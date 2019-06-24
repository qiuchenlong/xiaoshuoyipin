<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <!--line start-->
    <meta property="og:title" content="小说APP" />
    <meta property="og:description" content="精彩小说" />
    <meta property="og:url" content="分享網址" />
    <meta property="og:image" content="/Public/src/images/book0.png" />
    <!--line end-->
    <title></title>
    <!--<link rel="stylesheet" href="/Public/css/api.css" />-->
    <link rel="stylesheet" href="/Public/src/css/index.css">   <!--css-->
    <link rel="stylesheet" href="/Public/src/css/icon/iconfont.css"><!--图标字体-->
    <script src="/Public/src/library/zepto.js"></script><!--页面js-->
    <script src="/Public/src/js/global.js"></script>
    <script src="/Public/src/js/share.js"></script>
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
                    <span><?php echo ($arr["saleprice"]); ?>金币/章</span>
                </p>
                <p style=" display:  flex;justify-content: space-between;">
                    <span class="u-score">
                        <span class="star"></span>
                    </span>
                    <span><?php echo ($renshu); ?>人评分</span>
                </p>
                <p style=" display:  flex;justify-content: space-between;">
                    <span><?php echo ($arr["salenum"]); ?>人购买</span>
                </p>
            </div>
            <a class="iconfont icon-xiangshangbiaoshi-copy" href="<?php echo U('Shujia/index');?>"></a>
        </div>
        <div class="button" style="padding: 0.3rem;display:flex;justify-content:center;">
            <a class="but_a dashang" href="<?php echo U('User/chong_zhi');?>">
                <i class="iconfont icon-money"></i>
                <i class="text">充值</i>
            </a>
            <i class="i">|</i>
            <a class="but_a" href="dtail?id=<?php echo ($arr["articleid"]); ?>&jia=1">
                <i class="iconfont icon-custom-love"></i>
                <i class="text">收藏</i>
            </a>
           <!--  <i class="i">|</i>
            <a class="but_a js-share" href="javascript:;">
                <i class="iconfont icon-share"></i>
                <i class="text">分享</i>
            </a> -->
        </div>
    </div>
    <!--小说简介与编辑短评-->
    <div class="m-intro">
        <p class="appraise">
            <span class="h4">短评：</span>
            <span class="p"><?php echo ($arr["duanping"]); ?></span>
            <!--<i class="double1"></i>
            <i class="double2"></i>
            <i class="Buchecke"></i>-->
            <img class="quote0" style="position: absolute;top: 0.1rem;left: 0.1rem;width: 0.3rem;" src="/Public/src//images/quote0.png" alt="">
            <img class="quote1" style="position: absolute;bottom: 0.1rem;right: 0.1rem;width: 0.3rem;" src="/Public/src//images/quote1.png" alt="">
        </p>
        <p class="info">
            <?php echo ($arr["intro"]); ?>
        </p>
        <?php if(is_array($biao)): ?><p class="title-List" style="padding-top: 0;">
                <?php if(is_array($biao)): foreach($biao as $key=>$v): ?><a class="u-title1" href="javascript:;">
                        <?php echo ($v); ?>
                    </a><?php endforeach; endif; ?>
            </p>
            <?php else: ?>
            <p class="title-List" style="padding-top: 0;">
                <a class="u-title1" href="javascript:;">
                    <?php echo ($biao); ?>
                </a>
            </p><?php endif; ?>
    </div>
    <!--评论区-->
    <div class="m-comment">
        <div class="u-hd_title">
            <span class="left">
                <span class="text">评论</span>
            </span>
            <span class="right js-comment" href="javascript:;">我要评论</span>
            <div class="comment-on">
                <div class="u-hd_f">
                    <span class="iconfont  icon-xiangshangbiaoshi-copy"></span>
                    <span>书评区</span>
                    <span></span>
                </div>
                <div class="comment_bd">
                    <span class="u-score js-score">
                        <span class="star js-star"></span>
                    </span>
                    <form class="comment_form" action="<?php echo U('pladd');?>" method="post">
                        <!-- <input type="text" placeholder="标题 （选填）"> -->
                        <textarea name="text" id="" cols="30" rows="12" placeholder="写点什么吧亲爱的~"></textarea>
                        <input type="hidden" name="id" value="<?php echo ($_GET["id"]); ?>">
                        <!--评分-->
                        <input class="js-upstar" type="hidden" value="4">
                        <a class="comment_btn" href="javascript:;">
                            <input type="submit" value="发表书评">
                        </a>
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
                        <span class="star"></span>
                    </span>
                    </p>
                    <p class="text">
                        <?php echo ($o["content"]); ?>
                    </p>
                    <div class="foot">
                        <p class="left"><?php echo ($o["addtime"]); ?></p>
                        <p class="right">
                            <i>
                                <span><a href="dtail.html?id=<?php echo ($arr["articleid"]); ?>&shujia=1&dian=<?php echo ($o["id"]); ?>">点赞</a></span>
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
            <p style=" width: 100%; background: #fff; margin-bottom: 20px; line-height: 35px; height: 35px; color:green; text-align: center;" onClick="location.href='pinglun.html?id=<?php echo ($arr["articleid"]); ?>'">
                更多评论
            </p>
        </div>
    </div>
    <!--大家都在看-->
    <div class="m-time-travel">
        <div class="u-hd_title">
            <span class="left">
                <span class="text">大家都在看</span>
            </span>
            <!-- <span class="right" href="javascript:;">更多</span> -->
        </div>
        <div class="bd">
            <ul class="u-ul_lr">
                <?php if(is_array($yezai)): foreach($yezai as $key=>$y): ?><li class="li" onClick="location.href='dtail.html?id=<?php echo ($y["articleid"]); ?>'">
                        <div class="left">
                            <img src="/Public/<?php echo ($y["images"]); ?>" alt="">
                        </div>
                        <div class="right">
                            <h3 class="h3 u-text_line"><?php echo ($y["articlename"]); ?></h3>
                            <p class="text">
                                <span class="author"><?php echo ($y["author"]); ?></span>
                            </p>
                            <p class="u-line2"><?php echo ($y["intro"]); ?></p>
                        </div>
                    </li><?php endforeach; endif; ?>
            </ul>
        </div>
    </div>
    <!--书友还关注-->
    <div class="m-dtail_recom">
        <div class="u-hd_title">
            <span class="left">
                <span class="text">书友还关注</span>
            </span>
            <!-- <span class="right" href="javascript:;">更多</span> -->
        </div>
        <div class="bd">
            <ul class="u-ul_flex">
                <?php if(is_array($guanzhu)): foreach($guanzhu as $key=>$g): ?><li class="li" onClick="location.href='dtail.html?id=<?php echo ($y["articleid"]); ?>'">
                        <div class="top">
                            <a href="javascript:;">
                                <img src="/Public/<?php echo ($g["images"]); ?>" />
                            </a>
                        </div>
                        <div class="button">
                            <a class="u-line2" href="javascript:;"><?php echo ($g["articlename"]); ?></a>
                        </div>
                    </li><?php endforeach; endif; ?>
            </ul>
        </div>
    </div>
    <!--版本信息-->
    <div class="foot-v_info">
        <div class="u-hd_title">
            <span class="left">
                <!-- <span class="text">版本信息</span> -->
            </span>
            <a class="iconfont icon-xiangshangbiaoshi" href="javascript:;"></a>
        </div>
        <div class="bd">
            <p>
                <!-- 本书数字版权由XXX提供，并由其授权XXXXX有限公司制作发行，若包含不良信息，请及时告知客服。 -->
            </p>
        </div>
    </div>
    <!--点击下载APP-->
    <a class="m-appDownload" href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/a.php" style="padding-bottom: 1.22rem;">
        <div class="left">
            <img class="app_logo" src="/Public/src/images/logo.png" alt="">
            <div class="info">
                <h4 class="h4">安装看客小说客户端</h4>
                <p class="text">看更多正版好书</p>
            </div>
        </div>
        <span class="app_download">下载</span>
    </a>
