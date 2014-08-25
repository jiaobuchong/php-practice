<?php
/*
array(
1=>array('重庆', 0),
2=>array('贵州', 0),
3=>array('綦江区', 1),
4=>array('赶水镇', 3)
)
其中 綦江区 1是其父地区
递归 将地区的上下级关系 层次打印出来

----无限级分类
*/ 

//递归创建目录
//echo mkdir('./a') ? 'ok' : 'fail';
//echo mkdir('./b', 0777) ? 'ok' : 'fail';
//echo mkdir('./v/c/d', 0777, true) ? 'ok' : 'fail';

//递归创建级联目录
function mk_dir($path)
{
    //如果$path的父目录存在
    if (is_dir(dirname($path)))
    {
        return mkdir($path);
    }

    mk_dir(dirname($path));
    return mkdir($path);
}

//方法二
function mk_dir1($path)
{
    if (is_dir($path))
    {
        return true;
    }
    //父母录一定要先存在，如果不存在，创建之
    return is_dir(dirname($path)) || mk_dir1(dirname($path)) ? mkdir($path) : false; 
}
$path = './a/b/c/d/e/f/g';
//echo mk_dir($path) ? 'ok' : 'fail';

?> 
