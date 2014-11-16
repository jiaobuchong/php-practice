<?php
class CategoryModel extends Model
{
    protected $table = 'category';
    
    /*$data 包含数据的键值对如array('id'=>1, 'name'=>'jack')
      然后add()方法将数据插入到数据库中  
    */ 
    public function add($data)
    {
        //返回值为受影响的行数
        return $this->db->query('insert', $this->table, $data);
    }
}
?>
