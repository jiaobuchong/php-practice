<?php
header('Content-Type:text/html;charset=utf-8');
/*
把数据交给model去写入数据库
判断model的返回值
*/ 
//接收数据
require('../include/init.php');
if (empty($_POST['catename']) || empty($_POST['intro']))
{
    exit('输入不能为空！');
}
$data = array(':catename' => $_POST['catename'], ':intro' => $_POST['intro'], ':parent_id' => $_POST['parent_id']);


//调用model写入数据库中
print_r($data);
$catemodel = new CategoryModel();
$res = $catemodel->add($data);

echo 'The last insert id is ', $res, '<br />';
echo $res ? 'Inserting success' : 'Inserting failure';

?>
<br />
<a href="../index.php">返回首页</a>
