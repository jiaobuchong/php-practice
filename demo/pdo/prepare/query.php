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
    $pdo->query('set names utf8');  //这个可以插入数据库乱码
    $stmt = $pdo->prepare('select * from test where username = :username and id > :id');
    $stmt->bindParam(':username',$username);
    $stmt->bindParam(':id', $id);
    $username="周杰";
    $id = 53;
    $stmt->execute();

    //设置统一的结果的模式，下面使用的fetchAll() 和 fetch() 都使用它设置的格式
    //$pdo->setFetchMode(PDO::FETCH_NUM);
    /*
    方法1获取数据，每次只获取一条
    echo '<table border="1px" width="800px" align="center">';
    while (list($tid, $uid, $title, $content, $pubtime) = $stmt->fetch(PDO::FETCH_NUM))  //PDO::FETCH_NUM 返回索引数组
    {
        echo "<tr>";
        echo "<td>$tid</td>";
        echo "<td>$uid</td>";
        echo "<td>$title</td>";
        echo "<td>$content</td>";
        echo "<td>$pubtime</td>";
        echo "</tr>";
    }
    echo '</table>';
    */

    /*
    方法二获取数据
   foreach ($stmt as $row)
   {
       print_r($row);
       echo '<br />';
   }*/

   echo '<pre>';
   $res = $stmt->fetchAll(PDO::FETCH_ASSOC);    //获取整个数据表的数据
   print_r($res);
   echo '</pre>';

}
catch (PDOException $e)
{
    echo 'error: ' . $e->getMessage();
}

?> 
