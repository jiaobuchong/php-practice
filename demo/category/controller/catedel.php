<?php
header('Content-type:text/html;charset=utf-8');
require('../include/init.php');
//get the category id, and chang the id into int
$id = $_GET['id'] + 0;
//当这个栏目下有子栏目时不允许删除,所以此刻得找一下要删除栏目下是否有子栏目
$catemodel = new CategoryModel();
if (!empty($catemodel->getSon($id)))
{
    echo '你想删除的栏目下有子栏目，不能删除！<br />';
    echo '<a href="../index.php">返回首页</a>';
    exit();
}

if($catemodel->delete($id))
{
    echo 'delete successully!';
}
else
{
    echo 'delete failure!';
}

?>
<br />
<a href="../index.php">返回首页</a>
