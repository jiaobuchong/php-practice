<?php
$conn = mysql_connect('localhost', 'root', 'zhoujie');
$sql = 'use test';
mysql_query('set names utf8');
/*
 网页是utf8
连接器是utf8
返回值也是utf8

因此set names utf8

牵涉到数据库，想不乱码
1：正确指定客户端的编码
2：合理选择连接器的编码
3：正确指定返回内容的编码

网页本身编码，meta信息，client/connection/result
如果都保持一致，乱码消除

*/ 

?> 
<!doctype>
<html>
<head>
    <meta charset="utf-8">
    <title>编码测试</title>
</head>
<body>
    <p>The reason is which encoding you choose not match to the decoding!</p>
</body>
</html>
