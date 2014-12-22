<?php
//$pattern = '/(\d+\.?)/';   //regular expression
//$string = '192.168.210';

//提取每行的首个单词
$pattern = "/(?m)^\w+/";
$string = "first line\nsecond line\r\nthird line";

//匹配字符串最后一个单词
//$pattern = '/\w+$/';
//$string = 'you are so beautiful';
if (preg_match_all($pattern, $string, $arr))
{
    echo 'Matching well<br />';
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}
else
{
    echo '<font color="red">Matching failure.</font><br />';
}
?>
