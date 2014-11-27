<?php
require('../include/init.php');
$catemodel = new CategoryModel();
$catemodel->select();  //得到数据
$listdata = $catemodel->getCatTree(); //得到归好类的子孙树
require('../view/cateadd.html');
?>
