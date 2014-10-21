<?php
header('Content-Type:text/html;charset=utf-8');
try{
    //设置其自动提交和错误处理方式
    $opts = array(PDO::ATTR_AUTOCOMMIT=>false, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', 'zhoujie', $opts);
    echo $pdo->getAttribute(PDO::ATTR_AUTOCOMMIT), '<br />';
    echo $pdo->getAttribute(PDO::ATTR_ERRMODE), '<br />';
}
catch (PDOException $e)
{
    echo 'error:' . $e->getMessage();
    exit; 
}

try{
    //开启一个事务
    $pdo->beginTransaction();
    //zhoujie转出50元
    $price = 50;
    $affected_rows  = $pdo->exec("update demo set money = money - $price where id = 1");
    if ($affected_rows)
    {
        echo "zhoujie成功转出{$price}元";
    }
    else{
        throw new PDOException("zhoujie转出失败！");
    }
    //jack会收到50元
    $affected_rows = $pdo->exec("update demo set money = money + $price where id = 2");
    if ($affected_rows)
    {
        echo "jack成功收到{$price}元";
    }
    else
    {
        throw new PDOException("jack收入失败！");
    }
    echo '交易成功！';
    //提交以上的操作
    $pdo->commit();
}
catch(PDOException $e)
{
    echo 'error:' . $e->getMessage();
    echo '交易失败！';
    //撤消所有操作
    $pdo->rollback();
}
?> 
