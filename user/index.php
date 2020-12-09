<?php
include("../oreo/Oreo.Cron.php");
if($islogin2 != 1){exit("<script language='javascript'>window.location.href='./login.php';</script>");}
include("./oreo_static.php");
$orders=$DB->query("SELECT count(*) from oreo_order WHERE pid={$pid}")->fetchColumn();
$lastday=date("Ymd",strtotime("-1 day")).'00000000000';
$today=date("Ymd").'00000000000';
$order_today['alipay']=$DB->query("SELECT sum(money) from oreo_order where pid={$pid} and status=1 and trade_no>='$today' and type='alipay'")->fetchColumn();
$order_today['wxpay']=$DB->query("SELECT sum(money) from oreo_order where pid={$pid} and status=1 and trade_no>='$today' and type='wxpay'")->fetchColumn();
$order_today['qqpay']=$DB->query("SELECT sum(money) from oreo_order where pid={$pid} and status=1 and trade_no>='$today' and type='qqpay'")->fetchColumn();
$order_lastday['alipay']=$DB->query("SELECT sum(money) from oreo_order where pid={$pid} and status=1 and trade_no>='$lastday' and trade_no<'$today' and type='alipay'")->fetchColumn();
$order_lastday['wxpay']=$DB->query("SELECT sum(money) from oreo_order where pid={$pid} and status=1 and trade_no>='$lastday' and trade_no<'$today' and type='wxpay'")->fetchColumn();
$order_lastday['qqpay']=$DB->query("SELECT sum(money) from oreo_order where pid={$pid} and status=1 and trade_no>='$lastday' and trade_no<'$today' and type='qqpay'")->fetchColumn();
$order_today['all']=$DB->query("SELECT sum(money) from oreo_order where pid={$pid} and status=1 and trade_no>='$today'")->fetchColumn();
$order_lastday['all']=$DB->query("SELECT sum(money) from oreo_order where pid={$pid} and status=1 and trade_no>='$lastday' and trade_no<'$today'")->fetchColumn();
$rs=$DB->query("SELECT * from oreo_settle where pid={$pid} and status=1");
$ressz=$DB->query("SELECT sum(money) FROM `oreo_apply` where uid={$pid} and type=1")->fetchColumn();
$settle_money=0;
$max_settle=0;
$chart='';
$i=0;
while($row = $rs->fetch())
{
  $settle_money+=$row['money']+$ressz;
  if($row['money']>$max_settle)$max_settle=$row['money'];
  if($i<9)$chart.='['.$i.','.$row['money'].'],';
  $i++;
}
$chart=substr($chart,0,-1);
if($conf['verifytype']==1 && empty($userrow['phone']))$alertinfo='您还没有绑定密保手机，请&nbsp;<a href="my_vip.php" class="btn btn-sm btn-info">尽快绑定</a>';
elseif(empty($userrow['email']))$alertinfo='您还没有绑定密保邮箱，请&nbsp;<a href="my_vip.php" class="btn btn-sm btn-info">尽快绑定</a>';
$tuday=round($order_today['all'],2);
$yesterday=round($order_lastday['all'],2);
$tb1=round($tuday-$yesterday); 
$tb2=round($tb1/$yesterday*100);
$tbqb=round($tb2,2); 
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">首页</a></li>
                                            <li class="breadcrumb-item active">总览</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">商户控制台</h4>
                                </div> <!-- end page-title-box -->
                            </div> <!-- end col-->
                        </div>
                        <div class="row">
                            <div class="col-xl-5">
                                <div class="row">
								<div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-currency-usd widget-icon"></i>                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Average Revenue">当前余额</h5>
                                                <h3 class="mt-3 mb-3">¥<?php echo $userrow['money'];?></h3>
                                                <p class="mb-0 text-muted">
												<?php if($tbqb==0 || $yesterday==0){?>
												<p class="mb-0 text-muted">
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i>0%</span>
                                                    <span class="text-nowrap">同比昨日</span> </p>
												<?php }elseif($tbqb<0){ ?>
                                                    <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i><?php echo $tbqb;?>%</span>
                                                    <span class="text-nowrap">同比昨日</span> </p>
												<?php }elseif($tbqb>0){ ?>
												<span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i><?php echo $tbqb;?>%</span>
                                                    <span class="text-nowrap">同比昨日</span> </p>
												<?php } ?>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                    

                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-cart-plus widget-icon"></i>                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">订单总数</h5>
                                                <h3 class="mt-3 mb-3"><?php echo $orders;?></h3>
                                                <p class="mb-0 text-muted">
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 100%</span>
                                                    <span class="text-nowrap">步步高升</span>                                                </p>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-account-multiple widget-icon"></i>                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">已结算余额</h5>
                                                <h3 class="mt-3 mb-3"><?php echo $settle_money;?></h3>
                                                <p class="mb-0 text-muted">
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 100%</span>
                                                    <span class="text-nowrap">财源广进</span>                                                </p>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    
                                </div> <!-- end row -->
                            </div> <!-- end col -->

                            <div class="col-xl-7">
                                 <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-2">平台 公告</h4>
                                        <div class="slimscroll" style="max-height: 275px;">
											<div class="timeline-alt pb-0">
                                               <?php 
    $rs = $DB->query("SELECT * FROM oreo_notice order by id desc limit 99999");
    while ($res = $rs->fetch()) {
        echo '
		<div class="timeline-item">
        <i class="mdi mdi-upload bg-info-lighten text-info timeline-icon"></i>
        <div class="timeline-item-info">
        <a href="#" class="text-info font-weight-bold mb-1 d-block">'.$res['name'].'</a>
        <small>'.$res['text'].'</small>
         <p class="mb-0 pb-2">
         <small class="text-muted">'.$res['dtime'].'</small>  </p>
        </div>
         </div>';
	}
    ?>
                                            </div>
                                            <!-- end timeline -->
                                        </div> <!-- end slimscroll -->
                                    </div>
                                    <!-- end card-body -->
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                       <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div id="spark1" class="apex-charts"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="spark2" class="apex-charts"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="spark3" class="apex-charts"></div>
                                            </div>
                                        </div>
    
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-centered mb-0">
                                                        <thead class="thead-light">
                                                            <th>名称</th>
                                                            <th>今日</th>
                                                            <th>昨日</th>
                                                            <th>费率</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>支付宝</td>
                                                                <td>￥<?php echo round($order_today['alipay'],2)?></td>
                                                                <td>￥<?php echo round($order_lastday['alipay'],2)?></td>
                                                               <?php if ($userrow['ssvip']==2||$conf['chaojivip']==0||$conf['ssvip_ali']==777){ ?>
                                         <?php if ($conf['sw_money_rate']==0&&$userrow['zdyfl']==0){ ?>
			                        <td> <?php $yibai=100;$tyfeilv=$conf['money_rate'];echo $yibai-$tyfeilv?>% </td>
			                             <?php } ?>   <!-- 当开启通用费率 并且商户没有开启单独费率时-->
			   
                                        <?php if ($conf['sw_money_rate']==0&&$userrow['zdyfl']==1){ ?>
			                        <td><?php $yibai=100;$tyfeilv=$userrow['rate'];echo $yibai-$tyfeilv?>% </td>
			                            <?php } ?>	<!--当开启通用费率 并且商户开启单独费率时-->	   

			                            <?php if ($conf['sw_money_rate']==1&&$userrow['zdyfl']==0){ ?>
			                        <td><?php $yibai=100;$tyfeilv=$conf['alipay_rate'];echo $yibai-$tyfeilv?>% </td>
			                            <?php } ?>  <!-- 当开启三网费率 并且商户没有开启三网单独费率时-->
			   
			                            <?php if ($conf['sw_money_rate']==1&&$userrow['zdyfl']==1){ ?>
			                        <td><?php $yibai=100;$tyfeilv=$userrow['salipay_rate'];echo $yibai-$tyfeilv?>% </td>
			                            <?php } ?>  <!-- 当开启三网费率 并且商户开启三网单独费率时-->	
										<?php }else{ ?>
									<td><?php $yibai=100;$tyfeilv=$conf['ssvip_ali'];echo $yibai-$tyfeilv?>% </td>
									    <?php } ?>
                                                            </tr>
                                                            <tr>
                                                                <td>微信支付</td>
                                                                <td>￥<?php echo round($order_today['wxpay'],2)?></td>
                                                                <td>￥<?php echo round($order_lastday['wxpay'],2)?></td>
                                                               <?php if ($userrow['ssvip']==2||$conf['chaojivip']==0||$conf['ssvip_wx']==777){ ?>
									    <?php if ($conf['sw_money_rate']==0&&$userrow['zdyfl']==0){ ?>
			                        <td><?php $yibai=100;$tyfeilv=$conf['money_rate'];echo $yibai-$tyfeilv?>% </td>
			                            <?php } ?>   <!-- 当开启通用费率 并且商户没有开启单独费率时-->
			   
                                        <?php if ($conf['sw_money_rate']==0&&$userrow['zdyfl']==1){ ?>
			                        <td><?php $yibai=100;$tyfeilv=$userrow['rate'];echo $yibai-$tyfeilv?>% </td>
			                            <?php } ?>	<!--当开启通用费率 并且商户开启单独费率时-->	   

			                            <?php if ($conf['sw_money_rate']==1&&$userrow['zdyfl']==0){ ?>
			                        <td><?php $yibai=100;$tyfeilv=$conf['weixin_rate'];echo $yibai-$tyfeilv?>% </td>
			                            <?php } ?>  <!-- 当开启三网费率 并且商户没有开启三网单独费率时-->
			   
			                            <?php if ($conf['sw_money_rate']==1&&$userrow['zdyfl']==1){ ?>
			                        <td><?php $yibai=100;$tyfeilv=$userrow['sweixin_rate'];echo $yibai-$tyfeilv?>% </td>
			                            <?php } ?>  <!-- 当开启三网费率 并且商户开启三网单独费率时-->
										<?php }else{ ?>
									<td><?php $yibai=100;$tyfeilv=$conf['ssvip_wx'];echo $yibai-$tyfeilv?>% </td>
									    <?php } ?>
                                                            </tr>
                                                            <tr>
                                                                <td>QQ钱包</td>
                                                                <td>￥<?php echo round($order_today['qqpay'],2)?></td>
                                                                <td>￥<?php echo round($order_lastday['qqpay'],2)?></td>
                                                                <?php if ($userrow['ssvip']==2||$conf['chaojivip']==0||$conf['ssvip_qq']==777){ ?>
									    <?php if ($conf['sw_money_rate']==0&&$userrow['zdyfl']==0){ ?>
			                        <td><?php $yibai=100;$tyfeilv=$conf['money_rate'];echo $yibai-$tyfeilv?>% </td>
			                            <?php } ?>   <!-- 当开启通用费率 并且商户没有开启单独费率时-->
			   
                                        <?php if ($conf['sw_money_rate']==0&&$userrow['zdyfl']==1){ ?>
			                        <td><?php $yibai=100;$tyfeilv=$userrow['rate'];echo $yibai-$tyfeilv?>% </td>
			                            <?php } ?>	<!--当开启通用费率 并且商户开启单独费率时-->	   

			                             <?php if ($conf['sw_money_rate']==1&&$userrow['zdyfl']==0){ ?>
			                        <td> <?php $yibai=100;$tyfeilv=$conf['qq_rate'];echo $yibai-$tyfeilv?>% </td>
			                             <?php } ?>  <!-- 当开启三网费率 并且商户没有开启三网单独费率时-->
			   
			                             <?php if ($conf['sw_money_rate']==1&&$userrow['zdyfl']==1){ ?>
			                        <td> <?php $yibai=100;$tyfeilv=$userrow['sqq_rate'];echo $yibai-$tyfeilv?>% </td>
			                             <?php } ?>  <!-- 当开启三网费率 并且商户开启三网单独费率时-->	
										 <?php }else{ ?>
									<td><?php $yibai=100;$tyfeilv=$conf['ssvip_qq'];echo $yibai-$tyfeilv?>% </td>
									    <?php } ?>
                                                            </tr>
                                                             <tr>
                                                                <td>总计</td>
                                                                <td>￥<?php echo round($order_today['all'],2)?></td>
                                                                <td>￥<?php echo round($order_lastday['all'],2)?></td>
                                                                <td>
                                                                   
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card body-->
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->    
                    </div> <!-- content -->
                    </div> <!-- content -->

                    <!-- Footer Start -->
                    <footer class="footer">
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo $conf['copyright']; ?>.                           </div>
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
        <!-- App js -->
        <script src="../assets/newuser/js/app.min.js"></script>
        <script src="../assets/newuser/js/demo.dashboard.js"></script>
        <script src="../assets/newuser/js/apexcharts.min.js"></script>
 <script>
 Apex.grid={padding:{right:0,left:0}},
