<?php
class Model
{
    protected $table = NULL;     //model所控制的表
    protected $db = NULL;      //引入的mysql对象

    public function __construct()
    {
        $this->db = DB::getIns(); 
    }

/*公用的方法*/ 
    public function table($table)
    {
        $this->table = $table;
    }

}
?>
