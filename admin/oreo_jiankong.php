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
                                                <li class="breadcrumb-item"><a href="#">核心</a></li>
                                                <li class="breadcrumb-item active">监控配置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">监控配置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">监控配置说明</h4>
                                            <p class="text-muted m-b-30 font-14">在这里您可以设置平台的监控识别码参数，监控配置文件不用您动手设置，这个小奥已经帮您配置好了的！</p>
                            
                                            <form id="oreo_form" action="" method="post">
                                                    <div class="form-group">
                                                    <label>监控识别码配置</label>
                                                    <div>
                                                      <input type="text" class="form-control" name="cron_key"  placeholder="为了防止恶意刷新请设置识别码" value="<?php echo $conf['cron_key']; ?>" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>是否验证IP</label>
                                                    <div>
                                                    <select  class="form-control" name="jk_ip_status" id="jk_ip_status" onchange="sh_rg('sh',this.value)">
                                                    <option value="0" <?=$conf['jk_ip_status']==0?"selected":""?> >关闭</option>
                                                    <option value="1" <?=$conf['jk_ip_status']==1?"selected":""?> >开启</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="sh_reg"  style="<?php echo $conf['jk_ip_status'] == 1 ? "" : "display: none;";?>">
                                                <label>IP地址</label>
                                                    <div>
                                                      <input type="text" class="form-control" name="jk_ip"  placeholder="如：154.25.3.62" value="<?php echo $conf['jk_ip']; ?>" class="form-control"/>
                                                    </div>
                                                    <small>*如果是宝塔那么填写宝塔的IP地址</small>
                                                </div>

                                                <div class="form-group m-b-0">
                                                    <div>
                                                         <button type="button" id="cron"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                            重置
                                                        </button>
                                                    </div>
                                                </div>
                                                </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                </div> <!-- content -->
				<div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">系统监控说明</h4>
                                             
											 <p class="text-muted m-b-30 font-20" style="text-align: center;">
                                             余额监控地址：http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/cron.php?key=<?php echo $conf['cron_key']; ?>
											 <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/cron.php?key=<?php echo $conf['cron_key']; ?>" class="btn btn-xs btn-info">点击执行</a><hr>
											 </p>
											 <p class="text-muted m-b-30 font-20" style="text-align: center;">
                                             结算监控地址：http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/cron.php?key=<?php echo $conf['cron_key']; ?>&do=settle
											 <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/cron.php?key=<?php echo $conf['cron_key']; ?>&do=settle" class="btn btn-xs btn-info">点击执行</a><hr>
											 <b style="text-align: center;display: block;"><font color="red" >温馨提示：小奥已经帮您设置好监控配置文件啦（如果您已经设置好正确的支付接口通道配置并且是易支付）！如有问题请记得联系小奥哟！</font></b><hr>
											 </p>
                                             <p class="text-muted m-b-30 font-20" style="text-align: center;">
                                             支付宝自动补单监控：http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/budan_alipay.php?key=<?php echo $conf['cron_key']; ?>
											 <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/budan_alipay.php?key=<?php echo $conf['cron_key']; ?>" class="btn btn-xs btn-info">点击执行</a><hr>
											 </p>
											 <p class="text-muted m-b-30 font-20" style="text-align: center;">
                                             微信自动补单监控：http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/budan_wxpay.php?key=<?php echo $conf['cron_key']; ?>
											 <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/budan_wxpay.php?key=<?php echo $conf['cron_key']; ?>" class="btn btn-xs btn-info">点击执行</a><hr>
											 </p>
                                             <p class="text-muted m-b-30 font-20" style="text-align: center;">
                                             QQ钱包自动补单监控：http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/budan_qqpay.php?key=<?php echo $conf['cron_key']; ?>
											 <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/budan_qqpay.php?key=<?php echo $conf['cron_key']; ?>" class="btn btn-xs btn-info">点击执行</a><hr>
											 </p>
											 <p class="text-muted m-b-30 font-20" style="text-align: center;">
                                             会员接口自动补单监控：http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/budan_vip.php?key=<?php echo $conf['cron_key']; ?>
											 <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/cron/budan_vip.php?key=<?php echo $conf['cron_key']; ?>" class="btn btn-xs btn-info">点击执行</a><hr>
                                             </p> 
                                             
                                             <p class="text-muted m-b-30 font-20" style="text-align: center;">
                                             支付接口异动检测（需在Oreo综合服务站开通）：http://<?php echo $_SERVER['HTTP_HOST']; ?>/oreo/oreo_function/safe/oreo_pay_safe_cron.php?key=<?=$tokens;?>&super=oreo_pay_safe_verification
											 <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/oreo/oreo_function/safe/oreo_pay_safe_cron.php?key=<?=$tokens;?>&super=oreo_pay_safe_verification" class="btn btn-xs btn-info">点击执行</a><hr>
											 </p> 
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                </div> <!-- content -->
                <?php include'foot.php';?>
		<script>
        function sh_rg(type,val){
    var gb  = $("#"+type+"_reg");
    if(val == 0){
       $(gb).hide() 
    }
    if(val == 1){
       $(gb).show()
    }	
}
		 $("#cron").click(function () {
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=add_oreo_conf",
                            data: $('#oreo_form').serialize(),
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
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}  
</script>
    </body>
</html>