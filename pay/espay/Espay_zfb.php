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
$params['paytype'] = 'aliscan';
$params['notifyurl'] = 'http://'.$conf['local_domain'].'/Espay/Espay_notify.php';
$params['returnurl'] = 'http://'.$conf['local_domain'].'/Espay/Espay_return.php';
$remark='易商支付：www.espay.cn';
$params['is_qrcode'] = '1';
$params['sign'] = md5('version='.$params['version'].'&customerid='.$params['customerid'].'&total_fee='.$params['total_fee'].'&sdorderno='.$params['sdorderno'].'&notifyurl='.$params['notifyurl'].'&returnurl='.$params['returnurl'].'&'.$userkey);
//print_r($params);
//开始请求
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $gateway);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
    curl_setopt($curl, CURLOPT_POST, 1);
    //设置post数据
    $post_data = $params;
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
    //显示获得的数据
   //print_r($data);		
$data1 = json_decode($data,true);
//echo gettype($data1);
$retu = $data1['code_url'];
//$retu = getSubstr($data,"<script>location.href='","'</script>");
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
     $url = "http://www.espay.cn".urlencode($data);
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
<title>支付宝扫码支付 - <?php echo $sitename?></title>
<link href="/Espay/css/alipay_pay.css" rel="stylesheet" media="screen">
</head>
<body>
<div class="body">
<h1 class="mod-title">
<span class="ico-wechat"></span><span class="text">支付宝扫码支付</span>
</h1>
<div class="mod-ct">
<div class="order">
</div>
<div class="amount">￥<?php echo $row['money']?></div>
<div class="qr-image" id="qrcode">
</div>
 
<div class="detail" id="orderDetail">
<dl class="detail-ct" style="display: none;">
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
<p>请使用支付宝扫一扫</p>
<p>扫描二维码完成支付</p>
</div>
</div>
<div class="tip-text">
</div>
</div>
<div class="foot">
<div class="inner">
<div id="J_downloadInteraction" class="download-interaction download-interaction-opening">
	<div class="inner-interaction">
		<p class="download-opening">正在打开支付宝<span class="download-opening-1">.</span><span class="download-opening-2">.</span><span class="download-opening-3">.</span></p>
		<p class="download-asking">如果没有打开支付宝，<a id="J_downloadBtn" href="javascript:;" onclick="openAli();">请点此重新唤起</a></p>
