<?php
require '../../oreo/Oreo.Cron.php';

@header('Content-Type: text/html; charset=UTF-8');
$trade_no=daddslashes($_GET['trade_no']);
$type=daddslashes($_GET['type']);
$sitename=base64_decode(daddslashes($_GET['sitename']));
$row=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
if(!$row)sysmsg('该订单号不存在，请返回来源地重新发起请求！');

if ($type == 'wxpay') {
	$typeName = '微信';
    $type = 1;
} else if ($type == 'qqpay') {
	$typeName = 'QQ';
    $type = 3;
} else {
    $type = 2;
    $typeName = '支付宝';
}

$price = $row['money'];
$param = $trade_no;

$pay_id = $clientip;
//if($row['input'])$pay_id.='_'.mb_substr($row['input'],0,20,'UTF-8');
$data = array(

    "type" => $type,//支付方式
    "price" => $price,//原价
    "pay_id" => $pay_id, //可以是用户ID,站内商户订单号,用户名
    "param" => $param,//自定义参数
//            "https" => 1,//启用HTTPS



    "return_url" => 'http://'.$_SERVER['HTTP_HOST'].'/pay/oreopay/codepay_return.php',//付款后附带加密参数跳转到该页面
    "notify_url" => 'http://'.$_SERVER['HTTP_HOST'].'/pay/oreopay/codepay_notify.php',//付款后通知该页面处理业务
    "style" => '1',//付款页面风格
    "pay_type" => 1,//支付宝使用官方接口

    "chart" => strtolower('utf-8')//字符编码方式
    //其他业务参数根据在线开发文档，添加参数.文档地址:https://codepay.fateqq.com/apiword/
    //如"参数名"=>"参数值"
);

    $key = "6e720ffc95b8809cf3f118aa60bdcc34";//通讯密钥
    $sign = md5($_GET['payId'].$_GET['param'].$_GET['type'].$_GET['price'].$key);
    $p = "payId=".$pay_id.'&param='.$param.'&type='.$type."&price=".$price.'&sign='.$sign.'&isHtml=1';
    $apiHost="http://test.ytultd.com/createOrder?";
    $url = $apiHost.$p; //支付页面

?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $codepay_config['chart'] ?>">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="format-detection" content="telephone=no,email=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title><?php echo $typeName ?>扫码支付 - <?php echo $sitename?></title>
    <link href="https://codepay.fateqq.com/css/wechat_pay.css" rel="stylesheet" media="screen">

</head>

<body>
<div class="body">
    <h1 class="mod-title">
        <span class="ico_log ico-<?php echo $type ?>"></span>
    </h1>s

    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount" id="money">￥<?php echo $price ?></div>
        <div class="qrcode-img-wrapper" data-role="qrPayImgWrapper">
            <div data-role="qrPayImg" class="qrcode-img-area">
                <div class="ui-loading qrcode-loading" data-role="qrPayImgLoading" style="display: none;">加载中</div>
                <div style="position: relative;display: inline-block;">
                    <img id='show_qrcode' alt="加载中..." src="" width="210" height="210" style="display: block;">
                    <img onclick="$('#use').hide()" id="use"
                         src="<?php echo $codepay_path?>/img/use_<?php echo $type ?>.png"
                         style="position: absolute;top: 50%;left: 50%;width:32px;height:32px;margin-left: -21px;margin-top: -21px">
                </div>
            </div>


        </div>
        <div class="time-item" id="msg">
            <h1>二维码过期时间</h1>
            <strong id="hour_show">0时</strong>
            <strong id="minute_show">0分</strong>
            <strong id="second_show">0秒</strong>
        </div>

        <div class="tip">
            <div class="ico-scan"></div>
            <div class="tip-text">
                <p>请使用<?php echo $typeName ?>扫一扫</p>
                <p>扫描二维码完成支付</p>
            </div>
        </div>

        <div class="detail" id="orderDetail">
            <dl class="detail-ct" id="desc" style="display: none;">

                <dt>状态</dt>
                <dd id="createTime">订单创建</dd>

            </dl>
            <a href="javascript:void(0)" class="arrow"><i class="ico-arrow"></i></a>
        </div>

        <div class="tip-text">
        </div>


    </div>
    <div class="foot">
        <div class="inner">
            <p>手机用户可保存上方二维码到手机中</p>
            <p>在<?php echo $typeName ?>扫一扫中选择“相册”即可</p>
        </div>
    </div>

</div>
<div class="copyRight">
    <p>Copyright <a href="/" target="_blank">Oreo易支付</a></p>
</div>

<!--注意下面加载顺序 顺序错乱会影响业务-->
<script src="https://codepay.fateqq.com/js/jquery-1.10.2.min.js"></script>
<!--[if lt IE 8]>
<script src="https://codepay.fateqq.com/js/json3.min.js"></script><![endif]-->
<script>
    var user_data =<?php echo json_encode($url);?>
</script>
<script src="https://codepay.fateqq.com/js/notify.js"></script>
<script src="https://codepay.fateqq.com/js/codepay_util.js"></script>
<?php echo $codepay_html;?>
<script>
    setTimeout(function () {
        $('#use').hide()
    }, user_data.logShowTime || 10000)
</script>
</body>
</html>
