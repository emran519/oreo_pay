<?php
//Oreo微信小程序对接Demo
//引入核心文件
require './oreo/Oreo.Cron.php';
header('content-type:application/json;charset=utf-8');
header('Access-Control-Allow-Origin:*');
//引入Oreo类文件
require './OreoApplet.class.php';
//实例化Oreo类
$oreo = new OreoApplet();
$oreo->appId = $conf['oreo_applet_appid'];// Oreo综合服务站生成的AppId
$oreo->appSecret = $conf['oreo_applet_secret'];// Oreo综合服务站生成的secret
$res = $oreo->json($oreo->oreoStart());//函数开始
if ($res->oreo_code == 200) {
    //登录请求
    if($_POST['request_type']==1){
        //开始处理用户账号密码验证(根据您项目而定)
        //数据库查询(以下是PDO实例)
        //这里的用户密码是明文形式，此时您需要转换您数据库中对应的加密方式
        $password_hash = '!@#%!s!0';
        $password = md5($_POST['password'] . $password_hash);
        $user = $DB->query("SELECT * FROM `oreo_user` WHERE id='{$_POST['username']}' and password = '{$password}' limit 1")->fetch();
        //如果用户不存在
        if (empty($user)) {
            exit($oreo->getJson(0, "用户名或密码错误"));
        } else {
            //否则请返回当前用户的ID或用户名(这是根据您的业务而定，这个是我们在下一步查询中用到)
            exit($oreo->encrypt($user['id']));
        }
    }else if($_POST['request_type']==2){  //获取用户余额和今日订单数量
        $userMoney = $DB->query("SELECT money,apply FROM `oreo_user` WHERE id='{$_POST['uid']}' limit 1")->fetch(PDO::FETCH_ASSOC); //用户余额
        $today = date("Ymd").'00000000000';
        $todayOrderMoney = $DB->query("SELECT sum(money) from oreo_order where pid={$_POST['uid']} and status=1 and trade_no>='$today'")->fetchColumn();//今日订单总额
        $todayOrders=$DB->query("SELECT count(*) from oreo_order WHERE pid={$_POST['uid']} and status=1")->fetchColumn();//今日订单总数
        $data = array(
            'user_apply'  => $userMoney['apply'], //需要返回该用户当前能否还手动提现,Oreo只需知道 1表示不能,0表示可以
            'user_money'  => $userMoney['money'],
            'today_order_money' => $todayOrderMoney,
            'today_orders' => $todayOrders
        );
        exit($oreo->getJson(200, "查询成功",$data));
    }else if($_POST['request_type']==3){  //用户提现
        if($conf['settle_open']==0){
            exit($oreo->getJson(-1, "本站管理员暂未开启手动结算功能，如有疑问请联系客服！"));
        }
        //这里的计算过程得根据您业务需求自定义
        $user = $DB->query("SELECT * FROM `oreo_user` WHERE id='{$_POST['uid']}' limit 1")->fetch(PDO::FETCH_ASSOC); //用户余额
        //查找该用户当前余额后根据业务该处理的处理，不满足条件的正常返回提示
        if($user['apply']==1){
            exit($oreo->getJson(-1, "很抱歉，您有一个还未完结的手动结申请记录，请勿重复申请！"));
        }
        if($user['money']<$conf['sdtx_money_min']){
            exit($oreo->getJson(-1, "很抱歉，您当前的商户余额不满足本站可申请手动结算的最低金额设定标准！"));
        }
        //满足条件写入手动结算相关数据信息
        $date=date("YmdHis");
        $DB->exec("update `oreo_user` set `apply` ='1' where `id`='{$_POST['uid']}'");
        $DB->exec("INSERT INTO `oreo_apply` (`uid`, `jsfs`, `username`, `account`, `money`, `fee`, `sdtime`, `type`) VALUES ('{$_POST['uid']}', '{$user['settle_id']}', '{$user['username']}', '{$user['account']}', '{$user['money']}', '{$user['money']}', '{$date}', '0')");
        exit($oreo->getJson(200, "申请成功"));
        
    }else if($_POST['request_type']==4) {  //用户基本信息
        $userInfo = $DB->query("SELECT * FROM `oreo_user` WHERE id='{$_POST['uid']}' limit 1")->fetch(PDO::FETCH_ASSOC); //用户余额
        if($userInfo['settle_id']==1){
            $settle = '支付宝结算';
        }else if($userInfo['settle_id']==2){
            $settle = '微信结算';
        }else if($userInfo['settle_id']==3){
            $settle = 'QQ钱包结算';
        }else{
            $settle = '银行卡结算';
        }
        $data = array(
            'user_qq'  => $userInfo['qq'], //需要返回用户QQ
            'user_email'  => $userInfo['email'], //需要返回用户用户邮箱
            'user_phone'  => $userInfo['phone'], //需要返回用户用户手机号
            'user_settle'  => $settle, //需要返回结算方式
            'user_username'  => $userInfo['username'], //需要返回用户账户姓名
            'user_account' => $userInfo['account'] ? : '未填写' //需要返回用户结算账户
        );
        exit($oreo->getJson(200, "查询成功",$data));
        
    }else if($_POST['request_type']==5) {  //修改用户密码
        //这里的用户密码是明文形式，此时您需要转换您数据库中对应的加密方式
        $password_hash = '!@#%!s!0';
        $password = md5($_POST['password'].$password_hash);
        $DB->exec("UPDATE `oreo_user` SET `password`='$password' WHERE `id`='{$_POST['uid']}'");
        exit($oreo->getJson(200, "修改成功"));
    }
    exit($oreo->getJson(0, "参数错误"));
}
echo $oreo->oreoStart();
exit();
