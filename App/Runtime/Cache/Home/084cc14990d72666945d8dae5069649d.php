<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>title</title>
    <link rel="stylesheet" type="text/css" href="/Public/src/css/api.css" />
    <link rel="stylesheet" href="/Public/src/css/swiper-4.2.2.min.css"><!--轮播css-->
    <script src="/Public/src/library/zepto.js"></script><!--jQuery库 后面改成zepto-->
    <script src="/Public/src/library/js.cookie.js"></script><!--cookie API-->
    <script src="/Public/src/library/swiper-4.2.2.min.js"></script><!--页面js-->
      <link rel="stylesheet" href="/Public/css/api.css" />
    <link rel="stylesheet" href="/Public/src/css/index.css">
    <link rel="stylesheet" href="/Public/src/css/swiper-4.2.2.min.css"><!--轮播css-->
    <link rel="stylesheet" href="/Public/src/css/icon/iconfont.css">
    <script src="/Public/src/library/zepto.js"></script><!--页面js-->
    <script src="/Public/src/library/swiper-4.2.2.min.js"></script><!--页面js-->
    <script src="/Public/src/js/global.js"></script>
    <style>
        body, html{
            height: 100%;
            background: #fff;
        }
        .list{
            padding: 10px 20px;
            overflow: hidden;
        }
        .list li{
            width: 26%;
            float: left;
            margin-right: 10%;
            margin-bottom: 15px;
        }
        .list li:nth-child(3n){
            margin-right: 0px;
        }
        .list li .cover{
            position: relative;
            border-radius: 4px;
            /*overflow: hidden;*/
        }
        .cover img{width: 100%; height: 120px;}
        .list li .cover.active .bd{
            display: block;
        }
        .list li .cover.active .select{
            display: block;
        }
        .list li .cover .bd{
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
            display: none;
            background: rgba(0, 0, 0, 0.3);
        }
        .list li img{
            width: 100%;
            margin: 0px;
            padding: 0px;
        }
        .list li p{
            font-size: 14px;
            color: #717171;
            margin-top: 3px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }
        .select{
            position: absolute;
            width: 25px;
            height: 25px;
            background: url(/Public/src/images/gou.png) no-repeat;
            background-size: 25px;
            right: 5px;
            bottom: 5px;
            z-index: 9999;
            display: none;
        }
        .select.active{
            background-image: url(/Public/src/images/gou1.png);
        }
        .ft{
            position: fixed;
            padding: 10px 0px;
            bottom: 0px;
            left: 0px;
            border-top: 1px solid #eaeaea;
            width: 100%;
        }
        .ft .ft_bt{
            width: 85%;
            margin: 0px auto;
            background: #65ccdb;
            border-radius: 4px;
            text-align: center;
            height: 36px;
            line-height: 36px;
            color: #fff;
            font-size: 15px;
        }
        .booksList2{
            background: white;
            margin-top: 5px;
            padding: 0 10px 5px 10px;
        }
        .booksList2 ul li{
            border-bottom: 0px solid #f3f3f3;
            margin-bottom: 10px;
            position: relative;
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
            font-size: 12px;
            color: #787878;
            line-height: 15px;
        }
        .booksList2 ul li .bookInfo .booksName{
            font-size: 15px;
            color: #484848;
            margin-top: 5px;
            line-height: 25px;
        }
        .booksList2_title{
            padding: 0;
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
        .bookSelect{
            width: 25px;
            height: 25px;
            background: url(/Public/src/images/gou.png) no-repeat;
            background-size: 25px;
            float: left;
            vertical-align: middle;
            margin-top: 39px;
            margin-right: 5px;
            display: none;
        }
        .bookAcitve{
            background-image: url(/Public/src/images/gou1.png);
        }
        .booksList2 ul li .bookInfo{
            width: 68%;
        }
        .swiper-container{
            height: 32px;
            margin: 15px auto;
            border-radius: 10px;
            background: #f3f3f3;
        }
        .swiper-slide{
            padding: 0 10px;
            text-indent: 32px;
            line-height: 32px;
            font-size: 20px;
            border-radius: 16px;
            background: #f3f3f3;
            background: url(/Public/src/images/lb.png) no-repeat center left 5px,
            url(/Public/src/images/go.png) no-repeat center right 30px;
            background-size: contain, contain;
        }
        /*user_icon本页头部*/
        .bookrack_hd{display: flex; align-items: center; padding: 10px 20px;}
        .content-gift{ flex: 1; margin: 0 20px;}
        .swiper-pagination{display: none;}
        .user_icon{
            background: red;
            display: inline-block;
            border: 1px solid red;
            height: 30px;
            width: 30px;
            border-radius: 100%;
        }
        .user_icon img{
            width: 30px;
            height: 30px;
            border-radius: 100%;
        }
    </style>
</head>
<body ng-controller="DataController">
<div class="bookrack_hd">
   <!--  <a class="user_icon" href="<?php echo U('User/index');?>">
        <img src="/Public/src/images/ico-gift.png" alt="">
    </a> -->
<!--     <div class="content-gift">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">广播</div>
                <div class="swiper-slide">广播</div>
                <div class="swiper-slide">广播</div>
                <div class="swiper-slide">广播</div>
            </div>
            <!-- Add Pagination 
            <div class="swiper-pagination"></div>
            < Initialize Swiper 
        </div> -->
        <script>
            var swiper = new Swiper('.swiper-container', {
                direction  : 'vertical',
                pagination : {
                    el          : '.swiper-pagination',
                    hideOnClick : true,
                },
                loop       : true,
                delay      : 1500,
                autoplay   : {
                    disableOnInteraction : false,
                },
            });
        </script>
    </div>
</div>
<ul class="list">
    <!--  <li ng-repeat="b in bookList" >

         <div class="cover" >
         <span class="select" data="{{b.caseid}}" ></span>
            <div class="bd"></div>
            <img src="{{imgurl + b.images}}" ng-click="bookdetail(b.articleid)" />

         </div>

         <p>{{b.articlename}}</p>
      </li>-->

    <?php if(is_array($info)): foreach($info as $key=>$v): ?><li >
        <div class="cover">  
         <span onClick="location.href='<?php echo U('Index/shanchuhis');?>?id=<?php echo ($v["caseid"]); ?>'" style=" margin-top: -15px; position: absolute; right:-15px;"><img style=" width: 30px; height:auto; z-index: 100;" src="http://www.youdingb.com/xiangmu/xiaoshuoyipin/Public/images/shanchu.png">
         </span>
            <div class="bd"></div>
            <img src="/Public/<?php echo ($v["images"]); ?>"  onClick="location.href='<?php echo U('Index/dtail');?>?id=<?php echo ($v["articleid"]); ?>'" />
            <span class="select"></span>
        </div>
        <p><?php echo ($v["articlename"]); ?></p>
    </li><?php endforeach; endif; ?>


</ul>
<div class="booksList2">
    <ul>
        <!--			<li class="clearfix" ng-repeat="b in bookList"  >
                        <span class="bookSelect" data="{{b.caseid}}" ></span>
                        <div class="bookCover">

                            <img src="{{imgurl + b.images}}" />

                        </div>
                        <div class="bookInfo" ng-click="bookdetail(b.articleid)">
                            <p class="booksName">{{b.articlename}}</p>
                            <p class="txt">
                                {{b.intro}}
                            </p>
                            <div class="author">
                                <span>
                                    <i class="iconfont"><img src="../image/authors.png"/></i>
                                    {{b.author}}
                                </span>

                                <span class="labels">
                                    {{b.shortname}}
                                </span>
                                <span class="label">
                                    {{(b.size/20000).toFixed(1)}}万字
                                </span>
                            </div>
                        </div>
                    </li>-->
        <!--<li class="clearfix">
            <span class="bookSelect"></span>
            <div class="bookCover">
                <img src="../image/book0.png" alt="" />
            </div>
            <div class="bookInfo">
                <p class="booksName">在时光尽头等你</p>
                <p class="txt">
                    小四有次在接受采访的时候提到齐名的死，他不是因为对易瑶的死内疚或是对森湘的死痛苦才自杀的
                    ，齐名总是
                </p>
                <div class="author">
                    <span>
                        <i class="iconfont"><img src="../image/authors.png"/></i>
                        倾城
                    </span>

                    <span class="labels">
                        都市言情
                    </span>
                    <span class="label">
                        10万字
                    </span>
                </div>
            </div>
        </li>-->
    </ul>
</div>
<div class="ft" style="display:none;">
    <div class="ft_bt" ng-click="shanchu()">
        <span class="iconfont icon-shanchu" style="font-size:20px"></span>
        删除
    </div>
</div>

<footer class="footer">
  <div class="base"></div>
    <div class="menu">
        <a class="footer_a current" href="<?php echo U('Shujia/index');?>">
            <i class="iconfont icon-yg-shujia"></i>
            <span>书架</span>
        </a>
        <a class="footer_a" href="<?php echo U('Index/index');?>"> <i class="iconfont icon-shouye"></i> <span>首页</span> </a>
        <a class="footer_a" href="<?php echo U('Shuku/index');?>"> <i class="iconfont icon-yg-shujia"></i> <span>书库</span></a>
        <a class="footer_a" href="<?php echo U('Faxian/index');?>"><i class="iconfont icon-wode"></i><span>我的</span></a>
    </div>
</footer>

</body>
<script type="text/javascript" src="/Public/src/js/jquery-2.1.4.js"></script>
<script src="/Public/src/js/swiper.min.js"></script>
<script type="text/javascript">
    var swiper = new Swiper('.swiper-container', {
        pagination          : '.swiper-pagination',
        paginationClickable : true,
        direction           : 'vertical',
        autoplay            : 3000,
        speed               : 1000,
    });
    //  $('.booksList2 ul li').click(function(){
    //  alert(1);
    //  	if(!complete){
    //  		var $mark = $(this).find('.bookSelect').hasClass('bookAcitve');
    //  		if($mark){
    //  			$(this).find('.bookSelect').removeClass('bookAcitve');
    //  		}else{
    //  			$(this).find('.bookSelect').addClass('bookAcitve');
    //  		}
    //
    //		}else{
    //			api.openWin({
    //		         name: 'bookReader',
    //		         url: 'frame1/bookReader.html'
    //	         });
    //		}
    //
    //  })
    var app = angular.module('myApp', []);
    app.controller('DataController', function($scope) {
        $scope.bookList = [];
        $scope.sysList = [];
        $scope.imgurl = imageUrl;
        function systemlst() {
            $api.post(phpurl + 'Home/My/systemslst', function(ret) {
                if (ret.code == 200) {
                    $scope.sysList = ret.result;
                    $scope.$apply();
                    var swiper = new Swiper('.swiper-container', {
                        pagination          : '.swiper-pagination',
                        paginationClickable : true,
                        direction           : 'vertical',
                        autoplay            : 3000,
                        speed               : 1000,
                    });
                }
            });
        }
        function gate() {
            $api.post(phpurl + 'Home/My/mybookcase?user_id=' + userid, function(ret) {
                if (ret.code == 200) {
                    //				alert($api.jsonToStr(ret.result));
                    $scope.bookList = ret.result;
                    $scope.$apply();
                    $api.closeloadding();//关闭加载
                }
                $('.bookSelect').click(function() {
                    var id = $(this).attr('data');
                    var isH = $(this).hasClass('bookAcitve');
                    if (isH) {
                        var tuih = ',' + id;
                        caseid = caseid.replace(tuih, '');
                        $(this).removeClass('bookAcitve');
                    } else {
                        caseid += ',' + id;
                        $(this).addClass('bookAcitve');
                    }
                    event.stopPropagation();
                });
                $('.select').click(function() {
                    var id = $(this).attr('data');
                    var isH = $(this).hasClass('active');
                    if (isH) {
                        var tuih = ',' + id;
                        caseid = caseid.replace(tuih, '');
                        $(this).removeClass('active');
                    } else {
                        caseid += ',' + id;
                        $(this).addClass('active');
                    }
                    event.stopPropagation();
                });
            });
        }
        $scope.shanchu = function() {
            if (caseid == '') {
                $api.toast('请选择要删除的书本');
            }
            $api.post(phpurl + 'Home/My/delbookcase?caseid=' + caseid, {
                values : {},
            }, function(ret) {
                $api.toast('已删除');
                gate();
            });
        };
        EventT.on('apiready', function() {
            systemlst();
            api.addEventListener({//章节阅读
                name : 'shua_shujia',
            }, function(ret, err) {
                gate();
            });
            gate();
        });
        $scope.bookdetail = function(dates) {
            api.openWin({
                name      : 'win_headerfdsaf',
                url       : 'win_header.html',
                pageParam : {
                    frm_name : 'goods_detail25655',
                    frm_url  : 'frame0/bookDetails.html',
                    title    : '书籍详情',
                    data     : {
                        bookid : dates,
                    },
                },
            });
        };
        $scope.sysDe = function(dates) {
            api.openWin({
                name      : 'win_headsys',
                url       : 'win_header.html',
                pageParam : {
                    frm_name : 'sys_detail',
                    frm_url  : 'frame2/sysDetails.html',
                    title    : '信息详情',
                    data     : {
                        sysid : dates,
                    },
                },
            });
        };
    });
    var status = 1;
    var userid = 1,
        caseid = '';// 默认1
    var complete = true;  // 时候点击了整理图书标记，在点击删除和完成时恢复为true
    apiready = function() {
        userid = $api.getStorage('user_id');
        var showType = $api.getStorage('showType');
        if (showType == '列表展 示') {
            $('.list').css('display', 'none');
            $('.booksList2').css('display', 'block');
        } else {
            $('.list').css('display', 'block');
            $('.booksList2').css('display', 'none');
            $('.list').css('display', 'none');
            $('.booksList2').css('display', 'block');
        }
        api.addEventListener({
            name : 'bbook',  // 整理书籍
        }, function(ret, err) {
            complete = false;
            $('.ft').css('display', 'block');
            $('.cover').addClass('active');
            $('.bookSelect').css('display', 'block');
        });
        api.addEventListener({
            name : 'bok',   // 完成
        }, function(ret, err) {
            complete = true;
            $('.ft').css('display', 'none');
            $('.cover').removeClass('active');
            $('.bookSelect').css('display', 'none');
        });
        api.addEventListener({
            name : 'quanxuan',
        }, function(ret, err) {
            $('.select').addClass('active');
            $('.bookSelect').addClass('bookAcitve');
        });
        api.addEventListener({
            name : 'show_Way',
        }, function(ret, err) {
            var status = ret.value.status;
            caseid = '';
            if (status == 1) {
                $('.list').css('display', 'none');
                $('.booksList2').css('display', 'block');
            } else {
                $('.list').css('display', 'block');
                $('.booksList2').css('display', 'none');
            }
        });
        EventT.emit('apiready');
    };
</script>
</html>