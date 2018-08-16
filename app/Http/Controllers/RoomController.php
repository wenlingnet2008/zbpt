<?php

namespace App\Http\Controllers;

use App\LiveList;
use App\Message;
use App\Online;
use App\Robot;
use App\Room;
use App\User;
use Carbon\Carbon;
use GatewayClient\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Jenssegers\Agent\Facades\Agent;
use Mews\Purifier\Facades\Purifier;
use PragmaRX\Firewall\Vendor\Laravel\Facade as Firewall;
use Spatie\Permission\Models\Role;
use App\Order;

class RoomController extends Controller
{
    public function __construct()
    {
        Gateway::$registerAddress = '127.0.0.1:1236';
        $this->middleware('fw-block-blacklisted')->except('checkClientOnline');
        $this->middleware('auth')->only(['mute', 'kick', 'unmute']);
        $this->middleware('permission:kick|mute|unmute')->only(['mute', 'kick', 'unmute']);
        $this->middleware('permission:front_view_user')->only(['user']);
        $this->middleware('permission:front_robot_say')->only(['robots', 'robotSay']);
        if (\request()->filled('room_id')) {
            $room = Room::findOrFail(\request()->input('room_id'));
            $say_limit = $room->say_limit;
        } else {
            $say_limit = 60;
        }
        $this->middleware('throttle:' . $say_limit)->only(['say']); //设定每分钟发言的次数 1分钟60次
    }

    public function index(Request $request, $id)
    {

        $room = Room::find($id);
        if(!$room){
            return redirect('/');
        }
        $data['room'] = $room;
        if (!$room->hasRole('游客')) {
            $this->authorize('view', $room);
        }



        if (!$room->open) {
            return view('admin.error_notice')->with(['status' => '房间关闭']);
        }

        $live = LiveList::where([
            ['room_id', $id],
            ['start_time', '<=', date('Y-m-d H:i:s')],
            ['end_time', '>', date('Y-m-d H:i:s')],
        ])->first();


        if(!$live){
            return view('admin.error_notice')->with(['status' => '直播尚未开始或者已经结束']);
        }
        $data['live'] = $live;

        //访问密码验证
        if ($request->filled('access_password')) {
            $access_password = $request->input('access_password');
            if ($room->access_password == $access_password) {
                session(['access_password' => $access_password]);
                return redirect()->route('room.index', ['id' => $id]);
            } else {
                return view('admin.error_notice')->with(['status' => '访问密码错误']);
            }
        }

        //需要访问密码
        if ($room->access_password) {
            if (!session('access_password')) {
                return redirect()->route('room.access', ['id' => $id]);
            }
        }


        if (Auth::check()) {
            $user = $request->user();
            $user_id = $user->id;
            $client_name = $user->nick_name ? $user->nick_name : $user->name;
            if (!$user->isAdmin() and $room->user_id != $user->id and $room->owner_id != $user->id and $user->room_id != $room->id) {
                //return view('admin.error_notice')->with(['permission' => '不是该房间的用户，无法访问 ']);
            }
        } else {
            //游客
            $user = new User();

            $cookie_user = json_decode($request->cookie('access_token'), true);
            if ($cookie_user) {
                $user_id = $cookie_user['user_id'];
                $client_name = $cookie_user['name'];
            } else {
                $user_id = uniqid('guest_');;
                $client_name = '游客' . $user_id;
            }

//            $user_id = uniqid('guest_');;
//            $client_name = '游客'.$user_id;
        }


        $login_user = [
            'user_id' => $user_id,
            'name' => $client_name,
        ];

        //加入统计在线时间表
        $online = Online::where('user_id', $user_id)->first();
        if ($online) {
            //不是当天的，则把 online_time = 0
            if (!Carbon::now()->isSameDay(Carbon::parse($online->updated_at))) {
                $online->online_time = 0;
                $online->updated_at = Carbon::now();
                $online->save();
            }
            //在线时间超时
            //  * 需要前端js做个在线时间统计，如停留时间超过，也一样跳转
            //  这样做就无须一直请求后端来检测是否超时

            if ($room->time_limit) {
                if ($online->online_time > $room->time_limit) {
                    //游客一定在限时范围中，可做修改
                    if ($user->roles->isEmpty() or $user->hasAnyRole($room->limit_groups)) {
                        return redirect()->route('notice.onlinetime');
                    }
                }
            }

        } else {
            Online::create(['user_id' => $user_id, 'online_time' => 0, 'total_time' => 0]);
        }


        $messages = Message::where([
            ['room_id', $id],
            ['is_private', 0],
            ['created_at', '>', Carbon::now()->format('Y-m-d')],
        ])->orderBy('id', 'desc')->limit(50)->get()->reverse();
        $data['messages'] = [];

        if(Agent::isMobile()){
            return response()->view('m_room', $data)->cookie('access_token', json_encode($login_user), 60 * 6);

        }
        return response()->view('room', $data)->cookie('access_token', json_encode($login_user), 60 * 6);
    }