</div>
</div>
</div>
</div>
<script src="/Espay/js/qrcode.min.js"></script>
<script src="/Espay/js/qcloud_util.js"></script>
<script src="/Espay/js/layer.js"></script>
<script>
	var code_url = '<?php echo $code_url?>';
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
            data: {type: "alipay", trade_no: "<?php echo $row['trade_no']?>"}, //post数据
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
                if (data.code == 1) {
					layer.msg('支付成功，正在跳转中...', {icon: 16,shade: 0.01,time: 15000});
					setTimeout(window.location.href=data.backurl, 1000);
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
<script>
        if (typeof AlipayWallet !== 'object') {
            AlipayWallet = {};
        }

        (function () {
            var ua = navigator.userAgent.toLowerCase(),
                locked = false,
                domLoaded = document.readyState === 'complete',
                delayToRun;
            //alert(ua);
            function customClickEvent() {
                var clickEvt;
                if (window.CustomEvent) {
                    clickEvt = new window.CustomEvent('click', {
                        canBubble: true,
                        cancelable: true
                    });
                } else {
                    clickEvt = document.createEvent('Event');
                    clickEvt.initEvent('click', true, true);
                }

                return clickEvt;
            }

            function getAndroidVersion() {
                var match = ua.match(/android\s([0-9\.]*)/);
                return match ? match[1] : false;
            }

            var noIntentTest = /aliapp|360 aphone|weibo|windvane|ucbrowser|baidubrowser/.test(ua);
            var hasIntentTest = /chrome|samsung/.test(ua);
            var isAndroid = /android|adr/.test(ua) && !(/windows phone/.test(ua));
            var canIntent = !noIntentTest && hasIntentTest && isAndroid;
            var openInIfr = /weibo|m353/.test(ua);
            var inWeibo = ua.indexOf('weibo') > -1;

            if (ua.indexOf('m353') > -1 && !noIntentTest) {
                canIntent = false;
            }

            // 是否在 webview
            var inWebview = '';
            if (inWebview) {
                canIntent = false;
            }


            /**
             * 打开钱包
             * @@param   {string}    params  唤起钱包的参数设置('alipays://platformapi/startapp?'后面的值)
             * @@param   {boolean}   jumpUrl 唤起钱包后，android下要跳转到的URL；
             *                      若传"default"，则为https://d.alipay.com/i/index.htm?nojump=1#once
             */
            AlipayWallet.open = function (params, jumpUrl) {
                //alert(domLoaded);
                //alert(canIntent);
                //alert(ua.indexOf('360 aphone'));
                if (!domLoaded && (ua.indexOf('360 aphone') > -1 || canIntent)) {
                    var arg = arguments;
                    delayToRun = function () {
                        AlipayWallet.open.apply(null, arg);
                        delayToRun = null;
                    };
                    return;
                }

                // 唤起锁定，避免重复唤起
                if (locked) {
                    return;
                }
                locked = true;

                var o;
                // 参数容错
                if (typeof params === 'object') {
                    o = params;
                } else {
                    o = {
                        params: params,
                        jumpUrl: jumpUrl
                    };
                }

                // 参数容错
                if (typeof o.params !== 'string') {
                    o.params = '';
                }
                if (typeof o.openAppStore !== 'boolean') {
                    o.openAppStore = true;
                }

                o.params = o.params || 'appId=20000001';
                o.params = o.params + '';
                o.params = o.params + '&_t=' + (new Date() - 0);

                if (o.params.indexOf('startapp?') > -1) {
                    o.params = o.params.split('startapp?')[1];
                } else if (o.params.indexOf('startApp?') > -1) {
                    o.params = o.params.split('startApp?')[1];
                }

                // 是否为RC环境
                var isRc = '';

                // 是否唤起re包
                var isRe = '';
                if (typeof o.isRe === 'undefined') {
                    o.isRe = !!isRe;
                }

                // 通过alipays协议唤起钱包
                var schemePrefix;
                if (ua.indexOf('mac os') > -1 && ua.indexOf('mobile') > -1) {
                    // IOS RC包前缀为 alipaysrc
                    if (isRc) {
                        if (o.isRe) {
                            schemePrefix = 'alipayrerc';
                        } else {
                            schemePrefix = 'alipaysrc';
                        }
                    }
                }
                if (!schemePrefix && o.isRe) {
                    schemePrefix = 'alipayre';
                }
                schemePrefix = schemePrefix || 'alipays';

                // 由于历史原因，对 alipayqr 前缀做特殊处理
                if (location.href.indexOf('scheme=alipayqr') > -1) {
                    schemePrefix = 'alipayqr';
                    isRc = false;
                }




                if (!canIntent) {
                    var alipaysUrl = schemePrefix + '://platformapi/startapp?' + o.params;

                    if (ua.indexOf('qq/') > -1 || (ua.indexOf('safari') > -1 && (ua.indexOf('os 9_') > -1 || ua.indexOf('os 10_') > -1))) {
                        var openSchemeLink = document.getElementById('openSchemeLink');
                        if (!openSchemeLink) {
                            openSchemeLink = document.createElement('a');
                            openSchemeLink.id = 'openSchemeLink';
                            openSchemeLink.style.display = 'none';
                            document.body.appendChild(openSchemeLink);
                        }
                        openSchemeLink.href = alipaysUrl;
                        // 执行click
                        openSchemeLink.dispatchEvent(customClickEvent());
                    } else {
                        var ifr = document.createElement('iframe');
                        ifr.src = alipaysUrl;
                        ifr.style.display = 'none';
                        document.body.appendChild(ifr);
                    }
                } else {
                    // android 下 chrome 浏览器通过 intent 协议唤起钱包
                    var packageKey = 'AlipayGphone';
                    if (isRc) {
                        packageKey = 'AlipayGphoneRC';
                    }
                    var intentUrl = 'intent://platformapi/startapp?' + o.params + '#Intent;scheme=' + schemePrefix + ';package=com.eg.android.' + packageKey + ';end';

                    var openIntentLink = document.getElementById('openIntentLink');
                    if (!openIntentLink) {
                        openIntentLink = document.createElement('a');
                        openIntentLink.id = 'openIntentLink';
                        openIntentLink.style.display = 'none';
                        document.body.appendChild(openIntentLink);
                    }
                    openIntentLink.href = intentUrl;
                    // 执行click
                    openIntentLink.dispatchEvent(customClickEvent());
                }

                // 延迟移除用来唤起钱包的IFRAME并跳转到下载页
                setTimeout(function () {
                    if (typeof o.jumpUrl !== 'string') {
                        o.jumpUrl = '';
                    }

                    // URL白名单
                    var urlPattern = /^http(s)?:\/\/([a-z0-9_\-]+\.)*(alipay|taobao|alibaba|alibaba-inc|tmall|koubei)\.(com|net|cn|com\.cn)(:\d+)?([/;?].*)?$/;
                    // 默认跳转地址
                    if (o.jumpUrl === 'default') {
                        o.jumpUrl = 'https://ds.alipay.com/?nojump=true';
                    }

                    if (o.jumpUrl && typeof o.jumpUrl === 'string' && urlPattern.test(o.jumpUrl)) {
                        location.href = o.jumpUrl;
                    }
                }, 1000)


                // 唤起加锁，避免短时间内被重复唤起
                setTimeout(function () {
                    locked = false;
                }, 2500)
            }

            if (!domLoaded) {
                document.addEventListener('DOMContentLoaded', function () {
                    domLoaded = true;
                    if (typeof delayToRun === 'function') {
                        delayToRun();
                    }
                }, false);
            }
        })();
    </script>
    <script type="text/javascript">
        (function () {
            var schemeParam = 'saId=10000007&amp;clientVersion=3.7.0.0718&amp;qrcode='+code_url+'?_s=web-other';
            schemeParam = schemeParam.replace(/&amp;/ig, '&');


            if (!location.hash) {
                AlipayWallet.open({
                    params: schemeParam,
                    jumpUrl: '',
                    openAppStore: false
                });
            }



            function pageFuntion() {
                var interactionNode = document.getElementById('J_downloadInteraction');
                setTimeout(function () {
                    interactionNode.className = "download-interaction download-interaction-asking";
                }, 3000);
            }

            if (/complete|loaded|interactive/.test(document.readyState && document.body)) {
                pageFuntion();
            } else {
                document.addEventListener('DOMContentLoaded', function () {
                    pageFuntion();
                }, true);
            }
        })();
        function openAli()
        {
            var schemeParam = 'saId=10000007&amp;clientVersion=3.7.0.0718&amp;qrcode='+code_url+'?_s=web-other';
            schemeParam = schemeParam.replace(/&amp;/ig, '&');
            if (!location.hash) {
                AlipayWallet.open({
                    params: schemeParam,
                    jumpUrl: '',
                    openAppStore: false
                });
            }
        }
    </script>
</body>
</html>