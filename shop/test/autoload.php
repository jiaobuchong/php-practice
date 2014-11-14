<?php
//require('test.class.php');
function __autoload($className)
{
    require(strtolower($className) . '.class.php');
}
$t = new TEST();
$class = 'TestModel';
echo substr(strtolower($class), -5);
echo '<br />';
echo $class;
?>
