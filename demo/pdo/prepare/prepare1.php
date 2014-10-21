<?php
header('Content-Type:text/html;charset=utf-8');
/*
pdo预处理
效率要提高
性能要好
*/ 
try{
    //设置其自动提交和错误处理方式
    $opts = array(PDO::ATTR_AUTOCOMMIT=>true, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
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
    $pdo->query('set names utf8');
    $stmt = $pdo->prepare('insert into demo(username, money) values(?, ?)');
    $stmt->execute(array('Sb', 123));

    /*$stmt = $pdo->prepare('insert into demo(username, money) values(:name, :cost)');
    $stmt->execute(array('name'=>'Sb', 'cost'=>123));
    $stmt->execute($_GET);
    */

}
catch (PDOException $e)
{
    echo 'error: ' . $e->getMessage();
}

?> 
