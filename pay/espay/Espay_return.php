<?php
require '../includes/common.php';
@header('Content-Type: text/html; charset=UTF-8');
require_once '..//Espay/ESPAY_config.php';
$status=$_GET['status'];
$customerid=$_GET['customerid'];
$sdorderno=$_GET['sdorderno'];
$total_fee=$_GET['total_fee'];
$paytype=$_GET['paytype'];
$sdpayno=$_GET['sdpayno'];
$remark=$_GET['remark'];
$sign=$_GET['sign'];
$row=$DB->query("SELECT * FROM pay_order WHERE trade_no='{$_GET['sdorderno']}' limit 1")->fetch();
if($row['status']>=1){
	$url=creat_callback($row);
	exit('<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>支付成功</title>
        <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="black" name="apple-mobile-web-app-status-bar-style">
        <meta content="telephone=no" name="format-detection">
        <link href="/Espay/css/style.css" rel="stylesheet" type="text/css">
    <style type="text/css"></style></head>
    <body>
        <section class="aui-flexView">
            <header class="aui-navBar aui-navBar-fixed b-line">

                <div class="aui-center">
                    <span class="aui-center-title">支付成功</span>
                </div>
                <a href="javascript:;" class="aui-navBar-item">
                    <i class="icon icon-sys"></i>
                </a>
            </header>
            <section class="aui-scrollView">
                <div class="aui-back-box">
                    <div class="aui-back-pitch">
                        <img src="/Espay/css/icon-pitch.png" alt="">
                    </div>
                    <div class="aui-back-title">
                        <h2>支付成功！</h2>
                        <p>您以支付成功请返回浏览器等待页面跳转！</p>
                    </div>

                </div>
            </section>
        </section>

    
</body></html>');
}else{
	exit('未付款');
}
?>
