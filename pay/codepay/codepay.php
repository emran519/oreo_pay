<?php
require '../../oreo/Oreo.Cron.php';

require_once(SYSTEM_ROOT."oreo_function/pay/codepay/codepay_config.php");

@header('Content-Type: text/html; charset=UTF-8');

$trade_no=daddslashes($_GET['trade_no']);
$type=daddslashes($_GET['type']);
$sitename=base64_decode(daddslashes($_GET['sitename']));
$row=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
if(!$row)sysmsg('该订单号不存在，请返回来源地重新发起请求！');

if(!is_file(SYSTEM_ROOT.'../check_up.php')){ //如果存在这个文件 表示codepay目录上传 使用本地资源否则用远程资源
    $codepay_path="https://codepay.fateqq.com";
}else{
    $codepay_path="https://codepay.fateqq.com";
}
if ($type == 'wxpay') {
	$typeName = '微信';
    $type = 3;
} else if ($type == 'qqpay') {
	$typeName = 'QQ';
    $type = 2;
} else {
    $type = 1;
    $typeName = '支付宝';
}

$price = $row['money'];
$param = $trade_no;

$pay_id = $clientip;
//if($row['input'])$pay_id.='_'.mb_substr($row['input'],0,20,'UTF-8');
$data = array(
    "id" => $codepay_config['id'],//平台ID号
    "type" => $type,//支付方式
    "price" => $price,//原价
    "pay_id" => $pay_id, //可以是用户ID,站内商户订单号,用户名
    "param" => $param,//自定义参数
//            "https" => 1,//启用HTTPS
    "act" => $codepay_config['act'],
    "outTime" => $codepay_config['outTime'],//二维码超时设置
    "page" => $codepay_config['page'],//付款页面展示方式
    "return_url" => 'http://'.$_SERVER['HTTP_HOST'].'/pay/codepay/codepay_return.php',//付款后附带加密参数跳转到该页面
    "notify_url" => 'http://'.$conf['local_domain'].'/pay/codepay/codepay_notify.php',//付款后通知该页面处理业务
    "style" => $codepay_config['style'],//付款页面风格
    "pay_type" => $codepay_config['pay_type'],//支付宝使用官方接口
    "qrcode_url" => $codepay_config['qrcode_url'],//本地化二维码
    "chart" => strtolower('utf-8')//字符编码方式
    //其他业务参数根据在线开发文档，添加参数.文档地址:https://codepay.fateqq.com/apiword/
    //如"参数名"=>"参数值"
);
function create_link($params,$codepay_key,$host=""){
    ksort($params); //重新排序$data数组
    reset($params); //内部指针指向数组中的第一个元素
    $sign = '';
    $urls = '';
    foreach ($params AS $key => $val) {
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

    $key = md5($sign . $codepay_key);//替换为自己的密钥
    $query = $urls . '&sign=' . $key; //创建订单所需的参数
    $apiHost=$host?$host:"http://api2.fateqq.com:52888/creat_order/?";
    $url = $apiHost.$query; //支付页面
    return array("url"=>$url,"query"=>$query,"sign"=>$sign,"param"=>$urls);
}
$back=create_link($data,$codepay_config['key']);


switch ((int)$type) {
    case 1:
        $typeName = '支付宝';
        break;
    case 2:
        $typeName = 'QQ';
        break;
    default:
        $typeName = '微信';
}
$user_data = array("return_url" => 'http://'.$_SERVER['HTTP_HOST'].'/pay/codepay/codepay_return.php',
    "type" => $type, "outTime" => $codepay_config["outTime"], "codePay_id" => $codepay_config["id"]);


$user_data["qrcode_url"] = $codepay_config["qrcode_url"];

//中间那log 默认为10秒后隐藏
//改为自己的替换img目录下的use_开头的图片 你要保证你的二维码遮挡不会影响扫码
//二维码容错率决定你能遮挡多少部分
$user_data["logShowTime"] = 1;
/**
 * 高级模式 云端创建订单。(注意不要外泄密钥key)
 * 可自行根据订单返回的参数做一些高级功能。 以下demo只是简单的功能 其他需要自行开发
 * 比如根据money type 参数调用本地的二维码图片。
 * 比如根据云端订单状态创建失败 展示自定义转账的二维码。
 * 比如可自行开发付款后的同步通知实现。
 * 比如可自行开发软件端某个支付方式掉线。 自动停用该付款方式。
 * 如使用云端同步通知  请附带必要的参数 码支付的用户id,pay_id,type,money,order_id,tag,notiry_key
 * 必须将notiry_key参数返回 因为该参数为服务解密参数(会随时变化)。否则影响云端同步通知
 */

$codepay_json = get_curl($back['url']);

if(empty($codepay_json)){
    $data['call']="callback";
    $data['page']="3";
    $back=create_link($data,$codepay_config['key']);
    $codepay_html='<script src="'.$back['url'].'"></script>';
}else{
    $codepay_html="<script>callback({$codepay_json})</script>";
}

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
    <link href="<?php echo $codepay_path?>/css/wechat_pay.css" rel="stylesheet" media="screen">

</head>

<body>
<div class="body">
    <h1 class="mod-title">
        <span class="ico_log ico-<?php echo $type ?>"></span>
    </h1>

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
<script src="<?php echo $codepay_path?>/js/jquery-1.10.2.min.js"></script>
<!--[if lt IE 8]>
<script src="<?php echo $codepay_path?>/js/json3.min.js"></script><![endif]-->
<script>
    var user_data =<?php echo json_encode($user_data);?>
</script>
<script src="<?php echo $codepay_path?>/js/notify.js"></script>
<script src="<?php echo $codepay_path?>/js/codepay_util.js"></script>
<?php echo $codepay_html;?>
<script>
    setTimeout(function () {
        $('#use').hide()
    }, user_data.logShowTime || 10000)
</script>
</body>
</html>
