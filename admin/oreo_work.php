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
                                                <li class="breadcrumb-item active">工单系统</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">工单系统</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                                <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">工单系统说明</h4>
                                            <p class="text-muted m-b-30 font-14">这里可以设置您工单系统的一些参数，包括问题类型以及开关。</p>
												<div class="form-group">
                                                    <label>是否开启工单系统</label>
                                                    <div>
                                                    <select  class="form-control" name="owrk_zt"   id="owrk_zt"  onchange="oreo_work('wk',this.value)" >
                                                     <option value="1" <?=$conf['owrk_zt']==1?"selected":""?> >开启</option>
                                                     <option value="0" <?=$conf['owrk_zt']==0?"selected":""?> >关闭</option>
                                                    </select>
                                                    </div>
                                                </div>	
                                                <div  id="wk_ok"  style="<?php echo $conf['owrk_zt'] == 1 ? "" : "display: none;";?>">
												<div class="form-group" id="oreo_work_name" >
                                                    <label>工单类型设置</label>
                                                    <div>
                                                       <textarea name="oreo_work_name" rows="4" class="form-control"><?php echo $conf['oreo_work_name']; ?></textarea>
                                                       
                                                    </div>
                                                </div>
												</div>	
                                                <div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button"  id="work" value="保存修改" class="btn btn-primary waves-effect waves-light" >
                                                            保存
                                                        </button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                         </div> <!-- content -->
			                    <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">工单一览</h4>
                                            <p class="text-muted m-b-30 font-14">这里所产生的数据是<code>平台所有的工单数据</code>请收到工单后及时处理。
                                            </p>

                                            <div class="table-responsive" style="margin-top: 2em;">
                                            <table class="table table-bordered text-nowrap">
                                                <thead>
                                                <tr>
                                                 <th>商户ID</th>
		                                            <th>工单编号</th>
													<th style="display: none;">商户QQ号码</th>
		                                            <th>问题类型</th>
		                                            <th>工单标题</th>   
		                                            <th style="display: none;">工单内容</th>		  
		                                            <th>提交时间</th>
													<th style="display: none;">官方回复</th>
		                                           <th style="display: none;">完结时间</th>		  
		                                           <th>操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php									
