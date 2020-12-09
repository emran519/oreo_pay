<?php
/* *
 * 码支付异步通知页面
 */

require '../../oreo/Oreo.Cron.php';
require_once(SYSTEM_ROOT."oreo_function/pay/codepay/codepay_config.php");
ksort($_POST); //排序post参数
reset($_POST); //内部指针指向数组中的第一个元素
$sign = '';
foreach ($_POST AS $key => $val) {
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

if (!$_POST['pay_no'] || md5($sign . $codepay_config['key']) != $_POST['sign']) { //不合法的数据 KEY密钥为你的密钥
    exit('fail');
} else { //合法的数据

    $out_trade_no = daddslashes($_POST['param']);

    //支付宝交易号
    $trade_no = daddslashes($_POST['pay_no']);

    $srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1 for update")->fetch();
    if($srow['status']==0) {
		$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
		processOrder($srow);
    }
    exit('success');
}

?>