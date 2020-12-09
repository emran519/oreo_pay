<?php
include("../oreo/Oreo.Cron.php");
if($conf['ddcs']==0)sysmsg('在线测试支付页面已关闭，如有疑问请联系站点管理员！');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport"
  content="width=device-width,initial-scale=1,
  maximum-scale=1,user-scalable=no">
  <meta name="description" content="CO聚合支付V2.0">
  <title>体验支付 - <?php echo $conf["web_name"]; ?></title> 
  <meta content="<?php echo $conf["webcontent"]; ?>" name="keywords"></meta>
  <link rel="stylesheet" type="text/css" href="../assets/sdk/css/toPay.css">
  <link rel="stylesheet" type="text/css" href="../assets/sdk/css/media.css">
  <script type="text/javascript" media="" src="../assets/sdk/js/jquery.min.js"></script>
  <script type="text/javascript" media="" src="../assets/sdk/js/toPay.js"></script>
  <script type="text/javascript" media="" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
  <script type="text/javascript" media="" src="../assets/sdk/js/share.js"></script>
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="../assets/sdk/css/reset.css">
  <script type="text/javascript">
  // alert(Math.random().toString(36).substr(2));
  wx.config({
      debug:false,
      appId:"wxf3167b8d0a7132ca",
      timestamp:new Date().getTime(),
      nonceStr:"5a9948e15caba8a3",
      signature:"b493399864c2e059171ea25dbf83d2ee507ab6a7",
      jsApiList:['onMenuShareTimeline','onMenuShareAppMessage']
  });
  wx.error(function(res){
      console.log(res);
  });
  wx.ready(function(){
      wx.onMenuShareTimeline({
          title:"nowpay-demo",
          link:"/demo/",
          imgUrl:"../assets/sdk/css/logo.png",
          success:function(){
          },
          cancel:function(){
          }
      });
      wx.onMenuShareAppMessage({
          title:"nowpay-demo",
          link:"/demo/",
          imgUrl:"../assets/sdk/css/logo.png",
          success:function(){
          },
          cancel:function(){
          }
      });
  });
  </script>
</head>

<body>

  <div class="father" id="particles-js">
    <!-- 外层动画 -->
    <div class="crust">
        <div id="begin-effect">
        </div>
    </div>

   <!-- 以下为内层 -->
    <header>
      <!-- <div class="headerBgImg">
      </div> -->
      <div class="logoDiv" >
        <img src="../assets/sdk/css/logo.png">
      </div>
      <div class="thankWords" >
      <p style="display: inline-block;">嘿，你好~   </p>   <!-- id="wordA"   id="wordB"-->
        <p style="display: inline-block;">感谢体验<?php echo $conf['web_name']?></p>
        <span id="typed" style="display: inline-block;"></span>
      </div>
    </header><div style="clear:both;"></div>
 <form name=alipayment action=epayapi.php method=post target="_blank">
    <div class="contant">
      <p class="overimage"></p>
      <p class="overimageShadowA"></p>
      <p class="overimageShadowB"></p>
      <div class="printOuterDiv">
        <p class="printOuterWay"></p>
      </div>
      <div class="printPaperDiv" >
        <span><?php echo $conf['ddcs_money']?></span><span id="cc">元</span>
		 <input type="text" class="form-control"   name="WIDtotal_fee" value="<?php echo $conf['ddcs_money']; ?>"  class="form-control" style="display: none"/>
		 <input type="text" class="form-control"  name="id" value="<?php echo $conf['ddcs_id']; ?>" style="display: none"/>
		 <input type="text" class="form-control" name="key" value="<?php echo $conf['ddcs_key']; ?>" style="display: none"/>
		 <input size="30" name="WIDsubject" value="<?php echo $conf['order_name'];?>" class="form-control" placeholder="商品名称" required="required" style="display: none"/>
          <input size="30" name="WIDout_trade_no" value="<?php echo date("YmdHis").mt_rand(100,999); ?>"  class="form-control" placeholder="商户订单号" style="display: none" />		 
        <p><br>体验专业的支付服务</p>
      </div>
    </div>

    <div class="footer">
	<?php if($conf['alipay_mode']!=0){?>
                                                   <button type="radio" value="alipay" name="type" class="btn btn-primary" style="color: #ffff;background-color: #24272b;font-family: Trebuchet MS;padding: 15px 40px;font-size: 15px;"><i class="iconfont icon-zhifubao"></i> 支付宝</button>
												   <?php }if($conf['wxpay_mode']!=0){ ?>		
												   <button type="radio" value="wxpay" name="type" class="btn btn-success" style="color: #ffff;background-color: #24272b;font-family: Trebuchet MS;padding: 15px 40px;font-size: 15px;"><i class="iconfont icon-weixin"></i> 微信</button>
												   <?php }if($conf['qqpay_mode']!=0){ ?>
												   <button type="radio" value="qqpay" name="type" class="btn btn-secondary" style="color: #ffff;background-color: #24272b;font-family: Trebuchet MS;padding: 15px 40px;font-size: 15px;"><i class="iconfont icon-qq"></i> QQ钱包</button>
                                                   <?php } ?>   
    </div>
    <div class="bg"></div>
    <div class="loadingBg">
      <div class="spinner">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
      </div>
    </div>
  </div>
  <script type="text/javascript"  src='../assets/sdk/js/particles.min.js'></script>
  <script type="text/javascript"  src='../assets/sdk/js/stats.js'></script>
  <script type="text/javascript" media="" src="../assets/sdk/js/line.js"></script>

</body>
</html>
