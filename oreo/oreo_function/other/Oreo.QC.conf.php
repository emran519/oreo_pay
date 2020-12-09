<?php
include "../../Oreo.Config.php";
?>
<?php
try {
    $DB = new PDO("mysql:host={$oreoconfig['host']};dbname={$oreoconfig['dbname']};port={$oreoconfig['port']}",$oreoconfig['user'],$oreoconfig['pwd']);
}catch(Exception $e){
    exit('链接数据库失败:'.$e->getMessage());
}
$DB->exec("set names utf8");
$rs=$DB->query("select * from oreo_config");
while($row=$rs->fetch()){ 
	$conf[$row['k']]=$row['v'];
}
/**
 * 请到 http://connect.opensns.qq.com/申请appid, appkey, 并注册callback地址：http://你的域名/user/connect.php
 */
//申请到的appid
$QC_config["appid"]  = $conf['qopen_id'];

//申请到的appkey
$QC_config["appkey"] =  $conf['qopen_key'];

//callback url
$QC_config["callback"] =  'http://'.$conf['local_domain'].'/user/connect.php';
?>