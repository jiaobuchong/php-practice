<?php
/*
opendir()    打开目录
readdir()    读取目录
mkdir()      创建目录
rmdir()      删除目录
closedir()   关闭目录句柄
is_dir()     判断是否为目录
*/
$path = './test';
$dh = opendir($path);
/*echo readdir($dh), '<br />';
echo readdir($dh), '<br />';
echo readdir($dh), '<br />';
echo readdir($dh), '<br />';
*/
while (($filename = readdir($dh)) !== false)
{
    echo $filename;

    if (is_dir($path  . '/' . $filename))
    {
        echo ' is a directory!';
    }
    echo '<br />';
}

?> 
