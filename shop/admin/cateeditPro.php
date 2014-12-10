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

/*
栏目修改的时候涉及一个问题：假如修改一个栏目A的父栏目时，其父栏目不能是其本身，或是A的子栏目
解决方法：如果用户将栏目A的父栏目修改为M，然后查找M的家谱树，若家谱树里面有A,则修改失败！
*/ 

//1、$data['parent_id'] 就是父栏目M, 获得M的家谱树
$tree = $cate->getFatherTree($data[parent_id]);

//2、取得此栏目M的家谱树
echo '<br />你想修改 ' . $data['id'] . ' 栏目', '<br />';
echo '并把他的父栏目设为' . $data['parent_id'], '<br />';
echo $data['parent_id'] . '家谱树为:<br />';

//3、检查当前栏目A的id，是不是在M的家谱树中
$flag = true;
foreach ($tree as $v)
{
    if ($data['id'] == $v['id'])
    {
        $flag = false;
        break;
    }
}
if (!$flag)
{
    echo '上级分类选择错误，请重新选择！';
    exit();
}

echo '<br />';
//执行修改
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
