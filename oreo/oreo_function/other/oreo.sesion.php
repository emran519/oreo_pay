<?php
$clientip=real_ip();
if(isset($_COOKIE["admin_token"]))
{
	$token=authcode(daddslashes($_COOKIE['admin_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	$session=md5($conf['oreo_admin'].$conf['oreo_password'].$password_hash);
	if($session==$sid) {
		$islogin=1;
	}
}
if(isset($_COOKIE["user_token"]))
{
	$token=authcode(daddslashes($_COOKIE['user_token']), 'DECODE', SYS_KEY);
	list($pid, $sid, $expiretime) = explode("\t", $token);
	$userrow=$DB->query("SELECT * FROM oreo_user WHERE id='{$pid}' limit 1")->fetch();
	$session=md5($userrow['id'].$userrow['password'].$password_hash);
	if($session==$sid && $expiretime>time()) {
		$islogin2=1;
	}
}
if(isset($_COOKIE["auth_token"]))
{
	$token=authcode(daddslashes($_COOKIE['auth_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	$session_auth=md5('PvAGv2TO1xuon2Gu'.'oreo#@$4%$@$auth'.$password_hash);
	if($session_auth==$sid) {
		$oreo_auth=8;
	}
}
if(isset($_COOKIE["credit_token"]))
{
	$token=authcode(daddslashes($_COOKIE['credit_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	$session_credit=md5('PvAGv2TOcreditn2Gu'.'oreo#@C$4%$@$auth'.$password_hash);
	if($session_credit==$sid) {
		$oreo_credit=8;
	}
}
