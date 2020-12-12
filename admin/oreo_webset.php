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
                                                <li class="breadcrumb-item active">站点信息配置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">站点信息配置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">站点信息配置说明</h4>
                                            <p class="text-muted m-b-30 font-14">在这里您可以设置平台的有关参数，请认真填写每一项，确保没有错误！</p>
                                            <form id="oreo_form" action="" method="post">
                                                <div class="form-group">
                                                    <label>网站名称:</label>
                                                    <div>
                                                      <input type="text" class="form-control"  placeholder="如：Oreo支付系统"  name="web_name" value="<?php echo $conf['web_name']; ?>"  class="form-control" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>网站URL链接</label>
                                                    <div>
                                                        <input type="text" class="form-control" 
                                                                placeholder="请不要加http://" name="local_domain" value="<?php echo $conf['local_domain']; ?>"  name="local_domain" value="<?php echo $conf['local_domain']; ?>" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>ICP备案号</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="非必填" name="beian" value="<?php echo $conf['beian']; ?>" required/>
                                                    </div>
                                                </div>
                                               <div class="form-group">
                                                    <label>网站版权信息</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="如 2017-2019 OREO支付系统版权所有" name="copyright" value="<?php echo $conf['copyright']; ?>" required/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>网站关键词（优化SEO）</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="如 Oreo支付系统，懂你的才是最好的！" name="webcontent" value="<?php echo $conf['webcontent']; ?>" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>配置接口站跳转URL</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="如需开启接口站，请配置好跳转地址后前往模板切换中选择接口站模板并保存修改！(按Http头,/尾的格式填写)"
                                                               name="api_link" value="<?php echo $conf['api_link']; ?>" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>客服QQ</label>
                                                    <div>
                                                        <input class="form-control"  type="text range" placeholder="QQ号码" name="web_qq" value="<?php echo $conf['web_qq']; ?>" required/>
                                                    </div>
                                                </div>
                                              <div class="form-group">
                                                    <label>客服微信</label>
                                                    <div>
                                                        <input class="form-control"  type="text range" placeholder="客服微信" class="form-control" name="web_wx" value="<?php echo $conf['web_wx']; ?>" required/>
                                                    </div>
                                                </div>
                                              <div class="form-group">
                                                    <label>联系电话</label>
                                                    <div>
                                                        <input class="form-control"  type="text range" placeholder="联系电话" class="form-control" name="phone" value="<?php echo $conf['phone']; ?>" required/>
                                                    </div>
                                                </div>
                                              <div class="form-group">
                                                    <label>联系邮箱</label>
                                                    <div>
                                                        <input class="form-control"  type="text range" placeholder="网站邮箱" name="web_mail" value="<?php echo $conf['web_mail']; ?>" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>公司地址</label>
                                                    <div>
                                                        <input class="form-control"  type="text range" placeholder="无则留空" name="dizhi" value="<?php echo $conf['dizhi']; ?>" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>QQ交流群号</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="商户交流群" name="web_qh" value="<?php echo $conf['web_qh']; ?>" required/>
                                                    </div>
                                                </div>   
                                              <div class="form-group">
                                                    <label>QQ交流群链接</label>
                                                    <div>
                                                        <input class="form-control"  type="text range" placeholder="商户交流群URL链接" name="web_lj" value="<?php echo $conf['web_lj']; ?>" required/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>微信H5开关</label>
                                                    <div>
                                                    <select  class="form-control" name="wxpay_h5" id="wxpay_h5">
                                                    <option value="0" <?=$conf['wxpay_h5']==0?"selected":""?> >关闭</option>
                                                    <option value="1" <?=$conf['wxpay_h5']==1?"selected":""?> >开启</option>          
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>QQ防红跳转</label>
                                                    <div>
                                                    <select  class="form-control" name="qqtz" id="qqtz">
                                                    <option value="0" <?=$conf['qqtz']==0?"selected":""?> >关闭</option>
                                                    <option value="1" <?=$conf['qqtz']==1?"selected":""?> >开启</option>          
                                                    </select>
                                                    </div>
                                                </div>
                                              <div class="form-group">
                                                    <label>维护模式选项</label>
                                                    <div>
                                                    <select  class="form-control" name="web_is" id="web_is" onchange="sh_rg('sh',this.value)">
                                                    <option value="0" <?=$conf['web_is']==0?"selected":""?> >关闭</option>
                                                    <option value="1" <?=$conf['web_is']==1?"selected":""?> >开启界面维护（开启后，商户前、后台所有页面将弹出维护提示，但对接支付模块任可正常运行，也就是收银台可正常支付收款）</option>
                                                    <option value="2" <?=$conf['web_is']==2?"selected":""?> >开启整站维护（开启后，商户前、后台、所有页面及对接支付模块全部弹出维护提示，也就是收银台无法支付收款）</option>
                                                    </select>
                                                    </div>
                                                </div>
                                              <div class="form-group" id="sh_reg"  style="<?php echo $conf['web_is'] == 1 ||$conf['web_is'] == 2 ? "" : "display: none;";?>">
                                                    <label>维护提示信息</label>
                                                    <div>
                                                       <textarea  placeholder="支付系统正在维护中，请稍后访问！" name="web_offtext" rows="5" class="form-control"><?php echo $conf['web_offtext']; ?></textarea>
                                                       
                                                    </div>
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="webset"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
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
    if(val == 0){
       $(gb).hide() 
    }
    if(val == 1){
       $(gb).show()
    }
    if(val == 2){
       $(gb).show() 
    }	
}
		 $("#webset").click(function () {
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