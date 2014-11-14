<?php
require('./include/init.php');

$test = new Test();
$list = $test->select(); 

include(ROOT . 'view/' . 'userlist.html');
?>

