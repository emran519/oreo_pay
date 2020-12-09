<?php
/*易商户支付配置*/
$protocol = (int)$_SERVER['SERVER_PORT'] == 80 ? 'http://'.$_SERVER['HTTP_HOST'] : 'https://'.$_SERVER['HTTP_HOST'];
return [
    'app_key' => $conf['oreo_eshanghu_api_key_wx'] ,
    'app_secret' => $conf['oreo_eshanghu_api_secret_wx'] ,
    'sub_mch_id' => $conf['oreo_eshanghu_api_id_wx'] ,
    'notify' => $protocol.'/pay/eshanghu/eshanghu_notify.php', 
];
?>