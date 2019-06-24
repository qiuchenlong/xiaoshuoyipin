<?php 

include_once("conn.php");


// if($_REQUEST[userid]!="")
// {
// $_SESSION[touserid]=$_REQUEST[userid];	
// }

// if(isset($_REQUEST['state'])){
// 	if($_REQUEST['state'] == "aa"){
// 		$code =$_REQUEST['code'];
// 		$APPID='wx0e2b34533e8d071b';
// 		$secret = "9f8e28dc67221a6c28bc8f93d8671acf";
		
// 		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$APPID&secret=$secret&code=$code&grant_type=authorization_code";
		
// 		$open_info = json_decode(file_get_contents($url));
		
// 		$url = "https://api.weixin.qq.com/sns/userinfo?access_token={$open_info->access_token}&openid={$open_info->openid}&lang=zh_CN ";
// 		$user_info = json_decode(file_get_contents($url));
		
// 		$result_user = mysql_query("SELECT * FROM `jieqi_system_users` WHERE `wx_openid`='{$user_info->openid}'");
// 		$row = mysql_fetch_assoc($result_user);
// 		// echo  $user_info->openid;
// 		if($row){ // 注册了
// 			$_SESSION['user_id'] = $row['uid'];
// 		}else{ // 未注册
// 			$insert_result = mysql_query("INSERT INTO `jieqi_system_users`(`wx_openid`, `sex`, `name`, `images`) VALUES('{$user_info->openid}', '{$user_info->sex}', '{$user_info->nickname}', '{$user_info->headimgurl}')");
// 			$uid = mysql_insert_id($insert_result);
// 			$_SESSION['user_id'] = $uid;
// 		}
// 	}
// }else{
// 	$APPID='wx0e2b34533e8d071b';
// 	$REDIRECT_URI='http://www.youdingb.com/xiangmu/xiaoshuoyipin/s.php';
// 	// $scope='snsapi_base';
// 	$scope='snsapi_userinfo'; //需要授权
// 	$state = "aa";
// 	$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
// 	header("Location:".$url);
// }


// //邀请者送钱
// $yqz=mysql_query("select *from hongbao where  userid ='".$_SESSION[userid]."' and touserid='".$_SESSION[touserid]."'");
// $yaoqing=mysql_fetch_array($yqz);

//    if($yaoqing!=true)
//    {
   
//    $srat=mysql_query("INSERT INTO hongbao(userid,touserid) VALUES ('$_SESSION[userid]','$_SESSION[touserid]')");
//    $srat1=mysql_query("update user  set money=money+1 where userid='".$_SESSION[touserid]."'");//
   
//    }



?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
		body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
		body{ background: #FFF; background-size:100% 100%;}
	</style>
<!-- 	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=djyOCUct33Tgp7gNIwSy2BGku62fFuS7"></script> -->
	<title会书城</title>
</head>

<body  onload="tanchu();">

</body>

</html>
<script type="text/javascript">
	
	//关于状态码
	//BMAP_STATUS_SUCCESS	检索成功。对应数值“0”。
	//BMAP_STATUS_CITY_LIST	城市列表。对应数值“1”。
	//BMAP_STATUS_UNKNOWN_LOCATION	位置结果未知。对应数值“2”。
	//BMAP_STATUS_UNKNOWN_ROUTE	导航结果未知。对应数值“3”。
	//BMAP_STATUS_INVALID_KEY	非法密钥。对应数值“4”。
	//BMAP_STATUS_INVALID_REQUEST	非法请求。对应数值“5”。
	//BMAP_STATUS_PERMISSION_DENIED	没有权限。对应数值“6”。(自 1.1 新增)
	//BMAP_STATUS_SERVICE_UNAVAILABLE	服务不可用。对应数值“7”。(自 1.1 新增)
	//BMAP_STATUS_TIMEOUT	超时。对应数值“8”。(自 1.1 新增)
	// function tanchu() {
	// 	window.location.href = 'index.php';
	// }
	
	
</script>
