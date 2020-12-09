<?php
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
if($_GET['do']=='settle'){
	$thtime=date("Y-m-d").' 00:00:00';
	$row=$DB->query("SELECT * FROM oreo_batch WHERE time>='{$thtime}' limit 1")->fetch();
	if($row)exit('Oreo支付系统提醒您：您今日已监控结算，明天继续努力吧！');
	$limit='1000';
	$rs=$DB->query("SELECT * from oreo_user where (money>={$conf['settle_money']} or apply=1) and account is not null and username is not null and type!=2 limit {$limit}");
	$batch=date("Ymd").rand(111,999);
	$i=0;
	$allmoney=0;
	$nums  = 0;
	while($row = $rs->fetch())
	{
		$i++;
		//if($row['apply']==1 && $row['money']<$conf['settle_money']){$fee=$conf['settle_fee'];$row['money']-=$fee;}
		//else $fee=0;
		$fee=round($row['money']*$conf['settle_rate'],2);
		if($fee<$conf['settle_fee_min'])
		   $fee=$conf['settle_fee_min'];
		if($fee>$conf['settle_fee_max'])
		   $fee=$conf['settle_fee_max'];
	   $nums = $nums + $fee;
		$row['money']=$row['money']-$fee;
		if($conf['weixin_qiye']==1){
		    if($row['settle_id']==2){
			$account=$row['wx_openid'];
			}else{
			$account=$row['account'];
			}
		}else{
			$account=$row['account'];
			}
		$DB->exec("INSERT INTO `oreo_settle` (`pid`, `batch`, `type`, `username`, `account`, `money`, `fee`, `time`, `status`) VALUES ('{$row['id']}', '{$batch}', '{$row['settle_id']}', '{$row['username']}', '{$account}', '{$row['money']}', '{$fee}', '{$date}', '0')");
		$allmoney+=$row['money'];
	}	
	$DB->exec("INSERT INTO `oreo_batch` (`batch`, `allmoney`, `time`, `status`, `fee`) VALUES ('{$batch}', '{$allmoney}', '{$date}', '0','{$nums}')");
	exit('结算成功 总金额='.$allmoney.' 数量='.$i);
}
$thtime=date("Y-m-d H:i:s",time()-3600*6);

$DB->exec("delete from oreo_order where status=0 and addtime<'{$thtime}'");

$rs=$DB->query("SELECT * from oreo_user where money!='0.00'");

$allmoney=0;
while($row = $rs->fetch())
{
	$allmoney+=$row['money'];
}
$data['usermoney']=$allmoney;
$ressz=$DB->query("SELECT sum(money) FROM `oreo_apply` where  type=1")->fetchColumn();
$rs=$DB->query("SELECT * from oreo_settle");
$allmoney=0;
while($row = $rs->fetch())
{
	$allmoney+=$row['money']+$ressz;
}
$data['settlemoney']=$allmoney;

$lastday=date("Y-m-d",strtotime("-1 day")).' 00:00:00';
$today=date("Y-m-d").' 00:00:00';
$rs=$DB->query("SELECT * from oreo_order where status=1 and endtime>='$today'");
$order_today=array('alipay'=>0,'tenpay'=>0,'qqpay'=>0,'wxpay'=>0,'all'=>0);
while($row = $rs->fetch())
{
	$order_today[$row['type']]+=$row['money'];
}
$order_today['all']=$order_today['alipay']+$order_today['tenpay']+$order_today['qqpay']+$order_today['wxpay'];

$rs=$DB->query("SELECT * from oreo_order where status=1 and endtime>='$lastday' and endtime<'$today'");
$order_lastday=array('alipay'=>0,'tenpay'=>0,'qqpay'=>0,'wxpay'=>0,'all'=>0);
while($row = $rs->fetch())
{
	$order_lastday[$row['type']]+=$row['money'];
}
$order_lastday['all']=$order_lastday['alipay']+$order_lastday['tenpay']+$order_lastday['qqpay']+$order_lastday['wxpay'];

$data['order_today']=$order_today;
$data['order_lastday']=$order_lastday;

file_put_contents(SYSTEM_ROOT.'db.txt',serialize($data));

echo 'Oreo支付系统提醒您：站点流水监控成功！';