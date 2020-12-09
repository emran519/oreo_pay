<?php
include("../oreo/Oreo.Cron.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
include("./oreo_static.php");
function do_callback($data){
	global $DB,$userrow;
	if($data['status']>=1)$trade_status='TRADE_SUCCESS';
	else $trade_status='TRADE_FAIL';
	$array=array('pid'=>$data['pid'],'trade_no'=>$data['trade_no'],'out_trade_no'=>$data['out_trade_no'],'type'=>$data['type'],'name'=>$data['name'],'money'=>$data['money'],'trade_status'=>$trade_status);
	$arg=argSort(paraFilter($array));
	$prestr=createLinkstring($arg);
	$urlstr=createLinkstringUrlencode($arg);
	$sign=md5Sign($prestr, $userrow['key']);
	if(strpos($data['notify_url'],'?'))
		$url=$data['notify_url'].'&'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
	else
		$url=$data['notify_url'].'?'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
	return $url;
}
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
                                            <li class="breadcrumb-item active">订单列表</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">订单列表</h4>
                                </div> <!-- end page-title-box -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-lg-8">
                                                <form class="form-inline" method="post" action="oreo_order.php">
                                                    <div class="form-group mb-2">
                                                        <label for="inputPassword2" class="sr-only">搜索</label>
                                                        <input type="search"  name="my" class="form-control"  placeholder="搜索...">
                                                    </div>
                                                    <div class="form-group mx-sm-3 mb-2">
                                                        <label for="status-select" class="mr-2">搜索对象</label>
                                                        <select class="custom-select" name="column" >
                                                            <option selected>请选择...</option>
                                                            <option value="trade_no">交易号</option>
                                                            <option value="out_trade_no">商户订单号</option>
                                                            <option value="pid">商户号</option>
                                                            <option value="name">商品名称</option>
                                                            <option value="money">金额</option>
                                                        </select>
                                                    </div>                       
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="text-lg-right">
                                                    <button type="submit" name="submit" class="btn btn-success mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i> 搜索</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                                       </form> 
                                        <div class="table-responsive">
                                            <table class="table table-centered mb-0 text-nowrap">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>交易号/商户订单号</th>
                                                        <th>商品名称</th>
                                                        <th>商品金额</th>
                                                        <th>支付方式</th>
                                                        <th>创建时间/完成时间</th>
                                                        <th>状态</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												<?php
if(isset($_POST['submit'])) {

	if($_POST['column']=='name'){
		$sql=" and `{$_POST['column']}` like '%{$_POST['my']}%'";
	}else{
		$sql=" and `{$_POST['column']}`='{$_POST['my']}'";
	}
	$numrows=$DB->query("SELECT count(*) from oreo_order WHERE pid={$pid}{$sql}")->fetchColumn();
	$link='&my=search&column='.$_POST['column'].'&value='.$_POST['my'];
}												
$numrows=$DB->query("SELECT count(*) from oreo_order WHERE pid={$pid}{$sql} ")->fetchColumn();
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
$list=$DB->query("SELECT * FROM oreo_order WHERE pid={$pid}{$sql} order by trade_no desc limit $offset,$pagesize")->fetchAll();
												
                                   foreach($list as $res){
	                                echo '<tr>
                                    <td>'.$res['trade_no'].'<br/>'.$res['out_trade_no'].'</td>
                                    <td>'.$res['name'].'</td>
                                    <td>￥ <b>'.$res['money'].'</b></td>
                                    <td> <b>'.$res['type'].'</b></td>
                                    <td>'.$res['addtime'].'<br/>'.$res['endtime'].'</td>
                                    <td>'.($res['status']==1?'<font color=green>已完成</font>':'<font color=red>未完成</font>').'</td>
                                    <td><a href="'.do_callback($res).'" target="_blank" rel="noreferrer">重新通知</a></td></tr>';
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
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div> <!-- content -->
                    <!-- Footer Start -->
                    <footer class="footer">
                        <div class="row">
                            <div class="col-md-6">
                                 <?php echo $conf['copyright']; ?>. 
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
        <script src="../assets/newuser/js/app.min.js"></script>
    </body>
</html>