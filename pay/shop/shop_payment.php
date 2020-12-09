<?php
require '../../oreo/Oreo.Cron.php';
@header('Content-Type: text/html; charset=UTF-8');
//判断付款方式
if($_POST['payment']=='alipay'){
$type = 'alipay';
}if($_POST['payment']=='wxpay'){
$type = 'wxpay';
}if($_POST['payment']=='qqpay'){
$type = 'qqpay';
}
$oreoport = (int)$_SERVER['SERVER_PORT'] == 80 ? 'http://'.$_SERVER['HTTP_HOST'] : 'https://'.$_SERVER['HTTP_HOST'];
$order_text = $_POST['order_text'];//订单备注
$trade_no = $_POST['order_num'];//订单号
$shid = $_POST['shid'];//订单号
$oreotype = $_POST['oreotype'];//订单类型
if($oreotype=='newreal'){
	$alipay_notify='/pay/shop/real/alipay/oreo_alipay_notify.php';
	$alipay__return='/pay/shop/real/alipay/oreo_alipay_return.php';
	$wxpay_notify='/pay/shop/real/weixin/oreo_wxpay_notify.php';
	$wxpay__return='/pay/shop/real/weixin/oreo_wxpay_return.php';
	$qqpay_notify='/pay/shop/real/qqpay/oreo_qqpay_notify.php';
	$qqpay__return='/pay/shop/real/qqpay/oreo_qqpay_return.php';
}else{
	$alipay_notify='/pay/shop/alipay/oreo_alipay_notify.php';
	$alipay__return='/pay/shop/alipay/oreo_alipay_return.php';
	$wxpay_notify='/pay/shop/weixin/oreo_wxpay_notify.php';
	$wxpay__return='/pay/shop/weixin/oreo_wxpay_return.php';
	$qqpay_notify='/pay/shop/qqpay/oreo_qqpay_notify.php';
	$qqpay__return='/pay/shop/qqpay/oreo_qqpay_return.php';
}
$sitename=urlencode(base64_encode(daddslashes($queryArr['sitename'])));
$row=$DB->query("SELECT * FROM oreo_shop_details_real WHERE trade_no='{$trade_no}' limit 1")->fetch();
if(!$row)sysmsg('系统找不到您的订单信息');
if($row['status']==1)sysmsg('该订单已付款');
$DB->exec("update `oreo_shop_details_real` set  payment_method='$type' where trade_no='{$trade_no}' ");
if(!$type)sysmsg('付款方式不能为空.');
if($type=='alipay'){
require_once(SYSTEM_ROOT."oreo_function/pay/shoppay/oreo_shop_alipay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/shoppay/oreo_shop_submit.class.php");
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type, 
	"notify_url"	=> $oreoport.$alipay_notify,
	"return_url"	=> $oreoport.$alipay__return,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['order_name'],
	"username"	=> $row['username'],
	"shid"	=> $shid,
	"money"	=> $row['money']
);
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
}
if($type=='wxpay'){	
	require_once(SYSTEM_ROOT."oreo_function/pay/shoppay/oreo_shop_alipay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/shoppay/oreo_shop_submit.class.php");
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.$wxpay_notify,
	"return_url"	=> $oreoport.$wxpay__return,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['order_name'],
	"username"	=> $row['username'],
	"shid"	=> $shid,
	"money"	=> $row['money']
);
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
}
if($type=='qqpay'){	
	require_once(SYSTEM_ROOT."oreo_function/pay/shoppay/oreo_shop_alipay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/shoppay/oreo_shop_submit.class.php");
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.$qqpay_notify,
	"return_url"	=> $oreoport.$qqpay__return,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['order_name'],
	"username"	=> $row['username'],
	"shid"	=> $shid,
	"money"	=> $row['money']
);
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
}
?>
</body>
</html>