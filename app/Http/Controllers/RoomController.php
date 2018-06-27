<?php

namespace App\Http\Controllers;

use App\Message;
use App\Online;
use App\Room;
use App\User;
use Carbon\Carbon;
use GatewayClient\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Firewall\Vendor\Laravel\Facade as Firewall;
use Spatie\Permission\Models\Role;

class RoomController extends Controller
{
    public function __construct()
    {
        Gateway::$registerAddress = '127.0.0.1:1236';
        $this->middleware('fw-block-blacklisted')->except('checkClientOnline');
        $this->middleware('auth')->only(['mute', 'kick', 'unmute']);
        $this->middleware('permission:kick|mute|unmute')->only(['mute', 'kick', 'unmute']);
        if(\request()->filled('room_id')){
            $room = Room::findOrFail(\request()->input('room_id'));
            $say_limit = $room->say_limit;
        }else{
            $say_limit = 60;
        }
        $this->middleware('throttle:'.$say_limit)->only(['say']); //设定每分钟发言的次数 1分钟60次
    }

    public function index(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $data['room'] = $room;

        if(!$room->hasRole('游客')){
            $this->authorize('view', $room);
        }

        if(!$room->open){
            return response('房间关闭');
        }

        //访问密码验证
        if($request->filled('access_password')){
            $access_password = $request->input('access_password');
            if($room->access_password == $access_password){
                session(['access_password'=>$access_password]);
                return redirect()->route('room.index', ['id'=>$id]);
            }else{
                return view('admin.error_notice')->with(['status'=>'访问密码错误']);
            }
        }

         //需要访问密码
        if($room->access_password){
            if(!session('access_password')){
                return redirect()->route('room.access', ['id'=>$id]);
            }
        }


        if(Auth::check()){
            $user = $request->user();
            $user_id = $user->id;
            $client_name = $user->name;
            if(!$user->isAdmin() and $room->user_id != $user->id and $room->owner_id != $user->id and $user->room_id != $room->id){
                return view('admin.error_notice')->with(['permission'=>'不是该房间的用户，无法访问 ']);
            }
        }else{
            //游客
            $user = new User();

//            $cookie_user = json_decode($request->cookie('access_token'), true);
//            if($cookie_user){
//                $user_id = $cookie_user['user_id'];
//                $client_name = $cookie_user['name'];
//            }else{
//                $user_id = uniqid('guest_');;
//                $client_name = '游客'.$user_id;
//            }

            $user_id = uniqid('guest_');;
            $client_name = '游客'.$user_id;
        }


        $login_user = [
            'user_id' => $user_id,
            'name' => $client_name,
        ];

        //加入统计在线时间表
        $online = Online::where('user_id', $user_id)->first();
        if($online){
            //不是当天的，则把 online_time = 0
            if(!Carbon::now()->isSameDay(Carbon::parse($online->updated_at))){
                $online->online_time = 0;
                $online->updated_at = Carbon::now();
                $online->save();
            }
            //在线时间超时
            //  * 需要前端js做个在线时间统计，如停留时间超过，也一样跳转
            //  这样做就无须一直请求后端来检测是否超时

            if($room->time_limit){
                if($online->online_time > $room->time_limit){
                    //游客一定在限时范围中，可做修改
                    if($user->roles->isEmpty() or $user->hasAnyRole($room->limit_groups)){
                        return redirect()->route('notice.onlinetime');
                    }
                }
            }

        }else{
            Online::create(['user_id'=>$user_id, 'online_time'=>0, 'total_time'=>0]);
        }


        $messages = Message::where([
            ['room_id', $id],
            ['to_user_id', 0],
            ['created_at', '>' , Carbon::now()->format('Y-m-d')],
        ])->orderBy('id', 'desc')->limit(50)->get()->reverse();
        $data['messages'] = $messages;

        return response()->view('room', $data)->cookie('access_token', json_encode($login_user), 60*6);
    }

    public function access($id)
    {
        return view('room_access',['id'=>$id]);
    }


