<?php
//处理Excel数据
$file = 'core.csv';
$fp = fopen($file, 'rb');
/*
每次读一行，没一行的内容根据逗号分成数组
while (!feof($fp))
{
    $row = fgets($fp);
    print_r(explode(',', $row));

}
*/ 
while (!feof($fp))
{
    $row = fgetcsv($fp);
    print_r($row);
}
?> 
