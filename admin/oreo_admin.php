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
                                                <li class="breadcrumb-item active">配置系统管理员</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">配置系统管理员</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <form id="oreo_form" action="" method="post">
                                                <div class="form-group">
                                                    <label>管理员账号:</label>
                                                    <div>
                                                      <input type="text" class="form-control"  placeholder="后台登录账号"  name="oreo_admin" value="<?php echo $conf['oreo_admin']; ?>"  class="form-control" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>管理员密码:</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="请尽量设置复杂密码" name="oreo_password"  required/>
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