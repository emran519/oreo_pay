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
                                                <li class="breadcrumb-item active">参数与回调</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">参数与回调</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">参数与回调说明</h4>
                                            <p class="text-muted m-b-30 font-14">在这里您可以设置平台的有关参数，请认真填写每一项，确保没有错误！</p>
												<div class="form-group">
                                                    <label>自定义订单名称</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="order_name" value="<?php echo $conf['order_name']; ?>" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>是否开启同步通知</label>
                                                    <div>
                                                    <select  class="form-control" name="oreo_return" id="oreo_return">
                                                    <option value="0" <?=$conf['oreo_return']==0?"selected":""?> >关闭</option>
                                                    <option value="1" <?=$conf['oreo_return']==1?"selected":""?> >开启</option>          
                                                    </select>
                                                    </div>
													<small>* 当您的服务器做了一些安全设置，拒绝外部Post，拒绝官方回调是请必选开启.</small>
													<br><small>* 当选择开启时，系统同时启用异步通知与同步通知，这也可能会增加一些风险.</small>
													<br><small>* 如果服务器支持外部Post我们的建议是此处选择关闭.</small>
                                                </div>
												<div class="form-group">
                                                    <label>验证对接域名</label>
                                                    <div>
                                                    <select  class="form-control" name="oreo_yz_url" id="oreo_yz_url">
                                                    <option value="0" <?=$conf['oreo_yz_url']==0?"selected":""?> >关闭</option>
                                                    <option value="1" <?=$conf['oreo_yz_url']==1?"selected":""?> >开启</option>          
                                                    </select>
                                                    </div>
													<small>* 当开启此功能系统对商户对接域名进行验证，当不符合条件禁止正常下单.</small>
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="webset"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
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
		 $("#webset").click(function () {
			            var oreo_return = $("#oreo_return").val();	
						var oreo_yz_url = $("#oreo_yz_url").val();	
						var order_name=$("input[name='order_name']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=add_oreo_conf",
							data: {oreo_return:oreo_return,oreo_yz_url:oreo_yz_url,order_name:order_name},
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