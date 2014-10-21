<?php
header('Content-Type:text/html;charset=utf-8');
/*
pdo预处理
效率要提高
性能要好
*/ 
try{
    //设置其自动提交和错误处理方式
    $opts = array(PDO::ATTR_AUTOCOMMIT=>false, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', 'zhoujie', $opts);
    //echo $pdo->getAttribute(PDO::ATTR_AUTOCOMMIT), '<br />';
   // echo $pdo->getAttribute(PDO::ATTR_ERRMODE), '<br />';
}
catch (PDOException $e)
{
    echo 'error:' . $e->getMessage();
    exit; 
}

try
{
    /*
    $pdo->exec("insert into demo(username, money) values('Tom', 234.00)");
    $pdo->exec("insert into demo(username, money) values('Tom', 234.00)");
    $pdo->exec("insert into demo(username, money) values('Tom', 234.00)");
    $pdo->exec("insert into demo(username, money) values('Tom', 234.00)");
    sql injection delete from users where id = '5' or 1 = '1'
    */
     
}
catch (PDOException $e)
{
    echo 'error: ' . $e->getMessage();
}

?> 