$sql=" 1";
$numrows=$DB->query("SELECT count(*) from oreo_work WHERE{$sql}")->fetchColumn();
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
$list=$DB->query("SELECT * FROM oreo_work WHERE{$sql} order by id desc limit $offset,$pagesize");				
while($res = $list->fetch())
{
 echo '
	<tr>
	<td>' . $res['uid'] . '</td>	
	<td>' . $res['num'] . '</td>
	<td style="display: none;">' . $res['qq'] . '</td>
	<td>' . $res['types'] . '</td>
	<td>' . $res['biaoti'] . '</td>
	<td style="display: none;">' . $res['text'] . '</td>	
	<td>' . $res['edata'] . '</td>
	<td style="display: none;">' . $res['huifu'] . '</td>
	<td style="display: none;">' . $res['wdata'] . '</td>	
    <td>' . ($res['active'] == 1 ? '<a class="btn btn-xs btn-success"  data-toggle="modal" data-target="#chakan" data-id="chakan" >点击查看</a>' : '<a class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#editVoince" data-id="edit" >点击回复</a>') . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a data-toggle="modal" data-target="#shanchu" data-id="shanchu" class="btn btn-xs btn-danger" >删除</a></td></tr>';
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
echo '<li class="page-item"><a class="page-link" href="oreo_work.php?page='.$first.$link.'">首页</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_work.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_work.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=3)$s=3;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_work.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li class="page-item"><a class="page-link" href="oreo_work.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_work.php?page='.$last.$link.'">尾页</a></li>';
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
		                    <div class="modal fade bs-example-modal-center"   id="editVoince" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">工单回复</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>工单编号:</label>
                                                    <div>
                                                      <input type="text" class="form-control gd0" name="num" readonly="readonly" />
                                                    </div>
                                                </div>
												
												<div class="form-group">
                                                    <label>工单类型:</label>
                                                    <div>
													<input type="text" class="form-control gd1"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>工单标题:</label>
                                                    <div>
													<input type="text" class="form-control gd2"  readonly="readonly" />
													<input type="text" class="form-control gdq" name="qq" readonly="readonly" style="display: none;" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>工单内容:</label>
                                                    <div>
													 <textarea  type="text" rows="5" class="form-control gd3" readonly="readonly"></textarea>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>官方回复:</label>
                                                    <div>
													 <textarea type="text" placeholder="请输入您的回复内容" name="huifu" rows="5" class="form-control" ></textarea>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>是否完结</label>
                                                    <div>
                                                    <select class="form-control" name="active" id="active">
													<option selected="selected" >--请选择-- </option>
                                                    <option value="0" >未完结</option>
                                                    <option value="1" >已完结</option>  
                                                    </select>
                                                    </div>
                                                </div>
												 <div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="ohuifu"  value="提交" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                    </div>
                                                </div>
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->	

                                   <div class="modal fade bs-example-modal-center"   id="chakan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">查看详情</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>工单编号:</label>
                                                    <div>
													 <input type="text" class="form-control ca1"  readonly="readonly" />
                                                    </div>
                                                </div> 
												<div class="form-group">
                                                    <label>商户QQ号:</label>
                                                    <div>
													 <input type="text" class="form-control ca2"  readonly="readonly" />
                                                    </div>
                                                </div> 
												<div class="form-group">
                                                    <label>问题类型:</label>
                                                    <div>
													 <input type="text" class="form-control ca3"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>工单标题:</label>
                                                    <div>
													 <input type="text" class="form-control ca4"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>工单内容:</label>
                                                    <div>
													 <textarea  type="text"  rows="5" class="form-control ca5" readonly="readonly"></textarea>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>提交时间:</label>
                                                    <div>
													 <input type="text" class="form-control ca6"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>官方回复:</label>
                                                    <div>
													<textarea  type="text"  rows="5" class="form-control ca7" readonly="readonly"></textarea>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>完结时间:</label>
                                                    <div>
													 <input type="text" class="form-control ca8"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="modal-footer">
											   <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">关闭</button>
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
                                                    <label>问题类型:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca3"  readonly="readonly" name="typnames" />
													  <input type="text" class="form-control ca1" name="asknum"   readonly="readonly" style="display: none" />
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
                  </div>	
                <?php include'foot.php';?>
		<script>
	function oreo_work(type,val){
    var gb  = $("#"+type+"_ok");
    if(val == 0){
       $(gb).hide();  
    }
    if(val == 1){
       $(gb).show();
    }        
}		
	  $('#editVoince').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(1).text();
      modal.find('.gd0').val(content); 
	  var content = btnThis.closest('tr').find('td').eq(2).text();
      modal.find('.gdq').val(content); 
      var content = btnThis.closest('tr').find('td').eq(3).text();
      modal.find('.gd1').val(content);
 	  var content = btnThis.closest('tr').find('td').eq(4).text();
      modal.find('.gd2').val(content);
	  var content = btnThis.closest('tr').find('td').eq(5).text();
      modal.find('.gd3').val(content);
});
	  $('#chakan').on('show.bs.modal', function (event) {
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
	 
});
 $('#shanchu').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(3).text();
      modal.find('.ca3').val(content);
	  var content = btnThis.closest('tr').find('td').eq(1).text();
      modal.find('.ca1').val(content);
	 
});

		 $("#work").click(function () {
			            var owrk_zt = $("#owrk_zt").val();	
						var oreo_work_name=$("textarea[name='oreo_work_name']").val(); 
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=add_oreo_conf",
							data: {owrk_zt:owrk_zt,oreo_work_name:oreo_work_name},
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
					 $("#ohuifu").click(function () {
						var num=$("input[name='num']").val();
                        var qq=$("input[name='qq']").val();							
			            var huifu=$("textarea[name='huifu']").val(); 
						var active = $("#active").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Huifu",
							data: {num:num,qq:qq,huifu:huifu,active:active},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('回复成功', function(index) {
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
						var asknum=$("input[name='asknum']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_ShanchuAsk",
							data: {ids:ids,asknum:asknum},
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
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}  
</script>
    </body>
</html>