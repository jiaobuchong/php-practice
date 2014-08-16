<?php
$file = 'a.txt';
if (file_exists($file))
{
    echo $file, '存在';
    echo '上次修改时间', date('Y-m-d H:i:s', filemtime($file));
}
?> 
