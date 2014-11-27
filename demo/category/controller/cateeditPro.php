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
$catemodel = new CategoryModel();

$data = array(':catename' => $_POST['catename'], ':intro' => $_POST['intro'], ':parent_id' => $_POST['parent_id'], ':id'=>$_POST['id']);

/**
 * 现在有一个问题，假设我现在要修改A这个栏目，父栏目就不能修改为A本身或A下的子栏目
 * 解决方法： 现在得到了父栏目的$_POST['parent_id'], 寻找它的家谱树，如果A栏目的id在家谱树中，则不能删除
 **/
 //寻找家谱树
$tree = $catemodel->getFatherTree($_POST['parent_id']);
$flag = false;
foreach ($tree as $v)
{
    if ($v['id'] == $_POST['id'])
    {
        $flag = true;  //说明栏目下有子栏目
        break;
    }
}
if ($flag)
{
    echo '栏目选择错误，修改失败！';
    echo '<br /><a href="../index.php">返回首页</a>';
    exit();
}
if ($catemodel->update($data))
{
    echo 'update successfully!';
}
else
{
    echo 'update failure!';
}

?>
<br />
<a href="../index.php">返回首页</a>
