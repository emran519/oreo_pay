<?php
include "../oreo/Oreo.Cron.php";
include './oreo_static.php';
if ($islogin == 1) {
} else {
    exit("<script language='javascript'>window.location.href='./login.php';</script>");
}
$shop=isset($_GET['oreo_order'])?$_GET['oreo_order']:null;
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
                                                <li class="breadcrumb-item active">订单明细</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">订单明细</h4>
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
                                                <form class="form-inline" method="GET" action="oreo_order.php">
                                                    <div class="form-group mb-2">
                                                        <label for="inputPassword2" class="sr-only">搜索</label>
                                                        <input type="search"  name="oreo_order" class="form-control"  placeholder="搜索...">
                                                    </div>
                                                    <div class="form-group mx-sm-3 mb-2">
                                                        <select class="custom-select" name="column" >
                                                            <option selected>请选择...</option>
                                                            <option value="trade_no">交易号</option>
                                                            <option value="out_trade_no">商户订单号</option>
                                                            <option value="pid">商户号</option>
                                                            <option value="name">商品名称</option>
                                                            <option value="money">金额</option>
															 <option value="endtime">日期</option>
                                                        </select>
                                                    </div>                       
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="text-lg-right">
                                                    <button type="submit"  class="btn btn-success mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i> 搜索</button>
                                                    <button type="buttons" id="shanchu" class="btn btn-warning mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i> 保留最近5天订单</button>
												</div>
                                            </div><!-- end col-->
                                        </div>
										<div class="table-responsive">
                                            <table class="table table-bordered text-nowrap">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
		                                            <th>订单号</th>
		                                            <th>商户订单号</th>
		                                            <th>网站</th>
		                                            <th>名称</th>
		                                            <th>金额</th>		  
		                                            <th>方式</th>
		                                            <th>创建时间</th>
		                                           <th>结束时间</th>		  
		                                           <th>状态</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php							
    if($shop) {
        if($_GET['column']=='name'){
            $sql=" `{$_GET['column']}` like '%{$_GET['name']}%'";
        }else{
            $sql=" `{$_GET['column']}`='{$_GET['oreo_order']}'";
        }
        $numrows=$DB->query("SELECT count(*) from oreo_order WHERE{$sql}")->fetchColumn();
        $link='&oreo_order='.$_GET['oreo_order'].'&column='.$_GET['column'];
    }else{
        $numrows=$DB->query("SELECT count(*) from oreo_order WHERE 1")->fetchColumn();
        $sql=" 1";
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
$list=$DB->query("SELECT * FROM oreo_order WHERE{$sql} order by trade_no desc limit $offset,$pagesize");				
while($res = $list->fetch())
{
echo '
	<tr>
	<td>' . $res['pid'] . '</td>	
	<td><a class="btn btn-xs btn-info" href="' . $url['notify'] . '" title="支付通知" target="_blank" rel="noreferrer">' . $res['trade_no'] . '</a></td>
	<td>' . $res['out_trade_no'] . '</td>
	<td>' . getdomain($res['notify_url']) . '</td>
	<td>' . $res['name'] . '</td>
	<td>' . $res['money'] . '</td>	
	<td>' . $res['type'] . '</td>
	<td>' . $res['addtime'] . '</td>
	<td>' . $res['endtime'] . '</td>	
	<td>' . ($res['status'] == 1 ? '<a class="btn btn-xs btn-success">已完成</a>' : '<a class="btn btn-xs btn-danger">未完成</a>') . '</td></tr>';
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
echo '<li class="page-item"><a class="page-link" href="oreo_order.php?page='.$first.$link.'">首页</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_order.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_order.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=3)$s=3;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_order.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li class="page-item"><a class="page-link" href="oreo_order.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_order.php?page='.$last.$link.'">尾页</a></li>';
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
                    </div> <!-- Page content Wrapper -->
                </div> <!-- content -->
<?php include'foot.php';?>     
<script>
$("#shanchu").click(function () {
						
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=shanchu_Order",
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

</script>					
    </body>
</html>