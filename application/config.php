<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$
$server = [];
if (file_exists(APP_PATH . "server.php")) {
    $server = include("server.php");
}

$self = [
    'url_route_on' => true,
    'log' => [
        'type' => 'File', // 支持 socket trace file
    ],
    'app_trace' => true,
    'trace' => [
        'type' => 'Html',
    ],

    'view_replace_str' => [
        '__ROOT__' => '/',
        '__PUBLIC__' => '/static',
        '__JS__' => "/static/js",
        '__CSS__' => "/static/css",
        '__IMAGE__' => "/static/image",
        '__Lib__' => "/static/lib",
        '__CDNBASIC__' => "http://cdn.lmx0536.cn",
    ],
    'template' => [
        'layout_on' => true,
        'layout_name' => 'layout/layout',
    ],
];

return array_merge($self, $server);
