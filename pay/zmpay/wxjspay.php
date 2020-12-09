<?php
require '../../oreo/Oreo.Cron.php';
$trade_no = daddslashes($_GET['trade_no']);
@header('Content-Type: text/html; charset=UTF-8');
$row = $DB->query("SELECT * FROM oreo_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
if (!$row) exit('该订单号不存在，请返回来源地重新发起请求！');
if($row['status']==1) sysmsg('该订单已支付！');
if (isset($_GET['type'])) $DB->query("update `oreo_order` set `type` ='wxpay',`addtime` ='$date' where `trade_no`='$trade_no'");
require_once SYSTEM_ROOT . "oreo_function/pay/zmpay/Pay.class.php";
require_once SYSTEM_ROOT . "oreo_function/pay/zmpay/config.php";
$protocol = (int)$_SERVER['SERVER_PORT'] == 80 ? 'http://'.$_SERVER['HTTP_HOST'] : 'https://'.$_SERVER['HTTP_HOST'];
$notify_url = $protocol . '/pay/zmpay/wxpay_notify.php';
$pay = new Pay($id, $token);
$pay->mp_pay($trade_no, $row['name'], $row['money'], $notify_url, $mchid);