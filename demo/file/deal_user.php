<?php
//第一种办法
$file = './user.txt';
$cont = file_get_contents($file);
/*
由于各个系统换行符不一样
win: \r\n
*iux: \n
mac: \r
*/ 

print_r(explode("\n", $cont));  //换行为什么没有区分出来呢？
?> 
