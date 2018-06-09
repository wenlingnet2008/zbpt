<?php

namespace App\Http\Controllers;

use App\Room;
use GatewayClient\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function __construct()
    {
        Gateway::$registerAddress = '127.0.0.1:1236';
    }

    public function index($id)
    {

        $room = Room::findOrFail($id);
        session(['room_id'=> $id]);
        $data['room'] = $room;
        return view('room', $data);
    }


    public function login(Request $request){
        $this->validate($request, [
            'client_id' => ['required'],
        ]);
        $client_id = $request->input('client_id');
        $room_id = session('room_id');
        session(['client_id' => $client_id]);

        if(Auth::check()){
            $user = $request->user();
            $client_name = $user->name;
            $get_client_ids = Gateway::getClientIdByUid($user->id);
            if($get_client_ids){
                $client_id = $get_client_ids[0];
                return response()->json(['message'=>'请勿开启多个客户端']);
            }else{
                //绑定user id到客户端id上
                Gateway::bindUid($client_id, $user->id);
            }
        }else{
            $client_name = '游客'.uniqid();
        }
        //用户加入房间
        Gateway::joinGroup($client_id, $room_id);

        Gateway::setSession($client_id, [
            'client_name'  => $client_name,
            'room_id' => $room_id,
        ]);

        //获取房间列表
        $clients_list = Gateway::getClientSessionsByGroup($room_id);
        foreach($clients_list as $tmp_client_id=>$item)
        {
            $clients_list[$tmp_client_id] = $item['client_name'];
        }
        //$clients_list[$client_id] = $client_name;

        //发送给房间内的所有用户
        $new_message = array('type'=>'login', 'client_id'=>$client_id, 'client_name'=>$client_name, 'time'=>date('Y-m-d H:i:s'));
        Gateway::sendToGroup($room_id, json_encode($new_message));

        //给当前用户发送用户列表
        $new_message['client_list'] = $clients_list;
        Gateway::sendToClient($client_id, json_encode($new_message));



    }


    public function say(Request $request)
    {
        $this->validate($request, [
            'to_client_id' => ['required'],
            'to_client_name' => ['required'],
            'content' => ['required'],
        ]);

        if(Auth::check()){
            $user = $request->user();
            $room_id = session('room_id');
            $to_client_id = $request->input('to_client_id');
            $to_client_name = $request->input('to_client_name');
            $content = $request->input('content');
            $content = nl2br(htmlspecialchars($content));

            $from_client_id = Gateway::getClientIdByUid($user->id)[0];
            $from_client_name = $user->name;

            if($to_client_id == $from_client_id){
                return response()->json(['message'=>'自己不能更自己聊天']);
            }

            $message = [
                'type'=>'say',
                'from_client_id'=>$from_client_id,
                'from_client_name' =>$from_client_name,
                'to_client_id'=>'all',
                'content'=>$content,
                'time'=>date('Y-m-d H:i:s'),
            ];
            if($to_client_id == 'all'){
                Gateway::sendToGroup($room_id ,json_encode($message));
            }else{
                $message['to_client_id'] = $to_client_id;
                $message['content'] = '<a href="javascript:;" style="color: inherit;">@me</a> '.$content;
                Gateway::sendToClient($to_client_id, json_encode($message));
                $message['content'] = '<a href="javascript:;" style="color: inherit;">@'.$to_client_name.'</a> '.$content;
                Gateway::sendToClient($from_client_id, json_encode($message));
            }

        }else{
            return response()->json(['message'=>'请先登录后才能发言']);
        }
    }

    public function flush(Request $request)
    {
        $room_id = session('room_id');
        //获取房间列表
        $clients_list = Gateway::getClientSessionsByGroup($room_id);
        foreach($clients_list as $tmp_client_id=>$item)
        {
            $clients_list[$tmp_client_id] = $item['client_name'];
        }

        $message = [
            'type' => 'flush',
            'client_list' => $clients_list,
        ];
        Gateway::sendToGroup($room_id, json_encode($message));
    }
}
