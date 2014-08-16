<?php
/*
file函数，直接读取文件内容，并按行拆成数组，然后返回该数组
和file_get_contents的相同之处：一次性读入，大文件慎用
*/ 
$file = './user.txt';
$arr = file($file);
echo '<pre>';
print_r($arr);
echo '</pre>';
?> 
