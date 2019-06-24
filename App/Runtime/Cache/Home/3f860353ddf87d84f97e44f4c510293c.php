<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link href="/Public/css/swiper.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/Public/css/api.css" />
    <link rel="stylesheet" href="/Public/src/css/index.css">   <!--css-->
    <link rel="stylesheet" href="/Public/src/css/icon/iconfont.css">
    <script src="/Public/src/library/zepto.js"></script><!--页面js-->
    <script src="/Public/src/js/global.js"></script>
</head>
<body>
<header class="header">
    <div class="u-hd_f">
        <a class="iconfont  icon-xiangshangbiaoshi-copy" href="index.html"></a>
        <span class="h1">书单广场</span>
        <span></span>
    </div>
    <div class="u-hd_fbase"></div>
</header>
<div class="content" style=" margin-top: 10px;">
    <ul class="m-bookList">
        <?php if(is_array($arr)): foreach($arr as $key=>$v): if($v["gotos"] == 0): ?><li class="li"    onClick="location.href='<?php echo U('Index/dtail');?>?id=<?php echo ($v["bookid"]); ?>'" ><?php endif; ?>

                <?php if($v["gotos"] == 1): ?><li class="li"    onClick="location.href='<?php echo U('Index/guanggao');?>?id=<?php echo ($v["id"]); ?>'" ><?php endif; ?>

                <?php if($v["gotos"] == 2): ?><li class="li"    onClick="location.href='<?php echo U('Index/dtail');?>?id=<?php echo ($v["bookid"]); ?>'" >
                <a href="" target="_blank" ><?php endif; ?>

      

            <h4 class="h4"><?php echo ($v["title"]); ?></h4>
            <p class="imgList">
                <img src="/Public/<?php echo ($v["images"]); ?>" alt="">
                <img src="/Public/<?php echo ($v["imagest"]); ?>" alt="">
                <img src="/Public/<?php echo ($v["imagess"]); ?>" alt="">
            </p>
            <p class="ft">
                 <?php echo ($v["addtime"]); ?>
               
            </p>
        </li><?php endforeach; endif; ?>
    </ul>
</div>

<!-- <?php echo ($btn); ?> -->
<script src="/Public/src/js/book.js"></script>
</body>
</html>