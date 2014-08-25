<?php
$arr = array('"hello"', "'ncccn'", array('test""', "'some one like you'"));
//递归转义数组
function escape($arr)
{
    foreach ($arr as $k => $v)
    {
        if (is_string($v))
        {
            $arr[$k] = addslashes($v);
        }
        else if (is_array($v))
        {
            $arr[$k] = escape($v);
        }
    }
    return $arr;
}
print_r(escape($arr));
?> 
