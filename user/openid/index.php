<?php
include("../../oreo/Oreo.Cron.php");
//生成唯一码
$module=mt_rand(100000,999999);
$myid=md5($module.'#$@%!^*'.time()); //传值的参数
$token=$conf['oreo_wx_token'];
$DB->exec("DELETE FROM oreo_wx_seesion WHERE token='$myid' ");
$DB->exec("DELETE FROM  oreo_wx_seesion WHERE  addtime<=DATE_SUB(NOW(),INTERVAL 2 minute) "); 
$level=3;
$size=4;
require_once 'phpqrcode.php';
$errorCorrectionLevel = intval($level) ;//容错级别
$matrixPointSize = intval($size);//生成图片大小
//生成二维码图片
$object = new \QRcode();
$path = "qrcode/0.png"; //本地文件存储路径
$appid='wx278feb16ad503f30'; //公众号唯一标识
$oreoport =$_SERVER['HTTP_HOST'];//获取域名
$port = $_SERVER['SERVER_PORT'];//获取端口
$redirect_uri = urlencode ( 'http://www.oreopay.com/wx_api.php?myid='.$myid.'&domain='.$oreoport.'&port='.$port.'&oreo_token='.$token ); //这个是设置参数和授权后重定向的回调链接地址
$url  =  "https://open.weixin.qq.com/connect/oauth2/authorize".

"?appid=" . $appid .

"&redirect_uri=" . $redirect_uri  . 

"&response_type=code".

"&scope=snsapi_base". #!!!scope设置为snsapi_base !!!

"&state=1";    

$object->png($url, $path, $errorCorrectionLevel, $matrixPointSize, 2);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>微信扫码登录</title>
        <link rel="shortcut icon" href="../assets/newuser/images/favicon.ico">
        <link href="../../assets/newuser/css/app.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body style="background-color: rgb(51, 51, 51); padding: 50px;color: #fff;">
                <div class="content-page">
                    <div class="content">
                        <div class="row">
                            <div class="col-xl-12">
                            <div style="margin-top: 5em;">
                                <div style="text-align: center;font-size: 20px;line-height: 1.6;" >微信登录</div>
                                <div style="line-height: 1.6;text-align: center;">
                                <img style="width: 250px;margin: 15px;border: 1px solid #E2E2E2;" class="qrcode lightBorder" src="qrcode/0.png"></div>
                            </div> <!-- end col--> 
                            <div style="width: 250px;margin: 0 auto;">
                            <div style='margin-top: 15px;background-color: #232323;-webkit-border-radius: 100px;-webkit-box-shadow: inset 0 5px 10px -5px #191919,0 1px 0 0 #444;text-align: center;padding: 2px 14px;color: #fff;font-family: "Microsoft Yahei";'>
				                <p style="margin: 0;">请使用微信扫描二维码登录</p>
	                            <p style="margin: 0;">Oreo支付系统</p>
                            </div>
                            </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div> <!-- content -->
                    <!-- Footer Start -->
                    <footer class="footer" style="position: fixed;">
                    <div class="row">
                            <div class="col-md-6">
                                <?php echo $conf['copyright']; ?>.                           </div>
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-md-block">
                                    <a href="javascript: void(0);"><?php echo $conf['beian']; ?></a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- end Footer -->
                </div> <!-- content-page -->
            </div> <!-- end wrapper-->
        </div>
        <script src="../../assets/newuser/js/app.min.js"></script>
        <script src="../../assets/pay/js/layer.js"></script>
        <script>
    // 检查是否支付完成
    function loadmsg() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "./check_up.php",
            timeout: 10000, //ajax请求超时时间10s
            data: {myid: "<?php echo $myid?>"}, //post数据
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
               
                if (data.code == 1) {
                    layer.msg('支付成功，正在跳转中...', {icon: 16,shade: 0.01,time: 15000});
                    window.location.href=data.openid;
                } else{
                    setTimeout("loadmsg()", 2000);
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