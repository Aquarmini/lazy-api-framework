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

class Api extends Base
{
    //设置模块参数 全局变量 写在基类中
    protected static $arrKeyCode = [];
    protected $strRequestKeyCode = "";

    public function _initialize()
    {
        //默认返回json
        config('default_return_type', 'json');

        $strVersion = trim(input("vi"));

        if ($strVersion == "") {
            die(json_encode($this->toJson('-2', [], '版本号必填')));
        }
        //验证最低版本号
        if (!$this->checkVersion($strVersion)) {
            die(json_encode($this->toJson('-2', [], '版本号过低，请更换接口版本！')));
        }
        //加载验证码
        if (self::$arrKeyCode == null || count(self::$arrKeyCode) < 1) {
            $defind = APP_PATH . 'data/module_defined.php';
            if (!file_exists($defind)) {
                die(json_encode($this->toJson('-2', [], '缺失配置文件')));
            }
            $arrFunctionsDefined = require $defind;

            if (!array_key_exists($strVersion, $arrFunctionsDefined)) {
                die(json_encode($this->toJson('-2', [], '版本号不存在')));
            }
            self::$arrKeyCode = $arrFunctionsDefined[$strVersion];
        }

        //若无调用参数，则直接截断访问
        $strKeyCode = input('key');
        if ($strKeyCode == "" || !array_key_exists($strKeyCode, self::$arrKeyCode)) {
            die(json_encode($this->toJson('-2', [], '方法KEY不存在')));
        }

        $this->strRequestKeyCode = $strKeyCode;
    }

    private function checkVersion($ver)
    {
        $bver = config('api_version');
        $arr_ver = explode('.', $ver);
        $arr_bver = explode('.', $bver);
        foreach ($arr_ver as $i => $v) {
            if (empty($arr_bver[$i]) || $v > $arr_bver[$i]) {
                return true;
            } else if ($v < $arr_bver[$i]) {
                return false;
            }
        }
        return true;
    }

    public function toJson($status = 0, $data = [], $msg = '')
    {
        $json['status'] = $status;
        $json['data'] = $data;
        $json['timestamp'] = time();
        $json['msg'] = $msg;

        return $json;
    }

    public function succ($data = [], $msg = '')
    {
        return $this->toJson(1, $data, $msg);
    }

    public function fail($data = [], $msg = '')
    {
        return $this->toJson(0, $data, $msg);
    }

}