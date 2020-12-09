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
                                                <li class="breadcrumb-item"><a href="#">商户管理</a></li>
                                                <li class="breadcrumb-item active">商户列表</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">商户列表</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                             <div class="row mb-2">
                                            <div class="col-lg-8">
                                                <form class="form-inline" method="post" action="oreo_editable.php">
                                                    <div class="form-group mb-2">
                                                        <label for="inputPassword2" class="sr-only">搜索</label>
                                                        <input type="search"  name="my" class="form-control"  placeholder="搜索...">
                                                    </div>
                                                    <div class="form-group mx-sm-3 mb-2">
                                                        <select class="custom-select" name="column" >
                                                            <option selected>请选择...</option>
                                                            <option value="id">商户号</option>
                                                            <option value="username">姓名</option>
                                                            <option value="QQ">用户QQ</option>
                                                            <option value="money">余额</option>
                                                            <option value="account">结算账号</option>
															<option value="url">介入域名</option>
															<option value="email">邮箱</option>
															<option value="phone">手机号码</option>
                                                        </select>
                                                    </div>                       
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="text-lg-right">
                                                    <button type="submit" name="submit" class="btn btn-secondary  mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i>搜索</button>
													<a data-toggle="modal" data-target="#tianjia" data-id="tianjia"  class="btn btn-success mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i>添加商户</a>
                                                    <a data-toggle="modal" data-target="#shanghujk" data-id="shanghujk" class="btn btn-warning mb-2 mr-2"><i class="mdi mdi-bolnisi-cross"></i>商户加款</a>
												</div>
                                            </div><!-- end col-->
                                        </div></form> 
										<div class="table-responsive">
                                            <table class="table table-bordered text-nowrap">
                                                <thead>
                                                <tr>
                                                <th>ID</th>
				<th style="display: none">结算方式</th>
                <th>姓名</th>
				<th style="display: none">密钥</th>
				<th style="display: none">邮箱</th>
          		<th>用户QQ</th>
                <th>余额</th>
				<th style="display: none">密码</th>
				<th style="display: none">自定义费率</th>
				<th style="display: none">费率</th>
				<th style="display: none">支付宝费率</th>
				<th style="display: none">微信费率</th>
				<th style="display: none">QQ费率</th>
				<th style="display: none">是否结算</th>
				<th style="display: none">是否重置密钥</th>
          		<th>结算账号</th>
          		<th>支付宝</th>
		        <th>微信支付</th>
		        <th>QQ钱包</th>
                <th>接入域名</th>
          		<th>添加时间</th>
          		<th>状态</th>
				<th style="display: none">是否重置密钥</th>
				<th style="display: none">是否重置密钥</th>
				<th style="display: none">手机号码</th>
          		<th>操作</th>               
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
if(isset($_POST['submit'])) {

	if($_POST['column']=='name'){
		$sql="`{$_POST['column']}` like '%{$_POST['my']}%'";
	}else{
		$sql="`{$_POST['column']}`='{$_POST['my']}'";
	}
}else{
	$sql=" 1";
	$numrows=$DB->query("SELECT count(*) from oreo_user WHERE{$sql}")->fetchColumn();
	$link='&my=search&column='.$_POST['column'].'&value='.$_POST['my'];
	}	
										

$pagesize=10;
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
{
 $pages++;
 }
