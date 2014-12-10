<?php
/*取出id，从数据库中把数据取出*/
define('ACC', true);
require('../include/init.php');
$id = $_GET['id'] + 0;
$catelist = new CategoryModel();
$cateinfo = $catelist->find($id); 

//把栏目的数据取出来
$catelist->listdata = $catelist->select();
//获得排序后的栏目
$listdata = $catelist->getCatTree();

print_r($cateinfo);
require(ROOT . 'view/admin/templates/cateedit.html');
?>
