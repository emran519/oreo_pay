<?php
/* *
 * 支付宝当面付异步通知页面
 */

require_once('../../oreo/Oreo.Cron.php');
require_once(SYSTEM_ROOT."oreo_function/pay/f2fpay/config.php");
require_once(SYSTEM_ROOT."oreo_function/pay/f2fpay/AlipayTradeService.php");

//计算得出通知验证结果
$alipaySevice = new AlipayTradeService($config); 
//$alipaySevice->writeLog(var_export($_POST,true));
$verify_result = $alipaySevice->check($_POST);

if($verify_result) {//验证成功
	//商户订单号

	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号

	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];

	//买家支付宝
	$buyer_id = $_POST['buyer_id'];

    $srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1 for update")->fetch();
    $user=$DB->query("select * from oreo_user where id='{$srow['pid']}' limit 1")->fetch();
      if ($_GET['trade_status'] == 'TRADE_FINISHED' ||  $_POST['trade_status'] == 'TRADE_SUCCESS') {
		 if($srow['status']==0 && $conf['sw_money_rate']==0 && $user['zdyfl']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',`buyer` ='$buyer_id' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$conf['money_rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
		    do_notify($url['notify']);
		}
	      if($srow['status']==0 && $conf['sw_money_rate']==0 && $user['zdyfl']==1){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',`buyer` ='$buyer_id' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$user['rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
		    do_notify($url['notify']);
		}
	      if($srow['status']==0 && $conf['sw_money_rate']==1 && $user['zdyfl']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',`buyer` ='$buyer_id' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$conf['alipay_rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
		    do_notify($url['notify']);
		}	
	      if($srow['status']==0 && $conf['sw_money_rate']==1 && $user['zdyfl']==1){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',`buyer` ='$buyer_id' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$user['salipay_rate']/100,2);
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
		    do_notify($url['notify']);
		}

    }

	echo "success";

}else {
    //验证失败
    echo "fail";
}
?>