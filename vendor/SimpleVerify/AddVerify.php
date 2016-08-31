<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/5/26 Time: 21:17
// +----------------------------------------------------------------------
require_once 'SimpleVerify.php';

class AddVerify extends SimpleVerify
{
    private $left_num = 0;
    private $right_num = 0;

    public function __construct()
    {
        parent::__construct();
        $this->left_num = rand(0, 100);
        $this->right_num = rand(0, 100);

        $this->code = $this->left_num . "+" . $this->right_num . "=";
        $this->res = $this->left_num + $this->right_num;

    }

    public function verify(){
        parent::verify();
        unset($this->left_num,$this->right_num);
    }
}