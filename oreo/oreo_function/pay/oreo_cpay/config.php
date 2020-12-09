<?php
/*Oreo扫码付配置*/
$protocol = (int)$_SERVER['SERVER_PORT'] == 80 ? 'http://'.$_SERVER['HTTP_HOST'] : 'https://'.$_SERVER['HTTP_HOST'];
$oreo_cpay=array(
    'app_key' => $conf['oreo_cpay_appkey'], //数据库服务器
    'app_id' =>  $conf['oreo_cpay_appid'],//数据库端口
    'notify' => $protocol.'/pay/oreocpay/cpay_notify.php',//异步地址
    'return' => $protocol.'/pay/oreocpay/cpay_return.php'//同步步地址
);
?>