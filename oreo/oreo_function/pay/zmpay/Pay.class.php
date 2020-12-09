<?php
/*
 * 支付核心类库
 * Author：子墨
 * Mail:<3171275340@qq.com>
 * Date:2019/5/30
 */

class Pay
{
    private $id;
    private $key;

    public function __construct($id = null, $key = null)
    {
        $this->id = $id;
        $this->key = $key;
    }

    public function mp_pay($trade_no, $name, $money, $notify_url, $mchid)
    {
        $url = 'http://open.wangxinqianbao.cn/api/mp_pay.html';
        $data = [
            'id' => $this->id,
            'trade_no' => $trade_no,
            'name' => $name,
            'money' => $money,
            'notify_url' => $notify_url,
            'mchid' => $mchid
        ];
        $sign = $this->getSign($data);
        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';
        $url = $url . '?' . http_build_query($data);
        header("Location: {$url}");
    }

    public function scan_pay($trade_no, $name, $money, $notify_url, $mchid)
    {
        $url = 'http://open.wangxinqianbao.cn/api/scan_pay.html';
        $data = [
            'id' => $this->id,
            'trade_no' => $trade_no,
            'name' => $name,
            'money' => $money,
            'notify_url' => $notify_url,
            'mchid' => $mchid
        ];
        $sign = $this->getSign($data);
        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';
        $url = $url . '?' . http_build_query($data);
        $res = curl_get($url);
        if (!$res) sysmsg('发起支付失败！');
        $res = json_decode($res, 1);
        if ($res['code'] == 1) {
            return $res['code_url'];
        } else {
            sysmsg($res['msg']);
        }
    }

    /**
     * @Note   验证签名
     * @param $data  待验证参数
     * @return bool
     */
    public function verify($data)
    {
        if (!isset($data['sign']) || !$data['sign']) {
            return false;
        }
        $sign = $data['sign'];
        unset($data['sign']);
        unset($data['sign_type']);
        $sign2 = $this->getSign($data);
        if ($sign != $sign2) {
            return false;
        }
        return true;
    }

    /**
     * @Note  生成签名
     * @param $data   参与签名的参数
     * @return string
     */
    public function getSign($data)
    {
        $data = array_filter($data);
        if (get_magic_quotes_gpc()) {
            $data = stripslashes($data);
        }
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
        }
        $str = $str1 . $this->key;
        $str = trim($str, '&');
        $sign = md5($str);
        return $sign;
    }
}