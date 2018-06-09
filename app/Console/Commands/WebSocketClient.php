<?php

namespace App\Console\Commands;

use App\WebSocket\RobotConnection;
use Illuminate\Console\Command;
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

            $con = new AsyncTcpConnection('ws://192.168.10.10:7272');
            $con->onMessage = array(new RobotConnection(), 'message');
            $con->connect();


        };
        Worker::runAll();
    }

}
