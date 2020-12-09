$(document).ready(function(){
  init();

})


var wxPayUrl = '/demo/php';
var aliPayUrl = '/demo/php'; 
var aliPayMobileUrl = '/demo/php';
var unionPayUrl = '/demo/php';
var qqPayUrl = '/demo/php';

var isWx = "isWx";
var isPc = "isPc";
var isWap = "isWap";

function init(){

  buttonClick();
  // setTimeout(appendSpan,400);
  // setTimeout(clearIntervarA,400);
  // setTimeout(bb,1000);
  // setTimeout(clearIntervarAll,2000);

  var hiWord="嘿，你好~   ";
  var emojiPath='images/enjo.png';
  var thankWorkContent="感谢体验CO聚合支付。";

  setTimeout(beginEffect,500);
  function beginEffect(){
    $("#begin-effect").attr("class","begin-effect");
  }

  var indexA=0;
  function printTrankWords(){
    $("#wordA").html(hiWord.substr(0,indexA++));
  }
  var printFirst = setInterval(printTrankWords,50);

  function appendSpan(){
    var $emojiFace = $("<img src='"+emojiPath+"' class='emojiFace'>");
    $('#wordA').append("&nbsp;");
    $('#wordA').append($emojiFace);
  }

  var indexB=0;
  function printTrankWordsB(){
    $("#wordA").css("display","block");
    $("#wordB").html(thankWorkContent.substr(0,indexB++));
  }
  var printSecond=null;
  function bb(){

    printSecond = setInterval(printTrankWordsB,50);

  }
  function clearIntervarA(){
    clearInterval(printFirst);
  }
  function clearIntervarAll(){
    clearInterval(printSecond);
  }


  /*显示 loading*/
  function loadingShow(){
    $(".loadingBg").show();
  }

  function loadingHidd(){
    $(".loadingBg").hide();
    $(".bg").hide();
    $('#payChannelDiv').attr("class","payChannelDivBack");
    $(".qrCodeDivHidd").attr("class","qrCodeDivHidd");
  }

  function goToPayHtml(){
    window.location.href="toPay.html";
  }

  function buttonClick(){

    $("#myButton").click(()=>{
      $(".bg").show();
      $('#payChannelDiv').attr("class","payChannelDivShow");
    });

    $(".bg").click(function(){
      setTimeout(bgHidd,250);
      $('#payChannelDiv').attr("class","payChannelDivBack");
    });

    function bgHidd(){
      $(".bg").hide();
    }


    /*渠道支付按钮*/
    $("#wxBtn").click(function(){
      // toLoading("wxImg");
      if(isWx == browserCheck()){
        window.location.href=wxPayUrl;
      }else if(isPc == browserCheck()){
        window.location.href="/demo/php"
      }else if(isWap == browserCheck()){
        window.location.href=wxPayUrl;
      }
      loadingHidd();
    })

    $("#aliBtn").click(function(){

      // toLoading("aliImg");
      if(isWx == browserCheck()){
        window.location.href="/demo/php";
      }else if(isPc == browserCheck()){
        window.location.href=aliPayUrl;
      }else if(isWap == browserCheck()){
        window.location.href=aliPayMobileUrl;
      }

      loadingHidd();

    })

    $("#unBtn").click(function(){
      // toLoading("unImg");
      if(isWx == browserCheck()){
        window.location.href=unionPayUrl;
      }else if(isPc == browserCheck()){
        window.location.href=unionPayUrl;
      }else if(isWap == browserCheck()){
        window.location.href=unionPayUrl;
      }
      loadingHidd();
    })

    $("#qqBtn").click(function(){
      // toLoading("qqImg");
      if(isWx == browserCheck()){
        window.location.href=qqPayUrl;
      }else if(isPc == browserCheck()){
        window.location.href=qqPayUrl;
      }else if(isWap == browserCheck()){
        window.location.href=qqPayUrl;
      }
      loadingHidd();
    })

    function toLoading(_id){
      var $domAtom = $("#"+_id);
      $domAtom.css("background","none")
      $domAtom.empty();
      $("<p></p>")
       .appendTo($domAtom)
       .attr("class", "rotatePoint");
      $domAtom.attr("class","loader-channel");
    }

    // $("#jdBtn").click(function(){
    //   loadingShow();
    //   setTimeout(loadingHidd,2000);
    //   goToPayHtml();
    // })
    //
    // $("#bdBtn").click(function(){
    //   loadingShow();
    //   setTimeout(loadingHidd,2000);
    //   goToPayHtml();
    // })
  }

  var bForcepc = fGetQuery("dv") == "pc";
  var isMobile = true;
  var notMobile = false;

  var sUserAgent = navigator.userAgent.toLowerCase();
  var bIsPc = sUserAgent.match(/windows/i) == "windows";
  var bIsMac = sUserAgent.match(/mac/i) == "mac";
  var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
  var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
  var bIsMidp = sUserAgent.match(/midp/i) == "midp";
  var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
  var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
  var bIsAndroid = sUserAgent.match(/android/i) == "android";
  var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
  var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";

 // fBrowserRedirect();

  function fBrowserRedirect(){

    //Iphone + Ipad
    if(bIsIphoneOs || bIsIpad){
      // alert("bIsIphoneOs");
      // $(".bottom-div").css("class","bottom-div-os");
    }
    //Android
    if(bIsAndroid){
      // alert("android");
    }
    // PC
    if(bIsPc || bIsMac){
      // alert("pc");
    }

    if(bIsMidp||bIsUc7||bIsUc||bIsCE||bIsWM){
      // alert("不支持");
    }
  }

  //      ------------------------------------------    浏览器  ，手持设备校验 ---------------------------------------------------
  function checkIsMobie(){
    //手持
    if(bIsIphoneOs || bIsIpad){

      return isMobile;
    }
    if(bIsAndroid ){
      return isMobile;
    }
    // PC
    else{
      return notMobile;
    }
  }

  //判断是否在微信内
  function isWeixinBrowser(){
    var ua = navigator.userAgent.toLowerCase();
    return (/micromessenger/.test(ua)) ? true : false ;
  }


  function fGetQuery(name){//获取参数值
    var sUrl = window.location.search.substr(1);
    var r = sUrl.match(new RegExp("(^|&)" + name + "=([^&]*)(&|$)"));

    return (r == null ? null : (r[2]));
  }

  function fShowVerBlock(){
    if(bForcepc){
      document.getElementByIdx_x("dv_block").style.display = "block";
    } else {
      document.getElementByIdx_x("ad_block").style.display = "block";
    }
  }

  //终端初始化 ---------------
  browserInit();
  function browserInit(){
    //手机端初始化
    if(checkIsMobie()){
      //微信内打开
      if(isWeixinBrowser()){
        return isWx;
        //微信外部打开   需要隐藏掉微信支付按钮
      }else{
        // $("#wxBtn").remove();
      }
      //PC端初始化
    }else{
      return isPc;
    }
  }

  //终端校验 --------------
  function browserCheck(){
    //手机端初始化
    if(checkIsMobie()){
      //微信内打开
      if(isWeixinBrowser()){
        return isWx;
        //微信外部打开   需要隐藏掉微信支付按钮
      }else{
        return isWap;
      }
      //PC端初始化
    }else{
      return isPc;
    }
  }



}
