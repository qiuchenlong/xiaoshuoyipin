<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link href="../css/swiper.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/Public/css/api.css" />
    <link rel="stylesheet" href="/Public/src/css/index.css">
    <link rel="stylesheet" href="/Public/src/css/swiper-4.2.2.min.css"><!--轮播css-->
    <link rel="stylesheet" href="/Public/src/css/icon/iconfont.css">
    <script src="/Public/src/library/zepto.js"></script><!--页面js-->
    <script src="/Public/src/library/swiper-4.2.2.min.js"></script><!--页面js-->
    <script src="/Public/src/js/global.js"></script>
</head>
<body>
<header class="header">
    <div class="base"></div>
    <div class="breadcrumbs" >
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
            <a class="nav_a " href="index.html">女频</a>
            <a class="nav_a current" href="nan.html">男频</a>
            <a class="nav_a" href="chuban.html">出版</a>
            <a class="nav_a" href="mianfei.html">免费</a>
            <a class="nav_a" href="BookSelection.html">书单</a>
        </div>
    </div>
</header>
<div class="content">
    <div class="m-stack">
        <div class="m-stack_rec">

            <?php if(is_array($arr)): foreach($arr as $key=>$v): ?><a class="list" href="fenlei.html?id=<?php echo ($v["sortid"]); ?>&pin=1&lei=<?php echo ($v["shortname"]); ?>">
                <img src="/Public/<?php echo ($v["imgurl"]); ?>" alt="">
                <p class="img_title"></p>
            </a><?php endforeach; endif; ?>
        </div>

        <ul class="m-types">
            <?php if(is_array($info)): foreach($info as $key=>$k): ?><li class="li" onClick="location.href='fenlei.html?id=<?php echo ($k["sortid"]); ?>&pin=1&lei=<?php echo ($k["shortname"]); ?>'">
                <div class="left">
                    <img class="img_pst" src="/Public/<?php echo ($k["imgurl"]); ?>" alt="">
                    <img class="img_btm" src="/Public/<?php echo ($k["imgurl"]); ?>" alt="">
                </div>
                <div class="right">
                    <h2><?php echo ($k["shortname"]); ?></h2>
                </div>
            </li><?php endforeach; endif; ?>
        </ul>
    </div>
</div>
<footer class="footer">
    <div class="base"></div>
    <div class="menu">
        <a class="footer_a" href="<?php echo U('Shujia/index');?>">
            <i class="iconfont icon-yg-shujia"></i>
            <span>书架</span>
        </a>
        <a class="footer_a" href="<?php echo U('Index/index');?>"> <i class="iconfont icon-shouye"></i> <span>首页</span> </a>
        <a class="footer_a" href="<?php echo U('User/chong_zhi');?>"> <i class="iconfont icon-yg-shujia"></i> <span>书架</span></a>
        <a class="footer_a current" href="<?php echo U('Faxian/index');?>"><i class="iconfont icon-wode"></i><span>我的</span></a>
    </div>
</footer>
</body>
</html>