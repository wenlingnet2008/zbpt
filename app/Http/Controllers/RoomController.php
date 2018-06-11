<?php

namespace App\Http\Controllers;

use App\Room;
use App\User;
use GatewayClient\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Firewall\Vendor\Laravel\Facade as Firewall;

class RoomController extends Controller
{
    public function __construct()
    {
        Gateway::$registerAddress = '127.0.0.1:1236';
        $this->middleware('fw-block-blacklisted')->except('checkClientOnline');
    }

    public function index($id)
    {

        $room = Room::findOrFail($id);
        $data['room'] = $room;
        return view('room', $data);
    }


    //查看用户是否在登陆状态
    public function checkClientOnline()
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

        if(Auth::check()){
            $user = $request->user();
            $user_id = $user->id;
            $client_name = $user->name;
        }else{
            $user = json_decode($request->cookie('access_token'), true);
            if($user){
                $user_id = $user['user_id'];
                $client_name = $user['name'];
            }else{
                $user_id = uniqid();
                $client_name = '游客'.$user_id;
            }
        }

        $login_user = [
            'user_id' => $user_id,
            'name' => $client_name,
            'client_id' => $client_id,
        ];

        //发送给房间内的所有用户
        $new_message = array('type'=>'login', 'user_id'=>$user_id, 'name'=>$client_name, 'time'=>date('Y-m-d H:i:s'));
        Gateway::sendToGroup($room_id, json_encode($new_message));


        //用户加入房间
        $room->join($login_user);

        //获取房间列表
        $clients_list = $room->getUserList();

        //给当前用户发送用户列表
        $new_message['client_list'] = $clients_list;
        Gateway::sendToClient($client_id, json_encode($new_message));

        return response()->json(['message'=>'登陆成功'])->cookie('access_token', json_encode($login_user));
    }


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
            $to_user_id = $request->input('to_user_id');
            $content = $request->input('content');
            $content = nl2br(htmlspecialchars($content));

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
            'user_id' => ['required'],
            'room_id' => ['required', 'integer'],
        ]);
        $room_id = $request->input('room_id');
        $user_id = $request->input('user_id');
        $room = Room::findOrFail($room_id);
        $room->closeUser($user_id);
        Firewall::blacklist($request->getClientIp());
        return response()->json(['message'=>'操作成功']);
    }

}
