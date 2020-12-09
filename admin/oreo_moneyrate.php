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
                                                <li class="breadcrumb-item"><a href="#">系统参数</a></li>
                                                <li class="breadcrumb-item active">公共商户费率设置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">公共商户费率设置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">公共商户费率设置说明</h4>
                                            <p class="text-muted m-b-30 font-14">在这里您可以设置平台的商户费率参数，请认真填写每一项，若要设置单独费率请到商户信息里修改！</p>
                                            <form id="oreo_form" action="" method="post">
                                                  <div class="form-group">
                                                    <label>三网费率开关（关闭时按同比计算）</label>
                                                    <select   class="form-control" name="sw_money_rate" id="sw_money_rate" onchange="sw_fl('sws',this.value)" >
                                                      <option value="0" <?=$conf['sw_money_rate']==0?"selected":""?> >关闭</option>
                                                     <option value="1" <?=$conf['sw_money_rate']==1?"selected":""?>>开启公共三网费率模式</option>
                                                   </select>
                                                </div>
												  <div id="sws_gw" style="<?php echo $conf['sw_money_rate'] == 0 ? "" : "display: none;";?>" > 
                                                   <div class="form-group" >
                                                    <label>每笔交易费率（百分数）</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="money_rate" value="<?php echo $conf['money_rate']; ?>" />
                                                        <small>* 默认支付分成比例（百分数） 例如：95 = 收取5%的费率</small> 
                                                    </div>
                                                </div>
												</div>
												<div id="sws_sw_ggsz" style="<?php echo $conf['sw_money_rate'] == 1 ? "" : "display: none;";?>" > 
												<div class="form-group" >
                                                    <label>支付宝费率（百分数）</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="alipay_rate" value="<?php echo $conf['alipay_rate']; ?>" />
                                                        <small>* 默认支付分成比例（百分数） 例如：95 = 收取5%的费率</small> 
                                                    </div>
                                                </div>
												<div class="form-group" >
                                                    <label>微信费率（百分数）</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="weixin_rate" value="<?php echo $conf['weixin_rate']; ?>" />
                                                        <small>* 默认支付分成比例（百分数） 例如：95 = 收取5%的费率</small> 
                                                    </div>
                                                </div>
												<div class="form-group" >
                                                    <label>QQ钱包费率（百分数）</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="qq_rate" value="<?php echo $conf['qq_rate']; ?>" />
                                                        <small>* 默认支付分成比例（百分数） 例如：95 = 收取5%的费率</small> 
                                                    </div>
                                                </div>
												</div><br/>
                                                    <div class="form-group">
                                                    <label>每天满多少元自动结算</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="settle_money" value="<?php echo $conf['settle_money']; ?>" />
                                                    </div>
                                                </div>
                                                     <div class="form-group">
                                                    <label>结算手续费（实际为<?php $a=100;$b=$conf['settle_rate'];echo $a*$b?>%）</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="settle_rate" value="<?php echo $conf['settle_rate']; ?>" />
                                                        <small>* 1 = 1%(100:1)</small> 
                                                    </div>
                                                </div>
                                                   <div class="form-group">
                                                    <label>结算手续费最小</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="settle_fee_min" value="<?php echo $conf['settle_fee_min']; ?>" />
                                                    </div>
                                                </div>
                                                   <div class="form-group">
                                                    <label>结算手续费最大</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="settle_fee_max" value="<?php echo $conf['settle_fee_max']; ?>" />
														<small>如果是0即代表不要任何结算手续费</small> 
                                                    </div>
                                                </div>
                                                   <div class="form-group">
                                                    <label>手动结算功能</label>
                                                    <select  class="form-control" name="settle_open" id="settle_open" >
                                                     <option value="0" <?=$conf['settle_open']==0?"selected":""?> >关闭</option>
													 <option value="1" <?=$conf['settle_open']==1?"selected":""?> >开启</option>
                                                    </select>
                                                     <small>* 是否开启商户中心手动申请结算</small> 
                                                </div>
                                                    <div class="form-group">
                                                    <label>手动结算最低金额</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="sdtx_money_min" value="<?php echo $conf['sdtx_money_min']; ?>" />
                                                    </div>  
                                                      </div>
                                                <div class="form-group m-b-0">
                                                    <div> 
                                                        <button type="button" id="editMoneyrate" value="保存修改" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                            重置
                                                        </button>
                                                        </form>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                </div> <!-- content -->
                <?php include'foot.php';?>
<script>
function sw_fl(type,val){
    var gb  = $("#"+type+"_gw");
    var gg =  $("#"+type+"_sw_ggsz");

    if(val == 0){
       $(gb).show()
       $(gg).hide();
       $(dyh).hide();   
    }
    if(val == 1){
       $(gb).hide()
       $(gg).show();
       $(dyh).hide();
    }
    
     
}
                        $("#editMoneyrate").click(function () {
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