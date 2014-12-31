<?php
define('ACC', true);
header('Content-Type:text/html;charset=utf8');
require('./myUpload.class.php');
echo '<pre>';
    print_r($_FILES);
echo '</pre>';
//$up = new FileUpload('./uploads', array('txt', 'jpg', 'gif', 'png'), 2000000, false);

$up = new UploadTool(array('filepath'=>'./uploads/', 'maxsize'=>1000000, 'israndname'=>true));
$res = $up->uploadFile();
var_dump(implode('', $up->getErrorMsg()));
echo '<br />';
var_dump(implode(',', $up->getNewFileName()));
var_dump($res);
?>
