<?php
require_once('../oreo/Oreo.Cron.php');
//计算得出通知验证结果
	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];
	//支付宝交易号
	$trade_no = $_GET['trade_no'];
	//交易状态
	$trade_status = $_GET['trade_status'];
    if($_GET['trade_status'] == 'TRADE_SUCCESS') {
		$srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1")->fetch();
		$url=creat_callback($srow);
		if($srow['status']==0){
			echo '订单未付款成功';
		}
		else if($srow['status']==1){
			echo '<script>window.location.href="'.$url['return'].'";</script>';
		}
	     }	  
    	else{
			echo('订单有异常，Oreo拦击异常订单');
		}   
?>