<?php
/*
mysql_connect('localhost', 'root', 'zhoujie');
mysql_select_db('tieba');
创建PDO对象可以直接有以上的功能，还可以选择处理哪个数据库系统
可以参考手册
比如连接oracle数据库
$pdo = new PDO('oci:dbname=//192.168.1.111:1521/tieba', 'root', 'zhoujie');

在php.ini 中修改DSN
pdo.dsn.jack="mysql:host=localhost;dbname=tieba"

DSN data source name 数据源名称
  主机
  库

*/
 
try
{
    $dsn = 'mysql:host=localhost;dbname=tieba';
    //第四个参数进行设置参数
    $pdo = new PDO($dsn, 'root', 'zhoujie', array(PDO::ATTR_AUTOCOMMIT=>false, PDO::ATTR_PERSISTENT=>1));


}
catch(PDOException $e)
{
    echo '数据库连接失败.' . $e->getMessage();
}
echo 'pdo create ok!';
echo '<br />';
//设置属性值
//$pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
//数据库客户端版本
echo $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION) . '<br />';
//数据库服务器版本号
echo $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION) . '<br />';
//是否关闭自动提交功能
echo $pdo->getAttribute(PDO::ATTR_AUTOCOMMIT) . '<br />';
//当前PDO的错误处理的模式
echo $pdo->getAttribute(PDO::ATTR_ERRMODE) . '<br />';
//表字段字符的大小写转换
echo $pdo->getAttribute(PDO::ATTR_CASE) . '<br />';
//与连接状态相关特有信息
echo $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS) . '<br />';
//空字符串转换为SQL的null
echo $pdo->getAttribute(PDO::ATTR_ORACLE_NULLS) . '<br />';
echo $pdo->getAttribute(PDO::ATTR_PERSISTENT) . '<br />';  //是否可持续连接
//数据库特有的服务器信息
echo $pdo->getAttribute(PDO::ATTR_SERVER_INFO) . '<br />';



?> 
