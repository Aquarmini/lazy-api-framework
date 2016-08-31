<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/5/15 Time: 0:05
// +----------------------------------------------------------------------
class BasicRedis
{
    protected $host = '127.0.0.1';
    protected $port = '6379';
    protected $handle;
    protected $pre = 're_';

    public function __construct($host='127.0.0.1', $port='6379' , $pre='re_')
    {
        if(isset($host)){
            $this->host = $host;
        }
        if(isset($port)){
            $this->port = $port;
        }
        if(isset($pre)){
            $this->pre = $pre;
        }

        $this->handle = new Redis();
        $ret = $this->handle->connect($this->host, $this->port);
        if ($ret === false) {
            die($this->handle->getLastError());
        }
    }

    /**
     * [setPre 设置前缀]
     * @author limx
     * @param $key
     */
    public function setPre($key)
    {
        $this->pre = $key;
    }

    /**
     * [appPre 追加前缀]
     * @author limx
     * @param $key
     */
    public function addPre($key){
        $this->pre .= $key;
    }

    public function keys($key){
        return $this->handle->keys($this->pre.$key);
    }

    //String操作相关 S

    /**
     * [set 字符串写]
     * @author limx
     * @param $key
     * @param $value
     * @param int $expire
     * @return mixed
     */
    public function set($key, $value, $expire = 0)
    {
        if ($expire == 0) {
            $ret = $this->handle->set($this->pre.$key, $value);
        } else {
            $ret = $this->handle->setex($this->pre.$key, $expire, $value);
        }
        return $ret;
    }

    /**
     * [get 字符串读]
     * @author limx
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $func = is_array($key) ? 'mGet' : 'get';
        return $this->handle->{$func}($this->pre.$key);
    }
    //String操作相关 E


    //SET操作相关 S

    /**
     * [sAdd 加入集合新的元素]
     * @author limx
     * @param $key
     * @param $value
     * @return int
     */
    public function sAdd($key, $value)
    {
        return $this->handle->sAdd($this->pre.$key, $value);
    }

    /**
     * [sRemove 从集合中删除某个元素]
     * @author limx
     * @param $key
     * @param $value
     */
    public function sRemove($key, $value){
        return $this->handle->sRemove($this->pre.$key, $value);
    }

    public function sToggle($key, $value){
        if($this->sContains($key, $value)){
            return $this->sRemove($key, $value);
        }
        else{
            return $this->sAdd($key, $value);
        }

    }

    /**
     * [sContains 集合中是否存在某值]
     * @author limx
     * @param $key
     * @param $value
     */
    public function sContains($key, $value){
        return $this->handle->sContains($this->pre.$key, $value);
    }

    /**
     * [sSize 返回集合中元素个数]
     * @author limx
     * @param $key
     */
    public function sSize($key){
        return $this->handle->sSize($this->pre.$key);
    }

    /**
     * [sMembers 返回集合key中所有的元素]
     * @author limx
     * @param $key
     * @return array
     */
    public function sMembers($key){
        return $this->handle->sMembers($this->pre.$key);
    }

    //SET操作相关 E


}