</div>
<footer class="footer_dtail">
    <p class="btn" href="javascript:;">
        <?php if($shujia == null): ?><i class="iconfont icon-icon-test"><a href="dtail?id=<?php echo ($arr["articleid"]); ?>&jia=1">加入书架</a></i>
            <?php else: ?>
            已加书架<?php endif; ?>
    </p>
    <a class="btn current" href="book.html?id=<?php echo ($arr["articleid"]); ?>&zid=<?php echo ($arr["diyi"]); ?>"><i class="iconfont icon-read"></i>免费阅读</a>
</footer>
<!--打赏-->
<!--<div class="liCover" style="display: none">
    <div class="shareList">
        <ul>
            <li onclick="zhifu(0,'<?php echo ($arr["zongjia"]); ?>')">
                <p>整本购买<?php echo ($arr["zzhangjie"]); ?>集</p>
                <br /><?php echo ($arr["zongjia"]); ?>
                <b>8.5折</b>
            </li>
            <?php if(is_array($zhangjie)): foreach($zhangjie as $key=>$zj): ?><li onclick="zhifu('<?php echo ($zj["zj"]); ?>','<?php echo ($zj["jiage"]); ?>')">
                    <?php if($zj["mai"] == 1): ?><span>已经买</span><?php endif; ?>
                    <p><?php echo ($zj["kaishi"]); ?>-<?php echo ($zj["jieshu"]); ?>集</p>
                    <br /> <?php echo ($zj["jiage"]); ?>金币
                </li><?php endforeach; endif; ?>
            &lt;!&ndash;<li>
                <img src="../../image/weibo@2x.png" alt="" />
                <br />
                新浪微博
            </li>&ndash;&gt;
        </ul>
        <div class="li-cancel">
            取消
        </div>
    </div>
