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
                                                <li class="breadcrumb-item active">小程序配置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">小程序配置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">小程序说明</h4>
                                            <p class="text-muted m-b-30 font-14">在Oreo综合服务站申请开通小程序权限后您的站点即可在微信【易用户中心】中登录，该小程序集中用户端关键功能！</p>
                                            <form id="oreo_form" action="" method="post">
                                                <div class="form-group">
                                                    <label>AppId:</label>
                                                    <div>
                                                      <input type="text" class="form-control"  placeholder="综合服务站获取的AppId"  name="oreo_applet_appid" value="<?php echo $conf['oreo_applet_appid']; ?>"  class="form-control" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>AppSecret:</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="综合服务站获取的AppSecret" value="<?php echo $conf['oreo_applet_secret']; ?>" name="oreo_applet_secret" required/>
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