<?php
include("../oreo/Oreo.Cron.php");
if($islogin2 != 1){exit("<script language='javascript'>window.location.href='./login.php';</script>");}
include("./oreo_static.php");
if($conf['ddcsuser']==0){
	exit("<script language='javascript'>alert('本站管理员暂未开启订单测试功能，如有疑问请联系客服！');history.go(-1);</script>");
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
                                            <li class="breadcrumb-item active">订单测试</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">订单测试</h4>
                                </div> <!-- end page-title-box -->
                            </div> <!-- end col-->
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                              <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">关于在线测试的注意事项：</h4>
                                            <p>1.请不要恶意提交订单，投诉订单，否则后果自负.</p>
											<p>2.请确保您所提交的商户ID为您本人，测试支付成功后资金错乱概不负责.</p>
											<p>3.商品订单号为唯一值，如中途放弃测试，请直接刷新页面获取最新的唯一订单号.</p>
                                            <p>4.付款金额为随机值<code>1-10</code>￥，请您不要恶意测试，否则后果自负.</p>
                                        </div>   
                                            </div>
                                            <!-- end col -->
                                            <div class="col-lg-4">
                                                <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                    <h4 class="header-title mb-3">订单详情</h4>
													 <form class="needs-validation"name="alipayment"action="../SDK/epayapi.php"method="post"target="_self">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>商户ID :</td>
                                                                    <td><input type="text"class="form-control"name="id"value="<?php echo $pid?>"readonly="readonly"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>商户密钥 : </td>
                                                                    <td><input type="text"class="form-control"name="key"value="<?php echo $userrow['key']?>"readonly="readonly"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>商户订单号 :</td>
                                                                    <td><input type="text"class="form-control"name="WIDout_trade_no"value="<?php echo date("YmdHis").mt_rand(100,999); ?>"aria-describedby="inputGroupPrepend"readonly="readonly"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>商品名称 : </td>
                                                                    <td> <input type="text" class="form-control" name="WIDsubject" value="<?php echo $conf['order_name'];?>"readonly="readonly"></td>
                                                                </tr>
                                                                <tr>
																<?php if($conf['ddcsusje']==1){?>
                                                                    <th>付款金额(固定) :</th>
                                                                    <th><input type="text"class="form-control"name="WIDtotal_fee"value="<?php  echo $conf['ddcsus_money'];?>"readonly="readonly"></th>
																	<?php }else{?>
																	<th>付款金额(随机值) :</th>
                                                                    <th><input type="text"class="form-control"name="WIDtotal_fee"value="<?php echo mt_rand(1,10);?>"readonly="readonly"></th>
																	<?php }?>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- end table-responsive -->
                                                </div>
                                                <div class="button-list mt-3" style="text-align: center;">
                                                   <?php if($conf['alipay_mode']!=0){?>
                                                   <button type="radio" value="alipay" name="type" class="btn btn-primary"><i class="iconfont icon-zhifubao"></i> 支付宝</button>
												   <?php }if($conf['wxpay_mode']!=0){ ?>		
												   <button type="radio" value="wxpay" name="type" class="btn btn-success"><i class="iconfont icon-weixin"></i> 微信</button>
												   <?php }if($conf['qqpay_mode']!=0){ ?>
												   <button type="radio" value="qqpay" name="type" class="btn btn-secondary"><i class="iconfont icon-qq"></i> QQ钱包</button>
                                                   <?php } ?>   
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