<?php
/*
file db.class.php
数据库类,抽象类
*/ 
abstract class Db
{
    /*
        连接数据库服务器
        params $host 服务器地址
        params $user 用户名
        params $pass 密码
        return bool
    */ 
    public abstract function connect($host, $user, $pass);

    /*
        发送查询
        params $sql 发送的sql语句
        return mixed bool/resource
    */
    public abstract function query($sql);

    /*
        查询多行语句
        params $sql select型语句
        return array/bool
    */
    public abstract function getAll($sql);

    /*
        查询单行语句
        params $sql select型语句
        return array/bool
    */
    public abstract function getOne($sql);

    /*
        自动执行insert/update语句
        $this->autoExec('user', array('username'=>'Jack', 'email'=>'ijiaobu@qq.com'), 'insert');
        然后自动生成sql语句
        params $table 表名
        params $data insert的数据
        params $act insert/update
        params $where 在哪里插入
        return array/bool
    */
    public abstract function autoExec($table, $data, $act='insert', $where = '');



}
?> 