    //查看用户是否在登陆状态
    public function checkClientOnline(Request $request)
    {
        if(Firewall::isBlacklisted(\request()->ip())){
            return response()->json(['online'=>2]);
        }
        $login_user = json_decode(\request()->cookie('access_token'), true);
        if($login_user){
            $user_id = $login_user['user_id'];
            try{
                if(!Room::userIsOnline($user_id)){
                    return response()->json(['online'=>false]);
                }else{
                    return response()->json(['online'=>true]);
                }
            }catch (\Exception $e){
                return response()->json(['online'=>false]);
            }
        }
        return response()->json(['online'=>false]);
    }

    public function login(Request $request){
        $this->validate($request, [
            'client_id' => ['required'],
            'room_id' => ['required', 'integer'],
        ]);
        $client_id = $request->input('client_id');
        $room_id = $request->input('room_id');
        $room = Room::findOrFail($room_id);


        $user = json_decode($request->cookie('access_token'), true);
        $user_id = $user['user_id'];
        $client_name = $user['name'];


        $login_user = [
            'user_id' => $user_id,
            'name' => $client_name,
            'client_id' => $client_id,
        ];

        //发送给房间内的所有用户
        $new_message = array('type'=>'login', 'user_id'=>$user_id, 'name'=>e($client_name), 'time'=>date('Y-m-d H:i:s'));
        Gateway::sendToGroup($room_id, json_encode($new_message));


        //用户加入房间
        $room->join($login_user);

        //获取房间列表
        $clients_list = $room->getUserList();

        //给当前用户发送用户列表
        $new_message['client_list'] = $clients_list;
        Gateway::sendToClient($client_id, json_encode($new_message));


        return response()->json(['message'=>'登陆成功']);
    }

    //发言
    public function say(Request $request)
    {
        $this->validate($request, [
            'to_user_id' => ['required'],
            'room_id' => ['required', 'integer'],
            'content' => ['required'],
        ]);


        $room = Room::findOrFail($request->input('room_id'));
        $login_user = json_decode(\request()->cookie('access_token'), true);
        $user = User::find($login_user['user_id']);

        if($user){
            if($user->isMute()){
                return response()->json(['message'=>'你已经被禁止发言']);
            }

            $to_user_id = $request->input('to_user_id');
            $content = $request->input('content');
            $content = nl2br(e($content));

            if($to_user_id == $user->id){
                return response()->json(['message'=>'自己不能更自己聊天']);
            }

            if($to_user_id == 'all'){
               $room->sayAll($user, $content);
            }else{
                $to_user = User::find($to_user_id);
                if(!$to_user){
                    return response()->json(['message'=>'不能和游客聊天']);
                }
                $room->sayPrivate($user, $to_user, $content);
            }


        }else{
            return response()->json(['message'=>'请先登录后才能发言']);
        }
    }


    //踢出房间
    public function kick(Request $request)
    {
        $this->validate($request, [
            'user_id' => ['required', 'not_in:all'],
            'room_id' => ['required', 'integer'],
        ]);
        $room_id = $request->input('room_id');
        $user_id = $request->input('user_id');
        $room = Room::findOrFail($room_id);
        $room->closeUser($user_id);
        Firewall::blacklist($request->getClientIp());
        return response()->json(['message'=>'踢出房间操作成功']);
    }

    //禁止发言
    public function mute(Request $request)
    {
        $this->validate($request, [
            'user_id' => ['required', 'not_in:all'],
        ]);
        $user_id = $request->input('user_id');
        $user = User::findOrFail($user_id);
        $user->mute();

        return response()->json(['message'=>'禁言操作成功']);
    }

    public function unmute(Request $request)
    {
        $this->validate($request, [
            'user_id' => ['required', 'not_in:all'],
        ]);
        $user_id = $request->input('user_id');
        $user = User::findOrFail($user_id);
        $user->unmute();

        return response()->json(['message'=>'解除禁言操作成功']);
    }

}
