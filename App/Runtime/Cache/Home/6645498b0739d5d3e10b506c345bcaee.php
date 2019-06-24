<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html ng-app="myApp">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link href="../css/swiper.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/Public/src/css/api.css" />
    <link rel="stylesheet" href="/Public/src/css/index.css">
    <link rel="stylesheet" href="/Public/src/css/swiper-4.2.2.min.css"><!--轮播css-->
    <link rel="stylesheet" href="/Public/src/css/icon/iconfont.css"><!--图标字体->
    <link rel="stylesheet" href="../src/css/icon/iconfont.css">
    <script src="../src/library/zepto.js"></script><!-页面js-->
    <script src="/Public/src/library/zepto.js"></script><!--页面js-->
    <script src="/Public/src/library/swiper-4.2.2.min.js"></script><!--页面js-->
    <script src="/Public/src/js/global.js"></script>
</head>
<body>
<header class="header">
    <div class="base"></div>
    <div class="breadcrumbs">
        <div class="u-search">
            <form class="form" action="">
                <div class="search-div" onClick="location.href='<?php echo U('Sousuo/index');?>'">
                    <i class="iconfont icon-sousuo"></i>
                    <input class="search-input" type="search" placeholder="搜索我的书架、在线书库">
                </div>
                <button type="button" class="button" onClick="location.href='<?php echo U('Paihang/index');?>'">排行</button>
            </form>
        </div>
        <div class="nav">
        <a class="nav_a" href="<?php echo U('index_gratis');?>">首页</a>
            <a class="nav_a" href="<?php echo U('index');?>">女频</a>
        <a class="nav_a current" href="<?php echo U('index_male');?>">男频</a>
        <a class="nav_a" href="<?php echo U('index_publish');?>">出版</a>
        
        <!--<a class="nav_a" href="<?php echo U('BookSelection');?>">书单</a>-->
        </div>
    </div>
