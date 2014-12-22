<?php
header('Content-Type:text/html;charset=utf8');
require('./FileUpload2.class.php');
echo '<pre>';
    print_r($_FILES);
echo '</pre>';
//$up = new FileUpload('./uploads', array('txt', 'jpg', 'gif', 'png'), 2000000, false);
$up = new FileUpload(array('filepath'=>'./uploads/', 'maxsize'=>1000000, 'israndname'=>true));
$res = $up->uploadFile('spic');

if ($res)
{
    print_r($up->getNewFileName());
}
else
{
    print_r($up->getErrorMsg());
}

?>
