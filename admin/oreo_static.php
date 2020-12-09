<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?=$conf['web_name']?>控制台</title>
        <link rel="shortcut icon" href="../assets/admin/images/favicon.ico">
        <link href="../assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/admin/css/icons.css" rel="stylesheet" type="text/css">
        <link href="../assets/admin/css/style.css" rel="stylesheet" type="text/css">
       <!-- DataTables -->
        <link href="../assets/admin/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/admin/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="//at.alicdn.com/t/font_1139659_6z0njfyxgti.css">
        <body class="fixed-left">
        <div id="wrapper">
            <div class="left side-menu">
                <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                    <i class="ion-close"></i>
                </button>
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="index.php" class="logo"><i class="mdi mdi-assistant"></i>Oreo支付系统</a>
                    </div>
                </div>
                <div class="sidebar-inner slimscrollleft">
                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">一般</li>
                            <li>
                                <a href="index.php" class="waves-effect">
                                    <i class="mdi mdi-airplay"></i>
                                    <span> 控制台 </span>
                                </a>
                            </li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-multiple"></i> <span> 商户管理 </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="oreo_editable.php">商户/添加/管理</a></li>
                                    <li><a href="oreo_plist.php">添加/管理/合作者</a></li>
									<li><a href="oreo_shcode.php">商户收款码</a></li>
                                </ul>
                            </li>                             
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-apple-keyboard-command"></i> <span> 资金管理 </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span><span class="badge badge-pill badge-primary float-right">
								<?php 
								$usernum=$DB->query("select count(*) as TOTAL from oreo_apply where type='0'")->fetch();
								echo $usernum['TOTAL'];
								?>
								</span></a>
                                <ul class="list-unstyled">
                                    <li><a href="oreo_order.php">订单明细</a></li>
                                    <li><a href="oreo_slist.php">结算记录</a></li>
                                    <li><a href="oreo_settle.php">结算操作</a></li>   
									<li><a href="oreo_sdjs.php">手动结算申请记录</a></li>   
                                </ul>
                            </li>
                               <li>
                                <a href="oreo_work.php" class="waves-effect">
                                    <i class="mdi mdi-account-settings-variant"></i>
                                    <span> 工单系统 </span>
                                </a>
                            </li> 
							 <li>
                                <a href="oreo_notice.php" class="waves-effect">
                                    <i class="mdi mdi-access-point-network"></i>
                                    <span> 平台公告 </span>
                                </a>
                            </li> 
                            <li class="menu-title">核心</li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-xml"></i><span> 系统参数 </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                <li class="has_sub">
                                    <li><a href="oreo_webset.php">站点信息配置</a></li>
                                    <li><a href="oreo_dispatch.php">短信邮箱配置</a></li>
                                    <li><a href="oreo_shlogin.php">商户登录配置</a></li>
                                    <li><a href="oreo_fwtk.php">服务条款配置</a></li>
                                    <li><a href="oreo_shreg.php">申请商户配置</a></li>
                                    <li><a href="oreo_moneyrate.php">盈利费率配置</a></li>
                                    <li><a href="oreo_fukuan.php">结算转账设置</a></li>
                                    <li><a href="oreo_ddcs.php">订单测试设置</a></li>
                                </ul>
                            </li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-shield"></i><span> 安全配置 </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="oreo_safe.php?oreo=intercept">商品拦截配置</a></li>
                                    <li><a href="oreo_safe.php?oreo=log">登录记录</a></li>  
                                </ul>
                            </li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-key"></i><span> 接口管理 </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
								     <li><a href="oreo_orgin.php">参数与回调</a></li>
                                     <li><a href="oreo_payset.php">支付接口通道配置</a></li>
                                     <li><a href="oreo_lxjk.php">轮询接口设置</a></li>
                                </ul>
                            </li>
                               <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-cash-usd"></i><span> 会员功能设置</span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="oreo_vip.php">开通接口设置</a></li>
                                    <li><a href="oreo_vipcx.php">购买列表</a></li>
                                </ul>
                            </li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-shape-square-plus"></i> <span> 外观设置 </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="oreo_template.php">首页模板</a></li>
                                    <li><a href="oreo_logo.php">更改logo</a></li>                
                                </ul>
                            </li>
                            <li>
                                <a href="oreo_jiankong.php" class="waves-effect">
                                    <i class="mdi mdi-airplay"></i>
                                    <span> 监控配置 </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> 
                </div> 
				 <!-- Start right Content here -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <!-- Top Bar Start -->
                    <div class="topbar">
                        <nav class="navbar-custom">
                            <ul class="list-inline float-right mb-0"> 
							 <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                       aria-haspopup="false" aria-expanded="false">
                                        <i class="iconfont icon-tixing" style="font-size: 20px;color: #f7bd01;"></i>
                                        <span class="badge badge-danger noti-icon-badge"><?php 
								$usernum=$DB->query("select count(*) as TOTAL from oreo_apply where type='0'")->fetch();
								echo $usernum['TOTAL'];
								?></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5><span class="badge badge-danger float-right"><?php 
								$usernum=$DB->query("select count(*) as TOTAL from oreo_apply where type='0'")->fetch();
								echo $usernum['TOTAL'];
								?></span>新消息</h5>
                                        </div>
                                            <?php 
$rs=$DB->query("select * from oreo_apply where type='0'");									
while ($res = $rs->fetch()) {
	$usernums=$DB->query("select * from oreo_user where id='{$res['uid']}'")->fetch();
    echo '
	<a href="./oreo_sdjs.php" class="dropdown-item notify-item">
    <div class="notify-icon"><img src="//q3.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$usernums['qq'].'&src_uin='.$usernums['qq'].'&fid='.$usernums['qq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC " alt="user-img" class="img-fluid rounded-circle" /> </div>
    <p class="notify-details"><b>id为：' .$res['uid'].'</b><small class="text-muted">提交手动结算申请.</small></p>
    </a>
	';
}
?>
                                        <!-- item-->
                                        

                                    </div>
                                </li>
                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                                       aria-haspopup="false" aria-expanded="false">
                                        <img src="<?php echo ($conf['web_qq'])?'//q3.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$conf['web_qq'].'&src_uin='.$conf['web_qq'].'&fid='.$conf['web_qq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'assets/images/users/php.jpg'?>" alt="user" class="rounded-circle">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5>欢迎登录</h5>
                                        </div>
                                        <a class="dropdown-item" href="oreo_editable.php"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> 商户列表</a>
                                        <a class="dropdown-item" href="oreo_order.php"><i class="mdi mdi-wallet m-r-5 text-muted"></i> 订单明细</a>
                                        <a class="dropdown-item" href="oreo_webset.php"><i class="mdi mdi-settings m-r-5 text-muted"></i> 站点信息配置</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="./login.php?logout"><i class="mdi mdi-logout m-r-5 text-muted"></i> 安全退出</a>
                                    </div>
                                </li>
                            </ul>
                            <ul class="list-inline menu-left mb-0">
                                <li class="float-left">
                                    <button class="button-menu-mobile open-left waves-light waves-effect">
                                        <i class="mdi mdi-menu"></i>
                                    </button>
                                </li>
                                
                            </ul>
                            <div class="clearfix"></div>
                        </nav>
                    </div>
                    <!-- Top Bar End -->  