<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/6/2 Time: 15:29
// +----------------------------------------------------------------------

/**
 * [fnArrayColumn 获取数组中的某一列]
 * @author limx
 * @param $input 数组
 * @param $columnKey string：key值 int：角标 Key
 * @param null $indexKey 返回数组的key值 NULL时默认为角标
 * php7 中似乎有array_column函数 功能一样
 * @return array
 */
function fnArrayColumn($input, $columnKey, $indexKey = NULL)
{
    $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
    $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
    $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
    $result = array();

    foreach ((array)$input AS $key => $row) {
        if ($columnKeyIsNumber) {
            $tmp = array_slice($row, $columnKey, 1);
            $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
        } else {
            $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
        }
        if (!$indexKeyIsNull) {
            if ($indexKeyIsNumber) {
                $key = array_slice($row, $indexKey, 1);
                $key = (is_array($key) && !empty($key)) ? current($key) : NULL;
                $key = is_null($key) ? 0 : $key;
            } else {
                $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
            }
        }
        $result[$key] = $tmp;
    }
    return $result;
}

/**
 * [fnShowHeaer 返回头信息]
 * @author limx
 * @param string $act
 * @return string|void
 */
function fnShowHeader($act = 'utf-8')
{
    switch ($act) {
        case 'utf-8':
            return header("Content-type: text/html; charset=utf-8");
        default:
            return '';
    }
}

/**
 * [fnCurlPostJson 发送json的post请求]
 * @author limx
 * @param $url 请求地址
 * @param $data 数据包array
 * @return mixed
 */
function fnCurlPostJson($url, $data)
{
    $data_string = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
    );

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;

}

/**
 * 加密解密字符串
 * 加密:encrypt('str','E','nowamagic')
 * 解密:encrypt('被加密过的字符串','D','nowamagic')
 * $string   :需要加密解密的字符串
 * $operation:判断是加密还是解密:E:加密   D:解密
 * $key      :加密的钥匙(密匙)
 */
function fnEncrypt($string, $operation, $key = '')
{
    $key = md5($key);
    $key_length = strlen($key);
    $string = $operation == 'D' ? base64_decode($string) : substr(md5($string . $key), 0, 8) . $string;
    $string_length = strlen($string);
    $rndkey = $box = array();
    $result = '';
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($key[$i % $key_length]);
        $box[$i] = $i;
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'D') {
        if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
            return substr($result, 8);
        } else {
            return '';
        }
    } else {
        return str_replace('=', '', base64_encode($result));
    }
}

/**
 * [fnGetIp 获取当前IP]
 * @author limx
 * @return string
 */
function fnGetIp()
{
    //global $ip;
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;

}

/**
 * [fnCheckPhone 验证是否是手机号]
 * @author limx
 * @param $phonenumber 手机号码
 * @return bool
 */
function fnCheckPhone($phonenumber)
{
    if (preg_match("/^1[34578]{1}\d{9}$/", $phonenumber)) {
        return true;
    }
    return false;
}

/**
 * [fnObjectArray stdClass Object 转 array]
 * @author limx
 * @param $array stdClass Objec
 * @return array
 */
function fnObjectToArray($array)
{
    if (is_object($array)) {
        $array = (array)$array;
    }
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $array[$key] = fnObjectToArray($value);
        }
    }
    return $array;
}

/**
 * [fnGetRandomString 获取随机字符串]
 * @author limx
 * @param $intLength 字符串长度
 * @param string $strType 类型
 * @return string
 */
function fnGetRandomString($intLength, $strType = 'C')
{
    $arrChars = array();
    if ($strType == "N") {//获取数字随机码
        $arrChars = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    } else if ($strType == "S") {//获取字母随机码
        $arrChars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    } else if ($strType == "C") {//获取数字+字母随机码
        $arrChars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    }
    $intCharsLen = count($arrChars) - 1;
    shuffle($arrChars);
    // 将数组打乱
    $strOutput = "";
    for ($i = 0; $i < $intLength; $i++) {
        $strOutput .= $arrChars[mt_rand(0, $intCharsLen)];
        //获得一个数组元素
    }
    return $strOutput;
}

/**
 * [fnGetUrl 获取当前Url]
 * @Author   Limx
 * @Method   直接调用
 * @DateTime 2016-02-24T15:07:32+0800
 * @return   [type]                   [description]
 */
function fnGetUrl()
{

    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;

}

/**
 * [fnGetNowTime 获取当前时间]
 * @Author   Limx
 * @Method   直接调用
 * @DateTime 2016-02-19T22:32:56+0800
 * @return   [type]                   [description]
 */
function fnGetNowTime()
{
    return Date("Y-m-d H:i:s");
}

/**
 * [ufnCheckInts 正则匹配id字符串]
 * @Author   Limx
 * @Method   直接调用
 * @DateTime 2015-12-04T10:50:43+0800
 * @param    string $strId [id,id,id]
 * @return   [type]                          [description]
 */
function fnCheckInts($ids = "")
{
    $reg = "/^([0-9]+,)*[0-9]+$/";
    if (preg_match($reg, $ids)) {
        return true;
    }
    return false;
}

/**
 * 通过CURL发送HTTP请求
 * @param string $url //请求URL
 * @param array $postFields //请求参数
 * @return mixed
 */
function fnCurlPost($url, $postFields, $headerData = array())
{

    $postFields = http_build_query($postFields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    if (!empty($headerData)) {
        $headerArr = array();
        foreach ($headerData as $i => $v) {
            $headerArr[] = $i . ':' . $v;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
    }
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


function fnCurlGet($url, $headerData = array())
{

    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    if (!empty($headerData)) {
        $headerArr = array();
        foreach ($headerData as $i => $v) {
            $headerArr[] = $i . ':' . $v;
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr);
    }
    //执行命令
    $result = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);

    return $result;
}

/**
 * @blog<http://www.phpddt.com>
 */

function fnListDir($dir)
{
    $dir .= substr($dir, -1) == '/' ? '' : '/';
    $dirInfo = array();
    foreach (glob($dir . '*') as $v) {
        $dirInfo[] = $v;
        if (is_dir($v)) {
            $dirInfo = array_merge($dirInfo, listDir($v));
        }
    }
    return $dirInfo;
}
