<?php
require('./include/init.php');
$catemodel = new CategoryModel();
$listdata = $catemodel->select();
$listdata = $catemodel->getCatTree();

require(ROOTDIR . 'view/' . 'index.html');
?>
