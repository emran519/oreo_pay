<?php
require_once SYSTEM_ROOT.'oreo_function/plugin/oreo_shop_pay_real.php';
$oreo_auth_shop_real_pay=oreo_shop_user_real($oreo_this_user);
$data = json_decode($oreo_auth_shop_real_pay, true);  //解析获取的Json
$shop_pay_token=$data['token'];//返回Token
$alipay_config['partner']		= $oreo_this_user;
$alipay_config['key']			= $shop_pay_token;
$alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['input_charset']= strtolower('utf-8');
$alipay_config['transport']    = 'https';
$alipay_config['apiurl']    = 'https://www.oreopay.com/';
?>