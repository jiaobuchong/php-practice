<?php
/*递归转义$_GET和$_POST的数据*/
defined('ACC') || exit("This file is denied!");
function _addslashes($arr)
{
    foreach ($arr as $key => $value)
    {
        if (is_string($value))   //如果数组值是string类型
        {
            $arr[$key] = addslashes($value);
        }
        else if (is_array($value)) //如果是数组类型
        {
            $arr[$key] = _addslashes($value);
        }
    }
    return $arr;
} 
//$arr = array("'hello'", '"some"', array('"ji"', "'dfdf'"));
//print_r(_addslashes($arr));
?> 
