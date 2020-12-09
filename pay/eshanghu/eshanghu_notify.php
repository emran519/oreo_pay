<?php 
require_once('../../oreo/Oreo.Cron.php');
require(SYSTEM_ROOT.'oreo_function/pay/eshanghu/Signer.php');
require(SYSTEM_ROOT.'oreo_function/pay/eshanghu/Eshanghu.php');
$pay_config = require(SYSTEM_ROOT.'oreo_function/pay/eshanghu/config.php');

$pay = new Eshanghu($pay_config);

if($pay->checkSign($_POST)){
	
	if($_POST['status'] == 9){
		$out_trade_no = daddslashes($_POST['out_trade_no']);
		$order_sn = $_POST['order_sn'];
		$total_fee = $_POST['total_fee'];
		$srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1 for update")->fetch();
			if($srow['status']==0 && $conf['sw_money_rate']==0 && $user['zdyfl']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$conf['money_rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
			curl_get($url['notify']);
			proxy_get($url['notify']);
		}
		 if($srow['status']==0 && $conf['sw_money_rate']==0 && $user['zdyfl']==1){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$user['rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
			curl_get($url['notify']);
			proxy_get($url['notify']);
		}
	  if($srow['status']==0 && $conf['sw_money_rate']==1 && $user['zdyfl']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$conf['weixin_rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
			curl_get($url['notify']);
			proxy_get($url['notify']);
		}	
	   if($srow['status']==0 && $conf['sw_money_rate']==1 && $user['zdyfl']==1){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$user['sweixin_rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
			curl_get($url['notify']);
			proxy_get($url['notify']);
		}
		echo 'success';
	}else{
		echo 'fail';
	}
}else{
	echo 'fail';
}
?>