<?php
require('../include/init.php');
$id = $_GET['id'] + 0;
$catemodel = new CategoryModel();
$currdata = $catemodel->find($id); //获得此id的数据

//先执行一下$catemodel的select()方法 因为CategoryModel类的原因
$catemodel->select();
$listdata = $catemodel->getCatTree(); //得到归好类的子孙树
require('../view/cateedit.html');
?>
