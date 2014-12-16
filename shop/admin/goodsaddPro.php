<?php
header('Content-Type:text/html;charset=utf8');
define('ACC', true);
require('../include/init.php');

/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/
/*
Array
(
    [MAX_FILE_SIZE] => 2097152
    [goods_name] => 
    [goods_sn] => 
    [cat_id] => 0
    [shop_price] => 0
    [market_price] => 0
    [goods_desc] => sdvbsd
    [goods_weight] => 
    [weight_unit] => 1
    [goods_number] => 1
    [is_on_sale] => 1
    [keywords] => 
    [goods_brief] => 
    [seller_note] => 
    [goods_id] => 0
    [act] => insert
)
*/
/*
$data['goods_name'] = trim($_POST['goods_name']);
$data['goods_sn'] = trim($_POST['goods_sn']);
$data['cat_id'] = $_POST['cat_id'] + 0;
$data['shop_price'] = $_POST['shop_price'] + 0;
$data['market_price'] = $_POST['market_price'] + 0;
$data['goods_desc'] = $_POST['goods_desc'];
$data['goods_weight'] = $_POST['goods_weight'] * $_POST['weight_unit'];
$data['goods_number'] = $_POST['goods_number'];
$data['is_best'] = isset($_POST['is_best']) ? 1 : 0;
$data['is_new'] = isset($_POST['is_new']) ? 1 : 0;
$data['is_hot'] = isset($_POST['is_hot']) ? 1 : 0;
$data['is_on_sale'] = isset($_POST['is_on_sale']) ? 1 : 0;
$data['keywords'] = trim($_POST['keywords']);
$data['goods_brief'] = trim($_POST['goods_brief']);
//$data['seller_note'] = trim($_POST['seller_note']);
$data['add_time'] = time();
*/
$data = array();
$_POST['goods_weight'] *= $_POST['weight_unit'];   //克与千克的选择
echo '<pre>';
print_r($_POST);
$goods = new GoodsModel();
$data = $goods->_facade($_POST);   //自动过滤
print_r($data);

$data = $goods->_autofill($data);   //自动填充
print_r($data);
echo '</pre>';

//自动验证
$goods->_validate($data);
print_r($goods->getErr());
exit;
if($goods->add($data))
{
    echo 'Add goods success!';
}
else
{
    echo 'Add goods failure!';
}
//print_r($data); 



?>

