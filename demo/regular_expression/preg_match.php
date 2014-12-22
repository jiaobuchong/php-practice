<?php
//$content = file_get_contents('http://beyondweb.cn/page/3/');
//echo $content;

/*
if (preg_match($pattern, $string, $arr))
{
    echo 'The regular expression <strong>', $pattern, '</strong>and the string ', htmlspecialchars($string, ENT_QUOTES), ' matches well.<br />';
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}
else
{
    echo '<font color="red">The regular expression <strong>', $pattern, '</strong>and the string ', htmlspecialchars($string, ENT_QUOTES) ,' matches failure.</font><br />';
}
*/

$pattern = '/^<[^>]+>$/';   //regular expression
$pattern = '/(\d{4})-(\d{2})-(\d{2})/';   //regular expression
$pattern = '/^([a-z])\1$/';   //regular expression
$string = 'aa';
if (preg_match($pattern, $string, $arr))
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
