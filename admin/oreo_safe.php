<?php
include "../oreo/Oreo.Cron.php";
include './oreo_static.php';
if ($islogin == 1) {
} else {
    exit("<script language='javascript'>window.location.href='./login.php';</script>");
}
$oreo=isset($_GET['oreo'])?$_GET['oreo']:null;
?>
 <?php
 if($oreo == "intercept"){
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
                                                <li class="breadcrumb-item active">违规商品拦截</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">违规商品拦截</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">违规商品拦截配置说明</h4>
                                            <p class="text-muted m-b-30 font-14">在这里您可以设置平台的违规商品拦截有关参数！</p>
                                                  <div class="form-group">
                                                    <label>商品拦截关键词</label>
                                                    <div>
                                                       <textarea  placeholder="刷单|小视频|色情|钓鱼" name="goods_lj" rows="4" class="form-control"><?php echo $conf['goods_lj']; ?></textarea>
                                                       <small>* 拦截多个商品请用|分隔 如：刷单|小视频|色情|钓鱼</small>
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>拦截提示</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="提示内容..." name="goods_ljtis" value="<?php echo $conf['goods_ljtis']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <div> 
                                                        <button type="button" id="editSafe"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                            重置
                                                        </button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                </div> <!-- content -->

                <footer class="footer">
                <?php echo $conf['copyright']; ?>.
                  <div><?php echo $conf['beian']; ?>.</div>
                </footer>
            </div>
            <!-- End Right content here -->
        </div>
        <!-- END wrapper -->
 <?php
}elseif($oreo == "log"){
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
                                                <li class="breadcrumb-item active">登录记录</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">登录记录</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                          <div class="row">
                                 <div class="col-lg-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                             <div class="row mb-2">
                                            <div class="col-lg-8">
                                                <form class="form-inline" method="post" action="oreo_safe.php?oreo=log">
                                                    <div class="form-group mb-2">
                                                        <label for="inputPassword2" class="sr-only">搜索</label>
                                                        <input type="search"  name="my" class="form-control"  placeholder="搜索...">
                                                    </div>
                                                    <div class="form-group mx-sm-3 mb-2">
                                                        <select class="custom-select" name="column" >
                                                            <option selected>请选择...</option>
                                                            <option value="city">区域</option>
                                                            <option value="data">IP地址</option>
                                                            <option value="uid">商户号</option>
                                                        </select>
                                                    </div>                       
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="text-lg-right">
                                                    <button type="submit" name="submit" class="btn btn-success mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i> 搜索</button>
                                                    <button type="button" id="shanchu" class="btn btn-warning mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i>清空数据</button>
												</div>
                                            </div><!-- end col-->
                                        </div>
										<div class="table-responsive">
                                            <table class="table table-bordered text-nowrap">
                                                <thead>
                                                <tr>
                                                   <th>ID</th>
		                                            <th>登录ID</th>
		                                            <th>操作</th>
		                                            <th>登录时间</th>
		                                            <th>区域</th>
		                                            <th>IP</th>		  
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
if(isset($_POST['submit'])) {

	if($_POST['column']=='name'){
		$sql="`{$_POST['column']}` like '%{$_POST['my']}%'";
	}else{
		$sql="`{$_POST['column']}`='{$_POST['my']}'";
	}
}else{
	$sql=" 1";
	$numrows=$DB->query("SELECT count(*) from oreo_log WHERE{$sql}")->fetchColumn();
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
$list=$DB->query("SELECT * FROM oreo_log WHERE{$sql} order by id desc limit $offset,$pagesize");				
while($res = $list->fetch())
{
echo '<tr><td class="text-center"><b>'.$res['id'].'</b></td><td class="text-center">'.$res['uid'].'</td><td class="text-center">'.$res['type'].'</td><td class="text-center">'.$res['date'].'</td><td class="text-center">'.$res['city'].'</td><td class="text-center">'.$res['data'].'</td></td></tr>';
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
echo '<li class="page-item"><a class="page-link" href="oreo_safe.php?oreo=log&page='.$first.$link.'">首页</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_safe.php?oreo=log&page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_safe.php?oreo=log&page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=3)$s=3;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_safe.php?oreo=log&page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li class="page-item"><a class="page-link" href="oreo_safe.php?oreo=log&page='.$next.$link.'">&raquo;</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_safe.php?oreo=log&page='.$last.$link.'">尾页</a></li>';
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
                        </div><!-- container -->
                            </div> <!-- end row -->
                        </div><!-- container -->
<?php
}elseif($oreo == "hmd"){
    ?> 					
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="#">控制台</a></li>
                                                <li class="breadcrumb-item"><a href="#">安全配置</a></li>
                                                <li class="breadcrumb-item active">失信人员名单</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">失信人员名单</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                              <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <div class="col-lg-4">
                                                <div class="text-lg-left">
                                                    <button data-toggle="modal" data-target="#shixin" data-id="shixin" class="btn btn-success mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i>提交失信人员</button>
                                                </div>
                                            </div>
                                            <table class="table" id="my-table">
                                                <thead>
                                                  <tr>
                                                    <th>失信人员姓名</th>
                                                    <th>失信人员QQ号</th>
                                                    <th>失信人员电话</th>
                                                    <th>失信人员结算账户</th>
                                                    <th>失信人员URL</th>
                                                    <th>失信理由</th>
													<th>入库时间</th>
													<th>状态</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php echo html_entity_decode($oreoCre, ENT_QUOTES);?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->                   										
                    </div> <!-- Page content Wrapper -->
                </div> <!-- content -->
     <div class="modal fade bs-example-modal-center"   id="shixin" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">提交失信人员</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <form id="oreo_form" action="" method="post">
                 <div class="modal-body">
                     <div class="form-group">
                         <label>失信人姓名:</label>
                         <div>
                             <input type="text" class="form-control" name="xname"/>
                         </div>
                     </div>
                     <div class="form-group">
                         <label>失信人QQ号</label>
                         <div>
                             <input type="text" class="form-control" name="xqq"/>
                         </div>
                     </div>
                     <div class="form-group">
                         <label>失信人邮箱</label>
                         <div>
                             <input type="text" class="form-control" name="xemail"/>
                         </div>
                     </div>
                     <div class="form-group">
                         <label>失信人电话</label>
                         <div>
                             <input type="text" class="form-control" name="xphone"/>
                         </div>
                     </div>
                     <div class="form-group">
                         <label>失信人结算账户</label>
                         <div>
                             <input type="text" class="form-control" name="xaid"/>
                         </div>
                     </div>
                     <div class="form-group">
                         <label>失信人域名</label>
                         <div>
                             <input type="text" class="form-control" name="xdomain"/>
                         </div>
                     </div>
                     <div class="form-group">
                         <label>举报类型</label>
                         <div>
                             <select  class="form-control" name="jblx" id="jblx">
                                 <option value="1">跑路</option>
                                 <option value="2">恶意操作</option>
                                 <option value="3">虚假交易</option>
                                 <option value="4">其他</option>
                             </select>
                         </div>
                     </div>
                     <div class="form-group" >
                         <label>提交理由</label>
                         <div>
                             <textarea placeholder="提交理由不能为空" name="xtext" rows="5" class="form-control"></textarea>

                         </div>
                     </div>
                     <div class="form-group m-b-0">
                         <div>
                             <button type="button" id="xadd"  value="提交" class="btn btn-primary waves-effect waves-light" >
                                 提交
                             </button>
                         </div>
                     </div>
                 </div>
                 </form>
             </div><!-- /.modal-content -->
         </div><!-- /.modal-dialog -->
     </div><!-- /.modal -->
     <footer class="footer">
                  <?php echo $conf['copyright']; ?>.
                  <div><?php echo $conf['beian']; ?>.</div>
                </footer>
            </div>
            <!-- End Right content here -->
        </div>
        <!-- END wrapper -->
<?php
}
 ?>
<?php include'foot.php';?>
 <script>
$("#shanchu").click(function () {
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=shanchu_Safelog",
							data: {},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('删除数据成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});	
                        $("#editSafe").click(function () {
						var goods_lj=$("textarea[name='goods_lj']").val();
						var goods_ljtis=$("input[name='goods_ljtis']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=add_oreo_conf",
							data: {goods_lj:goods_lj,goods_ljtis:goods_ljtis},
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
$("#xadd").click(function () {
    var ii = layer.load(2, {shade: [0.1, '#fff']});
    $.ajax({
        type: "POST",
        url: "oreo_sub.php?act=add_oreo_credit",
        data: $('#oreo_form').serialize(),
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
</script>        
    </body>
</html>
