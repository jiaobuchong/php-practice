<?php
class GoodsModel extends Model
{
    protected $table = 'goods';
    protected $pk = 'goods_id';
    protected $fields = array(); //表的字段名
    protected $_auto = array(  //针对自动填充的字段
                            array('is_hot', 'value', 0),
                            array('is_new', 'value', 0),
                            array('is_best', 'value', 0),
                            array('add_time', 'function', 'time')
                            );
    /*自动验证
    1、必检字段    1
    2、有字段则检，无此字段则不检，如性别。没有，不检;有必是男女之一    0
    3、如有且内容不空，则检查，如签名档，非空，则检查长度      2
    protected $_valid = array(
                            array('goods_name', 1, '报错信息', '非空'),
                            array('cat_id', 1, '报错信息', '整型值'),
                            array('is_new', 0, '报错信息','值', '0,1'),
                            array('goods_brief', 2, '报错信息',00<->200)   //100到200个字符
                             );
    */
    protected $_valid = array(
             array('goods_name', 0, '必须有商品名', 'required', ''),
             array('cat_id', 1, '栏目id必须是整型值', 'number', ''),
             array('is_new', 2, 'is_new只能是0或1', 'in', '0,1'),
             array('goods_brief', 3, '商品简介在10到100个字符之间', 'length', '10,100')
             );


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
