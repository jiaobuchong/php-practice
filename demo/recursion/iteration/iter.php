<?php
/*
迭代：就是指在某个范围内，反复执行相同工作
一个函数
*/
function iter_sum($n)
{
    for ($i = 1, $sum = 0; $i <= $n; $i++)
    {
        $sum += $i;
    }
    return $sum;
}

/*递归
多个函数
*/
function rec_sum($n)
{
    if ($n = 1)
    {
        return 1;
    }
    return rec_sum($n - 1) + $n;
   
}

function mk_dir($path)
{
    $arr = array();
    while (!is_dir($path))
    {
        array_unshift($arr, $path);
        $path = dirname($path);
    }
    if (empty($arr))
    {
        return true;
    }
    foreach ($arr as $dir)
    {
        mkdir($dir);
    }
    return true;
}
$path = './a/b/c/d/e/f';
mk_dir($path) ? 'ok' : 'fail';
?> 
