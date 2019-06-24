<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>后台登录</title>
<meta name="author" content="DeathGhost" />
<link rel="stylesheet" type="text/css" href="__ROOT__/style.css" tppabs="css/style.css" />
<style>
body{height:100%;background:#16a085;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
</style>
<script src="__ROOT__/js/jquery-2.1.4.js"></script>
<script src="__ROOT__/Particleground.js" ></script>
<script>
$(document).ready(function() {
  //粒子背景特效
  $('body').particleground({
    dotColor: '#5cbdaa',
    lineColor: '#5cbdaa'
  });
  
});
</script>
</head>
<body>
<dl class="admin_login">
 <dt> 
  <strong>飞答后台管理系统登陆</strong>
 
 </dt>
 <dd class="user_icon">
  <input type="text" placeholder="账号" class="login_txtbx" id="phone"/>
 </dd>
 <dd class="pwd_icon">
  <input type="password" placeholder="密码" class="login_txtbx" id="password"/>
 </dd>
 <dd>
  <input type="button" value="立即登陆" class="submit_btn"/>
 </dd>

</dl>	
<script>
   $(function(){ 
	   $('.submit_btn').click(function(){
		   var username = $('#phone').val();
		   var password = $('#password').val();
		   $.ajax({
			   url:'?m=FeiAdmin&c=Index&a=UserLogin',
			   data:{username:username,password:password},
			   method:'GET'
		   }).done(function(ret){  
			   var ret = JSON.parse(ret);
			   var code = ret.code;

			   if(code == 200){
				   window.location.href="?m=Admin&c=Index&a=index";
			   }else{
				   alert(ret.msg);
			   }
		   })
	   })
   })
   
</script>
</body>
</html>
