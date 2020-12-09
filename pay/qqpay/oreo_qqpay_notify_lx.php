<?php 
require_once('../../oreo/Oreo.Cron.php');
require_once(SYSTEM_ROOT."oreo_function/pay/epay/yzf_qqpay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/epay/epay_notify.class.php");
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

    if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		//付款完成后，支付宝系统发送该交易状态通知
	  $srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1")->fetch();
	  $user=$DB->query("select * from oreo_user where id='{$srow['pid']}' limit 1")->fetch();
	  if($srow['status']==0){
      if($conf['sw_money_rate']==0 && $user['zdyfl']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',lxtype='$oreo_lxknum' where `trade_no`='$out_trade_no'");
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}' where oreo_lxname='3' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			$addmoney=round($srow['money']*$conf['money_rate']/100,2);
			if($conf['oreo_lx']==1&&$alilxzzcx['oreo_lxfs']==2){
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}', oreo_lrje=oreo_lrje+{$addmoney} where oreo_lxname='3' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			}
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
			curl_get($url['notify']);
			proxy_get($url['notify']);
		}
	  if($conf['sw_money_rate']==0 && $user['zdyfl']==1){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',lxtype='$oreo_lxknum' where `trade_no`='$out_trade_no'");
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}' where oreo_lxname='3' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			$addmoney=round($srow['money']*$user['rate']/100,2);
			if($conf['oreo_lx']==1&&$alilxzzcx['oreo_lxfs']==2){
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}', oreo_lrje=oreo_lrje+{$addmoney} where oreo_lxname='3' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			}
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
			curl_get($url['notify']);
			proxy_get($url['notify']);
		}
	  if($conf['sw_money_rate']==1 && $user['zdyfl']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',lxtype='$oreo_lxknum' where `trade_no`='$out_trade_no'");
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}' where oreo_lxname='3' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			$addmoney=round($srow['money']*$conf['qq_rate']/100,2);
			if($conf['oreo_lx']==1&&$alilxzzcx['oreo_lxfs']==2){
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}', oreo_lrje=oreo_lrje+{$addmoney} where oreo_lxname='3' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			}
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
			curl_get($url['notify']);
			proxy_get($url['notify']);
		}	
	   if($conf['sw_money_rate']==1 && $user['zdyfl']==1){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date',lxtype='$oreo_lxknum' where `trade_no`='$out_trade_no'");
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}' where oreo_lxname='3' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			$addmoney=round($srow['money']*$user['sqq_rate']/100,2);
			if($conf['oreo_lx']==1&&$alilxzzcx['oreo_lxfs']==2){
			$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxknum` ='{$oreo_lxknum}', oreo_lrje=oreo_lrje+{$addmoney} where oreo_lxname='3' AND oreo_lxtype='1' AND oreo_lxurl='$lxurl'");
			}
			$DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
			curl_get($url['notify']);
			proxy_get($url['notify']);
		}
    }
 }
	echo "success";
}
else {
    //验证失败
    echo "fail";
}
?>