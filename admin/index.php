<?php
include("../oreo/Oreo.Cron.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
include("./oreo_static.php");
$count1=$DB->query("SELECT count(*) from oreo_order")->fetchColumn();
$count2=$DB->query("SELECT count(*) from oreo_user")->fetchColumn();
$data=unserialize(file_get_contents(SYSTEM_ROOT.'db.txt'));
?>
<!-- Loader -->
                    <div class="page-content-wrapper ">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="#">控制台</a></li>
                                                <li class="breadcrumb-item active">数据分析</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">数据分析</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->       
                            <div class="row">
                                <!-- Column -->
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="col-3 align-self-center">
                                                    <div class="round">
                                                        <i class="mdi mdi-webcam"></i>
                                                    </div>
                                                </div>
                                                <div class="col-6 align-self-center text-center">
                                                    <div class="m-l-10">
                                                        <h5 class="mt-0 round-inner"><?php echo $data['usermoney']?>￥</h5>
                                                        <h5 class="mb-0 text-muted">总计余额</h5>                                                                 
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                               <!-- Column -->
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="col-3 align-self-center">
                                                    <div class="round">
                                                        <i class="mdi mdi-rocket"></i>
                                                    </div>
                                                </div>
                                                <div class="col-6 align-self-center text-center">
                                                    <div class="m-l-10">
                                                        <h5 class="mt-0 round-inner"><?php echo $data['settlemoney']?>￥</h5>
                                                        <h5 class="mb-0 text-muted">结算金额</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="col-3 align-self-center">
                                                    <div class="round">
                                                        <i class="mdi mdi-account-multiple-plus"></i>
                                                    </div>
                                                </div>
                                                <div class="col-6 text-center align-self-center">
                                                    <div class="m-l-10 ">
                                                        <h5 class="mt-0 round-inner"><?php echo $count2?>位</h5>
                                                        <h5 class="mb-0 text-muted">平台商户</h5>
                                                    </div>
                                                </div>                                          
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="col-3 align-self-center">
                                                    <div class="round ">
                                                        <i class="mdi mdi-basket"></i>
                                                    </div>
                                                </div>
                                                <div class="col-6 align-self-center text-center">
                                                    <div class="m-l-10 ">
                                                        <h5 class="mt-0 round-inner"><?php echo $count1?>笔</h5>
                                                        <h5 class="mb-0 text-muted">订单总数</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>                                                                                                                                           
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-xl-8 align-self-center">
                                    <div class="card bg-white m-b-30">
                                        <div class="card-body new-user">
                                            <h5 class="header-title mb-4 mt-0">支付通道订单明细</h5>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-top-0" style="width:60px;">排序</th>
                                                            <th class="border-top-0">名称</th>
                                                            <th class="border-top-0">今日收益</th>
                                                            <th class="border-top-0">昨日收益</th>                                    
                                                            <th class="border-top-0">同比(百分比)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <img class="rounded-circle" src="../assets/images/users/alipay.jpeg" alt="user" width="40"> </td>
                                                            <td>
                                                                <a href="javascript:void(0);">支付宝</a>
                                                            </td>
                                                            <td><?php echo round($data['order_today']['alipay'],2)?></td>
                                                            <td><?php echo round($data['order_lastday']['alipay'],2)?></td>  
                                                            <td><?php $tuday=round($data['order_today']['alipay'],2);
                                                                      $yesterday=round($data['order_lastday']['alipay'],2);
                                                                      $tb1=round($tuday-$yesterday); 
                                                                      $tb2=round($tb1/$yesterday*100);
                                                                      echo round($tb2) ?>%</td>   
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                 <img class="rounded-circle" src="../assets/images/users/weixin.jpeg" alt="user" width="40"> </td>
                                                            <td>
                                                                <a href="javascript:void(0);">微信支付</a>
                                                            </td>
                                                            <td><?php echo round($data['order_today']['wxpay'],2)?></td>
                                                            <td><?php echo round($data['order_lastday']['wxpay'],2)?></td>                                   
                                                            <td><?php $tuday=round($data['order_today']['wxpay'],2);
                                                                      $yesterday=round($data['order_lastday']['wxpay'],2);
                                                                      $tb1=round($tuday-$yesterday,2); 
                                                                      $tb2=round($tb1/$yesterday*100,2);
                                                                      echo round($tb2,2) ?>%</td> 
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                               <img class="rounded-circle" src="../assets/images/users/qq.jpeg" alt="user" width="40"> </td>
                                                            <td>
                                                                <a href="javascript:void(0);">QQ钱包</a>
                                                            </td>
                                                            <td><?php echo round($data['order_today']['qqpay'],2)?></td>
                                                            <td><?php echo round($data['order_lastday']['qqpay'],2)?></td>                                   
                                                            <td><?php $tuday=round($data['order_today']['qqpay'],2);
                                                                      $yesterday=round($data['order_lastday']['qqpay'],2);
                                                                      $tb1=round($tuday-$yesterday,2); 
                                                                      $tb2=round($tb1/$yesterday*100,2);
                                                                       echo round($tb2,2) ?>%</td> 
                                                       
                                                        </tr>
                                                        <tr >
                                                            <td>
                                                               <img class="rounded-circle" src="../assets/images/users/total.jpg" alt="user" width="40"> </td>
                                                            <td>
                                                                <a href="javascript:void(0);">总计</a>
                                                            </td>                                                
                                                            <td><?php echo round($data['order_today']['all'],2)?></td>
                                                            <td><?php echo round($data['order_lastday']['all'],2)?></td>                                   
                                                            <td><?php $tuday=round($data['order_today']['all'],2);
                                                                      $yesterday=round($data['order_lastday']['all'],2);
                                                                      $tb1=round($tuday-$yesterday,2); 
                                                                      $tb2=round($tb1/$yesterday*100,2);
                                                                       echo round($tb2,2) ?>%</td> 
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-4">
                               <div class="card bg-white m-b-30">
                                        <div class="card-body new-user">
                                            <h5 class="header-title mb-4 mt-0">来自Oreo的反馈信息</h5>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-top-0">排序</th>
                                                            <th class="border-top-0">名称</th>
                                                            <th class="border-top-0">结果</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <img class="rounded-circle" src="../assets/images/users/yxsj.jpg" alt="user" width="40"> </td>
                                                            <td>
                                                                <a href="javascript:void(0);">检查新版本</a>
                                                            </td>
                                                            <td>【捐赠版V2.2】</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                    </div> <!-- Page content Wrapper -->
                </div> <!-- content -->
          <?php include'foot.php';?>
<script>
$('<audio id="audio"><source src="notice.mp3" type="audio/mp3"></audio>').appendTo('body');  
var audio = $("#audio")[0]; 
var time = 0;
$(document).ready(function(){
settime();
});
function settime(){
if(time == 12){
notice();
time = 0;settime();
}else{

setTimeout(function(){time++;settime();},1000);
}
}
function notice(){
$.ajax({
type:'post',
url:"oreo_sub.php?act=mp3_apply",
dataType:'json',
data:{},
success:function(data){
//alert(json);
if(data.code == 1){
notice_window();
}
//console.log(json);
},
error:function(){

}
});
}
function notice_window(){
$('#notice').click();audio.play();setTimeout(function(){$('#notice').click();},10000);

}

</script>
    </body>
</html>