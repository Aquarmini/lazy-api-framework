<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/5/19 Time: 20:17
// +----------------------------------------------------------------------
require_once "BasicRedis.php";
class ReCache extends BasicRedis{

    public $expire=3600;

    public function __construct($host='127.0.0.1', $port='6379' , $pre='re_', $expire=3600)
    {
        parent::__construct($host, $port, $pre);
        if(isset($expire)){
            $this->expire=$expire;
        }
    }

    /**
     * [set_expire 设置超时时间]
     * @author limx
     * @param $expire
     */
    public function set_expire($expire){
        $this->expire=$expire;
    }

    /**
     * [is_cache 判断缓存是否存在]
     * @author limx
     * @param string $title
     */
    public function is_cache($title=""){
        if(is_array($title)){
            $title=$this->to_guid_string($title);
        }
        return $this->keys($title);
    }

    /**
     * 根据PHP各种类型变量生成唯一标识号
     * @param mixed $mix 变量
     * @return string
     */
    protected function to_guid_string($mix) {
        if (is_object($mix)) {
            return spl_object_hash($mix);
        } elseif (is_resource($mix)) {
            $mix = get_resource_type($mix) . strval($mix);
        } else {
            $mix = serialize($mix);
        }
        return md5($mix);
    }
}