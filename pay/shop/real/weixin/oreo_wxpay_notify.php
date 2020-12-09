<?php 
require_once('../../../../oreo/Oreo.Cron.php');
require_once(SYSTEM_ROOT."oreo_function/pay/shoppay/oreo_shop_wxpay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/shoppay/oreo_shop_notify.class.php");
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();
if($verify_result) {//验证成功
	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];
	//支付宝交易号
	$trade_no = $_GET['trade_no'];
	//交易状态
	$trade_status = $_GET['trade_status'];
	//买家支付宝
	$buyer_email = $_GET['buyer_email'];
	$srow=$DB->query("SELECT * FROM oreo_shop_details_real WHERE trade_no='{$out_trade_no}' limit 1 for update")->fetch();
      if ($_GET['trade_status'] == 'TRADE_SUCCESS' || $_GET['trade_status'] == 'TRADE_FINISHED') {
		 if($srow['status']==0){
			$DB->query("update `oreo_shop_details_real` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
			$addmoney=$srow['money'];
			$DB->query("update oreo_shop_user set frozen_balance=frozen_balance+{$addmoney} where username='{$srow['username']}' and shid='{$srow['pid']}'");
           die;
		}
    }
	echo "success";
}
else {
    //验证失败
	echo "fail";
}
?>