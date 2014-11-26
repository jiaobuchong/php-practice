<?php
/*
把数据交给model去写入数据库
判断model的返回值
*/ 
//接收数据
define('ACC', true);
require('./include/init.php');
$data = array('catename' => $_POST['catename'], 'intro' => $_POST['intro']);

//调用model写入数据库中
$cateModel = new CateModel();
$res = $cateModel->add($data);

echo $res, '<br />';
echo $res ? 'success' : 'failure';
//
?>
