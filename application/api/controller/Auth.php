<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Msg: 带权限接口类
// +----------------------------------------------------------------------
// | Date: 2016/8/30 Time: 22:34
// +----------------------------------------------------------------------
namespace app\api\controller;

use app\common\controller\Api;

class Auth extends Api
{
    public function index()
    {
        //获取操作码
        return call_user_func_array([$this, self::$arrKeyCode[$this->strRequestKeyCode]], []);
    }

    public function dumpPost()
    {
        $data[] = input('post.');
        $file = request()->file('file');
        if ($file) {
            //验证图片格式
            if (\limx\func\Match::isImage($file->getInfo('name')) === false) {
                return $this->fail([], '图片格式不对！');
            }
            // 上传图片
            $root = 'uploads' . DS . 'demo';
            $file->move($root);
        }
        return $this->succ($data);
    }

}