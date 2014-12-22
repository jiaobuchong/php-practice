<?php
echo '<pre>';
print_r($_FILES);
echo '</pre>';

/**
 * 接收文件，分目录存储，生成随机文件名
 * 1、根据时间戳，并按一定的规则创建目录
 * 2、获取文件后缀名
 * 3、判断大小
 **/
 //创建目录
// 2012-12/30/12_23_34_dvdfv.png
//echo date('Y-m-d/', time());
function mk_dir()
{
    $dir = './' . date('Y-m-d', time());
    if(is_dir($dir))
    {
        return $dir;
    }
    else
    {
        mkdir($dir, 0777, true);
        return $dir;
    }
}

//获取文件扩展名
function getExten($file)
{
    $tmp = explode('.', $file);
    return end($tmp);
}

//随机名
function randName()
{
    $str = 'abcdefghijklmnopqrstuvwxyz123456789';
    $time = date('H_i_s', time());
    return $time . '_' . substr(str_shuffle($str), 0, 6);
}

//处理上传过程
if ($_FILES['spic']['error'] != 0)
{
    echo 'upload failure!';
    exit;
}

//拼接文件路径
$path = mk_dir() . '/' . randName() . '.' . getExten($_FILES['spic']['name']);

if(move_uploaded_file($_FILES['spic']['tmp_name'], $path))
{
    echo 'success';
}
else
{
    echo 'failure';
}


?>
