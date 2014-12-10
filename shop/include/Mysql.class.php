<?php
defined('ACC') || exit("This file is denied!");
class Mysql
{

    private $pdo;   //pdo对象
    private $stmt;  //预处理 PDOStatement对象
    private $conf;     //配置选项
    private $connected = false;   //是否连接
    private $parameters;   //执行SQL语句要用的参数
    private $where;       //保存where参数
    private $success;     //SQL是否执行成功

    private static $ins;    //单例模式，保存pdo数据库对象
    private function __construct()
    {
        $this->connect();
    }

    //返回实例
    static public function getIns()
    {
        if (self::$ins instanceof self)
        {
            return self::$ins; 
        }
        self::$ins = new self();
        return self::$ins;
    }

    //针对克隆
    final public function __clone()
    {
        return self::$ins;
    }
    
   public function connect()
   {
        $this->conf = Conf::getIns();
        $dsn = 'mysql:host=' . $this->conf->host . ';dbname=' . $this->conf->dbname;
        try
        {
            //设置参数
            $this->pdo = new PDO($dsn, $this->conf->user, $this->conf->pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //如果你的SQL服务器不真正的支持预处理,我们可以很容易的通过如下方式在PDO初始化时传参来修复这个问题:
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->connected = true;
        }
        catch(PDOEXception $e)
        {
            //写入log
            $mess = '数据库连接出错。' . $e->getMessage();
            $this->writeToLog($mess);
            die();
        }

   }

    /*$act   操作  insert delete update select
      $table  数据库的表名
      $data   数据   array('id' => 1, 'name' = 'Jack')  id 和 name 对应数据库表中的字段名
      $where  也是一个数组 array('or' => array('id'=>1, 'name'=>'jack')) id 和name 对应数据表中的字段名
      
      执行delete update insert 返回数据库中受影响的行数
      select 操作返回会返回结果集中所有数据
    */
    public function query($act = '', $table = '', $data = array(), $fetchmode = PDO::FETCH_ASSOC)
    {
        $act = strtoupper($act);
        $query = $this->autoSQL($act, $table, $data);    //得到SQL语句
        $this->init($query);
        if ($act === 'SELECT')
        {
            return $this->stmt->fetchAll($fetchmode); 
        }
        else if ($act === 'INSERT' || $act === 'UPDATE' || $act === 'DELETE')
        {
            return $this->stmt->rowCount();     //
        }
        else
        {
            return NULL;
        }
    }

    /*
        如果没有连接数据库，调用连接数据库的函数 $this->connect()
        prepare query
        绑定参数
        执行语句
        异常写入log     
    */ 
    private function init($query)
    {
        if (!$this->connected)
            $this->connect();

        try{
            echo $query;
            
            $mess = "这是一次访问数据库。\n" . $query;
            $this->writeToLog($mess);      //把这一次数据库的查询写入日志

            $this->stmt = $this->pdo->prepare($query);    //预处理对象
            print_r($this->parameters); 
            if (!empty($this->parameters))
            {
                foreach ($this->parameters as $key => $value)
                {
                    $this->stmt->bindParam($key, $this->parameters[$key]);   //绑定参数
                }
            }
            $this->success = $this->stmt->execute();   //Execute SQL 
            
        }
        catch(PDOEXception $e)
        {
            $mess = '数据库执行SQL出错。' . $query . ' ' . $e->getMessage();
            $this->writeToLog($mess);
            die();
        }
        

    }
    //自动生成sql语句
    private function autoSQL($act, $table, $data)
    {
        $sql = '';
        switch ($act)
        {
            case 'INSERT':    //增
                 $sql .= 'INSERT INTO ' . $table . ' (' . implode(',', array_keys($data)) . ')';
                 $sql .= ' VALUES(';
                 $this->parameters = $this->bindMore($data);  //数据处理
                 $sql .= implode(",", array_keys($this->parameters));
                 $sql .= ')';
                 return $sql;   //返回SQL语句
            break;
            case 'DELETE':     //删
                 //$data = array('id'=>1)
                 $this->parameters = $this->bindMore($data);       //$this->parameters = array(':id'=>1)
                 $sql .= 'DELETE FROM ' . $table . ' WHERE ' . implode('', array_keys($data)) . '=';
                 $sql .=  implode('', array_keys($this->parameters));
                 return $sql;
            break;
            case 'UPDATE':  //改
                 //$data = array('username'=>'周杰伦', 'money'=>9999, 'id'=>1);  where条件写在最后
                 $this->parameters = $this->bindMore($data);
                 $sql .= 'UPDATE ' . $table . ' SET ';

                 $i = 0;     //为了保证where字段的顺利生成,设一参数，看数组是否循环到末尾

                 foreach ($data as $key => $value)
                 {
                    $i++;
                    if ($i == count($data))
                    {
                        $sql = rtrim($sql, ',');
                        $sql .= ' WHERE ' . $key . '=:' . $key;
                    }
                    else
                    {
                        $sql .= $key . '=:' . $key . ','; 
                    }
                 }
                return $sql;
            break;
            case 'SELECT':   //查
                 $sql .= 'SELECT * FROM ' . $table;
                 return $sql;
            break;
        }
    }

    /*$parray 就是例如 $parray = array('id'=>1, 'name'=>'Jack'),id和name对应于数据库表中的字段
      将$parray 生成形如 $parray = array(':id'=>1, ':name'=>'jack')
      所以本函数 侧重在于改变数组的key值
    */ 
    private function bindMore($parray)
    {
        $arr = array();
        if (is_array($parray) && !empty($parray))
        {
            //$i = 0;
            foreach($parray as $key => $value)
            {
                $newKey = ':' . $key;  //新的key值
                $arr[$newKey] = $value;
            } 
        }
        return $arr;
    }

    /*最后的插入id，即最新的auto_increment列的自增长的值*/
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    } 
    
