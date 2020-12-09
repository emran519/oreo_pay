<?php

//---------------------------------------------------------
//财付通即时到帐支付后台回调示例，商户按照此文档进行开发即可
//---------------------------------------------------------
require_once('../../oreo/Oreo.Cron.php');
require_once(SYSTEM_ROOT.'oreo_function/pay/qqpay/qpayNotify.class.php');
@header('Content-Type: text/html; charset=UTF-8');

$qpayNotify = new QpayNotify();
$result = $qpayNotify->getParams();
//判断签名
if($qpayNotify->verifySign()) {

//判断签名及结果（即时到帐）
	if($result['trade_state'] == "SUCCESS") {
		//商户订单号
		$out_trade_no = $result['out_trade_no'];
		//QQ钱包订单号
		$transaction_id = $result['transaction_id'];
		//金额,以分为单位
		$total_fee = $result['total_fee'];
		//币种
		$fee_type = $result['fee_type'];

		//------------------------------
		//处理业务开始
		//------------------------------
		$srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1")->fetch();
		$user=$DB->query("select * from oreo_user where id='{$srow['pid']}' limit 1")->fetch();
		if($srow['status']==0){
		if($conf['sw_money_rate']==0 && $user['zdyfl']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$conf['money_rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
		}
	      if($conf['sw_money_rate']==0 && $user['zdyfl']==1){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$user['rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
		}
	      if($conf['sw_money_rate']==1 && $user['zdyfl']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$conf['qq_rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
		}	
	      if($conf['sw_money_rate']==1 && $user['zdyfl']==1){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$user['sqq_rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
		}
		}
		//------------------------------
		//处理业务完毕
		//------------------------------
		echo "<xml>
<return_code>SUCCESS</return_code>
</xml>";
	} else {
		echo "<xml>
<return_code>FAIL</return_code>
</xml>";
	}

} else {
	//回调签名错误
	echo "<xml>
<return_code>FAIL</return_code>
<return_msg>签名失败</return_msg>
</xml>";
} 

?>