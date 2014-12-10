<?php
header('Content-Type:text/html;charset=utf8');
define('ACC', true);
require('./include/init.php');
/*$db = Mysql::getIns();
$db->single('category', array('id'=>123));
*/
function getVariableName($var, $scope)
{
    $name = array_search($var, $scope, true);
    return $name;
}
function test($id = 3)
{
    echo getVariableName($id, get_defined_vars());
}
//test();
class Test
{
    public function go()
    {
        $a = 123;
        return getVariableName($a, get_defined_vars());
    }
}
$a  = 2;
$ss = new Test();
echo $ss->go();
echo '<pre>';
print_r($GLOBALS);
echo '</pre>';
?>
