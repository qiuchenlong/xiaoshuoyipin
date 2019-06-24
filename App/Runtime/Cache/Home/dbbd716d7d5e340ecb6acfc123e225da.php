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
</head>
<body>
<header class="header">
    <div class="base_rank"></div>
    <div class="ranking_header">
        <a class="iconfont icon-xiangshangbiaoshi-copy" href="<?php echo U('Index/index');?>"></a>
        <div class="types">
            <a data-value="1" 
            <?php if($biaoqian == 1 ): ?>class="type_a active"<?php endif; ?>
            <?php if($biaoqian != 1 ): ?>class="type_a"<?php endif; ?>href="javascript:;" >女生</a>

            <a data-value="2" <?php if($biaoqian == 2 ): ?>class="type_a active"<?php endif; ?>
            <?php if($biaoqian != 2 ): ?>class="type_a"<?php endif; ?> href="javascript:;">男生</a>
            <a data-value="3" <?php if($biaoqian == 3 ): ?>class="type_a active"<?php endif; ?>
            <?php if($biaoqian != 3 ): ?>class="type_a"<?php endif; ?>
             href="javascript:;">出版</a>
            <a data-value="4" <?php if($biaoqian == 4 ): ?>class="type_a active"<?php endif; ?>
            <?php if($biaoqian != 4 ): ?>class="type_a"<?php endif; ?> href="javascript:;">免费</a>
        </div>
        <div class="rank_date">
            <ul class="select" name="type3" id="select">
                <li class="js-select_val" value="1">周榜</li>
                <!--<li class="select_li" value="2">月榜</li>-->
            </ul>
        </div>
    </div>
</header>
<ul class="js-select">
    <li class="js-select_li current" value="1">
        <span><i class="select_w">W</i><em>周榜</em></span>
        <img src="/Public/src/images/select.png" alt="">
    </li>
    <li class="js-select_li" value="2">
        <span><i class="select_m">M</i><em>月榜</em></span>
        <img src="/Public/src/images/select.png" alt="">
    </li>
</ul>
<div class="m-ranking">
    <div class="rank_left">
        <ul class="ul">
            <li <?php if($sort == 'newbook' ): ?>class="li active"<?php endif; ?>
            <?php if($sort != 'newbook' ): ?>class="li"<?php endif; ?> data-values="newbook"> 新书榜</li>
            <li <?php if($sort == 'fengyun' ): ?>class="li active"<?php endif; ?>
            <?php if($sort != 'fengyun' ): ?>class="li"<?php endif; ?>  data-values="fengyun"> 风云榜</li>
            <li <?php if($sort == 'lianzai' ): ?>class="li active"<?php endif; ?>
            <?php if($sort != 'lianzai' ): ?>class="li"<?php endif; ?>  data-values="lianzai"> 连载榜</li>
            <li <?php if($sort == 'wanjie' ): ?>class="li active"<?php endif; ?>
            <?php if($sort != 'wanjie' ): ?>class="li"<?php endif; ?> data-values="wanjie"> 完结榜</li>
        </ul>
    </div>
    <div class="rank_right">
        <ul class="u-ul_lr">
        <?php if(is_array($paihang)): foreach($paihang as $key=>$x): ?><li class="li" onClick="location.href='<?php echo U('Index/dtail');?>?id=<?php echo ($x["articleid"]); ?>'" >
                <div class="left">
                    <img src="http://www.youdingb.com/xiangmu/xiaoshuoyipin/Public/<?php echo ($x["images"]); ?>" alt="">
                    <span class="rank_list">
                        <i class="nmb">1</i>
                        <i class="iconfont icon-bookmark type1"></i>
                    </span>
                </div>
                <div class="right">
                    <h3 class="h3 u-text_line"><?php echo ($x["articlename"]); ?></h3>
                    <p class="text">
                        <span class="author"><?php echo ($x["author"]); ?></span>
                        <span class="u-title1"><?php echo ($x["shortname"]); ?></span>
                        <span class="u-title2"><?php echo ($x["size"]); ?></span>
                    </p>
                    <p class="u-line2"><?php echo ($x["intro"]); ?></p>
                </div>
            </li><?php endforeach; endif; ?>

           <!-- <li class="li" onClick="location.href='dtail.html'"  >
                <div class="left">
                    <img src="/Public/src/images/i-01.png" alt="">
                    <span class="rank_list">
                        <i class="nmb">2</i>
                        <i class="iconfont icon-bookmark type2"></i>
                    </span>
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
            <li class="li" onClick="location.href='dtail.html'"  >
                <div class="left">
                    <img src="/Public/src/images/i-01.png" alt="">
                    <span class="rank_list">
                        <i class="nmb">3</i>
                        <i class="iconfont icon-bookmark type3"></i>
                    </span>
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
            <li class="li" onClick="location.href='dtail.html'"  >
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
            <li class="li" onClick="location.href='dtail.html'"  >
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
            <li class="li" onClick="location.href='dtail.html'"  >
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
            <li class="li" onClick="location.href='dtail.html'"  >
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
           <li class="li" onClick="location.href='dtail.html'"  >
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
           <li class="li" onClick="location.href='dtail.html'"  >
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
           <li class="li" onClick="location.href='dtail.html'"  >
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
    </div>
</div>
<!-- <script src="/Public/src/js/ranking.js"></script> -->

<script type="text/javascript">

var biaoqian="<?php echo ($biaoqian); ?>";
 var sort="<?php echo ($sort); ?>";
;(function () {
    // 要传的参数
    var params = {
        type1: '1',
        type2: '1',
        type3: '1'
    };
    // 获取数据
    function updateList() {
        console.log(params);
        $.ajax({
            type: 'get',
            url: gApi.rankList,
            data: params,
            success: function success(res) {
                // console.log(res);
                /*let str = ``;
                $('.rank_right').html(str);*/
            }
        });
    };
    $(function ($) {
        // 初始化
        updateList();
        // 选择左侧分类
        $('.rank_left .ul .li').on('click', function (e) {
            var $this = $(this);
             sort=$(this).attr('data-values');
             // alert(sort);
            // 显示
            $this.addClass('active').siblings().removeClass('active');
            // 赋值、数据请求
            // params.type1 = $this.attr('data-value');
            params.type1 = $this.data('value');
            updateList();
            jiazai();
        });
        // 选择顶部分类
        $('.type_a').on('click', function (e) {
            var $this = $(this); 

            biaoqian=$(this).attr('data-value');
            
            // 显示
            $this.addClass('active').siblings().removeClass('active');
            // 赋值、数据请求
            params.type2 = $this.data('value');
            updateList();
            jiazai();
        });
        // 选择下拉榜单
        $('#select').on('change', function (e) {
            // 赋值、数据请求
            params.type3 = this.value;
            updateList();
        });
        /*点击周榜响应*/
        $('.js-select_val').on('click', function (e) {
            $('.js-select').toggle();
        });
        $('.js-select').on('click', function (e) {
            $('.js-select').hide();
        });
        /*周榜月榜下拉*/
        $('.js-select_li').on('click', function (e) {
            $(this).addClass('current').siblings().removeClass('current');
            var str1 = $(this).find('em').text();
            $('.js-select_val').html(str1);
        });
    });
})();


    function  jiazai()

    {
  var id="<?php echo ($id); ?>";
window.location.href="<?php echo U('Paihang/index');?>?biaoqian="+biaoqian+"&sort="+sort;
    }
</script>
</body>
</html>