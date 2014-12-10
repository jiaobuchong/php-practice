<?php
class Model
{
    protected $table = NULL;     //model所控制的表
    protected $db = NULL;      //引入的mysql对象
    protected $pk = '';   //数据库表的主键

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
}
?>
