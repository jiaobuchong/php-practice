<?php
$rootDir = str_replace('\\', '/', dirname(dirname(__FILE__))) . '/';
define('ROOTDIR', $rootDir);
require(ROOTDIR . 'include/db.class.php');
require(ROOTDIR . 'model/model.class.php');
require(ROOTDIR . 'model/categoryModel.class.php');
?>
