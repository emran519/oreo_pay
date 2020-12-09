CREATE TABLE `oreo_alisettle` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `out_trade_no` varchar(32) NOT NULL,
  `username` varchar(10) NOT NULL,
  `account` varchar(32) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `bz` varchar(32) NOT NULL,
  `time` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `transfer_status` int(1) NOT NULL DEFAULT '0',
  `transfer_result` varchar(64) NOT NULL,
  `transfer_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE `oreo_batch` (
  `batch` varchar(20) NOT NULL,
  `allmoney` decimal(10,2) NOT NULL,
  `time` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `oreo_config` (
  `k` varchar(200) NOT NULL,
  `v` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `oreo_config` (`k`, `v`) VALUES
('oreo_admin', 'admin'),
('oreo_password', '9d2e8f1bd1d62899dcf9540d6391b5fc'),
('agreement', '        <p>一、总则</p>\n        <p>1.1 Oreo支付的所有权和运营权归Oreo支付技术有限公司所有。</p>\n        <p>1.2 用户在注册之前，应当仔细阅读本协议，并同意遵守本协议后方可成为注册用户。一旦注册成功，则用户与Oreo支付之间自动形成协议关系，用户应当受本协议的约束。用户在使用特殊的服务或产品时，应当同意接受相关协议后方能使用。</p>\n        <p>1.3 本协议则可由Oreo支付随时更新，用户应当及时关注并同意本站不承担通知义务。本站的通知、公告、声明或其它类似内容是本协议的一部分。</p>\n        <p>二、服务内容</p>\n        <p>2.1 Oreo支付的具体内容由本站根据实际情况提供。</p>\n        <p>2.2 本站仅提供相关的网络服务，除此之外与相关网络服务有关的设备(如个人电脑、手机、及其他与接入互联网或移动网有关的装置)及所需的费用(如为接入互联网而支付的电话费及上网费、为使用移动网而支付的手机费)均应由用户自行负担。</p>\n        <p>三、用户账号 </p>\n        <p>3.1 经本站注册系统完成注册程序并通过身份认证的用户即成为正式用户，可以获得本站规定用户所应享有的一切权限；未经认证仅享有本站规定的部分会员权限。Oreo支付有权对会员的权限设计进行变更。</p>\n        <p>3.2 用户只能按照注册要求使用真实姓名，及身份证号注册。用户有义务保证密码和账号的安全，用户利用该密码和账号所进行的一切活动引起的任何损失或损害，由用户自行承担全部责任，本站不承担任何责任。如用户发现账号遭到未授权的使用或发生其他任何安全问题，应立即修改账号密码并妥善保管，如有必要，请通知本站。因黑客行为或用户的保管疏忽导致账号非法使用，本站不承担任何责任。</p>\n        <p>四、使用规则</p>\n        <p>4.1 遵守中华人民共和国相关法律法规，包括但不限于《中华人民共和国计算机信息系统安全保护条例》、《计算机软件保护条例》、《最高人民法院关于审理涉及计算机网络著作权纠纷案件适用法律若干问题的解释(法释[2004]1号)》、《全国人大常委会关于维护互联网安全的决定》、《互联网电子公告服务管理规定》、《互联网新闻信息服务管理规定》、《互联网著作权行政保护办法》和《信息网络传播权保护条例》等有关计算机互联网规定和知识产权的法律和法规、实施办法。 </p>\n        <p>4.2 用户对其自行发表、上传或传送的内容负全部责任，所有用户不得在本站任何页面发布、转载、传送含有下列内容之一的信息，否则本站有权自行处理并不通知用户：</p>\n		<p>(1)违反宪法确定的基本原则的；</p>\n		<p>(2)危害国家安全，泄漏国家机密，颠覆国家政权，破坏国家统一的；</p>\n		<p>(3)损害国家荣誉和利益的；</p>\n		<p>(4)煽动民族仇恨、民族歧视，破坏民族团结的；</p>\n		<p>(5)破坏国家宗教政策，宣扬邪教和封建迷信的；</p>\n		<p>(6)散布谣言，扰乱社会秩序，破坏社会稳定的；</p>\n		<p>(7)散布淫秽、色情、赌博、暴力、恐怖或者教唆犯罪的；</p>\n		<p>(8)侮辱或者诽谤他人，侵害他人合法权益的；</p>\n		<p>(9)煽动非法集会、结社、游行、示威、聚众扰乱社会秩序的；</p>\n		<p>(10)以非法民间组织名义活动的；</p>\n		<p>(11)含有法律、行政法规禁止的其他内容的。</p>\n		<p>(12)禁止未获授权的商户接入(如 私服、小说、影视等)。</p>\n        <p>4.3 用户承诺对其发表或者上传于本站的所有信息(即属于《中华人民共和国著作权法》规定的作品，包括但不限于文字、图片、音乐、电影、表演和录音录像制品和电脑程序等)均享有完整的知识产权，或者已经得到相关权利人的合法授权；如用户违反本条规定造成本站被第三人索赔的，用户应全额补偿本站一切费用(包括但不限于各种赔偿费、诉讼代理费及为此支出的其它合理费用)； </p>\n        <p>4.4 当第三方认为用户发表或者上传于本站的信息侵犯其权利，并根据《信息网络传播权保护条例》或者相关法律规定向本站发送权利通知书时，用户同意本站可以自行判断决定删除涉嫌侵权信息，除非用户提交书面证据材料排除侵权的可能性，本站将不会自动恢复上述删除的信息；</p>\n        <p>(1)不得为任何非法目的而使用网络服务系统；</p>\n        <p>(2)遵守所有与网络服务有关的网络协议、规定和程序； </p>\n        <p>(3)不得利用本站进行任何可能对互联网的正常运转造成不利影响的行为；</p>\n        <p>(4)不得利用本站进行任何不利于本站的行为。</p>\n        <p>4.5 如用户在使用网络服务时违反上述任何规定，本站有权要求用户改正或直接采取一切必要的措施(包括但不限于删除用户张贴的内容、暂停或终止用户使用网络服务的权利)以减轻用户不当行为而造成的影响。</p>\n        <p>五、隐私保护</p>\n        <p>5.1 本站不对外公开或向第三方提供单个用户的注册资料及用户在使用网络服务时存储在本站的非公开内容，但下列情况除外：</p>\n        <p>(1)事先获得用户的明确授权；</p>\n        <p>(2)根据有关的法律法规要求； </p>\n        <p>(3)按照相关政府主管部门的要求；</p>\n        <p>(4)为维护社会公众的利益。</p>\n        <p>5.2 本站可能会与第三方合作向用户提供相关的网络服务，在此情况下，如该第三方同意承担与本站同等的保护用户隐私的责任，则本站有权将用户的注册资料等提供给该第三方。</p>\n        <p>5.3 在不透露单个用户隐私资料的前提下，本站有权对整个用户数据库进行分析并对用户数据库进行商业上的利用。</p>\n        <p>六、版权声明</p>\n        <p>6.1 本站的文字、图片、音频、视频等版权均归Oreo支付技术有限公司享有或与作者共同享有，未经本站许可，不得任意转载。</p>\n        <p>6.2 本站特有的标识、版面设计、编排方式等版权均属Oreo支付技术有限公司享有，未经本站许可，不得任意复制或转载。</p>\n        <p>6.3 使用本站的任何内容均应注明“来源于Oreo支付”及署上作者姓名，按法律规定需要支付稿酬的，应当通知本站及作者及支付稿酬，并独立承担一切法律责任。</p>\n        <p>6.4 本站享有所有作品用于其它用途的优先权，包括但不限于网站、电子杂志、平面出版等，但在使用前会通知作者，并按同行业的标准支付稿酬。 </p>\n        <p>6.5 本站所有内容仅代表作者自己的立场和观点，与本站无关，由作者本人承担一切法律责任。 </p>\n        <p>6.6 恶意转载本站内容的，本站保留将其诉诸法律的权利。 </p>\n        <p>七、责任声明 </p>\n        <p>7.1 用户明确同意其使用本站网络服务所存在的风险及一切后果将完全由用户本人承担，Oreo支付对此不承担任何责任。 </p>\n        <p>7.2 本站无法保证网络服务一定能满足用户的要求，也不保证网络服务的及时性、安全性、准确性。 </p>\n        <p>7.3 本站不保证为方便用户而设置的外部链接的准确性和完整性，同时，对于该等外部链接指向的不由本站实际控制的任何网页上的内容，本站不承担任何责任。</p>\n        <p>7.4 对于因不可抗力或本站不能控制的原因造成的网络服务中断或其它缺陷，本站不承担任何责任，但将尽力减少因此而给用户造成的损失和影响。 </p>\n        <p>7.5 对于站向用户提供的下列产品或者服务的质量缺陷本身及其引发的任何损失，本站无需承担任何责任： </p>\n        <p>(1)本站向用户免费提供的各项网络服务； </p>\n        <p>(2)本站向用户赠送的任何产品或者服务。 </p>\n        <p>7.6 本站有权于任何时间暂时或永久修改或终止本服务(或其任何部分)，而无论其通知与否，本站对用户和任何第三人均无需承担任何责任。 </p>\n        <p>八、附则</p>\n        <p>8.1 本协议的订立、执行和解释及争议的解决均应适用中华人民共和国法律。 </p>\n        <p>8.2 如本协议中的任何条款无论因何种原因完全或部分无效或不具有执行力，本协议的其余条款仍应有效并且有约束力。 </p>\n        <p>8.3 本协议解释权及修订权归Oreo支付技术有限公司所有。 Oreo支付系统官方QQ交流群：正在策划中</p>'),
('alidm_app_id', ''),
('alidm_merchant_private_key', ''),
('alidm_public_key', ''),
('alipayrsaPublicKey', 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsEhsBTVzNGCWXTS57xSDb8gRxfYpEh6ayZs86ByIuYdLPYTLvf0EN676hH0/DzscDuHE4HhBL1sIcG0rbHSNHiPxs7BXDY+Ix9/yNKmZFLwhCecTxybAKL5twVo9eU11L09CHHz+Q+TlCxAnfJoSAfpKnXVFdT0jhT+FMfsytVE/mneHIeqU/MOTbQ+j38dU1uh341UMrg+HblpoM9nWb38BqIJqccE9uEeif1CAmkmCC0pwyG96V/96XJBcgzgwHSE0APWBt5XAUze6bSGl+7wVBaR0d1GRVKZNcXzLcOlNCTPQmVrN1nfz2e+AsKgV2vCixtpaKAn/9yk2UyvWGwIDAQAB'),
('alipay_appid', ''),
('alipay_mode', '0'),
('alipay_rate', ''),
('alivip', '0'),
('alivip_js', '<li>支付宝</li>\n<li>介绍1</li>\n<li>介绍2</li>\n<li>介绍3</li>'),
('alivip_money', '1'),
('ali_api_key', ''),
('ali_api_partner', ''),
('ali_api_seller_email', ''),
('ali_close_info', 'Oreo支付系统，安全，稳定！'),
('ali_codepay_api_id', '205717'),
('ali_codepay_api_key', '4eriPfxsC4ApsNDyt03VXdiHJoKTnonr'),
('ali_epay_api_id', ''),
('ali_epay_api_key', ''),
('ali_epay_api_url', ''),
('api_link', 'www.oreopay.com'),
('authcode', 'cb468e068856b814d6e96aa0b3d638a'),
('beian', '苏ICP备18068633号-1'),
('CAPTCHA_ID', ''),
('chaojivip', '0'),
('chaoji_js', '<li>超级会员</li>\n<li>介绍1</li>\n<li>介绍2</li>\n<li>介绍3</li>'),
('chaoji_money', '1'),
('copyright', '©2019     Oreo版权所有'),
('cron_key', 'oreopay'),
('ddcs', '0'),
('ddcsuser', '1'),
('ddcsusje', '1'),
('ddcsus_money', '0.01'),
('ddcs_id', ''),
('ddcs_key', ''),
('ddcs_money', ''),
('dizhi', '江苏省'),
('ds', '/jcbts.html'),
('gg', '一分价钱一分货<br>小户不跑，终成大户<br>易支付欢迎各位大佬入驻'),
('goods_lj', '刷单|小视频|直播|钓鱼|黄色小视频|黄色视频|黄色|毛片|习近平|博彩|赌博|彩票|体彩|买球|AV|装逼|GV|草泥马|特么的|撕逼|玛拉戈壁|爆菊|JB|呆逼|本屌|齐B短裙|法克鱿|丢你老母|达菲鸡|装13|逼格|蛋疼|傻逼|绿茶婊|你妈的|表砸|屌爆了|买了个婊|已撸|吉跋猫|妈蛋|逗比|我靠|碧莲|碧池|然并卵|日了狗|屁民|吃翔|XX狗|淫家|你妹|浮尸国|滚粗|岛国|东京|东京热|小姐姐|小姐|特殊服务|上门服务|大保健|口活|口交|SM|黄色片|易支付余额充值|易支付|非法|不合法|恐怖|恶心'),
('goods_ljtis', 'Oreo支付系统提醒您：该订单商品违反了平台允售商品协议，已被安全系统拦截，停止交易。'),
('id', 'undefinedcont=<p>123123123123</p>'),
('is_payreg', '0'),
('is_reg', '1'),
('kfset_mqid', '133635'),
('local_domain', 'www.oreopay.com'),
('login_is', '0'),
('login_offtext', ''),
('logo_url', '/oreo.png'),
('lxzt', '1'),
('mail_apikey', ''),
('mail_apiuser', ''),
('mail_cloud', '0'),
('mail_name', ''),
('mail_port', ''),
('mail_pwd', ''),
('mail_smtp', ''),
('money_rate', '99'),
('mz', '/jcbts.html'),
('ocode', '1'),
('order_name', '奥利奥饼干'),
('oreo_codepay_api_id', ''),
('oreo_codepay_api_id_ali', ''),
('oreo_codepay_api_id_qq', ''),
('oreo_codepay_api_id_wx', ''),
('oreo_codepay_api_key', ''),
('oreo_codepay_api_key_ali', ''),
('oreo_codepay_api_key_qq', ''),
('oreo_codepay_api_key_wx', ''),
('oreo_eshanghu_api_id_wx', ''),
('oreo_eshanghu_api_key_wx', ''),
('oreo_eshanghu_api_secret_wx', ''),
('oreo_lx', '0'),
('oreo_pwd', ''),
('oreo_return', '1'),
('oreo_user', ''),
('oreo_work_name', '<option value=\"支付问题\">支付问题</option>\r\n<option value=\"网站问题\">网站问题</option>\r\n<option value=\"提现到账问题\">提现到账问题</option>\r\n<option value=\"功能问题\">功能问题</option>\r\n<option value=\"发现BUG\">发现BUG</option>\r\n<option value=\"只想和你唠唠嗑\">只想和你唠唠嗑</option>'),
('oreo_yctype', '1'),
('oreo_yz_url', '0'),
('owrk_zt', '1'),
('payer_show_name', 'Oreo支付系统'),
('phone', '您的电话号码'),
('PRIVATE_KEY', ''),
('qopen_id', ''),
('qopen_key', ''),
('qqpay_api', '1'),
('qqpay_mode', '0'),
('qqtz', '0'),
('qqvip', '0'),
('qqvip_js', '<li>QQ钱包</li>\n<li>介绍1</li>\n<li>介绍2</li>\n<li>介绍3</li>'),
('qqvip_money', '30'),
('qq_api_mchid', ''),
('qq_api_mchkey', ''),
('qq_close_info', 'Oreo支付系统，安全，稳定！'),
('qq_codepay_api_id', '205717'),
('qq_codepay_api_key', '4eriPfxsC4ApsNDyt03VXdiHJoKTnonr'),
('qq_epay_api_id', ''),
('qq_epay_api_key', ''),
('qq_epay_api_url', ''),
('qq_rate', ''),
('quicklogin', '1'),
('reg_offtext', 'Oreo支付系统提醒您：管理员已关闭商户在线申请功能，请稍后重试！'),
('reg_pid', '1000'),
('reg_price', '0.01'),
('sdtx_money_min', ''),
('settle_fee_max', ''),
('settle_fee_min', ''),
('settle_money', ''),
('settle_open', '1'),
('settle_rate', ''),
('shixin', '0'),
('sh_codes', '0'),
('sms_appkey', ''),
('ssvip_ali', ''),
('ssvip_id', ''),
('ssvip_key', ''),
('ssvip_qq', ''),
('ssvip_url', ''),
('ssvip_wx', ''),
('ssvip_zdy', '1'),
('ssvip_zt', '0'),
('stype_1', '1'),
('stype_2', '1'),
('stype_3', '1'),
('stype_4', '1'),
('submit', '保存修改'),
('swap', '/jcbts.html'),
('sw_money_rate', '0'),
('template', 'oreo'),
('updatekey', ''),
('verifytype', '0'),
('vhms', '/jcbts.html'),
('webcontent', '最好用的第四方支付系统'),
('web_app', 'http://www.oreopay.com'),
('web_is', '0'),
('web_lj', 'https://jq.qq.com/?_wv=1027&k=5NzuDMi'),
('web_mail', 'louis@2free.cn'),
('web_name', 'Oreo 支付系统'),
('web_offtext', '这里是维护提示信息'),
('web_qh', '707644978'),
('web_qq', '609451870'),
('web_wx', '客服微信'),
('weixin_rate', ''),
('whmcs', '/jcbts.html'),
('work_types', 'value=\"\"是'),
('wxpay_h5', '1'),
('wxpay_mode', '0'),
('wxtransfer_desc', 'Oreo支付系统'),
('wxvip', '0'),
('wxvip_js', '<li>微信支付</li>\n<li>介绍1</li>\n<li>介绍2</li>\n<li>介绍3</li>'),
('wxvip_money', '1'),
('wx_api_appid', ''),
('wx_api_appsecret', ''),
('wx_api_key', ''),
('wx_api_mchid', ''),
('wx_close_info', 'Oreo支付系统，安全，稳定！'),
('wx_codepay_api_id', '205717'),
('wx_codepay_api_key', '4eriPfxsC4ApsNDyt03VXdiHJoKTnonr'),
('wx_epay_api_id', ''),
('wx_epay_api_key', ''),
('wx_epay_api_url', '');

CREATE TABLE `oreo_log` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `city` varchar(20) DEFAULT NULL,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `oreo_notice` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `text` longtext NOT NULL,
  `dtime` date NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `oreo_user` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `key` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
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

CREATE TABLE `oreo_viporder` (
  `id` int(11) NOT NULL,
  `uid` int(8) DEFAULT NULL,
  `name` varchar(16) NOT NULL,
  `money` varchar(16) NOT NULL,
  `time` varchar(16) NOT NULL,
  `type` int(3) NOT NULL,
  `typname` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

ALTER TABLE `oreo_alisettle`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `oreo_apply`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `oreo_batch`
  ADD PRIMARY KEY (`batch`);

ALTER TABLE `oreo_config`
  ADD PRIMARY KEY (`k`);

ALTER TABLE `oreo_log`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `oreo_lxjk`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `oreo_notice`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `oreo_order`
  ADD PRIMARY KEY (`trade_no`);

ALTER TABLE `oreo_panuser`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `oreo_regcode`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `oreo_settle`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `oreo_user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `oreo_viporder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `money` (`money`);

ALTER TABLE `oreo_work`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num` (`num`);

ALTER TABLE `oreo_alisettle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `oreo_apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `oreo_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `oreo_lxjk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `oreo_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `oreo_panuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `oreo_regcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `oreo_settle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `oreo_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

ALTER TABLE `oreo_viporder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `oreo_work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;