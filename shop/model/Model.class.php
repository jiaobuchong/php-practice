<?php
class Model
{
    protected $table = NULL;     //model所控制的表
    protected $db = NULL;      //引入的mysql对象
    protected $pk = '';   //数据库表的主键
    protected $fields = array();   //数据库表的字段名
    protected $_auto = array();   //自动往数据库中填充的字段
    protected $_valid = array();   //验证规则
    protected $error = array();  //验证错误信息

    public function __construct()
    {
        $this->db = Mysql::getIns(); 
    }

/*公用的方法*/ 
    public function table($table)
    {
        $this->table = $table;
    }
    
/* 
    param array $data 包含数据的键值对，如array('id'=>1, 'name'=>'jack')
    return int affected_rows
*/ 
    public function add($data)
    {
        //返回受影响的行数
        return $this->db->query('insert', $this->table, $data);
    }

    /**
     * 根据主键id删除数据
     * param int $id 
     * return int affected_rows 受影响的行数
     **/
     public function delete($id)
     {
         //$name = getVariableName($id, get_defined_vars());
         $data = array($this->pk=>$id);
         return $this->db->query('delete', $this->table, $data);
     }

    /**
     * 根据主键，如id，更新数据
     * param array $data 数据库的主键 data数组的最后一个键值为数据表的主键,如： array('id'=>12)
     * return int affected_rows
     **/
     public function update($data)
     {
        return $this->db->query('update', $this->table, $data);
     }
     
   /**
    * 查询数据库表的结果
    * param array $fieldVal    数据库表的字段值 array('id', 'catename', 'intro', 'parent_id')
    * param string $condition  查询时的条件  'order by id desc' or 'where firstname=:firstname and id = :id' 
    * param array $data   当你有第二个参数条件时，$data就必须有了, 如：array('firstname'=>'jack', 'id'=>1)
    * param const $fetchmode 取数据的模式
    **/
    public function select($fieldVal = array(), $condition = '', $data = array(), $fetchmode = PDO::FETCH_ASSOC)
    {
        return $this->db->getAll($fieldVal, $this->table, $condition, $data, $fetchmode);
    }

    /**
     * 从数据库中返回单条数据,根据主键去找出单条数据
     * param $id 数据库的主键
     * return array find data from database
     **/
     public function find($id, $fetchmode = PDO::FETCH_ASSOC)
     {
        //$name = getVariableName($id, get_defined_vars());
        // array $data array('id'=>'123')
        $data = array($this->pk=>$id);
        return $this->db->single($this->table, $data, $fetchmode);
     }

     /**
      * 负责清除掉传过来的数组不用的单元
      * 思路：循环数组，分别判断其key，是否是表字段(先有表的字段)
      * 表的字段可以用desc来得到，也可以手动写好。以tp为例，两者都行
      * 查询数据库的方式来获得
      * param $array 从POST那里接收过来的数组
      **/
    public function _facade($array = array())
    {
        $data = array();
        $this->fields = $this->getTableField();
        foreach ($array as $k => $v)
        {
            if (in_array($k, $this->fields)) //判断$k是否是表字段
            {
                $data[$k] = $v;
            }
        }
        return $data;
    }

    /*
    自动填充
    负责把数据表中需要的值，而$_POST又没有的字段赋上值 
    比如 $_POST里没有add_time,即商品时间
    则自动把time()的返回值赋过来
    param $data 通过_facade过滤之后的数据
    */ 
    public function _autofill($data)
    {
        foreach ($this->_auto as $v)
        {
            if (!array_key_exists($v[0], $data))
            {
                switch ($v[1])
                {
                    case 'value':
                        $data[$v[0]] = $v[2];
                        break;
                    case 'function':
                        $data[$v[0]] = call_user_func($v[2]);
                        break;
                }
            }
        }
        return $data;
    }

//通过发送desc sql语句获得数据库表的字段信息
//是哪个模块调的，就可以获得相应模块对应表的信息
    protected function getTableField()
    {
        return $this->db->getFields($this->table);
    }

    /**
     * 自动验证
     * 验证规则
     * 格式 $this->_valid = array(
                     array('验证的字段名',0/1/2(验证场景), '报错提示', 'require/in(某几种情况)/between(范围)/length(某个范围)')
                                 );
     array(
          array('goods_name', 0, '必须有商品名', 'required', ''),
          array('cat_id', 1, '栏目id必须是整型值', 'number', ''),
          array('is_new', 2, 'is_new只能是0或1', 'in', '0,1'),
          array('goods_brief', 3, '商品简介在10到100个字符之间', 'length', '10,100')
          )                                                                                                                                            );
     mb_strlen();     
     **/
    public function _validate($data)
     {
         if (empty($this->_valid))
         {
            return true;
         }
         foreach ($this->_valid as $v)
         {
             switch($v[1])
             {
                 case 0:    //不能为空
                    if (empty($data[$v[0]]))
                    {
                        $this->error[] = $v[2];
                        return false;
                    }
                    break;
                 case 1:
                   if (isset($data[$v[0]]))   //检查cat_id是否是整型值, 只要有这个值就要进行检查
                   {
                        if (!$this->check($data[$v[0]], $v[3], $v[4]))
                        {
                            $this->error[] = $v[2];
                            return false;
                        }
                   }
                   break;
                case 2:
                    if (isset($data[$v[0]]))
                    {
                        if (!$this->check($data[$v[0]], $v[3], $v[4]))
                        {
                            $this->error[] = $v[2];
                            return false;
                        }
                    }
                    break;
                case 3:     //只要这个值被设定，并且不为空，执行检查
                    if (isset($data[$v[0]]) && !empty($data[$v[0]]))
                    {
                        if (!$this->check($data[$v[0]], $v[3], $v[4]))
                        {
                            $this->error[] = $v[2];
                            return false;
                        }
                    }
                    break;
             }
         }
         return true;   //只要上面的情况都没有问题，则成功通过
     }

    /**
     * 根据规则检测数据合法性  require、number、in、between、length、email
     * param $value 用户的输入值
     * param $rule require, number ...
     * param $parm 0,1 or 10, 100 
     **/
    protected function check($value = '', $rule = '', $param = '')
    {
        switch ($rule)
        {
            case 'require':
                return !empty($value);
           case 'number':
                return is_numeric($value);
           case 'in':
                $tmp = explode(',', $param);
                return in_array($value, $tmp);
           case 'between':
                list($min, $max) = explode(',', $param);
                return $value >= $min && $value <= $max;
           case 'length':
                list($min, $max) = explode(',', $param);
                return strlen($value) >= $min && strlen($value) <= $max;
           default: 
                return false;
        }
    }
    /**
     * 返回自动验证的错误信息
     **/
     public function getErr()
     {
         return $this->error;
     }
}
?>
