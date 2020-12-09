<?php
include("../oreo/Oreo.Cron.php");
if($islogin2==1){}else exit('{"code":-3,"msg":"No Login"}');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
header('Access-Control-Allow-Origin:*');  
@header('Content-Type: application/json; charset=UTF-8');

switch($act){	
case 'edit_mycode':
	    if($_FILES['alipaycode']&&!istp($_FILES['alipaycode'])){
			exit('{"code":-3,"msg":"支付宝收款码图片格式错误"}');
		}if($_FILES['wxpaycode']&&!istp($_FILES['wxpaycode'])){
			exit('{"code":-3,"msg":"微信支付收款码图片格式错误"}');
		}if($_FILES['qqpaycode']&&!istp($_FILES['qqpaycode'])){
			exit('{"code":-3,"msg":"QQ钱包收款码图片格式错误"}');
		}else{
			$userids=$userrow['id'];
            $alipaycode=uploadtp($_FILES['alipaycode'],$userids);
			$wxpaycode=uploadtp($_FILES['wxpaycode'],$userids);
			$qqpaycode=uploadtp($_FILES['qqpaycode'],$userids);
			$sqs=$DB->exec("update `oreo_user` set  alipaycode='$alipaycode', wxpaycode='$wxpaycode', qqpaycode='$qqpaycode' where `id`='$pid' ");
            exit('{"code":1,"msg":"succ"}');
	  }
break;
case 'edit_mycodea':
	    if($_FILES['wxpaycode']&&!istp($_FILES['wxpaycode'])){
			exit('{"code":-3,"msg":"微信支付收款码图片格式错误"}');
		}if($_FILES['qqpaycode']&&!istp($_FILES['qqpaycode'])){
			exit('{"code":-3,"msg":"QQ钱包收款码图片格式错误"}');
		}else{
			$userids=$userrow['id'];
			$wxpaycode=uploadtp($_FILES['wxpaycode'],$userids);
			$qqpaycode=uploadtp($_FILES['qqpaycode'],$userids);
			$sqs=$DB->exec("update `oreo_user` set  wxpaycode='$wxpaycode', qqpaycode='$qqpaycode' where `id`='$pid' ");
            exit('{"code":1,"msg":"succ"}');
	  }
break;
case 'edit_mycodeb':
	    if($_FILES['alipaycode']&&!istp($_FILES['alipaycode'])){
			exit('{"code":-3,"msg":"支付宝收款码图片格式错误"}');
		}if($_FILES['qqpaycode']&&!istp($_FILES['qqpaycode'])){
			exit('{"code":-3,"msg":"QQ钱包收款码图片格式错误"}');
		}else{
			$userids=$userrow['id'];
			$alipaycode=uploadtp($_FILES['alipaycode'],$userids);
			$qqpaycode=uploadtp($_FILES['qqpaycode'],$userids);
			$sqs=$DB->exec("update `oreo_user` set  alipaycode='$alipaycode', qqpaycode='$qqpaycode' where `id`='$pid' ");
            exit('{"code":1,"msg":"succ"}');
	  }
break;
case 'edit_mycodec':
	   if($_FILES['alipaycode']&&!istp($_FILES['alipaycode'])){
			exit('{"code":-3,"msg":"支付宝收款码图片格式错误"}');
		}if($_FILES['wxpaycode']&&!istp($_FILES['wxpaycode'])){
			exit('{"code":-3,"msg":"微信支付收款码图片格式错误"}');
		}else{
			$userids=$userrow['id'];
			$alipaycode=uploadtp($_FILES['alipaycode'],$userids);
			$wxpaycode=uploadtp($_FILES['wxpaycode'],$userids);
			$sqs=$DB->exec("update `oreo_user` set  alipaycode='$alipaycode', wxpaycode='$wxpaycode' where `id`='$pid' ");
            exit('{"code":1,"msg":"succ"}');
	  }
break;
case 'edit_mycoded':
	   if($_FILES['qqpaycode']&&!istp($_FILES['qqpaycode'])){
			exit('{"code":-3,"msg":"QQ钱包收款码图片格式错误"}');
		}else{
			$userids=$userrow['id'];
			$qqpaycode=uploadtp($_FILES['qqpaycode'],$userids);
			$sqs=$DB->exec("update `oreo_user` set  qqpaycode='$qqpaycode' where `id`='$pid' ");
            exit('{"code":1,"msg":"succ"}');
	  }
break;
case 'edit_mycodee':
	   if($_FILES['alipaycode']&&!istp($_FILES['alipaycode'])){
			exit('{"code":-3,"msg":"支付宝收款码图片格式错误"}');
		}else{
			$userids=$userrow['id'];
			$alipaycode=uploadtp($_FILES['alipaycode'],$userids);
			$sqs=$DB->exec("update `oreo_user` set  alipaycode='$alipaycode' where `id`='$pid' ");
            exit('{"code":1,"msg":"succ"}');
	  }
break;
case 'edit_mycodef':
	   if($_FILES['wxpaycode']&&!istp($_FILES['wxpaycode'])){
			exit('{"code":-3,"msg":"微信支付收款码图片格式错误"}');
		}else{
			$userids=$userrow['id'];
			$wxpaycode=uploadtp($_FILES['wxpaycode'],$userids);
			$sqs=$DB->exec("update `oreo_user` set  wxpaycode='$wxpaycode' where `id`='$pid' ");
            exit('{"code":1,"msg":"succ"}');
	  }
break;
case 'edit_GoumaiSs':
	if($conf['chaojivip']==0)exit('{"code":-1,"msg":"未开放申请"}');
	$typname="ssvip";
	if($userrow['ssvip']==1)exit('{"code":-1,"msg":"您已经开通有关权限，无需再次操作！"}');
    if($userrow['money']<$conf['chaoji_money'])exit('{"code":-1,"msg":"您的余额不足以执行本次操作，请先充值！"}');
	if($userrow['ssvip']==2){
	  $nmoney=$conf['chaoji_money'];
	  $time=date("Y-m-d");
	  $name='超级会员';
	  $DB->exec("INSERT INTO `oreo_viporder` (`uid`, `name`, `money`, `time`, `type`, `typname`) VALUES ('{$pid}', '{$name}', '{$conf['chaoji_money']}', '{$time}', '1', '{$typname}')");
	  $DB->exec("update `oreo_user` set `ssvip` ='1', `money`=money-{$nmoney}  where `id`='$pid'");
			exit('{"code":1,"msg":"succ"}');
		}else{
			('{"code":-1,"msg":"提交失败'.$DB->errorCode().'"}');
		}
break;			
case 'edit_GoumaiQq':
	if($conf['qqvip']==0)exit('{"code":-1,"msg":"未开放申请"}');
	$typname="qqpay";
	if($userrow['qqpay']==1)exit('{"code":-1,"msg":"您已经开通有关权限，无需再次操作！"}');
    if($userrow['money']<$conf['qqvip_money'])exit('{"code":-1,"msg":"您的余额不足以执行本次操作，请先充值！"}');
	if($userrow['qqpay']==2){
	  $nmoney=$conf['qqvip_money'];
	  $time=date("Y-m-d");
	  $name='QQ钱包';
	  $DB->exec("INSERT INTO `oreo_viporder` (`uid`, `name`, `money`, `time`, `type`, `typname`) VALUES ('{$pid}', '{$name}', '{$conf['qqvip_money']}', '{$time}', '1', '{$typname}')");
	  $DB->exec("update `oreo_user` set `qqpay` ='1',`money`=money-{$nmoney} where `id`='$pid'");
			exit('{"code":1,"msg":"succ"}');
		}else{
			('{"code":-1,"msg":"提交失败'.$DB->errorCode().'"}');
		}
break;		
case 'edit_GoumaiWx':
	if($conf['wxvip']==0)exit('{"code":-1,"msg":"未开放申请"}');
	$typname="wxpay";
	if($userrow['wxpay']==1)exit('{"code":-1,"msg":"您已经开通有关权限，无需再次操作！"}');
    if($userrow['money']<$conf['wxvip_money'])exit('{"code":-1,"msg":"您的余额不足以执行本次操作，请先充值！"}');
	if($userrow['wxpay']==2){
	  $nmoney=$conf['wxvip_money'];
	  $time=date("Y-m-d");
	  $name='微信支付';
	  $DB->exec("INSERT INTO `oreo_viporder` (`uid`, `name`, `money`, `time`, `type`, `typname`) VALUES ('{$pid}', '{$name}', '{$conf['wxvip_money']}', '{$time}', '1', '{$typname}')");
	  $DB->exec("update `oreo_user` set `wxpay` ='1',`money`=money-{$nmoney} where `id`='$pid'");
			exit('{"code":1,"msg":"succ"}');
		}else{
			('{"code":-1,"msg":"提交失败'.$DB->errorCode().'"}');
		}
break;	
case 'edit_GoumaiAli':
	if($conf['alivip']==0)exit('{"code":-1,"msg":"未开放申请"}');
	$typname="alipay";
	if($userrow['alipay']==1)exit('{"code":-1,"msg":"您已经开通有关权限，无需再次操作！"}');
    if($userrow['money']<$conf['alivip_money'])exit('{"code":-1,"msg":"您的余额不足以执行本次操作，请先充值！"}');
	if($userrow['alipay']==2){
	  $nmoney=$conf['alivip_money'];
	  $time=date("Y-m-d");
	  $name='支付宝';
	  $DB->exec("INSERT INTO `oreo_viporder` (`uid`, `name`, `money`, `time`, `type`, `typname`) VALUES ('{$pid}', '{$name}', '{$conf['alivip_money']}', '{$time}', '1', '{$typname}')");
	  $DB->exec("update `oreo_user` set `alipay` ='1',`money`=money-{$nmoney} where `id`='$pid'");
			exit('{"code":1,"msg":"succ"}');
		}else{
			('{"code":-1,"msg":"提交失败'.$DB->errorCode().'"}');
		}
break;	
case 'm_EditPassword':
	$lastpassword=daddslashes(strip_tags($_POST['lastpassword']));
	$newpassword=daddslashes(strip_tags($_POST['newpassword']));
	if($lastpassword=='' || $newpassword=='' )exit('{"code":-1,"msg":"密码不能为空."}');
    if($lastpassword!=$newpassword)exit('{"code":-1,"msg":"两个密码不相同，请检查."}');
	if(strlen($lastpassword)<6)exit('{"code":-1,"msg":"密码不能少于6字符."}');
	if(isset($_SESSION['edit_password']) && $_SESSION['edit_password']>time()-120){
		exit('{"code":-1,"msg":"请勿频繁修改密码"}');
	}
	$password = md5($_POST['newpassword'].$password_hash);
	$abc=$DB->exec("UPDATE `oreo_user` SET `password`='$password' WHERE `id`='$pid'");
	$_SESSION['edit_password']=time();
	exit('{"code":1,"msg":"succ"}');
break;		
case 's_Work':
	$types=daddslashes(strip_tags($_POST['types']));
	$biaoti=daddslashes(strip_tags($_POST['biaoti']));
	$text=daddslashes(strip_tags($_POST['text']));
	$qq=daddslashes(strip_tags($_POST['qq']));
	if($conf['owrk_zt']==0)exit('{"code":-1,"msg":"未开放工单系统"}');
	if(isset($_SESSION['work_submit']) && $_SESSION['work_submit']>time()-2400){
		exit('{"code":-1,"msg":"请勿频繁提交工单"}');
	}
	if($conf['owrk_zt']==1){
		$num = rand(100000000,999999999);
		$edata=date("Y-m-d");
		$sds=$DB->exec("INSERT INTO `oreo_work` (`uid`, `num`, `types`, `biaoti`, `text`, `qq`, `edata`, `wdata`, `active`) VALUES ('{$pid}', '{$num}', '{$types}', '{$biaoti}', '{$text}', '{$qq}', '{$edata}', ' ', '0')");
		$_SESSION['work_submit']=time();
		$email=$conf['web_mail'];
		$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].'/';
		$sub = $conf['web_name'].' - 您有新的工单要处理';
		$msg = '<h2>新的工单等你来处理</h2>尊敬的管理员您的网站【'.$conf['web_name'].'】收到一个工单<br/>工单编号为：'.$num.'<br/>工单类型为：'.$types.'<br/>工单标题为：'.$biaoti.'<br/>请尽快登录后台处理订单：【<a href="'.$siteurl.'" target="_blank">登录后台</a>】<br/>';
		$result = send_mail($email, $sub, $msg);
			exit('{"code":1,"msg":"succ"}');
		}else{
			('{"code":-1,"msg":"提交失败'.$DB->errorCode().'"}');
		}
