<?php
require '../../oreo/Oreo.Cron.php';
@header('Content-Type: text/html; charset=UTF-8');
$trade_no=daddslashes($_GET['trade_no']);
$type=daddslashes($_GET['type']);
$sitename=base64_decode(daddslashes($_GET['sitename']));
$row=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
if(!$row)sysmsg('该订单号不存在，请返回来源地重新发起请求！');
$user=$DB->query("SELECT * FROM oreo_user WHERE id='{$row['pid']}' limit 1")->fetch();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="format-detection" content="telephone=no,email=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta name="renderer" content="webkit"/>
    <meta name="force-rendering" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Cache" content="no-cache">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>扫码支付</title>
    <link href="pay.css" rel="stylesheet" media="screen">
    <script src="https://lib.baomitu.com/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
<div class="body" id="body">
    <h1 class="mod-title">

        <span class="ico_log ico-1" v-if="payType == 1"></span>
        <span class="ico_log ico-2" v-if="payType == 2"></span>

    </h1>

    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount" id="timeOut" style="font-size: 20px;color: red;display: none;"><p>订单已过期，请您返回网站重新发起支付</p><br></div>
        <div class="amount" id="AppIdNo" style="font-size: 20px;color: red;display: none;"><p>请传入APP_ID</p><br></div>
        <div class="amount" id="SginNo" style="font-size: 20px;color: red;display: none;"><p>签名错误,请检查APP_ID和APP_KEY是否正确</p><br></div>
        <div class="amount" id="JkStateNo" style="font-size: 20px;color: red;display: none;"><p>监控端状态异常，请检查</p><br></div>
        <div class="amount" id="StatusO" style="font-size: 20px;color: red;display: none;"><p>权限被禁止</p><br></div>
        <div class="amount" id="StatusT" style="font-size: 20px;color: red;display: none;"><p>APP应用正在审核中</p><br></div>
        <div id="orderbody">
            <div class="amount" id="money">￥{{ reallyPrice }}</div>
            <div class="qrcode-img-wrapper" data-role="qrPayImgWrapper">
                <div data-role="qrPayImg" class="qrcode-img-area">
                    <div class="ui-loading qrcode-loading" data-role="qrPayImgLoading" style="display: none;">加载中</div>
                    <div style="position: relative;display: inline-block;">
                        <img  id='show_qrcode' alt="加载中..." :src="'./qrc.php?text='+payUrl" width="210" height="210" style="display: block;">
                        <!--<img onclick="$('#use').hide()" id="use" src="use_1.png" v-if="payType==1"
                             style="position: absolute;top: 50%;left: 50%;width:32px;height:32px;margin-left: -16px;margin-top: -16px">
                        <img onclick="$('#use').hide()" id="use" src="use_2.png" v-if="payType==2"
                             style="position: absolute;top: 50%;left: 50%;width:32px;height:32px;margin-left: -16px;margin-top: -16px">-->
                    </div>
                </div>


            </div>
            <div class="time-item">


                <div class="time-item" id="msg">
                    <h1  v-if="price == reallyPrice || price != reallyPrice">
                        <span style="color:red">为了您正常支付 请务必付款 {{ reallyPrice }} 元 <br>若有问题请联系QQ：<?=$user['qq'];?></span><br>


                    </h1>

                </div>







                <strong id="hour_show">0时</strong>
                <strong id="minute_show">0分</strong>
                <strong id="second_show">0秒</strong>
            </div>

            <div class="tip">
                <div class="ico-scan"></div>
                <div class="tip-text">
                    <p>请使用{{payType1}}扫一扫</p>

                    <p v-if="isAuto == 0">扫描二维码完成支付</p>
                    <p v-if="isAuto == 1">扫码后输入金额支付</p>

                </div>
            </div>

            <div class="detail" id="orderDetail">
                <dl class="detail-ct" id="desc" style="display: none;">
                    <dt>金额</dt>
                    <dd>{{price}}</dd>
                    <dt>商户订单：</dt>
                    <dd>{{trade_no}}</dd>
                    <dt>创建时间：</dt>
                    <dd>{{formatDate(date)}}</dd>
                    <dt>状态</dt>
                    <dd>等待支付</dd>
                </dl>

                <a href="javascript:void(0)" class="arrow" onclick="aaa()"><i class="ico-arrow"></i></a>
            </div>
        </div>


        <div class="tip-text">

        </div>


    </div>
    <div class="foot">
        <div class="inner">
            <p>手机用户可保存上方二维码到手机中</p>
            <p>在{{payType1}}扫一扫中选择“相册”即可</p>
        </div>
    </div>

