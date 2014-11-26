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

/*当一个栏目下还有栏目时，就不允许删除这个栏目
  所以此刻得调用model中的Categorymodel查找当前栏目下是否还有子栏目
*/ 
if (!empty($catelist->getSon($id)))
{
    exit("栏目下有子栏目，不能删除！");
}

if ($catelist->delete($id))
{
    echo '删除成功！';
}
else
{
    echo '删除失败！';
}

 
?>
