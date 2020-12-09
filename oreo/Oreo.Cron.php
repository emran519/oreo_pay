<?php
error_reporting(0);
define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('ROOT', dirname(SYSTEM_ROOT).'/');
date_default_timezone_set('Asia/Shanghai');
$date = date("Y-m-d H:i:s");
session_start();
$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath.'/';
if(is_file(SYSTEM_ROOT.'oreo_function/safe/oreo_wscan.php')){//360网站卫士
 require_once(SYSTEM_ROOT.'oreo_function/safe/oreo_wscan.php');
}
include_once(SYSTEM_ROOT."oreo_function/other/security.php");
require SYSTEM_ROOT.'Oreo.Config.php';
if(!defined('SQLITE') && (!$oreoconfig['user']||!$oreoconfig['pwd']||!$oreoconfig['dbname']))//检测安装
{
header('Content-type:text/html;charset=utf-8');
echo '你还没安装！<a href="../install">点此安装</a>';
exit();
}
try {
    $DB = new PDO("mysql:host={$oreoconfig['host']};dbname={$oreoconfig['dbname']};port={$oreoconfig['port']}",$oreoconfig['user'],$oreoconfig['pwd']);
}catch(Exception $e){
    exit('链接数据库失败:'.$e->getMessage());
}
$DB->exec("set names utf8");
$rs=$DB->query("select * from oreo_config");
while($row=$rs->fetch()){ 
	$conf[$row['k']]=$row['v'];
}
if($conf['wxpay_mode']==1){
    define('WX_API_APPID',  $conf['wx_api_appid']);
    define('WX_API_MCHID',  $conf['wx_api_mchid']);
    define('WX_API_KEY',  $conf['wx_api_key']);
    define('WX_API_APPSECRET',  $conf['wx_api_appsecret']);
    define('WX_SSLCERT_PATH', SYSTEM_ROOT.'oreo_function/pay/wxpay/apiclient_cert.pem');
define('WX_SSLKEY_PATH',  SYSTEM_ROOT.'oreo_function/pay/wxpay/apiclient_key.pem');
}
if($conf['qqpay_mode']==1){
    define('QQ_API_MCH_ID',  $conf['qq_api_mchid']);
    define('QQ_API_MCH_KEY',  $conf['qq_api_mchkey']);
}


