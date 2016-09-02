<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/6/2 Time: 14:14
// +----------------------------------------------------------------------
namespace app\common\controller;
use think\Controller;

class Base extends Controller
{


    /**
     * [lfnAjaxReturn desc]
     * @author limx
     * @param string $strStatus
     * @param array $strMsg
     * @return array
     */
    protected function lfnAjaxReturn($strStatus = '', $strMsg = array())
    {
        $arrResult = array(
            "STATUS" => $strStatus,
            "MESSAGE" => $strMsg,
            "TIMESTAMP" => time()
        );
        return $arrResult;
    }

    /**
     * [lfnAjaxSuccess 返回正确数据]
     * @author limx
     * @param array $strMsg
     */
    protected function lfnAjaxSuccess($strMsg = array())
    {
        $arrResult = array(
            "STATUS" => "1",
            "MESSAGE" => $strMsg,
            "TIMESTAMP" => time()
        );

        echo json_encode($arrResult);
    }

    /**
     * [lfnAjaxFailed 返回错误信息]
     * @author limx
     * @param string $strMsg
     */
    protected function lfnAjaxFailed($strMsg = "")
    {
        $arrResult = array(
            "STATUS" => "0",
            "MESSAGE" => $strMsg,
            "TIMESTAMP" => time()
        );

        echo json_encode($arrResult);
    }

}