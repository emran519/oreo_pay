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
                                                <li class="breadcrumb-item"><a href="#">一般</a></li>
                                                <li class="breadcrumb-item active">平台公告</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">平台公告</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">平台公告说明</h4>
                                            <p class="text-muted m-b-30 font-14">您可以在此页面修改或删除平台公告数据: <code style="font-size:20px">同时您可以适当的添加HTML代码，包括 style，href等.</code>. </p>
                                                <div class="text-lg-left">
                                                    <button data-toggle="modal" data-target="#tianjia" data-id="tianjia"class="btn btn-success mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i> 添加公告</button>    
											</div><!-- end col-->
                                              <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap">
                                                <thead style="text-align: center;">
                                                <tr>
                                                    <th style="display: none">ID</th>
				<th>标题</th>
          		<th>内容</th>
                <th>添加时间</th>
          		<th>状态</th>
          		<th>操作</th>         
                                                </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                <?php
$sql=" 1";
$numrows=$DB->query("SELECT count(*) from oreo_notice WHERE{$sql}")->fetchColumn();
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
$list=$DB->query("SELECT * FROM oreo_notice WHERE{$sql} order by id desc limit $offset,$pagesize");				
while($res = $list->fetch())
{
echo '
		<td  style="display: none">' . $res['id'] . '</td>
		<td>' . $res['name'] . '</td>
		<td style="max-width: 100px;overflow: hidden; text-overflow:ellipsis;white-space: nowrap">' . htmlspecialchars($res['text']) .'</td>
		<td>' . $res['dtime'] . '</td>
		<td style="display: none">' . $res['type'] . '</td>
		<td>' . ($res['type'] == 1 ? '<font color=green>正常</font>' : '<font color=red>关闭</font>') . '</td>
		<td><a data-toggle="modal" data-target="#bianji" data-id="bianji" class="btn btn-xs btn-info">编辑</a>&nbsp;<a data-toggle="modal" data-target="#shanchu" data-id="shanchu" class="btn btn-xs btn-danger" >删除</a></td></tr>';
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
echo '<li class="page-item"><a class="page-link" href="oreo_notice.php?page='.$first.$link.'">首页</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_notice.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_notice.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=3)$s=3;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_notice.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li class="page-item"><a class="page-link" href="oreo_notice.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_notice.php?page='.$last.$link.'">尾页</a></li>';
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
						<div class="modal fade bs-example-modal-center"   id="bianji" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">编辑公告内容</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>标题:</label>
                                                    <div>
													  <input type="text" class="form-control ca0" name="id" style="display: none"/>
                                                      <input type="text" class="form-control ca1" name="name"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>内容</label>
                                                    <div>
                                                       <textarea name="text" rows="4" class="form-control ca2"></textarea>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>状态</label>
                                                    <div>
                                                    <select class="form-control ca4" name="type" id="type">
                                                    <option value="1" >正常</option>
                                                    <option value="0" >关闭</option>  
                                                    </select>
                                                    </div>
                                                </div>
												 <div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="xiugai"  value="提交" class="btn btn-primary waves-effect waves-light" >
                                                            提交
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
                                                    <label>ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="ids" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>标题:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca1"  readonly="readonly" />
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
								   	<div class="modal fade bs-example-modal-center"   id="tianjia" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">添加公告</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>标题:</label>
                                                    <div>
                                                      <input type="text" class="form-control" name="namet"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>内容</label>
                                                    <div>
                                                       <textarea name="textt" rows="4" class="form-control"></textarea>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>状态</label>
                                                    <div>
                                                    <select class="form-control" name="typet" id="typet">
                                                    <option value="1" >正常</option>
                                                    <option value="0" >关闭</option>  
                                                    </select>
                                                    </div>
                                                </div>
												 <div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="xtianjia"  value="提交" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                    </div>
                                                </div>
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->	
                    </div> <!-- Page content Wrapper -->
                </div> <!-- content -->
                 <?php include'foot.php';?>
<script src="../assets/admin/js/jquery.dataTables.min.js"></script>
<script src="../assets/admin/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/admin/js/datatables.init.js"></script> 			 
		<script>
	 $('#bianji').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(1).text();
      modal.find('.ca1').val(content);
	  var content = btnThis.closest('tr').find('td').eq(2).text();
      modal.find('.ca2').val(content);
	  var content = btnThis.closest('tr').find('td').eq(3).text();
      modal.find('.ca3').val(content);
	  var content = btnThis.closest('tr').find('td').eq(4).text();
      modal.find('.ca4').val(content);
});
 $('#shanchu').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(1).text();
      modal.find('.ca1').val(content);
	 
});


                        $("#xiugai").click(function () {
						var id=$("input[name='id']").val();
						var name=$("input[name='name']").val();
						var text=$("textarea[name='text']").val(); 
						var type = $("#type").val();     
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_NewgonggaoXiugai",
							data: {id:id,name:name,text:text,type:type},
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
					$("#shanchul").click(function () {
						var ids=$("input[name='ids']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_ShuanchuAd",
							data: {ids:ids},
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
					$("#xtianjia").click(function () {
						var namet=$("input[name='namet']").val();
						var textt=$("textarea[name='textt']").val(); 
						var typet = $("#typet").val();     
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Newgonggao",
							data: {namet:namet,textt:textt,typet:typet},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert(data.msg, function(index) {
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