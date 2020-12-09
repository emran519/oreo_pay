<?php
include "../oreo/Oreo.Cron.php";
include './oreo_static.php';
if ($islogin == 1) {
} else {
    exit("<script language='javascript'>window.location.href='./login.php';</script>");
}
?>
<?php
if(isset($_GET['batch'])){
	$batch=$_GET['batch'];
	$allmoney=$_GET['allmoney'];
	$count=$DB->query("SELECT * from oreo_settle where batch='$batch'")->rowCount();
	$srow=$DB->query("SELECT * FROM oreo_batch WHERE batch='{$batch}' limit 1")->fetch();
	if($srow['status']==0){
		$rs=$DB->query("SELECT * from oreo_settle where batch='$batch'");
		while($row = $rs->fetch())
		{
			$dcmoney=$row['money']+$row['fee'];
			$DB->exec("update `oreo_user` set `money`=`money`-'{$dcmoney}',`apply`='0' where `id`='{$row['pid']}'");
			$DB->exec("update `oreo_settle` set `status`='1' where `id`='{$row['id']}'");
		}
		$DB->exec("update `oreo_batch` set `status`='1' where `batch`='{$batch}'");
	}
?>
                          
 <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="index.php">控制台</a></li>
                                                <li class="breadcrumb-item"><a href="#">资金管理</a></li>
                                                <li class="breadcrumb-item active">结算操作</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">结算操作</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->

                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                             <h4 class="mt-0 header-title">订单结算说明</h4>
                                            <p>结算标准：金额大于<code><?php echo $conf['settle_money']?></code>元，或主动申请的需扣除手续费<code><?php echo $conf['settle_fee']?></code>
                                              元。
                                              <p>结算列表请勿重复生成，CSV文件可以重复下载！
                                            </p>
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th style="width: 50%;">#</th>
                                                    <th>批次号</th>
                                                    <th>涉及总金额</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>当前需要结算的共有<?php echo $count?>条记录</td>
                                                    <td>
                                                        <a  id="inline-username" data-type="text" data-pk="1" data-title="Enter username">批次号：<?php echo $batch?></a>
                                                    </td>
                                                  <td>
                                                        <a  id="inline-username" data-type="text" data-pk="1" data-title="Enter username">总金额：<?php echo $allmoney?>元</a>
                                                    </td>
                                                </tr>
                                               
                                                </tbody>
                                            </table>
              <form action="download.php" method="get" role="form">
		  <input type="hidden" name="batch" value="<?php echo $batch?>"/>
		  <input type="hidden" name="allmoney" value="<?php echo $allmoney?>"/>

            <p><input type="submit" value="下载CSV文件" class="btn btn-primary form-control"/></p>
          </form>
		  <form action="transfer.php" method="get" role="form">
		  <input type="hidden" name="batch" value="<?php echo $batch?>"/>
            <p><input type="submit" value="单笔转账到支付宝账户" class="btn btn-success form-control"/></p>
          </form>
		  <form action="wxtransfer.php" method="get" role="form">
		  <input type="hidden" name="batch" value="<?php echo $batch?>"/>
            <p><input type="submit" value="微信企业付款" class="btn btn-success form-control"/></p>
          </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
           <?php }else{?>

                    <div class="page-content-wrapper ">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="index.php">控制台</a></li>
                                                <li class="breadcrumb-item"><a href="#">资金管理</a></li>
                                                <li class="breadcrumb-item active">结算操作</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">结算操作</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->

                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
         
                                            <h4 class="mt-0 header-title">订单结算说明</h4>
                                            <p>结算标准：金额大于<code><?php echo $conf['settle_money']?></code>元，或主动申请的需扣除手续费<code><?php echo $conf['settle_fee']?></code>
                                              元。
                                              <p>结算列表请勿重复生成，CSV文件可以重复下载！
                                            </p>
                                            <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap">
                                                <thead style="text-align: center;">
                                                <tr>
                                                    <th>批次号</th>
		                                            <th>总金额</th>
													<th>平台收益</th>
		                                            <th>生成时间</th>
		                                            <th>状态</th>
		                                            <th>操作</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody style="text-align: center;">
                                            <?php
$sql=" 1";
$numrows=$DB->query("SELECT count(*) from oreo_batch WHERE{$sql}")->fetchColumn();											
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
$list=$DB->query("SELECT * FROM oreo_batch WHERE{$sql} order by time desc limit $offset,$pagesize");				
while($res = $list->fetch())								
{
echo '<tr><td><b>'.$res['batch'].'</b></td><td>'.$res['allmoney'].'</td><td>'.$res['fee'].'</td><td>'.$res['time'].'</td><td>'.($res['status']==1?'<a class="btn btn-xs btn-success">已完成</a>':'<a class="btn btn-xs btn-danger">未完成</a>').'</td><td><a href="./oreo_settle.php?batch='.$res['batch'].'&allmoney='.$res['allmoney'].'" class="btn btn-xs btn-info" onclick="return confirm(\'是否确定生成本批次结算列表？\');">生成结算列表</a></td></tr>';
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
echo '<li class="page-item"><a class="page-link" href="oreo_settle.php?page='.$first.$link.'">首页</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_settle.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_settle.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=3)$s=3;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_settle.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li class="page-item"><a class="page-link" href="oreo_settle.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_settle.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">尾页</a></li>';
}
echo'</ul>';
#分页
?>
                                                </nav>
                                        </div>
            <?php }?>
                                        
                                      
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->
<?php include'foot.php';?>
    </body>
</html>