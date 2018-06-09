<?php
namespace App\WebSocket;
use GatewayClient\Gateway;
use Workerman\Lib\Timer;

class RobotConnection
{

    public function message($connection, $data)
    {

        $data = json_decode($data, true);
        if($data['type'] == 'init'){
            $id = 1; //房间号
            $client_id = $data['client_id'];
            if(session('client_name')){
                $client_name = session('client_name');
            }else{
                $client_name = '游客'.uniqid();
                session(['client_name' => $client_name]);
            }

            Gateway::setSession($client_id, [
                'client_name'  => $client_name,
                'room_id' => $id,
            ]);

            $new_message = array('type'=>'login', 'client_id'=>$client_id, 'client_name'=>htmlspecialchars($client_name), 'time'=>date('Y-m-d H:i:s'));
            Gateway::sendToGroup($id, json_encode($new_message));
            Gateway::joinGroup($client_id, $id);
            Gateway::sendToClient($client_id, json_encode($new_message));

            $time_interval = 10;
            Timer::add($time_interval, function() use($id, $client_id, $client_name)
            {
                $this->say($id, $client_id, $client_name, 'hello world');
            });
        }elseif($data['type'] == 'ping'){
            $connection->send('{"type":"pong"}');
        }
    }

    public function say($room_id, $client_id, $client_name, $content){
        $new_message = array(
            'type'=>'say',
            'from_client_id'=>$client_id,
            'from_client_name' =>$client_name,
            'to_client_id'=>'all',
            'content'=>nl2br(htmlspecialchars($content)),
            'time'=>date('Y-m-d H:i:s'),
        );

        Gateway::sendToGroup($room_id ,json_encode($new_message));
    }
}