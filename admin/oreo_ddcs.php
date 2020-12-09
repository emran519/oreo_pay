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
                                                <li class="breadcrumb-item active">订单测试设置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">订单测试设置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">订单测试设置说明</h4>
                                            <p class="text-muted m-b-30 font-14">在这里您可以设置平台的订单测试参数，请认真填写每一项，确保没有错误！</p>
                                            <form id="oreo_form" action="" method="post">
                                                 <div class="form-group">
                                                    <label>订单测试开关(用户页面)</label>
                                                    <div>
                                                    <select  class="form-control" name="ddcsuser" id="ddcsuser" onchange="dd_csus('ztu',this.value)">
                                                    <option value="0" <?=$conf['ddcsuser']==0?"selected":""?> >关闭</option>
                                                    <option value="1" <?=$conf['ddcsuser']==1?"selected":""?> >开启</option>          
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group" id="ztu_cx" style="<?php echo $conf['ddcsuser'] == 1 ? "" : "display: none;";?>">
												<div class="form-group">
                                                    <label>是否固定金额(用户页面)</label>
                                                    <div>
                                                    <select  class="form-control" name="ddcsusje" id="ddcsusje" onchange="dd_csusje('ztuj',this.value)">
                                                    <option value="0" <?=$conf['ddcsusje']==0?"selected":""?> >否</option>
                                                    <option value="1" <?=$conf['ddcsusje']==1?"selected":""?> >是</option>          
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group" id="ztuj_cx" style="<?php echo $conf['ddcsusje'] == 1 ? "" : "display: none;";?>">
												<div class="form-group">
                                                    <label>订单金额(用户页面):</label>
                                                    <div>
                                                      <input type="text" class="form-control"  placeholder="设置默认金额"  name="ddcsus_money" value="<?php echo $conf['ddcsus_money']; ?>"  class="form-control" required/>
                                                    </div>
                                                </div>
												</div></div>
												<br><hr class="hr97">
												<div class="form-group">
                                                    <label>订单测试开关(首页)</label>
                                                    <div>
                                                    <select  class="form-control" name="ddcs" id="ddcs" onchange="dd_cs('zt',this.value)">
                                                    <option value="0" <?=$conf['ddcs']==0?"selected":""?> >关闭</option>
                                                    <option value="1" <?=$conf['ddcs']==1?"selected":""?> >开启</option>          
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group" id="zt_cx" style="<?php echo $conf['ddcs'] == 1 ? "" : "display: none;";?>">
												<div class="form-group">
                                                    <label>订单金额(首页):</label>
                                                    <div>
                                                      <input type="text" class="form-control"  placeholder="设置默认金额"  name="ddcs_money" value="<?php echo $conf['ddcs_money']; ?>"  class="form-control" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>商户ID(首页)</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="收款ID,一般是1000" name="ddcs_id" value="<?php echo $conf['ddcs_id']; ?>" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>商户密钥(首页)</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="收款ID对应的KEY，一般是1000的key" name="ddcs_key" value="<?php echo $conf['ddcs_key']; ?>" required/>
                                                    </div>
                                                </div></div>
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
	function dd_cs(type,val){
    var gb  = $("#"+type+"_cx");
    if(val == 0){
       $(gb).hide() 
    }
    if(val == 1){
       $(gb).show()
    }
    
}
	function dd_csus(type,val){
    var gb  = $("#"+type+"_cx");
    if(val == 0){
       $(gb).hide() 
    }
    if(val == 1){
       $(gb).show()
    }
    
}
	function dd_csusje(type,val){
    var gb  = $("#"+type+"_cx");
    if(val == 0){
       $(gb).hide() 
    }
    if(val == 1){
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