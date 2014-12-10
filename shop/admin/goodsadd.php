<?php
define('ACC', true);
require('../include/init.php');

//直接调用/include/目录中的functions函数
$listdata = getCategoryData();
print_r($listdata);
require(ROOT . 'view/admin/templates/goodsadd.html');
?>
