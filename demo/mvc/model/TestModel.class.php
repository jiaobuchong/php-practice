<?php
class Test extends Model
{
    protected $table = 'test';
    //用户注册的方法
    /*
       $data array()
    */ 
    public function reg($data)
    {
        return $this->db->query('insert', $this->table, $data);
    }

    //取出所有的数据
    public function select()
    {
        return $this->db->getAll('SELECT * FROM ' . $this->table);
    }
}
?>
