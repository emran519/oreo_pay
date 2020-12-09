<?php
include("../oreo/Oreo.Cron.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$id = isset($_POST['id'])?intval($_POST['id']):exit('{"code":-1,"msg":"ID不能为空"}');
$row=$DB->query("SELECT * FROM oreo_settle WHERE id='{$id}' limit 1")->fetch();
if(!$row)exit('{"code":-1,"msg":"记录不存在"}');
if($row['type']!=2)exit('{"code":-1,"msg":"该记录不是微信结算"}');
if($row['transfer_status']==1)exit('{"code":0,"ret":2,"result":"微信订单号:'.$row['transfer_result'].' 支付时间:'.$row['transfer_date'].'"}');
//开始查询用户的Openid
$wx_openid=$row['account']; //用户OpenId
if($wx_openid=='0'){
    $data['code']=0;
    $data['ret']=0;
    $data['result']='用户OpenId为空 : 请通知用户到登录页面绑定微信登录';
    $DB->exec("update `oreo_settle` set `transfer_status`='2',`transfer_result`='用户OpenId为空 : 请通知用户到登录页面绑定微信登录' where `id`='$id'");
    echo json_encode($data); 
    die;
}
header('Content-type:text/html; Charset=utf-8');
$mchid = $conf['wxtransfer_mchid'];    //微信支付商户号 PartnerID 通过微信支付商户资料审核后邮件发送
$appid =  $conf['wxtransfer_appid']; //微信支付申请对应的公众号的APPID
$appKey =  $conf['wxtransfer_appkey'];   //微信支付申请对应的公众号的APP Key
$apiKey =  $conf['wxtransfer_apikey'];  //https://pay.weixin.qq.com 帐户设置-安全设置-API安全-API密钥-设置API密钥
$wxPay = new WxpayService($mchid,$appid,$appKey,$apiKey);
$openId = $wx_openid;      //获取openid


//②、付款
$outTradeNo = uniqid();     //订单号
$payAmount = $row['money'];             //转账金额，单位:元。转账最小金额为1元
$trueName = $row['username'];         //收款人真实姓名
$tcip=$_SERVER['SERVER_ADDR']; //ip地址
$apiclient_cert=$conf['apiclient_cert']; //cert文件目录
$apiclient_key=$conf['apiclient_key']; //key文件目录
$order_name=$conf['payer_show_name']; //key文件目录
$result = $wxPay->createJsBizPackage($openId,$payAmount,$outTradeNo,$trueName,$tcip,$order_name);

//写入数据库
if($result["result_code"]=='SUCCESS'){
    $data['code']=0;
    $data['ret']=1;
    $data['msg']='success';
    $data['result']='微信订单号:'.$result["payment_no"].' 支付时间:'.$result["payment_time"];
    $DB->exec("update `oreo_settle` set `transfer_status`='1',`transfer_result`='".$result["payment_no"]."',`transfer_date`='".$result["payment_time"]."' where `id`='$id'");
}elseif($result["result_code"]=='FAIL' && ($result["err_code"]=='OPENID_ERROR'||$result["err_code"]=='NAME_MISMATCH'||$result["err_code"]=='MONEY_LIMIT'||$result["err_code"]=='V2_ACCOUNT_SIMPLE_BAN')) {
        $data['code']=0;
        $data['ret']=0;
        $data['msg']='fail';
        $data['result']='失败 ['.$result["err_code"].']'.$result["err_code_des"];
        $DB->exec("update `oreo_settle` set `transfer_status`='2',`transfer_result`='".$data['result']."' where `id`='$id'");} elseif(!empty($result["result_code"])){
        $data['code']=-1;
        $data['msg']='['.$result["err_code"].']'.$result["err_code_des"];
} else {
        $data['code']=-1;
        $data['msg']='未知错误 '.$result["return_msg"];
    }
echo json_encode($data); 




class WxpayService
{
    protected $mchid;
    protected $appid;
    protected $appKey;
    protected $apiKey;
    public $data = null;

    public function __construct($mchid, $appid, $appKey,$key)
    {
        $this->mchid = $mchid;
        $this->appid = $appid;
        $this->appKey = $appKey;
        $this->apiKey = $key;
    }

    /**
     * 通过跳转获取用户的openid，跳转流程如下：
     * 1、设置自己需要调回的url及其其他参数，跳转到微信服务器https://open.weixin.qq.com/connect/oauth2/authorize
     * 2、微信服务处理完成之后会跳转回用户redirect_uri地址，此时会带上一些参数，如：code
     * @return 用户的openid
     */
    public function GetOpenid()
    {
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $scheme = $_SERVER['HTTPS']=='on' ? 'https://' : 'http://';
            $baseUrl = urlencode($scheme.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING']);
            $url = $this->__CreateOauthUrlForCode($baseUrl);
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $openid = $this->getOpenidFromMp($code);
            return $openid;
        }
    }

    /**
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
     * @return openid
     */
    public function GetOpenidFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);
        $res = self::curlGet($url);
        //取出openid
        $data = json_decode($res,true);
        $this->data = $data;
        $openid = $data['openid'];
        return $openid;
    }

    /**
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     * @return 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {
        $urlObj["appid"] = $this->appid;
        $urlObj["secret"] = $this->appKey;
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }

    /**
     * 构造获取code的url连接
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     * @return 返回构造好的url
     */
    private function __CreateOauthUrlForCode($redirectUrl)
    {
        $urlObj["appid"] = $this->appid;
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_base";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

    /**
     * 拼接签名字符串
     * @param array $urlObj
     * @return 返回已经拼接好的字符串
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign") $buff .= $k . "=" . $v . "&";
        }
        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 企业付款
     * @param string $openid 调用【网页授权获取用户信息】接口获取到用户在该公众号下的Openid
     * @param float $totalFee 收款总费用 单位元
     * @param string $outTradeNo 唯一的订单号
     * @param string $orderName 订单名称
     * @param string $notifyUrl 支付结果通知url 不要有问号
     * @param string $timestamp 支付时间
     * @return string
     */
    public function createJsBizPackage($openid, $totalFee, $outTradeNo,$trueName,$tcip,$order_name)
    {
        $config = array(
            'mch_id' => $this->mchid,
            'appid' => $this->appid,
            'key' => $this->apiKey,
        );
        $unified = array(
            'mch_appid' => $config['appid'],
            'mchid' => $config['mch_id'],
            'nonce_str' => self::createNonceStr(),
            'openid' => $openid,
            'check_name'=>'FORCE_CHECK',        //校验用户姓名选项。NO_CHECK：不校验真实姓名，FORCE_CHECK：强校验真实姓名
            're_user_name'=>$trueName,                 //收款用户真实姓名（不支持给非实名用户打款）
            'partner_trade_no' => $outTradeNo,
            'spbill_create_ip' => $tcip,
            'amount' => intval($totalFee * 100),       //单位 转为分
            'desc'=> $order_name,            //企业付款操作说明信息
        );
        $unified['sign'] = self::getSign($unified, $config['key']);
        $responseXml = $this->curlPost('https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers', self::arrayToXml($unified));
        $unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $result_code=$unifiedOrder->result_code;//业务结果
        $payment_no=$unifiedOrder->payment_no;//微信付款单号
        $payment_time=$unifiedOrder->payment_time;//付款成功时间
        $partner_trade_no=$unifiedOrder->partner_trade_no; //商户订单号
        $err_code=$unifiedOrder->err_code; //错误代码
        $array = array(
            "result_code"  => $result_code,
            "payment_no"  => $payment_no,
            "payment_time" => $payment_time,
            "partner_trade_no" => $partner_trade_no,
            "err_code"  => $err_code,
        );
        if ($unifiedOrder === false) {
            die('parse xml error');
        }
        if ($unifiedOrder->return_code != 'SUCCESS') {
            return($array);
            die;
           
        }
        if ($unifiedOrder->result_code != 'SUCCESS') {
            
            return($array);
            die;
        }
        return($array);
    }

    public static function curlGet($url = '', $options = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function curlPost($url = '', $postData = '', $options = array())
    {
        global $conf;
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //第一种方法，cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().$conf['apiclient_cert']);
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,getcwd().$conf['apiclient_key']);
        //第二种方式，两个文件合成一个.pem文件
//        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public static function createNonceStr($length = 16)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    public static function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
        $xml .= "</xml>";
        return $xml;
    }

    public static function getSign($params, $key)
    {
        ksort($params, SORT_STRING);
        $unSignParaString = self::formatQueryParaMap($params, false);
        $signStr = strtoupper(md5($unSignParaString . "&key=" . $key));
        return $signStr;
    }
    protected static function formatQueryParaMap($paraMap, $urlEncode = false)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if (null != $v && "null" != $v) {
                if ($urlEncode) {
                    $v = urlencode($v);
                }
                $buff .= $k . "=" . $v . "&";
            }
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }
}
?>