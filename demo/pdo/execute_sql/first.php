<?php
/*
    PDO中执行sql语句的方法有两个主要的
    1、exec() 用来处理非结果集的 insert update delete create 返回影响的行数
    2、query() 用来处理有结果集的语句 select desc show
    返回来的是PDOStatement 类的对象，再通过这个类的方法，获取结果
  set names utf8;
  $pdo->query("set names utf8");
  $pdo->exec("set names utf8");
*/ 
try{
    $dsn = 'mysql:host=localhost;dbname=test';
    $pdo = new PDO($dsn, 'root', 'zhoujie');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo 'error' . $e->getMessage();
    exit();
}
try
{
    $sql = 'insert into thread(uid, title, content, pubtime) values(12, "love is real!", 
           "love is beautiful!", 124353565)';
    $sql1 = "insert into demo(username, money) values('Tom', 23432)";
    $affected_rows = $pdo->exec($sql1);  //也可以用$pdo->query()
    echo $affected_rows.'<br />';
    echo $pdo->lastinsertid(); //获取自动增长的id
    /*
    $sql = 'select * from thread';
    $res = $pdo->query($sql);    //PDOStatement对象
    foreach ($res as $arr)
    {
        print_r($arr);
        echo '<br />';
    }
    */
    

}
catch (PDOException $e)
{
    echo 'error:' . $e->getMessage();
    exit();
}
echo 'ok';
?> 
