<?php
//php防注入和XSS攻击通用过滤. 
$_GET     && SafeFilter($_GET);
$_POST    && SafeFilter($_POST);
$_COOKIE  && SafeFilter($_COOKIE);
function SafeFilter (&$arr){
    $ra=Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/','/script/','/javascript/','/vbscript/','/expression/','/applet/','/meta/','/xml/','/blink/','/link/','/style/','/embed/','/object/','/frame/','/layer/','/title/','/bgsound/','/base/','/onload/','/onunload/','/onchange/','/onsubmit/','/onreset/','/onselect/','/onblur/','/onfocus/','/onabort/','/onkeydown/','/onkeypress/','/onkeyup/','/onclick/','/ondblclick/','/onmousedown/','/onmousemove/','/onmouseout/','/onmouseover/','/onmouseup/','/onunload/');
    if (is_array($arr)){
        foreach ($arr as $key => $value){
            if(!is_array($value)){
                if (!get_magic_quotes_gpc()){             //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
                    $value=addslashes($value);           //给单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）加上反斜线转义
                }
                $value=preg_replace($ra,'',$value);     //删除非打印字符，粗暴式过滤xss可疑字符串
                $arr[$key]     = htmlentities(strip_tags($value)); //去除 HTML 和 PHP 标记并转换为 HTML 实体
            }else{
                SafeFilter($arr[$key]);
            }
        }
    }
}
include("../oreo/Oreo.Cron.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?=$conf['web_name']?>-找回密码</title>
  <meta name="description" content="particles.js is a lightweight JavaScript library for creating particles.">
  <meta name="author" content="Oreo支付系统" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" media="screen" href="../assets/new_user/repass/css/style.css">
  <link rel="stylesheet" type="text/css" href="../assets/new_user/repass/css/reset.css"/>
</head>
<body>

<div id="particles-js">
		<div class="login">
			<div class="login-top">
			找回密码
			</div>
			<?php if($conf['verifytype']==1){?>
			<div class="login-center clearfix">
				<div class="login-center-img"><img src="../assets/new_user/repass/img/phone.png"/></div>
				<div class="login-center-input">
					<input type="text" name="email"  placeholder="请输入您的手机号码" onfocus="this.placeholder=''" onblur="this.placeholder='请输入您的手机号码'"/>
					<div class="login-center-input-text">手机号码</div>
				</div>
			</div>
			<?php }else{?>
			<div class="login-center clearfix">
				<div class="login-center-img"><img src="../assets/new_user/repass/img/email.png"/></div>
				<div class="login-center-input">
					<input type="text" name="email"  placeholder="请输入您的安全邮箱" onfocus="this.placeholder=''" onblur="this.placeholder='请输入您的安全邮箱'"/>
					<div class="login-center-input-text">安全邮箱</div>
				</div>
			</div>
			<?php }?>

			<div class="login-center clearfix">
				<div class="login-center-img"><img src="../assets/new_user/repass/img/code.png"/></div>
				<div class="login-center-input">
					<input type="text" name="code"  placeholder="请输入您的验证码" onfocus="this.placeholder=''" onblur="this.placeholder='请输入您的验证码'"/>
					<button id="sendcode"  type="button" class="btn btn-lg" style="background-color: #f7f7f7;width: 5.9em;font-size: 1em;position: absolute;bottom: 2px;right: 2px;border-radius: inherit;text-align: center;z-index: 3;height: 2em;">点击获取</button>
					<div class="login-center-input-text">验证码</div>
				</div>
			</div>
			<div class="login-center clearfix">
				<div class="login-center-img"><img src="../assets/new_user/repass/img/password.png"/></div>
				<div class="login-center-input">
					<input type="text" name="password" value="" placeholder="请输入您的新密码" onfocus="this.placeholder=''" onblur="this.placeholder='请输入您的新密码'"/>
					<div class="login-center-input-text">输入新密码</div>
				</div>
			</div>
			
			<button id="zhuimm"  value="找回密码" style="cursor: pointer;width: 250px;text-align: center;height: 40px;line-height: 40px;background-color: dodgerblue;border-radius: 5px;margin: 0 auto;margin-top: 50px;color: white;position: absolute;right: 38px;"> 找回密码 </button>  
		
		</div>
		<div class="sk-rotating-plane"></div>
</div>

<!-- scripts -->
<script src="../assets/new_user/repass/js/particles.min.js"></script>
<script src="../assets/new_user/repass/js/app.js"></script>
<script src="../assets/new_user/js/jquery.min.js"></script>
<script src="//static.geetest.com/static/tools/gt.js"></script>
<script src="../assets/newuser/js/layer.js"></script>
<script src="../assets/new_user/js/jquery.cookie.min.js"></script>
<script>    
function invokeSettime(obj){
    var countdown=60;
    settime(obj);
    function settime(obj) {
        if (countdown == 0) {
            $(obj).attr("data-lock", "false");
            $(obj).text("获取验证码");
            countdown = 60;
            return;
        } else {
            $(obj).attr("data-lock", "true");
            $(obj).attr("disabled",true);
            $(obj).text("(" + countdown + ") s 重新发送");
            countdown--;
        }
        setTimeout(function() {
                    settime(obj) }
                ,1000)
    }
}
$(document).ready(function(){
	$("#sendcode").click(function(){
        if ($(this).attr("data-lock") === "true") return;
        var email=$("input[name='email']").val();
        if(email==''){layer.alert('邮箱不能为空！');return false;}
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
        var ii = layer.load(2, {shade:[0.1,'#fff']});
        $.ajax({
            type : "POST",
            url : "ajax.php?act=sendcode_pass",
            data : {email:email},
            dataType : 'json',
            success : function(data) {
                layer.close(ii);
                if(data.code == 0){
                    new invokeSettime("#sendcode");
                    layer.msg('发送成功，请注意查收！');
                }else{
                    layer.alert(data.msg);
                }
            } 
        });
    });
	$("#zhuimm").click(function(){
        if ($(this).attr("data-lock") === "true") return;
        var email=$("input[name='email']").val();
		var code=$("input[name='code']").val();
        var password=$("input[name='password']").val();
		var password2=$("input[name='password2']").val();
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
        
        var ii = layer.load(2, {shade:[0.1,'#fff']});
        $(this).attr("data-lock", "true");
        $.ajax({
            type : "POST",
            url : "ajax.php?act=zhmmzhbz",
            data : {password:password,password2:password2,email:email,code:code},
            dataType : 'json',
            success : function(data) {
                $("#submit").attr("data-lock", "false");
                layer.close(ii);
                if(data.code == 1){
                    layer.alert('找回成功', function(index) {
                    layer.close(index);
                    location.href="index.php"; 
                 })
                }else{
                    layer.alert(data.msg);
                }
            }
        });
    });
    $.ajax({
        // 获取id，challenge，success（是否启用failback）
        url: "ajax.php?act=captcha&t=" + (new Date()).getTime(), // 加随机数防止缓存
        type: "get",
        dataType: "json",
        success: function (data) {
            console.log(data);
            // 使用initGeetest接口
            // 参数1：配置参数
            // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
            initGeetest({
                width: '100%',
                gt: data.gt,
                challenge: data.challenge,
                new_captcha: data.new_captcha,
                product: "bind", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
                offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
                // 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
            }, handlerEmbed);
        }
    });
}); 
</script>

</body>
</html>