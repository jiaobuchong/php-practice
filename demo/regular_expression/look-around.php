<?php
header('Content-Type:text/html;charset=utf-8');
$pattern = '/(?=(\d{3})+)/';   //regular expression
$string = '12345';
echo preg_replace($pattern, ',', $string);
echo '<br />';
//if (preg_match_all($pattern, $string, $arr))
//{
//
//    echo '<pre>';
//        print_r($arr);
//    echo '</pre>';
//}
$pattern = '/(?=(\d{3})+(?!\d))/';   //regular expression
$string = '123456';
echo preg_replace($pattern, ',', $string);

echo '<br />';
$pattern = '/(?<=\d)(?=(\d{3})+(?!\d))/';   //regular expression
$string = '123456';
echo preg_replace($pattern, ',', $string);

echo '<br />';
$pattern = '/(?<![a-zA-Z])\s+(?![a-zA-Z])/';   //regular expression  
$string = '   世界上最远的   距离， When I in front of you yet you don\'t know that I love you   ';
echo '[',  preg_replace($pattern, '', $string) , ']';

/**
 * 肯定环视要判断成功，字符串中必须有字符由环视结构中的表达式匹配;
 * 否定环视要判断成功有两种情况：字符串中出现了字符，但这些字符不能由环视结构中的表达式匹配;
 * 或者字符串中不再有任何字符，也就是说，这个位置是字符串的起始位置或结束位置。
 **/
echo '<br />';
$pattern = '/(?<=[^a-zA-Z])\s+(?=[^a-zA-Z])/';   //regular expression
$string = '   世界上最远的   距离， When I in front of you yet you don\'t know that I love you   ';
echo '[',  preg_replace($pattern, '', $string) , ']';
?>
