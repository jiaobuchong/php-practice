<?php
/*
file cateaddPro.php
作用 接收cateadd.php 表单页面发送过来的数据，并调用model，把数据如库

第一步 接收数据
print_r($_POST);
第二步 检验数据
第三步 实例化model，调用model的相关方法

*/ 
define('ACC', true);
require('../include/init.php');
print_r($_POST);
$data = array();
if (empty($_POST['catename']) && empty($_POST['intro']) && empty($_POST['parent_id']))
{
    exit("输入框中不能有空值！");
}
$data['catename']= $_POST['catename'];
$data['intro'] = $_POST['intro'];
$data['parent_id'] = $_POST['parent_id'];
$data['id'] = $_POST['id'];
$cate = new CategoryModel();
if ($cate->update($data))
{
    echo '栏目修改成功！';
    exit();
}
else
{
    echo '栏目修改失败！';
    exit();
}
?>
