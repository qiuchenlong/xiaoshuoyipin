<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link rel="stylesheet" href="/Public/src/css/index.css">   <!--css-->
    <link rel="stylesheet" href="/Public/src/css/icon/iconfont.css">
    <script src="/Public/src/library/zepto.js"></script><!--页面js-->
    <script src="/Public/src/js/global.js"></script>
    <style type="text/css">
     .d_bd img{ width: 15px; height: 15px;}
     .d_left .d_bd li{width: 100%; line-height: 0.62rem; color: #999; display: flex; justify-content: space-between; align-items: center;}
     .m-YetMoney{
        position: fixed;
        width: 100%;
        height:100%;
        top:0;
        left:0;
     }
     .m-YetMoney .js-yetMoney{
        position: absolute;
        bottom: 0;
        background: #fff;
        color: #232323;
        width: 100%;
        padding: 20px 10px;
        font-size: 0.36rem;
        line-height: 2;
     }
     .js-yetMoney .btn{
        color: #fff;
        text-align: center;
        border-radius: 2em;
        line-height: 3;
        margin-bottom: 1em;
     }
    </style>
</head>
<body>
<section class="book_conter">
    <article class="js-comment m-article">
       <!--  <h1 class="h1"><?php echo ($zhang["chaptername"]); ?></h1> -->
        <div class="bd">
          
            <?php if($_GET["mai"] == 1): ?><span >收费章节</span><br>
            <button>订阅本章： 12书币</button><br>
            <a href="">开启自动订阅</a>
            <?php else: echo ($zhang["attachment"]); endif; ?>

        </div>
        <div class="ft">
             <a class="m-appDownload" href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/a.php" style="padding-bottom: .22rem;">
        <div class="left">
            <img class="app_logo" style="width: 80px; height: 80px;" src="/Public/src/images/logo.png" alt="">
            <div class="info">
                <h4 class="h4">安装看客小说客户端</h4>
                <p class="text">下载APP即可获得100书币红包，阅读体验更佳</p>
            </div>
        </div>
        <span class="app_download" style=" font-size: 11px;">下载</span>
    </a>
        </div>
    </article>
    <div class="g-propagation">
        <div class="hd">
            <a href="javascript:history.back(-1);">
                <i class="iconfont icon-xiangshangbiaoshi-copy"></i>
                <span>返回</span>
            </a>
            <h2 class="book_name"><?php echo ($shuming); ?></h2>
            <nav class="menu">
                <a class="iconfont icon-mulu1 js-menu" href="javascript:;"></a>
                <div class="ul">
                    <a class="li" href="<?php echo U('Index/index');?>">
                        <i class="iconfont icon-index"></i>
                        <span>首页</span>
                    </a>
                    <a class="li" href="<?php echo U('User/chong_zhi');?>">
                        <i class="iconfont icon-fenlei"></i>
                        <span>充值</span>
                    </a>
                    <a class="li" href="<?php echo U('Paihang/index');?>">
                        <i class="iconfont icon-paihang"></i>
                        <span>排行</span>
                    </a>
                    <a class="li" href="<?php echo U('Shujia/index');?>">
                        <i class="iconfont icon-shujia1"></i>
                        <span>书架</span>
                    </a>
                </div>
            </nav>
        </div>
        <div class="ft" >
            <p class="ft_li">
                <span class="js-size_minus">Aa-</span>
                <span class="progressbar0">
                    <span class="progressbar1"></span>
                </span>
                <span class="js-size_add">Aa+</span>
            </p>
            <p class="ft_li">
                <span class="bg_tab current">默认</span>
                <span class="bg_tab">夜间</span>
                <span class="bg_tab">护眼</span>
            </p>
            <p class="ft_li">
                <span><a href="<?php echo U('index/book');?>?id=<?php echo ($_GET["id"]); ?>&zid=<?php echo ($_GET["zid"]); ?>&shang=1&shu=<?php echo ($_GET["shu"]); ?>&mai=<?php echo ($_GET["mai"]); ?>">上一章</a></span>
                <span class="js-directory">目录</span>
                <span><a href="<?php echo U('index/book');?>?id=<?php echo ($_GET["id"]); ?>&zid=<?php echo ($_GET["zid"]); ?>&xia=1&shu=<?php echo ($_GET["shu"]); ?>&mai=<?php echo ($_GET["mai"]); ?>">下一章</a></span>
            </p>
        </div>
    </div>
    <div class="m-directory">
        <div class="d_left">
            <ul class="d_hd">
                <li class="h1"><?php echo ($shuming); ?></li>
                <li class="h2">目录</li>
            </ul>
            <ul class="d_bd">
                <?php if(is_array($arr)): foreach($arr as $key=>$v): ?><a class="li active" href="<?php echo U('index/book');?>?id=<?php echo ($_GET["id"]); ?>&zid=<?php echo ($v["chapterid"]); ?>&mai=<?php echo ($v["mai"]); ?>&shu=<?php echo ($v["shu"]); ?>">
                    <li><p><?php echo ($v["chaptername"]); ?></p>
                    <?php if($v["mai"] == 1): ?><img src="/Public/images/suo.png"/>
                    <?php elseif($v["mai"] == 2): ?><img src="/Public/images/jiesuo.png"/><?php endif; ?>
                    </li>
                </a><?php endforeach; endif; ?>
            </ul>
        </div>
        <div class="d_right"></div>
    </div>
   <!--  <div class="m-YetMoney">
        <div class="js-yetMoney">
            <p>价格：9 金币</p>
            <p>余额：0 金币 + 6 代金券</p>
            <p style="color: #ccc;font-size: 0.28rem;margin-bottom: 0.1rem;">自动购买下一章并不显示</p>
            <div class="btn" style="background: #5fb55f;">余额不足，充值并购买</div>
            <div class="btn" style="background: #f0954c;">批量购买享 8 折优惠</div>
        </div>
    </div> -->
</section>
<script src="/Public/src/js/book.js"></script>
</body>
</html>