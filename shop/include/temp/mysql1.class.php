<?php
class Mysql extends Db
{
    private static $ins = NULL;
    private $conn = NULL;
    private $conf = array();

    protected function __construct()
    {
        $this->conf = conf::getIns();
        $this->connect($this->conf->host, $this->conf->user, $this->conf->pwd);
        $this->select_db($this->conf->db);
        $this->setChar($this->conf->char);
    }
    public function __destruct()
    {

    }
    
    public static function getIns()
    {
        if (self::$ins === false)
        {
            self::$ins = new self();
        }
        return self::$ins;
    }

    public function connect($h, $u, $p)
    {
        $this->conn = mysql_connect($h, $u, $p);
        if (!$this->conn)
        {
            $err = new Exception('连接失败！');
            throw $err;
        }
    }

    protected function select_db($db)
    {
        $sql = 'use ' . $db;
        $this->query($sql);
    }

    protected function setChar($char)
    {
        $sql = 'set names ' . $char;
        return $this->query($sql);
    }

    public function query($sql)
    {
        if ($this->conn->debug)
        {
            $this->log($sql);
        }
        $rs = mysql_query($sql, $this->conn);

        if (!$rs)
        {
            $this->log($this->error());
        }
        return $rs;
    }

    public function autoExecute($arr, $table, $mode = 'insert', $where = ' where 1 limit 1')
    {
        if (!is_array($arr))
        {
            return false;
        }
        if ($mode == 'update')
        {
            $sql = 'update' . $table . ' set ';
            foreach ($arr as $k => $v)
            {
                $sql .= $k . "='" . $v . "',";
            }
            $sql = rtrim($sql, ',');
            $sql .= $where;
            return $this->query($sql);
        }

        //insert
        $sql = 'insert into ' . $table . ' (' . implode(',', array_keys($arr)) . ')';
        $sql .=' values (\'';
        $sql .= implode("','", array_values($arr));
        $sql .= '\')';
    }

    public function getAll($sql)
    {
        $rs = $this->query($sql);
        $list = array();
        while($row = mysql_fetch_assoc($rs))
        {
            $list[] = $row;
        }
        return $list;
    }
    
    public function getRow($sql)
    {
        $rs = $this->query($sql);
        return mysql_fetch_assoc($rs);
    }

    public function getOne($sql)
    {
        $rs = $this->query($sql);
        $row = mysql_fetch_row($rs);
        return $row[0];
    }

    //返回受影响的行数
    public function affected_rows()
    {
        return mysql_affected_rows($this->conn);
    }

    //返回最新的auto_increment列的自增长的值
    public function insert_id()
    {
        return mysql_insert_id($this->conn);
    }


}
?> 
