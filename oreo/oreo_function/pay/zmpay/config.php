<?php
/*
 * 配置文件
 * Author：子墨
 * Mail:<3171275340@qq.com>
 * Date:2019/8/18
 */

$id = $conf['oreo_zmpay_api_id_wx']; //对接ID
$token = $conf['oreo_zmpay_api_token_wx']; //对接商户号

//微信商户号  添加请按照格式来
$wx_sh_arr =
    [
        [
            'mchid' => $conf['oreo_zmpay_api_mchid_wx'],
        ],
        
    ];

//轮训业务处理
$wid = array_rand($wx_sh_arr);
$mchid = $wx_sh_arr[$wid]['mchid'];