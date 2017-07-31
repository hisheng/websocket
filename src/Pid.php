<?php
/**
 * Created by PhpStorm.
 * User: hisheng
 * Date: 2017/7/31
 * Time: 10:12
 * swoole 的 pid 进程号
 */
namespace Websocket;

class Pid
{
    public static $master_pid_file;
    
    public function __construct($master_pid_file)
    {
        self::$master_pid_file = $master_pid_file;
    }
    public function get()
    {
        if(is_file(self::$master_pid_file)){
            return file_get_contents(self::$master_pid_file);
        }
        return false;
    }
    
    /**
     * @return bool 先删除 进程，然后删除进程号存储的文件
     */
    public function stop()
    {
        $pid = $this->get();
        if($pid){
            $killStatus =  posix_kill(intval($pid),15);
            if($killStatus)
            {
                return unlink(self::$master_pid_file);
            }
        }
        return false;
    }
}