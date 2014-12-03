<?php
define('ACC', true);
require('../include/init.php');

$catelist = new CategoryModel();
$catelist->select();   //先执行一下select方法，将数据保存在catelist的对象的属性listdata中，防止在getCatTree()方法中频繁的访问数据库
$listdata = $catelist->getCatTree();
//print_r($listdata);

require(ROOT . 'view/admin/templates/cateadd.html');
?>
