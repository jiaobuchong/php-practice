<?php
class Model
{
    protected $table = NULL;     //model所控制的表
    protected $db = NULL;      //引入的mysql对象

    public function __construct()
    {
        $this->db = Mysql::getIns(); 
    }

}
?>
