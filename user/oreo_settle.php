<?php
include("../oreo/Oreo.Cron.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
include("./oreo_static.php");
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
                                            <li class="breadcrumb-item active">结算明细</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">结算明细</h4>
                                </div> <!-- end page-title-box -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-centered mb-0 text-nowrap">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>序号</th>
                                                        <th>结算账号</th>
                                                        <th>结算金额</th>
                                                        <th>手续费</th>
                                                        <th>结算时间</th>
                                                        <th>状态</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
 <?php
											
$numrows=$DB->query("SELECT count(*) from oreo_settle WHERE pid={$pid}")->fetchColumn();
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
$list=$DB->query("SELECT * FROM oreo_settle WHERE pid={$pid} order by id desc limit $offset,$pagesize")->fetchAll();
$lisst=$DB->query("SELECT * FROM oreo_apply WHERE uid={$pid} order by id desc limit $offset,$pagesize")->fetchAll();
                                 foreach($list as $res){
	                                   echo '<tr>
                                       <td>'.$res['id'].'</td>
                                       <td>'.$res['account'].'</td>
                                       <td>￥ <b>'.$res['money'].'</b></td>
                                       <td>￥ <b>'.$res['fee'].'</b></td>
                                       <td>'.$res['time'].'</td>
                                       <td>'.($res['status']==1?'<font color=green>已完成</font>':'<font color=red>未完成</font>').'</td>
                                       </tr>';
                                      }
								  foreach($lisst as $res){
	                                  $fees=round($res['money']-$res['fee'],2);
									  echo '<tr>
                                       <td>'.$res['id'].'&nbsp;--&nbsp;手动结算</td>
                                       <td>'.$res['account'].'</td>
                                       <td>￥ <b>'.$res['money'].'</b></td>
                                       <td>￥ <b>'.$fees.'</b></td>
                                       <td>'.$res['sdtime'].'</td>
                                       <td>'.($res['type']==1?'<font color=green>已完成</font>':'<font color=red>未完成</font>').'</td>
                                       </tr>';
                                      } 
                                    ?>
                                                    
                                                </tbody>
                                            </table>
											<nav style="float: inline-end;">
                                                    <ul class="pagination">
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
    </body>
</html>