break;	
case 'sendcode':
	$situation=trim(daddslashes($_POST['situation']));
	$target=trim(strip_tags(daddslashes($_POST['target'])));
	if(isset($_SESSION['send_mail']) && $_SESSION['send_mail']>time()-10){
		exit('{"code":-1,"msg":"请勿频繁发送验证码"}');
	}
	if($conf['mail_cloud']==2){
	include_once SYSTEM_ROOT.'oreo_function/plugin/oreo_sms.php';		
	$phone=$userrow['phone'];	
	$token=$conf['oreo_smstoken'];
    $oreosms=oreo_smsgts($token);
    $arr = json_decode($oreosms, JSON_UNESCAPED_UNICODE);
    $getsid=$arr["getsid"]; 	
	$getskey=$arr["getskey"]; 
	require_once SYSTEM_ROOT.'oreo_function/other/class.geetestlib.php';
	$GtSdk = new GeetestLib($getsid, $getskey);
	$data = array(
		'user_id' => 'public', # 网站用户id
		'client_type' => "web", # web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
		'ip_address' => $clientip # 请在此处传输用户请求验证时所携带的IP
	);

	if ($_SESSION['gtserver'] == 1) {   //服务器正常
		$result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
		if ($result) {
			//echo '{"status":"success"}';
		} else{
			exit('{"code":-1,"msg":"验证失败，请重新验证"}');
		}
	}else{  //服务器宕机,走failback模式
		if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
			//echo '{"status":"success"}';
		}else{
			exit('{"code":-1,"msg":"验证失败，请重新验证"}');
		}
	}
	
	$row=$DB->query("select * from oreo_regcode where email='$phone' order by id desc limit 1")->fetch();
	if($row['time']>time()-60){
		exit('{"code":-1,"msg":"两次发送短信之间需要相隔60秒！"}');
	}
	$count=$DB->query("select count(*) from oreo_regcode where email='$phone' and time>'".(time()-3600*24)."'")->fetchColumn();
	if($count>2){
		exit('{"code":-1,"msg":"该手机号码发送次数过多，请更换号码！"}');
	}
	$count=$DB->query("select count(*) from oreo_regcode where ip='$clientip' and time>'".(time()-3600*24)."'")->fetchColumn();
	if($count>5){
		exit('{"code":-1,"msg":"你今天发送次数过多，已被禁止注册"}');
	}
	$web_name=$conf['web_name'];
	if(!$web_name){$web_name='Oreo支付系统';}
	$code = rand(111111,999999);
	$result = oreo_sms($token, $phone, $code, $web_name);
	$arr = json_decode($result, JSON_UNESCAPED_UNICODE);
    $jsoncode=$arr["result"]; 	
	if($jsoncode==0){
		if($DB->exec("insert into `oreo_regcode` (`type`,`code`,`email`,`time`,`ip`,`status`) values ('3','".$code."','".$phone."','".time()."','".$clientip."','0')")){
			$_SESSION['send_mail']=time();
			exit('{"code":0,"msg":"succ"}');
		}else{
			exit('{"code":-1,"msg":"写入数据库失败。'.$DB->errorCode().'"}');
		}
	}else{
		exit('{"code":-1,"msg":"短信发送失败"}');
	}
	
	}else{
	require_once SYSTEM_ROOT.'oreo_function/other/class.geetestlib.php';
	$GtSdk = new GeetestLib($conf['CAPTCHA_ID'], $conf['PRIVATE_KEY']);

	$data = array(
		'user_id' => $pid, # 网站用户id
		'client_type' => "web", # web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
		'ip_address' => $clientip # 请在此处传输用户请求验证时所携带的IP
	);

	if ($_SESSION['gtserver'] == 1) {   //服务器正常
		$result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
		if ($result) {
			//echo '{"status":"success"}';
		} else{
			exit('{"code":-1,"msg":"验证失败，请重新验证"}');
		}
	}else{  //服务器宕机,走failback模式
		if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
			//echo '{"status":"success"}';
		}else{
			exit('{"code":-1,"msg":"验证失败，请重新验证"}');
		}
	}
	if($conf['verifytype']==1){
		if($situation=='bind'){
			$phone=$target;
			if(empty($phone) || strlen($phone)!=11){
				exit('{"code":-1,"msg":"请填写正确的手机号码！"}');
			}
			if($phone==$userrow['phone']){
				exit('{"code":-1,"msg":"你填写的手机号码和之前一样"}');
			}
			$row=$DB->query("select * from oreo_user where phone='$target' limit 1")->fetch();
			if($row){
				exit('{"code":-1,"msg":"该手机号码已经绑定过其它商户"}');
			}
		}else{
			if(empty($userrow['phone']) || strlen($userrow['phone'])!=11){
				exit('{"code":-1,"msg":"请先绑定手机号码！"}');
			}
			$phone=$userrow['phone'];
		}
		$row=$DB->query("select * from oreo_regcode where email='$phone' order by id desc limit 1")->fetch();
		if($row['time']>time()-60){
			exit('{"code":-1,"msg":"两次发送短信之间需要相隔60秒！"}');
		}
		$count=$DB->query("select count(*) from oreo_regcode where email='$phone' and time>'".(time()-3600*24)."'")->fetchColumn();
		if($count>2){
			exit('{"code":-1,"msg":"该手机号码发送次数过多，暂无法发送！"}');
		}
		$count=$DB->query("select count(*) from oreo_regcode where ip='$clientip' and time>'".(time()-3600*24)."'")->fetchColumn();
		if($count>5){
			exit('{"code":-1,"msg":"你今天发送次数过多，已被禁止发送"}');
		}
		$code = rand(111111,999999);
		$result = send_sms($phone, $code, '4');
		if($result===true){
			if($DB->exec("insert into `oreo_regcode` (`type`,`code`,`email`,`time`,`ip`,`status`) values ('3','".$code."','".$phone."','".time()."','".$clientip."','0')")){
				$_SESSION['send_mail']=time();
				exit('{"code":0,"msg":"succ"}');
			}else{
				exit('{"code":-1,"msg":"写入数据库失败。'.$DB->errorCode().'"}');
			}
		}else{
			exit('{"code":-1,"msg":"短信发送失败 '.$result.'"}');
		}
	}else{
		if($situation=='bind'){
			$email=$target;
			if(!preg_match('/^[A-z0-9._-]+@[A-z0-9._-]+\.[A-z0-9._-]+$/', $email)){
				exit('{"code":-1,"msg":"邮箱格式不正确"}');
			}
			if($email==$userrow['email']){
				exit('{"code":-1,"msg":"你填写的邮箱和之前一样"}');
			}
			$row=$DB->query("select * from oreo_user where email='$email' limit 1")->fetch();
			if($row){
				exit('{"code":-1,"msg":"该邮箱已经绑定过其它商户"}');
			}
		}else{
			if(empty($userrow['email']) || strpos($userrow['email'],'@')===false){
				exit('{"code":-1,"msg":"请先绑定邮箱！"}');
			}
			$email=$userrow['email'];
		}
		$row=$DB->query("select * from oreo_regcode where email='$email' order by id desc limit 1")->fetch();
		if($row['time']>time()-60){
			exit('{"code":-1,"msg":"两次发送邮件之间需要相隔60秒！"}');
		}
		$count=$DB->query("select count(*) from oreo_regcode where email='$email' and time>'".(time()-3600*24)."'")->fetchColumn();
		if($count>6){
			exit('{"code":-1,"msg":"该邮箱发送次数过多，请更换邮箱！"}');
		}
		$count=$DB->query("select count(*) from oreo_regcode where ip='$clientip' and time>'".(time()-3600*24)."'")->fetchColumn();
		if($count>10){
			exit('{"code":-1,"msg":"你今天发送次数过多，已被禁止发送"}');
		}
		$sub = $conf['web_name'].' - 验证码获取';
		$code = rand(1111111,9999999);
		if($situation=='settle')$msg = '您正在修改结算账号信息，验证码是：'.$code;
		elseif($situation=='mibao')$msg = '您正在修改密保邮箱，验证码是：'.$code;
		elseif($situation=='bind')$msg = '您正在绑定新邮箱，验证码是：'.$code;
		else $msg = '您的验证码是：'.$code;
		$result = send_mail($email, $sub, $msg);
		if($result===true){
			if($DB->exec("insert into `oreo_regcode` (`type`,`code`,`email`,`time`,`ip`,`status`) values ('2','".$code."','".$email."','".time()."','".$clientip."','0')")){
				$_SESSION['send_mail']=time();
				exit('{"code":0,"msg":"succ"}');
			}else{
				exit('{"code":-1,"msg":"写入数据库失败。'.$DB->errorCode().'"}');
			}
		}else{
			file_put_contents('mail.log',$result);
			exit('{"code":-1,"msg":"邮件发送失败"}');
		}
	}
	}
