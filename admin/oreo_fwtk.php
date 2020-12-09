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
                                                <li class="breadcrumb-item active">服务条款配置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">服务条款配置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">服务条款配置说明</h4>
                                            <p class="text-muted m-b-30 font-14">在这里您可以设置平台的服务条款参数，不填写则是不显示服务条款！</p>
                                                <div class="form-group">
                                                    <label>服务条款配置</label>
                                                    <div>
                                                       <textarea  placeholder="Oreo支付系统服务条款..." name="agreement" rows="8" class="form-control"><?php echo $conf['agreement']; ?></textarea>
                                                       <small>* 全局服务条款中显示内容！</small>
                                                  </div>
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <div> 
                                                        <button type="button" id="fwtk"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                            重置
                                                        </button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                </div> <!-- content -->
                <?php include'foot.php';?>
		<script>
		 $("#fwtk").click(function () {				    
						var agreement=$("textarea[name='agreement']").val();				
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=add_oreo_conf",
							data: {agreement:agreement},
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