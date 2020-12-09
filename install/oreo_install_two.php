<?php
include("../oreo/oreo_function/quote/Oreo.Must.php");
error_reporting(0);
@header('Content-Type: text/html; charset=UTF-8');
$do=isset($_GET['do'])?$_GET['do']:'0';
if(file_exists('oreo.lock')){
	$installed=true;
	$do='0';
}
function checkfunc($f,$m = false) {
	if (function_exists($f)) {
		return '<font color="green">可用</font>';
	} else {
		if ($m == false) {
			return '<font color="black">不支持</font>';
		} else {
			return '<font color="red">不支持</font>';
		}
	}
}

function checkclass($f,$m = false) {
	if (class_exists($f)) {
		return '<font color="green">可用</font>';
	} else {
		if ($m == false) {
			return '<font color="black">不支持</font>';
		} else {
			return '<font color="red">不支持</font>';
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Oreo支付系统</title>
<link href="../assets/install/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../assets/install/js/jquery.js"></script>
</head>

<body>

<div class="top">
	<div class="top-logo">
	</div>
	<div class="top-link">
		<ul>
			<li><a href="http://www.oreopay.com/" target="_blank">官方网站</a></li>
			<li><a href="http://wpa.qq.com/msgrd?v=3&uin=609451870&site=qq&menu=yes" target="_blank">联系作者</a></li>
			<li><a href="//shang.qq.com/wpa/qunwpa?idkey=603b82b0c8b430b12a796a321d7da046549daf663afaaf176f1971269d2c250b" target="_blank">加入技术群</a></li>
		</ul>
	</div>
	<div class="top-version">
		<!-- 版本信息 -->
		<h3><a style="color: cornflowerblue;">懂你的才是最好的！</a></h3>
	</div>
</div>
<?php if ($installed) { ?>

<div class="main">
	<div class="pleft">
		<dl class="setpbox t1">
			<dt>安装步骤</dt>
			<dd>
				<ul>
					<li class="succeed">许可协议</li>
					<li class="now">环境检测</li>
					<li >参数配置</li>
					<li>正在安装</li>
					<li>安装完成</li>
				</ul>
			</dd>
		</dl>
	</div>

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

<?php }elseif ($do == '0') { ?>
<div class="main">
	<div class="pleft">
		<dl class="setpbox t1">
			<dt>安装步骤</dt>
			<dd>
				<ul>
					<li class="succeed">许可协议</li>
					<li class="now">环境检测</li>
					<li >参数配置</li>
					<li>正在安装</li>
					<li>安装完成</li>
				</ul>
			</dd>
		</dl>
	</div>

<div class="pright">
  <div class="enter_lf">
   <div class="Envin_lf">
      <div class="menter_lf"><span>服务器信息</span></div>
      <div class="menter_table_lf">
      <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabletable">
        <thead>
            <tr>
              <th>参数</th>
              <th>值</th>
            </tr>
        </thead>
        <tbody>
            <tr>
              <td>服务器域名</td>
              <td style=" color:#999;"><?php echo $_SERVER['SERVER_NAME']; ?></td>
            </tr>
            <tr>
              <td>服务器操作系统</td>
              <td style=" color:#999;"><?PHP echo PHP_OS; ?></td>
            </tr>
            <tr>
              <td>服务器翻译引擎</td>
              <td style="color:#999;"><?php echo $_SERVER['SERVER_SOFTWARE'] ?><td>
            </tr>
            <tr>
              <td>PHP版本</td>
              <td style="color:#999;"><?php echo phpversion() ?><?php if(ini_get('safe_mode')) { echo '线程安全'; } else { echo '非线程安全'; } ?></td>
            </tr>
            <tr>
              <td>是否支持Mysql</td>
              <td style=" color:#999;"><?php echo function_exists (mysql_close)?"是":"否"; ?></td>
            </tr>
        </tbody>
      </table>

      </div>
</div>
<div class="Envin_lf">
      <div class="menter_lf"><span>系统环境检测</span></div>
      <div class="menter_table_lf">
      <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabletable">
        <thead>
            <tr>
              <th>需呀开启变量的函数</th>
              <th>要求</th>
              <th>实际状态</th>
            </tr>
        </thead>
        <tbody>
            <tr>
              <td>PHP版本5.4以上</td>
              <td>必要</td> 
              <td><?php echo phpversion(); ?></td>  
            </tr>
            <tr>
              <td>curl_exec()</td>
              <td>必要</td>
              <td><?php echo checkfunc('curl_exec',true); ?></td>
            </tr>
             <tr>
              <td>file_get_contents()</td>
              <td>必要</td>
              <td><?php echo checkfunc('file_get_contents',true); ?></td>
            </tr>  
        </tbody>
      </table>

      </div>
</div>

    <div class="menter_btn_lf"></div>
    <div class="menter_btn_a_lf">
           <a href="oreo_install_two.php?do=1"><input name="" type="button" class="menter_btn_a_a_lf"value="继续"></a>
           <a href="javascript:history.back();"><input name="" type="button" class="menter_btn_a_a_lf" value="后退"></a>
           
    </div>
</div>
</div>

<?php }elseif($do=='1'){?>


<div class="main">
	<div class="pleft">
		<dl class="setpbox t1">
			<dt>安装步骤</dt>
			<dd>
				<ul>
					<li class="succeed">许可协议</li>
					<li class="succeed">环境检测</li>
					<li class="now">参数配置</li>
					<li>正在安装</li>
					<li>安装完成</li>
				</ul>
			</dd>
		</dl>
	</div>
    <div class="pright">
       
       <!--参数配置-->
<div class="index_mian_right_ly">
 
  
  <!--数据库设定-->
  <div class="index_mian_right_two_ly">
   <div class="index_mian_right_two_one_ly"><span>数据库设定</span></div>
   <div class="index_mian_right_two_two_ly">
   	<?php
if(defined("SAE_ACCESSKEY"))
echo <<<HTML
检测到您使用的是SAE空间，支持一键安装，请点击 <a href="?do=2">下一步</a>
HTML;
else
echo<<<HTML
     <form action="?do=2" class="form-sign" method="post">
     <div class="index_mian_right_two_two_o_ly"><b>数据库主机：</b><input class="index_mian_right_two_two_text_ly" name="db_host" /><span>一般为localhost</span></div>
	 <div class="index_mian_right_two_two_o_ly"><b>数据库端口：</b><input class="index_mian_right_two_two_text_ly" name="db_port" /><span>一般为3306</span></div>
     <div class="index_mian_right_two_two_o_ly"><b>数据库用户：</b><input class="index_mian_right_two_two_text_ly" name="db_user" type="text" /></div>
     <div class="index_mian_right_two_two_o_ly"><b>数据库密码：</b><input class="index_mian_right_two_two_text_ly" name="db_pwd" type="text" /></div>
     <div class="index_mian_right_two_two_o_ly"><b>数据库名称：</b><input class="index_mian_right_two_two_text_ly" name="db_name" type="text" /></div>
	 
   </div>
  </div>
  <!--数据库设定结束-->


  
  <!--管理员初始密码-->
  <div class="index_mian_right_three_ly">
   <div class="index_mian_right_three_one_ly"><span>设置安全校验码</span></div>
     <div class="index_mian_right_two_two_o_ly"><b>安全校验码：</b><input class="index_mian_right_two_two_text_ly" name="safer" /><span>此款项不走数据库您随时可以在/oreo/config.php修改</span></div>
   </div>
  </div>
  <!--管理员初始密码结束-->
  
  
  
 
  <!--线-->
  <div class="index_mian_right_six_ly"></div>
  
  <!--后退,继续-->
  <div class="index_mian_right_seven_ly">
      <input name="submit" class="index_mian_right_seven_Forward_ly" type="submit" value="保存配置" /></a>
     <a href="javascript:history.back();"><input name=""  class="index_mian_right_seven_Forward_ly" type="button" value="后退" /></a>
  </div>
  </form>
HTML;
?>
</div>    
 </div>
</div>
<div class="foot">
</div>
<?php }elseif($do=='2'){?>
<div class="main">
	<div class="pleft">
		<dl class="setpbox t1">
			<dt>安装步骤</dt>
			<dd>
				<ul>
					<li class="succeed">许可协议</li>
					<li class="succeed">环境检测</li>
					<li class="succeed">参数配置</li>
					<li class="now">正在安装</li>
					<li class="succeed">安装完成</li>
				</ul>
			</dd>
		</dl>
	</div>
    <div class="pright">
  <!--右边-->
  <form action="" method="get">
  <div class="index_mian_right_one_ly">
  
<?php
require './oreo.db.php';
if(defined("SAE_ACCESSKEY") || $_GET['jump']==1){
	include_once '../oreo/Oreo.Config.php';
	if(!$oreoconfig['user']||!$oreoconfig['pwd']||!$oreoconfig['dbname']) {
		echo '<div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
		      <div class="font">请先填写好数据库并保存后再安装！<a href="javascript:history.back(-1)"><< 返回上一页</a><</div>';
	} else {
		if(!$con=DB::connect($oreoconfig['host'],$oreoconfig['user'],$oreoconfig['pwd'],$oreoconfig['dbname'],$oreoconfig['port'])){
			if(DB::connect_errno()==2002)
				echo '
			          <div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
					  <div class="font">连接数据库失败，数据库地址填写错误！<a href="javascript:history.back(-1)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a></div>';
			elseif(DB::connect_errno()==1045)
				echo '
				      <div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
					  <div class="font">连接数据库失败，数据库用户名或密码填写错误！<a href="javascript:history.back(-1)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a></div>';
			elseif(DB::connect_errno()==1049)
				echo '
				      <div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
					  <div class="font">连接数据库失败，数据库名不存在！<a href="javascript:history.back(-1)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a></div>';
			else
				echo '
					  <div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
					  <div class="font">连接数据库失败，['.DB::connect_errno().']'.DB::connect_error().'<a href="javascript:history.back(-1)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a></div>';
		}else{
			echo '<div class="alert alert-success">数据库配置文件保存成功！</div>';
                if (DB::query("select * from card_config where 1") == FALSE) echo '
				 <div class="btn">
            	<a href="?do=3"><input name="" class="index_mian_right_seven_Forward_ly" type="button" value="创建数据表" /></a>
                  </div>';
                else echo '<div class="list-group-item list-group-item-info">系统检测到你已安装过Oreo支付系统</div>
				<div class="list-group-item">
					<a href="?do=6" class="btn btn-block btn-info">跳过安装</a>
				</div>
				<div class="list-group-item">
					<a href="?do=3" onclick="if(!confirm(\'全新安装将会清空所有数据，是否继续？\')){return false;}" class="btn btn-block btn-warning">强制全新安装</a>';
		}
	}
}else{
	$db_host=isset($_POST['db_host'])?$_POST['db_host']:NULL;
	$db_port=isset($_POST['db_port'])?$_POST['db_port']:NULL;
	$db_user=isset($_POST['db_user'])?$_POST['db_user']:NULL;
	$db_pwd=isset($_POST['db_pwd'])?$_POST['db_pwd']:NULL;
	$db_name=isset($_POST['db_name'])?$_POST['db_name']:NULL;
	$safer=isset($_POST['safer'])?$_POST['safer']:NULL;

	if($db_host==null || $db_port==null || $db_user==null || $db_pwd==null || $db_name==null || $safer==null){
		echo '<div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
		      <div class="font">保存错误,请确保每项都不为空<a href="javascript:history.back(-1)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a></div>';
	} else {
$config="<?php
/*数据库配置*/
\$oreoconfig=array(
	'host' => '{$db_host}', //数据库服务器
	'port' => {$db_port}, //数据库端口
	'user' => '{$db_user}', //数据库用户名
	'pwd' => '{$db_pwd}', //数据库密码
	'dbname' => '{$db_name}' //数据库名
);
    \$safe = '{$safer}';//此处为安全码，不走数据库
?>";
		if(!$con=DB::connect($db_host,$db_user,$db_pwd,$db_name,$db_port,$safer)){
			if(DB::connect_errno()==2002)
				echo '
			          <div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
					  <div class="font">连接数据库失败，数据库地址填写错误！<a href="javascript:history.back(-1)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a></div>';
			elseif(DB::connect_errno()==1045)
				echo '
				      <div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
					  <div class="font">连接数据库失败，数据库用户名或密码填写错误！<a href="javascript:history.back(-1)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a></div>';
			elseif(DB::connect_errno()==1049)
				echo '
				      <div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
					  <div class="font">连接数据库失败，数据库名不存在！<a href="javascript:history.back(-1)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a></div>';
			else
				echo '
			          <div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
					  <div class="font">连接数据库失败，['.DB::connect_errno().']'.DB::connect_error().'<a href="javascript:history.back(-1)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a></div>';
		}elseif(file_put_contents('../oreo/Oreo.Config.php',$config)){
			echo '
			      <div class="index_mian_right_one_one_ly"><span>一切准备就绪</span></div>
				<div class="font">数据库配置文件保存成功<a href="javascript:history.back(-1)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a></div>';
			if(DB::query("select * from ayangw_config where 1")==FALSE)
				echo '
			    <div class="btn">
            	<a href="?do=3"><input name="" class="index_mian_right_seven_Forward_ly" type="button" value="创建数据表" /></a>
                  </div>';
			    else
				echo '<div class="list-group-item list-group-item-info">系统检测到你已安装过Oreo支付系统</div>
				<div class="list-group-item">
					<a href="?do=6" class="btn btn-block btn-info">跳过安装</a>
				</div>
				<div class="list-group-item">
					<a href="?do=3" onclick="if(!confirm(\'全新安装将会清空所有数据，是否继续？\')){return false;}" class="btn btn-block btn-warning">强制全新安装</a>
				</div>';
		}else
			echo '
		          <div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
			      <div class="font">保存失败，请确保网站根目录有写入权限<a href="javascript:history.back(-1)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;返回上一页</a></div>';
	}
}
?>

  </div>
  <!--进入系统-->
  <div class="btnn-box"></div>
  </form>
</div>
<?php }elseif($do=='3'){?>
<div class="main">
	<div class="pleft">
		<dl class="setpbox t1">
			<dt>安装步骤</dt>
			<dd>
				<ul>
					<li class="succeed">许可协议</li>
					<li class="succeed">环境检测</li>
					<li class="succeed">参数配置</li>
					<li class="succeed">正在安装</li>
					<li class="now">安装完成</li>
				</ul>
			</dd>
		</dl>
	</div>
    <div class="pright">
  <!--右边-->
  <form action="" method="get">
  <div class="index_mian_right_one_ly">
<?php
if(defined("SAE_ACCESSKEY"))include_once '../oreo/sae.php';
else include_once '../oreo/Oreo.Config.php';
if(!$oreoconfig['user']||!$oreoconfig['pwd']||!$oreoconfig['dbname']) {
	echo '
	      <div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
		  <div class="font">请先填写好数据库并保存后再安装！<a href="javascript:history.back(-1)"><< 返回上一页</a><</div>';
} else {
	require './oreo.db.php';
	$sql=file_get_contents("oreo_pay.sql");
	$sql=explode(';',$sql);
	$cn = DB::connect($oreoconfig['host'],$oreoconfig['user'],$oreoconfig['pwd'],$oreoconfig['dbname'],$oreoconfig['port']);
	if (!$cn) die('err:'.DB::connect_error());
	DB::query("set sql_mode = ''");
	DB::query("set names utf8");
	$t=0; $e=0; $error='';
	for($i=0;$i<count($sql);$i++) {
		if ($sql[$i]=='')continue;
		if(DB::query($sql[$i])) {
			
          ++$t;
		} else {
          ++$e;
			$error.=DB::error().'<br/>';
		}
	}
}
if($e==1){
$e=0;}



if($e==0) {
	echo '
	      <div class="index_mian_right_one_one_ly"><span>安装成功</span></div>
		  <div class="font">Oreo支付系统安装成功<br/>SQL成功'.$t.'句/失败'.$e.'句</div>
		  <div class="btn"><a href="oreo_install_two.php?do=4"><input name="" class="index_mian_right_seven_Forward_ly" type="button" value="配置管理员账号密码" /></a></div>';
} else {
	echo '
	     <div class="index_mian_right_one_one_ly"><span>安装失败</span></div>
		 <div class="font">Oreo支付系统安装失败<br/>SQL成功'.$t.'句/失败'.$e.'句<br/>错误信息：'.$error.'<a href="oreo_install_two.php?do=3"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;点此进行重试</a></div>';
}
?>
  </div>
  <!--进入系统-->
  <div class="btnn-box"></div>
  </form>
</div>
<?php }elseif($do=='4'){?>
<div class="main">
	<div class="pleft">
		<dl class="setpbox t1">
			<dt>安装步骤</dt>
			<dd>
				<ul>
					<li class="succeed">许可协议</li>
					<li class="succeed">环境检测</li>
					<li class="succeed">参数配置</li>
					<li class="succeed">正在安装</li>
					<li class="now">安装完成</li>
				</ul>
			</dd>
		</dl>
	</div>
    <div class="pright">
  <!--右边-->
  <div class="index_mian_right_one_ly">
  <!--管理员初始密码-->
  <div class="index_mian_right_three_ly">
   <div class="index_mian_right_three_one_ly"><span>管理员初始密码</span></div>
   <div class="index_mian_right_three_two_ly">
     <div class="index_mian_right_three_two_o_ly"><b>用户名：</b><input class="index_mian_right_two_two_text_ly" name="oreo_admin" type="text" /><span>只能用'0-9','a-z','A-Z','.','@','_','-','!'以内范围的字符</span></div>
     <div class="index_mian_right_three_two_n_ly"><b>密码：</b><input class="index_mian_right_two_two_text_ly"  name="oreo_password"" value="" type="text" /></div>
   </div>
  </div>
  <!--管理员初始密码结束-->
  <div class="btn">
     <input type="button" id="editSafe"  value="保存修改" class="index_mian_right_seven_Forward_ly" >
   </div>
<script src="../assets/newuser/js/layer.js"></script>
<script>
                        $("#editSafe").click(function () {
					    var oreo_admin=$("input[name='oreo_admin']").val();
						var oreo_password=$("input[name='oreo_password']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo.php?act=edit_Safe",
							data: {oreo_admin:oreo_admin,oreo_password:oreo_password},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('保存成功', function(index) {
                                    layer.close(index);
                                    location.href="oreo_install_two.php?do=5"; 
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					
</script>        	 
<?php }elseif($do=='5'){?>
<div class="main">
	<div class="pleft">
		<dl class="setpbox t1">
			<dt>安装步骤</dt>
			<dd>
				<ul>
					<li class="succeed">许可协议</li>
					<li class="succeed">环境检测</li>
					<li class="succeed">参数配置</li>
					<li class="succeed">正在安装</li>
					<li class="now">安装完成</li>
				</ul>
			</dd>
		</dl>
	</div>
    <div class="pright">
  <!--右边-->
  <div class="index_mian_right_one_ly">
  <div class="index_mian_right_one_one_ly"><span>安装完成</span></div>
		 <div class="font">Oreo负责任的告诉您！系统安装成功！<br/>
		 （安装后倘若运行出错，请切换PHP版本至正常运行为止！）<br/>
		 为了避免您或他人重复安装程序，我们已经帮你删除install目录和assets/install目录。<br/>
		 如需要重新安装请在安装包内提取install目录和assets/install目录。<br/>
		 感谢您选择Oreo，信任Oreo</div>
		 <?php 
$installfile = '../install';	
$installstatic = '../assets/install';	 
function delDirAndFileInstall($installfile)
{
    if ($handle = opendir("$installfile")) {
        while (false !== ($item = readdir($handle))) {
            if ($item != "." && $item != "..") {
                if (is_dir("$installfile/$item")) {
                    delDirAndFileSql("$installfile/$item");
                } else {
                    unlink("$installfile/$item");
                }
            }
        }
        closedir($handle);
		rmdir($installfile);
    }
}
function delDirAndFileInstallStatic($installstatic)
{
    if ($handle = opendir("$installstatic")) {
        while (false !== ($item = readdir($handle))) {
            if ($item != "." && $item != "..") {
                if (is_dir("$installstatic/$item")) {
                    delDirAndFileSql("$installstatic/$item");
                } else {
                    unlink("$installstatic/$item");
                }
            }
        }
        closedir($handle);
		rmdir($installstatic);
    }
}
delDirAndFileInstall($installfile);	
delDirAndFileInstallStatic($installstatic);
		 ?>
		 <div class="btn">
     <a href="../admin"><input type="submit"  value="登录后台" class="index_mian_right_seven_Forward_ly" >
   </div>
   </div>
  <!--进入系统-->
  <div class="btnn-box"></div>
  </form>
</div>
<?php } ?>
</body>
</html>
