<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="MobileOptimized" content="320">
    <meta http-equiv="cleartype" content="on">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta name="wap-font-scale" content="no">
    <title>搜索</title>
    <link rel="stylesheet" type="text/css" href="/Public/src/css/common.css">
    <style type="text/css">
/*    .result-header {
        position: relative;
        padding: 1rem 1.5rem;
        background: #fff;
        margin-bottom: 1rem;
        border-bottom: solid 1px #ddd;
    }

    .result-header .result-form,
    .result_txt dl {
        display: -moz-box;
        display: -webkit-box;
        display: box;
        width: 100%;
    }

    .result_s_input {
        width: 100%;
        height: 36px;
        display: block;
        border: 1px solid #ddd;
        border-radius: 3px;
    }

    .result-form {
        padding-right: 50px;
        position: relative;
    }

    .result_button {
        position: absolute;
        right: -5px;
        width: 50px;
        height: 36px;
        background: #fff url(../img/zui_search_ico_gary.png) center no-repeat;
        background-size: 22px;
    }*/

    body,
    html {
        background: #ffffff;
    }
    h4{
    	line-height:30px;
    	font-size:14px;
    	font-weight:600;
    }
    .hot_seek_box {
        padding: 0 20px;
        background: #fff;
    }

    .hot_seek_box h3 {
        padding: 8px 0;
        font-size: 18px;
    }

    .hot_seek_list span {
        padding: 5px 10px;
        display: inline-block;
        margin: 5px;
        border-radius: 5px;
        line-height: 18px;
        font-size:14px;
        color: #919191;
        border: 1px solid #d6d6d6;
        border-radius: 3px;
        position: relative;
        overflow: hidden;
    }
    .hot_seek_list .active{
      border:1px solid #fc7358;
      color: #fc7358;
    }
  .hot_seek_list span i{
    width: 1px;
     height: 1px;
     border-top: 15px solid #f76836;
     border-left: 15px solid transparent;
     position: absolute;
     right: 0;
     top: 0;
     z-index: 1;
  }
  .hot_seek_list span a{
    position: absolute;
    top: -4px;
    right: -2px;
    font-size: 12px;
    color: #fff;
    transform: scale(0.6);
    z-index: 2;
  }
    .hot_seek_list {
    	padding:0 0 10px;
    }
    .top{
      /*border-left: 3px solid #abd4aa;*/
margin-left: 3.5%;
font-size: 12px;
margin-bottom: 5px;
padding-left: 5px;
    }

    /*.hot_seek_list span:nth-child(2n) {
        background: #71e1bd;
    }
     .hot_seek_list span:nth-child(2n+1) {
        background: #a9dff5;
    }
    .hot_seek_list span:nth-child(3n+1) {
        background: #ffa687;
    }

    .hot_seek_list span:nth-child(4n+1) {
        background: #f3c4e3;
    }*/

    .icon-shanchu{
    	float:right;
    	font-weight:normal;
    	font-size:18px;
    	color:#989898;
    }
    .booksList1{
      /*display: none;*/
    }
    .booksList2{
      /*display: block!important;*/
    		background:white;
    		margin-top:5px;
    		padding:0 10px 0 10px;
    	}
    	.booksList2 ul li{
    		border-bottom:0px solid #f3f3f3;
    		margin-bottom:10px;
        position: relative;
    	}
    	.booksList2 ul li:last-child{
    		border-bottom:0;
    	}
    	.booksList2 ul li .bookCover{
    		float:left;
    		width:20%;
    		/*margin-bottom:10px;*/
    		margin-top: 19px;
    	}
    	.booksList2 ul li .bookCover img{
    		width:100%;
    		/*height: 85px;*/
  height: 100%;
    	}
    	.booksList2 ul li .bookInfo{
    		float:left;
    		width:76%;
    		margin-left:3%;
    		font-size:12px;
    		color:#787878;
    		line-height:15px;
    	}
    	.booksList2 ul li .bookInfo .booksName{
    		font-size:15px;
    		color:#484848;
    		margin-top:19px;
    		line-height:25px;
    	}

    	.booksList2_title{
    		padding:0;
    	}
    	.author{
    		margin-top:11px;
    		color:#484848;
    	}
      .author .iconfont{
         width: 10px; height: 11px;
         margin-right: 2px;
      }
    	.author .iconfont img{
width: 10px; height: 11px;
vertical-align: middle;
    	}
    	.label{
    		padding:1px;
    		line-height:15px;
    		float:right;
    		border:1px solid #bbdba8;
    		border-radius:3px;
    		color:#bbdba8;
        margin-right: 5px;
        margin-top: -2px;
    	}
    	.labels{
    		padding:1px;
    		line-height:15px;
    		margin-right: 5px;
    		float:right;
    		border:1px solid #99bbda;
    		border-radius:3px;
    		color:#99bbda;
          margin-top: -2px;
    	}
    	.txt{
    		overflow: hidden;
		 	text-overflow: ellipsis;
		 	display: -webkit-box;
		 	-webkit-line-clamp: 3;
		 	-webkit-box-orient: vertical;
      font-size:13px;
      line-height: 18px;
    	}
    	.author{
    		/*font-weight:600;*/
        	margin-top:11px;
    		color:#484848;
    	}

    	@media screen and (max-width: 320px) {
		    .booksList2 ul li .bookCover{
		    	width:25%;
		    }
		}
		@media screen and (min-width:321px) and (max-width: 375px){
		    .booksList2 ul li .bookCover{
		    	width:22%;
		    }
		    .booksList2 ul li .bookInfo{
		    	width:75%;
		    }
		}
		@media screen and (min-width:376px) and (max-width: 414px){
		    .booksList2 ul li .bookCover{
		    	width:20%;

		    }
		    .booksList2 ul li .bookInfo{
		    	width:77%;
		    }
		}
		.pai_hang{ width: 100%; background: #ffffff; height:100%; margin-bottom: 20px; margin-top: 10px;}
		.pai_hang ul li{ float: left; width: 20%; text-align: center;
		font-size: 9px; color: #999999;overflow: hidden;
text-overflow:ellipsis;
white-space: nowrap;

		}
		.pai_hang ul li img{
		   width: 70%;
       margin-left: 15%;
       height: 70px;
      margin-bottom: 6px;
		}
    .pai_hang .title{
      margin-bottom: 16px;
    }
    .row{
      height: 52px;
      display: flex;
      align-items: center;
        font-size: 12px;
        position: relative;
    }
    .row .huan{
      position: absolute;
      right: 0;
      color: #858585;
    }
    .row .yuanzhu{
      width: 3px;
      height: 13px;
      background: #f7ac95;
      border-radius: 5px;
      margin-right: 6px;
      color: #676767;
    }
    .row2{
      padding-left: 20px;
      font-size: 13px;
    }
    .row2 .yuanzhu{
      background: #abd4aa;
    }
    .shujia{
      position: absolute;
      padding-left: 8px;
      top:18px;
      right: -10px;
      border: 1px solid #fdd2c3;
      width: 62px;
      height: 21px;
      background: #fcefea;
      color: #fdd2c3;
      font-size: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-top-left-radius: 10px;
      border-bottom-left-radius:10px;
    }
    .shujia1{
      position: absolute;
      padding-left: 8px;
      top:18px;
      right: -10px;
      border: 1px solid #c1d6df;
      width: 62px;
      height: 21px;
      background: #dff1fa;
      color: #c1d6df;
      font-size: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-top-left-radius: 10px;
      border-bottom-left-radius:10px;
      z-index: 10;
      display: none;
    }
    </style>
    <style>

		header{
		   background:#ffffff;
		}
    	.top{
    		height:45px;
    		background:#ffffff;
				display: flex;
				align-items: center;
				justify-content: center;
    	}

    	.search{
    		float:left;
    		width:82%;
    	}
    	.searchInput{
    		width:300px;
    		padding-left:20px !important;
    		height:30px !important;
    		line-height:30px;
    		font-size:11px !important;
    		border:none;
    		border:1px solid #e6e6e6;
    		border-radius:25px;
    		outline: none;
    		color:#939393;
			background: #f7f7f7;
    	}
			.tip{
				width: 80px;
				color: #4f4f4f;
				font-size: 15px;
        height: 30px;
        line-height: 30px; margin-left: -10px;
				text-align: center;
			}
    </style>
</head>

<body>

 <header>
		<div class="top">
			<!--<div class="back" onclick="api.closeWin({});">
				<i class="iconfont icon-llmainpageback"></i>
			</div>-->
      <form style="    display: flex;    align-items: center;"  action="<?php echo U('resou');?>" method="post" enctype="multipart/form-data">

			<div class="search">
				<input type="search" name="lei" required  class="searchInput" placeholder="搜索书名、作者" >
			</div><input class="tip" type="submit" value="搜索">
	
		</div>
	</header>
	

	
    <div class="booksList1">
	    <div class="hot_seek_box">
	        <!-- <h4>大家都在搜</h4> -->
        <div class="row">
            <div class="yuanzhu"></div>
            <span>大家都在搜</span>
            <span class="huan"><a href="index?page=1">换一换</a></span>
        </div>
	        <div class="hot_seek_list">
	         <?php if(is_array($arr)): foreach($arr as $key=>$v): ?><span class="active" onClick="location.href='resou.html?name=<?php echo ($v["keywords"]); ?>'"><?php echo ($v["keywords"]); ?><i></i><a>荐</a></span><?php endforeach; endif; ?>  
	        </div>
	    </div>
	    <div class="hot_seek_box" style="margin-top:10px;">
	        <h4>
	        	搜索历史
	        	<span class="iconfont icon-shanchu" ng-click="shanchu()"></span>
	        </h4>
	        <div class="hot_seek_list">
	           <?php if(is_array($sql)): foreach($sql as $key=>$p): ?><span onClick="location.href='resou.html?name=<?php echo ($p["keywords"]); ?>'"><?php echo ($p["keywords"]); ?></span><?php endforeach; endif; ?>
	        </div>
	    </div>
	   <div class="pai_hang">
	      <!--<p class="title" style="padding-left:0">
			<span class="top">热搜Top榜</span>
		</p> -->
    <div class="row row2">
        <div class="yuanzhu"></div>
        <span>热搜Top榜</span>
    </div>
         <ul class="layout-t-b">
                          <?php if(is_array($info)): foreach($info as $key=>$o): ?><!--     <li onClick="location.href='/books/index.php/Home/index/dtail.html?id=<?php echo ($o["articleid"]); ?>&name=<?php echo ($o["keywords"]); ?>'" > -->

                            <li onClick="location.href='<?php echo U('Index/dtail');?>?id=<?php echo ($o["articleid"]); ?>'" >


                                <dl>

                                    <dt><img src="/Public/<?php echo ($o["images"]); ?>" width="80" alt="<?php echo ($o["keywords"]); ?>"></dt>
                                    <dd>
                                        <h3><?php echo ($o["articlename"]); ?></h3>
                                    </dd>
                                </dl>

                            </li><?php endforeach; endif; ?>
                        </ul>
                    </div>

    </div>

    




</body>

</html>