<?php
/*Oreo支付系统微信自动补单-code's by Oreo！
说明：本页面用于Oreo支付系统对接第三方易支付时，请求支付接口订单列表，同步未通知到本站的订单，防止漏单。
温馨提示：监控频率建议5分钟一次，千万不要监控太快或使用多节点监控，否则可能会被支付接口自动屏蔽IP地址！
*/
include("../../oreo/Oreo.Cron.php");
function getIP()
{
    static $realip;
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        } else {
            if (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }
    }
    return $realip;
}
if ($conf['jk_ip_status'] == 1) {
	if($conf['jk_ip']!=getIP())
    exit('IP来源不合法');
}
$key = isset($_GET['key']) ? $_GET['key'] : null;
if (!($conf['cron_key'] && $key && $key == $conf['cron_key'])) {
    exit('Oreo支付系统提醒您：您的监控识别码不正确，请前往系统后台查看或修改！');
}
if ($key=='oreopay') {
    exit('请修改此默认监控识别码！');
}
if (function_exists("set_time_limit"))
{
	@set_time_limit(0);
}
if (function_exists("ignore_user_abort"))
{
	@ignore_user_abort(true);
}
@header('Content-Type: text/html; charset=UTF-8');
$data = get_curl($conf['ssvip_url'].'api.php?act=orders&limit=50&pid='.$conf['ssvip_id'].'&key='.$conf['ssvip_key']);
$arr = json_decode($data, true);
if($arr['code']==1){
	foreach($arr['data'] as $row){
		if($row['status']==1){
			$out_trade_no = $row['out_trade_no'];
		$srow=$DB->query("SELECT * FROM oreo_order WHERE trade_no='{$out_trade_no}' limit 1")->fetch();
		if($srow['status']==0){
			$DB->query("update `oreo_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
  processOrder($srow);
				echo 'Oreo支付系统非常负责的告诉您，已成功补单的有：'.$out_trade_no.'<br/>';
			}
		}
	}
	exit('ok');
}else{
	exit($arr['msg']);
}