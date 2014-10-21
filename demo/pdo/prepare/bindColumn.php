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
    $pdo = new PDO('mysql:host=localhost;dbname=tieba', 'root', 'zhoujie', $opts);
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
    $stmt = $pdo->prepare('select tid, title, content, pubtime from thread where tid > ? and tid < ?');
    $stmt->execute(array(20, 100));

    //设置统一的结果的模式，下面使用的fetchAll() 和 fetch() 都使用它设置的格式
    $stmt->setFetchMode(PDO::FETCH_NUM);
    $stmt->bindColumn(1, $tid);
    $stmt->bindColumn(2, $title);
    $stmt->bindColumn(3, $content);
    $stmt->bindColumn(4, $pubtime);

    echo '<table border="1px" width="800px" align="center">';
    while ($stmt->fetch())  //PDO::FETCH_NUM 返回索引数组
    {
        echo "<tr>";
        echo "<td>$tid</td>";
        echo "<td>$title</td>";
        echo "<td>$content</td>";
        echo "<td>$pubtime</td>";
        echo "</tr>";
    }
    echo '</table>';
    //获取结果集中的行数或是受影响的行数
    echo $stmt->rowCount();
    //$pdo->lastInsertId();         

}
catch (PDOException $e)
{
    echo 'error: ' . $e->getMessage();
}

?> 
