<?php
function proxy_get($url)
{
	return 0;
}
function curl_get($url)
{
$ch=curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$content=curl_exec($ch);
curl_close($ch);
return($content);
}
function do_notify($url){
	$return = curl_get($url);
	if(strpos($return,'success')!==false){
		return true;
	}else{
		proxy_get($url);
	}
}
function get_curl($url, $post=0, $referer=0, $cookie=0, $header=0, $ua=0, $nobaody=0)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$httpheader[] = "Accept:*/*";
	$httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
	$httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
	$httpheader[] = "Connection:close";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	if ($post) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	if ($header) {
		curl_setopt($ch, CURLOPT_HEADER, true);
	}
	if ($cookie) {
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	}
	if($referer){
		if($referer==1){
			curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
		}else{
			curl_setopt($ch, CURLOPT_REFERER, $referer);
		}
	}
	if ($ua) {
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	}
	else {
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0");
	}
	if ($nobaody) {
		curl_setopt($ch, CURLOPT_NOBODY, 1);
	}
	curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}
function real_ip(){
$ip = $_SERVER['REMOTE_ADDR'];
if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
	foreach ($matches[0] AS $xip) {
		if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
			$ip = $xip;
			break;
		}
	}
} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
	$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
} elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
	$ip = $_SERVER['HTTP_X_REAL_IP'];
}
return $ip;
}
function ip_city_str($str){
	return str_replace(array('省','市'),'',$str);
}
function get_ip_city($ip)
{
    $url = 'http://whois.pconline.com.cn/ipJson.jsp?json=true&ip=';
    $city = curl_get($url . $ip);
	$city = mb_convert_encoding($city, "UTF-8", "GB2312");
    $city = json_decode($city, true);
    if ($city['city']) {
        $location = ip_city_str($city['pro']).ip_city_str($city['city']);
    } else {
        $location = ip_city_str($city['pro']);
    }
	if($location){
		return $location;
	}else{
		return false;
	}
}
function get_ip_city3($ip)
{
    $url = 'http://ip.taobao.com/service/getIpInfo.php?ip=';
    @$data = file_get_contents($url . $ip);
    $arr = json_decode($data, true);
	if (array_key_exists('code',$arr) && $arr['code']==0) {
		if ($arr['data']['city']) {
			$location = $arr['data']['region'].$arr['data']['city'];
		} else {
			$location = $arr['data']['region'];
		}
	}
	if($location){
		return $location;
	}else{
		return false;
	}
}
function send_mail($to, $sub, $msg) {
	global $conf;
	if($conf['mail_cloud']==1){
		$url='http://api.sendcloud.net/apiv2/mail/send';
		$data=array(
			'apiUser' => $conf['mail_apiuser'],
			'apiKey' => $conf['mail_apikey'],
			'from' => $conf['mail_name'],
			'fromName' => $conf['web_name'],
			'to' => $to,
			'subject' => $sub,
			'html' => $msg);
		$ch=curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$json=curl_exec($ch);
		curl_close($ch);
		$arr=json_decode($json,true);
		if($arr['statusCode']==200){
			return true;
		}else{
			return implode("\n",$arr['message']);
		}
	}else{
		if(!function_exists("openssl_sign") && $conf['mail_port']==465){
			$mail_api = 'http://1.mail.qqzzz.net/';
		}
	if($mail_api) {
		$post[sendto]=$to;
		$post[title]=$sub;
		$post[content]=$msg;
		$post[user]=$conf['mail_name'];
		$post[pwd]=$conf['mail_pwd'];
		$post[nick]=$conf['web_name'];
		$post[host]=$conf['mail_smtp'];
		$post[port]=$conf['mail_port'];
		$post[ssl]=$conf['mail_port']==465?1:0;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$mail_api);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($post));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$ret = curl_exec($ch);
		curl_close($ch);
		if($ret=='1')return true;
		else return $ret;
	} else {
		include_once ROOT.'oreo/oreo_function/other/Oreo.smtp.class.php';
		$From = $conf['mail_name'];
		$Host = $conf['mail_smtp'];
		$Port = $conf['mail_port'];
		$SMTPAuth = 1;
		$Username = $conf['mail_name'];
		$Password = $conf['mail_pwd'];
		$Nickname = $conf['web_name'];
		$SSL = $conf['mail_port']==465?1:0;
		$mail = new SMTP($Host , $Port , $SMTPAuth , $Username , $Password , $SSL);
		$mail->att = array();
		if($mail->send($to , $From , $sub , $msg, $Nickname)) {
			return true;
		} else {
			return $mail->log;
		}
	}
	}
}
function send_sms($phone, $code, $moban='1'){
	global $conf;
	$app=$conf['mail_apikey'];
    $moban=$conf['mail_apiuser'];
	$url = 'http://api.978w.cn/yzmsms/index/appkey/'.$conf['sms_appkey'].'/phone/'.$phone.'/moban/'.$moban.'/app/'.$app.'/code/'.$code;
	$data=get_curl($url);
	$arr=json_decode($data,true);
	if($arr['status']=='200'){
		return true;
	}else{
		return $arr['error_msg_zh'];
	}
}
function daddslashes($string, $force = 0, $strip = FALSE) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force, $strip);
			}
		} else {
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}

