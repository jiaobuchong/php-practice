<?php
/*
file:log.class.php
Functionality:record information to the log
Process:
The content will be written to the file.(fopen, fwrite)
If the file is greater than 1M, and write a another new file

When the log receive the content,
    judge the filesize
        if the size > 1M, backup
        else write to the log
*/ 
defined('ACC') || exit("This file is denied!");
class Log
{
    const LOGFILE = 'data/log/curr.log';   //a constant variable, the name of the log file
    //writing log
    public static function write($con)
    {
        $con .= "\r\n";     //add a newline symbol
        $log = self::isBak();   //judge the log file backup or not, and return the log file name
        $fp = fopen($log, 'ab');
        fwrite($fp, $con);
        fclose($fp);

    }

    //backup the log
    public static function backup()
    {
        //change the original log file name
        //to such pattern: Year-Month-Day.bak
        $log = ROOT . self::LOGFILE;
        $bak = ROOT . 'data/log/' . date('Y-m-d') . '_' . mt_rand(10000, 99999) . '.bak';
        return rename($log, $bak);
    }

    //read and judge the log size
    public static function isBak()
    {
        //$log = ROOT . 'data/curr.log';
        $log = ROOT . self::LOGFILE;
        if (!file_exists($log))    //if the file isn't existed, create it
        {
            touch($log);
            return $log;
        }

        //clear the cache
        clearstatcache(true, $log);
        $size = filesize($log);
        if ($size <= 1024 * 1024)
        {
            return $log;
        }
        //when the program is running to this line, proved that the filesize is greater than 1M
        if (!self::backup())
        {
            return $log;
        }
        else   //rename success
        {
            touch($log);
            return $log;
        }
    }
}
?> 
