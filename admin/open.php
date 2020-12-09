<?php
header('Content-type:text/html; Charset=utf-8');
$scheme = $_SERVER['HTTPS']=='on' ? 'https://' : 'http://';
$baseUrl = urlencode($scheme.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING']);
echo  $baseUrl ;
?>