if(!$conf['local_domain'])$conf['local_domain']=$_SERVER['HTTP_HOST'];
$password_hash='!@#%!s!0';
require_once(SYSTEM_ROOT."oreo_function/pay/alipay/alipay_core.function.php");
require_once(SYSTEM_ROOT."oreo_function/pay/alipay/alipay_md5.function.php");
include_once(SYSTEM_ROOT."oreo_function/quote/Oreo.Must.php");
include_once(SYSTEM_ROOT."oreo_function/other/oreo.sesion.php");
if (!file_exists(ROOT ."Like_Oreo")) {
@file_put_contents(ROOT."Like_Oreo","Oreo支付系统版权文件，勿删除；光鲜亮丽的程序背后是一直在努力的我们！原创：Oreo，QQ:609451870");
sysmsg("<center><h2>检测到“Like_Oreo”版权文件已被删除</h2><ul><font size=\"4\">如果“Like_Oreo”版权文件被删除，<b>Oreo支付系统将不会运作！</b></font></li></ul><font size=\"4\">系统已为您重新生成该版权文件，刷新页面即可恢复！<ul><font size=\"4\">请尊重Oreo原创易支付系统，勿再次删除！<br/></center>", true);
}
define('Alipay_PrivateKey', "");
$weblock="yes";
$referer=empty($_SERVER['HTTP_REFERER']) ? array() : array($_SERVER['HTTP_REFERER']);
function customError($errno, $errstr, $errfile, $errline)
{ 
echo "<b>Error number:</b> [$errno],error on line $errline in $errfile<br />";
die();
}
set_error_handler("customError",E_ERROR);
$getfilter="'|\\b(and|or)\\b.+?(>|<|=|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$postfilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$cookiefilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
function StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq){  
$StrFiltValue=arr_foreach($StrFiltValue);
if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){   
slog("<br><br>操作IP: ".$_SERVER["REMOTE_ADDR"]."<br>操作时间: ".strftime("%Y-%m-%d %H:%M:%S")."<br>操作页面:".$_SERVER["PHP_SELF"]."<br>提交方式: ".$_SERVER["REQUEST_METHOD"]."<br>提交参数: ".$StrFiltKey."<br>提交数据: ".$StrFiltValue);
print "<div style=\"position:fixed;top:0px;width:100%;height:100%;background-color:white;color:green;font-weight:bold;border-bottom:5px solid #999;\"><br>您的提交带有不合法参数,谢谢合作!<br><br>了解更多请点击:<a href=\"http://webscan.360.cn\">http://webscan.360.cn</a></div>";
exit();
}
if (preg_match("/".$ArrFiltReq."/is",$StrFiltKey)==1){   
slog("<br><br>操作IP: ".$_SERVER["REMOTE_ADDR"]."<br>操作时间: ".strftime("%Y-%m-%d %H:%M:%S")."<br>操作页面:".$_SERVER["PHP_SELF"]."<br>提交方式: ".$_SERVER["REQUEST_METHOD"]."<br>提交参数: ".$StrFiltKey."<br>提交数据: ".$StrFiltValue);
print "<div style=\"position:fixed;top:0px;width:100%;height:100%;background-color:white;color:green;font-weight:bold;border-bottom:5px solid #999;\"><br>您的提交带有不合法参数,谢谢合作!<br><br>了解更多请点击:<a href=\"http://webscan.360.cn\">http://webscan.360.cn</a></div>";
exit();
}  
}  
foreach($_GET as $key=>$value){ 
StopAttack($key,$value,$getfilter);
}
foreach($_POST as $key=>$value){ 
StopAttack($key,$value,$postfilter);
}
foreach($_COOKIE as $key=>$value){ 
StopAttack($key,$value,$cookiefilter);
}
foreach($referer as $key=>$value){ 
StopAttack($key,$value,$getfilter);
}
function slog($logs)
{
$toppath=$_SERVER["DOCUMENT_ROOT"]."/log.htm";
$Ts=fopen($toppath,"a+");
fputs($Ts,$logs."\r\n");
fclose($Ts);
}
function arr_foreach($arr) {
static $str;
if (!is_array($arr)) {
return $arr;
}
  foreach ($arr as $key => $val ) {

    if (is_array($val)) {

        arr_foreach($val);
    } else {

      $str[] = $val;
    }
  }
  return implode($str);
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/')!==false && $conf['qqtz']==1){
    header("Content-Type: text/html; charset=utf-8");
    echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>请使用浏览器打开</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta content="false" name="twcClient" id="twcClient"/>
    <meta name="aplus-touch" content="1"/>
    <style>
body,html{width:100%;height:100%}
*{margin:0;padding:0}
body{background-color:#fff}
.top-bar-guidance{font-size:15px;color:#fff;height:70%;line-height:1.8;padding-left:20px;padding-top:20px;background:url(//gw.alicdn.com/tfs/TB1eSZaNFXXXXb.XXXXXXXXXXXX-750-234.png) center top/contain no-repeat}
.top-bar-guidance .icon-safari{width:25px;height:25px;vertical-align:middle;margin:0 .2em}
.app-download-tip{margin:0 auto;width:290px;text-align:center;font-size:15px;color:#2466f4;background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAcAQMAAACak0ePAAAABlBMVEUAAAAdYfh+GakkAAAAAXRSTlMAQObYZgAAAA5JREFUCNdjwA8acEkAAAy4AIE4hQq/AAAAAElFTkSuQmCC) left center/auto 15px repeat-x}
.app-download-tip .guidance-desc{background-color:#fff;padding:0 5px}
.app-download-btn{display:block;width:214px;height:40px;line-height:40px;margin:18px auto 0 auto;text-align:center;font-size:18px;color:#2466f4;border-radius:20px;border:.5px #2466f4 solid;text-decoration:none}
    </style>
</head>
<body>
<div class="top-bar-guidance">
    <p>点击右上角<img src="//gw.alicdn.com/tfs/TB1xwiUNpXXXXaIXXXXXXXXXXXX-55-55.png" class="icon-safari" /> <span id="openm">浏览器、Safari打开</span></p>
    <p>才可继续浏览本站哦~</p>
</div>
<div class="app-download-tip"><h2>欢迎使用最专业的支付服务</h2></span>
</div><br>
<div class="app-download-tip">
    <span class="guidance-desc">您可以复制本站网址，到浏览器内键入打开</span>
</div>
<script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
<script src="//open.mobile.qq.com/sdk/qqapi.js?_bid=152"></script>
</body>
</html>';
    exit;
}
?>