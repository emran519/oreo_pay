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
                                                <li class="breadcrumb-item active">添加/管理轮询接口</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">添加/管理轮询接口</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                    <div class="card-body">
									<h4 class="mt-0 header-title">添加/管理轮询接口使用说明</h4>
                                            <p class="text-muted m-b-30 font-14">&nbsp;&nbsp;&nbsp;&nbsp;注意:每一个轮寻通道只能拥有一种轮寻模式，如：支付宝可以添加N个接口但轮询模式必须统一<br>
											<code style="font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;在<a style="color:red;">轮流模式</a>中接口的轮流<a style="color:red;">仅限于</a>本轮寻配置列表，<a style="color:red;">注意:</a>请将支付通道配置页面微信选择易支付值可以随意填写</code><br>
											<code style="font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;在<a style="color:red;">按金额式</a>中接口的轮流将<a style="color:red;">优先</a>走轮寻配置列表，当轮寻金额<a style="color:red;">超出</a>设定的值后走下一个接口，当<a style="color:red;">都超出</a>接口将会走<a style="color:red;">支付通道配置页面</a>的配置</code><br>
											<code style="font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;当您<a style="color:red;">不需要易支付轮寻</a>的时候，也就是没有多接口的需求，请将<a style="color:red;">轮寻开关</a>置于<a style="color:red;">关闭</a>状态</code><br>
											</p>
                                             <div class="row mb-2">
                                            <div class="col-lg-8">
                                                <form class="form-inline" method="post" action="oreo_lxjk.php">
                                                    <div class="form-group mb-2">
                                                        <label for="inputPassword2" class="sr-only">搜索</label>
                                                        <input type="search"  name="my" class="form-control"  placeholder="搜索...">
                                                    </div>
                                                    <div class="form-group mx-sm-3 mb-2">
                                                        <select class="custom-select" name="column" >
                                                            <option selected>请选择...</option>
                                                            <option value="oreo_lxname">轮询通道</option>
                                                            <option value="oreo_lxurl">易支付地址</option>
                                                            <option value="oreo_lxid">易支付商户ID</option>
                                                        </select>
                                                    </div>                       
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="text-lg-right">
                                                    <button type="submit" name="submit" class="btn btn-success mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i> 搜索</button>
													<a data-toggle="modal" data-target="#tianjia" data-id="tianjia"  class="btn btn-warning mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i>添加接口</a>
													<?php if($conf['oreo_lx']==0){
echo'<a id="lxdk"  class="btn btn-danger mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i>轮询已关</a>&nbsp;&nbsp;';
}else{
	 echo'<a id="lxgb"  class="btn btn-success mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i>轮询已开</a>&nbsp;&nbsp;';
}?>
												</div>
                                            </div><!-- end col-->
                                        </div>
										<div class="table-responsive">
                                            <table class="table table-bordered text-nowrap">
                                                <thead>
                                                <tr>
                                                    <th style="display: none">ID</th>
				<th>轮询通道</th>
          		<th>易支付地址</th>
                <th>易支付商户ID</th>
          		<th>易支付商户KEY</th>
				<th>轮询模式</th>
				<th>轮询金额</th>
				<th>详细信息</th>
          		<th>状态</th>
          		<th>操作</th>  
				<th style="display: none">1</th>  
				<th style="display: none">2</th>   
				<th style="display: none">2</th>   
				<th style="display: none">2</th>   
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
if(isset($_POST['submit'])) {
if($_POST['my']=='支付宝'){
$_POST['my']=1;
}if($_POST['my']=='微信支付'){
$_POST['my']=2;
}if($_POST['my']=='QQ钱包'){
$_POST['my']=3;
}if($_POST['my']=='会员通道'){
$_POST['my']=4;
}	
	if($_POST['column']=='name'){
		$sql="`{$_POST['column']}` like '%{$_POST['my']}%'";
	}else{
		$sql="`{$_POST['column']}`='{$_POST['my']}'";
	}
}else{
	$sql=" 1";
	$numrows=$DB->query("SELECT count(*) from oreo_lxjk WHERE{$sql}")->fetchColumn();
	$link='&my=search&column='.$_POST['column'].'&value='.$_POST['my'];
	}										
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
$list=$DB->query("SELECT * FROM oreo_lxjk WHERE{$sql} order by id desc limit $offset,$pagesize");				
while($res = $list->fetch())
{
if($res['oreo_lxname']==1){
			$jiekou="支付宝";
		}if($res['oreo_lxname']==2){
			$jiekou="微信支付";
		}if($res['oreo_lxname']==3){
			$jiekou="QQ钱包";
		}if($res['oreo_lxname']==4){
			$jiekou="会员通道";
		}if($res['oreo_lxname']==5){
			$jiekou="全部";
		}
		if($res['oreo_lxfs']==1){
			$lxfs="按轮流式";
		}else{
			$lxfs="按金额式";
		}
		if($res['oreo_lxje']==''){
			$lxje="按轮流模式";
		}else{
			$lxje=$res['oreo_lxje'];
		}	
		if($res['oreo_lxfs']==2){
		if($res['oreo_lrje']>$res['oreo_lxje']){
			$lxlrje='<font color=red>超出,接口停止</font>';
			$lxlrjeql='&nbsp;<a data-toggle="modal" data-target="#qingkong" data-id="qingkong" class="btn btn-warning waves-effect waves-light" >流入金清空</a>';
		}else{
		    $lxlrje='<font color=green>正常, 当前：￥'.$res['oreo_lrje'].'</font>';
			$lxlrjeql='<a></a>';
		}
		}if($res['oreo_lxfs']==1){
		    $lxlrje='<font color=green>当前轮流模式</font>';
		}	
echo '
		<tr><td style="display: none"><b>' . $res['id'] . '</b></td>
		<td>' . $jiekou . '</td>
		<td style="display: none">' . $res['oreo_lxname'] . '</td>
		<td>' . $res['oreo_lxurl'] . '</td>
		<td>' . $res['oreo_lxid'] . '</td>
		<td>' . $res['oreo_lxkey'] . '</td>
		<td>' . $lxfs . '</td>
		<td>' . $lxje . '</td>
		<td style="display: none">' . $res['oreo_lxfs'] . '</td>
		<td style="display: none">' . $res['oreo_lxje'] . '</td>
		<td>' . $lxlrje . '</td>
		<td>' . ($res['oreo_lxtype'] == 1 ? '<font color=green>正常</font>' : '<font color=red>关闭</font>') . '</td>
		<td style="display: none">' . $res['oreo_lxtype'] . '</td>
		<td><a data-toggle="modal" data-target="#bianji" data-id="bianji" class="btn btn-xs btn-info">编辑</a>&nbsp;<a data-toggle="modal" data-target="#shanchu" data-id="shanchu" class="btn btn-xs btn-danger" >删除</a>&nbsp;<a class="btn btn-xs btn-info" href="cron/oreo_lx.php?key='.$conf['cron_key'].'&url='.$res['oreo_lxurl'].'&lxid='.$res['oreo_lxid'].'&lxkey='.$res['oreo_lxkey'].'" >监控</a>'.$lxlrjeql.'</td></tr>';
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
echo '<li class="page-item"><a class="page-link" href="oreo_lxjk.php?page='.$first.$link.'">首页</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_lxjk.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_lxjk.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=3)$s=3;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_lxjk.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li class="page-item"><a class="page-link" href="oreo_lxjk.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_lxjk.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">尾页</a></li>';
}
echo'</ul>';
#分页
?>
                                                </nav>
                                        </div>
                                </div> <!-- end col -->
                           </div> <!-- end row -->
                        </div><!-- container -->
						<div class="modal fade bs-example-modal-center"   id="bianji" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">编辑轮询接口信息</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>轮询通道</label>
                                                    <div>
                                                    <select class="form-control ca2" name="oreo_lxname" id="oreo_lxname">
                                                    <option value="1" >支付宝</option>
                                                    <option value="2" >微信支付</option>  
                                                    <option value="3" >QQ钱包</option>  
													<option value="4" >会员通道</option>  
													<option value="5" >全部</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>易支付地址</label>
                                                    <div>
													<input type="text" class="form-control ca0" name="uid" style="display: none"/>
													<input type="text" class="form-control ca3" name="oreo_lxurl"/>
                                                    </div>
                                                </div>
												<div class="form-group" >
                                                    <label>易支付商户ID</label>
                                                    <div>
													<input type="text" class="form-control ca4" name="oreo_lxid"/>
                                                    </div>
                                                </div>
												<div class="form-group" >
                                                    <label>易支付商户KEY</label>
                                                    <div>
													<input type="text" class="form-control ca5" name="oreo_lxkey"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>轮询模式</label>
                                                    <div>
													 <select  class="form-control ca8" name="oreo_lxfs"  id="oreo_lxfs" >
                                                    <option value="1" >按轮流式</option>
                                                    <option value="2" >按金额式</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>轮询金额满：</label>
                                                    <div>
                                                        <input type="text" class="form-control ca9" placeholder="轮询金额满多少开始轮询" name="oreo_lxje" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>状态</label>
                                                    <div>
                                                    <select class="form-control ca12" name="oreo_lxtype" id="oreo_lxtype">
                                                    <option value="0" >关闭</option>
                                                    <option value="1" >开启</option>  
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
                                                    <label>轮询通道:</label>
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
                                               <h5 class="modal-title" id="exampleModalLabel">添加轮询接口信息</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>轮询通道</label>
                                                    <div>
                                                    <select class="form-control ca" name="oreo_lxnamet" id="oreo_lxnamet">
                                                    <option value="1" >支付宝</option>
                                                    <option value="2" >微信支付</option>  
                                                    <option value="3" >QQ钱包</option>  
													<option value="4" >会员通道</option>  
													<option value="5" >全部</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>易支付地址</label>
                                                    <div>
													<input type="text" class="form-control" name="oreo_lxurlt"/>
                                                    </div>
                                                </div>
												<div class="form-group" >
                                                    <label>易支付商户ID</label>
                                                    <div>
													<input type="text" class="form-control" name="oreo_lxidt"/>
                                                    </div>
                                                </div>
												<div class="form-group" >
                                                    <label>易支付商户KEY</label>
                                                    <div>
													<input type="text" class="form-control" name="oreo_lxkeyt"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>轮询模式</label>
                                                    <div>
													 <select  class="form-control" name="oreo_lxfst"  id="oreo_lxfst" onchange="lx_fs('lxfs',this.value)" >
                                                    <option value="1" >按轮流式</option>
                                                    <option value="2" >按金额式</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div  id="lxfs_je"  style="<?php echo $conf['oreo_lxfst'] == 2 ? "" : "display: none;";?>">
												<div class="form-group">
                                                    <label>轮询金额满：</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="轮询金额满多少开始轮询" name="oreo_lxjet" />
                                                    </div>
                                                </div>
												</div>
												<div class="form-group">
                                                    <label>状态</label>
                                                    <div>
                                                    <select class="form-control" name="oreo_lxtypet" id="oreo_lxtypet">
                                                    <option value="0" >关闭</option>
                                                    <option value="1" >开启</option>  
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
                                     <div class="modal fade bs-example-modal-center"   id="qingkong" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                                                      <input type="text" class="form-control ca0" name="idss" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>轮询通道:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca1"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>易支付地址:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca3"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="qingkongsj"  value="提交" class="btn btn-danger waves-effect" >
                                                            确认清空
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
	function lx_fs(type,val){
	var zje  = $("#"+type+"_je");
    if(val == 1){
       $(zje).hide()
    }
    if(val == 2){
       $(zje).show()
    }        
}		
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
	  var content = btnThis.closest('tr').find('td').eq(11).text();
      modal.find('.ca11').val(content);
	  var content = btnThis.closest('tr').find('td').eq(8).text();
      modal.find('.ca8').val(content);
	  var content = btnThis.closest('tr').find('td').eq(9).text();
      modal.find('.ca9').val(content);
	  var content = btnThis.closest('tr').find('td').eq(12).text();
      modal.find('.ca12').val(content);
	  
	 
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
 $('#qingkong').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(1).text();
      modal.find('.ca1').val(content);
	  var content = btnThis.closest('tr').find('td').eq(3).text();
      modal.find('.ca3').val(content);
	 
});
                        $("#xiugai").click(function () {
						var oreo_lxname = $("#oreo_lxname").val();   
						var uid=$("input[name='uid']").val();
						var oreo_lxurl=$("input[name='oreo_lxurl']").val();
						var oreo_lxid=$("input[name='oreo_lxid']").val();
						var oreo_lxkey=$("input[name='oreo_lxkey']").val();
						var oreo_lxfs = $("#oreo_lxfs").val();   
						var oreo_lxje=$("input[name='oreo_lxje']").val();
						var oreo_lxtype = $("#oreo_lxtype").val(); 
						
						if (oreo_lxurl == '' || oreo_lxid == '' || oreo_lxkey == '') {
							layer.alert('请确保各项不能为空！');
							return false;
						}	
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Lxjkxiugai",
							data: {oreo_lxname:oreo_lxname,uid:uid,oreo_lxurl:oreo_lxurl,oreo_lxid:oreo_lxid,oreo_lxkey:oreo_lxkey,oreo_lxfs:oreo_lxfs,oreo_lxje:oreo_lxje,oreo_lxtype:oreo_lxtype},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('添加成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} if (data.code == -1) {
									layer.alert(data.msg);
								}if (data.code == -3) {
									layer.alert('金额必须是整数');
								}
							}
						});
					});
					$("#shanchul").click(function () {
						var ids=$("input[name='ids']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_shanchuLxjk",
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
					$("#qingkongsj").click(function () {
						var ids=$("input[name='idss']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_qingkongshuju",
							data: {ids:ids},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('清空成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					}); 
					$("#lxjesz").click(function () {
						var order_lxzje=$("input[name='order_lxzje']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=add_oreo_conf",
							data: {order_lxzje:order_lxzje},
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
					$("#xtianjia").click(function () {
						var oreo_lxname = $("#oreo_lxnamet").val();   
						var oreo_lxurl=$("input[name='oreo_lxurlt']").val();
						var oreo_lxid=$("input[name='oreo_lxidt']").val();
						var oreo_lxkey=$("input[name='oreo_lxkeyt']").val();
						var oreo_lxtype = $("#oreo_lxtypet").val();	
						var oreo_lxfs = $("#oreo_lxfst").val();   
						var oreo_lxje=$("input[name='oreo_lxjet']").val();
                        if (oreo_lxurl == '' || oreo_lxid == '' || oreo_lxkey == '') {
							layer.alert('请确保各项不能为空！');
							return false;
						}							
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Lxjktianjia",
							data: {oreo_lxname:oreo_lxname,oreo_lxurl:oreo_lxurl,oreo_lxid:oreo_lxid,oreo_lxkey:oreo_lxkey,oreo_lxtype:oreo_lxtype,oreo_lxfs:oreo_lxfs,oreo_lxje:oreo_lxje},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('添加成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} if (data.code == -1) {
									layer.alert(data.msg);
								}if (data.code == -3) {
									layer.alert('金额必须是整数');
								}
							} 
						});
					});
					$("#lxdk").click(function () {
						var oreo_lx="1";
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=add_oreo_conf",
							data: {oreo_lx:oreo_lx},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开通轮询成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});	
                   $("#lxgb").click(function () {
						var oreo_lx="0";
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=add_oreo_conf",
							data: {oreo_lx:oreo_lx},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('关闭轮询成功', function(index) {
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