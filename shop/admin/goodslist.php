<?php
define('ACC', true);
require('../include/init.php');

//直接调用/include/目录中的functions函数
$goods = new GoodsModel();

//查询出goods表中字段is_delete是0的商品
$goodslist = $goods->select('', 'WHERE is_delete = :is_delete', array('is_delete' => 0));
//print_r($goodslist);
require(ROOT . 'view/admin/templates/goodslist.html');
?>
