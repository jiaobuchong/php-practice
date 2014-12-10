<?php
/**
 * param mixed $var 要查找的变量 & 引用
 * param Array $scope 要搜寻的范围
 * return String $name 返回变量名称 
 **/
 function getVariableName(&$a, $scope = null)
 {
     if ($scope == null)
     {
         $scope = $GLOBALS;
     }
     //in order to avoid some variable own same value, assigned the current variable value
     //to the temporary $tmpVal

     $tmpVal = $a;
     $a  = 'temp_' . mt_rand();
     $name = array_search($a, $scope, true);
     $a = $tmpVal;
     return $name;
 }
 /*
$a = 12;
$b = 23;
//echo getValriableName($a);

function test()
{
    $some = 100;
    return getValriableName($some, get_defined_vars());
}
echo test();
*/
//获取栏目数据
function getCategoryData()
{
    $catelist = new CategoryModel();
    $catelist->listdata = $catelist->select();
    $listdata = $catelist->getCatTree();
    return $listdata;
}
?>