Apex.dataLabels={enabled:!1};
var randomizeArray=function(e){
	for(var t,r,a=e.slice(),o=a.length;0!==o;)
		r=Math.floor(Math.random()*o),
	t=a[o-=1],a[o]=a[r],a[r]=t;return a
	},
	sparklineData=[47,45,54,38,56,24,65,31,37,39,62,51,35,41,35,27,93,53,61,27,54,43,19,46],
	colorPalette=["#00D8B6","#008FFB","#FEB019","#FF4560","#775DD0"],
	spark1={chart:{type:"area",height:160,sparkline:{enabled:!0}},
	stroke:{width:2,curve:"straight"},
	fill:{opacity:.2},
	series:[{name:"图标中的数据为无效",
	data:randomizeArray(sparklineData)}],
	yaxis:{min:0},colors:["#009FFF"],
	title:{text:"¥<?php echo round($order_today['alipay'],2)?>",
	offsetX:20,
	style:{fontSize:"24px"}},
	subtitle:{text:"支付宝今日",offsetX:20,style:{fontSize:"14px"}}};
	new ApexCharts(document.querySelector("#spark1"),spark1).render();
	var spark2={chart:{type:"area",height:160,sparkline:{enabled:!0}},
	stroke:{width:2,curve:"straight"},
	fill:{opacity:.2},
	series:[{name:"图标中的数据为无效 ",data:randomizeArray(sparklineData)}],
	yaxis:{min:0},colors:["#00d300"],
	title:{text:"¥<?php echo round($order_today['wxpay'],2)?>",offsetX:20,
	style:{fontSize:"24px"}},
	subtitle:{text:"微信今日",offsetX:20,style:{fontSize:"14px"}}};
	new ApexCharts(document.querySelector("#spark2"),spark2).render();
	var spark3={chart:{type:"area",height:160,sparkline:{enabled:!0}},
	stroke:{width:2,curve:"straight"},
	fill:{opacity:.2},
	series:[{name:"图标中的数据为无效 ",data:randomizeArray(sparklineData)}],
	xaxis:{crosshairs:{width:1}},
	yaxis:{min:0},colors:["#727cf5"],
	title:{text:"¥<?php echo round($order_today['qqpay'],2)?>",offsetX:20,style:{fontSize:"24px"}},
	subtitle:{text:"QQ钱包今日",offsetX:20,style:{fontSize:"14px"}}};
	new ApexCharts(document.querySelector("#spark3"),spark3).render();
	var options1={chart:{type:"line",width:140,height:60,sparkline:{enabled:!0}},
	series:[{data:[25,66,41,89,63,25,44,12,36,9,54]}],
	stroke:{width:2,curve:"smooth"},
	markers:{size:0},colors:["#727cf5"],
	tooltip:{fixed:{enabled:!1},x:{show:!1},
	y:{title:{formatter:function(e){return""}}},
	marker:{show:!1}}},
	options2={chart:{type:"line",width:140,height:60,sparkline:{enabled:!0}},
	colors:["#0acf97"],series:[{data:[12,14,2,47,42,15,47,75,65,19,14]}],
	stroke:{width:2,curve:"smooth"},markers:{size:0},
	tooltip:{fixed:{enabled:!1},x:{show:!1},y:{title:{formatter:function(e){return""}}},
	marker:{show:!1}}},options3={chart:{type:"line",width:140,height:60,sparkline:{enabled:!0}},
	colors:["#ffbc00"],series:[{data:[47,45,74,14,56,74,14,11,7,39,82]}],
	stroke:{width:2,curve:"smooth"},markers:{size:0},tooltip:{fixed:{enabled:!1},x:{show:!1},y:{title:{formatter:function(e){return""}}},
	marker:{show:!1}}},options4={chart:{type:"line",width:140,height:60,sparkline:{enabled:!0}},colors:["#fa5c7c"],
	series:[{data:[15,75,47,65,14,2,41,54,4,27,15]}],
	stroke:{width:2,curve:"smooth"},
	markers:{size:0},tooltip:{fixed:{enabled:!1},x:{show:!1},
	y:{title:{formatter:function(e){return""}}},marker:{show:!1}}},
	options5={chart:{type:"bar",width:100,height:60,sparkline:{enabled:!0}},
	plotOptions:{bar:{columnWidth:"80%"}},colors:["#727cf5"],
	series:[{data:[25,66,41,89,63,25,44,12,36,9,54]}],
	labels:[1,2,3,4,5,6,7,8,9,10,11],
	xaxis:{crosshairs:{width:1}},
	tooltip:{fixed:{enabled:!1},
	x:{show:!1},y:{title:{formatter:function(e){return""}}},
	marker:{show:!1}}},
	options6={chart:{type:"bar",width:100,height:60,sparkline:{enabled:!0}},
	plotOptions:{bar:{columnWidth:"80%"}},colors:["#0acf97"],
	series:[{data:[12,14,2,47,42,15,47,75,65,19,14]}],
	labels:[1,2,3,4,5,6,7,8,9,10,11],xaxis:{crosshairs:{width:1}},
	tooltip:{fixed:{enabled:!1},x:{show:!1},
	y:{title:{formatter:function(e){return""}}},
	marker:{show:!1}}},options7={chart:{type:"bar",width:100,height:60,sparkline:{enabled:!0}},plotOptions:{bar:{columnWidth:"80%"}},colors:["#ffbc00"],
	series:[{data:[47,45,74,14,56,74,14,11,7,39,82]}],labels:[1,2,3,4,5,6,7,8,9,10,11],
	xaxis:{crosshairs:{width:1}},tooltip:{fixed:{enabled:!1},x:{show:!1},y:{title:{formatter:function(e){return""}}},marker:{show:!1}}},options8={chart:{type:"bar",width:100,height:60,sparkline:{enabled:!0}},plotOptions:{bar:{columnWidth:"80%"}},colors:["#fa5c7c"],series:[{data:[25,66,41,89,63,25,44,12,36,9,54]}],labels:[1,2,3,4,5,6,7,8,9,10,11],xaxis:{crosshairs:{width:1}},tooltip:{fixed:{enabled:!1},x:{show:!1},y:{title:{formatter:function(e){return""}}},marker:{show:!1}}};new ApexCharts(document.querySelector("#chart1"),options1).render(),new ApexCharts(document.querySelector("#chart2"),options2).render(),new ApexCharts(document.querySelector("#chart3"),options3).render(),new ApexCharts(document.querySelector("#chart4"),options4).render(),new ApexCharts(document.querySelector("#chart5"),options5).render(),new ApexCharts(document.querySelector("#chart6"),options6).render(),new ApexCharts(document.querySelector("#chart7"),options7).render(),new ApexCharts(document.querySelector("#chart8"),options8).render();
 </script>
        <!-- end demo js-->
    </body>
</html>