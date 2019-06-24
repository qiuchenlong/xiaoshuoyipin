<?php  error_reporting(0);   ?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
	
    <title>畅读小说</title>
	 <meta name="description" content="畅读小说" />
	 <meta name="keywords" content="畅读小说,畅读小说,小说,阅读,小说阅读,免费阅读,在线阅读" />
	 
    <!-- <link rel="stylesheet" type="text/css" href="./css/api.css" />
    <script type="text/javascript" src="./script/api.js"></script>
    <script type="text/javascript" src="./script/FInit.js"></script> -->


    <script src="apk/jquery-1.7.1.js"></script>
    <style type="text/css">
	    body{ background:#ffffff;}
#download{
    		
    		width: 100%;
    		background: #ffffff; position:fixed; left:0px; bottom:0px; height:80px; color:#FFFFFF;
        text-align: center;
    
    	}
    	#con{
    		height: 30px;
        line-height: 30px;
        width: 50%;
        margin-left: 10%;
        margin-top: 20px;
    		background: url(android.png) no-repeat 10px 12px;
    		background-size: 25px;
        text-align: center;
        border: #cccccc 1px solid; overflow: hidden;
        border-radius: 5px;
    	}
    	p{
    		margin: 0;padding-bottom: 4px;
    	}
    	#type{
    		
    		font-size: 14px;
    		color: #fff;
    	}
    	#info{
    		font-size: 13px;
    		color: #fff;
    	}

        #myCarousel{/*height:375px;*/background: #aaa;}
        .carousel-inner img{height:100%;}
        a.carousel-control{font-size: 80px;}
		#app_intro img{ width:100%;}
		#ios img{ width:100%;}
		#jmeter img{ width:100%;}
		.main img{ width:100%; top:0px;left:0px;}
		.shouye{ width:100%;top:0px;left:0px; display:none; }
		.shouye img{ width:100%;top:0px;left:0px; }
    </style>
</head>

<body onLoad="isrowser();">

<div class="shouye" id="weixin" > <img src='apk/bg.jpg'/>

</div>

<!--<img src="images/xiazai.png" height="auto" border="0" id="weixin" style="display: none; width:100%; z-index:100;" >-->
  <div class="main" id="wrap"  style="display:none;">
  
       <img src='bg.jpg' style="width: 100%; height: auto;" onClick="onclicks()" />
         
            
 
	          <!--邀请码-->
			<?php  if($_REQUEST[yq]!=""){ ?>
			<div style="position: fixed; z-index:100; bottom:0px;right:0px;height:80px;line-height:80px; text-align:left; background:#F53241; font-weight:bold; color: #000000;">
			邀请码：<?php echo $_REQUEST[yq]; ?>
			</div>
			  <?php }?> 
		   
              <!--邀请码 end-->
<!-- 			  
<div id="download" onClick="onclicks()">
                    <div id="con">
					             
								    <span  style="color:#000; font-size:12px;">点击下载APP </span> <?php  echo $result_app_code[company];?>
								  
                       
						
                    </div>
</div>
	 -->
	
	
</div>


 
 
</body>


<script type="text/javascript">
	    //检测是否是扣扣浏览器
		function isrowser(){
		
    var u = navigator.userAgent,
     	app = navigator.appVersion;  

    if(u.indexOf('MicroMessenger') >-1){

	     document.getElementById("weixin").style.display="block";
		
	}else{
	
	  document.getElementById("wrap").style.display="block";

	  
	}	
	
  }
	//判断安卓还是苹果
	
// 	var u = navigator.userAgent, app = navigator.appVersion;
// var ios = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
// if(ios){
//   //document.getElementById("type").innerHTML="点击下载app";
//   document.getElementById("con").style.background="url(images/pingguo.png) no-repeat 10px 12px";
//   document.getElementById("con").style.backgroundSize="40px";
//   document.getElementById("con").style.paddingLeft="80px";
//   document.getElementById("con").style.paddingTop="16px";
 		
// }else{
//    //document.getElementById("type").innerHTML="点击下载app";
//    document.getElementById("con").style.background="url(images/android.png) no-repeat 10px 12px";
//      document.getElementById("con").style.backgroundSize="40px";
//   document.getElementById("con").style.paddingLeft="80px";
//   document.getElementById("con").style.paddingTop="16px";
// }

	
// }
//


//看是否是苹果设备

function onclicks(){

var u = navigator.userAgent, app = navigator.appVersion;
var ios = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
if(ios){
  location.href = "apk/pingguo.jpg";
}else{
   location.href = "apk/xiaoshuo.apk";
  
}



}
//
</script>
	
</html>
</html>