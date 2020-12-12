<?php


class OreoApplet
{
    /**
     * Oreo综合服务站生成的AppId
     */
    public $appId;

    /**
     * Oreo综合服务站生成的AppSecret
     */
    public $appSecret;

    public function getJson($code,$msg,$data=null){
        if($code==200) {
            $arr['oreo_code'] = $code;
            $arr['oreo_msg']  = $msg;
            $arr['oreo_data'] = $data;
        }else{
            $arr['oreo_code'] = -1;
            $arr['oreo_msg']  =  $msg;
            $arr['oreo_data'] = $data;
        }
        return json_encode($arr);
    }

    public function oreoStart(){
        if($_POST){
            $_POST['app_id'] == $this->appId && $_POST['app_secret'] == $this->appSecret ? : exit($this->getJson(0,"无效请求 x001"));
           //$_POST['username'] && $_POST['password'] ? : exit($this->getJson(0,"用户名或密码不能为空"));
            return $this->getJson(200,"ok");
        }else{
             return $this->getJson(0,"无效请求 x002");
        }
    }

    public function encrypt($str) {
        $data = openssl_encrypt($str, 'AES-128-ECB', $this->appSecret, OPENSSL_RAW_DATA);
        $data = base64_encode($data);
        return $this->getJson(200,"登录成功",$data);
    }

    public function json($data, $assoc = false)
    {
        return json_decode($data, $assoc);
    }
}