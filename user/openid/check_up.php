<?php
/**
 * Oreo授权系统
 * =======================================================
 * 版权所有 (C) 2019 www.oreo.com，并保留所有权利。
 * Q Q: 609451870
 * =======================================================
 */
include("../../oreo/Oreo.Cron.php");
date_default_timezone_set('PRC');
header("content-type:text/html;charset=utf-8");
$myid=daddslashes($_GET['myid']);

function get_all_headers(){
  // 忽略获取的header数据
  $ignore = array('host','accept','content-length','content-type');
  $headers = array();
  foreach($_SERVER as $key=>$value){
    if(substr($key, 0, 5)==='HTTP_'){
      $key = substr($key, 5);
      $key = str_replace('_', ' ', $key);
      $key = str_replace(' ', '-', $key);
      $key = strtolower($key);
      if(!in_array($key, $ignore)){
        $headers[$key] = $value;
      }
    }
  }
  return $headers;
}
$header = get_all_headers();//获取header
$ret = array();
$ret['OreoAuthList'] = $header; //json第一段
header('content-type:application/json;charset=utf8');
$OreoMyOpenId=($ret['OreoAuthList']['openid']);
$OreoMyId=($ret['OreoAuthList']['myid']);
$OreoMyDomain=($ret['OreoAuthList']['domain']);
//开始查询有效性
if($OreoMyId){
$DB->exec("INSERT INTO `oreo_wx_seesion` (`token`, `open_id`, `addtime`) VALUES ('{$OreoMyId}', '{$OreoMyOpenId}', '{$date}')"); 
}
$thiz_myid=$DB->query("select * from oreo_wx_seesion where token='{$myid}' limit 1")->fetch();
if($thiz_myid['token']==$myid){
  $_SESSION['My_Wx_OpenId']= $thiz_myid['open_id'];
  $urls='../wx_connect.php?openid='.$thiz_myid['open_id'];
  exit('{"code":1,"msg":"查询成功","openid":"'.$urls.'"}');
}

?>