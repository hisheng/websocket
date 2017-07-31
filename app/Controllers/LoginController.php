<?php
/**
 * Created by PhpStorm.
 * User: hisheng
 * Date: 2017/7/31
 * Time: 14:50
 */
namespace App\Controller;

class LoginController
{
    public function indexAction($parms)
    {
        var_dump("LoginController indexAction");
        var_dump($parms);
    }
}