<?php
include("../oreo/Oreo.Cron.php");
if ($islogin2 != 1) {
	exit("<script language='javascript'>window.location.href='./login.php';</script>");
}
include("./oreo_static.php");
if($conf['settle_open']==0){
	exit("<script language='javascript'>alert('本站管理员暂未开启手动结算功能，如有疑问请联系客服！');history.go(-1);</script>");
}
$today=date("Y-m-d").' 00:00:00';
$rs=$DB->query("SELECT * from oreo_order where pid={$pid} and status=1 and endtime>='$today'");
$order_today=0;
while($row = $rs->fetch())
{
	$order_today+=$row['money'];
}

$fees=round($userrow['money']*$conf['settle_rate'],2);
if($fees<=$conf['settle_fee_min']&&$userrow['money']!=0){
$enable_money=round($userrow['money']-$conf['settle_fee_min'],2);
$feesr=$conf['settle_fee_min'];
}else{	
$enable_money=round($userrow['money']-($userrow['money']*$conf['settle_rate']),2);
$feesr=$conf['settle_rate'];
}
$sdate=date("YmdHis");
if(isset($_GET['act']) && $_GET['act']=='do'){
		if($userrow['apply']==1){
			exit("<script language='javascript'>alert('很抱歉，您有一个还未完结的手动结申请记录，请勿重复申请！');history.go(-1);</script>");
		}
		if($enable_money<$conf['sdtx_money_min']){
			exit("<script language='javascript'>alert('很抱歉，您当前的商户余额不满足本站可申请手动结算的最低金额设定标准！');history.go(-1);</script>");
		}
		if($userrow['type']==2){
			exit("<script language='javascript'>alert('很抱歉，您的商户出现异常，无法申请手动结算！');history.go(-1);</script>");
		}
		$sqs=$DB->exec("update `oreo_user` set `apply` ='1' where `id`='$pid'");
		$sqsa=$DB->exec("INSERT INTO `oreo_apply` (`uid`, `jsfs`, `username`, `account`, `money`, `fee`, `sdtime`, `type`) VALUES ('{$pid}', '{$userrow['settle_id']}', '{$userrow['username']}', '{$userrow['account']}', '{$userrow['money']}', '{$enable_money}', '{$sdate}', '0')");
		$email=$conf['web_mail'];
		$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].'/';
		$sub = $conf['web_name'].' - 您有新的手动结算要处理';
		$msg = '<h2>新的手动结算等你来处理</h2>尊敬的管理员您的网站【'.$conf['web_name'].'】收到一个新的手动结算申请<br/>结算ID：'.$pid.'<br/>结算姓名 ：'.$userrow['username'].'<br/>提现金额：'.$userrow['money'].'<br/>手续费：'.$feesr.'<br/>可提现余额：'.$enable_money.'<br/>请尽快登录后台处理订单：【<a href="'.$siteurl.'" target="_blank">登录后台</a>】<br/>';
		$result = send_mail($email, $sub, $msg);
		exit("<script language='javascript'>alert('恭喜您，申请手动结算成功，相关费率信息请看手动结算页说明！');history.go(-1);</script>");
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
                                            <li class="breadcrumb-item active">手动结算</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">手动结算</h4>
                                </div> <!-- end page-title-box -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-8">
											<?php if($userrow['apply']==1){?>
											<div class="alert alert-danger" role="alert">
                                            <i class="dripicons-wrong mr-2"></i> 您已经提交 <strong>手动结算</strong> 申请请求，请耐心等待管理员审核.
											</div><?php }?>
                                              <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">关于手动提现的注意事项：</h4>
                                            <p>1.当商户余额达到本站“手动结算金额标准”即可申请结算.</p>
											<p>2.手动结算功能可以让您在商户余额未达到<font color="red">“每日自动结算金额标准”</font>时向管理员申请结算.</p>
											<p> 3.款项将扣除<?php $a=100;$b=$conf['settle_rate'];echo $a*$b?>%的手续费，在T+1工作日内结算到您的指定账户中；结算时如手续费不足
				                                 <font color="red"><?php echo $conf['settle_fee_min']; ?>元</font>按<font color="red"><?php echo $conf['settle_fee_min']; ?>元</font>收取，请知悉.</p>
                                            <hr>
                                            <p>每日自动结算金额标准：</p>
											<p>1.商户余额满<?php echo $conf['settle_money']; ?>元，系统每日自动结算.</p>
											<p>2.申请手动结算金额标准：</code>商户余额满<?php echo $conf['sdtx_money_min']; ?>元，才可申请手动结算.</p>
                                        </div>
                                            </div>
                                            <!-- end col -->
                                            <div class="col-lg-4">
                                                <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                    <h4 class="header-title mb-3">结算详情</h4>
                                                     <form class="needs-validation" action="./oreo_apply.php?act=do" method="post">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>结算账号 :</td>
                                                                    <td><?php echo $userrow['account'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>结算姓名 : </td>
                                                                    <td><?php echo $userrow['username'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>当前商户余额 :</td>
                                                                    <td>￥<?php echo $userrow['money'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>手续费 : </td>
                                                                    <td>￥<?php echo $feesr;?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>可提现余额 :</th>
                                                                    <th>￥<?php echo $enable_money;?></th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- end table-responsive -->
                                                </div>
                                                <div class="alert alert-warning mt-3" role="alert">
                                                    申请一旦提交，即代表您已确认<strong>有关手续费</strong>的了解和接受 ！
                                                </div>
                                                <div class="input-group mt-3">
                                                    <div class="text-sm-right">
                                                            <button type="submit" name="submit" class="btn btn-danger"><i class="mdi mdi-cart-arrow-up"></i>提交申请</button>
                                                        </div>
                                                </div>
                                             </form>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
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