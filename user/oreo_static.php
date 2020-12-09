<?php 
//禁止多地登录和验证登录token
if($_SESSION['login_token']!=$userrow['login_token']){
    $_SESSION = array(); 
    session_start();  
    setcookie("user_token", "", time() - 1);
    setcookie("credit_token", "", time() - 1);
    session_destroy(); 
    @header('Content-Type: text/html; charset=UTF-8'); 
exit("<script language='javascript'>alert('您的账号已在别处登录');window.location.href='../';</script>");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $conf['web_name']; ?> - 商户后台面板</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/newuser/images/favicon.ico">
        <!-- third party css -->
        <link href="../assets/newuser/css/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- third party css end -->
        <!-- App css -->
        <link href="../assets/newuser/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/newuser/css/app.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <!-- Topbar Start -->
        <div class="navbar-custom topnav-navbar">
            <div class="container-fluid">
                <!-- LOGO -->
				<a class="button-menu-mobile disable-btn">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>                    </div>
                </a>
                <a href="index.php" class="topnav-logo">
                    <span class="topnav-logo-lg">
                        <img src="../assets/newuser/images/logo-light.png" alt="" height="16">  </span>
                    <span class="topnav-logo-sm">
                        <img src="../assets/newuser/images/logo_sm.png" alt="" height="16">  </span>   </a>
                <ul class="list-unstyled topbar-right-menu float-right mb-0">
					<li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="account-user-avatar"> 
                                <img src="<?php echo ($userrow['qq'])?'//q3.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$userrow['qq'].'&src_uin='.$userrow['qq'].'&fid='.$userrow['qq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'/assets/images/team-1.jpg'?>" alt="user-image" class="rounded-circle">                            </span>
                            <span>
                                <span class="account-user-name"><?php echo $userrow['username'];?></span>
                                <span class="account-position">UID:<?php echo $pid?></span>                            </span>                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">欢迎光临 !</h6>
                            </div>
                            <!-- item-->
                            <a href="./oreo_vip.php" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-circle mr-1"></i>
                                <span>会员中心</span>                            </a>
                            <!-- item-->
                            <a href="./oreo_order.php" class="dropdown-item notify-item">
                                <i class="mdi mdi-currency-cny"></i>
                                <span>订单明细</span>                            </a>
                            <!-- item-->
                            <a href="./oreo_apply.php" class="dropdown-item notify-item">
                                <i class="mdi mdi-code-tags-check"></i>
                                <span>手动结算</span>                            </a>
                            <!-- item-->
                            <a href="./login.php?logout" class="dropdown-item notify-item">
                                <i class="mdi mdi-axis-arrow-lock"></i>
                                <span>安全退出</span>                            </a>                        </div>
                    </li>
                </ul>
                
            </div>
        </div>
        <div class="container-fluid">
            <div class="wrapper">
                <div class="left-side-menu">
                    <div class="leftbar-user">
                        <a href="#">
                            <img src="<?php echo ($userrow['qq'])?'//q3.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$userrow['qq'].'&src_uin='.$userrow['qq'].'&fid='.$userrow['qq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'/assets/images/team-1.jpg'?>" alt="user-image" height="42" class="rounded-circle shadow-sm">
                            <span class="leftbar-user-name"><?php echo $userrow['username'];?></span>                        </a>                    </div>
                    <!--- Sidemenu -->
                    <ul class="metismenu side-nav">
                        <li class="side-nav-title side-nav-item">基本</li>
                         <li class="side-nav-item">
                            <a href="index.php" class="side-nav-link">
                                <i class="dripicons-meter"></i>
                                <span class="badge badge-light float-right"></span>
                                <span> 控制台 </span>                            </a>                        </li>
                        <li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="dripicons-view-apps"></i>
                                <span> 订单与结算 </span>
                                <span class="menu-arrow"></span>                            </a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="oreo_order.php">订单明细</a>                                </li>
                                <li>
                                    <a href="oreo_settle.php">结算明细</a>                                </li>
								 <li>
                                    <a href="oreo_apply.php">手动结算</a>                                </li>	
                                
                            </ul>
                        </li>
                        <li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="dripicons-copy"></i>
                                <span> 商户信息 </span>
                                <span class="menu-arrow"></span>                            </a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="oreo_vip.php">会员中心</a>                                </li>
                                <? if($conf['chaojivip']==1||$conf['alivip']==1||$conf['wxvip']==1||$conf['qqvip']==1){?>
                                    <li> <a href="oreo_shop.php">开通接口</a></li><?}?>
                            </ul>
                        </li>

						 <li class="side-nav-item">
                            <a href="oreo_work.php" class="side-nav-link">
                                <i class="mdi mdi-console-network"></i>
                                <span> 工单系统 </span>                            </a>                        </li>
								 <li class="side-nav-item">
                            <a href="oreo_cz.php" class="side-nav-link">
                                <i class="mdi mdi-altimeter"></i>
                                <span> 订单测试 </span>                            </a>                        </li>
								 <li class="side-nav-item">
							<a class="side-nav-link" onclick="return confirm('进群可获取平台最新信息，请在进群验证信息中填写您的商户ID，点击确定立即加群！')" href="<?php echo $conf['web_lj']?>" target="blank">	 
                                <i class="mdi mdi-account-multiple"></i>
                                <span> 商户群聊 </span>                            </a>                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>