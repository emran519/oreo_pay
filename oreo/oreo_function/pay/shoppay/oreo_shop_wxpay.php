<?php
$alipay_config['partner']		= $conf['wx_epay_api_id'];
$alipay_config['key']			= $conf['wx_epay_api_key'];
$alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['input_charset']= strtolower('utf-8');
$alipay_config['transport']    = 'http';
$alipay_config['apiurl']    = $conf['wx_epay_api_url'];
?>