<?php
class GoodsModel extends Model
{
    protected $table = 'goods';
    protected $pk = 'goods_id';

    /**
     * 将删除的商品保存到回收站,即设置goods表的is_delete的值为1
     * param goods_id 
     * return database affected rows 
     **/
     public function trash($goods_id)
     {
        $data = array('is_delete' => 1, $this->pk => $goods_id);
        return $this->update($data);
     }

}
?>
