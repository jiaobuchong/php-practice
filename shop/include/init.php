<?php
/*
init.php,框架初始化

*/ 
//定义一些常量
defined('ACC') || exit("This file is denied!");
define('ROOT', str_replace('\\', '/', dirname(dirname(__FILE__))) . '/');
define('DEBUG', true);

require(ROOT . 'include/lib_base.php');

//自动加载类
function __autoload($class)
{
    if (substr(strtolower($class), -5) == 'model')
    {
        require(ROOT . 'model/' . $class . '.class.php');
    }
    else
    {
        require(ROOT . 'include/' . $class . '.class.php');
    }
}

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


