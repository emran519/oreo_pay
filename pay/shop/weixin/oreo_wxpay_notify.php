<?php 
require_once('../../oreo/oreo.core.php');
require_once(SYSTEM_ROOT."oreo_static/pay/epay/yzf_wxpay.php");
require_once(SYSTEM_ROOT."oreo_static/pay/epay/epay_notify.class.php");

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

    //交易金额
	$buyer_email = $_GET['total_fee'];
   
    if ($_GET['trade_status'] == 'TRADE_SUCCESS' && $srow['status']==0) {
		//付款完成后，支付宝系统发送该交易状态通知
		$srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1")->fetch();
      if($srow['status']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',`buyer` ='$buyer_email' where `trade_no`='$out_trade_no'");
			$addmoney=$srow['money'];
		    $DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
		}
    }
	echo "success";
}
else {
    //验证失败
    echo "fail";
}

?>
