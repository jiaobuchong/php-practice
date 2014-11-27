<?php
class DB
{
    private $pdo;   //pdo对象
    private $stmt;
    private $host = 'localhost';
    private $dbname = 'shop';
    private $user = 'root';
    private $passwd = 'zhoujie';
    private $connected = false;  //是否连接好数据库
    
    private static $ins;  //单例模式创建mysql对象
    
    private function __construct()
    {
        $this->connect();
    } 
    
    //返回实例
    public static function getIns()
    {
        if (self::$ins instanceof self)
        {
            return self::$ins;
        }
        self::$ins = new self();
        return self::$ins;
    }
    //针对单例模式的clone,final方法不能被覆盖
    final public function __clone()
    {
        return self::$ins;
    }

    protected function connect()
    {
        $dsn = 'mysql::host=' . $this->host . ';dbname=' . $this->dbname;
        try
        {
            $this->pdo = new PDO($dsn, $this->user, $this->passwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            //通过$pdo对象打开的任何语句中的空字符串都将被转换为NULL
            $this->pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, true);
            //设置错误处理的参数为异常
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //如果SQL服务器不真正的支持预处理，可以通过如下方式在pdo初始化时传参来修复这个问题
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            //创建持久连接，持久连接的好处是能够避免在每个页面执行时都打开和关闭数据库服务器连接，速度更快
            $this->pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
            $this->connected = true; 
        }catch(PDOException $e)
        {
            echo 'Database connect failure:' . $e->getMessage();
        }
    }
    
    //执行update delete insert 操作
    /*
    param: $query INSERT INTO table_name(name, address, phone) VALUES(:name, :address, :phone)
    param: $operation insert/update/delete
    param: $data array(':name'=>'Jack', ':address'=>'London', ':phone'=>'110')
    */
    public function query($query, $operation, $data = '')
    {
        $operation = strtoupper($operation);
        $this->init($query, $data);
        if ($operation == 'INSERT')
        {
            return $this->pdo->lastInsertId();   //返回最后插入的id
        }
        else if ($operation == 'UPDATE' || $operation == 'DELETE')
        {
            return $this->stmt->rowCount();  //返回受影响的行数
        }
        else
        {
            return NULL;
        }
    }

    //返回所有数据
    //param: $data array(':name'=>'Jack', ':address'=>'London', ':phone'=>'110')
    public function getAll($query, $data = '', $fetchmode = PDO::FETCH_ASSOC)
    {
        $this->init($query, $data);
        return $this->stmt->fetchAll($fetchmode);    
    }

   //返回单条数据
   //param: $data array(':name'=>'Jack', ':address'=>'London', ':phone'=>'110')
   public function single($query, $data, $fetchmode = PDO::FETCH_ASSOC)
   {
       $this->init($query, $data);
       return $this->stmt->fetch($fetchmode);
   }

   //执行数据库的操作
    private function init($query, $data = '')
    {
        if (!$this->connected)
            $this->connect();
        try{
           $this->stmt = $this->pdo->prepare($query);
           if (!empty($data))
           {
               $this->stmt->execute($data); 
           }
           else
           {
               $this->stmt->execute();
           }
        }catch(PDOException $e)
        {
            echo 'The SQL query execute failure!' . $e->getMessage();
        }

    }


}
?>