</div>
<div class="copyRight">

</div>

<script src="https://lib.baomitu.com/vue/2.5.21/vue.min.js"></script>
<script>

    function aaa() {
        if ($('#orderDetail').hasClass('detail-open')) {
            $('#orderDetail .detail-ct').slideUp(500, function () {
                $('#orderDetail').removeClass('detail-open');
            });
        } else {
            $('#orderDetail .detail-ct').slideDown(500, function () {
                $('#orderDetail').addClass('detail-open');
            });
        }
    }
    function formatDate(now) {
        now = new Date(now*1000)
        return now.getFullYear()
            + "-" + (now.getMonth()>8?(now.getMonth()+1):"0"+(now.getMonth()+1))
            + "-" + (now.getDate()>9?now.getDate():"0"+now.getDate())
            + " " + (now.getHours()>9?now.getHours():"0"+now.getHours())
            + ":" + (now.getMinutes()>9?now.getMinutes():"0"+now.getMinutes())
            + ":" + (now.getSeconds()>9?now.getSeconds():"0"+now.getSeconds());

    }
    var myTimer;
    function timer(intDiff) {
        var i = 0;
        i++;
        var day = 0,
            hour = 0,
            minute = 0,
            second = 0;//时间默认值
        if (intDiff > 0) {
            day = Math.floor(intDiff / (60 * 60 * 24));
            hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
            minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
            second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
        }
        if (minute <= 9) minute = '0' + minute;
        if (second <= 9) second = '0' + second;
        $('#hour_show').html('<s id="h"></s>' + hour + '时');
        $('#minute_show').html('<s></s>' + minute + '分');
        $('#second_show').html('<s></s>' + second + '秒');
        if (hour <= 0 && minute <= 0 && second <= 0) {
            qrcode_timeout()
            clearInterval(myTimer);

        }
        intDiff--;

        myTimer = window.setInterval(function () {
            i++;
            var day = 0,
                hour = 0,
                minute = 0,
                second = 0;//时间默认值
            if (intDiff > 0) {
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            $('#hour_show').html('<s id="h"></s>' + hour + '时');
            $('#minute_show').html('<s></s>' + minute + '分');
            $('#second_show').html('<s></s>' + second + '秒');
            if (hour <= 0 && minute <= 0 && second <= 0) {
                qrcode_timeout()
                clearInterval(myTimer);

            }
            intDiff--;
        }, 1000);
    }



    function qrcode_timeout(){
        document.getElementById("orderbody").style.display = "none";
        document.getElementById("timeOut").style.display = "";
    }


    function getQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null)
            return decodeURI(r[2]);
        return null;
    }

    $.post("./c_order.php","trade_no="+getQueryString("trade_no"),function (data) {
        if (data.code==1){
            var time = new Date().getTime()-data.data.date*1000;
            time = time/1000;
            time = data.data.timeOut*60 - time;

            if (data.data.state == -1){
                time = 0;
            }
            timer(time);
            
            if (data.data.payType == 1) {
                data.data.payType1 = "微信";
            }else if (data.data.payType == 2) {
                data.data.payType1 = "支付宝";
            }



            new Vue({
                el: '#body',
                data: data.data
            })

            check();
        }else if (data.code == -8) {
            document.getElementById("orderbody").style.display = "none";
            document.getElementById("AppIdNo").style.display = "";
        }else if (data.code == -7) {
            document.getElementById("orderbody").style.display = "none";
            document.getElementById("SginNo").style.display = "";
        }else if (data.code == -5) {
            document.getElementById("orderbody").style.display = "none";
            document.getElementById("JkStateNo").style.display = "";
        }else if (data.code == -10) {
            document.getElementById("orderbody").style.display = "none";
            document.getElementById("StatusO").style.display = "";
        }else if (data.code == -11) {
            document.getElementById("orderbody").style.display = "none";
            document.getElementById("StatusT").style.display = "";
        }
        else{
            timer(0)
        }
    });

    function check() {
        $.get("../check_up.php","trade_no="+getQueryString("trade_no"),function (data) {
            console.log(data);
            if (data.code == 1){
                window.location.href = data.backurl;
            } else{
                if (data.data == "订单已过期") {
                    intDiff = 0;
                }else{
                    setTimeout("check()",1500);
                }
            }
        })
    }

</script>
</body>
</html>