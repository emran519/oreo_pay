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
                                                <li class="breadcrumb-item active">添加/管理合作者</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">添加/管理合作者</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            
						
                                                <div class="text-lg-left">
                                                    <a data-toggle="modal" data-target="#tianjia" data-id="tianjia" class="btn btn-success mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i> 添加合作者</a>
												
                                            </div><!-- end col-->
                       <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap">
                                                <thead>
                                                <tr>
                                                   <th>ID</th>
				<th>用户名</th>
          		<th>密码</th>
                <th>合作者TOKEN</th>
          		<th>添加时间</th>
                <th>等级</th>
          		<th>状态</th>
				<th style="display: none">状态</th>
				<th style="display: none">状态</th>
				<th style="display: none">状态</th>
          		<th>操作</th>        
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php									
$sql=" 1";
$numrows=$DB->query("SELECT count(*) from oreo_panuser WHERE{$sql}")->fetchColumn();
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
$list=$DB->query("SELECT * FROM oreo_panuser WHERE{$sql} order by id desc limit $offset,$pagesize");				
while($res = $list->fetch())
{
	if($res['level']==1){
			$levels="普通合作者";
		}if($res['level']==2){
			$levels="高级合作者";
		}if($res['level']==3){
			$levels="白金合作者";
		}
echo '
		<tr><td><b>' . $res['id'] . '</b></td>
		<td>' . $res['user'] . '</td>
		<td>' . $res['pwd'] . '</td>
		<td style="display: none">' . $res['name'] . '</td>
		<td>' . $res['token'] . '</td>
		<td>' . $res['regtime'] . '</td>
		<td>' . $levels . '</td>
		<td style="display: none">' . $res['level'] . '</td>
		<td>' . ($res['active'] == 1 ? '<font color=green>正常</font>' : '<font color=red>封禁</font>') . '</td>
		<td style="display: none">' . $res['active'] . '</td>
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
echo '<li class="page-item"><a class="page-link" href="oreo_plist.php?page='.$first.$link.'">首页</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_plist.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_plist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=3)$s=3;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_plist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li class="page-item"><a class="page-link" href="oreo_plist.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_plist.php?page='.$last.$link.'">尾页</a></li>';
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
                                               <h5 class="modal-title" id="exampleModalLabel">编辑合作者信息</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>用户名:</label>
                                                    <div>
													  <input type="text" class="form-control ca0" name="id" style="display: none"/>
                                                      <input type="text" class="form-control ca1" name="user"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>密码</label>
                                                    <div>
													<input type="text" class="form-control ca2" name="pwd"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>姓名</label>
                                                    <div>
													<input type="text" class="form-control ca3" name="name"/>
                                                    </div>
                                                </div>
												<div class="form-group" style="display: none">
                                                    <label>token</label>
                                                    <div>
													<input type="text" class="form-control ca4" name="token"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>等级</label>
                                                    <div>
                                                    <select class="form-control ca7" name="level" id="level">
                                                    <option value="1" >普通合作者</option>
                                                    <option value="2" >高级合作者</option>  
                                                    <option value="3" >白金合作者</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>是否激活</label>
                                                    <div>
                                                    <select class="form-control ca9" name="active" id="active">
                                                    <option value="1" >是</option>
                                                    <option value="0" >否</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>是否重置密钥</label>
                                                    <div>
                                                    <select class="form-control" name="resetkey" id="resetkey">
                                                    <option value="0" >否</option>  
													<option value="1" >是</option>
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
                                                    <label>用户名:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca1"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="shanchul"  value="提交" class="btn btn-danger waves-effect" >
                                                            确认删除账户
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
                                               <h5 class="modal-title" id="exampleModalLabel">添加合作者信息</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>用户名:</label>
                                                    <div>
                                                      <input type="text" class="form-control" name="usert"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>密码</label>
                                                    <div>
													<input type="text" class="form-control" name="pwdt"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>姓名</label>
                                                    <div>
													<input type="text" class="form-control" name="namet"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>等级</label>
                                                    <div>
                                                    <select class="form-control" name="levelt" id="levelt">
                                                    <option value="1" >普通合作者</option>
                                                    <option value="2" >高级合作者</option>  
                                                    <option value="3" >白金合作者</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>是否激活</label>
                                                    <div>
                                                    <select class="form-control" name="activet" id="activet">
                                                    <option value="1" >是</option>
                                                    <option value="0" >否</option>  
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
	  var content = btnThis.closest('tr').find('td').eq(5).text();
      modal.find('.ca5').val(content);
	  var content = btnThis.closest('tr').find('td').eq(6).text();
      modal.find('.ca6').val(content);
	  var content = btnThis.closest('tr').find('td').eq(7).text();
      modal.find('.ca7').val(content);
	  var content = btnThis.closest('tr').find('td').eq(8).text();
      modal.find('.ca8').val(content);
	  var content = btnThis.closest('tr').find('td').eq(9).text();
      modal.find('.ca9').val(content);
	 
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
						var user=$("input[name='user']").val();
						var pwd=$("input[name='pwd']").val();
						var name=$("input[name='name']").val();
						var token=$("input[name='token']").val();
						var level = $("#level").val();   
						var active = $("#active").val();   
						var resetkey = $("#resetkey").val();   
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Hzzxiugai",
							data: {id:id,user:user,pwd:pwd,name:name,token:token,level:level,active:active,resetkey:resetkey},
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
							url: "oreo_sub.php?act=edit_Hzzshanchu",
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
						var usert=$("input[name='usert']").val();
						var pwdt=$("input[name='pwdt']").val();
						var namet=$("input[name='namet']").val();
						var levelt = $("#levelt").val();   
						var activet = $("#activet").val();   
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Hzzxtianjia",
							data: {usert:usert,pwdt:pwdt,namet:namet,levelt:levelt,activet:activet},
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