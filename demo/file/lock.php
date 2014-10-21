<?php
header('Content-Type:text/html;charset=utf8');
$filename = './message.txt';
if (isset($_POST['dosubmit']))
{
    //字段的分隔使用 || , 行的分隔使用 [n]
    $mess = "{$_POST['username']}||" . time() . "||{$_POST['title']}" . "||{$_POST['content']}";
    writeMessage($filename, $mess);
}
if (file_exists($filename) && filesize($filename))
{
    readMessage($filename);
}

//fopen() fwrite() flock() fclose()
function writeMessage($filename, $mess)
{
    $fp = fopen($filename, 'a');    //以追加的方式打开文件，文件指针指到了末尾
    if (flock($fp, LOCK_EX + LOCK_NB))   //加锁
    {
        fwrite($fp, $mess);
        flock($fp, LOCK_UN + LOCK_NB);   //解锁
    }
    else
    {
        echo '写入锁定失败！';
    }

    fclose($fp);
}

//fopen()  feof() fread() flocl()
function readMessage($filename)
{
    //$mess = file_get_contents($filename);
    $fp = fopen($filename, 'r');
    flock($fp, LOCK_SH + LOCK_NB);
    $mess = '';
    while (!feof($fp))
    {
        $mess .= fread($fp, 1024);
    }
    sleep(30);
    flock($fp, LOCK_UN + LOCK_NB);

    $mess = rtrim($mess, "\n");   //针对于linux的 \n 处理
    $arrmess = explode("\n", $mess);
    foreach ($arrmess as $row)
    {
        list($username, $time, $title, $content) = explode('||', $row);
        echo "<strong>$username</strong>发表于", date('Y-m-d H:i:s', $time), "<br />";
        echo "<trong>$title</strong>", $content, '<br />', '<br />';
    }
}
?>
<form action="lock.php" method="post">
   username:<input type="text" name="username" / ><br />
   title:<input type="text" name="title" /><br />
   content:<input type="text" name="content" / ><br />
   <input type="submit" name="dosubmit" value="send" /><br />

</form> 
