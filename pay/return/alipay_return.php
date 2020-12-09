<?php
require_once('../../oreo/Oreo.Cron.php');
require_once(SYSTEM_ROOT."oreo_function/pay/alipay/alipay.config.php");
require_once(SYSTEM_ROOT."oreo_function/pay/alipay/alipay_notify.class.php");
@header('Content-Type: text/html; charset=UTF-8');
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {
	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];

	//买家支付宝
	$buyer_email = $_GET['buyer_email'];

	$srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1")->fetch();

    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		$url=creat_callback($srow);

		if($srow['status']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',`buyer` ='$buyer_email' where `trade_no`='$out_trade_no'");
			processOrder($srow);
			echo '<script>window.location.href="'.$url['return'].'";</script>';
		}else{
			echo '<script>window.location.href="'.$url['return'].'";</script>';
		}
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
}
else {
    //验证失败
	sysmsg('支付宝返回验证失败！');
}

?>