<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>后台登录</title>
<meta name="author" content="DeathGhost" />
<link rel="stylesheet" type="text/css" href="style.css" tppabs="css/style.css" />
<style>
body{height:100%;background:#16a085;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
</style>
<script src="http://www.jq22.com/jquery/1.11.1/jquery.min.js"></script>
<script src="Particleground.js" tppabs="js/Particleground.js"></script>
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
  <strong>微云财富后台管理系统登陆</strong>
 
 </dt>
 <dd class="user_icon">
  <input type="text" placeholder="账号" class="login_txtbx"/>
 </dd>
 <dd class="pwd_icon">
  <input type="password" placeholder="密码" class="login_txtbx"/>
 </dd>
 <dd>
  <input type="button" value="立即登陆" class="submit_btn"/>
 </dd>

</dl>
<script>
   $(function(){
	   $('.submit_btn').click(function(){
		   var username = $('.login_txtbx').val();
		   var password = $('.login_txtbx').val();
		   $.ajax({
			   url:'index.php?c=Index&a=UserLogin&username='+username+'&password='+password,
			   method:'get'
		   }).done(function(ret){
           
			   var ret = JSON.parse(ret);
			   var code = ret.code;

			   if(code == 200){
				   window.location.href="index.php?c=Index&a=index1";
			   }
		   })
	   })
   })
   
</script>
</body>
</html>
