<?php if (!defined('THINK_PATH')) exit();?><!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html> 
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<LINK rel="Bookmark" href="favicon.ico" >
<LINK rel="Shortcut Icon" href="favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/Public/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/style.css" />

<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script><![endif]-->

<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->
<!--/meta 作为公共模版分离出去-->

<title>意见管理</title>  
</head>  
<body>
<!--_header 作为公共模版分离出去-->
﻿  <title>小说管理系统</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>

</head>
<body>  

<header class="navbar-wrapper">
	<div class="navbar navbar-fixed-top">
		<div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/index.php">小说后台</a> <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/index.php">H-ui</a> 
			<!-- <span class="logo navbar-slogan f-l mr-10 hidden-xs"><a  href="http://www.fondfell.com" target="_blank" style="color:#fff;">分销</a></span>  -->
			<!-- <span class="logo navbar-slogan f-l mr-10 hidden-xs">
				<a  href="<?php echo U('Login/Client');?>" target="_blank" style="color:#fff;">发专辑</a></span> 
			</span> -->
			<nav class="nav navbar-nav">
				<!-- <ul class="cl">
					<li class="dropDown dropDown_hover"><a href="javascript:;" class="dropDown_A"><i class="Hui-iconfont">&#xe600;</i> 新增 <i class="Hui-iconfont">&#xe6d5;</i></a>
						<ul class="dropDown-menu menu radius box-shadow">
							<li><a href="javascript:;" onclick="article_add('添加资讯','article-add.html')"><i class="Hui-iconfont">&#xe616;</i> 资讯</a></li>
							<li><a href="javascript:;" onclick="picture_add('添加资讯','picture-add.html')"><i class="Hui-iconfont">&#xe613;</i> 图片</a></li>
							<li><a href="javascript:;" onclick="product_add('添加资讯','product-add.html')"><i class="Hui-iconfont">&#xe620;</i> 产品</a></li>
							<li><a href="javascript:;" onclick="member_add('添加用户','member-add.html','','510')"><i class="Hui-iconfont">&#xe60d;</i> 用户</a></li>
						</ul>
					</li>
				</ul> --> 
			</nav>
			<nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
				<ul class="cl">
					<li><?php echo ($phone); ?></li> 
					<li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A">
						<?php if($_SESSION["guanli"] == null): ?>代理商
						<?php else: ?>管理员<?php endif; ?>
				<i class="Hui-iconfont">&#xe6d5;</i></a> 
						<ul class="dropDown-menu menu radius box-shadow">   
							<!-- <li><a href="javascript:;" onClick="editpassword('修改信息','<?php echo U('Login/editpassword');?>')">个人信息</a> --></li> 
							<!-- <li><a href="javascript:;" onClick="changzh()">切换账户</a></li>    -->
							<li><a href="<?php echo U('Index/tuichu');?>">退出</a></li>  
						</ul>    
					</li> 
					<!-- <li id="Hui-msg"> <a href="#" title="消息"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>  -->
					<li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
						<ul class="dropDown-menu menu radius box-shadow"> 
							<li><a href="javascript:;" data-val="default" title="默认（绿色）">默认（绿色）</a></li> 
							<li><a href="javascript:;" data-val="green" title="黑色">黑色</a></li>
							<li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
							<li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
							<li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
							<li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</header>
<script type="text/javascript">
	function logout(){
		$.ajax({
			type:"post", 
			url:"<?php echo U('Login/logout');?>",
			success:function(data){ 
				if(data.state){
 	 			layer.msg(data.info,{icon:1}); 
 	 		    setTimeout(function(){
 	 			top.window.location.href = data.url;
 	 		     },1500)  
				}else{ 
 	 			layer.msg(data.info,{icon:1}); 
				} 
			},
		});
	} 

	function changzh(){ 
		$.ajax({
			type:"post",
			url:"<?php echo U('Login/logout');?>",
			success:function(data){
				if(data.state){
					layer.msg('请切换账号',{icon:1});
				    setTimeout(function(){
					top.window.location.href = data.url;
				},1000)}else{
					layer.msg('切换不成功',{icon:0});
				}},
				});
			}

	function editpassword(title,url){
	var index = layer.open({ 
		type: 2,
		title: title,
		content: url
	}); 
	layer.full(index); 
}
</script>   
<!--/_header 作为公共模版分离出去-->
 
