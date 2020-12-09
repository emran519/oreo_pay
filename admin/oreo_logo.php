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
                                                <li class="breadcrumb-item active">更改LOGO</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">更改LOGO</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">更改LOGO配置说明</h4>
											  <p class="text-muted m-b-30 font-14">在这里您可以设置平台的logo！</p>
                                                <div class="form-group">
                                                    <label>LOGO链接</label>
                                                    <div>
                                                        <input type="text" class="form-control" name="logo_url" value="<?php echo $conf['logo_url']?>"/>
														<small>* 显示调用数据库表"['logo_url']"。</small>
														<br>现在的图片：<br><img src="<?php echo $conf['logo_url']?>" style="max-width:100%">
                                                    </div>
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <div>
                                                         <button type="button" id="editLogo" value="保存修改" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                        
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                </div> <!-- content -->
                <?php include'foot.php';?>
		<script>
		$("#editLogo").click(function () {
					 var logo_url=$("input[name='logo_url']").val();
					    
						if (logo_url == '') {
							layer.alert('请确保各项不能为空！');
							return false;
						}
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=add_oreo_conf",
							data: {logo_url: logo_url},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('修改成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								}else {
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