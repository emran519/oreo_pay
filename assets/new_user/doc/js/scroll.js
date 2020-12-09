


function readyLoad(){
  window.onscroll = function (e) {
    if(window.scrollY < 200){
      $(".pay-left").css({
        'top':200 - window.scrollY
      });
    }else{
      $(".pay-left").css({
        'top':'0'
      });
    }
  }
}
