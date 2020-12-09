<?php
include("../oreo/Oreo.Cron.php");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>服务条款</title>
<style type="text/css">
body{ color: #555555; font-size: 12px; font-family:Tahoma, Geneva, sans-serif, Arial; margin:0; padding:0; background:#ffffff; outline: none;}
.w-main .title-1 h3{ font-family:"微软雅黑"; color:#333; font-size:18px; text-align:center; font-weight:700;}
.w-main .content p{ text-indent:2em; font-size:14px; line-height:20px; color:#555;}
</style>
</head>

<body>
  <div class="w-main">
      <div class="title-1">
        <h3>服务条款</h3>
      </div>
      <div class="content">
<?php echo $conf['agreement']; ?>
  </div>
</div>
</body>
</html>
