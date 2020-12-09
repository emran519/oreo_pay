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
                                                <li class="breadcrumb-item active">手动结算记录</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">手动结算记录</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">手动结算记录说明</h4>
											<code style="font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;当管理员状态设置为<a style="color:red;">已完成</a>时，系统将用户余额中自动减去有关结算费用并且标记已完成。</code><br>
											<code style="font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;当管理员状态设置为<a style="color:red;">驳回</a>时，系统不会减去用户余额并从列表中删除记录，用户可重新申请手动结算。</code><br>
                                          <div class="table-responsive" style="margin-top: 2em;">
                                            <table class="table table-bordered text-nowrap">
                                                <thead>
                                                <tr>
                                                    <th style="display: none">ID</th>								
              <th>商户ID</th>
              <th>结算方式</th>
              <th>姓名</th>
              <th>结算账号</th>
              <th>结算金额</th>
              <th>可提现</th>
			  <th>申请时间</th>
			  <th>操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php									
function display_type($type){
	if($type==1)
		return '支付宝';
	elseif($type==2)
		return '微信';
	elseif($type==3)
		return 'QQ钱包';
	elseif($type==4)
		return '银行卡';
	else
		return 1;
}
$sql=" 1";
$numrows=$DB->query("SELECT count(*) from oreo_apply WHERE{$sql}")->fetchColumn();
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
$list=$DB->query("SELECT * FROM oreo_apply WHERE{$sql} order by id desc limit $offset,$pagesize");				
while($res = $list->fetch())
{
	if($res['type']==1){
	$sz='<a style="color: red;">已完成</a>';
	}else{
	$sz='<a data-toggle="modal" data-target="#bianji" data-id="bianji" class="btn btn-xs btn-info">操作</a>';
	}
echo '
<tr>
<td>'.$res['uid'].'</td>
<td>'.display_type($res['jsfs']).'</td>
<td>'.$res['username'].'</td>
<td>'.$res['account'].'</td>
<td>'.$res['money'].'</td>
<td>'.$res['fee'].'</td>
<td>'.$res['sdtime'].'</td>
<td style="display: none;">'.$res['id'].'</td>
<td>'.$sz.' </td></tr>';
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
echo '<li class="page-item"><a class="page-link" href="oreo_sdjs.php?page='.$first.$link.'">首页</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_sdjs.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_sdjs.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=3)$s=3;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_sdjs.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li class="page-item"><a class="page-link" href="oreo_sdjs.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_sdjs.php?page='.$last.$link.'">尾页</a></li>';
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
							<div class="modal fade bs-example-modal-center"   id="bianji" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                                                      <input type="text" class="form-control ca0" name="uid" readonly="readonly" />
													  <input type="text" class="form-control ca7" name="ids" readonly="readonly" style="display: none"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>结算方式:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca1"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>结算账号:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca3"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>结算姓名:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca2"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>结算金额:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca5"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="yjs"  value="已结算" class="btn btn-xs btn-info" >
                                                            已结算
                                                        </button>
														<button type="button" id="bhsq"  value="驳回" class="btn btn-xs btn-danger" style="float: inline-end;" >
                                                            驳回
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
	  var content = btnThis.closest('tr').find('td').eq(5).text();
      modal.find('.ca5').val(content);
	  var content = btnThis.closest('tr').find('td').eq(7).text();
      modal.find('.ca7').val(content);
	 
});
                        $("#yjs").click(function () {
						var uid=$("input[name='uid']").val();
						var ids=$("input[name='ids']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=sdjs_Yjs",
							data: {uid:uid,ids:ids},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('状态为已结算', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					}); 
					 $("#bhsq").click(function () {
						var uid=$("input[name='uid']").val();
						var ids=$("input[name='ids']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=sdjs_Bhui",
							data: {uid:uid,ids:ids},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('已驳回结算申请', function(index) {
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