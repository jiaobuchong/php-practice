<?php
    /*所有由用户直接访问到的这些页面都得首先加载init.php*/ 
    require('./include/init.php');
    echo ROOT, '<br />';
    $conf = Conf::getIns();
    var_dump($conf);
    echo $conf->host, $conf->user, $conf->pwd;
    echo '<br />';
    $conf->template_dir = './www/smarty';
    echo $conf->template_dir;
    echo '<br />';
    echo '<hr />';

/*    for ($i = 0; $i < 10000; $i++)
        Log::write("发不耐烦东北 发表方面发表麻烦了发表方面；能力烦恼悲愤难； 你悲愤难发奶粉呢烦恼发奶粉");
  */
 print_r($_GET);   
    
?> 