    /**查询数据
     * param array $fieldVal    数据库表的字段值
     * param string $table 数据库表名
     * param string $condition  查询时的条件  'order by id desc' or 'where firstname=:firstname and id = :id' 
     * param array $data   当你有第二个参数条件时，$data就必须有了, 如：array('firstname'=>'jack', 'id'=>1)
     * param const $fetchmode 取数据的模式
     **/
    public function getAll($fieldVal = array(), $table = '', $condition = '', $data = array(), $fetchmode = PDO::FETCH_ASSOC)
    {
        if (!empty($data))
        {
            $this->parameters = $this->bindMore($data);
        }
        $query = $this->autoSelectSql($fieldVal, $table, $condition);  //生成select的SQL语句
        $this->init($query);
        return $this->stmt->fetchAll($fetchmode);
    }

    /* 查询一条数据
       param string $table 数据库表名
       param array $data  
    */
    public function single($table = '', $data = array(), $fetchmode = PDO::FETCH_ASSOC)
    {
        $this->parameters = $this->bindMore($data);

        //生成query 
        $primaKey = implode('', array_keys($data));
        $query = 'SELECT * FROM ' . $table . ' WHERE ' . $primaKey . '=:' . $primaKey;
        $this->init($query);
        return $this->stmt->fetch($fetchmode);
    }

    /** 专生成select的SQL语句
     * param array $fieldVal
     * param string $condition
     * return tring $sql
     **/
     protected function autoSelectSql($fieldVal = array(), $table, $condition = '')
     {
        $sql = '';
        if (empty($fieldVal))
        {
            $sql .= 'SELECT * FROM ' . $table;
        }
        else
        {
            $sql .= 'SELECT ' . implode(',', $fieldVal) . ' FROM ' . $table . ' ' . $condition;
        }
        return $sql;
     }
    
    //析构函数
    public function __destruct()
    {
        $this->closeConn();
    }

    //关闭连接
    private function closeConn()
    {
        $this->pdo = null;
    }

    //写入日志
    private function writeToLog($mess)
    {
        $mess = date('Y-m-d H:i:s:      ') . $mess;
        Log::write($mess);
    }
}
?> 

