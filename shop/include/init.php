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
//设置报错级别
if (defined('DEBUG'))
{
    error_reporting(E_ALL);
}
else
{
    error_reporting(0);
}


