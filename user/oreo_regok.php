<?php 
require_once('../oreo/Oreo.Cron.php');
$alipay_config['partner'] = $conf['reg_pid'];
$alipay_config['key'] = $DB->query("SELECT `key` FROM `oreo_user` WHERE `id`='{$conf['reg_pid']}' limit 1")->fetchColumn();
require_once("../oreo/oreo_function/pay/epay/epay_notify.class.php");

@header('Content-Type: text/html; charset=UTF-8');

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {
	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];

    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		$srow=$DB->query("SELECT * FROM oreo_regcode WHERE trade_no='{$trade_no}' limit 1")->fetch();
		$array = explode('|',$srow['data']);
		$type = addslashes($array[0]);
		$account = addslashes($array[1]);
		$username = addslashes($array[2]);
		$url = addslashes($array[3]);
        $pass = addslashes($array[4]);
        $qq = addslashes($array[7]);
        $phone = addslashes($array[8]);
        $password = md5($pass.$password_hash);
		if($srow['type']==1){
			$phone = addslashes($srow['email']);
			$email = addslashes($array[5]);
		}else{
			$email = addslashes($srow['email']);
		}
		if($conf['alivip']==1){
		$sali=2;
	    }else{
		$sali=1;
	    }
	    if($conf['wxvip']==1){
		$swx=2;
	    }else{
		$swx=1;
	    }
	    if($conf['qqvip']==1){
		$sqq=2;
	    }else{
		$sqq=1;
	    }
		if($srow['status']==0){
			$DB->exec("update `oreo_regcode` set `status` ='1' where `id`='{$srow['id']}'");
			$key = random(11);
		    $sds=$DB->exec("INSERT INTO `oreo_user` (`key`, `account`, `username`, `money`, `url`, `qq`, `password`, `email`, `phone`, `addtime`, `type`, `active`, `ssvip`, `zdyfl`, `settle_id`, `alipay`, `wxpay`, `qqpay`) VALUES ('{$key}', '{$account}', '{$username}', '0', '{$url}', '{$qq}', '{$password}', '{$email}', '{$phone}', '{$date}', '0', '1', '2', '0', '{$type}', '{$sali}', '{$swx}', '{$sqq}')");
		    $pid=$DB->lastInsertId();
			if($sds){
				$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
				$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
				$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath.'/';
				$sub = $conf['web_name'].' - 注册成功通知';
				$msg = '<h2>商户注册成功通知</h2>感谢您注册'.$conf['web_name'].'！<br/>您的商户ID（即登录账号）：'.$pid.'<br/>您的登录密码：'.$pass.'<br/>您的商户秘钥：'.$key.'<br/>'.$conf['web_name'].'官网：<a href="http://'.$_SERVER['HTTP_HOST'].'/" target="_blank">'.$_SERVER['HTTP_HOST'].'</a><br/>【<a href="'.$siteurl.'" target="_blank">商户管理后台</a>】';
				$result = send_mail($email, $sub, $msg);
			}else{
				sysmsg('申请商户失败！'.$DB->errorCode());
			}
		}else{
			$row=$DB->query("SELECT * FROM oreo_user WHERE account='$account' and email='$email' order by id desc limit 1")->fetch();
			if($row){
				$pid = $row['id'];
				$key = $row['key'];
			}else{
				sysmsg('申请商户失败！');
			}
		}
    }
}
else {
    sysmsg('签名校验失败！');
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
		name="viewport">
		<meta content="<?php echo $conf['webcontent']?>,<?php echo $conf['web_name']?>"
		name="description" />
		<meta name="author" content="<?php echo $conf['local_domain']?>" />
		<title>
			申请商户成功 |
			<?php echo $conf[ 'web_name']?>
		</title>
		<link href="../assets/new_user/css/app.min.css" rel="stylesheet"
		type="text/css">
		<style type="text/css">
*{margin:0;padding:0;list-style-type:none;}
a,img{border:0;}
</style>
	</head>
	<body class="authentication-bg">
	<div id="container" style="width:100%;height:100%;position: fixed;margin-top: -5em;">
    <div id="anitOut"></div>
</div>
		<div class="account-pages mt-5 mb-5">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-5">
						<div class="card">
							<!-- Logo -->
							<div class="card-header pt-4 pb-4 text-center bg-primary">
								<span>
									<font color="white" size="5">
										<b>
											<?php echo $conf[ 'web_name']?>
										</b>
									</font>
								</span>
							</div>
							<div class="card-body p-4">
								<div class="text-center w-75 m-auto">
									<h4 class="text-dark-50 text-center mt-0 font-weight-bold">
										申请商户成功！
									</h4>
								</div>
								<form name="form" method="post" action="login.php">
									<div class="form-group">
										<label for="emailaddress">
											以下为您的商户信息：
										</label>
										<label>
											商户ID：
										</label>
										<input class="form-control" type="text" name="pid" value="<?php echo $pid?>">
									</div>
									<div class="form-group">
										<label>
											商户密钥：
										</label>
										<input class="form-control" type="text" name="key" value="<?php echo $key?>">
									</div>
									<div class="form-group mb-0 text-center">
										<button class="btn btn-primary" type="submit" id="submit" ng-click="login()"
										ng-disabled="form.$invalid">
											返回登录
										</button>
									</div>
								</form>
							</div>
							<!-- end card -->
							<div class="row mt-3">
								<div class="col-12 text-center">
									<p class="text-muted">
										商户信息已经发送到您的邮箱中
									</p>
								</div>
								<!-- end col-->
							</div>
							<!-- end row -->
						</div>
						<!-- end col -->
					</div>
					<!-- end row -->
				</div>
				<!-- end container -->
			</div>
		</div>
		<!-- end page -->
		<footer class="footer footer-alt" style="text-transform: uppercase;">
			Copyright &copy; 2018-
			<?=date( 'Y')?>
				<?php echo $conf[ 'web_name']?>
					-
					<?php echo $_SERVER[ 'SERVER_NAME']?>
		</footer>
		<script src="../assets/new_user/js/app.min.js"></script>
		<script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
		<script type="text/javascript">
$(function () {
    if (!window.ActiveXObject && !!document.createElement("canvas").getContext) {
        $.getScript("../assets/new_user/js/cav.js",
                function () {
                    var t = {
                        width: 1.5,
                        height: 1.5,
                        depth: 10,
                        segments: 12,
                        slices: 6,
                        xRange: 0.8,
                        yRange: 0.1,
                        zRange: 1,
                        ambient: "#525252",
                        diffuse: "#FFFFFF",
                        speed: 0.0002
                    };
                    var G = {
                        count: 2,
                        xyScalar: 1,
                        zOffset: 100,
                        ambient: "#002c4a",
                        diffuse: "#005584",
                        speed: 0.001,
                        gravity: 1200,
                        dampening: 0.95,
                        minLimit: 10,
                        maxLimit: null,
                        minDistance: 20,
                        maxDistance: 400,
                        autopilot: false,
                        draw: false,
                        bounds: CAV.Vector3.create(),
                        step: CAV.Vector3.create(Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1))
                    };
                    var m = "canvas";
                    var E = "svg";
                    var x = {
                        renderer: m
                    };
                    var i, n = Date.now();
                    var L = CAV.Vector3.create();
                    var k = CAV.Vector3.create();
                    var z = document.getElementById("container");
                    var w = document.getElementById("anitOut");
                    var D, I, h, q, y;
                    var g;
                    var r;

                    function C() {
                        F();
                        p();
                        s();
                        B();
                        v();
                        K(z.offsetWidth, z.offsetHeight);
                        o()
                    }

                    function F() {
                        g = new CAV.CanvasRenderer();
                        H(x.renderer)
                    }

                    function H(N) {
                        if (D) {
                            w.removeChild(D.element)
                        }
                        switch (N) {
                            case m:
                                D = g;
                                break
                        }
                        D.setSize(z.offsetWidth, z.offsetHeight);
                        w.appendChild(D.element)
                    }

                    function p() {
                        I = new CAV.Scene()
                    }

                    function s() {
                        I.remove(h);
                        D.clear();
                        q = new CAV.Plane(t.width * D.width, t.height * D.height, t.segments, t.slices);
                        y = new CAV.Material(t.ambient, t.diffuse);
                        h = new CAV.Mesh(q, y);
                        I.add(h);
                        var N, O;
                        for (N = q.vertices.length - 1; N >= 0; N--) {
                            O = q.vertices[N];
                            O.anchor = CAV.Vector3.clone(O.position);
                            O.step = CAV.Vector3.create(Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1));
                            O.time = Math.randomInRange(0, Math.PIM2)
                        }
                    }

                    function B() {
                        var O, N;
                        for (O = I.lights.length - 1; O >= 0; O--) {
                            N = I.lights[O];
                            I.remove(N)
                        }
                        D.clear();
                        for (O = 0; O < G.count; O++) {
                            N = new CAV.Light(G.ambient, G.diffuse);
                            N.ambientHex = N.ambient.format();
                            N.diffuseHex = N.diffuse.format();
                            I.add(N);
                            N.mass = Math.randomInRange(0.5, 1);
                            N.velocity = CAV.Vector3.create();
                            N.acceleration = CAV.Vector3.create();
                            N.force = CAV.Vector3.create()
                        }
                    }

                    function K(O, N) {
                        D.setSize(O, N);
                        CAV.Vector3.set(L, D.halfWidth, D.halfHeight);
                        s()
                    }

                    function o() {
                        i = Date.now() - n;
                        u();
                        M();
                        requestAnimationFrame(o)
                    }

                    function u() {
                        var Q, P, O, R, T, V, U, S = t.depth / 2;
                        CAV.Vector3.copy(G.bounds, L);
                        CAV.Vector3.multiplyScalar(G.bounds, G.xyScalar);
                        CAV.Vector3.setZ(k, G.zOffset);
                        for (R = I.lights.length - 1; R >= 0; R--) {
                            T = I.lights[R];
                            CAV.Vector3.setZ(T.position, G.zOffset);
                            var N = Math.clamp(CAV.Vector3.distanceSquared(T.position, k), G.minDistance, G.maxDistance);
                            var W = G.gravity * T.mass / N;
                            CAV.Vector3.subtractVectors(T.force, k, T.position);
                            CAV.Vector3.normalise(T.force);
                            CAV.Vector3.multiplyScalar(T.force, W);
                            CAV.Vector3.set(T.acceleration);
                            CAV.Vector3.add(T.acceleration, T.force);
                            CAV.Vector3.add(T.velocity, T.acceleration);
                            CAV.Vector3.multiplyScalar(T.velocity, G.dampening);
                            CAV.Vector3.limit(T.velocity, G.minLimit, G.maxLimit);
                            CAV.Vector3.add(T.position, T.velocity)
                        }
                        for (V = q.vertices.length - 1; V >= 0; V--) {
                            U = q.vertices[V];
                            Q = Math.sin(U.time + U.step[0] * i * t.speed);
                            P = Math.cos(U.time + U.step[1] * i * t.speed);
                            O = Math.sin(U.time + U.step[2] * i * t.speed);
                            CAV.Vector3.set(U.position, t.xRange * q.segmentWidth * Q, t.yRange * q.sliceHeight * P, t.zRange * S * O - S);
                            CAV.Vector3.add(U.position, U.anchor)
                        }
                        q.dirty = true
                    }

                    function M() {
                        D.render(I)
                    }

                    function J(O) {
                        var Q, N, S = O;
                        var P = function (T) {
                            for (Q = 0, l = I.lights.length; Q < l; Q++) {
                                N = I.lights[Q];
                                N.ambient.set(T);
                                N.ambientHex = N.ambient.format()
                            }
                        };
                        var R = function (T) {
                            for (Q = 0, l = I.lights.length; Q < l; Q++) {
                                N = I.lights[Q];
                                N.diffuse.set(T);
                                N.diffuseHex = N.diffuse.format()
                            }
                        };
                        return {
                            set: function () {
                                P(S[0]);
                                R(S[1])
                            }
                        }
                    }

                    function v() {
                        window.addEventListener("resize", j)
                    }

                    function A(N) {
                        CAV.Vector3.set(k, N.x, D.height - N.y);
                        CAV.Vector3.subtract(k, L)
                    }

                    function j(N) {
                        K(z.offsetWidth, z.offsetHeight);
                        M()
                    }

                    C();
                })
    } else {
        alert('调用cav.js失败');
    }
});
</script>
	</body>
</html>