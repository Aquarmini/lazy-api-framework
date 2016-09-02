<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/8/30 Time: 23:07
// +----------------------------------------------------------------------
namespace app\api\controller\view;

use app\common\controller\Auth;

class AuthView extends Auth
{
    public function index()
    {
        return $this->fetch();
    }
}