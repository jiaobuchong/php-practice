<?php
    class Test
    {
        public $pa;
        public function __construct()
        {
            var_dump(empty($this->pa));
        }
    }
$p = new Test();

        $parray = array('id'=>1, 'name'=>'jack');
        $arr = array();
        if (is_array($parray))
        {
            $i = 0;
            foreach($parray as $key => $values)
            {
                $newKey = ':' . $key;  //新的key值
                $arr[$newKey] = $values;
            } 
        }
print_r($arr);   

$arr1 = array('sex'=>'male', 'height'=>123);
echo implode(' and ', $arr1);
echo implode(',', array_keys($arr1));
?> 
