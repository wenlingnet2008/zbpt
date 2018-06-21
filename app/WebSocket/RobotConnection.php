<?php
namespace App\WebSocket;
use App\RobotMessage;
use Carbon\Carbon;
use GatewayClient\Gateway;
use Workerman\Lib\Timer;
use Workerman\Connection\AsyncTcpConnection;

class RobotConnection
{

    private $robot;

    public function __construct($robot)
    {
        $this->robot = $robot;
    }

    public function connect()
    {

        $con = new AsyncTcpConnection('ws://192.168.10.10:7272');
        $con->onMessage = array($this, 'message');
        $con->connect();
    }

    public function message($connection, $data)
    {
        $time_interval = 10;
        $id = $this->robot['room_id'];
        $client_name = $this->robot['user_name'];
        $user_id = $this->robot['user_id'];

        $data = json_decode($data, true);
        if($data['type'] == 'init'){
            $client_id = $data['client_id'];
            $new_message = array('type'=>'login', 'user_id'=>$user_id, 'name'=>htmlspecialchars($client_name), 'time'=>date('Y-m-d H:i:s'));
            Gateway::sendToGroup($id, json_encode($new_message));

            Gateway::bindUid($client_id, $user_id);
            Gateway::setSession($client_id, [
                'client_name'  => $client_name,
                'user_id' => $user_id,
                'room_id' => $id,
            ]);
            Gateway::joinGroup($client_id, $id);


            $_SESSION[$this->robot['user_id']] = Timer::add($time_interval, function() use($id, $client_id, $client_name)
            {
                $this->say($id, $client_id, $client_name, $this->getMessage());
            });
            echo "添加{$_SESSION[$this->robot['user_id']]}定时发言\n";

        }elseif($data['type'] == 'ping'){
            $connection->send('{"type":"pong"}');
            if(Carbon::now()->gte(Carbon::parse()->setTimeFromTimeString($this->robot['end_time']))){
                echo "机器人{$this->robot['user_name']}下线\n";
                $connection->close();
                echo "删除{$_SESSION[$this->robot['user_id']]}定时发言\n";
                Timer::del($_SESSION[$this->robot['user_id']]);
            }

//            if(!Gateway::isUidOnline($user_id)){
//                if(Carbon::now()->gte(Carbon::parse()->setTimeFromTimeString($this->robot['up_time']))
//                    and Carbon::now()->lt(Carbon::parse()->setTimeFromTimeString($this->robot['end_time']))
//                ){
//                    echo "机器人{$this->robot['user_name']}上线\n";
//                    $this->connect();
//                }
//            }

        }
    }

    public function getMessage()
    {
        $message = RobotMessage::inRandomOrder()->first();
        return $message->content;
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