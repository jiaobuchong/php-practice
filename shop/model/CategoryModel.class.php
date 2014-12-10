<?php
class CategoryModel extends Model
{
    protected $table = 'category';
    protected $pk = 'id';  //category表的主键
    public $listdata;

    

    /*查询栏目列表*/
/*    public function select()
    {
        $sql = 'SELECT id, catename, intro, parent_id FROM ' . $this->table . ' ORDER BY id ASC';
        $this->listdata = $this->db->getAll($sql);
        return $this->listdata;
    } 
*/
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

    /*寻找子栏目
    param: int $id
    return array $id 栏目的子孙树
    */
    public function getSon($id)
    {
        $fieldVal = array('catename', 'intro', 'parent_id');
        $condition = 'WHERE parent_id = :id';
        $data = array('id' => $id);
        return $this->select($fieldVal, $condition, $data);
    }
     
    /*寻找家谱树
    param: int $id
    return array $id 家谱树
    */
    public function getFatherTree($id = 0)
    {
        $this->listdata = $this->select();
        $tree = array();

        //迭代寻找家谱树
        while($id > 0)
        {
            foreach ($this->listdata as $v)
            {
                if ($v['id'] == $id)
                {
                    $tree[] = $v;
                    $id = $v['parent_id'];
                    break;   //找到相应的项目后，就不要往下继续找了
                }
            }
        }
        return $tree;
    }

}
?>
