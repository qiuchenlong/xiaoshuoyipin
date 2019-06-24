<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link rel="stylesheet" href="/Public/css/api.css" />
    <link rel="stylesheet" href="/Public/src/css/index.css">   <!--css-->
    <link rel="stylesheet" href="/Public/src/css/icon/iconfont.css"><!--图标字体-->
    <script src="/Public/src/library/zepto.js"></script><!--页面js-->
    <script src="/Public/src/js/global.js"></script>
</head>
<body>
<div class="content">
    <!--小说详头部-->
    <div class="m-dtail_hd">
        <div class="top">
            <div class="left">
                <img class="js-imgurl" src="/Public/<?php echo ($arr["images"]); ?>" />
            </div>
            <div class="right">
                <h2 class="h2"><?php echo ($arr["articlename"]); ?></h2>
                <p class="author"><?php echo ($arr["author"]); ?></p>
                <p>
                    <span><?php echo ($arr["size"]); ?>万字</span>
                    <span>（已完结）</span>
                    <!-- <span><?php echo ($arr["saleprice"]); ?>金币/千字</span> -->
                </p>
                <p style=" display:  flex;justify-content: space-between;">
                    <span class="u-score">
                        <span class="star" style="width:<?php echo ($fenshu); ?>%"></span>
                    </span>
                    <span>&nbsp;&nbsp;&nbsp;<?php echo ($renshu); ?>人评分</span>
                </p>
                <p style=" display:  flex;justify-content: space-between;">
                  <!--   <span><?php echo ($arr["salenum"]); ?>人购买</span> -->
                </p>
            </div>
            <a class="iconfont icon-xiangshangbiaoshi-copy" href="<?php echo U('Shujia/index');?>"></a>
        </div>
        <div class="button" style="padding: 0.3rem;display:flex;justify-content:center;">
            <a href="<?php echo U('User/chong_zhi');?>">
                <i class="iconfont icon-money"></i>
                <i class="text">充值</i>
            </a>
           <!--  <i class="i">|</i>
            <a class="but_a" href="javascript:;">
                <i class="iconfont icon-custom-love"></i>
                <i class="text">收藏</i>
            </a> -->
            <i class="i">|</i>
            <a class="but_a js-share" href="javascript:;">
                <i class="iconfont icon-share"></i>
                <i class="text">分享</i>
            </a>
        </div>
    </div>
    <!--评论区-->
    <div class="m-comment">
        <div class="u-hd_title">
            <span class="left">
                <span class="text">评论</span>
            </span>
            <span class="right js-comment" href="javascript:;" style=" position: fixed; bottom: 40px; left: 40%; z-index: 1000; background: #ffffff;">
            我要评论</span>
            <div class="comment-on">
                <div class="u-hd_f">
                    <span class="iconfont  icon-xiangshangbiaoshi-copy"></span>
                    <span>书评区</span>
                    <span></span>
                </div>
                 <div class="comment_bd">
                    <span class="u-score">
                        <span class="star" ></span>
                    </span>
                    <form class="comment_form" action="<?php echo U('pladd');?>" method="post">
                        <!--评分-->
                        <input class="js-upstar" type="hidden" value="4" name="xing">
                        <!-- <input type="text" placeholder="标题 （选填）"> -->
                        <textarea name="text" id="" cols="30" rows="12" placeholder="写点什么吧亲爱的~" required ></textarea>
                        <input type="hidden" name="id" value="<?php echo ($_GET["id"]); ?>">
                    <a class="comment_btn" href="javascript:;">
                        <input type="submit" value="发表书评"></a>
                    <a class="comment-close" href="javascript:;"><img src="/Public/src/images/close_w.png" alt=""></a>
                      </form>
                </div>
            </div>
        </div>
        <div class="bd">
             <?php if(is_array($shu)): foreach($shu as $key=>$o): ?><div class="u-comment">
                <p class="comment_user">
                    <span class="iconfont icon-user"></span>
                    <span class="user_name"><?php echo ($o["name"]); ?></span>
                    <span class="u-score">
                        <span class="star" style="width: <?php echo ($o["xing"]); ?>%"></span>
                    </span>
                </p>
                <p class="text">
                   <?php echo ($o["content"]); ?>
                </p>
                <div class="foot">
                    <p class="left"><?php echo ($o["time"]); ?></p>
                    <p class="right">
                       <i>
                            <span><a href="<?php echo U('Index/pinglun');?>?id=<?php echo ($arr["articleid"]); ?>&shujia=1&dian=<?php echo ($o["id"]); ?>">点赞</a></span>
                            <span class="nmb"><?php echo ($o["likes"]); ?></span>
                        </i>
                      <!--   <i class="js-reply">
                            <span>回复</span>
                            <span class="nmb">0</span>
                        </i> -->
                    </p>
                </div>
                <!--<div class="u-reply reply_on">
                    <form class="reply_form" action="">
                        <h4 class="h4">
                            <img src="../src/images/close_green.png" alt="">
                            <span>写回复</span>
                            <img src="../src/images/send_green.png" alt="">
                        </h4>
                        <textarea class="textare" placeholder="写点什么吧亲爱的~"></textarea>
                    </form>
                </div>-->
            </div><?php endforeach; endif; ?>
        </div>
    </div>
    

</div>
    <!-- <?php echo ($btn); ?> -->

<!--打赏-->
<div class="liCover" style="display: none">
                    <div class="shareList">
                        <ul>
                            <li>
                                <img src="/Public/src/images/xianhua.jpg" alt="" />
                                <br />
                               鲜花
                            </li>
                            <li>
                                <img src="/Public/src/images/xianhua.jpg" alt="" />
                                <br />
                               鲜花
                            </li>
                            <li>
                                <img src="/Public/src/images/xianhua.jpg" alt="" />
                                <br />
                               鲜花
                            </li>
                            <li>
                                <img src="/Public/src/images/xianhua.jpg" alt="" />
                                <br />
                               鲜花
                            </li>
                            <!--<li>
                                <img src="../../image/weibo@2x.png" alt="" />
                                <br />
                                新浪微博
                            </li>-->
                        </ul>
                        <div class="li-cancel">
                            取消
                        </div>
                    </div>
                </div>

</body>
<script src="/Public/src/js/detail.js"></script>
</html>