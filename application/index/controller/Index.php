<?php
namespace app\index\controller;
use app\common\controller\NoAuth;

class Index extends NoAuth
{
    public function index()
    {
        return $this->fetch();
    }

}

