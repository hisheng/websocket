<?php
/**
 * Created by PhpStorm.
 * User: hisheng
 * Date: 2017/7/31
 * Time: 14:36
 * 路由解析类，把 user/login 解析到  user类 login方法
 */
namespace Websocket;
use ReflectionClass;

class Router
{
    public static $apiUrl;
    public static $parms;
    
    public $controller;
    public $action;
    
    
    public function urlParse($api){
        //1
        self::$apiUrl = $api['api'];
        self::$parms = $api['parms'];
        
        $url = trim(self::$apiUrl,'/');
        
        $ca = explode('/',$url);
        
        
        if(count($ca) < 2){
            //当只有 类没有 函数的时候，或者连类都没有的时候
            if(empty($ca[0])){
                $this->controller = 'Welcome';
            }else{
                $this->controller = ucfirst($ca[0]);
            }
            $this->action = 'index';
        }else{
            //2
            $this->controller = ucfirst($ca[0]);
            //echo $this->controller.BR;
            $this->action = $ca[1];
            //echo $this->action.BR;
        }
        
        //4 执行类中的 某个方法
        
        $className =  '\\App\Controllers\\'.$this->controller.'Controller';
        
        //检查这个类是否存在
//        if (class_exists($className)) {
//            $re = new ReflectionClass($className);
//            $constructor = $re->getConstructor();
//            $parameters = $constructor->getParameters();
//            //$re->newInstanceArgs($parameters);
//            //var_dump($parameters);exit;
//            //$class = new $className;
//        }else{
//            header("HTTP/1.0 404 Not Found");
//            exit;
//        }
        
        //检查这个类的方法是否存在
        if(method_exists($className,$this->action.'Action')){
            //$class->{$this->action.'Action'}();
            $classReflection = new ReflectionClass($className);
            $class = $classReflection->newInstance();
            call_user_func_array(
            # 调用内部function
                array($class,$this->action.'Action'),
                # 传递参数
                [
                    'parms'=>self::$parms
                ]
            );
        }else{
            header("HTTP/1.0 404 Not Found");
            exit;
        }
        
        
        
        
        
        
        
        
    }
    
 
}
