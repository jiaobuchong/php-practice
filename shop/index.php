<?php
    header('Content-Type:text/html;charset=utf8');
    /*所有由用户直接访问到的这些页面都得首先加载init.php*/ 
    define('ACC', true);
    require('./include/init.php');
    echo ROOT, '<br />';   //根目录

    $conf = Conf::getIns();    //配置文件
    var_dump($conf);
    echo $conf->host, $conf->user, $conf->pwd;
    echo '<br />';
    $conf->template_dir = './www/smarty';
    echo $conf->template_dir;
    echo '<br />';
   $db = Mysql::getIns();

   $db->query('insert', 'test', array('username'=>'周杰', 'money'=>'325464'));
   echo '<br />最后插入的id是'.$db->lastInsertId();

   /*
   echo '<br />test 表中的数据：<br />';
   $data = $db->query('select', 'test');
   echo '<pre>';
   print_r($data);
   echo '</pre>';
*/
   echo '<br />删除数据：<br />';
   echo  $db->query('delete', 'test', array('id'=>40));
   
   echo '<br />更新数据：<br />';
   $db->query('update', 'test', array('username'=>'周杰伦', 'money'=>999,'id'=>23));
   
   //echo '<br />查询所有数据：<br />';
   //$db->getAll('SELECT * FROM test WHERE username=:username AND id>:id', array('username'=>'周杰', 'id'=>53));
   
   echo '<br />查询一条数据:<br />:';
   $arr = $db->single('SELECT * FROM test WHERE username=:username AND id=:id', array('username'=>'周杰', 'id'=>53));
   print_r($arr);
   echo '<hr />';

/*   for ($i = 0; $i < 10000; $i++)
        Log::write("发不耐烦东北 发表方面发表麻烦了发表方面；能力烦恼悲愤难； 你悲愤难发奶粉呢烦恼发奶粉");
  */
 echo '<pre>';
    print_r($_SERVER);
 echo '</pre>'; 
 print_r($_GET);   
 
echo date('Y-m-d H:i:s');   
?> 
