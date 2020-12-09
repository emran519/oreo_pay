<?php
$is_defend=true;
require '../includes/common.php';
@header('Content-Type: text/html; charset=UTF-8');

$trade_no=daddslashes($_GET['trade_no']);
$sitename=base64_decode(daddslashes($_GET['sitename']));
$qq=$_GET['qq'];
if(!$qq)$qq=$conf['web_qq'];
$row=$DB->query("SELECT * FROM pay_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
if(!$row)sysmsg('该订单号不存在，请返回来源地重新发起请求！');
require_once '..//Espay/ESPAY_config.php';
//api调用*/
//测试
$money=$_REQUEST['money'];
$gateway = 'http://pay.espay.cn/api/submit?';
$params['version'] = '1.0';
$params['customerid'] = $userid;
$params['sdorderno'] = $trade_no;
$params['total_fee'] = number_format($money,2,'.','');
$params['paytype'] = 'wxgzh';
$params['notifyurl'] = 'http://'.$conf['local_domain'].'/Espay/Espay_notify.php';
$params['returnurl'] = 'http://'.$conf['local_domain'].'/Espay/Espay_return.php';
$remark='易商支付：www.espay.cn';
$params['is_qrcode'] = '1';
$params['sign'] = md5('version='.$params['version'].'&customerid='.$params['customerid'].'&total_fee='.$params['total_fee'].'&sdorderno='.$params['sdorderno'].'&notifyurl='.$params['notifyurl'].'&returnurl='.$params['returnurl'].'&'.$userkey);
//print_r($params);
//print_r($params);
//开始请求
    //$curl = curl_init();
    //设置抓取的url
   // curl_setopt($curl, CURLOPT_URL, $gateway);
    //设置头文件的信息作为数据流输出
 //   curl_setopt($curl, CURLOPT_HEADER, 0);
   // //设置获取的信息以文件流的形式返回，而不是直接输出。
   // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
  //  curl_setopt($curl, CURLOPT_POST, 1);
    //设置post数据
 //   $post_data = $params;
  //  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
   // //执行命令
   // $data = curl_exec($curl);
    //关闭URL请求
   // curl_close($curl);
    //显示获得的数据
   //print_r($data);		
//$data1 = json_decode($data,true);
//echo gettype($data1);
//$retu = $data1['code_img_url'];
//$retu = getSubstr($data,"<script>location.href='","'</script>");
//echo getSubstr($data,"location.href='","</script>");
$retu=$gateway."version=1.0&customerid=".$params['customerid']."&sdorderno=".$params['sdorderno']."&total_fee=".$params['total_fee']."&paytype=".$params['paytype']."&notifyurl=".$params['notifyurl']."&returnurl=".$params['returnurl']."&remark=".$params['remark']."&bankcode=ICBC&is_qrcode=".$params['is_qrcode']."&sign=".$params['sign']."";


file_put_contents(SYSTEM_ROOT.'回调地址.txt',$data);

/*以下是取中间文本的函数 
  getSubstr=调用名称
  $str=预取全文本 
  $leftStr=左边文本
  $rightStr=右边文本
*/

//echo getSubstr($data,"location.href='","</script>");
file_put_contents(SYSTEM_ROOT.'回调地址.txt',$data);

/*以下是取中间文本的函数 
  getSubstr=调用名称
  $str=预取全文本 
  $leftStr=左边文本
  $rightStr=右边文本
*/

$sdwz = http_sdwz($retu);
function getSubstr($str, $leftStr, $rightStr)
{
    $left = strpos($str, $leftStr);
    //echo '左边:'.$left;
    $right = strpos($str, $rightStr,$left);
    //echo '<br>右边:'.$right;
    if($left < 0 or $right < $left) return '';
    return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
}

function http_sdwz($url = "")
{
  
     $data = isset($url)?$url:'';
     $url = "http://www.espay.cn/".urlencode($data);
     $result = file_get_contents($url);
     $aa = json_decode($result,true);
     $bb = ($aa["code"]);
     $cc = "http://www.espay.cn/".$bb;
     return $cc;
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="zh-cn">
<meta name="renderer" content="webkit">
<title>微信安全支付 - <?php echo $sitename?></title>
<link href="/Espay/css/wechat_pay.css" rel="stylesheet" media="screen">
</head>
<body>
<div class="body">
<h1 class="mod-title">
<span class="ico-wechat"></span><span class="text">微信支付</span>
</h1>
<div class="mod-ct">
<div class="order">
</div>
<div class="amount">￥<?php echo $row['money']?>
  </br>
  <?php if($conf['wxt7']==1){?>
本支付接口由易商支付：www.espay.cn提供！
<?php }else{?> <?php }?>
  </div>
  
<div class="qr-image" id="qrcode">
</div>
 
<div class="detail" id="orderDetail">
<dl class="detail-ct" style="display: none;">
<dt>商家</dt>
<dd id="storeName"><?php echo $sitename?></dd>
<dt>购买物品</dt>
<dd id="productName"><?php echo $row['name']?></dd>
<dt>商户订单号</dt>
<dd id="billId"><?php echo $row['trade_no']?></dd>
<dt>创建时间</dt>
<dd id="createTime"><?php echo $row['addtime']?></dd>
</dl>
<a href="javascript:void(0)" class="arrow"><i class="ico-arrow"></i></a>
</div>
<div class="tip">
<span class="dec dec-left"></span>
<span class="dec dec-right"></span>
<div class="ico-scan"></div>
<div class="tip-text">
<p>请使用微信扫一扫</p>
<p>扫描二维码完成支付</p>
</div>
</div>
<div class="tip-text">
</div>
</div>
<div class="foot">
<div class="inner">
<p>手机用户可保存上方二维码到手机中</p>
<p>在微信扫一扫中选择“相册”即可</p>
</div>
</div>
</div>
<script src="/Espay/js/qrcode.min.js"></script>
<script src="/Espay/js/qcloud_util.js"></script>
<script src="/Espay/js/layer.js"></script>
<script>
    var qrcode = new QRCode("qrcode", {
        text: "<?php echo $retu?>",
        width: 230,
        height: 230,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
    // 订单详情
    $('#orderDetail .arrow').click(function (event) {
        if ($('#orderDetail').hasClass('detail-open')) {
            $('#orderDetail .detail-ct').slideUp(500, function () {
                $('#orderDetail').removeClass('detail-open');
            });
        } else {
            $('#orderDetail .detail-ct').slideDown(500, function () {
                $('#orderDetail').addClass('detail-open');
            });
        }
    });
    // 检查是否支付完成
    function loadmsg() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/Espay/getshop.php",
            timeout: 10000, //ajax请求超时时间10s
            data: {type: "wxpay", trade_no: "<?php echo $row['trade_no']?>"}, //post数据
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
                if (data.code == 1) {
					layer.msg('支付成功，正在跳转中...', {icon: 16,shade: 0.01,time: 15000});
                    window.location.href=data.backurl;
                }else{
                    setTimeout("loadmsg()", 4000);
                }
            },
            //Ajax请求超时，继续查询
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (textStatus == "timeout") {
                    setTimeout("loadmsg()", 1000);
                } else { //异常
                    setTimeout("loadmsg()", 4000);
                }
            }
        });
    }
    window.onload = loadmsg();
</script>
</body>
</html>