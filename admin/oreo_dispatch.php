<?php
include "../oreo/Oreo.Cron.php";
include './oreo_static.php';
if ($islogin == 1) {
} else {
    exit("<script language='javascript'>window.location.href='./login.php';</script>");
}
?>
                  <div class="page-content-wrapper ">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="#">控制台</a></li>
                                                <li class="breadcrumb-item"><a href="#">系统参数</a></li>
                                                <li class="breadcrumb-item active">邮箱或短信参数配置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">邮箱或短信参数配置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">邮箱和短信参数配置说明</h4>
                                            <p class="text-muted m-b-30 font-14">在这里您可以设置平台的邮箱和短信参数，请认真填写每一项，否则不能发送有关邮件或短信验证！</p>
                                            <form id="oreo_form" action="" method="post">
                                                <div class="form-group">
                                                    <label>选择发送方式</label>
                                                  <select  class="form-control" name="mail_cloud"  id="mail_cloud"  onchange="sh_rg('sh',this.value)">
												  <option value="2" <?=$conf['mail_cloud']==2?"selected":""?> >Oreo云短信</option>
                                                  <option value="1" <?=$conf['mail_cloud']==1?"selected":""?> >sendcloud</option>
                                                  <option value="0" <?=$conf['mail_cloud']==0?"selected":""?> >SMTP发信</option>
                                                 </select>
                                                </div>
												<div  id="sh_reg"  style="<?php echo $conf['mail_cloud'] == 0 ? "" : "display: none;";?>">
                                                <div class="form-group">
                                                    <label>SMTP地址</label>
                                                    <div>
                                                      <input type="text" class="form-control" name="mail_smtp"  placeholder="如：smtp.qq.com" value="<?php echo $conf['mail_smtp']; ?>" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>SMTP端口</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="一般465或25" name="mail_port" value="<?php echo $conf['mail_port']; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>邮箱账号</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="请输入邮箱账号" name="mail_name" value="<?php echo $conf['mail_name']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>邮箱密码</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="请输入正确的密码/授权码"  name="mail_pwd" value="<?php echo $conf['mail_pwd']; ?>"/>
                                                    </div>
                                                </div></div>
												<div  id="sh_oreo"  style="<?php echo $conf['mail_cloud'] == 2 ? "" : "display: none;";?>">
                                                <div class="form-group">
                                                    <label>Token</label>
                                                    <div>
                                                      <input type="text" class="form-control" name="oreo_smstoken"  placeholder="" value="<?php echo $conf['oreo_smstoken']; ?>" class="form-control"/>
                                                    </div>
													<small>* Oreo云短信调用腾讯云短信，因此该服务需要付出一定的费用</small><br>
												    <small>* Oreo云短信开通方法请到<a href="https://auth.oreopay.com/user/oreo_sms.php">Oreo授权站</a>开通，开通成功送出极验</small>
                                                </div>
                                              </div>
												<div  id="sh_dx"  style="<?php echo $conf['mail_cloud'] == 1 ? "" : "display: none;";?>">
                                                <!--<div class="form-group">
                                                    <label>Send Cloud API_USER</label>
                                                    <div>
                                                        <input class="form-control"  type="text range" placeholder="请登录官网获取" name="mail_apiuser" value="<?php /*echo $conf['mail_apiuser']; */?>"/>
                                                    </div>
                                                </div>
                                              <div class="form-group">
                                                    <label>Send Cloud API_KEY</label>
                                                    <div>
                                                        <input class="form-control"  type="text range" placeholder="请登录官网获取" name="mail_apikey" value="<?php /*echo $conf['mail_apikey']; */?>" class="form-control"/>
                                                    </div>
                                                </div>-->
                                              <div class="form-group">
                                                    <label>app_key</label>
                                                    <div>
                                                        <input class="form-control"  type="text range" placeholder="" name="sms_appkey" value="<?php echo $conf['sms_appkey']; ?>"/>
                                                      <small>* admin.978w.cn【我的接口】页面查看</small>
                                                    </div>
                                                </div>
                                                    <div class="form-group">
                                                        <label>短信模板ID</label>
                                                        <div>
                                                            <input class="form-control"  type="text range" placeholder="" name="mail_apiuser" value="<?php echo $conf['mail_apiuser']; ?>" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>网站名称</label>
                                                        <div>
                                                            <input class="form-control"  type="text range" placeholder="不超过12字符且不允许有空格" name="mail_apikey" value="<?php echo $conf['mail_apikey']; ?>" class="form-control"/>
                                                        </div>
                                                    </div>
												 <div class="form-group">
                                                    <label>CAPTCHA_ID</label>
                                                    <div>
                                                        <input class="form-control"  type="text range" 
                                                                 placeholder="请登录极限验证官方获取" name="CAPTCHA_ID" value="<?php echo $conf['CAPTCHA_ID']; ?>" />
                                                      <small>* Geetest极限验证码配置</small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>PRIVATE_KEY</label>
                                                    <div>
                                                        <input type="text" class="form-control" 
                                                                placeholder="请登录极限验证官方获取" name="PRIVATE_KEY" value="<?php echo $conf['PRIVATE_KEY']; ?>"/>
                                                      <small>* Geetest极限验证码配置</small>
                                                    </div>
                                                </div>     
												</div>          
                                                <div class="form-group m-b-0">
                                                    <div>
                                                         <button type="button" id="dispatch"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                            重置
                                                        </button>
                                                        </form>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                </div> <!-- content -->
                <footer class="footer">
                  <?php echo $conf['copyright']; ?>.
                  <div><?php echo $conf['beian']; ?>.</div>
                </footer>
            <?php include'foot.php';?>
		<script>
	function sh_rg(type,val){
    var gb  = $("#"+type+"_reg");
	var gg  = $("#"+type+"_dx");
	var oreo  = $("#"+type+"_oreo");
    if(val == 0){
       $(gb).show()
       $(gg).hide(); 
       $(oreo).hide();	   
    }
    if(val == 1){
       $(gb).hide()
       $(gg).show();
	   $(oreo).hide();
    }
      if(val ==2){
       $(gb).hide()
       $(gg).hide();
	   $(oreo).show();
    }	
}
		 $("#dispatch").click(function () {			
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=add_oreo_conf",
                            data: $('#oreo_form').serialize(),
                            dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('修改成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
</script>
    </body>
</html>