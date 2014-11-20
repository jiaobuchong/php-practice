<?php
class CategoryModel extends Model
{
    protected $table = 'category';
    protected $listdata;
    
    /*$data 包含数据的键值对如array('id'=>1, 'name'=>'jack')
      然后add()方法将数据插入到数据库中  
    */ 
    public function add($data)
    {
        //返回值为受影响的行数
        return $this->db->query('insert', $this->table, $data);
    }

    /*查询栏目列表*/
    public function select()
    {
        $sql = 'SELECT id, catename, intro, parent_id FROM ' . $this->table . ' ORDER BY id ASC';
        $this->listdata = $this->db->getAll($sql);
        return $this->listdata;
    } 

    /*
    getCatTree
    param int id
    return $id下的栏目的子孙树
    */ 
    public function getCatTree($id = 0, $len = 1)
    {
        static $subs = array();
        foreach ($this->listdata as $v)
        {
            if ($v['parent_id'] == $id)   //parent_id 和 id相等的都是id的子栏目
            {
                $v['len'] = $len;
                $subs[] = $v;
                $this->getCatTree($v['id'], $len + 2);
            }
        }
        return $subs;
    }

    /*删除栏目*/
    public function delete($id)
    {
        return $this->db->query('delete', $this->table, array('id'=>$id));
    } 

    /*根据主键id，取出一行数据*/
    public function find($id)
    {
        $sql = 'SELECT id, catename, intro, parent_id FROM ' . $this->table . ' WHERE id = :id';
        return $this->db->single($sql, array('id' => $id)); 
    } 

    /*根据id修改栏目数据*/
    public function update($data)
    {
         return $this->db->query('update', $this->table, $data);
    } 
}
?>
