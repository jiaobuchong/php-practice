<?php
//删除目录
//只能删除空目录
foreach (array('a', 'b', 'c') as $v) 
{
    $path = './test/' . $v;
    if (file_exists($path) && is_dir($path))
    {
        if (rmdir($path))
        {
            echo $path . ' is deleted successfully!';
        }
        else
        {
            echo $path, ' is deleted failure!';
        }
        echo '<br />';
    }
    else
    {
        echo 'Something wrong!';
    }
}
    