if (isset($_GET['page'])){
$page=intval($_GET['page']);
}
else{
$page=1;
}
$offset=$pagesize*($page - 1);
$list=$DB->query("SELECT * FROM oreo_user WHERE{$sql} order by id desc limit $offset,$pagesize");				
while($res = $list->fetch())
{
echo '<tr>
<td><a class="btn btn-xs btn-info" >'.$res['id'].'</a></td>
<td style="display: none">'.$res['settle_id'].'</td>
<td>'.$res['username'].'</td>
<td style="display: none;">'.$res['key'].'</td>
<td style="display: none;">'.$res['email'].'</td>
<td>'.$res['qq'].'</td>
<td>'.$res['money'].'</td>
<td style="display: none;">'.$res['password'].'</td>
<td style="display: none;">'.$res['zdyfl'].'</td>
<td style="display: none;">'.$res['rate'].'</td>
<td style="display: none;">'.$res['salipay_rate'].'</td>
<td style="display: none;">'.$res['sweixin_rate'].'</td>
<td style="display: none;">'.$res['sqq_rate'].'</td>
<td style="display: none;">'.$res['type'].'</td>
<td style="display: none;">'.$res['resetkey'].'</td>
<td>'.($res['settle_id']==2?'<a class="btn btn-xs btn-default">微信</a>:':null).($res['settle_id']==3?'<a class="btn btn-xs btn-default">QQ</a>:':null).$res['account'].'</td>
<td>'.($res['alipay']==1?'<a  data-toggle="modal" data-target="#paytypali" data-id="paytyp"  class="btn btn-xs btn-info">当前:正常</a>':null).($res['alipay']==2?'<a data-toggle="modal" data-target="#paytypalig" data-id="paytypalig" class="btn btn-xs btn-danger">当前:关闭</a>':null).'</td>
<td>'.($res['wxpay']==1?'<a data-toggle="modal" data-target="#paytypwx" data-id="paytyp"  class="btn btn-xs btn-info">当前:正常</a>':null).($res['wxpay']==2?'<a data-toggle="modal" data-target="#paytypwxg" data-id="paytypwxg" class="btn btn-xs btn-danger">当前:关闭</a>':null).'</td>
<td>'.($res['qqpay']==1?'<a data-toggle="modal" data-target="#paytypqq" data-id="paytyp"  class="btn btn-xs btn-info">当前:正常</a>':null).($res['qqpay']==2?'<a data-toggle="modal" data-target="#paytypqqg" data-id="paytypqqg" class="btn btn-xs btn-danger">当前:关闭</a>':null).'</td>
<td>'.$res['url'].'</td> 
<td>'.$res['addtime'].'</td>
<td style="display: none;">'.$res['active'].'</td>
<td>'.($res['active']==1?'<a class="btn btn-xs btn-success">正常</a>':'<a class="btn btn-xs btn-danger">封禁</a>').'</td>	
<td style="display: none;">'.$res['account'].'</td> 
<td style="display: none;">'.$res['phone'].'</td> 
<td>
<form target="_blank"  id="'.$res['id'].'" name="'.$res['id'].'" action="../user/login.php" method="POST" >
<input type="hidden" name="user" value="'.$res['id'].'"/>
<input type="hidden" name="admin_pass" value="'.$res['password'].'"/>
<button type="submit" class="btn btn-xs btn-info">登录</button>
&nbsp;<a data-toggle="modal" data-target="#bianji" data-id="bianji" class="btn btn-xs btn-info">编辑</a>&nbsp;<a data-toggle="modal" data-target="#shanchu" data-id="shanchu" class="btn btn-xs btn-danger" >删除</a></form></td></tr>';
}
?>
                                                
                                               
                                                </tbody>
                                            </table>
											</div>
            					<nav style="float: inline-end;">
