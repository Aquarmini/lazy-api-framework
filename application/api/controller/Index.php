<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Msg: 无权限接口类
// +----------------------------------------------------------------------
// | Date: 2016/8/30 Time: 22:34
// +----------------------------------------------------------------------
namespace app\api\controller;

use app\common\controller\Api;

class Index extends Api
{
    public function index()
    {
        //获取操作码
        return call_user_func_array([$this, self::$arrKeyCode[$this->strRequestKeyCode]], []);
    }

    public function get1()
    {
        return $this->succ(input(''));
    }

    public function get2()
    {
        return $this->fail(input(''),'错误');
    }

}

