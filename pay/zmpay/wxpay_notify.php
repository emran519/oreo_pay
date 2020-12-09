<?php
require_once('../../oreo/Oreo.Cron.php');

@header('Content-Type: text/html; charset=UTF-8');

if (isset($_GET['type'])) $DB->query("update `oreo_order` set `type` ='wxpay',`addtime` ='$date' where `trade_no`='$trade_no'");

require_once SYSTEM_ROOT . "oreo_function/pay/zmpay/Pay.class.php";
require_once SYSTEM_ROOT . "oreo_function/pay/zmpay/config.php";
$protocol = (int)$_SERVER['SERVER_PORT'] == 80 ? 'http://'.$_SERVER['HTTP_HOST'] : 'https://'.$_SERVER['HTTP_HOST'];
$notify_url = $protocol . '/pay/zmpay/wxpay_notify.php';

$pay = new Pay($id, $token);

$data = $_REQUEST;
$out_trade_no = $data['out_trade_no'];
if ($pay->verify($data)) {
    if ($data['trade_status'] == 'TRADE_SUCCESS') {
        $srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1")->fetch();
        $user=$DB->query("select * from oreo_user where id='{$srow['pid']}' limit 1")->fetch();
        if(!$srow) exit('fail');
        if($srow['status']==0){
            if($conf['sw_money_rate']==0 && $user['zdyfl']==0){
                $DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='{$data['out_trade_no']}'");
                $addmoney=round($srow['money']*$conf['money_rate']/100,2);
                $DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
                exit('success');
            }
              if($conf['sw_money_rate']==0 && $user['zdyfl']==1){
                $DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='{$data['out_trade_no']}'");
                $addmoney=round($srow['money']*$user['rate']/100,2);
                $DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
                exit('success');
            }
             if($conf['sw_money_rate']==1 && $user['zdyfl']==0){
                $DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='{$data['out_trade_no']}'");
                $addmoney=round($srow['money']*$conf['weixin_rate']/100,2);
                $DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
                exit('success');
            }
             if($conf['sw_money_rate']==1 && $user['zdyfl']==1){
                $DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='{$data['out_trade_no']}'");
                $addmoney=round($srow['money']*$user['sweixin_rate']/100,2);
                $DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
                exit('success');
            }
        }else{
            exit('success');
        }
    } else {
        exit('fail');
    }
} else {
    exit('fail');
}