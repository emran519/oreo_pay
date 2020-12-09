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
                                                <li class="breadcrumb-item active">商户登录配置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">商户登录配置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">商户登录配置说明</h4>
                                            <p class="text-muted m-b-30 font-14">在这里您可以设置平台的商户登录参数，请认真填写每一项！</p>
                                            <form id="oreo_form" action="" method="post">
                                                <div class="form-group">
                                                    <label>商户登录状态</label>
                                                    <select  class="form-control" name="login_is" id="login_is" onchange="sh_rg('sh',this.value)">
                                                    <option value="1" <?=$conf['login_is']==1?"selected":""?> >关闭(禁止商户登录)</option>
                                                     <option value="0" <?=$conf['login_is']==0?"selected":""?> >开启（允许商户登录）</option>
                                                    </select>
                                                </div>
                                                <div class="form-group"  id="sh_reg"  style="<?php echo $conf['login_is'] == 1 ? "" : "display: none;";?>">
                                                    <label>若关闭登录则维护提示信息</label>
                                                    <div>
                                                       <textarea  placeholder="Oreo支付系统提醒您：管理员已开启商户登录维护模式，请稍后重试！！" name="login_offtext" rows="4" class="form-control"><?php echo $conf['login_offtext']; ?></textarea>
                                                       <small>* 所填提示内容将会在开启商户登录维护模式的情况下显示在商户登录页面，如果上方按钮为关闭，此提示将不会显示！</small>
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>快捷登录方式</label>
                                                    <select  class="form-control" name="quicklogin" id="quicklogin" onchange="qc_rg('qc',this.value)">
                                                    <option value="0" <?=$conf['quicklogin']==0?"selected":""?> >关闭快捷登录</option>
                                                    <option value="1" <?=$conf['quicklogin']==1?"selected":""?> >Oreo免签QQ快捷登录</option>
                                                    <option value="3" <?=$conf['quicklogin']==3?"selected":""?> >Oreo免签微信快捷登录</option>
                                                    <option value="4" <?=$conf['quicklogin']==4?"selected":""?> >Oreo免签微信和QQ免签登录</option>
                                                    <option value="2" <?=$conf['quicklogin']==2?"selected":""?> >官方QQ快捷登录</option>
                                                    <option value="5" <?=$conf['quicklogin']==5?"selected":""?> >官方QQ快捷登录和Oreo免签微信</option>
                                                    </select>
                                                </div>
												<div class="form-group"  id="qc_qcg"  style="<?php echo $conf['quicklogin'] == 2 ||$conf['quicklogin'] == 5 ? "" : "display: none;";?>">
                                                <div class="form-group">
                                                    <label>QQ应用appid</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="QQ应用appid"  name="qopen_id" value="<?php echo $conf['qopen_id']; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>QQ应用appkey</label>
                                                    <div>
                                                        <input class="form-control"  type="text range" placeholder="QQ应用appkey" name="qopen_key" value="<?php echo $conf['qopen_key']; ?>"/>
                                                    </div>
                                                </div>
												 </div>
												 <div class="form-group"  id="qc_qco"  style="<?php echo $conf['quicklogin'] == 1 ||$conf['quicklogin'] == 4 ? "" : "display: none;";?>">
												  <div class="form-group">
                                                    <label>Oreo免签QQ-Token</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="Oreo免签QQ-Token"  name="oreo_qq_token" value="<?php echo $conf['oreo_qq_token']; ?>"/>
                                                    </div>
                                                </div>
												 <small>* 仅需配置Token，无需繁琐配置，如没有权限请登录<a href="https://auth.oreopay.com/">Oreo授权系统</a>申请获取权限</small>
												 </div>
                                                 <div class="form-group"  id="qc_orw"  style="<?php echo $conf['quicklogin'] == 3 ||$conf['quicklogin'] == 4 ||$conf['quicklogin'] == 5 ? "" : "display: none;";?>">
												  <div class="form-group">
                                                    <label>Oreo微信免签Token</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="Oreo微信免签Token"  name="oreo_wx_token" value="<?php echo $conf['oreo_wx_token']; ?>"/>
                                                    </div>
                                                </div>
												 <small>* 仅需配置Token，无需繁琐配置，如没有权限请登录<a href="https://auth.oreopay.com/">Oreo授权系统</a>申请获取权限</small>
												 </div>
                                                <div class="form-group m-b-0">
                                                    <div> 
                                                        <button type="button" id="shlogin"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
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
               <?php include'foot.php';?>
		<script>
	function sh_rg(type,val){
    var gb  = $("#"+type+"_reg");
    if(val == 1){
       $(gb).show()
       $(gg).hide();  
    }
    if(val == 0){
       $(gb).hide()
       $(gg).show();
    }        
}
	function qc_rg(type,val){
    var kq  = $("#"+type+"_qcg");
	var kqo  = $("#"+type+"_qco");
    var ow  = $("#"+type+"_orw");
    if(val == 0){
       $(kq).hide(); 
	   $(kqo).hide();  
       $(ow).hide();
    }
    if(val == 1){
       $(kq).hide(); 
	   $(kqo).show();  
       $(ow).hide();
    }
    if(val == 2){
       $(kq).show();
	   $(kqo).hide();
       $(ow).hide();
    }     
	if(val == 3){
       $(kq).hide();
	   $(kqo).hide();
       $(ow).show();
    }       
    if(val == 4){
       $(kq).hide();
	   $(kqo).hide();
       $(ow).show();
       $(kqo).show();  
    } 
    if(val == 5){
       $(kq).show();
	   $(kqo).hide();
       $(ow).show();
       $(kqo).hide();  
    }         
}
		 $("#shlogin").click(function () {
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
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}  
</script>
    </body>
</html>