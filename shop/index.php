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
?> 
