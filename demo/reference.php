<?php
error_reporting(E_ALL | E_STRICT);
$age = 10;
function ch_age($age) //引用传值 函数内部和外部 指向的是同一个变量的地址
{
    return ++$age;
}
echo ch_age(&$age);
echo '<br />';
echo $age;
/*
违反封装性
函数运行之后，对外部的环境应该是"没有副作用的"
因此对函数进行引用传参是不推荐的
allow_call_time_pass_reference = Off  
不推荐引用传参
*/ 
?> 
