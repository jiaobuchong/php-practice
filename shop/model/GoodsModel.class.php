<?php
class GoodsModel extends Model
{
    protected $table = 'goods';
    /**
     * param array $data
     * return affected rows
     **/
    public function add($data)
    {
        return $this->db->query('insert', $this->table, $data);
    }

}
?>
