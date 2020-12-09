<?php
/* * 
 * 码支付同步通知页面
 */

require '../../oreo/Oreo.Cron.php';
require_once(SYSTEM_ROOT."oreo_function/pay/codepay/codepay_config.php");
ksort($_GET); //排序get参数
reset($_GET); //内部指针指向数组中的第一个元素
$sign = '';
foreach ($_GET AS $key => $val) {
    if ($val == '') continue;
    if ($key != 'sign') {
        if ($sign != '') {
            $sign .= "&";
            $urls .= "&";
        }
        $sign .= "$key=$val"; //拼接为url参数形式
        $urls .= "$key=" . urlencode($val); //拼接为url参数形式
    }
}
if (!$_GET['pay_no'] || md5($sign . $codepay_config['key']) != $_GET['sign']) { //不合法的数据 KEY密钥为你的密钥
    sysmsg('验证失败！');
} else { //合法的数据
    $out_trade_no = daddslashes($_GET['param']);
    //支付宝交易号
    $trade_no = daddslashes($_GET['pay_no']);

    $srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1 for update")->fetch();
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
		$url['return']='wxwap_ok.php';
	}else{
		$url=creat_callback($srow);
	}
    if($srow['status']==0){
        $DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
		processOrder($srow,false);

        echo '<script>window.location.href="'.$url['return'].'";</script>';
    }else{
		echo '<script>window.location.href="'.$url['return'].'";</script>';
    }
}
?>