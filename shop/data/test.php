<?php
//touch('a.txt');
echo date('Y-m-d');
$new = './new.php';
$old = './a.txt';
rename($old, $new);
?> 
