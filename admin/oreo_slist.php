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
                                                <li class="breadcrumb-item active">结算记录</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">结算记录</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">结算记录说明</h4>
                                            <p class="text-muted m-b-30 font-14">这里所产生的数据是<code>平台所有的结算记录数据</code>包括当日和以往数据，您可以根据状态来判断结算是否完成。
                                            </p>
                                           <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap" style="text-align: center;">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
              <th>商户号</th>
              <th>结算方式</th>
              <th>姓名</th>
              <th>结算账号</th>
              <th>收款码</th>
              <th>结算金额</th>
              <th>手续费</th>
              <th>结算时间</th>
              <th>状态</th>
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
$numrows=$DB->query("SELECT count(*) from oreo_settle WHERE{$sql}")->fetchColumn();
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
$list=$DB->query("SELECT * FROM oreo_settle WHERE{$sql} order by id desc limit $offset,$pagesize");				
while($res = $list->fetch())
{
    $rescode=$DB->query("select * from oreo_user where id='{$res['pid']}'")->fetch();
    if($res['type']==1&&$rescode['alipaycode']!=''){
        $photo='<img src="'.$rescode['alipaycode'].'"  class="rounded img-raised" style="width: 130px;height: 130px;">';
    }else if($res['type']==2&&$rescode['wxpaycode']!=''){
        $photo='<img src="'.$rescode['wxpaycode'].'"  class="rounded img-raised" style="width: 130px;height: 130px;">';
    }else if($res['type']==3&&$rescode['qqpaycode']!=''){
        $photo='<img src="'.$rescode['qqpaycode'].'"  class="rounded img-raised" style="width: 130px;height: 130px;">';
    }else{
        $photo='<a>用户未上传收款码</a>';
    }
echo '
<tr>
<td><b>'.$res['id'].'</b></td>
<td>'.$res['pid'].'</td>
<td>'.display_type($res['type']).'</td>
<td>'.$res['username'].'</td>
<td>'.$res['account'].'</td>
<td>'.$photo.'</td>
<td>'.$res['money'].'</td>
<td>'.$res['fee'].'</td>
<td>'.$res['time'].'</td>
<td>'.($res['status']==1?'<a class="btn btn-xs btn-success">已完成</a>':'<a class="btn btn-xs btn-danger">未完成</a>').'</td></tr>';
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
echo '<li class="page-item"><a class="page-link" href="oreo_slist.php?page='.$first.$link.'">首页</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_slist.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_slist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=3)$s=3;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_slist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li class="page-item"><a class="page-link" href="oreo_slist.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_slist.php?page='.$last.$link.'">尾页</a></li>';
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

                </div> <!-- content -->
<?php include'foot.php';?>
    </body>
</html>