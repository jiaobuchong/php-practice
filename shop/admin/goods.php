<?php
define('ACC', true);
require('../include/init.php');

/**
 * 接收goods_id
 * 实例化goodsmodel
 * 调用find方法
 * 展示商品信息
 **/
 $goods = new GoodsModel();
 $goods_id = $_GET['goods_id'] + 0;
 $goodsData = $goods->find($goods_id);
 print_r($goodsData);
//require(ROOT . 'view/admin/templates/goodsadd.html');
?>
