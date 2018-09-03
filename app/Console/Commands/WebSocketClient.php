<?php

namespace App\Console\Commands;

use App\Online;
use App\Robot;
use App\WebSocket\RobotConnection;
use Carbon\Carbon;
use GatewayClient\Gateway;
use Illuminate\Console\Command;
use Workerman\Lib\Timer;
use Workerman\Worker;
use Workerman\Connection\AsyncTcpConnection;

class WebSocketClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workerman:client {action} {--daemonize}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'WebSocket Client Use Workerman';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $argv;
        $action=$this->argument('action');

        $argv[1]=$action;
        $argv[2]=$this->option('daemonize') ? '-d' : '';


        $worker = new Worker();
        $worker->count = 1;
        $worker->onWorkerStart = function($worker){
            Timer::add(10, function(){
                $robots = Robot::with(['rooms'])->get();
                foreach ($robots as $robot){
                    foreach($robot->rooms as $room){
                        $new_robot = $robot->toArray();
                        if($room->robot_open) {
                            $new_robot['room_id'] = $room->id;
                            $new_robot['user_id'] = $new_robot['user_id'] . '_' . $room->id;
                            if (!Gateway::isUidOnline($new_robot['user_id'])) {
                                if (Carbon::now()->gte(Carbon::parse()->setTimeFromTimeString($new_robot['up_time']))
                                    and Carbon::now()->lt(Carbon::parse()->setTimeFromTimeString($new_robot['end_time']))
                                ) {
                                    echo "机器人{$new_robot['user_name']}上线\n";
                                    $con = new RobotConnection($new_robot);
                                    $con->connect();
                                } else {
                                    echo "机器人{$new_robot['user_name']}没有到上线时间\n";
                                }
                            } else {
                                echo "机器人{$new_robot['user_name']}已经上线\n";
                            }

                        }else{
                            echo $robot->room->name."房间没有开启机器人\n";
                        }
                    }
                }
            });



        };

        //用于接收用户退出时，统计用户的在线时间
        $admin = new Worker();
        $admin->count = 1;
        $admin->onWorkerStart = function($admin){
            $con = new AsyncTcpConnection('ws://127.0.0.1:7272');
            $con->onMessage = function($connection, $data){
                $data = json_decode($data, true);
                if($data['type'] == 'init'){
                    $user_id = 'admin_1001';
                    $client_id = $data['client_id'];
                    Gateway::bindUid($client_id, $user_id);
                    Gateway::setSession($client_id, [
                        'client_name'  => 'admin',
                        'user_id' => $user_id,
                    ]);
                    //echo "绑定{$user_id}用户\n";
                }elseif($data['type'] == 'ping'){
                    $connection->send('{"type":"pong"}');
                }elseif($data['type'] == 'logout'){
                    $user_id = $data['user_id'];
                    if(!str_contains($user_id, 'robot_')) {

                        $online = Online::where('user_id', $user_id)->first();
                        if ($online) {
                            //不是当天的，则把 online_time = 0, 对于长时间在线超过1天的暂时不计入总的在线时间
                            if (!Carbon::now()->isSameDay(Carbon::parse($online->updated_at))) {
                                $online->online_time = 0;
                                $online->updated_at = Carbon::now();
                                $online->save();
                            } else {
                                //计算当天在线时间
                                $online_time = Carbon::now()->diffInSeconds(Carbon::parse($online->updated_at));
                                $online->online_time = $online->online_time + $online_time;
                                $online->total_time = $online->total_time + $online_time;
                                $online->save();
                            }
                        } else {
                            Online::create(['user_id' => $user_id, 'online_time' => 0, 'total_time' => 0]);
                        }
                    }
                }
            };
            $con->connect();
        };

        Worker::runAll();
    }

}