break;
case 'sendcodeemail':
		if($situation=='bind'){
			$email=$target;
			if(!preg_match('/^[A-z0-9._-]+@[A-z0-9._-]+\.[A-z0-9._-]+$/', $email)){
				exit('{"code":-1,"msg":"邮箱格式不正确"}');
			}
			if($email==$userrow['email']){
				exit('{"code":-1,"msg":"你填写的邮箱和之前一样"}');
			}
			$row=$DB->query("select * from oreo_user where email='$email' limit 1")->fetch();
			if($row){
				exit('{"code":-1,"msg":"该邮箱已经绑定过其它商户"}');
			}
		}else{
			if(empty($userrow['email']) || strpos($userrow['email'],'@')===false){
				exit('{"code":-1,"msg":"请先绑定邮箱！"}');
			}
			$email=$userrow['email'];
		}
		$row=$DB->query("select * from oreo_regcode where email='$email' order by id desc limit 1")->fetch();
		if($row['time']>time()-60){
			exit('{"code":-1,"msg":"两次发送邮件之间需要相隔60秒！"}');
		}
		$count=$DB->query("select count(*) from oreo_regcode where email='$email' and time>'".(time()-3600*24)."'")->fetchColumn();
		if($count>6){
			exit('{"code":-1,"msg":"该邮箱发送次数过多，请更换邮箱！"}');
		}
		$count=$DB->query("select count(*) from oreo_regcode where ip='$clientip' and time>'".(time()-3600*24)."'")->fetchColumn();
		if($count>10){
			exit('{"code":-1,"msg":"你今天发送次数过多，已被禁止发送"}');
		}
		$sub = $conf['web_name'].' - 验证码获取';
		$code = rand(1111111,9999999);
		if($situation=='settle')$msg = '您正在修改结算账号信息，验证码是：'.$code;
		elseif($situation=='mibao')$msg = '您正在修改密保邮箱，验证码是：'.$code;
		elseif($situation=='bind')$msg = '您正在绑定新邮箱，验证码是：'.$code;
		else $msg = '您的验证码是：'.$code;
		$result = send_mail($email, $sub, $msg);
		if($result===true){
			if($DB->exec("insert into `oreo_regcode` (`type`,`code`,`email`,`time`,`ip`,`status`) values ('2','".$code."','".$email."','".time()."','".$clientip."','0')")){
				$_SESSION['send_mail']=time();
				exit('{"code":1,"msg":"succ"}');
			}else{
				exit('{"code":-1,"msg":"写入数据库失败。'.$DB->errorCode().'"}');
			}
		}else{
			file_put_contents('mail.log',$result);
			exit('{"code":-1,"msg":"邮件发送失败"}');
		}
