<?php
define('ACC', true);
require('../include/init.php');

//调用model获取数据库中的数据
$catelist = new CategoryModel();
$catelist->listdata = $catelist->select(array('id', 'catename', 'intro', 'parent_id'));

$listdata = $catelist->getCatTree();
echo '<pre>';
//print_r($listdata);
echo '</pre>';
require(ROOT . 'view/admin/templates/catelist.html');
?>
