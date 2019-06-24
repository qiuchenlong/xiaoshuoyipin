<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>title</title>
    <link rel="stylesheet" type="text/css" href="/Public/src/css/api.css"/>
     <link rel="stylesheet" type="text/css" href="/Public/src/css/win_header.css" />

    <style type="text/css">
        .top{
            height: 40px;
            background: #fff;
            top: -5px;
        }
        .search{
            float: left;
            width: 90%;
            margin-top: 5px;
            margin-left: 5%;
        }
        .searchInput{
            width: 100%;
            background: url(../image/zui_search_ico.png) no-repeat 10px #f3f3f3;
            background-size: 16px;
            background-position: 30%;
            height: 25px !important;
            line-height: 25px;
            font-size: 12px !important;
            border: none;
            border: 1px solid #ccc;
            border-radius: 30px;
            outline: none;
            color: #666;
            text-align: center;
        }
        .classify{
            padding: 15px 0 0;
            background: white;
        }
        .classify ul li{
            float: left;
            width: 20%;
            text-align: center;
            font-size: 14px;
            color: #484848;
        }
        .classify ul li img{
            width: 50%; height: 30px;
        }
        .bookList{
            background: white;
        }
        .bookList ul li{
            float: left;
            width: 32.5%;
            text-align: center;
            font-size: 14px;
        }
        .bookList ul li img{
            width: 80%;
        }
        .bookList ul li .bookName{
            width: 70%;
            margin: 10px auto;
            font-size: 12px;
            color: #676767;
            height: 26px;
            line-height: 13px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .title{
            font-size: 16px;
            /*line-height:45px;*/
            padding: 0px 0;
            padding-left: 10px;
            color: #ffffff;
            font-weight: 600
        }
        .booksList2{
            background: white;
            margin-top: 50px;
            padding: 0 10px 5px 10px;
        }
        .booksList2 ul li{
            border-bottom: 1px solid #f3f3f3;
            margin-bottom: 10px;
            padding-bottom: 10px;
        }
        .booksList2 ul li:last-child{
            border-bottom: 0;
        }
        .booksList2 ul li .bookCover{
            float: left;
            width: 20%;
            margin-bottom: 10px;
            margin-top: 10px;
        }
        .booksList2 ul li .bookCover img{
            width: 100%;
            height: 85px;
        }
        .booksList2 ul li .bookInfo{
            float: left;
            width: 76%;
            margin-left: 3%;
            font-size: 11px;
            color: #787878;
            line-height: 15px;
        }
        .booksList2 ul li .bookInfo .booksName{
            font-size: 13px;
            color: #484848;
            margin-top: 5px;
            line-height: 25px;
        }
        .booksList2_title{
            padding: 0;
        }
        #swiper2, #swiper1{
            height: 35px;
            line-height: 35px;
            font-size: 14px;
            border-bottom: 1px solid #dedede;
            color: #484848;
            background: white;
            padding: 0 10px;
        }
        .icon-laba{
            font-size: 20px;
            float: left;
            margin-right: 5px;
            color: #494df1;
        }
        .button{
            padding: 10px;
            text-align: center;
        }
        .button span{
            display: inline-block;
            width: 90%;
            text-align: center;
            line-height: 30px;
            border-radius: 3px;
            color: white;
        }
        .txt{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        .author{
            margin-top: 15px;
            color: #484848;
        }
        .author img{
            width: 10px; height: 10px;
            vertical-align: middle;
        }
        .label{
            padding: 1px;
            line-height: 15px;
            float: right;
            border: 1px solid #bbdba8;
            border-radius: 3px;
            color: #bbdba8;
            margin-right: 5px;
        }
        .labels{
            padding: 1px;
            line-height: 15px;
            margin-right: 5px;
            float: right;
            border: 1px solid #99bbda;
            border-radius: 3px;
            color: #99bbda;
        }
        .hotList{
            background: white;
            margin-top: -5px;
        }
        .hotList > ul > li{
            line-height: 40px;
            padding: 0 10px;
            font-size: 14px;
            border-bottom: 1px solid #f1f1f1;
        }
        .hotList > ul > li:last-child{
            border: 0
        }
        .hotList > ul > li .sort{
            width: 24px;
            height: 24px;
            line-height: 25px;
            text-align: center;
            background: #ff3a3a;
            border-radius: 50%;
            color: white;
        }
        .hotList > ul > li .booksName{
            margin-left: 10px;
        }
        .hotList > ul > li .label{
            margin-top: 9px;
        }
   		.back img{width: 18px; height: 18px ; margin-left: 10px;}
        .header{position: fixed; top: 0px; z-index: 1000; background: #d82f2f }
    </style>
</head>
<body ng-controller="DataController">


        <header class="header">
          <span class="title">合集</span>
          <span class="back"  tapmode="active" onClick="location.href='<?php echo U(index);?>'" ><img src="/Public/src/images/fanhui.png" alt="" ></span>
          <div class="icon" onClick="location.href='<?php echo U('Sousuo/index');?>'"><img src="/Public/src/images/zui_search_ico.png" alt="" ></div>
        </header>

    
	<div class="booksList2">
		<ul>

		<!-- 	<?php if($arr == null): ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="8" color="red">暂无此书</font><?php endif; ?> -->

			<?php if(is_array($xiaoshuo)): foreach($xiaoshuo as $key=>$v): ?><li class="clearfix" onClick="location.href='<?php echo U('index/dtail');?>?id=<?php echo ($v["articleid"]); ?>'" >
				<div class="bookCover">
					<img src="http://www.youdingb.com/xiangmu/xiaoshuoyipin/Public/<?php echo ($v["images"]); ?>" alt="">
				</div>
				<div class="bookInfo">
					<p class="booksName"><?php echo ($v["articlename"]); ?></p>
					<p class="txt">
						<?php echo ($v["intro"]); ?>
					</p>
					<div class="author">
						<span>
							<i class="iconfont"><img src="/Public/src/images/authors.png"/></i>
							<?php echo ($v["author"]); ?>
						</span>
						
						<span class="labels">
							<?php echo ($v["shortname"]); ?>
						</span>
						<span class="label">
							<?php echo ($v["size"]); ?>万字
						</span>
					</div>
				</div>
			</li><?php endforeach; endif; ?>
		</ul>
	</div>
	
</body>

</html>