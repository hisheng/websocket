<?php
/**
 * Created by PhpStorm.
 * User: hisheng
 * Date: 2017/7/31
 * Time: 10:00
 */


if(count($argv) > 1){
    $parm = $argv[1];
}else{
    $parm = 'start';
}

define('MASTER_PID_FILE',__DIR__.'/server.pid');

switch ($parm){
    case 'start':
        $status = checkServer();
        if($status){
            echo 'WARNING swSocket_bind: bind(0.0.0.0:7703) failed. Error: Address already in use [98]';
            echo "\n";
            echo 'Usage:php swoole.php start|stop|restart';
            echo "\n";
            return ;
        }
        freshRedis();
        break;
    case 'stop':
        stopServer();
        clearServerPid();
        return;
        //$server->shutdown();
        break;
    case 'restart':
        if(!stopServer()){
            return 'stop server error';
        }
        if(clearServerPid()){
            freshRedis();
        }else{
            echo 'error';
            return;
        }
        //$server->reload();
        break;
    case 'help':
        //stopServer();
        //$server->reload();
        echo 'Usage:php swoole.php start|stop|restart';
        return;
        break;
    default:
        freshRedis();
}

function getPid(){
    if(is_file(MASTER_PID_FILE)){
        return file_get_contents(MASTER_PID_FILE);
    }
    return false;
}

function stopServer(){
    $pid = getPid();
    if($pid){
        return posix_kill(intval($pid),15);
    }
    return false;
}

function clearServerPid(){
    if(checkServer()){
        return unlink(MASTER_PID_FILE);
    }
    return true;
}
function checkServer(){
    $pid = getPid();
    if($pid){
        return 1;
    }
    return 0;
}

