<?php
define('ACC', true);
require('../include/init.php');

 $goods = new GoodsModel();
 if (isset($_GET['act']) && $_GET['act'] == 'show')
 {
    //这个部分打印回收的商品
    $goodslist = $goods->select('', 'WHERE is_delete = :is_delete', array('is_delete' => 1));
    require(ROOT . 'view/admin/templates/goodstrash.html');

 }
 else
 {
     $goods_id = $_GET['goods_id'] + 0;
     if($goods->trash($goods_id))
     {
         echo 'Add goods into trash successfully!', '<br />';
     }
     else
     {
         echo 'Add goods into trash failure!', '<br />';
     }

 }
?>
