<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Msg: 测试类
// +----------------------------------------------------------------------
// | Date: 2016/8/30 Time: 22:38
// +----------------------------------------------------------------------
namespace app\api\controller;

use app\common\controller\Base;

class Test extends Base
{

    public function _initialize()
    {
        $this->view->engine->layout('test/layout');
    }

    public function index()
    {
        return $this->fetch();
    }

    public function code()
    {
        if (request()->instance()->isPost()) {
            $method = input('post.method');
            $code = substr(md5(time() . $method), 0, 6);
            dump($code);
        }
        return $this->fetch();
    }

    public function upCode()
    {
        $num = 6;
        $defind = APP_PATH . 'data/module_defined.php';
        if (!file_exists($defind)) {
            dump('缺少配置文件！');
            exit;
        }

        $code = include $defind;
        $method = $code[array_keys($code)[0]];
        $new = [];
        foreach ($method as $i => $v) {
            $key = substr(md5(time() . $v), 0, $num);
            while (in_array($key, $new)) {
                $num++;
                $key = substr(md5(time() . $v), 0, $num);
            }

            $new[$key] = $v;
        }

        dump('复制以下接口键值对到data/module_defined.php中');
        foreach ($new as $i => $v) {
            echo "\"$i\"=>\"$v\",<br/>";
        }

    }
}