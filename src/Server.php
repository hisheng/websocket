<?php
/**
 * Created by PhpStorm.
 * User: hisheng
 * Date: 2017/7/31
 * Time: 10:08
 */
namespace Websocket;

class Server
{
    public static $master_pid_file;
    public static $log_file;
    
    public $pid;
    
    public function __construct($master_pid_file)
    {
        self::$master_pid_file = $master_pid_file;
        self::$log_file = __DIR__.'/swoole.log';
        
        $this->pid = new Pid(self::$master_pid_file);
    }
    
    public function start()
    {
        if(! $this->pid->get())
        {
            $server = new  \swoole_websocket_server("0.0.0.0", 10703);
            $server->set(array(
                'log_file' => self::$log_file,
                'pid_file' =>self::$master_pid_file,
                'daemonize' => 1
            ));
            $server->on('open', function (\swoole_websocket_server $server, $request) {
                echo "server: handshake success with fd{$request->fd}\n";
                //$server->push($request->fd,json('open ok'));
            });
            
            $server->on('message', function (\swoole_websocket_server $server, $frame) {
                echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
                $apiParms = json_decode($frame->data,true);
                if($apiParms){
                    $router = new Router();
                    $router->urlParse($apiParms);
                }
            });
    
            $server->on('close', function ($ser, $fd) {
                echo "client {$fd} closed\n";
            });
    
            $server->start();
        }else{
            echo 'WARNING swSocket_bind: bind(0.0.0.0:7703) failed. Error: Address already in use [98]';
            echo "\n";
            echo 'Usage:php swoole.php start|stop';
            echo "\n";
        }
    }
    
    public function stop()
    {
        $this->pid->stop();
    }
    
    
    public function restart()
    {
    
    }
    
    
    public function help()
    {
    
    }
    


}
