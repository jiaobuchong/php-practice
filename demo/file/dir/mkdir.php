<?php
//创建目录
foreach (array('a', 'b', 'c') as $v) 
{
    $path = './test/' . $v;
    if (file_exists($path) && is_dir($path))
    {
        echo $path . ' is already existed!';
        echo '<br />';
        continue;
    }
    if (mkdir($path))
    {
        echo $v, ' is created successfully!';
    }
    else
    {
        echo $v, ' is not created!';
    }
    echo '<br />';
}

?>

