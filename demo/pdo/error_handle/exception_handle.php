<?php
header('Content-Type:text/html;charset=utf-8');
/*
1、默认的错误模式，
2、警告的模式 PDO::ERRMODE_WARNING
3、异常的模式 PDO::ERRORMODE_EXCEPTION
*/ 
try
{
    $dsn = 'mysql:host=localhost;dbname=tieba';
    $pdo = new PDO($dsn, 'root', 'zhoujie');
    //设置属性为异常模式
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    echo 'Database connect failure!' . $pdo->getMessage();
    exit;
}
echo '错误模式:' . $pdo->getAttribute(PDO::ATTR_ERRMODE) . '<br />';

try
{
    //使用pdo中的方法进行数据库的操作
    $affetced_rows = $pdo->exec('delete from hello');
}
catch (PDOException $e)
{
    echo 'The reason of error:' . $e->getMessage();
   //print_r($pdo->errorInfo());
}

?> 

