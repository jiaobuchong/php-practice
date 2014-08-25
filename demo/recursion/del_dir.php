<?php
/*
递归删除目录
*/
function del_dir($path)
{
    //不是目录
    if (!is_dir($path))
    {
        return NULL;
    }
    //打开目录
    $dp = opendir($path);
    while(($filename = readdir($dp)) !== false)
    {
        if ($filename == '.' || $filename == '..')
        {
            continue;
        }

        $tem_path = $path . '/' . $filename;
        if (is_dir($tem_path))
        {
            del_dir($tem_path);
        }
        else
        {
            unlink($tem_path);
        }
    }
    closedir($dp);
    rmdir($path);
}
$path = './aaa';
del_dir($path);
?>
