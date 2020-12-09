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
                                                <li class="breadcrumb-item active">模板切换</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">模板切换</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">模板切换配置说明</h4>
                                            <p class="text-muted m-b-30 font-15">当前使用模板目录：<code><?php echo $conf['template']?> </code></p>
											温馨提示：感谢您选择Oreo支付系统，Oreo模板来自互联网，如有侵权请立即联系作者，我们将第一时间删除模板~谢谢支持！ 
											</p>   
                                            <form id="oreo_form" action="" method="post">
                                                <div class="form-group">
                                                    <label>选择模板</label>
                                                  <select  class="form-control" name="template"  default="<?php echo $conf['template']?>"  onchange="setAct(this)" id="product">
                                                      <option value="oreo" url="https://cdn.oreo.2free.cn/mubansrc/oreo.jpg" from="2">oreo</option>
                                                      <option value="index1" url="../template/index/index1/template_view.png" from="2">一号模板</option>
                                                      <option value="index2" url="../template/index/index2/template_view.png" from="2">二号模板</option>
                                                      <option value="index3" url="../template/index/index3/template_view.png" from="2">三号模板</option>
                                                      <option value="index4" url="../template/index/index4/template_view.png" from="2">四号模板</option>
                                                      <option value="index5" url="../template/index/index5/template_view.png" from="2">五号模板</option>
                                                      <option value="index6" url="../template/index/index6/template_view.png" from="2">六号模板</option>
                                                      <option value="index7" url="../template/index/index7/template_view.png" from="2">七号模板</option>
                                                      <option value="index8" url="../template/index/index8/template_view.png" from="2">八号模板</option>
                                                      <option value="index9" url="../template/index/index9/template_view.png" from="2">九号模板</option>
                                                 </select>
                                                </div>
												<br>模板预览图：<br>
												<img id="product_img" src="" style="max-width:100%;margin-top: 1em;">
                                                <div class="form-group m-b-0" style="margin-top: 1.5em;">
                                                    <div>
                                                         <button type="button" id="editTemplate" value="保存修改" class="btn btn-primary waves-effect waves-light" >
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
        function setAct(id){
            var url = $('#product').find("option:selected").attr("url"); 
            var from = $('#product').find("option:selected").attr("from"); 
            if (from == 1) {
                $('#product_img').attr('src', '__IMG__' + url);
            }
            if (from == 2) {
                $('#product_img').attr('src', url);
            }
        }		
                     $("#editTemplate").click(function () {
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