    //获取当天的聊天消息
    public function getTodayMessage($id)
    {
        $messages = Message::with(['user:id,name', 'user.roles:id,name'])->where([
            ['room_id', $id],
            ['is_private', 0],
            ['created_at', '>', Carbon::now()->format('Y-m-d')],
        ])->orderBy('id', 'desc')->limit(50)->get();

        return response()->json(array_values($messages->reverse()->toArray()));
    }

    public function access($id)
    {
        return view('room_access', ['id' => $id]);
    }



    private function getLoginUser(Request $request)
    {
        if (Auth::check()) {
            $user = $request->user();
            $user_id = $user->id;
            $client_name = $user->nick_name ? $user->nick_name : $user->name;

        } else {

            $cookie_user = json_decode($request->cookie('access_token'), true);
            if ($cookie_user) {
                $user_id = $cookie_user['user_id'];
                $client_name = $cookie_user['name'];
            } else {
                $user_id = uniqid('guest_');;
                $client_name = '游客' . $user_id;
            }

        }

        $login_user = [
            'user_id' => $user_id,
            'name' => $client_name,
        ];


        return $login_user;

    }

    //查看用户是否在登陆状态
    public function checkClientOnline(Request $request)
    {
        if (Firewall::isBlacklisted(\request()->ip())) {
            return response()->json(['online' => 2]);
        }
        $login_user = json_decode(\request()->cookie('access_token'), true);
        if ($login_user) {
            $user_id = $login_user['user_id'];
            try {
                if (!Room::userIsOnline($user_id)) {
                    return response()->json(['online' => false]);
                } else {
                    return response()->json(['online' => true]);
                }
            } catch (\Exception $e) {
                return response()->json(['online' => false]);
            }
        }
        return response()->json(['online' => false]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'client_id' => ['required'],
            'room_id' => ['required', 'integer'],
        ]);
        $client_id = $request->input('client_id');
        $room_id = $request->input('room_id');
        $room = Room::findOrFail($room_id);

        $login_user = $this->getLoginUser($request);
        $login_user['client_id'] = $client_id;

        $user_id = $login_user['user_id'];
        $client_name = $login_user['name'];

        $user = User::find($user_id);
        if($user){
            $roles = $user->roles()->select('id', 'name')->get();
        }else{
            $roles = [
                ['id' => 5, 'name' => '游客'],
            ];
        }


        //发送给房间内的所有用户
        $new_message = array('type' => 'login', 'user_id' => $user_id, 'name' => e($client_name), 'roles' => $roles,'time' => date('Y-m-d H:i:s'));
        Gateway::sendToGroup($room_id, json_encode($new_message));


        //用户加入房间
        $room->join($login_user);

        //获取房间列表
        $clients_list = $room->getUserList();

        //给当前用户发送用户列表
        $new_message['client_list'] = $clients_list;
        Gateway::sendToClient($client_id, json_encode($new_message));


