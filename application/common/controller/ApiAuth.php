<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/7/8 Time: 16:04
// +----------------------------------------------------------------------
namespace app\common\controller;

use app\common\controller\Base;

class ApiAuth extends Base
{
    //设置模块参数 全局变量 写在基类中
    protected static $arrKeyCode = [];
    protected $strRequestKeyCode = "";

    public function _initialize()
    {
        //默认返回json
        config('default_return_type', 'json');
        //写在基类中的函数 S
        $strVersion = trim(input("vi"));

        if ($strVersion == "") {
            die(json_encode($this->json_error([], '版本号不存在！1')));
        }
        //加载验证码
        if (self::$arrKeyCode == null || count(self::$arrKeyCode) < 1) {
            $arrFunctionsDefined = @require '../application/data/module_defined.php';

            if (!array_key_exists($strVersion, $arrFunctionsDefined)) {
                die(json_encode($this->json_error([], '版本号不存在！2')));
            }
            self::$arrKeyCode = $arrFunctionsDefined[$strVersion];
        }

        //若无调用参数，则直接截断访问
        $strKeyCode = input('key');
        if ($strKeyCode == "" || !array_key_exists($strKeyCode, self::$arrKeyCode)) {
            die(json_encode($this->json_error([], '方法KEY不存在！3')));
        }

        $this->strRequestKeyCode = $strKeyCode;
        //写在基类中的函数 E
    }

    public function toJson($status = 0, $data = [], $msg = '')
    {
        $json['status'] = $status;
        $json['data'] = $data;
        $json['timestamp'] = time();
        $json['msg'] = $msg;

        return json_encode($json);
    }

    public function json_success($data = [], $msg = '')
    {
        return $this->toJson(1, $data, $msg);
    }

    public function json_error($data = [], $msg = '')
    {
        return $this->toJson(0, $data, $msg);
    }

}