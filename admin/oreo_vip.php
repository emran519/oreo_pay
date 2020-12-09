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
                                                <li class="breadcrumb-item active">VIP功能设置</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">VIP功能设置</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">VIP功能设置说明</h4>
                                            <p class="text-muted m-b-30 font-14">关闭则是免费，前台不显示购买列表，关闭后所有商户均是开启支付宝通道，若要开启购买,所有用户均需要购买有关权限才能使用相关功能.
											<br/>系统能自动判断哪些用户是消费购买权限的，您如果关闭/开启，之前消费购买的则任然继续使用，没有消费购买则是需要消费开启相关权限.</p>
												<div class="form-group">
                                                    <label style="color: #f00;">超级会员设置</label>
                                                    <select  class="form-control" name="chaojivip" id="chaojivip" onchange="svip('sss',this.value)">
                                                    <option value="0" <?=$conf['chaojivip']==0?"selected":""?> >关闭</option>
													<option value="1" <?=$conf['chaojivip']==1?"selected":""?> >开启</option> 
                                                    </select>													
													<small>* 关闭则是免费，用户可以免费开通！</small>		
                                                </div>
												<div  id="sss_v"  style="<?php echo $conf['chaojivip'] == 1 ? "" : "display: none;";?>">
												<div class="form-group">
                                                    <label style="color: #f00;">价格设置</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="chaoji_money" value="<?php echo $conf['chaoji_money']; ?>" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label style="color: #f00;">介绍设置:</label>
                                                    <div>
                                                       <textarea   placeholder="如：<li>超级会员</li> ,建议4个，多了或者少了影响美观" name="chaoji_js" rows="3" class="form-control"><?php echo $conf['chaoji_js']; ?></textarea>
                                                       <small>* 建议4个,多了或者少了影响美观！</small>
                                                  </div>
                                                </div>    
												
												<div class="form-group">
                                                    <label style="color: #f00;">是否启用特殊支付通道</label>
                                                    <select  class="form-control" name="ssvip_zt" id="ssvip_zt" onchange="svip('ssz',this.value)">
                                                    <option value="0" <?=$conf['ssvip_zt']==0?"selected":""?> >关闭</option>
													<option value="1" <?=$conf['ssvip_zt']==1?"selected":""?> >开启</option> 
                                                    </select>													
													<small>* 以下是易支付接口配置！</small>		
                                                </div>
												<div  id="ssz_v"  style="<?php echo $conf['ssvip_zt'] == 1 ? "" : "display: none;";?>">
										    	<div class="form-group">
                                                    <label style="color: #f00;">接口地址</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="ssvip_url" value="<?php echo $conf['ssvip_url']; ?>" />
														<small> * 网站的URL地址 例如:https://pay.oreopay.com/</small>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label style="color: #f00;">商户ID</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="ssvip_id" value="<?php echo $conf['ssvip_id']; ?>" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label style="color: #f00;">商户KEY</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="ssvip_key" value="<?php echo $conf['ssvip_key']; ?>" />
                                                    </div>
                                                </div></div>
												<div class="form-group">
                                                    <label style="color: #f00;">是否启用超级会员自定义费率</label>
                                                    <select  class="form-control" name="ssvip_zdy" id="ssvip_zdy" onchange="svip('sszz',this.value)">
                                                    <option value="0" <?=$conf['ssvip_zdy']==0?"selected":""?> >关闭</option>
													<option value="1" <?=$conf['ssvip_zdy']==1?"selected":""?> >开启</option> 
                                                    </select>														
                                                </div>
												<div  id="sszz_v"  style="<?php echo $conf['ssvip_zt'] == 1 ? "" : "display: none;";?>">
												<div class="form-group">
                                                    <label style="color: #f00;">支付宝费率</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="ssvip_ali" value="<?php echo $conf['ssvip_ali']; ?>" />
														<small>* 例如：95 = 收取5%的费率,如果设置为777即代表走公共或个人费率！</small>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label style="color: #f00;">微信费率</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="ssvip_wx" value="<?php echo $conf['ssvip_wx']; ?>" />
														<small>* 例如：95 = 收取5%的费率,如果设置为777即代表走公共或个人费率！</small>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label style="color: #f00;">QQ钱包费率</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="ssvip_qq" value="<?php echo $conf['ssvip_qq']; ?>" />
														<small>* 例如：95 = 收取5%的费率,如果设置为777即代表走公共或个人费率！</small>
                                                    </div>
                                                </div></div>
												</div>
                                                <div class="form-group">
                                                    <label style="color: #0094ff;">支付宝收费接口设置</label>
                                                    <select  class="form-control" name="alivip" id="alivip" onchange="svip('ali',this.value)">
                                                    <option value="0" <?=$conf['alivip']==0?"selected":""?> >关闭</option>
													<option value="1" <?=$conf['alivip']==1?"selected":""?> >开启</option> 
                                                    </select>													
													<small>* 关闭则是免费，用户可以免费开通！</small>	
                                                </div>
												<div  id="ali_v"  style="<?php echo $conf['alivip'] == 1 ? "" : "display: none;";?>">
												<div class="form-group">
                                                    <label style="color: #0094ff;">价格设置</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="alivip_money" value="<?php echo $conf['alivip_money']; ?>" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label style="color: #0094ff;">介绍设置:</label>
                                                    <div>
                                                       <textarea  placeholder="如：<li>支付宝接口</li> " name="alivip_js" rows="3" class="form-control"><?php echo $conf['alivip_js']; ?></textarea>
                                                       <small>* 建议4个,多了或者少了影响美观！</small>
                                                  </div>
                                                </div>    
												</div><br/> 
												<div class="form-group">
                                                    <label style="color: #27c90e;">微信收费接口设置</label>
                                                    <select  class="form-control" name="wxvip" id="wxvip" onchange="svip('wx',this.value)">
                                                    <option value="0" <?=$conf['wxvip']==0?"selected":""?> >关闭</option>
													<option value="1" <?=$conf['wxvip']==1?"selected":""?> >开启</option> 
                                                    </select>													
													<small>* 关闭则是免费，用户可以免费开通！</small>		
                                                </div>
												<div  id="wx_v"  style="<?php echo $conf['wxvip'] == 1 ? "" : "display: none;";?>">
												<div class="form-group">
                                                    <label style="color: #27c90e;">价格设置</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="wxvip_money" value="<?php echo $conf['wxvip_money']; ?>" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label style="color: #27c90e;">介绍设置:</label>
                                                    <div>
                                                       <textarea   placeholder="如：<li>微信接口</li> ,建议4个，多了或者少了影响美观" name="wxvip_js" rows="3" class="form-control"><?php echo $conf['wxvip_js']; ?></textarea>
                                                       <small>* 建议4个,多了或者少了影响美观！</small>
                                                  </div>
                                                </div>    
												</div><br/> 
												<div class="form-group">
                                                    <label style="color: #4728ea;">QQ钱包收费接口设置</label>
                                                    <select  class="form-control" name="qqvip" id="qqvip" onchange="svip('qq',this.value)">
                                                    <option value="0" <?=$conf['qqvip']==0?"selected":""?> >关闭</option>
													<option value="1" <?=$conf['qqvip']==1?"selected":""?> >开启</option> 
                                                    </select>													
													<small>* 关闭则是免费，用户可以免费开通！</small>		
                                                </div>
												<div  id="qq_v"  style="<?php echo $conf['qqvip'] == 1 ? "" : "display: none;";?>">
												<div class="form-group">
                                                    <label style="color: #4728ea;">价格设置</label>
                                                    <div>
                                                        <input type="text" class="form-control"  name="qqvip_money" value="<?php echo $conf['qqvip_money']; ?>" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label style="color: #4728ea;">介绍设置:</label>
                                                    <div>
                                                       <textarea   placeholder="如：<li>QQ钱包接口</li> ,建议4个，多了或者少了影响美观" name="qqvip_js" rows="3" class="form-control"><?php echo $conf['qqvip_js']; ?></textarea>
                                                       <small>* 建议4个,多了或者少了影响美观！</small>
                                                  </div>
                                                </div>    
												</div>                               
                                                <div class="form-group m-b-0">
                                                    <div> 
                                                        <button type="button" id="vip" value="保存修改" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                            重置
                                                        </button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                </div> <!-- content -->
                <?php include'foot.php';?>
		<script>
	function svip(type,val){
    var ali  = $("#"+type+"_v");
	var wx  = $("#"+type+"_v");
	var qq  = $("#"+type+"_v");
	var sss  = $("#"+type+"_v");
	var ssz  = $("#"+type+"_v");
	var sszz  = $("#"+type+"_v");
    if(val == 0){
       $(ali). hide()
       $(wx). hide()	  
       $(qq). hide()
       $(sss). hide()
       $(ssz). hide()
       $(sszz). hide()	   
    }
    if(val == 1){
       $(ali).show()
	   $(wx).show()
	   $(qq).show()
	   $(sss).show()
	   $(ssz).show()
	   $(sszz).show()
    }        
}

                        $("#vip").click(function () {
						var chaojivip = $("#chaojivip").val();
						var chaoji_money=$("input[name='chaoji_money']").val();
						var chaoji_js=$("textarea[name='chaoji_js']").val();
						var ssvip_zt = $("#ssvip_zt").val();
						var ssvip_url=$("input[name='ssvip_url']").val();
                        var ssvip_id=$("input[name='ssvip_id']").val();
						var ssvip_key=$("input[name='ssvip_key']").val();		
						var ssvip_zdy = $("#ssvip_zdy").val();
						var ssvip_ali=$("input[name='ssvip_ali']").val();
						var ssvip_wx=$("input[name='ssvip_wx']").val();
						var ssvip_qq=$("input[name='ssvip_qq']").val();
					    var alivip = $("#alivip").val();
						var alivip_money=$("input[name='alivip_money']").val();
						var alivip_js=$("textarea[name='alivip_js']").val();
						var wxvip = $("#wxvip").val();
						var wxvip_money=$("input[name='wxvip_money']").val();
						var wxvip_js=$("textarea[name='wxvip_js']").val();
						var qqvip = $("#qqvip").val();
						var qqvip_money=$("input[name='qqvip_money']").val();
						var qqvip_js=$("textarea[name='qqvip_js']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Svip",
							data: {chaojivip:chaojivip,chaoji_money:chaoji_money,chaoji_js:chaoji_js,ssvip_zt:ssvip_zt,ssvip_url:ssvip_url,ssvip_id:ssvip_id,ssvip_key:ssvip_key,ssvip_zdy:ssvip_zdy,ssvip_ali:ssvip_ali,ssvip_wx:ssvip_wx,ssvip_qq:ssvip_qq,alivip_js:alivip_js,alivip:alivip,alivip_money:alivip_money,alivip_js:alivip_js,wxvip:wxvip,wxvip_money:wxvip_money,wxvip_js:wxvip_js,qqvip:qqvip,qqvip_money:qqvip_money,qqvip_js:qqvip_js},
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