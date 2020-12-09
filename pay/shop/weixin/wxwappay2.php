<?php
$is_defend=true;
require '../../oreo/oreo.core.php';

@header('Content-Type: text/html; charset=UTF-8');

$trade_no=daddslashes($_GET['trade_no']);
$sitename=base64_decode(daddslashes($_GET['sitename']));
$row=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
if(!$row)sysmsg('该订单号不存在，请返回来源地重新发起请求！');

if(isset($_GET['type']))$DB->query("update `oreo_order` set `type` ='wxpay',`addtime` ='$date' where `trade_no`='$trade_no'");

$name = $conf['order_name'];
require_once SYSTEM_ROOT."oreo_static/pay/wxpay/WxPay.Api.php";
require_once SYSTEM_ROOT."oreo_static/pay/wxpay/WxPay.NativePay.php";
$notify = new NativePay();
$input = new WxPayUnifiedOrder();
$input->SetBody($name);
$input->SetOut_trade_no($trade_no);
$input->SetTotal_fee($row['money']*100);
$input->SetSpbill_create_ip($clientip);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetNotify_url($oreoport.'/wxpay_notify.php');
$input->SetTrade_type("MWEB");
$result = $notify->GetPayUrl($input);
if($result["result_code"]=='SUCCESS'){
	$redirect_url=$oreoport.'/pay/weixin/wxwap_return.php?trade_no='.$trade_no;
	$url=$result['mweb_url'].'&redirect_url='.urlencode($redirect_url);
	exit("<script>window.location.replace('{$url}');</script>");
}else{
	sysmsg('微信支付下单失败！['.$result["err_code"].'] '.$result["err_code_des"]);
}

?>