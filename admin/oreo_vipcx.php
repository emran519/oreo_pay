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
                                                <li class="breadcrumb-item"><a href="#">资金管理</a></li>
                                                <li class="breadcrumb-item active">会员购买列表</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">会员购买列表</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">会员购买列表说明</h4>
                                            <p class="text-muted m-b-30 font-14">这里所产生的数据是<code>平台所有的会员购买数据</code>这些数据能当做消费凭证。
                                            </p>
                                            <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap">
                                                <thead>
                                                <tr>
                                                <th>商户ID</th>
		                                            <th>名称</th>
		                                            <th>消费</th>
		                                            <th>开通时间</th> 
 													<th>状态</th>
													<th style="display: none">oreo</th>
													<th>操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php									
$sql=" 1";
$numrows=$DB->query("SELECT count(*) from oreo_viporder WHERE{$sql}")->fetchColumn();
$link='&my=search&column='.$_POST['column'].'&value='.$_POST['my'];
$pagesize=10;
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
{
 $pages++;
 }
if (isset($_GET['page'])){
$page=intval($_GET['page']);
}
else{
$page=1;
}
$offset=$pagesize*($page - 1);
$list=$DB->query("SELECT * FROM oreo_viporder WHERE{$sql} order by id desc limit $offset,$pagesize");				
while($res = $list->fetch())
{
$url = creat_callback($res);
$domain = !empty($res['domain']) ? $res['domain'] : getdomain($res['notify_url']);	
echo '
	<tr>
	<td>' . $res['uid'] . '</td>	
	<td>' . $res['name'] . '</td>
	<td>¥' . $res['money'] . '</td>
	<td>' . $res['time'] . '</td>
    <td>'.($res['type']==1?'<a class="btn btn-xs btn-info" data-toggle="modal" data-target="#quxiao" data-id="quxiao" >当前:正常</a>':null).($res['type']==0?'<a class="btn btn-xs btn-danger" data-toggle="modal" data-target="#kaitong" data-id="kaitong">当前:关闭</a>':null).'</td>	
	<td style="display: none;">' . $res['typname'] . '</td>
	<td><a data-toggle="modal" data-target="#shanchu" data-id="shanchu" class="btn btn-xs btn-danger" >删除</a></td>
	</tr>';
}
 ?>
                                                
                                               
                                                </tbody>
                                            </table>
											</div>
											<nav style="float: inline-end;">
<?php
echo'<ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li class="page-item"><a class="page-link" href="oreo_vipcx.php?page='.$first.$link.'">首页</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_vipcx.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_vipcx.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=3)$s=3;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_vipcx.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li class="page-item"><a class="page-link" href="oreo_vipcx.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_vipcx.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">尾页</a></li>';
}
echo'</ul>';
#分页
?>
                                                </nav>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div><!-- container -->
                    </div> <!-- Page content Wrapper -->
					<div class="modal fade bs-example-modal-center"   id="quxiao" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的操作</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="uids" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>会员类型:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca1" name="hylx" readonly="readonly" />
													   <input type="text" class="form-control ca5" name="leixing"   readonly="readonly" style="display: none;" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="guan"  value="提交" class="btn btn-danger waves-effect" >
                                                            取消权限
                                                        </button>
                                                    </div>
                                                </div>
												
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->	
								   	<div class="modal fade bs-example-modal-center"   id="kaitong" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的操作</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="kuids" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>会员类型:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca1" name="khylx"  readonly="readonly" />
													   <input type="text" class="form-control ca5" name="kleixing"   readonly="readonly" style="display: none" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="kai"  value="提交" class="btn btn-primary waves-effect waves-light" >
                                                            开通权限
                                                        </button>
                                                    </div>
                                                </div>
												
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->	
								   <div class="modal fade bs-example-modal-center"   id="shanchu" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的操作</h5>
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
												<div class="form-group">
                                                    <label>名称:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca1"  readonly="readonly" name="vname" />
													  <input type="text" class="form-control ca5" name="sclx"   readonly="readonly" style="display: none" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="shanchul"  value="提交" class="btn btn-danger waves-effect" >
                                                            确认删除
                                                        </button>
                                                    </div>
                                                </div>
												
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->	
                </div> <!-- content -->
                <?php include'foot.php';?>
<script src="../assets/admin/js/jquery.dataTables.min.js"></script>
<script src="../assets/admin/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/admin/js/datatables.init.js"></script> 
		<script>
	 $('#quxiao').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(1).text();
      modal.find('.ca1').val(content);
	  var content = btnThis.closest('tr').find('td').eq(5).text();
      modal.find('.ca5').val(content);
	 
});
    $('#kaitong').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(1).text();
      modal.find('.ca1').val(content);
	  var content = btnThis.closest('tr').find('td').eq(5).text();
      modal.find('.ca5').val(content);
	 
});
 $('#shanchu').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(1).text();
      modal.find('.ca1').val(content);
	  var content = btnThis.closest('tr').find('td').eq(5).text();
      modal.find('.ca5').val(content);
	 
});
                        $("#guan").click(function () {
						var uids=$("input[name='uids']").val();
						var hylx=$("input[name='hylx']").val();
						var leixing=$("input[name='leixing']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_SvipGuan",
							data: {uids:uids,hylx:hylx,leixing:leixing},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('已成功取消权限', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$("#kai").click(function () {
						var kuids=$("input[name='kuids']").val();
						var khylx=$("input[name='khylx']").val();
						var kleixing=$("input[name='kleixing']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_SvipKai",
							data: {kuids:kuids,khylx:khylx,kleixing:kleixing},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('已成功开通权限', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$("#shanchul").click(function () {
						var ids=$("input[name='ids']").val();
						var vname=$("input[name='vname']").val();
						var sclx=$("input[name='sclx']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_ShanchuVip",
							data: {ids:ids,vname:vname,sclx:sclx},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('删除成功', function(index) {
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