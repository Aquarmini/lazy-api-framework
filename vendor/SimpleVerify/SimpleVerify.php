<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/5/26 Time: 21:08
// +----------------------------------------------------------------------
class SimpleVerify
{
    protected $verify=array();
    protected $config=array();
    protected $code='';
    protected $res='';
    protected $error='';

    public function __construct()
    {
        //启动session
        session_start();
        //配置配置文件
        $this->config['sec_time']=100;//失效时间默认100秒

    }

    public function verify(){
        $im = imagecreatetruecolor(410, 115);
        $BackColor = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
        imagefill($im, 0, 0, $BackColor);


        for ($i = 1; $i <= 20; $i++) {
            $YuanColor = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
            imageellipse($im, rand(rand(0, 100), 410), rand(rand(0, 100), 115), rand(rand(0, 150), 115), rand(rand(0, 200), 115), $YuanColor);
        }
        unset($i, $YuanColor);


        for ($y = 0; $y <= 115; $y += 3) {
            for ($x = 0; $x <= 410; $x += 3) {
                $YuanColor = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
                imagesetpixel($im, $x, $y, $YuanColor);
            }
        }
        unset($x, $y, $YuanColor);

        $YuanColor = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));

        imagefttext($im, 50, 0, 50, 80, $YuanColor, 'static/ttfs/2.ttf', $this->code);

        unset($YuanColor);
        $this->saveVerify();

        imagepng($im);
        imagedestroy($im);
    }

    /**
     * [saveVerify 保存验证码信息]
     * @author limx
     */
    public function saveVerify(){
        //配置初始化存储的数据

        $this->verify['time']=time();//当前时间戳
        $this->verify['res']=$this->res;//结果

        $_SESSION['verify']=$this->verify;
        unset($this->verify);
    }

    /**
     * [checkVerify 验证 验证码是否正确]
     * @author limx
     * @param string $code
     * @return bool
     */
    public function checkVerify($code=''){
        $verify=$_SESSION['verify'];
        if($verify['time']+$this->config['sec_time']>time()){
            //未超时 验证 验证码 忽略大小写不同
            if(strcasecmp($code,$verify['res']) == 0){
                return true;
            }
            $this->error='验证码错误！';
            return false;

        }
        $this->error='验证码已超时！';
        return false;
    }

    public function getError(){

        return $this->error;
    }
}