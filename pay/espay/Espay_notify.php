<?php
require '../includes/common.php';
@header('Content-Type: text/html; charset=UTF-8');
require_once '..//Espay/ESPAY_config.php';
$status=$_POST['status'];
$customerid=$_POST['customerid'];
$sdorderno=$_POST['sdorderno'];
$total_fee=$_POST['total_fee'];
$paytype=$_POST['paytype'];
$sdpayno=$_POST['sdpayno'];
$remark=$_POST['remark'];
$sign=$_POST['sign'];

$mysign=md5('customerid='.$customerid.'&status='.$status.'&sdpayno='.$sdpayno.'&sdorderno='.$sdorderno.'&total_fee='.$total_fee.'&paytype='.$paytype.'&'.$userkey);
global $DB,$date;
if($sign==$mysign){
    if($status=='1'){
      	$srow=$DB->query("SELECT * FROM pay_order WHERE trade_no='{$_POST['sdorderno']}' limit 1 ")->fetch();
      	if($srow['status']==0){
        	$DB->query("update `pay_order` set `status` ='1',`endtime` ='$date' where `trade_no`='{$_POST['sdorderno']}'");
					processOrder($srow);
          echo 'success';
          file_put_contents(SYSTEM_ROOT.'notify.txt','状态效验正确');
        }else {
        	return false;
        }
    } else {
        echo 'fail';
    }
} else {
    echo 'signerr';
}
?>
