<?php
$file = './b.txt';
$fp = fopen($file, 'ab');
for ($i = 0; $i < 100; $i++)
{
    echo filesize($file), '<br />';
    fwrite($fp, $i . "\r\n");
}
fclose($fp);
echo 'ok';
?> 
