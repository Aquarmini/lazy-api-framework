<?php
namespace app\api\controller;

use app\common\controller\ApiAuth;

class Index extends ApiAuth
{
    public function index()
    {
        //获取操作码
        return call_user_func_array([$this, self::$arrKeyCode[$this->strRequestKeyCode]], []);
    }

    public function get1()
    {
        return $this->json_success(input(''));
    }

    public function get2()
    {
        return $this->json_success(input(''));
    }

}

