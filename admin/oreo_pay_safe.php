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
                                                <li class="breadcrumb-item active">接口安全设置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">接口安全设置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">接口安全设置说明</h4>
                                            <p class="text-muted m-b-30 font-14">您在这里可以设置您对接接口的动态验证，如果您允许接口信息同步于oreo云端，则当您的接口被更改（包括数据库内更改）时您会收到Oreo的通知手机短信.<br>
                                                目前此功能仅支持Oreo正式注册会员，如果您是授权码登录，建议您注册账号域名过户到本账户.<br>
                                                如果开启接受短信将会扣除您的oreo综合服务站中的短信数量.<br>
                                                如果您修改了接口可以在此页面进行同步数据的操作，我们会根据你的选择来判断是否进行云端同步的操作，并且会为您专属定制安全策略.</p>
												<div class="form-group">
                                                    <label>是否开启同步云端</label>
                                                    <div>
                                                    <select  class="form-control" name="oreo_return" id="oreo_return">
                                                    <option value="0" <?=$conf['oreo_return']==0?"selected":""?> >关闭</option>
                                                    <option value="1" <?=$conf['oreo_return']==1?"selected":""?> >开启</option>          
                                                    </select>
                                                    </div>
													<small>* 当开启时您的同步参数会于本地时刻进行一致性认证.</small>
                                                </div>
												<div class="form-group">
                                                    <label>是否开启短息通知</label>
                                                    <div>
                                                    <select  class="form-control" name="oreo_yz_url" id="oreo_yz_url">
                                                    <option value="0" <?=$conf['oreo_yz_url']==0?"selected":""?> >关闭</option>
                                                    <option value="1" <?=$conf['oreo_yz_url']==1?"selected":""?> >开启</option>          
                                                    </select>
                                                    </div>
													<small>* 当开启接受短信时，若接口发生改变且未进行同步时您将收到短信提示.</small>
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="webset"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
                                                            同步数据
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
							url: "oreo_sub.php?act=edit_OreoPayis",
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