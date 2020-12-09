<?php
/**
 * QQ互联
**/
include "../oreo/Oreo.Cron.php";
if($conf['quicklogin']==1||$conf['quicklogin']==3||$conf['quicklogin']==4||$conf['quicklogin']==5){ 
if($_GET['openid']){
	$openid=$_GET['openid'];
	$userrow=$DB->query("SELECT * FROM oreo_user WHERE wx_openid='{$openid}' limit 1")->fetch();
	if($userrow){
		$pid=$userrow['id'];
		$key=$userrow['password'];
		if($islogin2==1){
			@header('Content-Type: text/html; charset=UTF-8');
			exit("<script language='javascript'>alert('当前微信已绑定商户ID:{$pid}，请勿重复绑定！');window.location.href='./';</script>");
		}
		$session=md5($pid.$key.$password_hash);
		$expiretime=time()+2400;
		$token=authcode("{$pid}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
		setcookie("user_token", $token, time() + 2400);
		$login_time = time();//禁止多地登录
        $m_login['token'] =md5($login_time.$pid);
        $_SESSION['login_token'] = $m_login['token'];
        $DB->exec("update `oreo_user` set `login_token`='{$_SESSION['login_token']}'  where `id`='{$pid}'");
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>window.location.href='./';</script>");
	}elseif($islogin2==1){
		$sds=$DB->exec("update `oreo_user` set `wx_openid` ='$openid' where `id`='$pid'");
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('已成功绑定微信！');window.location.href='./';</script>");
	}else{
		$_SESSION['My_Wx_OpenId']=$openid;
		exit("<script language='javascript'>alert('请输入商户ID和密钥完成登录');window.location.href='./login.php?connect=true';</script>");
	}
}elseif($islogin2==1 && isset($_GET['unbind'])){
	$DB->exec("update `oreo_user` set `wx_openid` =NULL where `id`='$pid'");
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功解绑微信！');window.location.href='./';</script>");
}elseif($islogin2==1 && !isset($_GET['bind'])){
	exit("<script language='javascript'>alert('您已登陆！');window.location.href='./';</script>");
}
}