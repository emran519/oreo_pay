<?php 
require_once('../../oreo/Oreo.Cron.php');
require_once(SYSTEM_ROOT."oreo_function/pay/svip/oreo_wxpay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/svip/svip_notify.class.php");

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
		$url=creat_callback($srow);
		$user=$DB->query("select * from oreo_user where id='{$srow['pid']}' limit 1")->fetch();
		if($srow['status']==1){
			echo '<script>window.location.href="'.$url['return'].'";</script>';
		}
		if($srow['status']==0 && $conf['chaojivip']==1&&$conf['ssvip_zt']==1&&$conf['ssvip_zdy']==1&&$user['ssvip']==1&&$conf['ssvip_wx']!=777){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',`lxtype` ='$oreo_lxknum',`svip` ='1' where `trade_no`='$out_trade_no'");
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}' where oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			$addmoney=round($srow['money']*$conf['ssvip_wx']/100,2);
			if($conf['oreo_lx']==1&&$alilxzzcx['oreo_lxfs']==2){
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}', oreo_lrje=oreo_lrje+{$addmoney} where oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			}
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			echo '<script>window.location.href="'.$url['return'].'";</script>';
		} 
      if($srow['status']==0 && $conf['sw_money_rate']==0 && $user['zdyfl']==0 && $conf['ssvip_wx']==777 || $conf['ssvip_zdy']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',`lxtype` ='$oreo_lxknum',`svip` ='1' where `trade_no`='$out_trade_no'");
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}' where oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			$addmoney=round($srow['money']*$conf['money_rate']/100,2);
			if($conf['oreo_lx']==1&&$alilxzzcx['oreo_lxfs']==2){
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}', oreo_lrje=oreo_lrje+{$addmoney} where oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			}
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			echo '<script>window.location.href="'.$url['return'].'";</script>';
		} 
		if($srow['status']==0 && $conf['sw_money_rate']==0 && $user['zdyfl']==1 && $conf['ssvip_wx']==777 || $conf['ssvip_zdy']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',`lxtype` ='$oreo_lxknum',`svip` ='1' where `trade_no`='$out_trade_no'");
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}' where oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			$addmoney=round($srow['money']*$user['rate']/100,2);
			if($conf['oreo_lx']==1&&$alilxzzcx['oreo_lxfs']==2){
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}', oreo_lrje=oreo_lrje+{$addmoney} where oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			}
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			echo '<script>window.location.href="'.$url['return'].'";</script>';
		}
        if($srow['status']==0 && $conf['sw_money_rate']==1 && $user['zdyfl']==0 && $conf['ssvip_wx']==777 || $conf['ssvip_zdy']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',`lxtype` ='$oreo_lxknum',`svip` ='1' where `trade_no`='$out_trade_no'");
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}' where oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			$addmoney=round($srow['money']*$conf['weixin_rate']/100,2);
			if($conf['oreo_lx']==1&&$alilxzzcx['oreo_lxfs']==2){
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}', oreo_lrje=oreo_lrje+{$addmoney} where oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			}
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			echo '<script>window.location.href="'.$url['return'].'";</script>';
		}
		if($srow['status']==0 && $conf['sw_money_rate']==1 && $user['zdyfl']==1 && $conf['ssvip_wx']==777 || $conf['ssvip_zdy']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',`lxtype` ='$oreo_lxknum',`svip` ='1' where `trade_no`='$out_trade_no'");
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}' where oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			$addmoney=round($srow['money']*$user['sweixin_rate']/100,2);
			if($conf['oreo_lx']==1&&$alilxzzcx['oreo_lxfs']==2){
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}', oreo_lrje=oreo_lrje+{$addmoney} where oreo_lxname='4' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			}
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			echo '<script>window.location.href="'.$url['return'].'";</script>';
		}
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
}
else {
    //验证失败
	echo('验证失败！');
}

?>