<!--_menu 作为公共模版分离出去-->
﻿<aside class="Hui-aside"> 
	<div class="menu_dropdown bk_2"> 
		<?php if($_SESSION["guanli"] != null): ?><dl id="menu-xitong">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Guanli"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "Guanli")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Guanli/index');?>" title="系统列表">管理员列表</a></li>
					
				</ul>
			</dd> 
		</dl><?php endif; ?>
		
		<dl id="menu-xitong">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 广告管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Lunbo"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "Lunbo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Lunbo/index');?>" title="系统列表">轮播图管理</a></li>

					<li <?php if((ACTION_NAME == "bookad") and (CONTROLLER_NAME == "Lunbo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Lunbo/bookad');?>" title="书本广告">阅读广告管理</a></li>

					
				</ul>
			</dd> 
		</dl>
		<dl id="menu-xitong">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 书单管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Shudan"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "Shudan")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Shudan/index');?>" title="系统列表">书单管理</a></li>
					<!-- <li <?php if((ACTION_NAME == "hengtu") and (CONTROLLER_NAME == "Lunbo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Lunbo/hengtu');?>" title="系统列表">首页广告图</a></li> -->
					<!-- <li <?php if((ACTION_NAME == "huiyuanlst") and (CONTROLLER_NAME == "User")): ?>class="current"<?php endif; ?>><a href="<?php echo U('User/huiyuanlst');?>" title="会员列表">会员列表</a></li>  -->
				</ul>
			</dd> 
		</dl>
		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 分类管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Pindao"): ?>style="display:block"<?php endif; ?> >
				<ul>

					<li <?php if((ACTION_NAME == "nvpin") and (CONTROLLER_NAME == "Pindao")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Pindao/nvpin');?>" title="女频列表">女频列表</a></li>
					<li <?php if((ACTION_NAME == "nanpin") and (CONTROLLER_NAME == "Pindao")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Pindao/nanpin');?>" title="男频列表">男频列表</a></li>
					
					<li <?php if((ACTION_NAME == "chuban") and (CONTROLLER_NAME == "Pindao")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Pindao/chuban');?>" title="情欲列表">出版列表</a></li>
					<!-- <li <?php if((ACTION_NAME == "mianfei") and (CONTROLLER_NAME == "Pindao")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Pindao/mianfei');?>" title="情欲列表">免费列表</a></li> -->
					
					<!-- <li <?php if((ACTION_NAME == "huiyuanlst") and (CONTROLLER_NAME == "User")): ?>class="current"<?php endif; ?>><a href="<?php echo U('User/huiyuanlst');?>" title="会员列表">会员列表</a></li>  -->
				</ul>
			</dd> 
		</dl>

		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 小说管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Xiaoshuo"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "xiaoshuo") and (CONTROLLER_NAME == "index")): ?>class="current"<?php endif; ?>><a href="<?php echo U('xiaoshuo/chongzhi');?>" title="">设置充值金额</a></li>
					<li <?php if((ACTION_NAME == "xiaoshuo") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/xiaoshuo');?>" title="小说列表">小说列表</a></li>
					<li <?php if((ACTION_NAME == "fenlei") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/fenlei');?>" title="小说分类">小说分类</a></li>
					<li <?php if((ACTION_NAME == "biaoqian") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/biaoqian');?>" title="小说标签">首页推荐</a></li>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/lanmu');?>" title="标签列表">推荐栏目</a></li>
					<li <?php if((ACTION_NAME == "pinglun") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/pinglun');?>" title="评论管理">评论管理</a></li>
					<li <?php if((ACTION_NAME == "pingbi") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/pingbi');?>" title="评论管理">评论屏蔽设置</a></li>
					<li <?php if((ACTION_NAME == "fenxiang") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/fenxiang');?>" title="每日分享">每日分享</a></li>

					<!-- <li <?php if((ACTION_NAME == "tuisong") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/tuisong');?>" title="首页小说">首页小说</a></li> -->
					<li <?php if((ACTION_NAME == "orders") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/orders');?>" title="小说订单">小说订单</a></li>
					<!-- <li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "Index")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Index/index');?>" title="订单统计">订单统计</a></li> -->
					<li <?php if((ACTION_NAME == "xiaoshou") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/xiaoshou');?>" title="小说销售情况">小说销售情况</a></li>
					<!-- <li <?php if((ACTION_NAME == "tuijian") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/tuijian');?>" title="推荐管理">推荐管理</a></li>
					<li <?php if((ACTION_NAME == "jingxuan") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/jingxuan');?>" title="精选管理">精选管理</a></li>
					<li <?php if((ACTION_NAME == "wanjie") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/wanjie');?>" title="完结管理">完结管理</a></li>
					<li <?php if((ACTION_NAME == "mianfei") and (CONTROLLER_NAME == "Xiaoshuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Xiaoshuo/mianfei');?>" title="免费管理">免费管理</a></li> -->
				</ul>
			</dd> 
		</dl>

		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "User"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "User")): ?>class="current"<?php endif; ?>><a href="<?php echo U('User/index');?>" title="用户列表">用户列表</a></li>
					<li <?php if((ACTION_NAME == "xinxi") and (CONTROLLER_NAME == "User")): ?>class="current"<?php endif; ?>><a href="<?php echo U('User/xinxi');?>" title="用户列表">信息记录</a></li>
					<li <?php if((ACTION_NAME == "daijin") and (CONTROLLER_NAME == "User")): ?>class="current"<?php endif; ?>><a href="<?php echo U('User/daijin');?>" title="分享奖励代金券记录">分享奖励代金券记录</a></li>
					
					
				</ul>
			</dd> 
		</dl>
		<?php if($_SESSION["guanli"] != null): ?><dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 代理商管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Daili"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "Daili")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Daili/index');?>" title="代理商列表">代理商列表</a></li>
					<li <?php if((ACTION_NAME == "jiesuan") and (CONTROLLER_NAME == "Daili")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Daili/jiesuan');?>" title="代理商结算">代理商结算</a></li>
					
					
					
				</ul>
			</dd> 
		</dl><?php endif; ?>
		<?php if($_SESSION["guanli"] == null): ?><dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 个人中心<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Geren"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "jiesuan") and (CONTROLLER_NAME == "Geren")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Geren/jiesuan');?>" title="结算记录">结算记录</a></li>
				<!-- 	<li <?php if((ACTION_NAME == "gong") and (CONTROLLER_NAME == "Geren")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Geren/gong');?>" title="代理商结算">公众号设置</a></li>
					<li <?php if((ACTION_NAME == "gongjie") and (CONTROLLER_NAME == "Geren")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Geren/gongjie');?>" title="公众号接口">公众号接口</a></li>
					<li <?php if((ACTION_NAME == "tuiguang") and (CONTROLLER_NAME == "Geren")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Geren/tuiguang');?>" title="推广链接">推广链接</a></li> -->
					<li <?php if((ACTION_NAME == "mima") and (CONTROLLER_NAME == "Geren")): ?>class="current"<?php endif; ?>><a onclick="picture_add('修改密码','<?php echo U('Geren/mima');?>')" title="修改密码">修改密码</a></li>
					
					
					
				</ul>
			</dd> 
		</dl><?php endif; ?>
		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 数据统计<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Tongji"): ?>style="display:block"<?php endif; ?> >
				<ul>
				<!-- 	<?php if($_SESSION["guanli"] != null): ?><li <?php if((ACTION_NAME == "dingdan") and (CONTROLLER_NAME == "Tongji")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Tongji/dingdan');?>" title="订单统计">充值订单统计</a></li>
					<?php else: ?><li <?php if((ACTION_NAME == "daidingdan") and (CONTROLLER_NAME == "Tongji")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Tongji/daidingdan');?>" title="订单统计">充值订单统计</a></li><?php endif; ?> -->
					<li <?php if((ACTION_NAME == "user") and (CONTROLLER_NAME == "Tongji")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Tongji/user');?>" title="用户统计">用户统计</a></li>
					
					
					
				</ul>
			</dd> 
		</dl>



		<!-- <dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 热词管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Reci"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "Reci")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Reci/index');?>" title="用户列表">热词列表</a></li>
				</ul>
			</dd> 
		</dl> -->
		<!-- <dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 标签管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Biaoqian"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "Biaoqian")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Biaoqian/index');?>" title="标签列表">标签列表</a></li>
				</ul>
			</dd> 
		</dl> -->
		<!-- 
		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "System"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "System")): ?>class="current"<?php endif; ?>><a href="<?php echo U('System/index');?>" title="用户列表">系统通知</a></li>
				
				</ul>
			</dd> 
		</dl> -->

		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i>意见<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Yijian"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "Yijian")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Yijian/index');?>" title="用户列表">意见反馈</a></li>
				</ul>
			</dd> 
		</dl>
		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i>搜索管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Sousuo"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "Sousuo")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Sousuo/index');?>" title="热搜TOP榜">热搜TOP榜</a></li>
				</ul>
			
			</dd> 
		</dl>

		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i>系统设置<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "System"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "System")): ?>class="current"<?php endif; ?>><a href="<?php echo U('System/index');?>" title="客服信息">系统通知</a></li>
					<li <?php if((ACTION_NAME == "sys") and (CONTROLLER_NAME == "System")): ?>class="current"<?php endif; ?>><a href="<?php echo U('System/sys');?>" title="系统信息">系统信息</a></li>
				</ul>
			
			</dd> 
		</dl>

		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i>帮助中心<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd <?php if(CONTROLLER_NAME == "Help"): ?>style="display:block"<?php endif; ?> >
				<ul>
					<li <?php if((ACTION_NAME == "index") and (CONTROLLER_NAME == "Help")): ?>class="current"<?php endif; ?>><a href="<?php echo U('Help/index');?>" title="帮助中心">帮助中心</a></li>
					<!-- <li <?php if((ACTION_NAME == "sys") and (CONTROLLER_NAME == "System")): ?>class="current"<?php endif; ?>><a href="<?php echo U('System/sys');?>" title="系统信息">系统信息</a></li> -->
				</ul>
			
			</dd> 
		</dl>


	</div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div> 

<script type="text/javascript"> 
 		function picture_add(title, url) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url,
            shade: 0.6,
		    area:['68%','80%'] 
        });
        // layer.full(index);
    }

function del(id){
	var con;
	con=confirm("确定删除吗?"); //在页面上弹出对话框
	if(con==true){
		location.href="<?php echo U('del');?>?id="+id+"";
	}
}  
</script>  
<!--/_menu 作为公共模版分离出去--> 

<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 频道管理 <span class="c-gray en">&gt;</span> 系统通知 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav> 
	
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <i ></i> </a><a href="<?php echo U('add');?>"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加</a> </span><span class="r">共有数据：<strong><?php echo ($shu); ?></strong> 条</span> </div>
			
			
			<div class="mt-0">  
				<table class="table table-border table-bordered table-bg table-hover table-sort" width="100%">
					<thead>
						<tr class="text-c"> 
							
							<th>ID</th>
							<th>标题</th>
							<th>内容</th>
							<th>添加时间</th>
							<th>是否首页轮播</th>
							<th>操作</th>
							
							 
						</tr> 
						<?php if(is_array($arr)): foreach($arr as $key=>$v): ?><tr class="text-c"> 
							<!-- <td width="100"><?php echo ($v["sortid"]); ?></td> -->
							
							<td><?php echo ($v["id"]); ?></td>
							<td><?php echo ($v["title"]); ?></td>
							<td><?php echo ($v["content"]); ?></td>
							<td><?php echo ($v["addtime"]); ?></td>
							<td><?php echo ($v["types"]); ?></td>
							<td >								
								<a title="修改" href="<?php echo U('edit');?>?id=<?php echo ($v["id"]); ?>"  class="ml-5" style="text-decoration:none">
									<i class="Hui-iconfont">&#xe6df;</i>
								</a> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a  href="<?php echo U('del');?>?id=<?php echo ($v["id"]); ?>" class="ml-5" title="删除">
									<i class="Hui-iconfont">&#xe6e2;</i>
								</a>
							</td>
						</tr><?php endforeach; endif; ?>
					</thead> 
					<tfoot>
						
					</tfoot>
				</table>
				<?php echo ($btn); ?>
			</div>
		</article>
	</div> 
</section>

<!--_footer 作为公共模版分离出去-->
 <!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/Public/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/static/h-ui.admin/js/H-ui.admin.page.js"></script> 
<!--/_footer /作为公共模版分离出去-->

<!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/Public/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/Public/lib/laypage/1.2/laypage.js"></script> 
<script type="text/javascript"> 
 
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>