</header>
<div class="content">
    <div class="m-swiper">
        <div class="swiper-container">
            <div class="swiper-wrapper">
            <?php if(is_array($lunbo)): foreach($lunbo as $key=>$v): ?><div class="swiper-slide">
                <?php if($v["gotos"] == 0): ?><a href="<?php echo U('Index/dtail');?>?id=<?php echo ($v["bookid"]); ?>"><?php endif; ?>

                <?php if($v["gotos"] == 1): ?><a href="<?php echo U('Index/guanggao');?>?id=<?php echo ($v["id"]); ?>"><?php endif; ?>

                <?php if($v["gotos"] == 2): ?><a href="<?php echo ($v["weburl"]); ?>" target="_blank" ><?php endif; ?>

                <img src="http://www.youdingb.com/xiangmu/xiaoshuoyipin/Public/<?php echo ($v["images"]); ?>" alt="">

                </a>

                </div><?php endforeach; endif; ?>
             <!--    <div class="swiper-slide"><a href="javascript:;"><img src="/Public/src/images/ind-02.png" alt=""></a></div>
                <div class="swiper-slide"><a href="javascript:;"><img src="/Public/src/images/ind-03.png" alt=""></a></div>
                <div class="swiper-slide"><a href="javascript:;"><img src="/Public/src/images/ind-04.png" alt=""></a></div>
                <div class="swiper-slide"><a href="javascript:;"><img src="/Public/src/images/ind-05.png" alt=""></a></div> -->
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Initialize Swiper -->
        </div>
        <script>
            var swiper = new Swiper('.swiper-container', {
                pagination : {
                    el        : '.swiper-pagination',
                    clickable : true,
                },
                loop       : true,
                delay      : 1500,
                autoplay   : {
                    disableOnInteraction : false,
                },
            });
        </script>
    </div>
    <div class="m-choice">
        <h3 class="h3">精选</h3>
        <a class="u-text_line" href="javascript:;" >免费已生效，点开即领！</a>
    </div>
    <div class="m-recom">
        <div class="u-hd"onClick="location.href='<?php echo U(resou);?>?id=<?php echo ($xiaoshuo1["id"]); ?>'" >
            <h2 class="h2"><?php echo ($xiaoshuo1["title"]); ?></h2>
            <a style="display: flex;align-items: center;" href="javascript:;">
                    	更多<i class="iconfont icon-signboard_right" style="vertical-align: middle;font-size:0.2rem"></i>
                    </a>
        </div>
        <div class="bd">
            <ul class="u-ul_flex">
             <?php if(is_array($xiaoshuo1["xiaoshuo"])): foreach($xiaoshuo1["xiaoshuo"] as $key=>$v): ?><li class="li" onClick="location.href='<?php echo U('Index/dtail');?>?id=<?php echo ($v["articleid"]); ?>'" >
                    <div class="top">
                        <a href="javascript:;">
                            <img src="http://www.youdingb.com/xiangmu/xiaoshuoyipin/Public/<?php echo ($v["images"]); ?>" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;"><?php echo ($v["articlename"]); ?></a>
                    </div>
                </li><?php endforeach; endif; ?>
                <!-- <li class="li">
                    <div class="top">
                        <a href="dtail.html">
                            <img src="/Public/src/images/i-01.png" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;">医妃读心术</a>
                    </div>
                </li>
                <li class="li">
                    <div class="top">
                        <a href="dtail.html">
                            <img src="/Public/src/images/i-01.png" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;">医妃读心术</a>
                    </div>
                </li> -->
                <!--<li class="li">
                    <div class="top">
                        <a href="javascript:;">
                            <img src="../src/images/i-01.png"/>
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;">医妃读心术</a>
                    </div>
                </li>-->
            </ul>
        </div>
    </div>
    <!--强力推荐-->
    <div class="m-recom">
        <div class="u-hd"onClick="location.href='<?php echo U(resou);?>?id=<?php echo ($xiaoshuo2["id"]); ?>'" >
            <h2 class="h2"><?php echo ($xiaoshuo2["title"]); ?></h2>
            <div class="right"><a href="javascript:;">更多</a></div>
        </div>
        <div class="bd">
            <ul class="u-ul_flex">
                 <?php if(is_array($xiaoshuo2["xiaoshuo"])): foreach($xiaoshuo2["xiaoshuo"] as $key=>$v): ?><li class="li" onClick="location.href='<?php echo U('Index/dtail');?>?id=<?php echo ($v["articleid"]); ?>'" >
                    <div class="top">
                        <a href="javascript:;">
                            <img src="http://www.youdingb.com/xiangmu/xiaoshuoyipin/Public/<?php echo ($v["images"]); ?>" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;"><?php echo ($v["articlename"]); ?></a>
                    </div>
                </li><?php endforeach; endif; ?>
               <!--  <li class="li" onClick="location.href='dtail.html'" >
                    <div class="top">
                        <a href="dtail.html">
                            <img src="/Public/src/images/i-01.png" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="dtail.html">医妃读心术</a>
                    </div>
                </li>
                <li class="li" onClick="location.href='dtail.html'" >
                    <div class="top">
                        <a href="javascript:;">
                            <img src="/Public/src/images/i-01.png" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;">医妃读心术</a>
                    </div>
                </li>
                <li class="li" onClick="location.href='dtail.html'">
                    <div class="top">
                        <a href="dtail.html">
                            <img src="/Public/src/images/i-01.png" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;">医妃读心术</a>
                    </div>
                </li>
                <li class="li" onClick="location.href='dtail.html'">
                    <div class="top">
                        <a href="dtail.html">
                            <img src="/Public/src/images/i-01.png" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="dtail.html">医妃读心术</a>
                    </div>
                </li>
                <li class="li" onClick="location.href='dtail.html'">
                    <div class="top">
                        <a href="javascript:;">
                            <img src="/Public/src/images/i-01.png" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;">医妃读心术</a>
                    </div>
                </li> -->
            </ul>
        </div>
    </div>

    <?php if(is_array($xiaoshuo)): foreach($xiaoshuo as $key=>$v): ?><div class="m-time-travel">
       <div class="u-hd"onClick="location.href='<?php echo U(resou);?>?id=<?php echo ($v["id"]); ?>'" >
            <h2 class="h2"><?php echo ($v["title"]); ?></h2>
            <div class="right" ><a href="javascript:;">更多</a></div>
        </div>
        <div class="bd">
            <ul class="u-ul_lr">

            <?php if(is_array($v["xiaoshuo1"])): foreach($v["xiaoshuo1"] as $key=>$a): ?><li class="li" onClick="location.href='<?php echo U('Index/dtail');?>?id=<?php echo ($a["articleid"]); ?>'">
                    <div class="left">
                        <img src="http://www.youdingb.com/xiangmu/xiaoshuoyipin/Public/<?php echo ($a["images"]); ?>" />
                    </div>
                    <div class="right">
                        <h3 class="h3 u-text_line"><?php echo ($a["articlename"]); ?></h3>
                        <p class="text">
                            <span class="author"><?php echo ($a["author"]); ?></span>
                            <span class="u-title1"><?php echo ($a["shortname"]); ?></span>
                            <span class="u-title2"><?php echo ($a["allvisit"]); ?></span>
                        </p>
                        <p class="u-line2"><?php echo ($a["intro"]); ?></p>
                    </div>
                </li><?php endforeach; endif; ?>

               <!--  <li class="li" onClick="location.href='dtail.html'">
                    <div class="left">
                        <img src="/Public/src/images/i-01.png" alt="">
                    </div>
                    <div class="right">
                        <h3 class="h3 u-text_line">邪王轻点爱：枭宠医妃</h3>
                        <p class="text">
                            <span class="author">拈花惹笑</span>
                            <span class="u-title1">王爷</span>
                            <span class="u-title2">女尊天下</span>
                        </p>
                        <p class="u-line2">特种女兵军医穿越：战神王爷轻点可以吗？</p>
                    </div>
                </li>
                <li class="li" onClick="location.href='dtail.html'">
                    <div class="left">
                        <img src="/Public/src/images/i-01.png" alt="">
                    </div>
                    <div class="right">
                        <h3 class="h3 u-text_line">邪王轻点爱：枭宠医妃</h3>
                        <p class="text">
                            <span class="author">拈花惹笑</span>
                            <span class="u-title1">王爷</span>
                            <span class="u-title2">女尊天下</span>
                        </p>
                        <p class="u-line2">特种女兵军医穿越：战神王爷轻点可以吗？</p>
                    </div>
                </li>
                <li class="li" onClick="location.href='dtail.html'" >
                    <div class="left">
                        <img src="/Public/src/images/i-01.png" alt="">
                    </div>
                    <div class="right">
                        <h3 class="h3 u-text_line">邪王轻点爱：枭宠医妃</h3>
                        <p class="text">
                            <span class="author">拈花惹笑</span>
                            <span class="u-title1">王爷</span>
                            <span class="u-title2">女尊天下</span>
                        </p>
                        <p class="u-line2">特种女兵军医穿越：战神王爷轻点可以吗？</p>
                    </div>
                </li> -->
            </ul>
            <ul class="u-ul_flex">
            <?php if(is_array($v["xiaoshuo2"])): foreach($v["xiaoshuo2"] as $key=>$b): ?><li class="li" onClick="location.href='<?php echo U('Index/dtail');?>?id=<?php echo ($b["articleid"]); ?>'">
                    <div class="top">
                        <a href="javascript:;">
                            <img src="http://www.youdingb.com/xiangmu/xiaoshuoyipin/Public/<?php echo ($b["images"]); ?>" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;"><?php echo ($b["articlename"]); ?></a>
                    </div>
                </li><?php endforeach; endif; ?>
               <!--  <li class="li" onClick="location.href='dtail.html'">
                    <div class="top">
                        <a href="javascript:;">
                            <img src="/Public/src/images/i-01.png" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;">医妃读心术</a>
                    </div>
                </li>
                <li class="li" onClick="location.href='dtail.html'" >
                    <div class="top">
                        <a href="javascript:;">
                            <img src="/Public/src/images/i-01.png" />
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;">医妃读心术</a>
                    </div>
                </li> -->
                <!--<li class="li">
                    <div class="top">
                        <a href="javascript:;">
                            <img src="../src/images/i-01.png"/>
                        </a>
                    </div>
                    <div class="button">
                        <a class="u-line2" href="javascript:;">医妃读心术</a>
                    </div>
                </li>-->
            </ul>
        </div>
    </div><?php endforeach; endif; ?>
</div>
<!--<section class="pg_activity" onClick="location.href='<?php echo U('Notice/index');?>'">
    <img src="/Public/src/images/activity.png" alt="" />
    <span>活动</span>
</section>-->
<footer class="footer">
    <div class="base"></div>
    <div class="menu">
        <a class="footer_a" href="<?php echo U('Shujia/index');?>">
            <i class="iconfont icon-yg-shujia"></i>
            <span>书架</span>
        </a>
        <a class="footer_a current" href="<?php echo U('Index/index');?>"> <i class="iconfont icon-shouye"></i> <span>首页</span> </a>
        <a class="footer_a" href="<?php echo U('Shuku/index');?>"> <i class="iconfont icon-caidan"></i> <span>书库</span></a>
        <a class="footer_a" href="<?php echo U('Faxian/index');?>"><i class="iconfont icon-wode"></i><span>我的</span></a>
    </div>
</footer>
<!--<footer class="footer"></footer>-->
</body>
</html>