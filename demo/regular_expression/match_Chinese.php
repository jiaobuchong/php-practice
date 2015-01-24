<?php
header('Content-Type:text/html;charset=utf-8');
var_dump(preg_match('/^.$/u', '周'));
var_dump(preg_match('/[周杰]/u', '傻'));
var_dump(preg_match('/^\w$/u', '傻'));
if (preg_match('/\blove\b/u', '周杰 好帅哦！ love，', $match))
{
    print_r($match);
}

//指定码值
var_dump(preg_match('/\x{53d1}/u', '发', $mat));
print_r($mat);
//echo 'hello';
//Unicode Script 匹配中文
//按照书写系统来划分Unicode 字符 比如 \p{Greek}表示希腊语字符 \p{Han}表示汉语
var_dump(preg_match('/\\p{Han}/u', '我'));
?>
