<?php
include("../oreo/Oreo.Cron.php");
if($islogin==1){}else exit('{"code":-3,"msg":"No Login"}');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
header('Access-Control-Allow-Origin:*');  
@header('Content-Type: application/json; charset=UTF-8');
switch($act){
case 'add_oreo_conf':
foreach ($_POST as $k => $value) {
        if($k=='pwd')continue;
        $value=daddslashes($value);
        $DB->query("insert into oreo_config set `k`='{$k}',`v`='{$value}' on duplicate key update `v`='{$value}'");
	}
	if(!empty($_POST['oreo_password'])){
        $pwd =  md5($_POST['oreo_password'].$password_hash);
        $DB->query("update `oreo_config` set `v` ='{$pwd}' where `k`='oreo_password'");
    }
	 exit('{"code":1,"msg":"succ"}');
break;	

case 'Oreo_Out':
    $DB->exec("UPDATE `oreo_config` SET `v` = '' WHERE `oreo_config`.`k` = 'oreo_auth_user'; ");
    $DB->exec("UPDATE `oreo_config` SET `v` = '' WHERE `oreo_config`.`k` = 'oreo_auth_password'; ");
    $DB->exec("UPDATE `oreo_config` SET `v` = '' WHERE `oreo_config`.`k` = 'oreo_auth_ukey'; ");
    exit('{"code":8,"msg":"注销成功"}');
break;
case 'mp3_apply':
$usernum=$DB->query("select * from oreo_apply where type='0'")->fetch();
if($usernum)
	exit('{"code":1,"msg":"succ"}');
else
	exit('{"code":0,"msg":"succ"}');
break;	
case 'shanchu_Order':
$sql="DELETE FROM oreo_order WHERE addtime<=DATE_SUB(NOW(),INTERVAL 5 DAY) ";
if($DB->exec($sql))
	 exit('{"code":1,"msg":"succ"}');
else
	 exit('{"code":-1,"msg":"删除数据失败！"}');
break;
case 'shanchu_Safelog':
$sql="DELETE FROM oreo_log";
if($DB->exec($sql))
	 exit('{"code":1,"msg":"succ"}');
else
	 exit('{"code":-1,"msg":"删除数据失败！"}');
break;			
case 'edit_Kpaytypqqk':
	$id=$_POST['typidkqqk'];
	$sqs=$DB->exec("update `oreo_user` set `qqpay` ='1' where id='{$id}' ");
    if($DB->exec($sql)||$sqs){
		 exit('{"code":1,"msg":"开启成功！"}');
   }else{
	    exit('{"code":-1,"msg":"开启失败！"}');
  }	
break;	  
case 'edit_Kpaytypwxk':
	$id=$_POST['typidkwxk'];
	$sqs=$DB->exec("update `oreo_user` set `wxpay` ='1' where id='{$id}' ");
    if($DB->exec($sql)||$sqs){
		 exit('{"code":1,"msg":"开启成功！"}');
   }else{
	    exit('{"code":-1,"msg":"开启失败！"}');
  }
break;	
case 'edit_ShanchuVip':
$id=$_POST['ids'];
$vname=$_POST['vname'];
$sclx=$_POST['sclx'];
$rows=$DB->query("select * from oreo_viporder where uid='$id' AND name='$vname' limit 1")->fetch();
if(!$rows)
	exit('{"code":-1,"msg":"当前记录不存在！"}');
$urls=explode(',',$rows['url']);
$sql="DELETE FROM oreo_viporder WHERE uid='$id' AND name='$vname'";
$sqs=$DB->exec("update `oreo_user` set `{$sclx}` ='2' where `id`='$id'");	
if($DB->exec($sql))
	 exit('{"code":1,"msg":"succ"}');
else
	 exit('{"code":-1,"msg":"删除vip数据失败！"}');
break;
case 'edit_ShanchuAsk':
$id=$_POST['ids'];
$asknum=$_POST['asknum'];
$rows=$DB->query("select * from oreo_work where uid='$id' AND num='$asknum' limit 1")->fetch();
if(!$rows)
	exit('{"code":-1,"msg":"当前记录不存在！"}');
$urls=explode(',',$rows['url']);
$sql="DELETE FROM oreo_work WHERE uid='$id' AND num='$asknum'";	
if($DB->exec($sql))
	 exit('{"code":1,"msg":"succ"}');
else
	 exit('{"code":-1,"msg":"删除失败！"}');
break;
case 'edit_Kpaytypalik':
	$id=$_POST['typidkalik'];
	$sqs=$DB->exec("update `oreo_user` set `alipay` ='1' where id='{$id}' ");
    if($DB->exec($sql)||$sqs){
		 exit('{"code":1,"msg":"开启成功！"}');
   }else{
	    exit('{"code":-1,"msg":"开启失败！"}');
  }
break;	
case 'edit_Kpaytypqq':
	$id=$_POST['typidkqq'];
	$sqs=$DB->exec("update `oreo_user` set `qqpay` ='2' where id='{$id}' ");
    if($DB->exec($sql)||$sqs){
		 exit('{"code":1,"msg":"关闭成功！"}');
   }else{
	    exit('{"code":-1,"msg":"关闭失败！"}');
  }
break;		
case 'edit_Kpaytypwx':
	$id=$_POST['typidkwx'];
	$sqs=$DB->exec("update `oreo_user` set `wxpay` ='2' where id='{$id}' ");
    if($DB->exec($sql)||$sqs){
		 exit('{"code":1,"msg":"关闭成功！"}');
   }else{
	    exit('{"code":-1,"msg":"关闭失败！"}');
  }
break;	
case 'edit_Kpaytypali':
	$id=$_POST['typidk'];
	$sqs=$DB->exec("update `oreo_user` set `alipay` ='2' where id='{$id}' ");
    if($DB->exec($sql)||$sqs){
		 exit('{"code":1,"msg":"关闭成功！"}');
   }else{
	    exit('{"code":-1,"msg":"关闭失败！"}');
  }
break;	
case 'edit_Shujku':
	$id=$_POST['jkid'];
    $money=$_POST['jkje'];
    $fl=$_POST['jksxf'];
    if($id==NULL or $money==NULL){
		 exit('{"code":-1,"msg":"请确保加*项都不为空"}');
    }else{
    $addmoney=round($money*$fl/100,2);
    $DB->query("update oreo_user set money=money+{$addmoney} where id='{$id}'");
	exit('{"code":1,"msg":"商户加款成功！商户ID：'.$id.'<br/>加款金额：'.$addmoney.'"}');
}
break;		
case 'edit_Newgonggao':
	$name=daddslashes(strip_tags($_POST['namet']));
	$text=$_POST['textt'];
	$type=daddslashes(strip_tags($_POST['typet']));
	$addtime=date("Y-m-d");
    $sds=$DB->exec("INSERT INTO `oreo_notice` (`name`, `text`, `type`, `dtime`) VALUES ('{$name}', '{$text}', '{$type}', '{$addtime}')");
	exit('{"code":1,"msg":"添加成功"}');
break;
case 'edit_Hzzxtianjia':
	$user=daddslashes(strip_tags($_POST['usert']));
	$pwd=daddslashes(strip_tags($_POST['pwdt']));
	$name=daddslashes(strip_tags($_POST['namet']));
	$level=daddslashes(strip_tags($_POST['levelt']));
	$active=daddslashes(strip_tags($_POST['activet']));
    if($user==NULL or $pwd==NULL){
     exit('{"code":-1,"msg":"保存错误,用户名和密码是必填"}');
     } else {
     $token = md5(random(24));
     $sds=$DB->exec("INSERT INTO `oreo_panuser` (`user`, `pwd`, `name`, `token`, `level`, `active`, `regtime`) VALUES ('{$user}', '{$pwd}', '{$name}', '{$token}', '{$level}', '{$active}', '{$date}')");
     $pid=$DB->lastInsertId();
     if($sds){
		 exit('{"code":1,"msg":"添加成功！合作者身份TOKEN：'.$token.'"}');
}else
        exit('{"code":-1,"msg":"添加失败！"}');
}
break;	
case 'edit_Xtianjia':
	$settle_id=daddslashes(strip_tags($_POST['settle_id']));
	$username=daddslashes(strip_tags($_POST['usernamea']));
	$account=daddslashes(strip_tags($_POST['accounta']));
	$money=daddslashes(strip_tags($_POST['moneya']));
	$url=daddslashes(strip_tags($_POST['urla']));
	$email=daddslashes(strip_tags($_POST['emaila']));
	$qq=daddslashes(strip_tags($_POST['qqa']));
	$phonea=daddslashes(strip_tags($_POST['phonea']));
	$password = md5($_POST['passworda'].$password_hash);
	$zdyfl=daddslashes(strip_tags($_POST['zdyfl']));
	$rate=daddslashes(strip_tags($_POST['ratea']));
	$salipay_rate=daddslashes(strip_tags($_POST['salipay_ratea']));
	$sweixin_rate=daddslashes(strip_tags($_POST['sweixin_ratea']));
	$sqq_rate=daddslashes(strip_tags($_POST['sqq_ratea']));
	$type=daddslashes(strip_tags($_POST['type']));
	$active=daddslashes(strip_tags($_POST['active']));
    if($account==NULL or $username==NULL){
     exit('{"code":-1,"msg":"保存错误,用户名和结算账户是必填"}');
     } else {
     $key = random(11);
     $sds=$DB->exec("INSERT INTO `oreo_user` (`key`, `account`, `username`, `money`, `url`, `addtime`, `type`, `settle_id`, `email`, `qq`, `phone`, `password`, `zdyfl`, `rate`, `salipay_rate`,  `sweixin_rate`,  `sqq_rate`, `active`, `ssvip`) VALUES ('{$key}', '{$account}', '{$username}', '{$money}', '{$url}', '{$date}', '{$type}', '{$settle_id}', '{$email}', '{$qq}', '{$phonea}', '{$password}', '{$zdyfl}', '{$rate}', '{$salipay_rate}', '{$sweixin_rate}', '{$sqq_rate}', '{$active}', '2')");
     $pid=$DB->lastInsertId();
     if($sds){
		 exit('{"code":1,"msg":"商户ID：'.$pid.'<br/>密钥：'.$key.'"}');
}else
        exit('{"code":-1,"msg":"添加商户失败！"}');
}
break;	
case 'edit_ShuanchuAd':
$id=$_POST['ids'];
$sql=$DB->exec("DELETE FROM oreo_notice WHERE id='$id'");
exit('{"code":1,"msg":"succ"}');
break;
case 'edit_Hzzshanchu':
$id=$_POST['ids'];
$rows=$DB->query("select * from oreo_panuser where id='$id' limit 1")->fetch();
if(!$rows)
	exit('{"code":-1,"msg":"当前记录不存在！"}');
$urls=explode(',',$rows['url']);
$sql="DELETE FROM oreo_panuser WHERE id='$id'";
if($DB->exec($sql))
	 exit('{"code":1,"msg":"succ"}');
else
	 exit('{"code":-1,"msg":"删除商户失败！"}');
break;				
case 'edit_Shanchu':
$id=$_POST['ids'];
$rows=$DB->query("select * from oreo_user where id='$id' limit 1")->fetch();
if(!$rows)
	exit('{"code":-1,"msg":"当前记录不存在！"}');
$urls=explode(',',$rows['url']);
$sql="DELETE FROM oreo_user WHERE id='$id'";
if($DB->exec($sql))
	 exit('{"code":1,"msg":"succ"}');
else
	 exit('{"code":-1,"msg":"删除商户失败！"}');
break;	
case 'edit_NewgonggaoXiugai':
	$id=daddslashes(strip_tags($_POST['id']));
	$name=daddslashes(strip_tags($_POST['name']));
	$text=$_POST['text'];
	$type=daddslashes(strip_tags($_POST['type']));
    $sqs=$DB->exec("update `oreo_notice` set `name` ='{$name}',`text` ='{$text}',`type` ='{$type}' where `id`='$id' ");
	   exit('{"code":1,"msg":"succ"}');
break;
case 'edit_Hzzxiugai':
	$id=daddslashes(strip_tags($_POST['id']));
	$user=daddslashes(strip_tags($_POST['user']));
	$pwd=daddslashes(strip_tags($_POST['pwd']));
	$name=daddslashes(strip_tags($_POST['name']));
	$token=daddslashes(strip_tags($_POST['token']));
	$level=daddslashes(strip_tags($_POST['level']));
	$active=daddslashes(strip_tags($_POST['active']));
	$resetkey=daddslashes(strip_tags($_POST['resetkey']));
    if($_POST['resetkey']==1){
       $token = random(24);
   }else{
	   $token=$_POST['token'];
   }
       $sqs=$DB->exec("update `oreo_panuser` set `user` ='{$user}',`pwd` ='{$pwd}',`name` ='{$name}',`level` ='{$level}',`token` ='{$token}',`active` ='{$active}' where `id`='$id' ");
	   exit('{"code":1,"msg":"succ"}');
break;
case 'sdjs_Yjs':
	$uid=daddslashes(strip_tags($_POST['uid']));
	$ids=daddslashes(strip_tags($_POST['ids']));
	$sdjs=$DB->query("select * from oreo_apply where id='{$ids}' and uid='{$uid}' limit 1")->fetch();
	$usermon=$DB->query("select * from oreo_user where id='{$uid}' limit 1")->fetch();
	$umoney=$usermon['money'];
	$newmoney=$sdjs['money'];
	if($umoney<$newmoney)exit('{"code":-1,"msg":"结算申请失败<br>当前用户余额：'.$umoney.'&nbsp;元<br>结算金额：'.$newmoney.'&nbsp;元<br>用户余额小于结算金额，故不能进行有关操作。"}');
    $sqs=$DB->exec("update `oreo_apply` set `type` ='1'  where `uid`='$uid' ");
	$sqss=$DB->exec("update `oreo_user` set `apply` ='0', money=money-{$newmoney} where `id`='$uid' ");
	exit('{"code":1,"msg":"succ"}');
break;
case 'sdjs_Bhui':
	$uid=daddslashes(strip_tags($_POST['uid']));
	$ids=daddslashes(strip_tags($_POST['ids']));
	$sql=$DB->exec("DELETE FROM oreo_apply WHERE id='$ids' and uid='$uid'");	
    $sqss=$DB->exec("update `oreo_user` set `apply` ='0' where `id`='$uid' ");
	exit('{"code":1,"msg":"succ"}');
break;		
case 'edit_Lxjkxiugai':
	$oreo_lxname=daddslashes(strip_tags($_POST['oreo_lxname']));
	$uid=daddslashes(strip_tags($_POST['uid']));
	$oreo_lxurl=daddslashes(strip_tags($_POST['oreo_lxurl']));
	$oreo_lxid=daddslashes(strip_tags($_POST['oreo_lxid']));
	$oreo_lxkey=daddslashes(strip_tags($_POST['oreo_lxkey']));
	$oreo_lxfs=daddslashes(strip_tags($_POST['oreo_lxfs']));
	$oreo_lxje=daddslashes(strip_tags($_POST['oreo_lxje']));
	$oreo_lxtype=daddslashes(strip_tags($_POST['oreo_lxtype']));
	$rows=$DB->query("select * from oreo_lxjk where  oreo_lxname='$oreo_lxname' ")->fetch();
	if($rows['oreo_lxname']==$oreo_lxname&&$rows['oreo_lxfs']!=$oreo_lxfs){
		if($oreo_lxname==1){
		$oreo_lxnames='支付宝';
		}else if($oreo_lxname==2){
		$oreo_lxnames='微信支付';
		}else if($oreo_lxname==3){
		$oreo_lxnames='QQ钱包';
		}else if($oreo_lxname==4){
		$oreo_lxnames='超级会员';
		}else if($oreo_lxname==5){
		$oreo_lxnames='全部';
		}
		if($rows['oreo_lxfs']==1){
		$oreo_lxfss='按轮流式';
		}else{
		$oreo_lxfss='按金额式';
		}
		exit('{"code":-1,"msg":"修改失败，一个轮寻通道只能添加一种轮寻方式！当前轮询通道：'.$oreo_lxnames.'<br/>已经有开启：'.$oreo_lxfss.'<br/>如需更改模式请删除后添加"}');
	}
	if(!is_numeric($oreo_lxje)&&$oreo_lxfs==2){
		exit('{"code":-3,"msg":"succ"}');
	}
	if($oreo_lxfs==1){
		$oreo_lxje='';
	}
	$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lxname` ='$oreo_lxname',`oreo_lxurl` ='{$oreo_lxurl}',`oreo_lxid` ='{$oreo_lxid}',`oreo_lxkey` ='{$oreo_lxkey}',`oreo_lxtype` ='{$oreo_lxtype}',`oreo_lxfs` ='{$oreo_lxfs}',`oreo_lxje` ='{$oreo_lxje}'  where `id`='$uid'");
    exit('{"code":1,"msg":"succ"}');
break;	
case 'delete_codeAli':
$ids=daddslashes(strip_tags($_POST['ids']));
$rows=$DB->query("select * from oreo_user where id='$ids' limit 1")->fetch();
	$str = $rows['alipaycode'];
    $Array=explode('/',$str);
	unlink ( '../user/upload/mycode/'.$Array['6'] );
$sqs=$DB->exec("update `oreo_user` set `alipaycode` ='' where `id`='$ids'");	
 exit('{"code":1,"msg":"succ"}');
break;
case 'delete_codeWx':
$ids=daddslashes(strip_tags($_POST['ids']));
$rows=$DB->query("select * from oreo_user where id='$ids' limit 1")->fetch();
	$str = $rows['wxpaycode'];
    $Array=explode('/',$str);
	unlink ( '../user/upload/mycode/'.$Array['6'] );
$sqs=$DB->exec("update `oreo_user` set `wxpaycode` ='' where `id`='$ids'");	
 exit('{"code":1,"msg":"succ"}');
break;
case 'delete_codeQq':
$ids=daddslashes(strip_tags($_POST['ids']));
$rows=$DB->query("select * from oreo_user where id='$ids' limit 1")->fetch();
	$str = $rows['qqpaycode'];
    $Array=explode('/',$str);
	unlink ( '../user/upload/mycode/'.$Array['6'] );
$sqs=$DB->exec("update `oreo_user` set `qqpaycode` ='' where `id`='$ids'");	
 exit('{"code":1,"msg":"succ"}');
break;
case 'edit_Lxjktianjia':
	$oreo_lxname=daddslashes(strip_tags($_POST['oreo_lxname']));
	$oreo_lxurl=daddslashes(strip_tags($_POST['oreo_lxurl']));
	$oreo_lxid=daddslashes(strip_tags($_POST['oreo_lxid']));
	$oreo_lxkey=daddslashes(strip_tags($_POST['oreo_lxkey']));
	$oreo_lxtype=daddslashes(strip_tags($_POST['oreo_lxtype']));
	$oreo_lxfs=daddslashes(strip_tags($_POST['oreo_lxfs']));
	$oreo_lxje=daddslashes(strip_tags($_POST['oreo_lxje']));
	$rows=$DB->query("select * from oreo_lxjk where  oreo_lxname='$oreo_lxname' ")->fetch();
	if($rows['oreo_lxname']==$oreo_lxname&&$rows['oreo_lxfs']!=$oreo_lxfs){
		if($oreo_lxname==1){
		$oreo_lxnames='支付宝';
		}else if($oreo_lxname==2){
		$oreo_lxnames='微信支付';
		}else if($oreo_lxname==3){
		$oreo_lxnames='QQ钱包';
		}else if($oreo_lxname==4){
		$oreo_lxnames='超级会员';
		}else if($oreo_lxname==5){
		$oreo_lxnames='全部';
		}
		if($rows['oreo_lxfs']==1){
		$oreo_lxfss='按轮流式';
		}else{
		$oreo_lxfss='按金额式';
		}
		exit('{"code":-1,"msg":"添加失败，一个轮寻通道只能添加一种轮寻方式！当前轮询通道：'.$oreo_lxnames.'<br/>已经有开启：'.$oreo_lxfss.'"}');
	}
	if(!is_numeric($oreo_lxje)&&$oreo_lxfs==2){
		exit('{"code":-3,"msg":"succ"}');
	}
	$oreo_lxknum = 0;
	$sds=$DB->exec("INSERT INTO `oreo_lxjk` (`oreo_lxname`, `oreo_lxurl`, `oreo_lxid`, `oreo_lxkey`, `oreo_lxtype`, `oreo_lxfs`, `oreo_lxje`, `oreo_lxknum`, `oreo_lrje`) VALUES ('{$oreo_lxname}', '{$oreo_lxurl}', '{$oreo_lxid}', '{$oreo_lxkey}', '{$oreo_lxtype}', '{$oreo_lxfs}', '{$oreo_lxje}', '{$oreo_lxknum}', '0')");
    exit('{"code":1,"msg":"succ"}');
break;	
case 'edit_shanchuLxjk':
$id=$_POST['ids'];
$sql="DELETE FROM oreo_lxjk WHERE id='$id'";	
if($DB->exec($sql))
	 exit('{"code":1,"msg":"succ"}');
else
	 exit('{"code":-1,"msg":"删除数据失败！"}');
break;
case 'edit_qingkongshuju':
$id=$_POST['ids'];
$sqs=$DB->exec("update `oreo_lxjk` set `oreo_lrje` ='0' where `id`='$id'");	
	 exit('{"code":1,"msg":"succ"}');
break;
case 'edit_Xiugai':
	$id=daddslashes(strip_tags($_POST['id']));
	$settle_id=daddslashes(strip_tags($_POST['settle_id']));
	$username=daddslashes(strip_tags($_POST['username']));
	$account=daddslashes(strip_tags($_POST['account']));
	$key=daddslashes(strip_tags($_POST['key']));
	$money=daddslashes(strip_tags($_POST['money']));
	$url=daddslashes(strip_tags($_POST['url']));
	$email=daddslashes(strip_tags($_POST['email']));
	$qq=daddslashes(strip_tags($_POST['qq']));
	$phone=daddslashes(strip_tags($_POST['phone']));
	$password = md5($_POST['password'].$password_hash);
	$zdyfl=daddslashes(strip_tags($_POST['zdyfl']));
	$rate=daddslashes(strip_tags($_POST['rate']));
	$salipay_rate=daddslashes(strip_tags($_POST['salipay_rate']));
	$sweixin_rate=daddslashes(strip_tags($_POST['sweixin_rate']));
	$sqq_rate=daddslashes(strip_tags($_POST['sqq_rate']));
	$type=daddslashes(strip_tags($_POST['type']));
	$active=daddslashes(strip_tags($_POST['active']));
	$resetkey=daddslashes(strip_tags($_POST['resetkey']));
    if($_POST['resetkey']==1){
       $key = random(11);
   }else{
	   $key=$_POST['key'];
   }
   $rows=$DB->query("select * from oreo_user where id='$id' limit 1")->fetch();
   if ($rows['password']==$_POST['password']){
       $sqs=$DB->exec("update `oreo_user` set `account` ='{$account}',`username` ='{$username}',`key` ='{$key}',`money` ='{$money}',`url` ='{$url}',`type` ='$type',`settle_id` ='$settle_id',`email` ='$email',`qq` ='$qq',`phone` ='$phone',`zdyfl` ='{$zdyfl}',`rate` ='{$rate}',`salipay_rate` ='{$salipay_rate}',`sweixin_rate` ='{$sweixin_rate}',`sqq_rate` ='{$sqq_rate}',`active` ='$active' where `id`='$id' ");
  }else{
      $sqs=$DB->exec("update `oreo_user` set `account` ='{$account}',`username` ='{$username}',`key` ='{$key}',`money` ='{$money}',`url` ='{$url}',`type` ='$type',`settle_id` ='$settle_id',`email` ='$email',`qq` ='$qq',`phone` ='$phone',`password` ='{$password}',`zdyfl` ='{$zdyfl}',`rate` ='{$rate}',`salipay_rate` ='{$salipay_rate}',`sweixin_rate` ='{$sweixin_rate}',`sqq_rate` ='{$sqq_rate}',`active` ='$active' where `id`='$id'");
  }
  
	 exit('{"code":1,"msg":"succ"}');
break;			
case 'edit_SvipGuan':
    $uids=daddslashes(strip_tags($_POST['uids']));
	$hylx=daddslashes(strip_tags($_POST['hylx']));
    $leixing=daddslashes(strip_tags($_POST['leixing']));
	$sqs=$DB->exec("update `oreo_viporder` set `type` ='0' where uid='$uids' and name='$hylx' ");
	$sqs=$DB->exec("update `oreo_user` set `$leixing` ='2' where id='$uids' ");
	 exit('{"code":1,"msg":"succ"}');
break;	
case 'edit_SvipKai':
    $kuids=daddslashes(strip_tags($_POST['kuids']));
	$khylx=daddslashes(strip_tags($_POST['khylx']));
    $kleixing=daddslashes(strip_tags($_POST['kleixing']));
	$sqs=$DB->exec("update `oreo_viporder` set `type` ='1' where uid='$kuids' and name='$khylx' ");
	$sqs=$DB->exec("update `oreo_user` set `$kleixing` ='1' where id='$kuids' ");
	 exit('{"code":1,"msg":"succ"}');
break;	
case 'edit_Svip':
    $chaojivip=daddslashes(strip_tags($_POST['chaojivip']));
	$chaoji_money=daddslashes(strip_tags($_POST['chaoji_money']));
	$chaoji_js=daddslashes(strip_tags($_POST['chaoji_js']));
	$ssvip_zt=daddslashes(strip_tags($_POST['ssvip_zt']));
	$ssvip_url=daddslashes(strip_tags($_POST['ssvip_url']));
	$ssvip_id=daddslashes(strip_tags($_POST['ssvip_id']));
	$ssvip_key=daddslashes(strip_tags($_POST['ssvip_key']));
	$alivip=daddslashes(strip_tags($_POST['alivip']));
	$alivip_money=daddslashes(strip_tags($_POST['alivip_money']));
	$alivip_js=daddslashes(strip_tags($_POST['alivip_js']));
	$wxvip=daddslashes(strip_tags($_POST['wxvip']));
	$wxvip_money=daddslashes(strip_tags($_POST['wxvip_money']));
	$wxvip_js=daddslashes(strip_tags($_POST['wxvip_js']));
	$qqvip=daddslashes(strip_tags($_POST['qqvip']));
	$qqvip_money=daddslashes(strip_tags($_POST['qqvip_money']));
	$qqvip_js=daddslashes(strip_tags($_POST['qqvip_js']));
	foreach ($_POST as $k => $value) {
        if($k=='pwd')continue;
	if($chaojivip==0){
		$sqs=$DB->exec("update `oreo_user` set `ssvip` ='1'");
	}
	else{
		$sqs=$DB->exec("update `oreo_user` set `ssvip` ='2'");		
		$listss=$DB->query("SELECT * FROM oreo_viporder WHERE  name='超级会员' AND type='1' ")->fetchAll();
        foreach($listss as $resvs){
		$namevs=$resvs['uid'];
		$sqs=$DB->exec("update `oreo_user` set `ssvip` ='1' where id='$namevs' ");
		}
	}	
	if($alivip==0){
		$sqs=$DB->exec("update `oreo_user` set `alipay` ='1'");
	}
	else{
		$sqs=$DB->exec("update `oreo_user` set `alipay` ='2'");		
		$list=$DB->query("SELECT * FROM oreo_viporder WHERE  name='支付宝' AND type='1' ")->fetchAll();
        foreach($list as $res){
		$names=$res['uid'];
		$sqs=$DB->exec("update `oreo_user` set `alipay` ='1' where id='$names' ");
		}
	}
	if($wxvip==0){
		$sqs=$DB->exec("update `oreo_user` set `wxpay` ='1'");
	}
	else{
		$sqs=$DB->exec("update `oreo_user` set `wxpay` ='2'");
		$wxzf=$DB->query("SELECT * FROM oreo_viporder WHERE  name='微信支付' AND type='1' ")->fetchAll();
		foreach($wxzf as $resw){
		$namesw=$resw['uid'];
		$sqs=$DB->exec("update `oreo_user` set `wxpay` ='1' where id='$namesw' ");
		}
	}
	if($qqvip==0){
		$sqs=$DB->exec("update `oreo_user` set `qqpay` ='1'");
	}
	else{
		$sqs=$DB->exec("update `oreo_user` set `qqpay` ='2'");
		$qqqb=$DB->query("SELECT * FROM oreo_viporder WHERE  name='QQ钱包' AND type='1' ")->fetchAll();
		foreach($qqqb as $resq){
		$namesq=$resq['uid'];
		$sqs=$DB->exec("update `oreo_user` set `qqpay` ='1' where id='$namesq' ");
		}
	}
        $value=daddslashes($value);
        $DB->query("insert into oreo_config set `k`='{$k}',`v`='{$value}' on duplicate key update `v`='{$value}'");
    }
	 exit('{"code":1,"msg":"succ"}');
break;				
case 'edit_Huifu':
	$num=($_POST['num']);	
	$qqmail=($_POST['qq']);	
	$huifu=daddslashes(strip_tags($_POST['huifu']));
	$active=daddslashes(strip_tags($_POST['active']));
		if($active==1 && $qqmail!=''){
		$wdata=date("Y-m-d");
		$sqs=$DB->exec("update `oreo_work` set `huifu` ='{$huifu}',`wdata` ='{$wdata}',`active` ='{$active}' where `num`='$num'");
		$qqemail=$qqmail.'@qq.com';
        $siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].'/';
		$sub = $conf['web_name'].' - 您提交的工单已有回复';
		$msg = '<h2>您的工单已有新的进展</h2>尊敬的商户您好【'.$conf['web_name'].'】对你的工单进行了回复<br/>工单编号为：'.$num.'的工单已经有最新的进展啦！<br/>请尽快登录后台查看详细内容：【<a href="'.$siteurl.'" target="_blank">登录后台</a>】<br/>';
		$result = send_mail($qqemail, $sub, $msg);
		exit('{"code":1,"msg":"succ"}');
		}else{
			$wdata=date("Y-m-d");
		$sqs=$DB->exec("update `oreo_work` set `huifu` ='{$huifu}',`wdata` ='{$wdata}',`active` ='{$active}' where `num`='$num'");
		exit('{"code":1,"msg":"succ"}');
		}
break;
case 'oreo_auth_login_new':
	$oreo_user=daddslashes(strip_tags($_POST['oreo_user']));//oreo账号
	$oreo_pwd=daddslashes(strip_tags($_POST['oreo_pwd']));//oreo密码
	$domain=$_SERVER['HTTP_HOST'];//当前域名
	$xieyi=(int)$_SERVER['SERVER_PORT'] == 80 ? 'http://': 'https://';//当前网站协议
	//前端传输安全验证
	$module=daddslashes(strip_tags($_POST['module']));//安全码
	$adtime=daddslashes(strip_tags($_POST['adtime']));//时间戳
	$codes_two=daddslashes(strip_tags($_POST['codes_two']));//验证码2
	$shah_out=sha1($module.'or#$Login@%!^*eo*@#code'.$adtime);//先sha1加密
	$token_auth = md5($shah_out); //本地生成一个token
	if($codes_two != $token_auth)exit('{"code":"-1","msg":"非法操作"}');
	//以上参数都通过
	//给Oreo综合服务器安全验证
	$safe=md5($shah_out);//后进行MD5加密
	$oreo="1hD9aA9LogincB12yXAxq0Us";//集体密钥
	//提交OreoAuth函数
	include_once SYSTEM_ROOT.'oreo_function/plugin/oreo_login.php';	
	$response = OreoLogin($xieyi,$domain,$module, $adtime, $safe, $oreo, $oreo_user, $oreo_pwd);
	$data = json_decode($response, true);  //解析获取的Json
	$code=$data['code'];//返回code 
	$msg=$data['msg'];//返回msg
	exit('{"code":'.$code.',"msg":"'.$msg.'"}');  
break;
    case 'add_oreo_credit':
        $xname=daddslashes(strip_tags($_POST['xname']));//失信人姓名
        $xqq=daddslashes(strip_tags($_POST['xqq']));//失信人QQ号
        $xemail=daddslashes(strip_tags($_POST['xemail']));//失信人邮箱
        $xphone=daddslashes(strip_tags($_POST['xphone']));//失信人电话
        $xaid=daddslashes(strip_tags($_POST['xaid']));//失信人结算账户
        $xdomain=daddslashes(strip_tags($_POST['xdomain']));//失信人域名
        $jblx=daddslashes(strip_tags($_POST['jblx']));//举报类型
        $xtext=daddslashes(strip_tags($_POST['xtext']));//提交理由
        $oreo_user=$conf['oreo_auth_user'];//Oreo账号
        //提交OreoAuth函数
        include_once SYSTEM_ROOT.'oreo_function/plugin/oreo_credit.php';
        $response = OreoCredit_Add($xname,$xqq,$xemail,$xphone,$xaid,$xdomain,$jblx,$xtext,$oreo_user);
        $data = json_decode($response, true);  //解析获取的Json
        $code=$data['code'];//返回code
        $msg=$data['msg'];//返回msg
        exit('{"code":'.$code.',"msg":"'.$msg.'"}');
        break;
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}