break;
case 'verifycode':
	$code=trim(strip_tags(daddslashes($_POST['code'])));
	if($conf['verifytype']==1){
		$row=$DB->query("select * from oreo_regcode where type=3 and code='$code' and email='{$userrow['phone']}' order by id desc limit 1")->fetch();
	}else{
		$row=$DB->query("select * from oreo_regcode where type=2 and code='$code' and email='{$userrow['email']}' order by id desc limit 1")->fetch();
	}
	if(!$row){
		exit('{"code":-1,"msg":"验证码不正确！"}');
	}
	if($row['time']<time()-3600 || $row['status']>0){
		exit('{"code":-1,"msg":"验证码已失效，请重新获取"}');
	}
	$_SESSION['verify_ok']=$pid;
	$DB->exec("update `oreo_regcode` set `status` ='1' where `id`='{$row['id']}'");
	exit('{"code":1,"msg":"succ"}');
break;
case 'edit_info':
    $type=intval($_POST['stype']);
	$account=trim(strip_tags(daddslashes($_POST['account'])));
	$username=trim(strip_tags(daddslashes($_POST['username'])));
	$email=daddslashes(strip_tags($_POST['email']));
	$phone=daddslashes(strip_tags($_POST['phone']));
	$qq=daddslashes(strip_tags($_POST['qq']));
	$url=daddslashes(strip_tags($_POST['url']));

	if($qq==null || $url==null || $account==null || $username==null){
		exit('{"code":-1,"msg":"请确保每项都不为空"}');
	}
	if($type==1 && strlen($account)!=11 && strpos($account,'@')==false){
		exit('{"code":-1,"msg":"请填写正确的支付宝账号！"}');
	}
	if($type==2 && strlen($account)<3){
		exit('{"code":-1,"msg":"请填写正确的微信"}');
	}
	if($qq!=$userrow['qq']){
	$sqs=$DB->exec("update `oreo_user` set  `settle_id` ='{$type}',`account` ='{$account}',`username` ='{$username}',`qq` ='{$qq}',`url` ='{$url}',`email` ='{$email}',`phone` ='{$phone}',`qq_uid` =''  where `id`='$pid'");		
	}else{
		$sqs=$DB->exec("update `oreo_user` set  `settle_id` ='{$type}',`account` ='{$account}',`username` ='{$username}',`qq` ='{$qq}',`url` ='{$url}',`email` ='{$email}',`phone` ='{$phone}'  where `id`='$pid'");
	}		
		exit('{"code":1,"msg":"succ"}');
