<?php
require('./include/init.php');
$db = Mysql::getIns();

$test = new Test();
$test->reg(array('username'=>'adminuser', 'money'=>123.00));
?>
