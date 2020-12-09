<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>正在为您跳转到支付页面，请稍候...</title>
    <style type="text/css">
        body {margin:0;padding:0;}
        p {position:absolute;
            left:50%;top:50%;
            width:330px;height:30px;
            margin:-35px 0 0 -160px;
            padding:20px;font:bold 14px/30px "宋体", Arial;
            background:#f9fafc url(../images/loading.gif) no-repeat 20px 26px;
            text-indent:22px;border:1px solid #c5d0dc;}
        #waiting {font-family:Arial;}
    </style>
<script>
function open_without_referrer(link){
document.body.appendChild(document.createElement('iframe')).src='javascript:"<script>top.location.replace(\''+link+'\')<\/script>"';
}
</script>
</head>
<body>
<?php
$oreoport = (int)$_SERVER['SERVER_PORT'] == 80 ? 'http://'.$_SERVER['HTTP_HOST'] : 'https://'.$_SERVER['HTTP_HOST'];
require '../oreo/Oreo.Cron.php';
@header('Content-Type: text/html; charset=UTF-8');
$type=daddslashes($_GET['type']);
$trade_no=daddslashes($_GET['trade_no']);
$row=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
if(!$row)sysmsg('该订单号不存在，请返回来源地重新发起请求！');
if(!$type)sysmsg('参数错误');
$DB->query("update `oreo_order` set `type` ='$type',`addtime` ='$date' where `trade_no`='$trade_no'");
if($conf['oreo_return']==1){
$oreo_return_ali_s='return/oreo_salipay_return.php';
$oreo_return_ali_sl='return/oreo_salipay_return_lx.php';
$oreo_return_wx_s='return/oreo_swxpay_return.php';
$oreo_return_wx_sl='return/oreo_swxpay_return_lx.php';
$oreo_return_qq_s='return/oreo_sqqpay_return.php';
$oreo_return_qq_sl='return/oreo_sqqpay_return_lx.php';
$oreo_return_ali='return/oreo_alipay_return.php';
$oreo_return_alil='return/oreo_alipay_return_lx.php';
$oreo_return_wx='return/oreo_wxpay_return.php';
$oreo_return_wxl='return/oreo_wxpay_return_lx.php';
$oreo_return_qq='return/oreo_qqpay_return.php';
$oreo_return_qql='return/oreo_qqpay_return_lx.php';
}else{
$oreo_return_ali_s='oreo_return.php';	
$oreo_return_ali_sl='oreo_return.php';
$oreo_return_wx_s='oreo_return.php';	
$oreo_return_wx_sl='oreo_return.php';	
$oreo_return_qq_s='oreo_return.php';	
$oreo_return_qq_sl='oreo_return.php';
$oreo_return_ali='oreo_return.php';
$oreo_return_wx='oreo_return.php';
$oreo_return_qq='oreo_return.php';
$oreo_return_alil='oreo_return.php';
$oreo_return_wxl='oreo_return.php';
$oreo_return_qql='oreo_return.php';
}
if($type=='alipay'){
$userpid=$DB->query("select pid from oreo_order where trade_no='{$trade_no}' limit 1")->fetch();
$userali=round($userpid['pid']);
$usernum=$DB->query("select ssvip from oreo_user where id='{$userali}' limit 1")->fetch();
$ljarr = explode("|", $conf['goods_lj']);
foreach ($ljarr as $k => $v) {
    if (strexists($name, $v)) {
        sysmsg($conf['goods_ljtis']);
        exit;
    }
}
$lxnullsa=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='4' AND oreo_lxtype='1' ")->fetch();
if($conf['chaojivip']==1&&$conf['ssvip_zt']==1&&$conf['ssvip_ali']!=777&&$usernum['ssvip']==1){
require_once(SYSTEM_ROOT."oreo_function/pay/svip/oreo_alipay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/svip/oreo_submit.class.php");
if($conf['oreo_lx']==1&&$lxnullsa){
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/svip/alipay/oreo_alipay_notify_lx.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_ali_sl,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}else{
	$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/svip/alipay/oreo_alipay_notify.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_ali_s,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
}
if($conf['alipay_mode']==0){
echo "
支付宝接口关闭";
}
$userpid=$DB->query("select pid from oreo_order where trade_no='{$trade_no}' limit 1")->fetch();
$userali=round($userpid['pid']);
$usernum=$DB->query("select alipay from oreo_user where id='{$userali}' limit 1")->fetch();
if($usernum['alipay']!=1){
echo<<<HTML
<!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>站点提示信息</title>
        <style type="text/css">
html{background:#eee}body{background:#fff;color:#333;font-family:"微软雅黑","Microsoft YaHei",sans-serif;margin:2em auto;padding:1em 2em;max-width:700px;-webkit-box-shadow:10px 10px 10px rgba(0,0,0,.13);box-shadow:10px 10px 10px rgba(0,0,0,.13);opacity:.8}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px "微软雅黑","Microsoft YaHei",,sans-serif;margin:30px 0 0 0;padding:0;padding-bottom:7px}#error-page{margin-top:50px}h3{text-align:center}#error-page p{font-size:9px;line-height:1.5;margin:25px 0 20px}#error-page code{font-family:Consolas,Monaco,monospace}ul li{margin-bottom:10px;font-size:9px}a{color:#21759B;text-decoration:none;margin-top:-10px}a:hover{color:#D54E21}.button{background:#f7f7f7;border:1px solid #ccc;color:#555;display:inline-block;text-decoration:none;font-size:9px;line-height:26px;height:28px;margin:0;padding:0 10px 1px;cursor:pointer;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top}.button.button-large{height:29px;line-height:28px;padding:0 12px}.button:focus,.button:hover{background:#fafafa;border-color:#999;color:#222}.button:focus{-webkit-box-shadow:1px 1px 1px rgba(0,0,0,.2);box-shadow:1px 1px 1px rgba(0,0,0,.2)}.button:active{background:#eee;border-color:#999;color:#333;-webkit-box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5);box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5)}table{table-layout:auto;border:1px solid #333;empty-cells:show;border-collapse:collapse}th{padding:4px;border:1px solid #333;overflow:hidden;color:#333;background:#eee}td{padding:4px;border:1px solid #333;overflow:hidden;color:#333}
        </style>
    </head>
    <body id="error-page">
       <h3>站点提示信息</h3>
        <a>您没有开通支付宝通道使用权限，若有需要请到 商户中心-开通接口处 在线开通有关权限</a>
    </body>
    </html>
HTML;
exit;
}
if($conf['alipay_mode']==1){
	require_once(SYSTEM_ROOT."oreo_function/pay/alipay/alipay.config.php");
	require_once(SYSTEM_ROOT."oreo_function/pay/alipay/alipay_submit.class.php");
	//构造要请求的参数数组，无需改动
	if(checkmobile()==true){
		$alipay_service = "alipay.wap.create.direct.pay.by.user";
	}else{
		$alipay_service = "create_direct_pay_by_user";
	}
	$parameter = array(
		"service" => $alipay_service,
		"partner" => trim($alipay_config['partner']), //合作身份者id
		"seller_id" => trim($alipay_config['partner']), //收款支付宝用户号
		"payment_type"	=> "1", //支付方式
		"notify_url"	=> $oreoport.'/pay/alipay/alipay_notify.php', //服务器异步通知页面路径
		"return_url"	=> $oreoport.'/pay/oreo_return.php', //页面跳转同步通知页面路径
		"out_trade_no"	=> $trade_no, //商户订单号
		"subject"	=> $row['name'], //订单名称
		"total_fee"	=> $row['money'], //付款金额
		"_input_charset"	=> strtolower('utf-8')
	);
	if(checkmobile()==true){
		$parameter['app_pay'] = "Y";
	}
	//建立请求
	$alipaySubmit = new AlipaySubmit($alipay_config);
	$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "正在跳转");
	echo $html_text;
}
$lxnulla=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='1' AND oreo_lxtype='1' ")->fetch();
if($conf['alipay_mode']==2){
require_once(SYSTEM_ROOT."oreo_function/pay/epay/yzf_alipay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/epay/epay_submit.class.php");
if($conf['oreo_lx']==1&&$lxnulla){
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/alipay/oreo_alipay_notify_lx.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_alil,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}else{
	$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/alipay/oreo_alipay_notify.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_ali,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
}
if($conf['alipay_mode']==3){
	echo "<script>window.location.href='./codepay/codepay.php?trade_no={$trade_no}&type=alipay&sitename={$sitename}';</script>";
}
 if($conf['alipay_mode'] == 4) {
        echo "<script>window.location.href='./alipay/alipay.php?trade_no={$trade_no}&type={$type}&name={$name}&money={$money}&sitename={$sitename}';</script>";
    }
if($conf['alipay_mode'] == 5) {
    echo "<script>window.location.href='./oreocpay/pay.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
}
}
if($type=='wxpay'){
$userpid=$DB->query("select pid from oreo_order where trade_no='{$trade_no}' limit 1")->fetch();
$userali=round($userpid['pid']);
$usernum=$DB->query("select ssvip from oreo_user where id='{$userali}' limit 1")->fetch();	
$lxnullsw=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='4' AND oreo_lxtype='1' ")->fetch();
if($conf['chaojivip']==1&& $conf['ssvip_zt']==1&&$conf['ssvip_wx']!=777&&$usernum['ssvip']==1){
require_once(SYSTEM_ROOT."oreo_function/pay/svip/oreo_wxpay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/svip/oreo_submit.class.php");
if($conf['oreo_lx']==1&&$lxnullsw){
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/svip/weixin/oreo_wxpay_notify_lx.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_wx_sl,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}else{
	$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/svip/weixin/oreo_wxpay_notify.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_wx_s,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
}	
if($conf['wxpay_mode']==0){
echo "
微信支付接口关闭";
}
$userpid=$DB->query("select pid from oreo_order where trade_no='{$trade_no}' limit 1")->fetch();
$userali=round($userpid['pid']);
$usernum=$DB->query("select wxpay from oreo_user where id='{$userali}' limit 1")->fetch();
if($usernum['wxpay']!=1){
echo<<<HTML
<!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>站点提示信息</title>
        <style type="text/css">
html{background:#eee}body{background:#fff;color:#333;font-family:"微软雅黑","Microsoft YaHei",sans-serif;margin:2em auto;padding:1em 2em;max-width:700px;-webkit-box-shadow:10px 10px 10px rgba(0,0,0,.13);box-shadow:10px 10px 10px rgba(0,0,0,.13);opacity:.8}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px "微软雅黑","Microsoft YaHei",,sans-serif;margin:30px 0 0 0;padding:0;padding-bottom:7px}#error-page{margin-top:50px}h3{text-align:center}#error-page p{font-size:9px;line-height:1.5;margin:25px 0 20px}#error-page code{font-family:Consolas,Monaco,monospace}ul li{margin-bottom:10px;font-size:9px}a{color:#21759B;text-decoration:none;margin-top:-10px}a:hover{color:#D54E21}.button{background:#f7f7f7;border:1px solid #ccc;color:#555;display:inline-block;text-decoration:none;font-size:9px;line-height:26px;height:28px;margin:0;padding:0 10px 1px;cursor:pointer;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top}.button.button-large{height:29px;line-height:28px;padding:0 12px}.button:focus,.button:hover{background:#fafafa;border-color:#999;color:#222}.button:focus{-webkit-box-shadow:1px 1px 1px rgba(0,0,0,.2);box-shadow:1px 1px 1px rgba(0,0,0,.2)}.button:active{background:#eee;border-color:#999;color:#333;-webkit-box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5);box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5)}table{table-layout:auto;border:1px solid #333;empty-cells:show;border-collapse:collapse}th{padding:4px;border:1px solid #333;overflow:hidden;color:#333;background:#eee}td{padding:4px;border:1px solid #333;overflow:hidden;color:#333}
        </style>
    </head>
    <body id="error-page">
       <h3>站点提示信息</h3>
        <a>您没有开通微信支付通道使用权限，若有需要请到 商户中心-开通接口处 在线开通有关权限</a>
    </body>
    </html>
HTML;
exit;
}
if($conf['wxpay_mode']==1){
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
		echo "<script>window.location.href='./weixin/wxjspay.php?trade_no={$trade_no}';</script>";
	}elseif(checkmobile()==true){
	if($conf['wxpay_h5']==1){
		echo "<script>window.location.href='.ay/weixin/wxwappay2.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
	}else{
	}
		echo "<script>window.location.href='./weixin/wxwappay.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
	}else{
		echo "<script>window.location.href='./weixin/wxpay.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
	}
}
$lxnullw=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='2' AND oreo_lxtype='1' ")->fetch();
if($conf['wxpay_mode']==2){
require_once(SYSTEM_ROOT."oreo_function/pay/epay/yzf_wxpay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/epay/epay_submit.class.php");
if($conf['oreo_lx']==1&&$lxnullw){
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/weixin/oreo_wxpay_notify_lx.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_wxl,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}else{
	$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/weixin/oreo_wxpay_notify.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_wx,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
}
if($conf['wxpay_mode']==3){
	echo "<script>window.location.href='./codepay/codepay.php?trade_no={$trade_no}&type=wxpay&sitename={$sitename}';</script>";
}
if($conf['wxpay_mode']==4){
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
		echo "<script>window.location.href='./eshanghu/wxjspay.php?trade_no={$trade_no}';</script>";
	}elseif(checkmobile()==true){
	if($conf['wxpay_h5']==1){
		echo "<script>window.location.href='./eshanghu/wxwappay.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
	}else{
	}
		echo "<script>window.location.href='./eshanghu/wxwappay.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
	}else{
		echo "<script>window.location.href='./eshanghu/wxpay.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
	}
}
if($conf['wxpay_mode']==5){
    echo "<script>window.location.href='./oreocpay/pay.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
}
if($conf['wxpay_mode']==6){
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
		echo "<script>window.location.href='./zmpay/wxjspay.php?trade_no={$trade_no}';</script>";
	}elseif(checkmobile()==true){
		echo "<script>window.location.href='./zmpay/wxwappay.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
	}else{
		echo "<script>window.location.href='./zmpay/wxpay.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
	}
}
}
if($type=='qqpay'){
$userpid=$DB->query("select pid from oreo_order where trade_no='{$trade_no}' limit 1")->fetch();
$userali=round($userpid['pid']);
$usernum=$DB->query("select ssvip from oreo_user where id='{$userali}' limit 1")->fetch();
$lxnullsq=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='4' AND oreo_lxtype='1' ")->fetch();
if($conf['chaojivip']==1&& $conf['ssvip_zt']==1&&$conf['ssvip_qq']!=777&&$usernum['ssvip']==1){
require_once(SYSTEM_ROOT."oreo_function/pay/svip/oreo_qqpay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/svip/oreo_submit.class.php");
if($conf['oreo_lx']==1&&$lxnullsq){
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/svip/qqpay/oreo_qqpay_notify_lx.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_qq_sl,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}else{
	$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/svip/qqpay/oreo_qqpay_notify.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_qq_s,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
}	
if($conf['qqpay_mode']==0){
echo "
QQ钱包接口关闭";
}
$userpid=$DB->query("select pid from oreo_order where trade_no='{$trade_no}' limit 1")->fetch();
$userali=round($userpid['pid']);
$usernum=$DB->query("select qqpay from oreo_user where id='{$userali}' limit 1")->fetch();
if($usernum['qqpay']!=1){
echo<<<HTML
<!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>站点提示信息</title>
        <style type="text/css">
html{background:#eee}body{background:#fff;color:#333;font-family:"微软雅黑","Microsoft YaHei",sans-serif;margin:2em auto;padding:1em 2em;max-width:700px;-webkit-box-shadow:10px 10px 10px rgba(0,0,0,.13);box-shadow:10px 10px 10px rgba(0,0,0,.13);opacity:.8}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px "微软雅黑","Microsoft YaHei",,sans-serif;margin:30px 0 0 0;padding:0;padding-bottom:7px}#error-page{margin-top:50px}h3{text-align:center}#error-page p{font-size:9px;line-height:1.5;margin:25px 0 20px}#error-page code{font-family:Consolas,Monaco,monospace}ul li{margin-bottom:10px;font-size:9px}a{color:#21759B;text-decoration:none;margin-top:-10px}a:hover{color:#D54E21}.button{background:#f7f7f7;border:1px solid #ccc;color:#555;display:inline-block;text-decoration:none;font-size:9px;line-height:26px;height:28px;margin:0;padding:0 10px 1px;cursor:pointer;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top}.button.button-large{height:29px;line-height:28px;padding:0 12px}.button:focus,.button:hover{background:#fafafa;border-color:#999;color:#222}.button:focus{-webkit-box-shadow:1px 1px 1px rgba(0,0,0,.2);box-shadow:1px 1px 1px rgba(0,0,0,.2)}.button:active{background:#eee;border-color:#999;color:#333;-webkit-box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5);box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5)}table{table-layout:auto;border:1px solid #333;empty-cells:show;border-collapse:collapse}th{padding:4px;border:1px solid #333;overflow:hidden;color:#333;background:#eee}td{padding:4px;border:1px solid #333;overflow:hidden;color:#333}
        </style>
    </head>
    <body id="error-page">
       <h3>站点提示信息</h3>
        <a>您没有开通QQ钱包通道使用权限，若有需要请到 商户中心-开通接口处 在线开通有关权限</a>
    </body>
    </html>
HTML;
exit;
}
if($conf['qqpay_mode']==1){
	echo "<script>window.location.href='./qqpay/qqpay.php?trade_no={$trade_no}&sitename={$sitename}';</script>";
}
$lxnull=$DB->query("SELECT * FROM `oreo_lxjk` WHERE oreo_lxname='3' AND oreo_lxtype='1' ")->fetch();
if($conf['qqpay_mode']==2){
require_once(SYSTEM_ROOT."oreo_function/pay/epay/yzf_qqpay.php");
require_once(SYSTEM_ROOT."oreo_function/pay/epay/epay_submit.class.php");
if($conf['oreo_lx']==1&&$lxnull){
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/qqpay/oreo_qqpay_notify_lx.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_qql,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}else{
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> $oreoport.'/pay/qqpay/oreo_qqpay_notify.php',
	"return_url"	=> $oreoport.'/pay/'.$oreo_return_qq,
	"out_trade_no"	=> $trade_no,
	"name"	=> $row['name'],
	"money"	=> $row['money']
);
}
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
}
if($conf['qqpay_mode']==3){
	echo "<script>window.location.href='./codepay/codepay.php?trade_no={$trade_no}&type=qqpay&sitename={$sitename}';</script>";
}
}
?>

</body>
</html>
