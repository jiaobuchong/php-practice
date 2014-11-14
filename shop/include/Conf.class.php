<?php
/*
    file: conf.class.php
    配置文件读写类
*/ 
class Conf
{
    private static $ins = null;
    protected $data = array();

    final protected function __construct()
    {
        /*
            将配置信息直接给data属性
        */ 
        include(ROOT . 'include/config.inc.php');       
        $this->data = $_CFG;
    }
    final protected function __clone()
    {
        return self::$ins;
    }
    public static function getIns()
    {
        if (self::$ins instanceof self)
        {
            return self::$ins; 
        }
        else
        {
            self::$ins = new self();
            return self::$ins;
        }
    }

    //用魔术方法，读取data内的信息
    public function __get($key)
    {
        if (array_key_exists($key, $this->data))
        {
            return $this->data[$key];
        }
        else
        {
            return null;
        }
    }

    //运用魔术方法在运行期动态增加或改变配置选项
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }
}
/*$conf = Conf::getIns();
var_dump($conf);
echo $conf->host, $conf->user, $conf->pwd;
echo '<br />';
$conf->template_dir = './www/smarty';
echo $conf->template_dir;
*/
?>  