function strexists($string, $find) {
	return !(strpos($string, $find) === FALSE);
}

function dstrpos($string, $arr) {
	if(empty($string)) return false;
	foreach((array)$arr as $v) {
		if(strpos($string, $v) !== false) {
			return true;
		}
	}
	return false;
}

function checkmobile() {
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$ualist = array('android', 'midp', 'nokia', 'mobile', 'iphone', 'ipod', 'blackberry', 'windows phone');
	if((dstrpos($useragent, $ualist) || strexists($_SERVER['HTTP_ACCEPT'], "VND.WAP") || strexists($_SERVER['HTTP_VIA'],"wap")))
		return true;
	else
		return false;
}
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : ENCRYPT_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}

function showmsg($content = '未知的异常',$type = 4,$back = false)
{
switch($type)
{
case 1:
	$panel="success";
break;
case 2:
	$panel="info";
break;
case 3:
	$panel="warning";
break;
case 4:
	$panel="danger";
break;
}

echo '<div class="panel panel-'.$panel.'">
      <div class="panel-heading">
        <h3 class="panel-title">提示信息</h3>
        </div>
        <div class="panel-body">';
echo $content;

if ($back) {
	echo '<hr/><a href="'.$back.'"><< 返回上一页</a>';
}
else
    echo '<hr/><a href="javascript:history.back(-1)"><< 返回上一页</a>';

echo '</div>
    </div>';
}
function sysmsg($msg = '未知的异常',$die = true) {
    ?>  
<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8" /><title><?php echo $conf['web_title']; ?> - 站点提示</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta content="<?php echo $conf['web_title']; ?>" name="author" /><link href="//<?=$_SERVER['HTTP_HOST']?>/assets/newuser/css/icons.min.css" rel="stylesheet" type="text/css" /><link href="//<?=$_SERVER['HTTP_HOST']?>/assets/newuser/css/app.min.css" rel="stylesheet" type="text/css" /></head>
<body>
<div class="mt-5 mb-5"><div class="container"><div class="row justify-content-center"><div class="col-12"><div class="text-center"><img src="//<?=$_SERVER['HTTP_HOST']?>/assets/newuser/images/maintenance.svg" height="140" alt="File not found Image">
<h3 class="mt-4"><?php echo $msg; ?>.</h3>
<div class="row mt-5"><div class="col-md-4"><div class="text-center mt-3 pl-1 pr-1"><i class="dripicons-jewel bg-primary maintenance-icon text-white mb-2"></i>
<h5 class="text-uppercase">遇到问题怎么办?</h5>
<p class="text-muted">首先请认真阅读问题内容并且做出对应的更改方案.</p></div></div> <div class="col-md-4"><div class="text-center mt-3 pl-1 pr-1"><i class="dripicons-clock bg-primary maintenance-icon text-white mb-2"></i>
<h5 class="text-uppercase">我们的时效性?</h5>
<p class="text-muted">如果您已知晓问题的所在您可以极速处理当前存在的问题即可解决当前的问题.</p></div></div> <div class="col-md-4"><div class="text-center mt-3 pl-1 pr-1"><i class="dripicons-question bg-primary maintenance-icon text-white mb-2"></i>
<h5 class="text-uppercase">问题多次出现怎么办?</h5>
<p class="text-muted">如果该问题反复出现那么您可能需要联系管理员来获取最佳的解决方案.</p>
</div></div> </div> </div></div> </div></div></div><footer class="footer footer-alt"><?php echo $conf['web_copyright']; ?>. </footer><script src="//<?=$_SERVER['HTTP_HOST']?>/assets/newuser/js/app.min.js"></script>
</body>
</html>	
    <?php
    if ($die == true) {
        exit;
    }
}
function creat_callback($srow){
	global $DB;
	$userrow=$DB->query("SELECT * FROM oreo_user WHERE id='{$srow['pid']}' limit 1")->fetch();
	$array=array('pid'=>$srow['pid'],'trade_no'=>$srow['trade_no'],'out_trade_no'=>$srow['out_trade_no'],'type'=>$srow['type'],'name'=>$srow['name'],'money'=>$srow['money'],'trade_status'=>'TRADE_SUCCESS');
	$arg=argSort(paraFilter($array));
	$prestr=createLinkstring($arg);
	$urlstr=createLinkstringUrlencode($arg);
	$sign=md5Sign($prestr, $userrow['key']);
	if(strpos($srow['notify_url'],'?'))
		$url['notify']=$srow['notify_url'].'&'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
	else
		$url['notify']=$srow['notify_url'].'?'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
	if(strpos($srow['return_url'],'?'))
		$url['return']=$srow['return_url'].'&'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
	else
		$url['return']=$srow['return_url'].'?'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
	return $url;
}
function processOrder($srow,$notify=true){
	global $DB,$conf;
	$user=$DB->query("select * from oreo_user where id='{$srow['pid']}' limit 1")->fetch();
	if($conf['sw_money_rate']==0 && $user['zdyfl']==0){
	$rate=$DB->query("SELECT rate FROM oreo_user WHERE id='{$srow['pid']}'")->fetchColumn();
	$user=$DB->query("select * from oreo_user where id='{$srow['pid']}' limit 1")->fetch();
	$addmoney=round($srow['money']*$conf['money_rate']/100,2);
	$DB->exec("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
	if($notify==true){
		$url=creat_callback($srow);
		do_notify($url['notify']);
	}
  }	
    if($conf['sw_money_rate']==0 && $user['zdyfl']==1){
	$rate=$DB->query("SELECT rate FROM oreo_user WHERE id='{$srow['pid']}'")->fetchColumn();
	$user=$DB->query("select * from oreo_user where id='{$srow['pid']}' limit 1")->fetch();
    $addmoney=round($srow['money']*$user['rate']/100,2);
	$DB->exec("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
	if($notify==true){
		$url=creat_callback($srow);
		do_notify($url['notify']);
	}
  }	
    if($conf['sw_money_rate']==1 && $user['zdyfl']==0){
	$rate=$DB->query("SELECT rate FROM oreo_user WHERE id='{$srow['pid']}'")->fetchColumn();
	$user=$DB->query("select * from oreo_user where id='{$srow['pid']}' limit 1")->fetch();
    $addmoney=round($srow['money']*$conf['alipay_rate']/100,2);
	$DB->exec("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
	if($notify==true){
		$url=creat_callback($srow);
		do_notify($url['notify']);
	}
  }	
    if($conf['sw_money_rate']==1 && $user['zdyfl']==1){
	$rate=$DB->query("SELECT rate FROM oreo_user WHERE id='{$srow['pid']}'")->fetchColumn();
	$user=$DB->query("select * from oreo_user where id='{$srow['pid']}' limit 1")->fetch();
    $addmoney=round($srow['money']*$user['salipay_rate']/100,2);
	$DB->exec("update oreo_user set money=money+{$addmoney} where id='{$srow['pid']}'");
	if($notify==true){
		$url=creat_callback($srow);
		do_notify($url['notify']);
	}
  }	
}
function getdomain($url){
	$arr=parse_url($url);
	return $arr['host'];
}

//图片上传
	function uploadtp($file,$userids){
		$tmp_filename = $file['tmp_name'];
		if(is_uploaded_file($tmp_filename)){ 
			$allow_mimes = array(
				'image/png' => '.png',
				'image/x-png' => '.png',
				'image/gif' => '.gif',
				'image/jpeg' => '.jpg',
				'image/pjpeg' => '.jpg'
			);        
			if(!array_key_exists($file['type'], $allow_mimes )) {
				return false;
				exit;
			}
			$filexname = 'upload/mycode/'.$userids.'_'.md5(rand()).'.jpg';
			if (move_uploaded_file($tmp_filename, $filexname)) { 
				$lj="//".$_SERVER['HTTP_HOST']."/user/".$filexname;
				return $lj;
			}else{
				return false;
			}
		}
	}
//检测图片
	function istp($file){
		$tmp_filename = $file['tmp_name'];
		if(is_uploaded_file($tmp_filename)){ 
			// 是一个上传的文件. 
			$allow_mimes = array(
				'image/png' => '.png',
				'image/x-png' => '.png',
				'image/gif' => '.gif',
				'image/jpeg' => '.jpg',
				'image/pjpeg' => '.jpg'
			);        
			if(!array_key_exists($file['type'], $allow_mimes )) {
				return false;
			}else{
				return true;
			}
		}
	}
	//删除目录及文件函数
	function delDirAndFileNow($this_file)
{
    if ($handle = opendir("$this_file")) {
        while (false !== ($item = readdir($handle))) {
            if ( $item != "." && $item != ".." ) {
                if (is_dir("$this_file/$item")) {
					delDirAndFileNow("$this_file/$item");
                } else {
					unlink("$this_file/$item"); 
                }
            }
        }
        closedir($handle);
		rmdir( $this_file);
		return true;
		
    }
}	