break;
case 'edit_bind':
	$email=daddslashes(strip_tags($_POST['email']));
	$phone=daddslashes(strip_tags($_POST['phone']));
	$code=daddslashes(strip_tags($_POST['code']));

	if($code==null || $email==null && $phone==null){
		exit('{"code":-1,"msg":"请确保每项都不为空"}');
	}
	if($conf['verifytype']==1){
		$row=$DB->query("select * from oreo_regcode where type=3 and code='$code' and email='$phone' order by id desc limit 1")->fetch();
	}else{
		$row=$DB->query("select * from oreo_regcode where type=2 and code='$code' and email='$email' order by id desc limit 1")->fetch();
	}
	if(!$row){
		exit('{"code":-1,"msg":"验证码不正确！"}');
	}
	if($row['time']<time()-3600 || $row['status']>0){
		exit('{"code":-1,"msg":"验证码已失效，请重新获取"}');
	}
	if($conf['verifytype']==1){
		$sqs=$DB->exec("update `oreo_user` set `phone` ='{$phone}' where `id`='$pid'");
	}else{
		$sqs=$DB->exec("update `oreo_user` set `email` ='{$email}' where `id`='$pid'");
	}
	if($sqs || $DB->errorCode()=='0000'){
		exit('{"code":1,"msg":"succ"}');
	}else{
		exit('{"code":-1,"msg":"保存失败！'.$DB->errorCode().'"}');
	}
