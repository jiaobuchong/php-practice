<?php
header('Content-Type:text/html;charset=utf-8');
/*
1、默认的错误模式，
*/ 
try
{
    $dsn = 'mysql:host=localhost;dbname=tieba';
    $pdo = new PDO($dsn, 'root', 'zhoujie');
}
catch (PDOException $e)
{
    echo 'Database connect failure!' . $pdo->getMessage();
    exit;
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$affected_rows = $pdo->exec('delete from hello');
echo '错误模式:' . $pdo->getAttribute(PDO::ATTR_ERRMODE) . '<br />';
/*
if (!$affected_rows)
{
    echo $pdo->errorCode();
    echo '<br />';
    print_r($pdo->errorInfo());
}
else
{
    echo 'ok';
}
*/

?> 

