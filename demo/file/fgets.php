<?php
$file = './user.txt';
$fh = fopen($file, 'rb'); //模式里加b，表示以2进制来处理，不受编码限制
//feof, end of file 专门用来判断指针是否已经走到末尾,到文件末尾返回true
while (!feof($fh))
{
    echo fgets($fh), '<br />';
}
fclose($fh);
?> 
