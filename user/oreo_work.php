<?php
include("../oreo/Oreo.Cron.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
include("./oreo_static.php");

$numrows=$DB->query("SELECT * from oreo_work WHERE uid={$pid}")->rowCount();
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

$list=$DB->query("SELECT * FROM oreo_work WHERE uid={$pid}  limit $offset,$pagesize")->fetchAll();

?>
                <div class="content-page">
                    <div class="content">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">控制台</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">基本</a></li>
                                            <li class="breadcrumb-item active">工单查看/提交</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">工单查看/提交</h4>
                                </div> <!-- end page-title-box -->
                            </div> <!-- end col-->
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="header-title">工单系统说明</h4>
                                        <p class="text-muted font-14 mb-4">
                                            使用过程中遇到什么问题您都可以到这里给管理员反馈的哟！.
                                        </p>
									<?php	if($conf['owrk_zt']==0){ }else{?>
                                                <div class="col-lg-4">
                                                <div class="text-lg-left">
                                                    <button type="submit" data-toggle="modal" data-target="#tijiao" data-id="tijiao" class="btn btn-success mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i> 提交工单</button>
                                                </div>
                                            </div><?php }?>
                                        <div class="table-responsive-sm">
                                            <table class="table table-striped table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>工单编号</th>
                                                        <th>工单类型</th>
                                                        <th>工单标题</th>
														<th style="display: none;">工单内容</th>
                                                        <th>提交时间</th>
														<th style="display: none;">官方回复</th>
														<th>完结时间</th>
														<th>状态/详情</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     <?php
                                 foreach($list as $res){
	                                   echo '<tr>
                                       <td>'.$res['num'].'</td>
                                       <td>'.$res['types'].'</td>
                                       <td>'.$res['biaoti'].'</td>
									   <td style="display: none;">'.$res['text'].'</td>
									   <td>'.$res['edata'].'</td>
									   <td style="display: none;">'.$res['huifu'].'</td>
									   <td>'.$res['wdata'].'</td>
									   <td>' . ($res['active'] == 1 ? '<a class="btn btn-success"  data-toggle="modal" data-target="#chakan" data-id="chakan" >已完结/查看详情</a>' : '<a class="btn btn-warning" data-toggle="modal" data-target="#chakan" data-id="edit" >未完结/查看详情</a>') . '</td></tr>';
                                      }
                                    ?>
                                                </tbody>
                                            </table>
																						<nav style="float: inline-end;">
<?php
echo'<ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li class="page-item"><a class="page-link" href="oreo_work.php?page='.$first.$link.'">首页</a></li>';

} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';

}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_work.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=10)$s=10;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_work.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{

echo '<li class="page-item"><a class="page-link" href="oreo_work.php?page='.$last.$link.'">尾页</a></li>';
} else {

echo '<li class="page-item"><a class="page-link">尾页</a></li>';
}
echo'</ul>';
#分页
?>
                                                </nav>
                                        </div> <!-- end table-responsive-->
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->
                    <div id="chakan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">查看详情</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                        <label>工单编号:</label>
                                                        <input type="text" class="form-control ca1" readonly="readonly">
                                                    </div>
													<div class="form-group">
                                                        <label>工单类型:</label>
                                                        <input type="text" class="form-control ca2" readonly="readonly">
                                                    </div>
													<div class="form-group">
                                                        <label>工单标题:</label>
                                                        <input type="text" class="form-control ca3" readonly="readonly">
                                                    </div>
													<div class="form-group">
                                                        <label>工单内容:</label>
                                                        <textarea  type="text"  rows="4" class="form-control ca4" readonly="readonly"></textarea>
                                                    </div>
													<div class="form-group">
                                                        <label>官方回复:</label>
                                                        <textarea  type="text"  rows="4" class="form-control ca5" readonly="readonly"></textarea>
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-dismiss="modal">关闭</button>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
										<div id="tijiao" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">提交工单</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                        <label for="example-select">问题类型</label>
                                                        <select class="form-control" id="types" name="types">
                                                            <?php echo $conf['oreo_work_name'];?>
                                                        </select>
                                                    </div>
													<div class="form-group">
                                                        <label>工单标题:</label>
														<input type="text" name="uid"  style="display: none;" value="<?php echo $userrow['id']?>"> 
                                                        <input type="biaoti" name="biaoti" class="form-control" >
                                                    </div>
													<div class="form-group">
                                                        <label>工单内容:</label>
                                                        <textarea  type="text"  name="text" rows="4" class="form-control" ></textarea>
                                                    </div>
													<div class="form-group">
                                                        <label>联系QQ:</label>
                                                        <input type="text" class="form-control" name="qq"  value="<?php echo $userrow['qq'];?>">
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
													    <button type="button" class="btn btn-primary" id="swork">提交</button>
                                                        <button type="button" class="btn btn-light" data-dismiss="modal">关闭</button>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                    </div> <!-- content -->
                    <!-- Footer Start -->
                    <footer class="footer">
                        <div class="row">
                            <div class="col-md-6">
                              <?php echo $conf['copyright']; ?>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-md-block">
                                    <a href="javascript: void(0);"><?php echo $conf['beian']; ?></a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- end Footer -->
                </div> <!-- content-page -->
            </div> <!-- end wrapper-->
        </div>
        <script src="../assets/newuser/js/app.min.js"></script>
        <script src="../assets/newuser/js/layer.js"></script>	
<script>
		$('#chakan').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca1').val(content);
	  var content = btnThis.closest('tr').find('td').eq(1).text();
      modal.find('.ca2').val(content);
	  var content = btnThis.closest('tr').find('td').eq(2).text();
      modal.find('.ca3').val(content);
	  var content = btnThis.closest('tr').find('td').eq(3).text();
      modal.find('.ca4').val(content);
	  var content = btnThis.closest('tr').find('td').eq(5).text();
      modal.find('.ca5').val(content);	 
});
 $("#swork").click(function () {
			            var types = $("#types").val();
						var uid = $("input[name='uid']").val();						
                        var biaoti = $("input[name='biaoti']").val();			
						var text=$("textarea[name='text']").val(); 
						var qq = $("input[name='qq']").val();
						if (biaoti == '' || text == '' || qq == '') {
							layer.alert('请确保各项不能为空！');
							return false;
						}
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=s_Work",
							data: {types:types,uid:uid,biaoti:biaoti,text:text,qq:qq},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('提交成功！', function(index) {
                                    layer.close(index);
                                    location.href="oreo_work.php"; 
                                    })
								} else if (data.code == 2) {
									$("#situation").val("settle");
									$('#myModal').modal('show');
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});   		              
</script>
    </body>

</html>