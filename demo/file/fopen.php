<?php
    /*
        fopen()   打开一个文件，返回一个句柄资源，通道，文件指针
                 fopen($filename, mode)  模式，只读模式，追加模式，
        fread()
        fwrite()

    */ 
    /*
$url = 'http://photo.cankaoxiaoxi.com/china/2014/0810/455951_17.shtml';
$html = file_get_contents($url);
if (file_put_contents('girl.html', $html))
{
    echo 'I\'m  a thief';
}
*/
$file = 'http://photo.cankaoxiaoxi.com/china/2014/0810/455951_17.shtml';
$fh = fopen($file, 'r');  //r+读写模式，并把指针指向文件头
//沿着通道读文件
$con = fread($fh, 10);   //读10个字节
echo $con;
fclose($fh);

$fp = fopen($file, 'r+');
echo fwrite($fp, 'hello, world') ? 'success' : 'failure';
?> 
