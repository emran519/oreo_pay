<?php
include("../oreo/oreo_function/quote/Oreo.Must.php");
error_reporting(0);
@header('Content-Type: text/html; charset=UTF-8');
$do=isset($_GET['do'])?$_GET['do']:'0';
if(file_exists('oreo.lock')){
	$installed=true;
	$do='0';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Oreo支付系统</title>
<link href="../assets/install/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../assets/install/js/jquery.js"></script>
<script type="text/javascript" src="../assets/install/js/suibian.js"></script>
</head>

<body>

<div class="top">
	<div class="top-logo">
	</div>
	<div class="top-link">
		<ul>
			<li><a href="http://www.oreopay.com/" target="_blank">官方网站  </a></li>
			<li><a href="http://wpa.qq.com/msgrd?v=3&uin=609451870&site=qq&menu=yes" target="_blank">联系作者</a></li>
			<li><a href="//shang.qq.com/wpa/qunwpa?idkey=603b82b0c8b430b12a796a321d7da046549daf663afaaf176f1971269d2c250b" target="_blank">加入技术群</a></li>
		</ul>
	</div>
	<div class="top-version">
		<h3><a style="color: cornflowerblue;">懂你的才是最好的！</a></h3>
	</div>
</div>

<div class="main">
	<div class="pleft">
		<dl class="setpbox t1">
			<dt>安装步骤</dt>
			<dd>
				<ul>
					<li class="now">许可协议</li>
					<li>环境检测</li>
					<li>参数配置</li>
					<li>正在安装</li>
					<li>安装完成</li>
				</ul>
			</dd>
		</dl>
	</div>
<?php if ($installed) { ?>
  <form action="" method="get">
  <div class="index_mian_right_one_ly">
   <div class="index_mian_right_one_one_ly"><span>您已经安装Oreo</span></div>
   <div class="font">系统检测到您已经安装Oreo系统，如果需要重新安装，请您删除install目录下的oreo.lock文件再进行重新安装！<br/>感谢您选择Oreo，信任Oreo</div>
   <div class="btn">
   	<a href="../admin"><input name="" class="index_mian_right_seven_Forward_ly" type="button" value="进入系统" /></a>
   </div>
   
  </div>
  <!--进入系统-->
  <div class="btnn-box"></div>
  </form>
</div>
<?php }else{?>
	
	<div class="pright">
		<div class="pr-title"><h3>阅读许可协议</h3></div>
		<div class="pr-agreement">
				<p> 
<p>感谢您选Oreo支付系统
<p>本系统为基于PHP+MYsql5.6开发.
<p>本系统为免费开源，开源目的则为了让更多的开发者参考和学习。
<p>软件使用过程中，没有任何明示、暗示的保证。使用者必须自担风险，即使开发者被事先告知风险的可能性。软件使用中一切直接的、间接的损失，包括但是不限于故障、数据丢失、业务中断、设计误差、……，概不负责。
<p>产生一切问题与本人（软件作者）无关。
<p>选择继续安装即表示同意本协议。
<p>协议发布时间： 2020年12月8日
				</p>
				
		</div>
		<div class="btn-box">
			<input name="readpact" type="checkbox" id="readpact" value="" class="check_boxId" /><label for="readpact"><strong class="fc-690 fs-14">我已经阅读并同意此协议</strong></label>
			<input name="继续" type="submit" class="menter_btn_a_a_lf" value="继续"  />
		</div>
	</div>
</div>

<div class="foot">

</div>
<?php }?>
</body>
</html>
