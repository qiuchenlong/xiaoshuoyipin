<!DOCTYPE html>
<!-- saved from url=(0025)http://laikan.motie.com/i -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="MobileOptimized" content="320">
		<meta http-equiv="cleartype" content="on">
		<meta name="wap-font-scale" content="no">
		<link rel="stylesheet" type="text/css" href="Public/css/common.css" media="all">
		<title>个人中心</title>
		<link rel="stylesheet" type="text/css" href="Public/css/i.css" media="all">
		<script type="text/javascript" src="Public/js/Zepto-1.2.0.js"></script>
		<script src="Public/js/jquery-2.1.4.js"></script>
	</head>
	<body class="gray-bg">
	    <div class="wrapper">
	        <!-- header start -->
			<div class="lk-header" id="hd">
			    <span class="arrow-left" onclick="window.history.go(-1)"><a href="javascript:;"><img src="Public/img/lk_arrowLeft.png"></a></span>
			    <b>个人中心</b>
			    <!--<span class="indexIco"><a href="http://laikan.motie.com/"><img src="Public/img/lk_index_ico.png"></a></span>-->
			</div> 
	        
	        <!--i detail-->
	        <div class="i_cover">
	            <dl>
	                <dt><img src="Public/img/laikan_person_ico.png"></dt>
	                <dd>
	                    <p><span class="name">{$Obj.name}</span>普通用户</p>
	                    <p><span class="id">登录账号：</span>（QQ帐号）</p>
	                </dd>
	            </dl>
	        </div>
	
	    <!--i cont start-->
	        <!-- 我的账户 start -->
	        <div class="user_level">
	            <a href="index.php?c=Index&a=myCount">
	                <span class="l"><img src="Public/img/i-backNew-ico.png"></span>
	                <b>我的账户</b>
	                <span class="r" style="top:1.4rem">{$Obj.money}&nbsp;来看币&nbsp;|&nbsp;{$Obj.reading_notes}&nbsp;阅读券</span>
	            </a>
	        </div>
	        <!-- 充值 start -->
	        <div class="user_level">
	            <a href="index.php?c=Index&a=chongzhi">
	                <span class="l"><img src="Public/img/i_pay_ico.png"></span>
	                <b>充值</b>
	                <span class="r"><img src="Public/img/i_arrowRight_ico.png"></span>
	            </a>
	        </div>
	        <!-- 充值记录 start -->
	        <div class="user_level">
	            <a href="index.php?c=Index&a=jilu">
	                <span class="l"><img src="Public/img/i_record_ico.png"></span>
	                <b>充值记录</b>
	                <span class="r"><img src="Public/img/i_arrowRight_ico.png"></span>
	            </a>
	        </div>
	        <!-- 消费记录 start -->
	        <div class="user_level mg_b10">
	            <a href="#">
	                <span class="l"><img src="Public/img/i_cosume_ico.png"></span>
	                <b>消费记录</b>
	                <span class="r"><img src="Public/img/i_arrowRight_ico.png"></span>
	            </a>
	        </div>
	
	        
	        <!-- 绑定手机 start -->
	        <div class="user_level mg_b10">
	            <a href="#">
	                <span class="l"><img src="Public/img/i_bindM_ico.png"></span>
	                <b>绑定手机</b>
	                <span class="r">未绑定<img src="Public/img/i_arrowRight_ico.png">
	                </span>
	            </a>
	        </div>
	        
	        
	        <!-- 我的书架 start -->
	        <div class="user_level">
	            <a href="index.php?m=api&c=book&a=mybook">
	                <span class="l"><img src="Public/img/i_bookList_ico.png"></span>
	                <b>我的书架</b>
	                <span class="r">
	                 
	                    
	                    <img src="Public/img/i_arrowRight_ico.png">
	                </span>
	            </a>
	        </div>
	        <!-- 阅读记录 start -->
	        <div class="user_level">
	            <a href="index.php?c=Index&a=quedujilu">
	                <span class="l"><img src="Public/img/i_readCord_ico.png"></span>
	                <b>阅读记录</b>
	                <span class="r">
	           
	                    
	                    <img src="Public/img/i_arrowRight_ico.png">
	                </span>
	            </a>
	        </div>
	        
	                
	        <!-- 联系我们 start -->
	        <div class="user_level mg_b10">
	            <a href="index.php?c=Index&a=lianxi">
	                <span class="l"><img src="Public/img/i_contact_ico.png"></span>
	                <b>联系我们</b>
	                <span class="r">
	                    <img src="Public/img/i_arrowRight_ico.png">
	                </span>
	            </a>
	        </div>
	
	        <!--loginout-->
	        <div class="i-loginOut" onclick="logout()"><a href="javascript:;">注销</a></div>
	    </div>
	</body>
	
	<script>
		function logout(){
			$.ajax({
				url:"index.php?m=api&c=login&a=signout",
				method:"get",
			}).done(function(ret){
				var ret = JSON.parse(ret);
				if(ret && ret.code == 200){
					Zepto.toast('已注销！');
					setTimeout(function(){
						window.location.href = 'index.php'
					},600)
				}
			})
		}
	</script>
</html>