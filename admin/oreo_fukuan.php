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
                                                <li class="breadcrumb-item active">结算转账设置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">结算转账设置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">结算转账设置说明</h4>
                                            <p class="text-muted m-b-30 font-14">在这里您可以设置平台的结算转账有关参数，一般是针对企业（第三方）接口着开发使用，使用前请先确认您有第三方有关权限！</p>
                                            <form id="oreo_form" action="" method="post">
                                            <div class="form-group" >
                                                    <label>是否开启微信企业转账</label>
                                                    <div>
                                                    <select  class="form-control" name="weixin_qiye" id="weixin_qiye" onchange="sh_rg('sh',this.value)">
                                                    <option value="0" <?=$conf['weixin_qiye']==0?"selected":""?> >关闭</option>
                                                    <option value="1" <?=$conf['weixin_qiye']==1?"selected":""?> >开启</option>          
                                                    </select>
                                                    </div>
                                                    </div>
                                                    <div class="form-group" id="sh_reg"  style="<?php echo $conf['weixin_qiye'] == 1 ? "" : "display: none;";?>">
                                                <div class="form-group">
                                                    <label>微信支付商户号</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="" name="wxtransfer_mchid" value="<?php echo $conf['wxtransfer_mchid']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>微信支付公众号APPID</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="" name="wxtransfer_appid" value="<?php echo $conf['wxtransfer_appid']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>微信支付公众号APP_Key</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="" name="wxtransfer_appkey" value="<?php echo $conf['wxtransfer_appkey']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>微信支付API_Key</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="" name="wxtransfer_apikey" value="<?php echo $conf['wxtransfer_apikey']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>微信支付cert</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="请在您管理员目录下自行创建文件夹并上传您的密钥文件在此配置地址" name="apiclient_cert" value="<?php echo $conf['apiclient_cert']; ?>" />
                                                    </div>
                                                    <br>
                                                    <small>密钥文件：apiclient_cert.pem</small><br>
                                                    <small>设置方法：必须在当前目录下，如admin，在此目录下自行创建一个文件夹，再上次您的密钥文件.</small><br>
                                                    <small>千万不要暴露您创建的文件夹. 上次成功后设置地址为如： /新建的文件加名/apiclient_cert.pem</small><br>
                                                </div>
                                                <div class="form-group">
                                                    <label>微信支付Key</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="请在您管理员目录下自行创建文件夹并上传您的密钥文件在此配置地址" name="apiclient_key" value="<?php echo $conf['apiclient_key']; ?>" />
                                                    </div>
                                                    <br>
                                                    <small>密钥文件：apiclient_key.pem</small><br>
                                                    <small>设置方法：必须在当前目录下，如admin，在此目录下自行创建一个文件夹，再上次您的密钥文件.</small><br>
                                                    <small>千万不要暴露您创建的文件夹. 上次成功后设置地址为如： /新建的文件加名/apiclient_key.pem</small><br>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>转帐备注</label>
                                                    <div>
                                                        <input type="text" class="form-control" placeholder="如：余额提现"  name="payer_show_name" value="<?php echo $conf['payer_show_name']; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>支付宝应用APPID</label>
                                                    <div>
                                                        <input class="form-control"  type="text range"  name="alipay_appid" value="<?php echo $conf['alipay_appid']; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <div> 
                                                        <button type="button" id="editFukuan"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
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
     	function sh_rg(type,val){
    var gb  = $("#"+type+"_reg");
    if(val == 0){
       $(gb).hide() 
    }
    if(val == 1){
       $(gb).show()
    }
    	
}
                        $("#editFukuan").click(function () {
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