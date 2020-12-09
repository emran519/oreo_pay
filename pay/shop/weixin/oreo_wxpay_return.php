<?php require_once('../../oreo/oreo.core.php'); ?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $conf['web_title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://css.letvcdn.com/lc04_yinyue/201612/19/20/00/bootstrap.min.css">
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<body background="https://ww2.sinaimg.cn/large/a15b4afegy1fpp139ax3wj200o00g073.jpg">
	 <div id="container" style="width:100%;height:100%;position: fixed;">
    <div id="anitOut"></div>
</div>
<?php 
require_once(SYSTEM_ROOT."oreo_static/pay/epay/yzf_wxpay.php");
require_once(SYSTEM_ROOT."oreo_static/pay/epay/epay_notify.class.php");

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

    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		$srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1")->fetch();
		if($srow['status']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
			$addmoney=$srow['money'];
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			echo '<form id="oreosubmit" name="oreosubmit" action="../../user/oreo_invoice.php" method="POST">
             <input type="hidden" name="adtime" value="'.$srow['addtime'].'"/>
             <input type="hidden" name="endtime" value="'.$date.'"/>
             <input type="hidden" name="status" value="1"/>
			 <input type="hidden" name="uids" value="'.$srow['pid'].'"/>
			 <input type="hidden" name="out_trade_no" value="'.$out_trade_no.'"/>
			 <input type="hidden" name="money" value="'.$_GET['money'].'"/>
			 <input type="submit" value="正在跳转,请勿关闭此页面"></form>
			 <script>document.forms["oreosubmit"].submit();</script>';
		}else{
			echo '<form id="oreosubmit" name="oreosubmit" action="../../user/oreo_invoice.php" method="POST">
             <input type="hidden" name="adtime" value="'.$srow['addtime'].'"/>
             <input type="hidden" name="endtime" value="'.$date.'"/>
             <input type="hidden" name="status" value="1"/>
			 <input type="hidden" name="uids" value="'.$srow['pid'].'"/>
			 <input type="hidden" name="out_trade_no" value="'.$out_trade_no.'"/>
			 <input type="hidden" name="money" value="'.$_GET['money'].'"/>
			 <input type="submit" value="正在跳转,请勿关闭此页面"></form>
			 <script>document.forms["oreosubmit"].submit();</script>';
		}
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
}
else {
    //验证失败
	echo '    <form id="oreosubmit" name="oreosubmit" action="../../user/oreo_invoice.php" method="POST">
             <input type="hidden" name="adtime" value="'.$srow['addtime'].'"/>
             <input type="hidden" name="endtime" value="'.$date.'"/>
             <input type="hidden" name="status" value="0"/>
			 <input type="hidden" name="uids" value="'.$srow['pid'].'"/>
			 <input type="hidden" name="out_trade_no" value="'.$out_trade_no.'"/>
			 <input type="hidden" name="money" value="'.$_GET['money'].'"/>
			 <input type="submit" value="正在跳转,请勿关闭此页面"></form>
			 <script>document.forms["oreosubmit"].submit();</script>';
}

?>
<script type="text/javascript">
            var second=5;
            var timer;
            function change()
            {
                second--;
              
             if(second>-1)
             {
                 document.getElementById("second").innerHTML=second;
                 timer = setTimeout('change()',1000);
             }
             else
             {
                 clearTimeout(timer);
             }
            }
            timer = setTimeout('change()',1000);
</script>
</body>
</html>