<?php
define('ACC', true);
require('../include/init.php');

//直接调用/include/目录中的functions函数
$goods = new GoodsModel();
$goodslist = $goods->select();
//print_r($goodslist);
require(ROOT . 'view/admin/templates/goodslist.html');
?>
