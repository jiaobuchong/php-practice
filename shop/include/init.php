<?php
/*
init.php,框架初始化

*/ 
//定义一些常量
define('ROOT', str_replace('\\', '/', dirname(dirname(__FILE__))) . '/');
define('DEBUG', true);

require(ROOT . 'include/conf.class.php');
require(ROOT . 'include/db.class.php');
require(ROOT . 'include/log.class.php');
require(ROOT . 'include/lib_base.php');
require(ROOT . 'include/pdo.class.php');

//过滤参数，用递归的方式过滤$_GET, $_POST, $_COOKIE
$_GET = _addslashes($_GET);
$_POST = _addslashes($_POST);
$_COOKIE = _addslashes($_COOKIE);

//设置报错级别
if (defined('DEBUG'))
{
    error_reporting(E_ALL | E_STRICT);
}
else
{
    error_reporting(0);
}


