<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/5/19 Time: 20:18
// +----------------------------------------------------------------------
require_once "ReCache.php";
class StringCache extends ReCache{

    public function __construct($host='127.0.0.1', $port='6379' , $pre='re_', $expire=3600)
    {
        parent::__construct($host, $port, $pre, $expire);
    }


    /**
     * [set_cache 保存缓存]
     * @author limx
     * @param $condition string:缓存名 array:查询条件
     * @param array $value
     * @param $expire
     */
    public function set_cache($condition="",$value=array(),$expire=3600){
        if(!isset($expire)){
            $expire=$this->expire;
        }

        if(is_array($condition)){
            $name=$this->to_guid_string($condition);
        }
        else{
            $name=$condition;
        }

        $value = serialize($value);

        return $this->set($name,$value,$expire);

    }

    /**
     * [get_cache 读取缓存]
     * @author limx
     * @param string $condition
     */
    public function get_cache($condition=""){
        if(is_array($condition)){
            $name=$this->to_guid_string($condition);
        }
        else{
            $name=$condition;
        }

        return unserialize($this->get($name));
    }
}