        return response()->json(['message' => '登陆成功'])->cookie('access_token', json_encode($login_user), 60 * 6);
    }

    //发言
    public function say(Request $request, $type = 'public')
    {
        $this->validate($request, [
            'to_user_id' => ['required'],
            'room_id' => ['required', 'integer'],
            'content' => ['required'],
        ], [
            'to_user_id.required' => '聊天用户不能为空',
            'room_id.required' => '房间不能为空',
            'content.required' => '发言内容不能为空',
        ]);


        $room = Room::findOrFail($request->input('room_id'));
        $login_user = json_decode(\request()->cookie('access_token'), true);
        $user = User::find($login_user['user_id']);

        if ($user) {
            if ($user->isMute()) {
                return response()->json(['message' => '你已经被禁止发言'], 400);
            }

            $to_user_id = $request->input('to_user_id');
            $to_user = User::find($to_user_id);
            $content = $request->input('content');
            $content = Purifier::clean($content);
            $content = nl2br(e($content));


            if ($to_user_id == $user->id) {
                return response()->json(['message' => '自己不能更自己聊天'], 400);
            }
            if ($type == 'public') {
                if ($to_user_id == 'all') {
                    $room->sayAll($user, $content);
                } else {
                    if (!$to_user) {
                        return response()->json(['message' => '不能和游客聊天'], 400);
                    }

                    $room->sayToUser($user, $to_user, $content);
                }
            } else {
                if (!$to_user) {
                    return response()->json(['message' => '用户不在线!!'], 400);
                }
                if(Room::userIsOnline($to_user_id)){
                    $room->sayPrivate($user, $to_user, $content);
                }else{
                    return response()->json(['message' => '用户不在线'], 400);
                }


            }

            return response()->json(['message' => '发言成功']);
        } else {
            return response()->json(['message' => '请先登录后才能发言'], 401);
        }
    }

    //私聊
    public function sayPrivate(Request $request)
    {
        return $this->say($request, 'private');

    }

    //用户是否已经登录
    public function isLogin()
    {
        $login_user = json_decode(\request()->cookie('access_token'), true);
        if (Auth::check() or $login_user) {
            $user = \request()->user();

            if(!$user){
                $user = User::with(['roles'=>function($query){
                    $query->select('id', 'name');
                }])->find($login_user['user_id']);
            }else{
                $user->roles = $user->roles()->select('id', 'name')->get();
            }

            if($user){
                $online = Online::where('user_id', $user->id)->first();
                $user->online_total_time = $online ? $online->total_time : 0 ;

            }


            return $user
                    ? response()->json(['message'=>'已经登录', 'is_login' => true , 'data' => $user])
                    : response()->json(['message'=>'没有登录', 'is_login' => false]);
        }

        return response()->json(['message'=>'没有登录', 'is_login' => false]);
    }


    //私聊用户列表
    public function privateUserList(Request $request)
    {
        $this->validate($request, [
            'room_id' => ['required', 'integer'],
        ]);

        $login_user = json_decode($request->cookie('access_token'), true);

        $user = User::findOrFail($login_user['user_id']);

        $room_id = $request->room_id;

        $user_ids = Message::where('user_id', $user->id)->where('is_private', 1)->groupBy('to_user_id')->pluck('to_user_id');
        $to_user_ids = Message::where('to_user_id', $user->id)->where('is_private', 1)->groupBy('user_id')->pluck('user_id');

        $private_user_ids = array_unique($user_ids->merge($to_user_ids)->toArray());


        $users = User::select('id', 'name')->whereIn('id', $private_user_ids)->get();


        return response()->json($users);

    }


    //获取私聊的聊天列表
    public function privateSayList(Request $request)
    {
        $this->validate($request, [
            'to_user_id' => ['required'],
        ]);

        $login_user = json_decode($request->cookie('access_token'), true);

        $user = User::findOrFail($login_user['user_id']);

        $messages = Message::where([
            ['user_id', $user->id],
            ['to_user_id', $request->to_user_id],
            ['is_private', 1],

        ])->orWhere(function ($query) use($user){
            $query->where([
                ['user_id', \request()->to_user_id],
                ['to_user_id', $user->id],
                ['is_private', 1],
            ]);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);

    }





    //显示右键操作权限菜单
    public function getDoPermissionMenu(Request $request)
    {
        $this->validate($request, [
            'to_user_id' => ['required'],
        ]);
        $login_user = json_decode($request->cookie('access_token'), true);

        $user = User::find($login_user['user_id']);


        if($user){
            $permission = [];
            if(
                $user->id != $request->to_user_id
                and !str_contains($request->to_user_id, 'guest_')
                and !str_contains($request->to_user_id, 'robot_')
            ){
                $permission = ['say_private' => '私聊'];
            }

            if($user->can('front_view_user') and !str_contains($request->to_user_id, 'guest_')){
                $permission['view_user'] = '查看用户资料';
            }
            if($user->can('kick')){
                $permission['manage_user'] = '踢人｜禁言功能';
            }

            return response()->json(['message'=>'获取操作权限成功', 'permission'=>$permission]);
        }

        return response()->json(['message'=>'没有权限操作'], 400);
    }


    public function teacher($id)
    {
        $room = Room::findOrFail($id);

        $teacher = $room->teacher->only(['id', 'name', 'image', 'introduce']);
        if($teacher['image']){
            //$teacher['image'] = Storage::disk('uploads')->url($teacher['image']);
        }

        $teacher['order_num'] = Order::where([
            ['room_id', $id],
            ['user_id', $teacher['id']],
        ])->count();

        $teacher['avg_profit'] = number_format(Order::where([
            ['room_id', $id],
            ['user_id', $teacher['id']],
        ])->avg('profit_loss'), 2);

        $profit_num = Order::where([
            ['room_id', $id],
            ['user_id', $teacher['id']],
            ['profit_loss', '>', 0],
        ])->count();


        $teacher['success_rate'] =  $profit_num ?  number_format(($profit_num / $teacher['order_num'] * 100), 2) : 0;


        return response()->json($teacher);
    }


    public function user($user_id)
    {
        $user = User::with(['roles'=>function($query){
            $query->select('id', 'name');
        }])->findOrFail($user_id);

        $online = Online::where('user_id', $user_id)->first();
        $user->online_total_time = $online ? $online->total_time : 0;
        if($user->image){
            //$user->image = Storage::disk('uploads')->url($user->image);
        }


        return collect($user)->except(['is_admin']);
    }

    public function orders(Request $request, $id)
    {
        $this->validate($request, [
            'type' => ['required', Rule::in(['now', 'history'])]
        ],[
            'type.in' => 'type的值必须是now或者history'
        ]);

        $room = Room::findOrFail($id);
        $teacher = $room->teacher;

        $login_user = json_decode(\request()->cookie('access_token'), true);
        $user = User::find($login_user['user_id']);


        $orders = Order::with(['order_type', 'user'=>function($query){
            $query->select('name', 'id');
        }])
            ->when($user ? !$user->isAdmin() : true, function ($query) use($user){
                $query->whereHas('roles', function ($query) use($user){
                    $query->where('id', $user ? $user->roles->first()->id : 5);
                });
            })
            ->when($request->type == 'history', function ($query){
                $query->whereDate('created_at', '<', date('Y-m-d'));
            }, function ($query){
                $query->whereDate('created_at', date('Y-m-d'));
            })

            ->where('room_id', $room->id)
            ->paginate(20);

        $orders->appends(['type'=>$request->type]);

        return response()->json($orders);

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


    // 搜索房间内用户
    public function searchOnlineUser(Request $request)
    {
        $this->validate($request, [
            'room_id' => ['required'],
            'name'  => ['required'],
        ]);

        $name = $request->name;

        $room = Room::findOrFail($request->room_id);

        $user_lists = $room->getUserList();

        $like_users = collect($user_lists)->filter(function ($value) use($name){
                return str_contains($value, $name);
        });

        return response()->json($like_users);
    }

    //获取房间内的客服
    public function customerService($id)
    {
        $room = Room::findOrFail($id);

        $users = User::whereHas('roles', function ($query){
            $query->where('id', 8);
        })->where('room_id', $room->id)->get();

        $c_services = $users->map(function ($user){
            if(Room::userIsOnline($user->id)){
                $user->is_online = true;
            }else{
                $user->is_online = false;
            }
            return $user;
        });


        return response()->json($c_services);
    }


    public function robots($id)
    {
        $robots = Robot::where('room_id', $id)->get();

        return response()->json($robots);
    }


    public function robotSay(Request $request)
    {
        $this->validate($request, [
            'user_id' => ['required'],
            'room_id' => ['required', 'integer'],
            'content' => ['required'],
        ], [
            'user_id.required' => '用户不能为空',
            'room_id.required' => '房间不能为空',
            'content.required' => '发言内容不能为空',
        ]);

        $robot = Robot::where([
            ['room_id', $request->room_id],
            ['user_id', $request->user_id],
        ])->firstOrFail();

        $content = Purifier::clean($request->input('content'));
        $content = nl2br(htmlspecialchars($content));
        $message = [
            'type'=>'say',
            'from_client_id'=>$robot->user_id,
            'from_client_name' => e($robot->user_name),
            'to_client_id'=>'all',
            'content'=>$content,
            'roles' => Role::select('id', 'name')->where('id', 2)->get(),
            'time'=>date('Y-m-d H:i:s'),
        ];

        Gateway::sendToGroup($request->room_id ,json_encode($message));

        return response()->json(['message' => '发言成功']);

    }


    public function onLiveRoom()
    {
        $livelists = LiveList::with(['room'])
                ->where([
                    ['start_time', '<=', date('Y-m-d H:i:s')],
                    ['end_time', '>', date('Y-m-d H:i:s')],
                ])
                ->orderBy('start_time', 'asc')->get();

        $livelists->transform(function ($item, $key){
            $item->teacher = $item->room ? $item->room->teacher->name : '';
            $item->image = Storage::disk('uploads')->url($item->image);
            $item->url = route('room.index', ['id'=>$item->id]);
            return $item->only(['id','teacher', 'url', 'image', 'start_time', 'end_time']);
        });


        return response()->json($livelists);
    }

}