</div>-->
<!--分享-->
<div class="shareCover" style="display: none">
    <div class="shareList">
        <ul>
            <li>
                <img class="share_facebook" src="/Public/src/images/wechat@2x.png" alt="" />
                <br />
                facebook
            </li>
            <li>
                <a class="share_line" href="" style="display: inline-block;">
                    <img src="/Public/src/images/kj@2x.png" alt="" />
                    <br />
                    line
                </a>
            </li>
            <!--<li>
                <img src="../../image/weibo@2x.png" alt="" />
                <br />
                新浪微博
            </li>-->
        </ul>
        <div class="js-cancel">
            取消
        </div>
    </div>
</div>
</body>
<script src="/Public/src/js/detail.js"></script>
<script type="text/javascript" src="/Public/src/js/zhifu.js"></script>
<script type="text/javascript">
    /*$('meta[property="og:title"]').attr("content", $('.m-dtail_hd .author').text());
    $('meta[property="og:description"]').attr("content", $('.m-intro .info').text());
    $('meta[property="og:image"]').attr("content", $('.js-imgurl').attr("src"));*/
    /*function zhifu(n, m) {
        $id = '<?php echo ($arr["articleid"]); ?>';
        // alert(n);
        window.location.href = '<?php echo U('chongzhi');?>?zj=' + n + '&price=' + m + '&id=' + $id;
    }*/
    $('.share_facebook').on('click', function(e) {
        FB.ui({
            method : 'share',
            // href   : 'http://www.baidu.com', //通过后替换成该网址的
            href   : 'http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/Index/dtail.html' + location.search, //通过后替换成该网址的
            redirect_uri:'http://www.baidu.com'
        }, function(response) {});
    });
    $('.share_line').on('click', function(e) {
        $(this).attr('href', 'https://lineit.line.me/share/ui?url=' + location.href);
        // window.open('https://lineit.line.me/share/ui?url=' + location.href, 'newwindow', 'height=600, width=800,  toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no')
    });
</script>
</html>