-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-12-09 21:37:31
-- 服务器版本： 5.6.46-log
-- PHP 版本： 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `pay_applet_2free`
--

-- --------------------------------------------------------

--
-- 表的结构 `oreo_apply`
--

CREATE TABLE `oreo_apply` (
                              `id` int(11) NOT NULL,
                              `uid` varchar(16) NOT NULL,
                              `jsfs` int(11) NOT NULL,
                              `username` varchar(64) NOT NULL,
                              `account` varchar(64) NOT NULL,
                              `money` varchar(16) NOT NULL,
                              `fee` varchar(16) NOT NULL,
                              `sdtime` datetime NOT NULL,
                              `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_batch`
--

CREATE TABLE `oreo_batch` (
                              `batch` varchar(20) NOT NULL,
                              `allmoney` decimal(10,2) NOT NULL,
                              `fee` varchar(16) NOT NULL,
                              `time` datetime DEFAULT NULL,
                              `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_config`
--

CREATE TABLE `oreo_config` (
                               `k` varchar(200) NOT NULL,
                               `v` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oreo_config`
--

INSERT INTO `oreo_config` (`k`, `v`) VALUES
('agreement', '<p>感谢您选Oreo支付系统\n<p>本系统为基于PHP+MYsql5.6开发.\n<p>本系统为免费开源，开源目的则为了让更多的开发者参考和学习。\n<p>软件使用过程中，没有任何明示、暗示的保证。使用者必须自担风险，即使开发者被事先告知风险的可能性。软件使用中一切直接的、间接的损失，包括但是不限于故障、数据丢失、业务中断、设计误差、……，概不负责。\n<p>产生一切问题与本人（软件作者）无关。\n<p>选择继续安装即表示同意本协议。'),
('alidm_app_id', ''),
('alidm_merchant_private_key', ''),
('alidm_public_key', ''),
('alipayrsaPublicKey', 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsEhsBTVzNGCWXTS57xSDb8gRxfYpEh6ayZs86ByIuYdLPYTLvf0EN676hH0/DzscDuHE4HhBL1sIcG0rbHSNHiPxs7BXDY+Ix9/yNKmZFLwhCecTxybAKL5twVo9eU11L09CHHz+Q+TlCxAnfJoSAfpKnXVFdT0jhT+FMfsytVE/mneHIeqU/MOTbQ+j38dU1uh341UMrg+HblpoM9nWb38BqIJqccE9uEeif1CAmkmCC0pwyG96V/96XJBcgzgwHSE0APWBt5XAUze6bSGl+7wVBaR0d1GRVKZNcXzLcOlNCTPQmVrN1nfz2e+AsKgV2vCixtpaKAn/9yk2UyvWGwIDAQAB'),
('alipay_appid', ''),
('alipay_app_PublicKey', 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyzbgIrrAXqi9LRPV3m+XBziA0Ll4atuwFWiD6wBGCEw4mJIC86yHZb1ahwHRcEKVw0hOgYk0jDnJw6vbvYW7zU92GKBWmS03F0LI3yMpe7/vZeQ9SE9QbGsJ6TjtMI8MQllN/abAjR6n64TVAcyCbZ3ibreY2nNv1kD/+j5IT9RmOtCNQWXx6ZFOt21j8hQx+xsfy7v8ZDqywQ8vlcs4QM4Sjym6Oj/NEiUAITJ4fo2B/vP0WgoQm9Mcfv5Zx75l2Tjh6Qq8v7IS0LW7z0s4MjU9ru2Rtg9m6iBDPbCRueysXUTsVfRA4NYM0b69xiJwrI4wGH/4mBcpUYmZnZS9pQIDAQAB'),
('alipay_mode', '0'),
('alipay_rate', '98.5'),
('alivip', '0'),
('alivip_js', '<li>支付宝</li>\n<li>介绍1</li>\n<li>介绍2</li>\n<li>介绍3</li>'),
('alivip_money', '17'),
('ali_api_key', ''),
('ali_api_partner', ''),
('ali_api_seller_email', ''),
('ali_close_info', 'Oreo支付系统提醒您：我们正在维护该接口，请稍后再试！'),
('ali_codepay_api_id', '205717'),
('ali_codepay_api_key', '4eriPfxsC4ApsNDyt03VXdiHJoKTnonr'),
('ali_epay_api_id', ''),
('ali_epay_api_key', ''),
('ali_epay_api_url', ''),
('apiclient_cert', ''),
('apiclient_key', ''),
('api_link', 'https://www.oreopay.com'),
('authcode', 'cb468e068856b814d6e96aa0b3d638a'),
('beian', '苏ICP备18068633号-1'),
('CAPTCHA_ID', ''),
('oreo_applet_appid', ''),
('oreo_applet_secret', ''),
('chaojivip', '0'),
('chaoji_js', '<li>超级会员</li>\n<li>介绍1</li>\n<li>介绍2</li>\n<li>介绍3</li>'),
('chaoji_money', '0'),
('copyright', '©2019     Oreo版权所有'),
('cron_key', 'oreopay'),
('ddcs', '1'),
('ddcsuser', '1'),
('ddcsusje', '1'),
('ddcsus_money', '0.01'),
('ddcs_id', ''),
('ddcs_key', ''),
('ddcs_money', '0.01'),
('dizhi', '江苏省'),
('ds', '/jcbts.html'),
('gg', '一分价钱一分货<br>小户不跑，终成大户<br>易支付欢迎各位大佬入驻'),
('gg1', 'Oreo支付系统安全，稳定，好用！主要还是免费！'),
('gg2', 'Oreo支付系统安全，稳定，好用！主要还是免费！'),
('gg3', 'Oreo支付系统安全，稳定，好用！主要还是免费！'),
('gg4', 'Oreo支付系统安全，稳定，好用！主要还是免费！'),
('gg5', 'Oreo支付系统安全，稳定，好用！主要还是免费！'),
('goods_lj', '刷单|小视频|直播|钓鱼|黄色小视频|黄色视频|黄色|毛片|习近平|博彩|赌博|彩票|体彩|买球|AV|装逼|GV|草泥马|特么的|撕逼|玛拉戈壁|爆菊|JB|呆逼|本屌|齐B短裙|法克鱿|丢你老母|达菲鸡|装13|逼格|蛋疼|傻逼|绿茶婊|你妈的|表砸|屌爆了|买了个婊|已撸|吉跋猫|妈蛋|逗比|我靠|碧莲|碧池|然并卵|日了狗|屁民|吃翔|XX狗|淫家|你妹|浮尸国|滚粗|岛国|东京|东京热|小姐姐|小姐|特殊服务|上门服务|大保健|口活|口交|SM|黄色片|易支付余额充值|易支付|非法|不合法|恐怖|恶心'),
('goods_ljtis', 'Oreo支付系统提醒您：该订单商品违反了平台允售商品协议，已被安全系统拦截，停止交易。'),
('id', 'undefinedcont=<p>123123123123</p>'),
('is_payreg', '0'),
('is_reg', '1'),
('kfset_mqid', '133635'),
('local_domain', 'www.oreopay.com'),
('login_is', '0'),
('login_offtext', '110'),
('logo_url', '/oreo.png'),
('lxzt', '1'),
('mail_apikey', ''),
('mail_apiuser', ''),
('mail_cloud', '0'),
('mail_name', ''),
('mail_port', ''),
('mail_pwd', ''),
('mail_smtp', ''),
('mb3_bm1', 'CEO'),
('mb3_bm2', '总经理'),
('mb3_bm3', '技术'),
('mb3_jj1', 'Oreo支付系统'),
('mb3_jj2', 'Oreo支付系统'),
('mb3_jj3', 'Oreo支付系统'),
('mb3_name1', 'Oreo支付系统'),
('mb3_name2', 'Oreo支付系统'),
('mb3_name3', 'Oreo支付系统'),
('mb3_qq1', '2645147933'),
('mb3_qq2', '2645147933'),
('mb3_qq3', '2645147933'),
('mb_1', '申请友链'),
('mb_10', 'http://wpa.qq.com/ms=3&uin=317127SPAY&Menu=yes'),
('mb_2', 'http://wpa.qq.com/ms=3&uin=317127534PAY&Menu=yes'),
('mb_3', '申请友链'),
('mb_4', 'http://wpa.qq.com/?v=3&uin=3AY&Menu=yes'),
('mb_5', '申请友链'),
('mb_6', 'http://wpa.qq.com/msrd?v=3&uin=317127ite=ISPAY&Menu=yes'),
('mb_7', '申请友链'),
('mb_8', 'http://wpa.qq.com/msgr?v=3&uin=3te=ISPAY&Menu=yes'),
('mb_9', '申请友链'),
('money_rate', '60'),
('mz', '/jcbts.html'),
('ocode', '1'),
('order_name', '奥利奥饼干'),
('oreo_admin', 'admin'),
('oreo_auth_password', ''),
('oreo_auth_ukey', ''),
('oreo_auth_user', ''),
('oreo_codepay_api_id', ''),
('oreo_codepay_api_id_ali', ''),
('oreo_codepay_api_id_qq', ''),
('oreo_codepay_api_id_wx', ''),
('oreo_codepay_api_key', ''),
('oreo_codepay_api_key_ali', ''),
('oreo_codepay_api_key_qq', ''),
('oreo_codepay_api_key_wx', ''),
('oreo_cpay_appid', ''),
('oreo_cpay_appkey', ''),
('oreo_eshanghu_api_id_wx', ''),
('oreo_eshanghu_api_key_wx', ''),
('oreo_eshanghu_api_secret_wx', ''),
('oreo_etongshanghu_api_id_wx', ''),
('oreo_etongshanghu_api_key_wx', ''),
('oreo_etongshanghu_api_secret_wx', ''),
('oreo_lx', '0'),
('oreo_password', '9d2e8f1bd1d62899dcf9540d6391b5fc'),
('oreo_qq_token', ''),
('oreo_return', '1'),
('oreo_smstoken', ''),
('oreo_work_name', '<option value=\"支付问题\">支付问题</option>\n<option value=\"网站问题\">网站问题</option>\n<option value=\"提现到账问题\">提现到账问题</option>\n<option value=\"功能问题\">功能问题</option>\n<option value=\"发现BUG\">发现BUG</option>\n<option value=\"只想和你唠唠嗑\">只想和你唠唠嗑</option>'),
('oreo_wx_token', ''),
('oreo_yz_url', '0'),
('oreo_zmpay_api_id_wx', ''),
('oreo_zmpay_api_mchid_wx', ''),
('oreo_zmpay_api_token_wx', ''),
('owrk_zt', '1'),
('payer_show_name', 'Oreo支付系统余额提现'),
('phone', '您的电话号码'),
('PRIVATE_KEY', ''),
('qopen_id', ''),
('qopen_key', ''),
('qqpay_api', '1'),
('qqpay_mode', '0'),
('qqtz', '1'),
('qqvip', '0'),
('qqvip_js', '<li>QQ钱包</li>\n<li>介绍1</li>\n<li>介绍2</li>\n<li>介绍3</li>'),
('qqvip_money', '30'),
('qq_api_mchid', ''),
('qq_api_mchkey', ''),
('qq_close_info', 'Oreo支付系统提醒您：我们正在维护该接口，请稍后再试！'),
('qq_codepay_api_id', ''),
('qq_codepay_api_key', ''),
('qq_epay_api_id', ''),
('qq_epay_api_key', ''),
('qq_epay_api_url', ''),
('qq_rate', '70'),
('quicklogin', '0'),
('reg_offtext', 'Oreo支付系统提醒您：管理员已关闭商户在线申请功能，请稍后重试！'),
('reg_pid', ''),
('reg_price', ''),
('sdtx_money_min', '1'),
('settle_fee_max', '88888'),
('settle_fee_min', '0.5'),
('settle_money', '10'),
('settle_open', '1'),
('settle_rate', '0.005'),
('shixin', '1'),
('sh_codes', '1'),
('sms_appkey', ''),
('ssvip_ali', ''),
('ssvip_id', ''),
('ssvip_key', ''),
('ssvip_qq', ''),
('ssvip_url', ''),
('ssvip_wx', ''),
('ssvip_zdy', '0'),
('ssvip_zt', '0'),
('stype_1', '1'),
('stype_2', '1'),
('stype_3', '1'),
('stype_4', '1'),
('submit', '保存修改'),
('swap', '/jcbts.html'),
('sw_money_rate', '0'),
('template', 'index1'),
('updatekey', '388Xl8LHHKl9Ll8Z'),
('verifytype', '0'),
('vhms', '/jcbts.html'),
('webcontent', '最好用的第四方支付系统'),
('web_app', ''),
('web_is', '0'),
('web_lj', 'https://jq.qq.com/?_wv=1027&k=5NzuDMi'),
('web_mail', 'louis@2free.cn'),
('web_name', 'Oreo 支付系统'),
('web_offtext', '这里是维护提示信息'),
('web_qh', '707644978'),
('web_qq', '609451870'),
('web_wx', '客服微信'),
('weixin_qiye', '0'),
('weixin_rate', '50'),
('whmcs', '/jcbts.html'),
('work_types', 'value=\"\"是'),
('wxpay_h5', '1'),
('wxpay_mode', '0'),
('wxtransfer_apikey', ''),
('wxtransfer_appid', ''),
('wxtransfer_appkey', ''),
('wxtransfer_desc', ''),
('wxtransfer_mchid', ''),
('wxvip', '0'),
('wxvip_js', '<li>微信支付</li>\n<li>介绍1</li>\n<li>介绍2</li>\n<li>介绍3</li>'),
('wxvip_money', '5'),
('wx_api_appid', ''),
('wx_api_appsecret', ''),
('wx_api_key', ''),
('wx_api_mchid', ''),
('wx_close_info', 'Oreo支付系统提醒您：我们正在维护该接口，请稍后再试！'),
('wx_codepay_api_id', ''),
('wx_codepay_api_key', ''),
('wx_epay_api_id', ''),
('wx_epay_api_key', ''),
('wx_epay_api_url', ''),
('xaid', ''),
('xdomain', ''),
('xname', ''),
('xphone', ''),
('xqq', ''),
('xtext', '');

-- --------------------------------------------------------

--
-- 表的结构 `oreo_log`
--

CREATE TABLE `oreo_log` (
                            `id` int(11) NOT NULL,
                            `uid` int(11) DEFAULT NULL,
                            `type` varchar(20) DEFAULT NULL,
                            `date` datetime NOT NULL,
                            `city` varchar(20) DEFAULT NULL,
                            `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_lxjk`
--

CREATE TABLE `oreo_lxjk` (
                             `id` int(11) NOT NULL,
                             `oreo_lxname` varchar(16) NOT NULL,
                             `oreo_lxurl` varchar(32) NOT NULL,
                             `oreo_lxid` varchar(32) NOT NULL,
                             `oreo_lxkey` varchar(64) NOT NULL,
                             `oreo_lxtype` varchar(4) NOT NULL,
                             `oreo_lxfs` int(4) NOT NULL,
                             `oreo_lxje` varchar(16) NOT NULL,
                             `oreo_lxknum` varchar(16) NOT NULL,
                             `oreo_lrje` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_notice`
--

CREATE TABLE `oreo_notice` (
                               `id` int(11) NOT NULL,
                               `name` text NOT NULL,
                               `text` longtext NOT NULL,
                               `dtime` date NOT NULL,
                               `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oreo_notice`
--

INSERT INTO `oreo_notice` (`id`, `name`, `text`, `dtime`, `type`) VALUES
(1, '演示公告', 'Oreo授权系统，安全，好用，功能多，欢迎授权使用', '2019-07-31', 1);

-- --------------------------------------------------------

--
-- 表的结构 `oreo_order`
--

CREATE TABLE `oreo_order` (
                              `trade_no` varchar(64) NOT NULL,
                              `out_trade_no` varchar(64) NOT NULL,
                              `notify_url` varchar(64) DEFAULT NULL,
                              `return_url` varchar(64) DEFAULT NULL,
                              `type` varchar(20) NOT NULL,
                              `svip` int(11) NOT NULL,
                              `buyer` varchar(30) DEFAULT NULL,
                              `pid` int(11) NOT NULL,
                              `addtime` datetime DEFAULT NULL,
                              `endtime` datetime DEFAULT NULL,
                              `name` varchar(64) NOT NULL,
                              `money` varchar(32) NOT NULL,
                              `domain` varchar(32) DEFAULT NULL,
                              `ip` varchar(20) DEFAULT NULL,
                              `status` int(1) NOT NULL DEFAULT '0',
                              `lxtype` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_panuser`
--

CREATE TABLE `oreo_panuser` (
                                `id` int(11) NOT NULL,
                                `token` varchar(32) NOT NULL,
                                `user` varchar(32) NOT NULL,
                                `pwd` varchar(32) NOT NULL,
                                `email` varchar(32) DEFAULT NULL,
                                `phone` varchar(20) DEFAULT NULL,
                                `name` varchar(10) DEFAULT NULL,
                                `regtime` datetime DEFAULT NULL,
                                `logtime` datetime DEFAULT NULL,
                                `level` int(1) NOT NULL DEFAULT '1',
                                `type` int(1) NOT NULL DEFAULT '0',
                                `active` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_regcode`
--

CREATE TABLE `oreo_regcode` (
                                `id` int(11) NOT NULL,
                                `type` int(1) NOT NULL DEFAULT '0',
                                `code` varchar(32) NOT NULL,
                                `email` varchar(32) DEFAULT NULL,
                                `time` int(11) NOT NULL,
                                `ip` varchar(20) DEFAULT NULL,
                                `status` int(1) NOT NULL DEFAULT '0',
                                `trade_no` varchar(32) DEFAULT NULL,
                                `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_settle`
--

CREATE TABLE `oreo_settle` (
                               `id` int(11) NOT NULL,
                               `pid` int(11) NOT NULL,
                               `batch` varchar(20) NOT NULL,
                               `type` int(1) NOT NULL DEFAULT '1',
                               `username` varchar(10) NOT NULL,
                               `account` varchar(32) NOT NULL,
                               `money` decimal(10,2) NOT NULL,
                               `fee` decimal(10,2) NOT NULL,
                               `time` datetime DEFAULT NULL,
                               `status` int(1) NOT NULL DEFAULT '0',
                               `transfer_status` int(1) NOT NULL DEFAULT '0',
                               `transfer_result` varchar(64) DEFAULT NULL,
                               `transfer_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_user`
--

CREATE TABLE `oreo_user` (
                             `id` int(11) NOT NULL,
                             `newid` varchar(32) NOT NULL,
                             `uid` int(11) DEFAULT NULL,
                             `login_token` varchar(255) NOT NULL,
                             `key` varchar(32) NOT NULL,
                             `password` varchar(32) NOT NULL,
                             `gotype` int(11) NOT NULL,
                             `zdyfl` varchar(4) NOT NULL,
                             `rate` varchar(8) DEFAULT NULL,
                             `salipay_rate` varchar(4) NOT NULL,
                             `sweixin_rate` varchar(4) NOT NULL,
                             `sqq_rate` varchar(4) NOT NULL,
                             `ssvip` int(3) DEFAULT '1',
                             `alipay` int(3) NOT NULL DEFAULT '1',
                             `wxpay` int(3) NOT NULL DEFAULT '1',
                             `qqpay` int(3) NOT NULL DEFAULT '1',
                             `account` varchar(32) DEFAULT NULL,
                             `username` varchar(10) DEFAULT NULL,
                             `alipay_uid` varchar(32) DEFAULT NULL,
                             `qq_uid` varchar(32) DEFAULT NULL,
                             `wx_openid` varchar(255) NOT NULL,
                             `money` decimal(10,2) NOT NULL,
                             `settle_id` int(1) NOT NULL DEFAULT '1',
                             `email` varchar(32) DEFAULT NULL,
                             `phone` varchar(20) DEFAULT NULL,
                             `qq` varchar(20) DEFAULT NULL,
                             `url` varchar(64) DEFAULT NULL,
                             `addtime` datetime DEFAULT NULL,
                             `apply` int(1) NOT NULL DEFAULT '0',
                             `level` int(1) NOT NULL DEFAULT '1',
                             `type` int(1) NOT NULL DEFAULT '0',
                             `active` int(1) NOT NULL DEFAULT '0',
                             `alipaycode` varchar(255) NOT NULL,
                             `wxpaycode` varchar(255) NOT NULL,
                             `qqpaycode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_user_money`
--

CREATE TABLE `oreo_user_money` (
                                   `id` int(11) NOT NULL,
                                   `user_id` int(11) NOT NULL,
                                   `old_money` decimal(10,2) NOT NULL,
                                   `new_money` decimal(10,2) NOT NULL,
                                   `all_money` decimal(10,2) NOT NULL,
                                   `u_source` varchar(255) NOT NULL,
                                   `add_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_viporder`
--

CREATE TABLE `oreo_viporder` (
                                 `id` int(11) NOT NULL,
                                 `uid` int(8) DEFAULT NULL,
                                 `name` varchar(16) NOT NULL,
                                 `money` varchar(16) NOT NULL,
                                 `time` varchar(16) NOT NULL,
                                 `type` int(3) NOT NULL,
                                 `typname` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_work`
--

CREATE TABLE `oreo_work` (
                             `id` int(11) NOT NULL,
                             `uid` int(8) DEFAULT NULL,
                             `num` varchar(16) NOT NULL,
                             `types` varchar(16) NOT NULL,
                             `biaoti` text,
                             `text` text,
                             `qq` varchar(16) NOT NULL,
                             `edata` varchar(16) NOT NULL,
                             `huifu` text,
                             `wdata` varchar(16) NOT NULL,
                             `active` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oreo_wx_seesion`
--

CREATE TABLE `oreo_wx_seesion` (
                                   `id` int(11) NOT NULL,
                                   `token` varchar(255) NOT NULL,
                                   `open_id` varchar(255) NOT NULL,
                                   `addtime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `oreo_apply`
--
ALTER TABLE `oreo_apply`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `oreo_batch`
--
ALTER TABLE `oreo_batch`
    ADD PRIMARY KEY (`batch`);

--
-- 表的索引 `oreo_config`
--
ALTER TABLE `oreo_config`
    ADD PRIMARY KEY (`k`);

--
-- 表的索引 `oreo_log`
--
ALTER TABLE `oreo_log`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `oreo_lxjk`
--
ALTER TABLE `oreo_lxjk`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `oreo_notice`
--
ALTER TABLE `oreo_notice`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `oreo_order`
--
ALTER TABLE `oreo_order`
    ADD PRIMARY KEY (`trade_no`);

--
-- 表的索引 `oreo_panuser`
--
ALTER TABLE `oreo_panuser`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `oreo_regcode`
--
ALTER TABLE `oreo_regcode`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `oreo_settle`
--
ALTER TABLE `oreo_settle`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `oreo_user`
--
ALTER TABLE `oreo_user`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `oreo_user_money`
--
ALTER TABLE `oreo_user_money`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `oreo_viporder`
--
ALTER TABLE `oreo_viporder`
    ADD PRIMARY KEY (`id`),
    ADD KEY `uid` (`uid`),
    ADD KEY `money` (`money`);

--
-- 表的索引 `oreo_work`
--
ALTER TABLE `oreo_work`
    ADD PRIMARY KEY (`id`),
    ADD KEY `num` (`num`);

--
-- 表的索引 `oreo_wx_seesion`
--
ALTER TABLE `oreo_wx_seesion`
    ADD PRIMARY KEY (`id`),
    ADD KEY `token` (`token`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `oreo_apply`
--
ALTER TABLE `oreo_apply`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oreo_log`
--
ALTER TABLE `oreo_log`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- 使用表AUTO_INCREMENT `oreo_lxjk`
--
ALTER TABLE `oreo_lxjk`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oreo_notice`
--
ALTER TABLE `oreo_notice`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `oreo_panuser`
--
ALTER TABLE `oreo_panuser`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oreo_regcode`
--
ALTER TABLE `oreo_regcode`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oreo_settle`
--
ALTER TABLE `oreo_settle`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oreo_user`
--
ALTER TABLE `oreo_user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- 使用表AUTO_INCREMENT `oreo_user_money`
--
ALTER TABLE `oreo_user_money`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oreo_viporder`
--
ALTER TABLE `oreo_viporder`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oreo_work`
--
ALTER TABLE `oreo_work`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oreo_wx_seesion`
--
ALTER TABLE `oreo_wx_seesion`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
