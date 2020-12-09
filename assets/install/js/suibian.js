// JavaScript Document
$(document).ready(function(e) {
	  $(".menter_btn_a_a_lf").click(function(){
		if($(".check_boxId").is(":checked")){
			
	     	window.location.href="oreo_install_two.php";
		}
		else
		{
			alert("请同意安装协议");
		}
	});
});