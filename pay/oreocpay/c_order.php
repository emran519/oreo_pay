<?php
header('content-type:application/json;charset=utf8');
require '../../oreo/Oreo.Cron.php';
require_once(SYSTEM_ROOT."oreo_function/pay/oreo_cpay/config.php");//载入配置文件
$trade_no=daddslashes($_POST['trade_no']);
$row=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
$type=$row['type']; //订单类型
//配置付款方式
if ($type == 'wxpay') {
    $typeName = '微信';
    $type = 1;
} else if ($type == 'alipay') {
    $typeName = '支付宝';
    $type = 2;
}
# 签名函数
function sign($data_arr) {
    return md5(join('',$data_arr));
};
$order_name=$row['name'];//订单名称
$money = $row['money'];//订单金额
$AppID=$oreo_cpay['app_id'];
$key=$oreo_cpay['app_key'];
$notify=$oreo_cpay['notify'];//异步地址
$return=$oreo_cpay['return'];//同步步地址
$sign = sign(array($AppID, $trade_no, $order_name, $type, $money, $key));

$url="https://auth.oreopay.com/oreo_api/oreo_cpay/createOrder.php";

$data = array(
    "AppID" => $AppID, //应用ID
    "trade_no" => $trade_no, //站内商户订单号
    "order_name" => $order_name,//订单名称
    "type" => $type,//支付方式 ，1微信，2支付宝
    "money" => $money,//价格
    "notifyUrl" => $notify,//异步地址
    "returnUrl" => $return,//同步地址
    "sign" => $sign //加密值
);
function SendDataByCurl($url,$data=array()){
    //对空格进行转义
    $url = str_replace(' ','+',$url);
    $ch = curl_init();
    //设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_TIMEOUT,3); //定义超时3秒钟
    // POST数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // 把post的变量加上
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  //所需传的数组用http_bulid_query()函数处理一下，就ok了
    //执行并获取url地址的内容
    $output = curl_exec($ch);
    $errorCode = curl_errno($ch);
    //释放curl句柄
    curl_close($ch);
    if(0 !== $errorCode) {
        return false;
    }

    return $output;
}

$back=SendDataByCurl($url,$data);
$arr = json_decode($back, JSON_UNESCAPED_UNICODE);
echo $back;