break;
case 'checkbind':
	if($conf['verifytype']==1 && (empty($userrow['phone']) || strlen($userrow['phone'])!=11)){
		exit('{"code":1,"msg":"bind"}');
	}elseif($conf['verifytype']==0 && (empty($userrow['email']) || strpos($userrow['email'],'@')===false)){
		exit('{"code":1,"msg":"bind"}');
	}elseif(isset($_SESSION['verify_ok']) && $_SESSION['verify_ok']===$pid){
		exit('{"code":1,"msg":"bind"}');
	}else{
		exit('{"code":2,"msg":"need verify"}');
	}
break;
case 'edit_Guanbisvip':
	$row_vip=$DB->query("select * from oreo_viporder where uid='$pid' and name='超级会员' and type='1' ")->fetch();
	if(!$row_vip)exit('{"code":-1,"msg":"无会员信息"}');
	$DB->exec("update `oreo_viporder` set `type` ='0' where uid='$pid' and name='超级会员' ");
	$DB->exec("update `oreo_user` set `ssvip` ='2' where id='$pid' ");
	 exit('{"code":1,"msg":"succ"}');
break;
case 'edit_Kaiqisvip':
	$row_vip=$DB->query("select * from oreo_viporder where uid='$pid' and name='超级会员' and type='0' ")->fetch();
	if(!$row_vip)exit('{"code":-1,"msg":"无会员信息"}');
	$DB->exec("update `oreo_viporder` set `type` ='1' where uid='$pid' and name='超级会员' ");
	$DB->exec("update `oreo_user` set `ssvip` ='1' where id='$pid' ");
	 exit('{"code":1,"msg":"succ"}');
