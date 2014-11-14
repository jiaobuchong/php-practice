<?php
$root = str_replace('\\', '/', dirname(dirname(__FILE__))) . '/';
define('ROOT', $root);
require(ROOT . 'include/config.inc.php');
require(ROOT . 'include/conf.class.php');
require(ROOT . 'include/pdo.class.php');
require(ROOT . 'include/log.class.php');
require(ROOT . 'model/model.class.php');
require(ROOT . 'model/TestModel.class.php');
?>
