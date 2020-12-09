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
                                            <li class="breadcrumb-item active">会员中心</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">会员中心</h4>
                                </div> <!-- end page-title-box -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Profile -->
                                <div class="card bg-primary">
                                    <div class="card-body profile-user-box">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="media">
                                                    <span class="float-left m-2 mr-4"><img src="<?php echo ($userrow['qq'])?'//q3.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$userrow['qq'].'&src_uin='.$userrow['qq'].'&fid='.$userrow['qq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'/assets/images/team-1.jpg'?>" style="height: 100px;" alt="" class="rounded-circle img-thumbnail"></span>
                                                    <div class="media-body">

                                                        <h4 class="mt-1 mb-1 text-white"><?php echo $userrow['username'];?></h4>
                                                        <p class="font-13 text-white-50">KEY: <?php echo $userrow['key'];?></p>

                                                        <ul class="mb-0 list-inline text-light">
                                                            <li class="list-inline-item mr-3">
                                                                <h5 class="mb-1">¥ <?php echo $userrow['money'];?></h5>
                                                                <p class="mb-0 font-13 text-white-50">余额</p>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <h5 class="mb-1"><?php 
								$sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='超级会员' limit 1")->fetch();
								if($sviprows['type']==1){
									echo'超级会员';	
								}else{
									echo'不是会员';	
								}?></h5>
                                                                <p class="mb-0 font-13 text-white-50">会员权限</p>
                                                            </li>
                                                        </ul>
                                                    </div> <!-- end media-body-->
                                                </div>
                                            </div> <!-- end col--> 
                                           <div class="col-sm-4">
                                                <div class="text-center mt-sm-0 mt-3 text-sm-right">
                                                    <button type="button" class="btn btn-light" id="czkeys">
                                                        <i class="mdi mdi-account-edit mr-1"></i> 重置秘钥
                                                    </button>
                                                </div>
                                            </div> <!-- end col-->											
                                        </div> <!-- end row -->
                                    </div> <!-- end card-body/ profile-user-box-->
                                </div><!--end profile/ card -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->
                        <div class="row">
                          <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3"> 商户详情 </h4>
                                        <form>
                                            <div id="basicwizard">
                                                <ul class="nav nav-pills nav-justified form-wizard-header mb-4">
                                                    <li class="nav-item">
                                                        <a href="#basictab1" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2"> 
                                                            <i class="mdi mdi-account-circle mr-1"></i>
                                                            <span class="d-none d-sm-inline">商户信息</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#basictab2" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                                            <i class="mdi mdi-database-refresh"></i>
                                                            <span class="d-none d-sm-inline">修改信息</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#basictab3" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                                            <i class="mdi mdi-checkbox-marked-circle-outline mr-1"></i>
                                                            <span class="d-none d-sm-inline">修改密码</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content b-0 mb-0">
                                                    <div class="tab-pane" id="basictab1">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="userName">商户结算方式</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control"  value="<?php 
							if($userrow['settle_id']==1){
								echo'支付宝结算';
							}else if($userrow['settle_id']==2){
								echo'微信结算';
							}else if($userrow['settle_id']==3){
								echo'QQ钱包结算';
							}else if($userrow['settle_id']==4){
								echo'银行卡结算';
							}	
							?>" readonly="readonly">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="password">商户结算账号</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" value="<?php echo $userrow['account'];?>" readonly="readonly">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="confirm">商户结算姓名</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" value="<?php echo $userrow['username'];?>" readonly="readonly">
                                                                    </div>
                                                                </div>
																<div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="confirm">保密邮箱</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" value="<?php echo $userrow['email'];?>" readonly="readonly">
                                                                    </div>
                                                                </div>
																<div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="confirm">保密手机号</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" value="<?php echo $userrow['phone'];?>" readonly="readonly">
                                                                    </div>
                                                                </div>
																<div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="confirm">联系QQ</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" value="<?php echo $userrow['qq'];?>" readonly="readonly">
                                                                    </div>
                                                                </div>
																<div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="confirm">对接网站域名</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text"  class="form-control" value="<?php echo $userrow['url'];?>" readonly="readonly">
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row -->
                                                    </div>
                                                    <div class="tab-pane" id="basictab2">
                                                        <div class="row">
                                                            <div class="col-12">
                                                               <div class="alert alert-warning" role="alert">
                                                                <i class="dripicons-warning mr-2"></i> <strong>警告</strong> 请不要填写随意或虚假信息,这影响您的提现操作!
                                                                </div>
                                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#xiugai" data-id="xiugai">修改</button>
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row -->
                                                    </div>
                                                    <div class="tab-pane" id="basictab3">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="name">输入新密码</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="newpassword" class="form-control" placeholder="请输入新密码">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="surname">再次输入</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="lastpassword" class="form-control" placeholder="请再次输入新密码">
                                                                    </div>
                                                                </div>
                                                               <button type="button" id="xiugaimima" class="btn btn-primary">提交</button>
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row -->
                                                    </div>
                                                </div> <!-- tab-content -->
                                            </div> <!-- end #basicwizard-->
                                        </form>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                                  <div id="xiugai" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="text-center mt-2 mb-4">
                                                         <i class="mdi mdi-account-circle mr-1"></i>
                                                        </div>
                                                 <?php if ($conf['verifytype'] == 0) { ?>
												<div class="form-group">
                                                    <label>保密邮箱:</label>
                                                    <div>
													 <input type="text" class="form-control ca1"  readonly="readonly" value="<?php echo $userrow['email']?>"/>
                                                    </div>
                                                </div> 
												<div class="form-group">
                                                    <label>输入验证码:</label>
                                                    <div class="input-group">
                                                    <input class="form-control"type="text"name="code"placeholder="输入邮箱验证码"required>
                                                    <div class="input-group-append"><button type="button" class="btn btn-default" id="sendcode">获取验证码</button>
                                                 </div></div>
                                                </div> 
												<?php } else { ?>
												<div class="form-group">
                                                    <label>保密手机号:</label>
                                                    <div>
													 <input type="text" class="form-control ca2" name="phone" readonly="readonly" value="<?php echo $userrow['phone']?>"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>输入验证码:</label>
                                                    <div class="input-group">
                                                     <input class="form-control"type="text"name="code"placeholder="输入短信验证码"required>
                                                    <div class="input-group-append"><button type="button"class="btn btn-default"id="sendsms">获取验证码</button>
                                                 </div></div>
                                                </div> 
									           <?php } ?>
                                                            <div class="form-group text-center">
                                                                <button class="btn btn-primary" type="button" id="verifycode">提交验证</button>
                                                            </div>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
										<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="text-center mt-2 mb-4">
                                                         <i class="mdi mdi-account-circle mr-1"></i>
                                                        </div>
                                                <div class="form-group">
                                                    <label>商户结算方式:</label>
                                                    <div>
													<select class="form-control show-tick" name="stype" default="<?php echo $userrow['settle_id'] ?>">
                                                    <?php if($conf['stype_1']){?><option value="1" <?=$userrow['settle_id']==1?"selected":""?>>支付宝结算</option>
	     								            <?php }if($conf['stype_2']){?><option value="2" <?=$userrow['settle_id']==2?"selected":""?>>微信结算</option>
	     								            <?php }if($conf['stype_3']){?><option value="3" <?=$userrow['settle_id']==3?"selected":""?>>QQ钱包结算</option>
	     								            <?php }if($conf['stype_4']){?><option value="4" <?=$userrow['settle_id']==4?"selected":""?>>银行卡结算</option>
	     								            <?php }?>
                                                   </select>
                                                    </div>
                                                </div> 
												<div class="form-group">
                                                    <label id="typename">商户结算账号:</label>
                                                    <div>
													 <input type="text" class="form-control ca2" name="account" value="<?php echo $userrow['account']?>" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>商户结算姓名:</label>
                                                    <div>
													 <input type="text" class="form-control ca3" name="username" value="<?php echo $userrow['username']?>" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>保密邮箱:</label>
                                                    <div>
													 <input type="text" class="form-control ca1" name="email" value="<?php echo $userrow['email']?>" />
                                                    </div>
                                                </div> 
												<div class="form-group">
                                                    <label>保密手机号:</label>
                                                    <div>
													 <input type="text" class="form-control ca2" name="phone" value="<?php echo $userrow['phone']?>" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>联系QQ:</label>
                                                    <div>
													 <input type="text" class="form-control ca3" name="qq" value="<?php echo $userrow['qq']?>" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>对接网站域名:</label>
                                                    <div>
													 <input type="text" class="form-control ca3" name="url" placeholder="请不要写http://等协议"  value="<?php echo $userrow['url']?>" />
                                                    </div>
													<small>* 如：http://www.qq.com 直接写 www.qq.com</small>
                                                </div>
                                                            <div class="form-group text-center">
                                                                <button class="btn btn-primary" type="button" id="editInfo">提交</button>
                                                            </div>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                             <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">接口管理</h4>
                                        <div class="table-responsive-sm">
                                            <table class="table table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>名称</th>
                                                        <th>状态</th>
                                                        <th>开通时间</th>
														<th>自助开关</th>
														<th>操作</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>超级会员</td>
                                                        <td><?php 
										if($userrow['ssvip']==1){
											echo'<a style="color: blue;">已开启</a>';
										}else{
											echo'<a style="color: red;">已关闭</a>';
										}
										?></td>
                                                        <td><?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='超级会员' limit 1")->fetch();
								         if($sviprows['time']!=''){
									         echo''.$sviprows['time'].'';	
								         }else{
									         echo'系统默认开通';	
								        }?></td>
										<td>
										<?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='超级会员' limit 1")->fetch();
								         if($sviprows){
									         echo'支持';	
								         }else{
									         echo'不支持';	
								        }?>
										</td>
                                                         <td>
                                        <?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='超级会员' limit 1")->fetch();
								         if($sviprows&&$sviprows['type']==1){
									         echo'<a class="btn btn-danger"  id="guanbisvip" style="color: white;"> 点击关闭</a>';	
								         }else if($sviprows&&$sviprows['type']==0){
									         echo'<a class="btn btn-success" id="kaiqiisvip" style="color: white;">点击开启</a>';	
								        }else{
											 echo'<button class="btn btn-secondary" style="color: white;">无权操作</button>';	
										}
										?>    
                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>支付宝</td>
                                                        <td>
														<?php 
										if($userrow['alipay']==1){
											echo'<a style="color: blue;">已开启</a>';
										}else{
											echo'<a style="color: red;">已关闭</a>';
										}
										?>
														</td>
                                                        <td><?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='支付宝' limit 1")->fetch();
								         if($sviprows['time']!=''){
									         echo''.$sviprows['time'].'';	
								         }else{
									         echo'系统默认开通';	
								        }?></td>
										 <td>
										<?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='支付宝' limit 1")->fetch();
								         if($sviprows){
									         echo'支持';	
								         }else{
									         echo'不支持';	
								        }?>
										</td>
                                                       <td>
                                        <?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='支付宝' limit 1")->fetch();
								         if($sviprows&&$sviprows['type']==1){
									         echo'<a class="btn btn-danger"  id="guanbiali" style="color: white;">点击关闭</a>';	
								         }else if($sviprows&&$sviprows['type']==0){
									         echo'<a class="btn btn-success" id="kaiqiali" style="color: white;">点击开启</a>';	
								        }else{
											 echo'<button class="btn btn-secondary" style="color: white;">无权操作</button>';	
										}
										?>   
                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>微信支付</td>
                                                        <td><?php 
										if($userrow['wxpay']==1){
											echo'<a style="color: blue;">已开启</a>';
										}else{
											echo'<a style="color: red;">已关闭</a>';
										}
										?></td>
                                                        <td><?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='微信支付' limit 1")->fetch();
								         if($sviprows['time']!=''){
									         echo''.$sviprows['time'].'';	
								         }else{
									         echo'系统默认开通';	
								        }?></td>
										<td>
										<?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='微信支付' limit 1")->fetch();
								         if($sviprows){
									         echo'支持';	
								         }else{
									         echo'不支持';	
								        }?>
										</td>
                                                       <td>
                                        <?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='微信支付' limit 1")->fetch();
								         if($sviprows&&$sviprows['type']==1){
									         echo'<a class="btn btn-danger" id="guanbiwx" style="color: white;">点击关闭</a>';	
								         }else if($sviprows&&$sviprows['type']==0){
									         echo'<a class="btn btn-success" id="kaiqiwx" style="color: white;">点击开启</a>';	
								        }else{
											 echo'<button class="btn btn-secondary" style="color: white;">无权操作</button>';	
										}
										?>   
                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>QQ钱包</td>
                                                        <td><?php 
										if($userrow['qqpay']==1){
											echo'<a style="color: blue;">已开启</a>';
										}else{
											echo'<a style="color: red;">已关闭</a>';
										}
										?></td>
                                                        <td><?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='QQ钱包' limit 1")->fetch();
								         if($sviprows['time']!=''){
									         echo''.$sviprows['time'].'';	
								         }else{
									         echo'系统默认开通';	
								        }?></td>
										<td>
										<?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='QQ钱包' limit 1")->fetch();
								         if($sviprows){
									         echo'支持';	
								         }else{
									         echo'不支持';	
								        }?>
										</td>
                                                        <td>
                                        <?php 
								         $sviprows=$DB->query("select * from oreo_viporder where uid='$pid' AND name='QQ钱包' limit 1")->fetch();
								         if($sviprows&&$sviprows['type']==1){
									         echo'<a class="btn btn-danger" id="guanbiqq" style="color: white;">点击关闭</a>';	
								         }else if($sviprows&&$sviprows['type']==0){
									         echo'<a class="btn btn-success" id="kaiqiqq" style="color: white;">点击开启</a>';	
								        }else{
											 echo'<button class="btn btn-secondary" style="color: white;">无权操作</button>';	
										}
										?>   
                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                            <!-- end col -->
                             <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3"> 我的收款码 </h4>
                                        <form>
                                            <div id="basicwizard">
                                                <ul class="nav nav-pills nav-justified form-wizard-header mb-4">
                                                    <li class="nav-item">
                                                        <a href="#basictabcode" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2 active"> 
                                                            <i class="mdi mdi-credit-card-scan"></i>
                                                            <span class="d-none d-sm-inline">收款码</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#basictabupcode" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                                            <i class="mdi mdi-cloud-upload"></i>
                                                            <span class="d-none d-sm-inline">上传收款码</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content b-0 mb-0">
                                                    <div class="tab-pane active" id="basictabcode">
                                                        <div class="row">
                                                            <div class="col-12">
                                                               <?php if($userrow['alipaycode']){?>  
                            <small class="text-muted">支付宝: </small>
                            <img src="<?php echo $userrow['alipaycode'];?>" alt="请上传收款码" class="rounded img-raised" style="width: 200px;height: 200px;margin: 0 auto;text-align: center;vertical-align: middle;display: table-caption;">
                            <hr> <?php }if($userrow['wxpaycode']){?>  
                            <small class="text-muted">微信: </small>
                            <img src="<?php echo $userrow['wxpaycode'];?>" alt="请上传收款码" class="rounded img-raised" style="width: 200px;height: 200px;margin: 0 auto;text-align: center;vertical-align: middle;display: table-caption;">
                            <hr> <?php }if($userrow['qqpaycode']){?>  
                            <small class="text-muted">QQ: </small>
                            <img src="<?php echo $userrow['qqpaycode'];?>" alt="请上传收款码" class="rounded img-raised" style="width: 200px;height: 200px;margin: 0 auto;text-align: center;vertical-align: middle;display: table-caption;">
							<hr><?php }?>  
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row -->
                                                    </div>
                                                    <div class="tab-pane" id="basictabupcode">
                                                        <div class="row">
                                                            <div class="col-12">
                                                            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                             <span aria-hidden="true">×</span>
                                                             </button>
                                                             <strong>警告 - </strong>请不要上传虚假信息,这影响您的提现操作,一旦上传成功就不能再次修改，若要修改请联系管理员重置有关信息!
                                                            </div>
							<?php if($conf['sh_codes']==1){?>
                                                              <?php if(!$userrow['alipaycode']&&!$userrow['wxpaycode']&&!$userrow['qqpaycode']){?>  
                            <small class="text-muted">支付宝&nbsp;&nbsp;&nbsp;&nbsp;: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="alipaycode" id="alipaycode"  />
							 <hr>
                            <small class="text-muted">微信支付: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="wxpaycode" id="wxpaycode"  />
                            <hr>
                            <small class="text-muted">QQ钱包&nbsp;&nbsp;: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="qqpaycode" id="qqpaycode"  />
							<hr>
							<div class="text-center">
				            <a name="tjrz" value="tjrz" id="go" onclick="tjrz()" class="btn btn-success" style="color: white;">上传图片</a>
                            </div>
							<?php } ?>
							<?php if($userrow['alipaycode']&&!$userrow['wxpaycode']&&!$userrow['qqpaycode']){?>  
                            <small class="text-muted">微信支付: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="wxpaycode" id="wxpaycode"  />
                            <hr>
                            <small class="text-muted">QQ钱包&nbsp;&nbsp;: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="qqpaycode" id="qqpaycode"  />
							<hr>
							<div class="text-center">
				            <a name="tjrza" value="tjrza" id="go" onclick="tjrza()" class="btn btn-success" style="color: white;">上传图片</a>
                            </div>
							<?php } ?>
							<?php if(!$userrow['alipaycode']&&$userrow['wxpaycode']&&!$userrow['qqpaycode']){?>  
                            <small class="text-muted">支付宝&nbsp;&nbsp;&nbsp;&nbsp;: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="alipaycode" id="alipaycode"  />
							 <hr>
                            <small class="text-muted">QQ钱包&nbsp;&nbsp;: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="qqpaycode" id="qqpaycode"  />
							<hr>
							<div class="text-center">
				            <a name="tjrzb" value="tjrzb" id="go" onclick="tjrzb()" class="btn btn-success" style="color: white;">上传图片</a>
                            </div>
							<?php } ?>
							<?php if(!$userrow['alipaycode']&&!$userrow['wxpaycode']&&$userrow['qqpaycode']){?>  
                            <small class="text-muted">支付宝&nbsp;&nbsp;&nbsp;&nbsp;: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="alipaycode" id="alipaycode"  />
							 <hr>
                            <small class="text-muted">微信支付: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="wxpaycode" id="wxpaycode"  />
                            <hr>
							<div class="text-center">
				            <a name="tjrzc" value="tjrzc" id="go" onclick="tjrzc()" class="btn btn-success" style="color: white;">上传图片</a>
                            </div>
							<?php } ?>
							<?php if($userrow['alipaycode']&&$userrow['wxpaycode']&&!$userrow['qqpaycode']){?>  
                            <small class="text-muted">QQ钱包&nbsp;&nbsp;: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="qqpaycode" id="qqpaycode"  />
							<hr>
							<div class="text-center">
				            <a name="tjrzd" value="tjrzd" id="go" onclick="tjrzd()" class="btn btn-success" style="color: white;">上传图片</a>
                            </div>
							<?php } ?>
							<?php if(!$userrow['alipaycode']&&$userrow['wxpaycode']&&$userrow['qqpaycode']){?>  
                            <small class="text-muted">支付宝&nbsp;&nbsp;&nbsp;&nbsp;: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="alipaycode" id="alipaycode"  />
							 <hr>
							<div class="text-center">
				            <a name="tjrze" value="tjrze" id="go" onclick="tjrze()" class="btn btn-success" style="color: white;">上传图片</a>
                            </div>
							<?php } ?>
							<?php if($userrow['alipaycode']&&!$userrow['wxpaycode']&&$userrow['qqpaycode']){?>  
                            <small class="text-muted">微信支付: </small>
                            <input type="file" class="btn bg-light-blue waves-effect"  name="wxpaycode" id="wxpaycode"  />
                            <hr>
							<div class="text-center">
				            <a name="tjrzf" value="tjrzf" id="go" onclick="tjrzf()" class="btn btn-success" style="color: white;">上传图片</a>
                            </div>
							<?php } } ?>
							
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row -->
                                                    </div>
                                                </div> <!-- tab-content -->
                                            </div> <!-- end #basicwizard-->
                                        </form>
                                    </div> <!-- end card-body -->
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
<script src="../assets/newuser/js/demo.form-wizard.js"></script>
<script src="../assets/newuser/js/layer.js"></script>
<script src="//static.geetest.com/static/tools/gt.js"></script> 
<script> 
					$("#guanbisvip").click(function () {
						var uid="<?=$pid?>";
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_Guanbisvip",
							data: {uid:uid},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('关闭权限成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$("#kaiqiisvip").click(function () {
						var uid="<?=$pid?>";
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_Kaiqisvip",
							data: {uid:uid},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开通权限成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$("#guanbiali").click(function () {
						var uid="<?=$pid?>";
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_Guanbiali",
							data: {uid:uid},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('关闭权限成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$("#kaiqiali").click(function () {
						var uid="<?=$pid?>";
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_Kaiqiali",
							data: {uid:uid},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开通权限成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$("#guanbiwx").click(function () {
						var uid="<?=$pid?>";
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_Guanbiwx",
							data: {uid:uid},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('关闭权限成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$("#kaiqiwx").click(function () {
						var uid="<?=$pid?>";
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_Kaiqiwx",
							data: {uid:uid},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开通权限成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$("#guanbiqq").click(function () {
						var uid="<?=$pid?>";
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_Guanbiqq",
							data: {uid:uid},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('关闭权限成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$("#kaiqiqq").click(function () {
						var uid="<?=$pid?>";
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_Kaiqiqq",
							data: {uid:uid},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开通权限成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$("#czkeys").click(function () {
						var uid="<?=$pid?>";
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_chongzhikyes",
							data: {uid:uid},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('重置秘钥成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					
function invokeSettime(obj) {
					var countdown = 60;
					settime(obj);

					function settime(obj) {
						if (countdown == 0) {
							$(obj).attr("data-lock", "false");
							$(obj).text("获取验证码");
							countdown = 60;
							return;
						} else {
							$(obj).attr("data-lock", "true");
							$(obj).attr("disabled", true);
							$(obj).text("(" + countdown + ") s 重新发送");
							countdown--;
						}
						setTimeout(function () {
								settime(obj)
							}
							, 1000)
					}
				}
                        $("#sendcode").click(function () {
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "GET",
							url: "ajax2.php?act=sendcodeemail",
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									new invokeSettime("#sendcode2");
									layer.msg('发送成功，请注意查收！');
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
var handlerEmbed = function (captchaObj) {
    var phone;
    captchaObj.onReady(function () {
        $("#wait").hide();
    }).onSuccess(function () {
        var result = captchaObj.getValidate();
        if (!result) {
            return alert('请完成验证');
        }
        var ii = layer.load(2, {shade:[0.1,'#fff']});
        $.ajax({
            type : "POST",
            url : "ajax2.php?act=sendcode",
            data : {phone:phone,geetest_challenge:result.geetest_challenge,geetest_validate:result.geetest_validate,geetest_seccode:result.geetest_seccode},
            dataType : 'json',
            success : function(data) {
                layer.close(ii);
                if(data.code == 0){
                    new invokeSettime("#sendsms");
					new invokeSettime("#sendcode2");
					layer.msg('发送成功，请注意查收！');
                }else{
                    layer.alert(data.msg);
                    captchaObj.reset();
                }
            } 
        });
    });
    $('#sendsms').click(function () {
        if ($(this).attr("data-lock") === "true") return;
        phone=$("input[name='phone']").val();
        if(phone==''){layer.alert('手机号码不能为空！');return false;}
        if(phone.length!=11){layer.alert('手机号码不正确！');return false;}
        captchaObj.verify();
    })
    // 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
};
				$(document).ready(function () {
					$("select[name='stype']").change(function () {
						if ($(this).val() == 1) {
							$("#typename").html("支付宝账号");
						} else if ($(this).val() == 2) {
							$("#typename").html("微信Openid");
						} else if ($(this).val() == 3) {
							$("#typename").html("QQ号");
						} else if ($(this).val() == 4) {
							$("#typename").html("银行卡号");
						}
					});
					
					$("#editInfo").click(function () {
						var stype = $("select[name='stype']").val();
						var account = $("input[name='account']").val();
						var username = $("input[name='username']").val();
						var email = $("input[name='email']").val();
						var phone = $("input[name='phone']").val();
						var qq = $("input[name='qq']").val();
						var url = $("input[name='url']").val();
						if (account == '' || username == '' || email == '' || qq == '' || url == '') {
							layer.alert('请确保各项不能为空！');
							return false;
						}
						if (email.length > 0) {
							var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
							if (!reg.test(email)) {
								layer.alert('邮箱格式不正确！');
								return false;
							}
						}
						if (url.indexOf(" ") >= 0) {
							url = url.replace(/ /g, "");
						}
						if (url.toLowerCase().indexOf("http://") == 0) {
							url = url.slice(7);
						}
						if (url.toLowerCase().indexOf("https://") == 0) {
							url = url.slice(8);
						}
						if (url.slice(url.length - 1) == "/") {
							url = url.slice(0, url.length - 1);
						}
						$("input[name='url']").val(url);
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=edit_info",
							data: {stype: stype, account: account, username: username,email: email,phone: phone, qq: qq, url: url},
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
					$("#checkbind").click(function () {
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "GET",
							url: "ajax2.php?act=checkbind",
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									$("#situation").val("bind");
									$('#myModal2').modal('show');
								} else if (data.code == 2) {
									$("#situation").val("mibao");
									$('#myModal').modal('show');
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$("#verifycode").click(function () {
						var code = $("input[name='code']").val();
						var situation = $("#situation").val();
						if (code == '') {
							layer.alert('请输入验证码！');
							return false;
						}
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=verifycode",
							data: {code: code},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.msg('验证成功！');
									$('#myModal').modal('show');
									if (situation == 'settle') {
										$("#editSettle").click();
									} else if (situation == 'mibao') {
										$("#situation").val("bind");
										$('#myModal2').modal('show');
									} else if (situation == 'bind') {
										$('#myModal2').modal('hide');
										window.location.reload();
									}
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
					$.ajax({
						// 获取id，challenge，success（是否启用failback）
						url: "ajax.php?act=captcha&t=" + (new Date()).getTime(), // 加随机数防止缓存
						type: "get",
						dataType: "json",
						success: function (data) {
							console.log(data);
							// 使用initGeetest接口
							// 参数1：配置参数
							// 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
							initGeetest({
								width: '100%',
								gt: data.gt,
								challenge: data.challenge,
								new_captcha: data.new_captcha,
								product: "bind", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
								offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
								// 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
							}, handlerEmbed);
						}
					});
					var items = $("select[default]");
					for (i = 0; i < items.length; i++) {
						$(items[i]).val($(items[i]).attr("default") || 1);
					}
				});		
					
				$("#xiugaimima").click(function () {
						var newpassword = $("input[name='newpassword']").val();						
                        var lastpassword = $("input[name='lastpassword']").val();			
						if (newpassword == '' || lastpassword == '') {
							layer.alert('请确保各项不能为空！');
							return false;
						}
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						
						$.ajax({
							type: "POST",
							url: "ajax2.php?act=m_EditPassword",
							data: {newpassword:newpassword,lastpassword:lastpassword},
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
		function tjrz(){
		var rzForm = new FormData(); 
		rzForm.append("tjrz","tjrz"); 
		rzForm.append("alipaycode",$('#alipaycode')[0].files[0]); 
		rzForm.append("wxpaycode",$('#wxpaycode')[0].files[0]); 
		rzForm.append("qqpaycode",$('#qqpaycode')[0].files[0]); 
		var ii = layer.load(2, {shade: [0.1, '#fff']});
		$.ajax({
			url: "ajax2.php?act=edit_mycode",
			type : "POST",
			dataType : 'JSON', 
			data : rzForm,
			cache: false,
			processData: false,
			contentType: false,
			success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('上传成功!', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
        })
	}
	function tjrza(){
		var rzForm = new FormData(); 
		rzForm.append("tjrza","tjrza"); 
		rzForm.append("wxpaycode",$('#wxpaycode')[0].files[0]); 
		rzForm.append("qqpaycode",$('#qqpaycode')[0].files[0]); 
		var ii = layer.load(2, {shade: [0.1, '#fff']});
		$.ajax({
			url: "ajax2.php?act=edit_mycodea",
			type : "POST",
			dataType : 'JSON', 
			data : rzForm,
			cache: false,
			processData: false,
			contentType: false,
			success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('上传成功!', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
        })
	}
	function tjrzb(){
		var rzForm = new FormData(); 
		rzForm.append("tjrzb","tjrzb"); 
		rzForm.append("alipaycode",$('#alipaycode')[0].files[0]); 
		rzForm.append("qqpaycode",$('#qqpaycode')[0].files[0]); 
		var ii = layer.load(2, {shade: [0.1, '#fff']});
		$.ajax({
			url: "ajax2.php?act=edit_mycodeb",
			type : "POST",
			dataType : 'JSON', 
			data : rzForm,
			cache: false,
			processData: false,
			contentType: false,
			success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('上传成功!', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
        })
	}
	function tjrzc(){
		var rzForm = new FormData(); 
		rzForm.append("tjrzc","tjrzc"); 
		rzForm.append("alipaycode",$('#alipaycode')[0].files[0]); 
		rzForm.append("wxpaycode",$('#wxpaycode')[0].files[0]); 
		var ii = layer.load(2, {shade: [0.1, '#fff']});
		$.ajax({
			url: "ajax2.php?act=edit_mycodec",
			type : "POST",
			dataType : 'JSON', 
			data : rzForm,
			cache: false,
			processData: false,
			contentType: false,
			success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('上传成功!', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
        })
	}
	function tjrzd(){
		var rzForm = new FormData(); 
		rzForm.append("tjrzd","tjrzd"); 
        rzForm.append("qqpaycode",$('#qqpaycode')[0].files[0]); 
		var ii = layer.load(2, {shade: [0.1, '#fff']});
		$.ajax({
			url: "ajax2.php?act=edit_mycoded",
			type : "POST",
			dataType : 'JSON', 
			data : rzForm,
			cache: false,
			processData: false,
			contentType: false,
			success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('上传成功!', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
        })
	}
	function tjrze(){
		var rzForm = new FormData(); 
		rzForm.append("tjrze","tjrze"); 
        rzForm.append("alipaycode",$('#alipaycode')[0].files[0]); 
		var ii = layer.load(2, {shade: [0.1, '#fff']});
		$.ajax({
			url: "ajax2.php?act=edit_mycodee",
			type : "POST",
			dataType : 'JSON', 
			data : rzForm,
			cache: false,
			processData: false,
			contentType: false,
			success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('上传成功!', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
        })
	}
	function tjrzf(){
		var rzForm = new FormData(); 
		rzForm.append("tjrzf","tjrzf"); 
        rzForm.append("wxpaycode",$('#wxpaycode')[0].files[0]); 
		var ii = layer.load(2, {shade: [0.1, '#fff']});
		$.ajax({
			url: "ajax2.php?act=edit_mycodef",
			type : "POST",
			dataType : 'JSON', 
			data : rzForm,
			cache: false,
			processData: false,
			contentType: false,
			success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('上传成功!', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
        })
	}
</script>	    
</body>
</html>