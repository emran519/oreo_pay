<?php
include("../oreo/Oreo.Cron.php");
if($islogin2 != 1){exit("<script language='javascript'>window.location.href='./login.php';</script>");}
if($conf['chaojivip']==0||$conf['alivip']==0||$conf['wxvip']==0||$conf['qqvip']==0){
    exit("<script language='javascript'>alert('本站管理员暂未开启接口权限购买功能，如有疑问请联系客服！');history.go(-1);</script>");
}
include("./oreo_static.php");
$vipzfb=$DB->query("select * from oreo_viporder where uid='$pid' and name='支付宝' ")->fetch();
$vipwx=$DB->query("select * from oreo_viporder where uid='$pid' and name='微信支付' ")->fetch();
$vipqq=$DB->query("select * from oreo_viporder where uid='$pid' and name='QQ钱包' ")->fetch();
$vipssvip=$DB->query("select * from oreo_viporder where uid='$pid' and name='超级会员' ")->fetch();
?>
<link rel="stylesheet" href="//at.alicdn.com/t/font_1139659_a1gvys4jdtq.css">
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
                                            <li class="breadcrumb-item active">开通接口</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">开通接口</h4>
                                </div> <!-- end page-title-box -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end page title -->
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <!-- Pricing Title-->
                                <div class="text-center">
                                    <h3 class="mb-2">您可以在此页进行购买平台设定的接口使用权限和会员权限</h3>
                                </div>
                                <!-- Plans -->
                                <div class="row mt-sm-5 mt-3 mb-3">
								 <?php 	if ($conf['chaojivip']==1){ ?>
									<div class="col-md-4">
                                        <div class="card card-pricing">
                                            <div class="card-body text-center">
                                                <p class="card-pricing-plan-name font-weight-bold text-uppercase">超级会员</p>
                                                <i class="iconfont icon-huiyuan" style="font-size: 35px;color: #f7bd01;"></i>
                                                <h2 class="card-pricing-price">¥<?php echo $conf['chaoji_money']; ?><span>/ 元</span></h2>
                                                <ul class="card-pricing-features">
                                                    <?php echo $conf['chaoji_js'];?>
                                                </ul>
												<?php if($userrow['ssvip']==1 || $vipssvip ){ ?>
                                                <button class="btn btn-primary mt-4 mb-2 btn-rounded">您已开通,无需再次操作</button>
						                        <?php }else{ ?>
												<input type="text" name="usid" readonly="readonly"  value="<?php echo $pid?>"  style="display: none;" />
						                        <input type="text" class="form-control gdq" name="chaoji_money" readonly="readonly"  value="<?php echo $conf['chaoji_money'];?>"  style="display: none;" /> 
                                                <input type="text" name="typnamesvip" readonly="readonly"  value="ssvip"  style="display: none;" />
                                                <button class="btn btn-primary mt-4 mb-2 btn-rounded" type="button" id="ssgoumai">立即开通</button>
												<?php }?>
                                            </div>
                                        </div> <!-- end Pricing_card -->
                                    </div> <!-- end col -->
                                     <?php }?>
                                    <?php 	if ($conf['alivip']==1){ ?>
									<div class="col-md-4">
                                        <div class="card card-pricing">
                                            <div class="card-body text-center">
                                                <p class="card-pricing-plan-name font-weight-bold text-uppercase">支付宝</p>
                                                <i class="iconfont icon-zhifubao" style="font-size: 35px;color: #05bcff;"></i>
                                                <h2 class="card-pricing-price">¥<?php echo $conf['alivip_money']; ?><span>/ 元</span></h2>
                                                <ul class="card-pricing-features">
                                                    <?php echo $conf['alivip_js'];?>
                                                </ul>
												<?php if($userrow['alipay']==1 || $vipzfb ){ ?>
                                                <button class="btn btn-primary mt-4 mb-2 btn-rounded">您已开通,无需再次操作</button>
						                        <?php }else{ ?>
												<input type="text" class="form-control gdq" name="usid" readonly="readonly"  value="<?php echo $pid?>"  style="display: none;" />
						                        <input type="text" class="form-control gdq" name="alimoney" readonly="readonly"  value="<?php echo $conf['alivip_money'];?>"  style="display: none;" />
						                        <input type="text" name="typnameali" readonly="readonly"  value="alipay"  style="display: none;" />
                                                <button class="btn btn-primary mt-4 mb-2 btn-rounded" type="button" id="aligoumai">立即开通</button>
												<?php }?>
                                            </div>
                                        </div> <!-- end Pricing_card -->
                                    </div> <!-- end col -->
                                     <?php }?>
                                    <?php 	if ($conf['wxvip']==1){ ?>
									<div class="col-md-4">
                                        <div class="card card-pricing">
                                            <div class="card-body text-center">
                                                <p class="card-pricing-plan-name font-weight-bold text-uppercase">微信支付</p>
                                                <i class="iconfont icon-weixin" style="font-size: 35px;color: #00cc38;"></i>
                                                <h2 class="card-pricing-price">¥<?php echo $conf['wxvip_money']; ?><span>/ 元</span></h2>
                                                <ul class="card-pricing-features">
                                                    <?php echo $conf['wxvip_js'];?>
                                                </ul>
												<?php if($userrow['wxpay']==1 || $vipwx ){ ?>
                                                <button class="btn btn-primary mt-4 mb-2 btn-rounded">您已开通,无需再次操作</button>
						                        <?php }else{ ?>
												<input type="text" class="form-control gdq" name="usid" readonly="readonly"  value="<?php echo $pid?>"  style="display: none;" />
						                        <input type="text" class="form-control gdq" name="wxmon" readonly="readonly"  value="<?php echo $conf['wxvip_money'];?>"  style="display: none;" />
                                                <input type="text" name="typnamewx" readonly="readonly"  value="wxpay"  style="display: none;" />
                                                <button class="btn btn-primary mt-4 mb-2 btn-rounded" type="button" id="wxgoumai">立即开通</button>
												<?php }?>
                                            </div>
                                        </div> <!-- end Pricing_card -->
                                    </div> <!-- end col -->
                                     <?php }?>
                                    <?php 	if ($conf['qqvip']==1){ ?>
									<div class="col-md-4">
                                        <div class="card card-pricing">
                                            <div class="card-body text-center">
                                                <p class="card-pricing-plan-name font-weight-bold text-uppercase">QQ钱包</p>
                                                <i class="iconfont icon-qq" style="font-size: 35px;color: #0096db;"></i>
                                                <h2 class="card-pricing-price">¥<?php echo $conf['qqvip_money']; ?><span>/ 元</span></h2>
                                                <ul class="card-pricing-features">
                                                    <?php echo $conf['qqvip_js'];?>
                                                </ul>
												<?php if($userrow['qqpay']==1 || $vipqq ){ ?>
                                                <button class="btn btn-primary mt-4 mb-2 btn-rounded">您已开通,无需再次操作</button>
						                        <?php }else{ ?>
												<input type="text" class="form-control gdq" name="usid" readonly="readonly"  value="<?php echo $pid?>"  style="display: none;" />
						                        <input type="text" class="form-control gdq" name="qqmon" readonly="readonly"  value="<?php echo $conf['qqvip_money'];?>"  style="display: none;" /> 
                                                <input type="text" name="typnameqq" readonly="readonly"  value="qqpay"  style="display: none;" />
                                                <button class="btn btn-primary mt-4 mb-2 btn-rounded" type="button" id="qqgoumai">立即开通</button>
												<?php }?>
                                            </div>
                                        </div> <!-- end Pricing_card -->
                                    </div> <!-- end col -->
                                     <?php }?>
                                </div>
                                <!-- end row -->
                            </div> <!-- end col-->
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
<script src="../assets/newuser/js/layer.js"></script>	
<script>
					 $("#aligoumai").click(function () {
						var usid=$("input[name='usid']").val();
                        var alimoney=$("input[name='alimoney']").val();
						var typname=$("input[name='typnameali']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_GoumaiAli",
							data: {usid:usid,alimoney:alimoney,typname:typname},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开通成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else if (data.code == -1) {
									layer.alert( data.msg, function(index) {
                                    layer.close(index);
                                    location.href="oreo_cz.php"; 
                                    })
								} 
							}
						});
					});
					 $("#wxgoumai").click(function () {
						var usid=$("input[name='usid']").val();
                        var wxmon=$("input[name='wxmon']").val();
						var typname=$("input[name='typnamewx']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_GoumaiWx",
							data: {usid:usid,wxmon:wxmon,typname:typname},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开通成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else if (data.code == -1) {
									layer.alert( data.msg, function(index) {
                                    layer.close(index);
                                    location.href="oreo_cz.php"; 
                                    })
								} 
							}
						});
					});
					$("#qqgoumai").click(function () {
						var usid=$("input[name='usid']").val();
                        var qqmon=$("input[name='qqmon']").val();
						var typname=$("input[name='typnameqq']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_GoumaiQq",
							data: {usid:usid,qqmon:qqmon,typname:typname},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开通成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else if (data.code == -1) {
									layer.alert( data.msg, function(index) {
                                    layer.close(index);
                                    location.href="oreo_cz.php"; 
                                    })
								} 
							}
						});
					});
					$("#ssgoumai").click(function () {
						var usid=$("input[name='usid']").val();
                        var chaoji_money=$("input[name='chaoji_money']").val();
						var typname=$("input[name='typnamesvip']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_GoumaiSs",
							data: {usid:usid,chaoji_money:chaoji_money,typname:typname},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开通成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else if (data.code == -1) {
									layer.alert( data.msg, function(index) {
                                    layer.close(index);
                                    location.href="oreo_cz.php"; 
                                    })
								} 
							}
						});
					});

</script>
    </body>

</html>