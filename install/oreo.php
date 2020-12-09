<?php
include("../oreo/Oreo.Cron.php");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
header('Access-Control-Allow-Origin:*');  
@header('Content-Type: application/json; charset=UTF-8');
switch($act){	
case 'edit_Safe':
	$oreo_admin=daddslashes(strip_tags($_POST['oreo_admin']));
	$oreo_password=daddslashes(strip_tags($_POST['oreo_password']));
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
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}