<?php
@header('Content-Type: application/json; charset=UTF-8');
require '../oreo/Oreo.Cron.php';

$trade_no=isset($_GET['trade_no'])?daddslashes($_GET['trade_no']):exit('No trade_no!');


$row=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
if($row['status']>=1){
	$url=creat_callback($row);
	exit('{"code":1,"msg":"付款成功","backurl":"'.$url['return'].'"}');
}else{
	exit('{"code":-1,"msg":"未付款"}');
}

?>