break;
case 'edit_Guanbiali':
	$row_vip=$DB->query("select * from oreo_viporder where uid='$pid' and name='支付宝' and type='1' ")->fetch();
	if(!$row_vip)exit('{"code":-1,"msg":"无会员信息"}');
	$sqs=$DB->exec("update `oreo_viporder` set `type` ='0' where uid='$pid' and name='支付宝' ");
	$sqs=$DB->exec("update `oreo_user` set `alipay` ='2' where id='$pid' ");
	 exit('{"code":1,"msg":"succ"}');
break;
case 'edit_Kaiqiali':
	$row_vip=$DB->query("select * from oreo_viporder where uid='$pid' and name='支付宝' and type='0' ")->fetch();
	if(!$row_vip)exit('{"code":-1,"msg":"无会员信息"}');
	$sqs=$DB->exec("update `oreo_viporder` set `type` ='1' where uid='$pid' and name='支付宝' ");
	$sqs=$DB->exec("update `oreo_user` set `alipay` ='1' where id='$pid' ");
	 exit('{"code":1,"msg":"succ"}');
break;
case 'edit_Guanbiwx':
	$row_vip=$DB->query("select * from oreo_viporder where uid='$pid' and name='微信支付' and type='1' ")->fetch();
	if(!$row_vip)exit('{"code":-1,"msg":"无会员信息"}');
	$sqs=$DB->exec("update `oreo_viporder` set `type` ='0' where uid='$pid' and name='微信支付' ");
	$sqs=$DB->exec("update `oreo_user` set `wxpay` ='2' where id='$pid' ");
	 exit('{"code":1,"msg":"succ"}');
