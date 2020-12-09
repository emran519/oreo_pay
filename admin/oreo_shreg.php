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
                                                <li class="breadcrumb-item active">申请商户配置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">申请商户配置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">申请商户配置说明</h4>
                                            <p class="text-muted m-b-30 font-14">在这里您可以设置平台的申请商户有关参数，请认真填写每一项，否则可能商户无法注册！</p>
                                            <form id="oreo_form" action="" method="post">
                                                <div class="form-group">
                                                    <label>是否开放自助申请商户</label>
                                                    <select  class="form-control" name="is_reg" id="is_reg" onchange="sh_rg('sh',this.value)">
                                                    <option value="1" <?=$conf['is_reg']==1?"selected":""?> >开启</option>
                                                     <option value="0" <?=$conf['is_reg']==0?"selected":""?> >关闭</option>
                                                    </select>
                                                </div>
                                                   <div class="form-group" id="sh_reg" style="<?php echo $conf['is_reg'] == 0 ? "" : "display: none;";?>">
                                                    <label>关闭自助申请商户提示信息</label>
                                                    <div>
                                                       <textarea  placeholder="Oreo支付系统提醒您：管理员已关闭商户在线申请功能，请稍后重试！" name="reg_offtext" rows="4" class="form-control"><?php echo $conf['reg_offtext']; ?></textarea>
                                                       <small>* 所填提示内容将会在关闭自助申请商户的情况下显示在商户自助注册页面，如果上方按钮为开启，此提示将不会显示！</small>
                                                  </div>
                                                </div>
												
												
                                                <div class="form-group">
                                                    <label>商户申请是否收费</label>
                                                    <select  class="form-control" name="is_payreg" id="is_payreg" onchange="sh_sf('sf',this.value)">
                                                    <option value="1" <?=$conf['is_payreg']==1?"selected":""?> >收费</option>
                                                     <option value="0" <?=$conf['is_payreg']==0?"selected":""?> >免费</option>
                                                    </select>
                                                </div>
												<div class="form-group" id="sf_sfm" style="<?php echo $conf['is_payreg'] == 1 ? "" : "display: none;";?>">
                                                   <div class="form-group">
                                                    <label>付费申请收款商户ID</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="reg_pid" value="<?php echo $conf['reg_pid']; ?>" />
                                                    </div>
                                                </div>
                                                    <div class="form-group">
                                                    <label>商户申请价格</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="reg_price" value="<?php echo $conf['reg_price']; ?>" />
                                                    </div>
                                                </div> </div>
                                                   <div class="form-group">
                                                    <label>申请验证方式</label>
                                                    <select  class="form-control" name="verifytype" id="verifytype">
                                                    <option value="0" <?=$conf['verifytype']==0?"selected":""?> >邮箱验证</option>
                                                    <option value="1" <?=$conf['verifytype']==1?"selected":""?> >手机验证</option>
                                                    </select>
                                                </div>
                                                   <div class="form-group">
                                                    <label>是否开启支付宝结算</label>
                                                    <select  class="form-control" name="stype_1" id="stype_1">
                                                    <option value="1" <?=$conf['stype_1']==1?"selected":""?> >开启</option>
                                                     <option value="0" <?=$conf['stype_1']==0?"selected":""?> >关闭</option>
                                                    </select>
                                                </div>
                                                   <div class="form-group">
                                                    <label>是否开启微信结算</label>
                                                    <select  class="form-control" name="stype_2" id="stype_2">
                                                    <option value="1" <?=$conf['stype_2']==1?"selected":""?> >开启</option>
                                                     <option value="0" <?=$conf['stype_2']==0?"selected":""?> >关闭</option>
                                                    </select>
                                                </div>
                                                   <div class="form-group">
                                                    <label>是否开启QQ钱包结算</label>
                                                    <select  class="form-control" name="stype_3" id="stype_3">
                                                    <option value="1" <?=$conf['stype_3']==1?"selected":""?> >开启</option>
                                                     <option value="0" <?=$conf['stype_3']==0?"selected":""?> >关闭</option>
                                                    </select>
                                                </div>
                                                   <div class="form-group">
                                                    <label>是否开启银行卡结算</label>
                                                    <select  class="form-control" name="stype_4" id="stype_4">
                                                    <option value="1" <?=$conf['stype_4']==1?"selected":""?> >开启</option>
                                                     <option value="0" <?=$conf['stype_4']==0?"selected":""?> >关闭</option>
                                                    </select>
                                                </div>                                                   
                                                <div class="form-group m-b-0">
                                                    <div> 
                                                        <button  type="button" id="editshreg"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
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
       $(gb).show()
       $(gg).hide();  
    }
    if(val == 1){
       $(gb).hide()
       $(gg).show();
    }        
}
function sh_sf(type,val){
    var sfm  = $("#"+type+"_sfm");
    if(val == 0){
       $(sfm).hide();  
    }
    if(val == 1){
       $(sfm).show();
    }        
}
		 $("#editshreg").click(function () {
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