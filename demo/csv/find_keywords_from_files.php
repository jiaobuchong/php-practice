<?php
/*
批量处理文件内容
有
a.txt
b.txt
c.txt    
……
如果文件中有fuck这个单词的，或者小于10个字节的，删掉
思路：循环文件名
判断文件大小，filesize if < 10, delete
if > 10: if have the word of fuck
if true: delete
*/ 
foreach (array('a.txt', 'b.txt', 'c.txt') as $v)
{
    $file = './' . $v;
    $size = filesize($file);
    /*if ($size < 10)
    {
        unlink($file);
        echo $file, ' is deleted because of the size';
        continue;
    }*/

    $content = file_get_contents($file);
   
    if (stripos($content, 'fuck') !== false)
    {
        unlink($file);
        echo $file, 'is deleted because of the dirty words!';
    }

}
?>