break;	
case 'edit_Kaiqiwx':
	$row_vip=$DB->query("select * from oreo_viporder where uid='$pid' and name='微信支付' and type='0' ")->fetch();
	if(!$row_vip)exit('{"code":-1,"msg":"无会员信息"}');
	$sqs=$DB->exec("update `oreo_viporder` set `type` ='1' where uid='$pid' and name='微信支付' ");
	$sqs=$DB->exec("update `oreo_user` set `wxpay` ='1' where id='$pid' ");
	 exit('{"code":1,"msg":"succ"}');
break;	
case 'edit_Guanbiqq':
	$row_vip=$DB->query("select * from oreo_viporder where uid='$pid' and name='QQ钱包' and type='1' ")->fetch();
	if(!$row_vip)exit('{"code":-1,"msg":"无会员信息"}');
	$sqs=$DB->exec("update `oreo_viporder` set `type` ='0' where uid='$pid' and name='QQ钱包' ");
	$sqs=$DB->exec("update `oreo_user` set `qqpay` ='2' where id='$pid' ");
	 exit('{"code":1,"msg":"succ"}');
break;	
case 'edit_Kaiqiqq':
	$row_vip=$DB->query("select * from oreo_viporder where uid='$pid' and name='QQ钱包' and type='0' ")->fetch();
	if(!$row_vip)exit('{"code":-1,"msg":"无会员信息"}');
	$sqs=$DB->exec("update `oreo_viporder` set `type` ='1' where uid='$pid' and name='QQ钱包' ");
	$sqs=$DB->exec("update `oreo_user` set `qqpay` ='1' where id='$pid' ");
	 exit('{"code":1,"msg":"succ"}');
break;	
case 'edit_chongzhikyes':
	if(isset($_SESSION['Reset_Token']) && $_SESSION['Reset_Token']>time()-3600){
		exit('{"code":-1,"msg":"请勿频繁修改秘钥"}');
	}
	$key = random(11);
	$DB->exec("update `oreo_user` set `key` ='{$key}' where id='$pid'");
	$_SESSION['Reset_Token']=time();
	exit('{"code":1,"msg":"succ"}');
break;	
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}