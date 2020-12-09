<?php
$lxnull=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='4' AND oreo_lxtype='1' ")->fetch();
if($conf['oreo_lx']==1&&$lxnull){	
$alilxddcx=$DB->query("select * from oreo_order WHERE status='1' AND type='qqpay' AND svip='1' AND DATE_FORMAT(endtime,'%y-%m-%d')=DATE_FORMAT(now(),'%y-%m-%d') order by endtime desc limit 1")->fetch();
$lxtype=$alilxddcx['lxtype'];
$alilxzzcx=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='4' AND oreo_lxtype='1' ")->fetch();
if($alilxzzcx){
$cxlxdid=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxknum='$lxtype'")->fetch();
$llid=$cxlxdid['id'];
$alilxzzcx=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='4' AND oreo_lxtype='1' AND id>'$llid' limit 1 ")->fetch();
if(!$alilxzzcx){
$alilxzzcx=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='4' AND oreo_lxtype='1' order by id asc limit 1 ")->fetch();
}
}
if($alilxzzcx['oreo_lxfs']==2){
$alilxzzcx=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxje>=oreo_lrje limit 1  ")->fetch();
}	
$oreo_lxknum = random(8);
$lxurl=$alilxzzcx['oreo_lxurl'];
if($alilxzzcx['oreo_lxfs']==1&&$alilxzzcx['oreo_lxname']==4||$alilxzzcx['oreo_lxname']==5){
$alipay_config['partner']		= $alilxzzcx['oreo_lxid'];
$alipay_config['key']			= $alilxzzcx['oreo_lxkey'];
$alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['input_charset']= strtolower('utf-8');
$alipay_config['transport']    = 'http';
$alipay_config['apiurl']    = $alilxzzcx['oreo_lxurl'];
}
else if($conf['oreo_lx']!=0&&$alilxzzcx['oreo_lxname']==4||$alilxzzcx['oreo_lxname']==5){
$lxjecx=$DB->query("select sum(money) from oreo_order where status='1' and type='qqpay' and DATE_FORMAT(endtime,'%y-%m-%d')=DATE_FORMAT(now(),'%y-%m-%d') ")->fetch();
$lxmonet=$lxcx['sum(money)']; 
$alipay_config['partner']		= $alilxzzcx['oreo_lxid'];
$alipay_config['key']			= $alilxzzcx['oreo_lxkey'];
$alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['input_charset']= strtolower('utf-8');
$alipay_config['transport']    = 'http';
$alipay_config['apiurl']    = $alilxzzcx['oreo_lxurl'];
}
else{
$alipay_config['partner']		= $conf['ssvip_id'];
$alipay_config['key']			= $conf['ssvip_key'];
$alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['input_charset']= strtolower('utf-8');
$alipay_config['transport']    = 'http';
$alipay_config['apiurl']    = $conf['ssvip_url'];
}
}
else{
$alipay_config['partner']		= $conf['ssvip_id'];
$alipay_config['key']			= $conf['ssvip_key'];
$alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['input_charset']= strtolower('utf-8');
$alipay_config['transport']    = 'http';
$alipay_config['apiurl']    = $conf['ssvip_url'];
}
?>