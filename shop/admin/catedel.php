<?php
//栏目的删除页面
/*
接收 栏目的id
调用model
删除栏目的 id
*/ 

define('ACC', true);
require('../include/init.php');

$id = $_GET['id'] + 0;

$catelist = new CategoryModel();
if ($catelist->delete($id))
{
    echo '删除成功！';
}
else
{
    echo '删除失败！';
}

 
?>
