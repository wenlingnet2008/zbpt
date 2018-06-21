<?php

namespace App\Console\Commands;

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
                $robots = Robot::get();
               foreach ($robots as $robot){
                   if(!Gateway::isUidOnline($robot['user_id'])){
                       if(Carbon::now()->gte(Carbon::parse()->setTimeFromTimeString($robot['up_time']))
                           and Carbon::now()->lt(Carbon::parse()->setTimeFromTimeString($robot['end_time']))
                       ){
                           echo "机器人{$robot['user_name']}在线\n";
                           $con = new RobotConnection($robot);
                           $con->connect();
                       }else{
                           echo "机器人{$robot['user_name']}没有到上线时间\n";
                       }
                   }else{
                       echo "机器人{$robot['user_name']}已经上线\n";
                   }
               }
            });



        };
        Worker::runAll();
    }

}
