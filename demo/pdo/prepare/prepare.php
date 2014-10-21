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
    //给数据库管理系统并直接执行 $pdo->query("select * from users");
    //只是将这个语句放到服务器上(数据库管理系统)上，编写后等待，没有执行
   // $affected_rows = $pdo->exec("insert into demo(username, money) values('周杰', 234)");
   // echo $affected_rows;
    
    $pdo->query('set names utf8');  //这个可以插入数据库乱码

    /*
    $stmt = $pdo->prepare("insert into demo(username, money) values('周杰伦', 123)");
    //var_dump($stmt);
    //执行上面在数据库系统中准备好的语句
    $stmt->execute();     执行两次
    $stmt->execute();
    */

    //防止注入
 /*   $stmt = $pdo->prepare("insert into demo(username, money) values(?, ?)"); //使用?
    //绑定参数
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $money);
    //给变量一个值
    $username = "admin";
    $money = 1234.50;
    $stmt->execute();

//只要一次绑定
    $username = "admin1";
    $money = 123.9;
    $stmt->execute();
    */
    $stmt = $pdo->prepare("insert into demo(username, money) values(:name, :money)"); //使用?
    $stmt->bindParam(':name', $username);   //第三个参数，限定类型
    $stmt->bindParam(':money', $money);


    $stmt->execute();

}
catch (PDOException $e)
{
    echo 'error: ' . $e->getMessage();
}

?> 