<?php
echo'<ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li class="page-item"><a class="page-link" href="oreo_editable.php?page='.$first.$link.'">首页</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_editable.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">首页</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_editable.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="page-item active"><a class="page-link">'.$page.'</a></li>';
if($pages>=3)$s=3;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li class="page-item"><a class="page-link" href="oreo_editable.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li class="page-item"><a class="page-link" href="oreo_editable.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li class="page-item"><a class="page-link" href="oreo_editable.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="page-item"><a class="page-link">尾页</a></li>';
}
echo'</ul>';
#分页
?>
                                                </nav>
                                        </div>
                                </div> <!-- end col -->
                           </div> <!-- end row -->
                        </div><!-- container -->
						<div class="modal fade bs-example-modal-center"   id="bianji" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">编辑商户信息</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="id" readonly="readonly"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>结算方式</label>
                                                    <div>
                                                    <select class="form-control ca1" name="settle_id" id="settle_id">
                                                    <option value="1" >支付宝</option>
                                                    <option value="2" >微信支付</option>  
													<option value="3" >QQ钱包</option>
													<option value="4" >银行卡</option>
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>结算账号</label>
                                                    <div>
													<input type="text" class="form-control ca23" name="account"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>结算账号姓名</label>
                                                    <div>
													<input type="text" class="form-control ca2" name="username"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>自定义商户密匙(key)</label>
                                                    <div>
													<input type="text" class="form-control ca3" name="key"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>商户余额</label>
                                                    <div>
													<input type="text" class="form-control ca6" name="money"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>网站域名</label>
                                                    <div>
													<input type="text" class="form-control ca19" name="url"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>邮箱</label>
                                                    <div>
													<input type="text" class="form-control ca4" name="email"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>QQ号码</label>
                                                    <div>
													<input type="text" class="form-control ca5" name="qq"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>手机号码</label>
                                                    <div>
													<input type="text" class="form-control ca24" name="phone" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>登录密码</label>
                                                    <div>
													<input type="password" class="form-control ca7" name="password"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>是否自定义费率</label>
                                                    <div>
                                                    <select class="form-control ca8" name="zdyfl" id="zdyfl" onchange="zdy('fl',this.value)">
                                                    <option value="0" <?=$userrow['zdyfl']==0?"selected":""?>>否</option>
                                                    <option value="1" <?=$userrow['zdyfl']==1?"selected":""?> >是</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div  id="fl_v"  style="<?php echo $userrow['zdyfl'] == 0 ? "" : "display: none;";?>">
												<div class="form-group">
                                                     <input type="text" class="form-control" value="当平台给商户开启单笔费率，请一定要设置以下的几个费率"  disabled="disabled"  >
                                                </div>
												<div class="form-group">
                                                    <label>自定义分成比例</label>
                                                    <div>
													<input type="text" class="form-control ca9" name="rate" placeholder="填写百分数，例如98.5"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>支付宝费率</label>
                                                    <div>
													<input type="text" class="form-control ca10" name="salipay_rate" placeholder="填写百分数，例如98.5"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>微信费率</label>
                                                    <div>
													<input type="text" class="form-control ca11" name="sweixin_rate" placeholder="填写百分数，例如98.5"/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>QQ钱包费率</label>
                                                    <div>
													<input type="text" class="form-control ca12" name="sqq_rate" placeholder="填写百分数，例如98.5"/>
                                                    </div>
                                                </div>
												</div>
												<div class="form-group">
                                                    <label>是否结算</label>
                                                    <div>
                                                    <select class="form-control ca13" name="type" id="type">
                                                    <option value="1" >是</option>
                                                    <option value="2" >否</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>是否激活</label>
                                                    <div>
                                                    <select class="form-control ca21" name="active" id="active">
                                                    <option value="1" >是</option>
                                                    <option value="0" >否</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>是否重置密钥</label>
                                                    <div>
                                                    <select class="form-control" name="resetkey" id="resetkey">
                                                    <option value="0" >否</option>  
													<option value="1" >是</option>
                                                    </select>
                                                    </div>
                                                </div>
												 <div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="xiugai"  value="提交" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                    </div>
                                                </div>
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->	
								   <div class="modal fade bs-example-modal-center"   id="shanchu" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的操作</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="ids" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>账户当前余额:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca6"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="shanchul"  value="提交" class="btn btn-danger waves-effect" >
                                                            确认删除账户
                                                        </button>
                                                    </div>
                                                </div>
												
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->	
								   <div class="modal fade bs-example-modal-center"   id="tianjia" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">添加商户</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
												<div class="form-group">
                                                    <label>结算方式</label>
                                                    <div>
                                                    <select class="form-control" name="settle_ida" id="settle_ida">
                                                    <option value="1" >支付宝</option>
                                                    <option value="2" >微信支付</option>  
													<option value="3" >QQ钱包</option>
													<option value="4" >银行卡</option>
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>结算账号</label>
                                                    <div>
													<input type="text" class="form-control" name="accounta" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>结算账号姓名</label>
                                                    <div>
													<input type="text" class="form-control" name="usernamea" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>商户余额</label>
                                                    <div>
													<input type="text" class="form-control" name="moneya" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>网站域名</label>
                                                    <div>
													<input type="text" class="form-control" name="urla" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>邮箱</label>
                                                    <div>
													<input type="text" class="form-control" name="emaila" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>QQ号码</label>
                                                    <div>
													<input type="text" class="form-control" name="qqa" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>手机号码</label>
                                                    <div>
													<input type="text" class="form-control" name="phonea" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>登录密码</label>
                                                    <div>
													<input type="password" class="form-control" name="passworda" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>是否自定义费率</label>
                                                    <div>
                                                    <select class="form-control" name="zdyfl" id="zdyfl" onchange="zdy('flt',this.value)">
                                                    <option value="0" <?=$conf['zdyfl']==0?"selected":""?>>否</option>
                                                    <option value="1" <?=$conf['zdyfl']==1?"selected":""?> >是</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div  id="flt_v"  style="<?php echo $conf['zdyfl'] == 1 ? "" : "display: none;";?>">
												<div class="form-group">
                                                     <input type="text" class="form-control" value="当平台给商户开启单笔费率，请一定要设置以下的几个费率"  disabled="disabled"  >
                                                </div>
												<div class="form-group">
                                                    <label>自定义分成比例</label>
                                                    <div>
													<input type="text" class="form-control" name="ratea" placeholder="填写百分数，例如98.5" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>支付宝费率</label>
                                                    <div>
													<input type="text" class="form-control" name="salipay_ratea" placeholder="填写百分数，例如98.5" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>微信费率</label>
                                                    <div>
													<input type="text" class="form-control" name="sweixin_ratea" placeholder="填写百分数，例如98.5" value=""/>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>QQ钱包费率</label>
                                                    <div>
													<input type="text" class="form-control" name="sqq_ratea" placeholder="填写百分数，例如98.5" value=""/>
                                                    </div>
                                                </div>
												</div>
												<div class="form-group">
                                                    <label>是否结算</label>
                                                    <div>
                                                    <select class="form-control" name="type" id="type">
                                                    <option value="1" >是</option>
                                                    <option value="2" >否</option>  
                                                    </select>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>是否激活</label>
                                                    <div>
                                                    <select class="form-control" name="active" id="active">
                                                    <option value="1" >是</option>
                                                    <option value="0" >否</option>  
                                                    </select>
                                                    </div>
                                                </div>
												 <div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="xtianjia"  value="提交" class="btn btn-primary waves-effect waves-light" >
                                                            提交
                                                        </button>
                                                    </div>
                                                </div>
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->
                                    <div class="modal fade bs-example-modal-center"   id="shanghujk" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的操作</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control" name="jkid" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>加款余额:</label>
                                                    <div>
                                                      <input type="text" class="form-control" name="jkje"  />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>加款扣除手续费:</label>
                                                    <div>
                                                      <input type="text" class="form-control" name="jksxf" placeholder="不得为0，填写百分数，例如98.5，如免手续费写100"  /> 
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
														<button type="button" id="shjiakuan"  value="提交" class="btn btn-primary waves-effect waves-light" >
                                                            确认加款
                                                        </button>
                                                    </div>
                                                </div>
												
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->	
                                    <div class="modal fade bs-example-modal-center"   id="paytypali" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的操作</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="typidk" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>当前状态:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca16"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="paytypalis"  value="提交" class="btn btn-danger waves-effect" >
                                                            确认关闭
                                                        </button>
                                                    </div>
                                                </div>
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->	
                                  <div class="modal fade bs-example-modal-center"   id="paytypwx" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的操作</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="typidkwx" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>当前状态:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca17"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="paytypwxs"  value="提交" class="btn btn-danger waves-effect" >
                                                            确认关闭
                                                        </button>
                                                    </div>
                                                </div>
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->	
								   <div class="modal fade bs-example-modal-center"   id="paytypqq" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的操作</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="typidkqq" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>当前状态:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca18"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="paytypqqs"  value="提交" class="btn btn-danger waves-effect" >
                                                            确认关闭
                                                        </button>
                                                    </div>
                                                </div>
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->
								   <div class="modal fade bs-example-modal-center"   id="paytypalig" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的操作</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="typidkalik" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>当前状态:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca18"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="paytypalik"  value="提交" class="btn btn-primary waves-effect waves-light">
                                                            确认开启
                                                        </button>
                                                    </div>
                                                </div>
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->
								   <div class="modal fade bs-example-modal-center"   id="paytypwxg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的操作</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="typidkwxk" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>当前状态:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca18"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="paytypwxk"  value="提交" class="btn btn-primary waves-effect waves-light" >
                                                            确认开启
                                                        </button>
                                                    </div>
                                                </div>
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->
								    <div class="modal fade bs-example-modal-center"   id="paytypqqg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-centered">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLabel">请确认您的操作</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                                 </button>
                                                  </div>
                                                   <div class="modal-body">
                                                   <div class="form-group">
                                                    <label>商户ID:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca0" name="typidkqqk" readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label>当前状态:</label>
                                                    <div>
                                                      <input type="text" class="form-control ca18"  readonly="readonly" />
                                                    </div>
                                                </div>
												<div class="form-group m-b-0">
                                                    <div>
                                                        <button type="button" id="paytypqqk"  value="提交" class="btn btn-primary waves-effect waves-light" >
                                                            确认开启
                                                        </button>
                                                    </div>
                                                </div>
                                              </div>
                                           </div><!-- /.modal-content -->
                                       </div><!-- /.modal-dialog -->
                                   </div><!-- /.modal -->
                    </div> <!-- Page content Wrapper -->
                </div> <!-- content -->
                  <?php include'foot.php';?>
		<script>
	function zdy(type,val){
    var fl  = $("#"+type+"_v");
	var flt  = $("#"+type+"_v");
    if(val == 0){
       $(fl). hide()
	   $(flt). hide()
    }
    if(val == 1){
       $(fl).show()
	   $(flt).show()
    }        
}	
	 $('#bianji').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(1).text();
      modal.find('.ca1').val(content);
	  var content = btnThis.closest('tr').find('td').eq(2).text();
      modal.find('.ca2').val(content);
	  var content = btnThis.closest('tr').find('td').eq(3).text();
      modal.find('.ca3').val(content);
	  var content = btnThis.closest('tr').find('td').eq(4).text();
      modal.find('.ca4').val(content);
	  var content = btnThis.closest('tr').find('td').eq(5).text();
      modal.find('.ca5').val(content);
	  var content = btnThis.closest('tr').find('td').eq(6).text();
      modal.find('.ca6').val(content);
	  var content = btnThis.closest('tr').find('td').eq(7).text();
      modal.find('.ca7').val(content);
	  var content = btnThis.closest('tr').find('td').eq(8).text();
      modal.find('.ca8').val(content);
	  var content = btnThis.closest('tr').find('td').eq(9).text();
      modal.find('.ca9').val(content);
	  var content = btnThis.closest('tr').find('td').eq(10).text();
      modal.find('.ca10').val(content);
	  var content = btnThis.closest('tr').find('td').eq(11).text();
      modal.find('.ca11').val(content);
	  var content = btnThis.closest('tr').find('td').eq(12).text();
      modal.find('.ca12').val(content);
	  var content = btnThis.closest('tr').find('td').eq(13).text();
      modal.find('.ca13').val(content);
	  var content = btnThis.closest('tr').find('td').eq(14).text();
      modal.find('.ca14').val(content);
	  var content = btnThis.closest('tr').find('td').eq(15).text();
      modal.find('.ca15').val(content);
	  var content = btnThis.closest('tr').find('td').eq(16).text();
      modal.find('.ca16').val(content);
	  var content = btnThis.closest('tr').find('td').eq(17).text();
      modal.find('.ca17').val(content);
	  var content = btnThis.closest('tr').find('td').eq(18).text();
      modal.find('.ca18').val(content);
	  var content = btnThis.closest('tr').find('td').eq(19).text();
      modal.find('.ca19').val(content);
	  var content = btnThis.closest('tr').find('td').eq(20).text();
      modal.find('.ca20').val(content);
	  var content = btnThis.closest('tr').find('td').eq(21).text();
      modal.find('.ca21').val(content);
	  var content = btnThis.closest('tr').find('td').eq(22).text();
      modal.find('.ca22').val(content);
	  var content = btnThis.closest('tr').find('td').eq(23).text();
      modal.find('.ca23').val(content);
	  var content = btnThis.closest('tr').find('td').eq(24).text();
      modal.find('.ca24').val(content);
	 
});
 $('#shanchu').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(6).text();
      modal.find('.ca6').val(content);
	 
});
$('#paytypali').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(16).text();
      modal.find('.ca16').val(content);
	 
});
$('#paytypwx').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(17).text();
      modal.find('.ca17').val(content);
	 
});
$('#paytypqq').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(18).text();
      modal.find('.ca18').val(content);
	 
});
$('#paytypalig').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(18).text();
      modal.find('.ca18').val(content);
	 
});
$('#paytypwxg').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(18).text();
      modal.find('.ca18').val(content);
	 
});
$('#paytypqqg').on('show.bs.modal', function (event) {
      var btnThis = $(event.relatedTarget); //触发事件的按钮
      var modal = $(this);  //当前模态框
      var modalId = btnThis.data('id');   //解析出data-id的内容
      var content = btnThis.closest('tr').find('td').eq(0).text();
      modal.find('.ca0').val(content); 
      var content = btnThis.closest('tr').find('td').eq(18).text();
      modal.find('.ca18').val(content);
	 
});
                        $("#xiugai").click(function () {
						var id=$("input[name='id']").val();
						var settle_id = $("#settle_id").val();   
						var account=$("input[name='account']").val();
						var username=$("input[name='username']").val();
						var key=$("input[name='key']").val();
						var money=$("input[name='money']").val();
						var url=$("input[name='url']").val();
						var email=$("input[name='email']").val();
						var qq=$("input[name='qq']").val();
						var phone=$("input[name='phone']").val();
						var password=$("input[name='password']").val();
						var zdyfl = $("#zdyfl").val();
						var rate=$("input[name='rate']").val();
						var salipay_rate=$("input[name='salipay_rate']").val();
						var sweixin_rate=$("input[name='sweixin_rate']").val();
						var sqq_rate=$("input[name='sqq_rate']").val();
						var type = $("#type").val();
						var active = $("#active").val();
						var resetkey = $("#resetkey").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Xiugai",
							data: {id:id,settle_id:settle_id,account:account,username:username,key:key,money:money,url:url,email:email,qq:qq,phone:phone,password:password,zdyfl:zdyfl,rate:rate,salipay_rate:salipay_rate,sweixin_rate:sweixin_rate,sqq_rate:sqq_rate,type:type,active:active,resetkey:resetkey},
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
					$("#shanchul").click(function () {
						var ids=$("input[name='ids']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Shanchu",
							data: {ids:ids},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('删除成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					}); 
					$("#xtianjia").click(function () {
						var settle_id = $("#settle_ida").val();   
						var accounta=$("input[name='accounta']").val();
						var usernamea=$("input[name='usernamea']").val();
						var moneya=$("input[name='moneya']").val();
						var urla=$("input[name='urla']").val();
						var emaila=$("input[name='emaila']").val();
						var qqa=$("input[name='qqa']").val();
						var phonea=$("input[name='phonea']").val();
						var passworda=$("input[name='passworda']").val();
						var zdyfl = $("#zdyfl").val();
						var ratea=$("input[name='ratea']").val();
						var salipay_ratea=$("input[name='salipay_ratea']").val();
						var sweixin_ratea=$("input[name='sweixin_ratea']").val();
						var sqq_ratea=$("input[name='sqq_ratea']").val();
						var type = $("#type").val();
						var active = $("#active").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Xtianjia",
							data: {settle_id:settle_id,accounta:accounta,usernamea:usernamea,moneya:moneya,urla:urla,emaila:emaila,qqa:qqa,phonea:phonea,passworda:passworda,zdyfl:zdyfl,ratea:ratea,salipay_ratea:salipay_ratea,sweixin_ratea:sweixin_ratea,sqq_ratea:sqq_ratea,type:type,active:active},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert(data.msg, function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							} 
						});
					});
					$("#shjiakuan").click(function () {
						var jkid=$("input[name='jkid']").val();
						var jkje=$("input[name='jkje']").val();
						var jksxf=$("input[name='jksxf']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Shujku",
							data: {jkid:jkid,jkje:jkje,jksxf:jksxf},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == -1) {
									layer.alert(data.msg);
								} else {
									layer.alert(data.msg, function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								}
							}
						});
					}); 
					$("#paytypalis").click(function () {
						var typidk=$("input[name='typidk']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Kpaytypali",
							data: {typidk:typidk},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('关闭成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					}); 
					$("#paytypwxs").click(function () {
						var typidkwx=$("input[name='typidkwx']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Kpaytypwx",
							data: {typidkwx:typidkwx},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('关闭成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});
                    $("#paytypqqs").click(function () {
						var typidkqq=$("input[name='typidkqq']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Kpaytypqq",
							data: {typidkqq:typidkqq},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('关闭成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					}); 
                    $("#paytypalik").click(function () {
						var typidkalik=$("input[name='typidkalik']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Kpaytypalik",
							data: {typidkalik:typidkalik},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开启成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});	
					$("#paytypwxk").click(function () {
						var typidkwxk=$("input[name='typidkwxk']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Kpaytypwxk",
							data: {typidkwxk:typidkwxk},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开启成功', function(index) {
                                    layer.close(index);
                                    location.reload();
                                    })
								} else {
									layer.alert(data.msg);
								}
							}
						});
					});	
					$("#paytypqqk").click(function () {
						var typidkqqk=$("input[name='typidkqqk']").val();
						var ii = layer.load(2, {shade: [0.1, '#fff']});
						$.ajax({
							type: "POST",
							url: "oreo_sub.php?act=edit_Kpaytypqqk",
							data: {typidkqqk:typidkqqk},
							dataType: 'json',
							success: function (data) {
								layer.close(ii);
								if (data.code == 1) {
									layer.alert('开启成功', function(index) {
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