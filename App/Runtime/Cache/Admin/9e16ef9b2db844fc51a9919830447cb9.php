<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8"> 
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->  
<link href="/Public/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="/Public/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<link href="/Public/static/h-ui.admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="/Public/lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script><![endif]-->
<title>分销管理系统</title> 
<meta name="keywords" content=""/>  
    <meta name="description" content=""/>
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<!-- <div class="header"><a href="https://www.youdingb.com/"><img src="http://www.youdingb.com/assets/images/logo.png"/></a>互联网入口创建者</div> -->
<div class="loginWraper">
	<form  action="<?php echo U('login');?>" method="post" enctype="multipart/form-data">

	<div id="loginform" class="loginBox">
		<div class="form form-horizontal">
			<div class="row cl">
				<label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
				<div class="formControls col-xs-8">
					<input id="phone" name="phone" type="text" placeholder="账户" class="input-text size-L">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
				<div class="formControls col-xs-8">
					<input id="password" name="password" type="password" placeholder="密码" class="input-text size-L">
				</div>
			</div>
			<!-- <div class="row cl">
				<div class="formControls col-xs-8 col-xs-offset-3">
					<input id="codeinput" name="code" class="input-text size-L" type="text" placeholder="验证码" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
					<img src="<?php echo U('Login/verify');?>" id="code"/>
					<a id="kanbuq" href="javascript:;" >看不清，换一张</a>
				</div> 
			</div> -->
			<!-- <div class="row cl">
				<div class="formControls col-xs-8 col-xs-offset-3">
					<label for="online">
						<input type="checkbox" name="online" id="online" value="">
						使我保持登录状态</label>
				</div>
			</div> -->
			<div class="row cl">
				<div class="formControls col-xs-8 col-xs-offset-3">
					<input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
					<input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
					<!-- <br/><br/>
					<a href="<?php echo U('Login/wechatlogin');?>" target="_blank" class="iconfont weixin" title="微信">微信登录</a>
					<a href="http://www.fondfell.com/register.php" target="_blank">注册</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.fondfell.com/forget.php" target="_blank">忘记密码？</a> -->
				</div>
			</div>
		</div>
	</div>  
</div>
</form>
<!-- <div class="footer"><a href="https://www.youdingb.com/">首页</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="http://www.youdingb.com/app.php">微入口</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="http://www.youdingb.com/zhaopin.php">招聘</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="http://www.youdingb.com/about.php">关于我们</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="">@广州放飞信息科技有限公司</a></div>  -->

<script type="text/javascript" src="/Public/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/Public/lib/layer/2.4/layer.js"></script>
<script type="text/javascript">
 // $('#code').click(function(){
 // 	 this.src = '/index.php/Admin/Login/verify/'+Math.random();
 // })

</script>
</body>
</html>