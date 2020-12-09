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
$is_defend=true;
include("../oreo/Oreo.Cron.php");
if(isset($_POST['user']) && isset($_POST['pass']) || isset($_POST['admin_pass'])){
    $user=daddslashes($_POST['user']);
	$pass = md5($_POST['pass'].$password_hash);
    $userrow=$DB->query("SELECT * FROM oreo_user WHERE id='{$user}' limit 1")->fetch();
    if(!$userrow) { exit("<script language='javascript'>alert('您输入的商户ID有误，请检查！');window.location.href='./';</script>");}
    if($user==$userrow['id'] && $pass==$userrow['password'] || $_POST['admin_pass']==$userrow['password']) {
        if($wx_openid=$_SESSION['My_Wx_OpenId']){
            $DB->exec("update `oreo_user` set `wx_openid` ='$wx_openid' where `id`='$user'");
            unset($_SESSION['My_Wx_OpenId']);
        }
        if($qq_openid=$_SESSION['Oauth_qq_uid']){
            $DB->exec("update `oreo_user` set `qq_uid` ='$qq_openid' where `id`='$user'");
            unset($_SESSION['Oauth_qq_uid']);
        }
		if($userrow['active']==0) { exit("<script language='javascript'>alert('您的账号被封禁，若有问题请联系管理员！');window.location.href='./';</script>");}
        if(isset($_POST['admin_pass'])){
            $pass=$_POST['admin_pass'];
            }
        $session=md5($user.$pass.$password_hash);
        $expiretime=time()+604800;
        $token=authcode("{$user}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
        setcookie("user_token", $token, time() + 604800);
        $login_time = time();//禁止多地登录
        $m_login['token'] =md5($login_time.$user);
        $_SESSION['login_token'] = $m_login['token'];
        $DB->exec("update `oreo_user` set `login_token`='{$_SESSION['login_token']}'  where `id`='{$user}'");
        @header('Content-Type: text/html; charset=UTF-8');
        exit("<script language='javascript'>alert('登录用户中心成功！');window.location.href='./';</script>");
    }else {
        @header('Content-Type: text/html; charset=UTF-8');
        exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
    }
}elseif(isset($_GET['logout'])){
    setcookie("user_token", "", time() - 604800);
    @header('Content-Type: text/html; charset=UTF-8');
    exit("<script language='javascript'>alert('您已成功注销本次登录！');window.location.href='./login.php';</script>");
}elseif($islogin2==1){
    exit("<script language='javascript'>alert('您已登录！');window.location.href='./';</script>");
}
if($conf['web_is']==1)sysmsg($conf['web_offtext']);
if($conf['web_is']==2)sysmsg($conf['web_offtext']);
if($conf['login_is']==1)sysmsg($conf['login_offtext']);
if($conf['is_reg']==0)sysmsg($conf['reg_offtext']);
?>
<!DOCTYPE html>
<html lang="en" >
<head>
<meta charset="UTF-8">
<title><?=$conf['web_name']?>-商户面板登录页面</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--图标库-->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css'>
<!--响应式框架-->
<link rel='stylesheet' href='../assets/new_user/css/bootstrap.min.css'>
<!--主要样式-->
<link rel="stylesheet" href="../assets/new_user/css/style.css">
</head>
<body>
<div class="container">
	<div class="card-wrap">
		<div class="card border-0 shadow card--welcome is-show" id="welcome">
			<div class="card-body">
				<h2 class="card-title">欢迎光临</h2>
				<p>欢迎进入登录页面</p>
				<div class="btn-wrap">
					<a class="btn btn-lg btn-register js-btn" data-target="register">注册</a>
					<a class="btn btn-lg btn-login js-btn" data-target="login">登录</a>
				</div>
			</div>
		</div>
		<div class="card border-0 shadow card--register" id="register">
			<div class="card-body">
				<h2 class="card-title">会员注册</h2>
				<?php if($conf['is_payreg']){?>
                    <p>商户申请价格为：<b><?php echo $conf['reg_price']?></b> 元</p>
					<?php }?>
				<form>
						<div class="form-group">
					     <select class="form-control" name="type" id="type">
						<?php if($conf['stype_1']){?>
						<option value="1">支付宝结算</option>
						<?php }if($conf['stype_2']){?>
						<option value="2">微信结算</option>
						<?php }if($conf['stype_3']){?>
						<option value="3">QQ钱包结算</option>
						<?php }if($conf['stype_4']){?>
						<option value="4">银行卡结算</option>
						<?php }?>
						</select>
					</div>
					<div class="form-group">
						<input class="form-control" type="text" placeholder="结算账号" name="account"  required/>
					</div>
					<div class="form-group">
						<input class="form-control" type="text" placeholder="真实姓名" name="username"  required="required"/>
					</div>
					<div class="form-group">
						<input class="form-control" type="text" placeholder="联系QQ" name="qq"  required="required"/>
					</div>
					<div class="form-group">
						<input class="form-control" type="text" placeholder="对接域名" name="url"  required="required"/>
					</div>
					<div class="form-group">
					<input class="form-control" type="password" placeholder="登录密码"  name="password" required="required"/>
					</div>
					<div class="form-group">
						<input class="form-control" type="email" placeholder="邮箱"  name="email" required="required"/>
					</div>
					<?php if($conf['verifytype']==1){?>
						<div class="form-group">
                           <input class="form-control common-input" type="text" name="phone" placeholder="手机号码" required>
                        </div>
						<div class="form-group">
						    <input class="form-control " type="text" name="code" placeholder="短信验证码" required>
							<button id="sendsms" type="button" class="btn btn-lg" style="background-color: #a0a0d5;width: 5.9em;font-size: 1em;position: absolute;bottom: 98px;right: 20px;border-radius: inherit;text-align: center;">点击获取</button>
						</div>
					<?php }else{?>
						<div class="form-group">
						    <input class="form-control " type="text" name="code" placeholder="邮箱验证码" required>
									<button id="sendcode" type="button" class="btn btn-lg" style="background-color: #a0a0d5;width: 5.9em;font-size: 1em;position: absolute;bottom: 98px;right: 20px;border-radius: inherit;text-align: center;">点击获取</button>
						</div>
				<?php }?>
					<button class="btn btn-lg" type="button" id="submit">注册</button>
				</form>
			</div>
			<button class="btn btn-back js-btn" data-target="welcome"><i class="fas fa-angle-left"></i></button>
		</div>
		<div class="card border-0 shadow card--login" id="login">
			<div class="card-body">
				<h2 class="card-title">欢迎登录！</h2>
				<?php if($conf['quicklogin']==0){?>
                    
				<?php } else if($conf['quicklogin']==1){ ?>
				<p>第三方登录</p>
				<p class="badge-wrap">
					<a class="badge" onclick="location.href='https://www.oreopay.com/qc_api.php?token=<?php echo $conf['oreo_qq_token'];?>'"><i class="fab fa-qq"></i></a>
				</p>
				<?php } else if($conf['quicklogin']==2){ ?>
				<p>第三方登录</p>
				<p class="badge-wrap">
					<a class="badge" onclick="location.href='connect.php'"><i class="fab fa-qq"></i></a>
				</p>
				<?php } else if($conf['quicklogin']==3){ ?>
				<p>第三方登录</p>
				<p class="badge-wrap">
					<a class="badge" onclick="location.href='./openid/index.php'"><i class="fab fa-weixin"></i></a>
				</p>
				<?php } else if($conf['quicklogin']==4){ ?>
				<p>第三方登录</p>
				<p class="badge-wrap">
					<a class="badge" onclick="location.href='https://www.oreopay.com/qc_api.php?token=<?php echo $conf['oreo_qq_token'];?>'"><i class="fab fa-qq"></i></a>
					<a class="badge" onclick="location.href='./openid/index.php'"><i class="fab fa-weixin"></i></a>
				</p>
				<?php } else if($conf['quicklogin']==5){ ?>
				<p>第三方登录</p>
				<p class="badge-wrap">
					<a class="badge" onclick="location.href='connect.php'"><i class="fab fa-qq"></i></a>
					<a class="badge" onclick="location.href='./openid/index.php'"><i class="fab fa-weixin"></i></a>
				</p>
				<?php }?>
				<p>或用账号登录</p>
				<form action="" method="POST">
					<div class="form-group">
						<input class="form-control" type="user" placeholder="商户ID" name="user" required="required"/>
					</div>
					<div class="form-group">
						<input class="form-control" type="password" placeholder="登录密码"  name="pass" required="required"/>
					</div>
					<p><a href="./retrieve_password.php">忘记密码?</a></p>
					<button class="btn btn-lg" type="submit" >登录</button>
				</form>
			</div>
			<button class="btn btn-back js-btn" data-target="welcome"><i class="fas fa-angle-left"></i></button>
		</div>
		
	</div>
	
</div>
  
<script src="../assets/new_user/js/index.js"></script>
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
            $(obj).text("(" + countdown + ") s ");
            countdown--;
        }
        setTimeout(function() {
                    settime(obj) }
                ,1000)
    }
}
var handlerEmbed = function (captchaObj) {
    var phone;
    captchaObj.onReady(function () {
        $("#wait").hide();
    }).onSuccess(function () {
        var result = captchaObj.getValidate();
        if (!result) {
            return alert('请完成验证');
        }
        var ii = layer.load(2, {shade:[0.1,'#fff']});
        $.ajax({
            type : "POST",
            url : "ajax.php?act=sendsms",
            data : {phone:phone,geetest_challenge:result.geetest_challenge,geetest_validate:result.geetest_validate,geetest_seccode:result.geetest_seccode},
            dataType : 'json',
            success : function(data) {
                layer.close(ii);
                if(data.code == 0){
                    new invokeSettime("#sendsms");
                    layer.msg('发送成功，请注意查收！');
                }else{
                    layer.alert(data.msg);
                    captchaObj.reset();
                }
            } 
        });
    });
    $('#sendsms').click(function () {
        if ($(this).attr("data-lock") === "true") return;
        phone=$("input[name='phone']").val();
        if(phone==''){layer.alert('手机号码不能为空！');return false;}
        if(phone.length!=11){layer.alert('手机号码不正确！');return false;}
        captchaObj.verify();
    })
    // 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
};
$(document).ready(function(){
    $("select[name='type']").change(function(){
        if($(this).val() == 1){
            $("input[name='account']").attr("placeholder","支付宝账号");
        }else if($(this).val() == 2){
            $("input[name='account']").attr("placeholder","微信号");
        }else if($(this).val() == 3){
            $("input[name='account']").attr("placeholder","QQ号");
        }else if($(this).val() == 4){
            $("input[name='account']").attr("placeholder","银行卡号");
        }
    });
    $("select[name='type']").change();
    if($.cookie('mch_info')){
        var data = $.cookie('mch_info').split("|");
        layer.open({
          type: 1,
          title: '你之前申请的商户',
          skin: 'layui-layer-rim',
          content: '<li class="list-group-item"><b>商户ID（即登录账号）：</b>'+data[0]+'</li><li class="list-group-item"><b>商户密钥：</b>'+data[1]+'</li><li class="list-group-item"><a href="login.php?user='+data[0]+'&pass='+data[1]+'" class="btn btn-default btn-block">返回登录</a></li>'
        });
    }
    $("#sendcode").click(function(){
        if ($(this).attr("data-lock") === "true") return;
        var email=$("input[name='email']").val();
        if(email==''){layer.alert('邮箱不能为空！');return false;}
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
        var ii = layer.load(2, {shade:[0.1,'#fff']});
        $.ajax({
            type : "POST",
            url : "ajax.php?act=sendcode",
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
    $("#submit").click(function(){
        if ($(this).attr("data-lock") === "true") return;
		var type = $("#type").val();
        var account=$("input[name='account']").val();
        var username=$("input[name='username']").val();
		var qq=$("input[name='qq']").val();
        var url=$("input[name='url']").val();
		var password=$("input[name='password']").val();
        var email=$("input[name='email']").val();
        var phone=$("input[name='phone']").val();
        var code=$("input[name='code']").val();
        var tgid=$("input[name='tgid']").val();
        if(account=='' || username=='' || url=='' || email=='' || phone=='' || code==''){layer.alert('请确保各项不能为空！');return false;}
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
        if (url.indexOf(" ")>=0){
            url = url.replace(/ /g,"");
        }
        if (url.toLowerCase().indexOf("http://")==0){
            url = url.slice(7);
        }
        if (url.toLowerCase().indexOf("https://")==0){
            url = url.slice(8);
        }
        if (url.slice(url.length-1)=="/"){
            url = url.slice(0,url.length-1);
        }
        $("input[name='url']").val(url);
        var ii = layer.load(2, {shade:[0.1,'#fff']});
        $(this).attr("data-lock", "true");
        $.ajax({
            type : "POST",
            url : "ajax.php?act=reg",
            data : {type:type,account:account,username:username,qq:qq,url:url,password:password,email:email,phone:phone,code:code,tgid:tgid},
            dataType : 'json',
            success : function(data) {
                $("#submit").attr("data-lock", "false");
                layer.close(ii);
                if(data.code == 1){
                    layer.open({
                      type: 1,
                      title: '商户申请成功',
                      skin: 'layui-layer-rim',
                      content: '<li class="list-group-item"><b>商户ID（即登录账号）：</b>'+data.pid+'</li><li class="list-group-item"><b>商户密钥：</b>'+data.key+'</li><li class="list-group-item">以上商户信息已经发送到您的邮箱中</li><li class="list-group-item"><a href="login.php?user='+data.pid+'&pass='+data.key+'" style="color: #ff6262;background-color: unset;">返回登录</a></li>'
                    });
                    var mch_info = data.pid+"|"+data.key;
                    $.cookie('mch_info', mch_info);
                }else if(data.code == 2){
                    layer.open({
                      type: 1,
                      title: '支付确认页面',
                      skin: 'layui-layer-rim',
                      content: '<li class="list-group-item"><b>所需支付金额：</b>'+data.need+'元</li><li class="list-group-item text-center"><a href="../pay/payment.php?type=alipay&trade_no='+data.trade_no+'" class="btn btn-primary" style="width: auto;">支付宝</a>&nbsp;<a href="../pay/payment.php?type=wxpay&trade_no='+data.trade_no+'" class="btn btn-primary" style="width: auto;">微信支付</a>&nbsp;<a href="../pay/payment.php?type=qqpay&trade_no='+data.trade_no+'" class="btn btn-primary" style="width: auto;">QQ钱包</a></li><li class="list-group-item">提示：支付完成后详细信息通过邮箱发送到您账户</li>'
                    });
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