<?php
/*
 * 爱客网安装入口程序
* @copyright (c) 2012-3000 12IK All Rights Reserved
* @author 小麦
* @Email:160780470@qq.com
*/
if (is_file('./data/install.lock')) {
    header('Location: ./');
    exit;
}
//载入版本号
require_once('version.php');

/* 应用名称*/
define('APP_NAME', 'install');
/* 应用目录*/
define('APP_PATH', './install/');
/* DEBUG开关*/
define('APP_DEBUG', true);
require("./core/setup.php");
