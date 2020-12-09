<?php
/* *
 * 码支付同步通知页面
 */

require '../../oreo/Oreo.Cron.php';
require_once(SYSTEM_ROOT."oreo_function/pay/oreo_cpay/config.php");//载入配置文件
# 签名函数
function sign($data_arr) {
    return md5(join('',$data_arr));
};

$sign = sign(array($_GET['trade_no'], $_GET['type'], $_GET['money'], $_GET['reallyPrice'], $oreo_cpay['app_key']));
# 对比签名
if($sign == $_GET['sign']) {
    $out_trade_no = daddslashes($_GET['trade_no']);
    $srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1")->fetch();
    $user=$DB->query("select * from oreo_user where id='{$srow['pid']}' limit 1")->fetch();
    if($srow['status']==0 && $conf['sw_money_rate']==0 && $user['zdyfl']==0){
        $DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
        $addmoney=round($srow['money']*$conf['money_rate']/100,2);
        $DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
        $url=creat_callback($srow);
        curl_get($url['notify']);
        proxy_get($url['notify']);
    }
    if($srow['status']==0 && $conf['sw_money_rate']==0 && $user['zdyfl']==1){
        $DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
        $addmoney=round($srow['money']*$user['rate']/100,2);
        $DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
        $url=creat_callback($srow);
        curl_get($url['notify']);
        proxy_get($url['notify']);
    }
    if($srow['status']==0 && $conf['sw_money_rate']==1 && $user['zdyfl']==0){
        $DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
        $addmoney=round($srow['money']*$conf['alipay_rate']/100,2);
        $DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
        $url=creat_callback($srow);
        curl_get($url['notify']);
        proxy_get($url['notify']);
    }
    if($srow['status']==0 && $conf['sw_money_rate']==1 && $user['zdyfl']==1){
        $DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
        $addmoney=round($srow['money']*$user['salipay_rate']/100,2);
        $DB->query("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
        $url=creat_callback($srow);
        curl_get($url['notify']);
        proxy_get($url['notify']);
    }
    echo "success";
}else{
    echo "error_sign";//sign校验不通过
    exit();
}