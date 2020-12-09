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
                                                <li class="breadcrumb-item"><a href="#">商户管理</a></li>
                                                <li class="breadcrumb-item active">商户收款码</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">商户收款码</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">                                   
												 <div class="form-group">
                                                    <label>商户收款码上传开关</label>
                                                  <select  class="form-control" name="sh_codes"  id="sh_codes" >
                                                  <option value="1" <?=$conf['sh_codes']==1?"selected":""?> >开启</option>
                                                  <option value="0" <?=$conf['sh_codes']==0?"selected":""?> >关闭</option>
                                                 </select>
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <div>
                                                         <button type="button" id="shcode"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                </div> <!-- content -->
                            
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">商户收款码说明</h4>
											<code style="font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;只有上传收款码的商户才能在一下列表内</code><br>
											<code style="font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;以下为商户上传的收款码，当管理员删除收款码时自动将文件夹内删除有关图片并清除商户的有关信息</code><br>
                                            <table id="datatable" class="table table-bordered">
                                                <thead style="text-align: center;">
                                                <tr>								
              <th>商户ID</th>
              <th>支付宝</th>
              <th>微信支付</th>
              <th>QQ钱包</th>
			  <th>操作</th>
                                                </tr>
                                                </thead>  
                                                <tbody style="text-align: center;">
<?php
$rs=$DB->query("SELECT * FROM oreo_user  where alipaycode!='' or wxpaycode!='' or qqpaycode!=''");
while($res = $rs->fetch())
{
echo '
<tr>
<td>'.$res['id'].'</td>
<td><img src="'.$res['alipaycode'].'" id="scan2" alt="暂无图片" class="rounded img-raised" style="width: 100px;height: 100px;"></td>
<td><img src="'.$res['wxpaycode'].'" id="scan2" alt="暂无图片" class="rounded img-raised" style="width: 100px;height: 100px;"></td>
<td><img src="'.$res['qqpaycode'].'" id="scan2" alt="暂无图片" class="rounded img-raised" style="width: 100px;height: 100px;"></td>
<td><a data-toggle="modal" data-target="#shanchu" data-id="shanchu" class="btn btn-xs btn-danger" >删除</a></td></tr>';
}
?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
							 <div class="modal fade bs-example-modal-center"   id="shanchu" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的删除操作</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="ids" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="deleteali"  value="支付宝" class="btn btn-xs btn-info" >
                                                            支付宝
                                                        </button>&nbsp;&nbsp;
														<button type="button" id="deletewx"  value="微信" class="btn btn-success" >
                                                            微信
                                                        </button>&nbsp;&nbsp;
														<button type="button" id="deleteqq"  value="QQ" class="btn btn-secondary waves-effect">
                                                            QQ
                                                        </button>
														
                                                    </div>
                                                </div>
												
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->	
                        </div><!-- container -->
                    </div> <!-- Page content Wrapper -->
                </div> <!-- content -->
<?php include'foot.php';?>
<script src="../assets/admin/js/jquery.dataTables.min.js"></script>
<script src="../assets/admin/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/admin/js/datatables.init.js"></script> 
<script> 
 $('#shanchu').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
});
                        $("#deleteali").click(function () {
						var ids=$("input[name='ids']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=delete_codeAli",
							data: {ids:ids},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('删除支付宝收款码成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					}); 
					 $("#deletewx").click(function () {
						var ids=$("input[name='ids']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=delete_codeWx",
							data: {ids:ids},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('删除微信收款码成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					}); 
					$("#deleteqq").click(function () {
						var ids=$("input[name='ids']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=delete_codeQq",
							data: {ids:ids},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('删除QQ收款码成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					}); 
					$("#shcode").click(function () {
						var sh_codes = $("#sh_codes").val();								
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=add_oreo_conf",
							data: {sh_codes:sh_codes},
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