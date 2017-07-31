<?php
/**
 * Created by PhpStorm.
 * User: hisheng
 * Date: 2017/7/31
 * Time: 10:00
 */
require './../vendor/autoload.php';

if(count($argv) > 1){
    $parm = $argv[1];
}else{
    $parm = 'start';
}

define('MASTER_PID_FILE',__DIR__.'/server.pid');
$swooleServer = new \Websocket\Server(MASTER_PID_FILE);

switch ($parm){
    case 'start':
        $swooleServer->start();
        break;
    case 'stop':
       $swooleServer->stop();
        return;
        break;
    case 'help':
        //stopServer();
        //$server->reload();
        echo 'Usage:php swoole.php start|stop|restart';
        return;
        break;
    default:
    
}


