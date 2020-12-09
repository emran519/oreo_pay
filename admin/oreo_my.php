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
                                                <li class="breadcrumb-item active">登录我的oreo账号</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">登录我的oreo账号</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
							<?php if($oreo_lo_code!=8){ ?>
                            <div class="row">
                                <div class="col-lg98-6">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">登录我的oreo账号说明</h4>
                                            <p class="text-muted m-b-30 font-14">正版用户请在此处登录您的Oreo账号并验证，登录后获得更好的服务，包括oreo的内测资格等.<a href="https://www.oreopay.com/">Oreo授权站</a></p>
												 <div class="form-group" >
                                                    <label>我的账号</label>
                                                    <div>
                                                      <input type="text" class="form-control" name="oreo_user" value=""  />
													 </div>
                                                </div>
												<div class="form-group">
                                                    <label>登录密码</label>
                                                    <div>
                                                      <input type="password" class="form-control" name="oreo_pwd" />
                                                    </div>
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <div>
                                                         <button type="button" id="oreo_login_one"  value="保存修改" class="btn btn-primary waves-effect waves-light" >
                                                            登录
                                                        </button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                    </div> <!-- content -->
							<?php }if($oreo_yctypes==1){ ?>
							 <div class="col-md-12 col-lg-12 col-xl-4">
                               <div class="card bg-white m-b-30">
                                        <div class="card-body new-user">
                                            <h5 class="header-title mb-4 mt-0">来自Oreo的反馈信息</h5>
                                            <p class="text-muted m-b-30 font-14">以下信息来自Oreo授权站，此信息与授权站同步状态.</p>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    
                                                    <tbody style="text-align: center;">
                                                        <tr>
                                                            <td>
                                                               <img class="rounded-circle" src="../assets/images/users/myid.jpg" alt="user" width="40"> </td>
                                                            <td>
                                                                <a href="javascript:void(0);" >我的账号</a>
                                                            </td>
                                                            <td><?php echo $my_uid; 
															 ?></td>                  
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <img class="rounded-circle" src="../assets/images/users/mytype.jpg" alt="user" width="40"> </td>
                                                            <td>
                                                                <a href="javascript:void(0);">我的状态</a>
                                                            </td>
                                                            <td><?php if($yczt==1){echo '<a style="color: green;">正常</a>';}else{echo'<a style="color: red;">封禁</a>';} ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <img class="rounded-circle" src="../assets/images/users/yue.jpg" alt="user" width="40"> </td>
                                                            <td>
                                                                <a href="javascript:void(0);">我的余额</a>
                                                            </td>
                                                            <td><?php echo $money ?></td>

                                                       
                                                        </tr>
                                                        <tr >
                                                            <td>
                                                                <img class="rounded-circle" src="../assets/images/users/dengji.jpg" alt="user" width="40"> </td>
                                                            <td>
                                                                <a href="javascript:void(0);">我的等级</a>
                                                            </td>                                                
                                                            <td>【<?php echo $gradename; ?>】</td>

                                                        </tr>
														<tr >
                                                            <td>
                                                               <img class="rounded-circle" src="../assets/images/users/beta.jpg" alt="user" width="40"> </td>
                                                            <td>
                                                                <a href="javascript:void(0);">内测权限</a>
                                                            </td>                                                
                                                            <td><?php if($beta==1){echo '<a style="color: green;">内测用户</a>';}if($beta==0){echo'<a style="color: red;">无权</a>';} ?></td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
											<div class="form-group m-b-0" style="text-align: center;">
                                                    <div>
                                                         <button type="button" id="login_out"  value="注销" class="btn btn-primary waves-effect waves-light" style="width: 8em;">
                                                            注销
                                                        </button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                    </div> <!-- Page content Wrapper -->
					<?php } ?>
                 <?php include'foot.php';?>
                 <script src="//static.geetest.com/static/tools/gt.js"></script>
		<script>
                     $("#oreo_login_one").click(function () {	
                        var oreo_user=$("input[name='oreo_user']").val();//账号
						var oreo_pwd=$("input[name='oreo_pwd']").val();//密码
                        var module=<?=$modules;?>;//安全码
                        var adtime=<?=$adtime;?>;//时间戳
                        var codes_one=<?="'$shah'";?>;//验证码
                        var codes_two=<?= "'$safe'" ;?>;//验证码2
                        if(oreo_user=='' || oreo_pwd==''){layer.alert('请确保各项不能为空！');return false;}
						var ii = layer.load(2, {shade: [0.1, '#fff']}); 
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=oreo_auth_login_new",
							data: {oreo_user:oreo_user,oreo_pwd:oreo_pwd,module:module,adtime:adtime,codes_one:codes_one,codes_two:codes_two},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 8) {
									layer.alert('登录成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
                     $("#login_out").click(function () {
                         var ii = layer.load(2, {shade: [0.1, '#fff']});
                         $.ajax({
                             type: "POST",
                             url: "oreo_sub.php?act=Oreo_Out",
                             dataType: 'json',
                             success: function (data) {
                                 layer.close(ii);
                                 if (data.code == 1) {
                                     layer.alert('注销成功', function(index) {
                                         layer.close(index);
                                         location.reload();
                                     })
                                 } else {
                                     layer.alert(data.msg);
                                 }
                             }
                         });
                     });

</script>
</body>
</html>