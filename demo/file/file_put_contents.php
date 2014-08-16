<?php
    header('Content-Type:text/html;charset=utf-8');
    //文件内容的读取与写入
    //file_get_contents()  可以获取一个文件的内容或一个网络资源的内容
    //这个函数一次性的把文件的内容全部读出来，放入内存里。
    $data = file_get_contents('caocao');   //
    echo $data;
    $file = 'a.txt';
    //file_put_contents()把内容写入到文件，帮我们封装好了写入和关闭的细节
    file_put_contents('./a.txt', $data);




?> 
