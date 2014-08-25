<?php
/*
求1到n的和 
function sum($n)
{
    $sum = 0;
    for ($i = 1; $i <= $n; $i++)
    {
        $sum += $i;
    }
    return $sum;
}
echo sum(100);   //array_sum(range(1, 100))
电影里的“慢动作”
函数 调用 开始 执行
入栈出栈的过程
先进后出
层数太深，不宜用递归
递归：
a、猴子变猴子，自身调自身
b、必须有一个终止条件
*/ 
function sum($n)
{
    if ($n == 1)
    {
        return 1;
    }
    return sum($n-1) + $n;
}
echo sum(100), '<br />';

//打印级联目录
$path = './test';
//var_dump(is_dir($path));die;
function open_dir($path, $len = 3)
{
    $dp = opendir($path);
    while (($filename = readdir($dp)) !== false)
    {
        if ($filename == '.' || $filename == '..')
        {
            continue;
        }
        
        echo '<p>' . str_repeat('&nbsp;', $len) . '|' . '---<span id="' . $filename .'">' . $filename, '</span><br /></p>';
        
        if (is_dir($path . '/' . $filename))
        {
            echo <<<CHCOLOR
            <script type="text/javascript">
                document.getElementById('$filename').style.color = 'blue';
            </script>
CHCOLOR;
            open_dir($path . '/' . $filename, 3 * $len);
        }
    }
    closedir($dp);

}
function open_dir1($path)
{
    $dp = opendir($path);
    while (($filename = readdir($dp)) !== false)
    {
/*        if ($filename == '.' || $filename == '..')
        {
            continue;
        }*/
        echo $filename, '<br />';
    }
}
open_dir($path);
echo '<hr />';
open_dir1($path);

?> 
