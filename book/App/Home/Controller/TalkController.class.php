<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
include_once("UpFileTool.class.php");
include_once("Common.php");
include_once("mysqlha.php"); 
header("Content-Type:text/html; charset=utf-8");

class TalkController extends Controller {

	//添加话题
    public function addTalk(){
		$user_id = $_REQUEST['user_id'];
		$content = $_REQUEST['content'];//
		$classify_id = $_REQUEST['classify_id'];// 一级分类
        $seclassify_id = $_REQUEST['seclassify_id'];// 二级分类
		$type = $_REQUEST['type']; //图片是0 视频是1 纯文本是2
		$lon = $_REQUEST['lon'];//
		$lat = $_REQUEST['lat'];//
		$city = $_REQUEST['city'];//发布动态城市
		$location =$_REQUEST['location'];//
		$money = $_REQUEST['money'];//查看所需的金额
        $Model = M();

        $updateArr['money'] = $money; 
		$updateArr['lon'] = $lon;
		$updateArr['lat'] = $lat;  
		$updateArr['classify_id'] = $classify_id; 
		$updateArr['seclassify_id'] = $seclassify_id;
		$updateArr['type'] = $type;//0为图片 1为视频,2是纯文本
		$updateArr['location'] = $location;
		$updateArr['city'] = $city;
		$updateArr['content'] = $content;  
		$updateArr['user_id'] = $user_id;
		
		if ($_FILES) {
            if($type == 0){  
				$UpFileTool = new \Think\UpFileTool('flie');// 实例化上传类
				$UpFileTool->multiImage(0.4,'Uploads','Uploads');
				$multiSumbImage = $UpFileTool->multiSumbImage;
				$multiSrcImage = $UpFileTool->multiSrcImage;
				$updateArr['images'] = $multiSrcImage;
				$updateArr['sumbimages'] = $multiSumbImage; 
			}else{   
				$UpFileTool = new \Think\UpFileTool('flie'); 
				// $UpFileTool2 =  new \Think\UpFileTool('cover'); 

                $UpFileTool->upFile($srcimage='Uploads');
                // $UpFileTool2->upImage(0.3,'Uploads','Uploads');
				$video=$UpFileTool->srcImage;
				// $srcimage = $UpFileTool2->$srcImage;
				// $sumbimages = $UpFileTool2->$sumbImage; 
				$http_url = "http://www.fondfell.com/superDao/apis/ll/";
				$updateArr['video'] = $http_url.$video;  
				//$updateArr['images'] = 222;//$srcimage;  
				//$updateArr['sumbimages'] = 333;//$sumbimages; 
				// $updateArr['duration'] = $_REQUEST['duration'];     
				// echo json_encode($updateArr);die;      
			} 
			
		}  
		myinsert('talk',$updateArr); 
		 
		if(!empty($classify_id)){ 
		$count = $Model->query("SELECT count(*) as count FROM hb_talk WHERE classify_id=".$classify_id." AND user_id=".$user_id.";");//一个用户的话题数量。
		$count = $count[0]['count']; 
		if($count>11){ 
	    $classname = $Model->query("SELECT name FROM hb_classify WHERE classify_id=".$classify_id.";");
		$Model->execute("update user set fields='".$classname[0]['name']."' where user_id=".$user_id."");//发过超过10条就改变用户的领域
		}
		}
		
		$Model->execute("update user set talkcount=talkcount+1 where user_id=".$user_id."");
		$resultArr = array(
		   "code"=>200,
			"msg"=>"添加成功"  
		);
		echo json_encode($resultArr);
	}
	
	//添加点赞
	public function addTalkLike(){
		$user_id = $_REQUEST['user_id'];
		$talk_id = $_REQUEST['talk_id'];
		$Model = M();
		$count = $Model->Query("select count(*) as count from hb_talklike where talk_id=".$talk_id." and user_id=".$user_id."");
		$count = $count[0]['count'];
		if($count == 0){
			$insertArr = array(
				"user_id"=>$user_id,
				"talk_id"=>$talk_id
			);
			myinsert('talklike',$insertArr);
			$Model->execute("update talk set likecount=likecount+1 where talk_id=".$talk_id."");
			$resultArr = array(
			   "code"=>200,
				"msg"=>"添加点赞成功"
			);
		}else{
			del('talklike',"talk_id=".$talk_id." and user_id=".$user_id."");
			$Model->execute("update talk set likecount=likecount-1 where talk_id=".$talk_id."");
			$resultArr = array(
			   "code"=>201,
				"msg"=>"取消点赞成功"
			);
		}
		echo json_encode($resultArr);
	}
	
	//收藏话题
	public function collectionTalk(){
		$user_id = $_REQUEST['user_id'];
		$talk_id = $_REQUEST['talk_id'];
		
		$insertArr = array(
		   "user_id"=>$user_id,
		   "talk_id"=>$talk_id
		);
		$model = M();
		$isshoucang = $model->query("SELECT user_id FROM hb_collection WHERE user_id=".$user_id." AND talk_id=".$talk_id.";");
		$isshoucang = $isshoucang[0];
		if($isshoucang){
			$resultArr = array(
		      "code"=>201,
		      "msg"=>"已经收藏过"
		  );
		  echo json_encode($resultArr);
		}else{
			myinsert('collection',$insertArr);
		    $resultArr = array(
		      "code"=>200,
		      "msg"=>"收藏成功"
		  );
		  echo json_encode($resultArr);
		}
		
	}
	
	//添加分享 
	public function shareTalk(){ 
		$user_id = $_REQUEST['user_id'];
		$talk_id = $_REQUEST['talk_id'];
		$Model = M();
		$insertArr = array(
		   "user_id"=>$user_id,
		   "talk_id"=>$talk_id
		);
		
		myinsert('sharetalk',$insertArr); 
		$Model->execute("update talk set sharecount=sharecount+1,jishicount=jishicount+1 where talk_id=".$talk_id.";");
		$Model->execute("update user set sharecount=sharecount+1 where user_id=".$user_id."");
		$resultArr = array(
		   "code"=>200,
		   "msg"=>"分享成功"
		);
		echo json_encode($resultArr);
	}


	
	//获取我的分享和收藏和我的飞享
	public function getMyTalkList(){
		$page = $_REQUEST["page"];
		$pagecount = $_REQUEST['pagecount'];
		if($page == null||$page<=0){ 
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}
		$startcount = $page*$pagecount;

		$user_id = $_REQUEST['user_id'];  
		$type = $_REQUEST['type']; 
		$Model = M();
		if($type == 0){//我的收藏
			$result = $Model->Query("select t1.headimg,t1.sumbheadimg,t1.name,t2.content,t.talk_id,t.collection_id from hb_collection t,hb_user t1,hbtalk t2 where t.talk_id=t2.talk_id and t2.user_id=t1.user_id and t.user_id=".$user_id." limit ".$startcount.",".$pagecount."");
		}else if($type == 1){//我的分享
			$result = $Model->Query("select t1.headimg,t1.sumbheadimg,t1.name,t2.content,t.talk_id from hb_sharetalk t,hb_user t1,hb_talk t2 where t.talk_id=t2.talk_id and t2.user_id=t1.user_id and t.user_id=".$user_id." limit ".$startcount.",".$pagecount."");
		}else if($type == 2){//我的飞享
			$result = $Model->Query("select t1.headimg,t1.sumbheadimg,t1.name,t.* from hb_talk t,hb_user t1 where t.user_id=t1.user_id and t.user_id=".$user_id." limit ".$startcount.",".$pagecount."");
		}
		
		$result = array($result);
		echo getSuccessJson($result);
	}

	//获取我浏览的记录。
	public function getMyGet(){
		$page = $_REQUEST["page"];
		$pagecount = $_REQUEST['pagecount'];
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}
		$startcount = $page*$pagecount;

		$user_id = $_REQUEST['user_id'];   

		$Model = M();
		$result = $Model->Query("select t1.headimg,t1.sumbheadimg,t1.name,t2.content,t.talk_id,t.id from hb_browsinghistory t,hb_user t1,hb_talk t2 where t.talk_id=t2.talk_id and t2.user_id=t1.user_id and t.user_id=".$user_id." limit ".$startcount.",".$pagecount."");
		$result = array($result); 
		echo getSuccessJson($result);  
	} 

		//删除我的浏览记录
	public function delhistory(){ 
		$id = $_REQUEST['id'];
		$Model = M();  
		$is_del = $Model->execute("DELETE FROM hb_browsinghistory WHERE id=".$id.";");
		if($is_del){ 
			$result = array('code'=>200,'msg'=>"删除成功");
		}else{
			$result = array('code'=>201,'msg'=>"删除失败");
		}
		$this->ajaxReturn($result); 
	} 



	//删除我的飞享
	public function delmyfeixiang(){
		$talk_id = $_REQUEST['talk_id'];
		$Model = M(); 
		$is_del = $Model->execute("DELETE FROM hb_talk WHERE talk_id=".$talk_id.";");
		if($is_del){
			$result = array('code'=>200,'msg'=>"删除成功");
		}else{
			$result = array('code'=>201,'msg'=>"删除失败");
		}
		$this->ajaxReturn($result); 
	} 

	//删除我的收藏
	public function delmycollect(){
		$collection_id = $_REQUEST['collection_id'];  
		$Model = M();
		$is_del = $Model->execute("DELETE FROM hb_collection WHERE collection_idcollection_id=".$collection_id.";");
		if($is_del){ 
			$result = array('code'=>200,'msg'=>"删除成功");
		}else{
			$result = array('code'=>201,'msg'=>"删除失败");
		}
		$this->ajaxReturn($result);
	} 


	
	//获取话题详情
	public function TalkDetail(){
		$talk_id = $_REQUEST['talk_id'];
		$user_id = $_REQUEST['user_id'];//用户id
		$flag = FALSE;
		$Model = M();
		$talk = $Model->Query("select * from hb_talk where talk_id=".$talk_id."");
		$talk[0]['addtime'] = time_tran($talk[0]['addtime']);
		$money = $talk[0]['money'];//所需看话题的金额
		$to_user_id = $talk[0]['user_id'];//发起话题的用户
		if($user_id === $to_user_id){
			$flag = TRUE; 
		}
		$needmoney = $Model->Query("select name,needmoney,job,headimg,companyname,authentication from hb_user where user_id=".$to_user_id."");
		$talk[0]['name'] = $needmoney[0]['name'];
		$talk[0]['needmoney'] = $needmoney[0]['needmoney'];
		$talk[0]['zhiwei'] = $needmoney[0]['job'];
		$talk[0]['headimg'] = $needmoney[0]['headimg'];
		$talk[0]['danwei'] = $needmoney[0]['companyname']; 
		$talk[0]['authentication'] = empty($needmoney[0]['authentication'])?'':$needmoney[0]['authentication']; 
		//获取是否购买了
		$count = $Model->Query("select count(*) as count from hb_payrecord where a_id=".$talk_id." and user_id=".$user_id." and type=1");
		$count = $count[0]['count'];  
		if($count>0 || $money==0 || $flag){ 
		    $talk[0]['isbuy'] = 1;
		    $histroycount = $Model->Query("SELECT count(*) as count FROM hb_browsinghistory WHERE user_id=".$user_id." AND talk_id=".$talk_id.";"); 
		    if($histroycount[0]['count']<1)
		    $Model->execute("INSERT INTO hb_browsinghistory (user_id,talk_id) VALUES (".$user_id.",".$talk_id.");");//浏览记录
		}else{
			$talk[0]['isbuy'] = 0; 
		}
		//获取是否已关注
		$count = $Model->Query("select count(*) as count from hb_follow where user_id=".$user_id." and to_user_id=".$to_user_id."");
		$count = $count[0]['count'];  
		if($count>0){
			$talk[0]['isguan'] = 1;
		}else{
			$talk[0]['isguan'] = 0;
		}
		
		//获取是否点赞
		$count = $Model->Query("select count(*) as count from hb_talklike where user_id=".$user_id." and talk_id=".$talk_id."");
		$count = $count[0]['count'];
		if($count>0){
			$talk[0]['islike'] = 1;
		}else{
			$talk[0]['islike'] = 0;
		}
		
		//查看作者的飞答条数
		$dacount = $Model->Query("select count(*) as count from hb_problem where to_user_id=".$to_user_id." and state=1");
		$dacount = $dacount[0]['count'];
		$talk[0]['dacount'] = $dacount;
		$result = array($talk);
		echo getSuccessJson($result);
	}
	
	//获取列表
	public function getTalkList(){
		$user_id = $_REQUEST['user_id']; 
		$page = $_REQUEST["page"];
		$pagecount = $_REQUEST['pagecount'];
		$longitude =$_REQUEST['lon'];
    	$latitude = $_REQUEST['lat'];
		$type = $_REQUEST['type'];
		$Model = M();
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

        
		$startcount = $page*$pagecount;
		$where = "";
		
		
		if($type == 0){  
			//视频
			//$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.sumbheadimg,t1.headimg,t1.authentication,t1.name as niname from talk t,user t1 where t.video!='' AND t.user_id=t1.user_id) tb1 left join seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.addtime desc,tb1.replycount desc limit ".$startcount.",".$pagecount."");
		    //全部
			$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.avatarUrl as sumbheadimg,t1.avatarUrl as headimg,t1.nickName as niname from hb_talk t,hb_user t1 where t.user_id=t1.user_id) tb1 left join hb_seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.addtime desc,tb1.replycount desc limit ".$startcount.",".$pagecount."");
			// echo $Model->_sql();die;
		}else if($type == 1){  
			//获取我喜欢的 
			// $classify = $Model->Query("select classify from user where user_id=".$user_id."");
			// $classify = $classify[0]['classify'];
			// $classify = explode(',',$classify);
			// for($i=0;$i<sizeof($classify);$i++){ 
			// 	if($i == 0){
			// 		$where.="t.classify_id=".$classify[$i]." ";
			// 	}else{
			// 		$where.="or t.classify_id=".$classify[$i]." ";
			// 	}
			// }
			// if($where != ""){  
			// 	$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.sumbheadimg,t1.headimg,t1.name as niname from talk t,user t1 where t.user_id=t1.user_id and (".$where.")) tb1 left join seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id  order by tb1.replycount desc limit ".$startcount.",".$pagecount."");
			// }else{
			// 	$result = array();
			//   }

			//获取热门  
			// $result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.sumbheadimg,t1.authentication,t1.headimg from talk t,user t1 where t.user_id=t1.user_id and t.hot=1) tb1 left join seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.addtime desc limit ".$startcount.",".$pagecount."");
			//tb1.replycount desc, 
			//
			 //全部
			$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.avatarUrl as sumbheadimg,t1.avatarUrl as headimg,t1.nickName as niname from hb_talk t,hb_user t1 where t.user_id=t1.user_id) tb1 left join hb_seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.addtime desc limit ".$startcount.",".$pagecount."");
			//,tb1.replycount desc 
		}else if($type == 2){   
			//获取头条 
			$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.avatarUrl as sumbheadimg,t1.avatarUrl as headimg,t1.nickName as niname,t1.authentication from hb_talk t,hb_user t1 where t.user_id=t1.user_id and t.toutiao=1) tb1 left join hb_seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.addtime desc,tb1.replycount desc limit ".$startcount.",".$pagecount."");
		}else if($type == 3){
			 //获取我关注的
            $followlist = $Model->Query("select to_user_id from hb_follow where user_id=".$user_id."");
            for($i=0;$i<sizeof($followlist);$i++){
				if($i == 0){
					$where.="t.user_id=".$followlist[$i]['to_user_id']." ";
				}else{
					$where.="or t.user_id=".$followlist[$i]['to_user_id']." ";
				}
			}	
            if($where != ""){
				$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.avatarUrl as sumbheadimg,t1.avatarUrl as headimg,t1.nickName as niname,t1.authentication from hb_talk t,hb_user t1 where t.user_id=t1.user_id and (".$where.")) tb1 left join hb_seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.addtime desc,tb1.replycount desc limit ".$startcount.",".$pagecount."");
			}else{ 
				$result = array();
			}
			
		}else if($type == 4){
			//获取同城 rtrim($str,"World!") 
			$city = $_REQUEST['city']; 
			$classify_id = $_REQUEST['classify_id'];
			if(!empty($classify_id)){
			$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.sumbheadimg,t1.headimg,t1.authentication,t1.name as niname from hb_talk t,hb_user t1 where t.user_id=t1.user_id and t.seclassify_id=".$classify_id." and  t.city like '%".$city."%') tb1 left join hb_seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.replycount desc,tb1.addtime desc limit ".$startcount.",".$pagecount."");	
			}else{
				$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.sumbheadimg,t1.authentication,t1.headimg,t1.name as niname from hb_talk t,hb_user t1 where t.user_id=t1.user_id and  t.city like '%".$city."%') tb1 left join hb_seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.replycount desc,tb1.addtime desc limit ".$startcount.",".$pagecount."");
			}
		}else if($type == 5){
			$classify_id = $_REQUEST['classify_id'];
			$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.sumbheadimg,t1.authentication,t1.headimg,t1.name as niname from hb_talk t,hb_user t1 where t.user_id=t1.user_id and t.classify_id=".$classify_id.") tb1 left join hb_seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.replycount desc,tb1.addtime desc limit ".$startcount.",".$pagecount."");
		}else if($type == 6){
			$to_user_id = $_REQUEST['to_user_id'];
			$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.sumbheadimg,t1.authentication,t1.headimg,t1.name as niname from hb_talk t,hb_user t1 where t.user_id=t1.user_id and t.user_id=".$to_user_id.") tb1 left join hb_seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.replycount desc,tb1.addtime desc limit ".$startcount.",".$pagecount."");
		}
		foreach ($result as $key => $value) {
			$addtime = strtotime($value['addtime']);
			$result[$key]['addtime']=timeToStr($addtime); 
		} 
		$result = array($result);
		echo getSuccessJson($result,'查询成功'); 
	}


	//二级分类筛选
	public function shaixuan(){
		$seclassify_id = $_REQUEST['seclassify_id'];
		$authentication = $_REQUEST['authentication'];//1为未认证，2为认证
		$page = $_REQUEST["page"]; 
		$pagecount = $_REQUEST['pagecount']; 
		$Model = M();
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}
		$where = "t1.user_id>0";
		if(!empty($authentication)){
			if($authentication==1){
			  $where .=" and t1.authentication=0";
			}else{
				$where .=" and t1.authentication>0";
			}
		} 

        
		$startcount = $page*$pagecount; 
		$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.sumbheadimg,t1.headimg,t1.authentication from talk t,user t1 where t.user_id=t1.user_id and t.seclassify_id=".$seclassify_id." and ".$where.") tb1 left join seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.replycount desc limit ".$startcount.",".$pagecount."");
		// echo $Model->_sql();die;
		$result = array($result);
		echo getSuccessJson($result);

	}
	//同城搜索一级 
	public function SameCitySearch(){
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		$authentication = $_REQUEST['authentication'];//1为未认证，2为认证
		$city = $_REQUEST['city']; 
		$classify_id = $_REQUEST['seclassify_id'];//二级分类 

		$Model = M();
		
		if($page == null||$page<=0){
			$page=0;
		} 

		if($pagecount == null||$pagecount<=0){ 
			$pagecount=10;
		}
		$startcount = $page*$pagecount;

		$where = "t1.user_id>0";
		if(!empty($authentication)){
			if($authentication==1){
			  $where .=" and t1.authentication=0";
			}else{
				$where .=" and t1.authentication>0";
			}
		} 

		// $city = rtrim($_REQUEST['city'],"市");
		$city = $_REQUEST['city']; 
		$classify_id = $_REQUEST['seclassify_id'];//二级分类 
			$result = $Model->Query("select tb1.*,tb2.name FROM (select t.*,t1.authentication,t1.sumbheadimg,t1.headimg from talk t,user t1 where t.user_id=t1.user_id and t.seclassify_id=".$classify_id." and t.city like '%".$city."%' AND ".$where.") tb1 left join seclassify tb2 on tb1.seclassify_id=tb2.seclassify_id order by tb1.replycount desc limit ".$startcount.",".$pagecount.""); 

		$result = array($result);
		echo getSuccessJson($result); 
	}

	//获取某一条动态奖金池
	public function bonus(){ 
		$talk_id = $_REQUEST['talk_id']; 
		$model = M();
		$data = $model->query("SELECT (t1.rate_allpay*t.allpay/100) as jiangjinchi FROM talk t,user t1 where t.user_id=t1.user_id AND t.talk_id=".$talk_id.";");
		$data[0]['jiangjinchi']=round($data[0]['jiangjinchi'],2);
		$data = array($data);
		echo getSuccessJson($data); 
	}

	//获取举报的信息
	public function jubao(){
		$talk_id = $_REQUEST['talk_id'];
		$jubao = $_REQUEST['jubao'];
		$model = M();
		$data = $model->execute("UPDATE talk SET `jubao`=".$jubao." WHERE talk_id=".$talk_id.";");
		$this->ajaxReturn(array("code"=>200));
	}
	
	//获取某一条动态分享列表
	public function getShareList(){  
		$talk_id = $_REQUEST['talk_id'];
		$Model = M();
		$page = $_REQUEST["page"];
		$pagecount = $_REQUEST['pagecount'];
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

        
		$startcount = $page*$pagecount;
		$paymoney = $Model->Query("select paymoney from talk where talk_id=".$talk_id."");
		$paymoney = $paymoney[0]['paymoney'];
		$count = $Model->Query("select count(*) as count  from sharetalk where talk_id=".$talk_id."");
		$count = $count[0]['count']; 
		
		$result = $Model->Query("SELECT t1.headimg,t1.name,COUNT(*) AS count FROM sharetalk t,USER t1 WHERE t.talk_id=".$talk_id." AND t1.user_id=t.user_id GROUP BY t.user_id,t.talk_id order by count desc limit ".$startcount.",".$pagecount."");
		for($i=0;$i<sizeof($result);$i++){
			$mycount = $result[$i]['count'];
			$getmoney = ($mycount/$count)*$paymoney;
			$result[$i]['getmoney'] = $getmoney;
		}
		$result = array($result); 
		echo getSuccessJson($result);
	}
	
	//购买话题
	public function buyTalk(){
		$user_id = $_REQUEST['user_id'];
		$talk_id = $_REQUEST['talk_id'];
		$Model = M();
		
		
		$usermoney = $Model->Query("select money from user where user_id=".$user_id."");
		$usermoney = $usermoney[0]['money'];
		$money = $Model->Query("select money from talk where talk_id=".$talk_id."");
		
		
		
		if($usermoney<$money[0]['money']){
			$returnArr = array(
			   "code"=>201,
			   "msg"=>"余额不足"
			);
			echo json_encode($returnArr);
			exit();
		}
		
		$jiangmoney = $money[0]['money']*0.08;
		$Model->execute("update talk set paymoney=paymoney+".$jiangmoney.",allpay=allpay+".$money[0]['money']." where talk_id=".$talk_id."");
		$Model->execute("update user set tingcount=tingcount+1,money=money-".$money[0]['money']." where user_id=".$user_id."");
		$insertArr = array(
		    "a_id"=>$talk_id,
			"user_id"=>$user_id,
			"money"=>$money[0]['money'],
			"type"=>1
		);
		
		myinsert('payrecord',$insertArr);
		$returnArr = array(
		   "code"=>200,
		   "msg"=>"购买成功"
		);
		echo json_encode($returnArr);
	}


	//他的动态
	public function OtherTalkList(){
		$user_id = $_REQUEST['user_id'];
		$page = $_REQUEST["page"];
		$pagecount = $_REQUEST['pagecount'];
		$Model = M();
		
		if($page == null||$page<=0){ 
			$page=0; 
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

		$startcount = $page*$pagecount; 
		
		$result = $Model->Query("select t.*,t1.sumbheadimg as hesumbheadimg,t1.headimg as heheadimg,t1.authentication,t1.workimg,t1.job from talk t,user t1 where t.user_id=t1.user_id and t.user_id=".$user_id." order by t.replycount desc limit ".$startcount.",".$pagecount."");
		
		foreach ($result as $key => $value) {   
			$seclassify = $Model->Query("SELECT name,se_images FROM seclassify WHERE seclassify_id=".$value['seclassify_id'].";");
			$result[$key]['fenlei_name'] = $seclassify[0]['name'];
		} 
		$result = array($result);
		echo getSuccessJson($result);
	}



	/*********************************************/
	//添加和取消关注
	public function addFollow(){
		$user_id = $_REQUEST['user_id'];
		$to_user_id = $_REQUEST['to_user_id'];
		
		$Model = M();
		$count = $Model->Query("select count(*) as count from hb_follow where user_id=".$user_id." and to_user_id=".$to_user_id."");
		$count = $count[0]['count'];
		
		if($count == 0){
			$insertArr = array(
			   "user_id"=>$user_id,
			   "to_user_id"=>$to_user_id
			);
			myinsert('hb_follow',$insertArr);
			$returnArr = array(
			   "code"=>200,
			   "msg"=>"添加关注成功" 
			);
			$Model->execute("update hb_user set fans=fans+1 where user_id=".$to_user_id."");
			$Model->execute("update hb_user set attentions=attentions+1 where user_id=".$user_id."");
		}else{
			del('hb_follow',"user_id=".$user_id." and to_user_id=".$to_user_id."");
			$returnArr = array(
			   "code"=>201,
			   "msg"=>"取消关注成功" 
			);
			$Model->execute("update hb_user set fans=fans-1 where user_id=".$to_user_id."");
			$Model->execute("update hb_user set attentions=attentions-1 where user_id=".$user_id."");
		}
		echo json_encode($returnArr);
	}


	//发布子评论
    public function addPinglun(){  
		$user_id = $_REQUEST['user_id'];
		$content = $_REQUEST['content'];
        $talk_id =$_REQUEST['talk_id'];
		$parent_id =$_REQUEST['parent_id'];
		$level = $_REQUEST['level'];
		
        $Model = M();
		$insertArr = array(  
			"content"=>$content,
			"user_id"=>$user_id,  
			"talk_id"=>$talk_id, 
			"parent_id"=>$parent_id, 
			"level"=>$level
		);
        $Model->execute("update hb_talk set replycount=replycount+1 where talk_id=".$talk_id.";");
        if($level==1){
		   myinsert('hb_subcomment',$insertArr);  
        }else{   
		   myinsert('hb_talkreply',$insertArr);
        }
		$resultArr = array(
		   "code"=>200,
		   "msg"=>"发布成功"
		);
		echo json_encode($resultArr);
		
	}

	//备份
	//获取列表
	// public function getTalkList(){
	// 	$user_id = $_REQUEST['user_id'];
	// 	$page = $_REQUEST["page"];
	// 	$pagecount = $_REQUEST['pagecount'];
	// 	$longitude =$_REQUEST['lon'];
 //    	$latitude = $_REQUEST['lat'];
	// 	$type = $_REQUEST['type'];
	// 	$Model = M();
		
	// 	if($page == null||$page<=0){
	// 		$page=0;
	// 	}

	// 	if($pagecount == null||$pagecount<=0){
	// 		$pagecount=10;
	// 	}

        
	// 	$startcount = $page*$pagecount;
	// 	$where = "";
		
		
	// 	if($type == 0){
	// 	    //获取我关注的
 //            $followlist = $Model->Query("select to_user_id from follow where user_id=".$user_id."");
 //            for($i=0;$i<sizeof($followlist);$i++){
	// 			if($i == 0){
	// 				$where.="t.user_id=".$followlist[$i]['to_user_id']." ";
	// 			}else{
	// 				$where.="or t.user_id=".$followlist[$i]['to_user_id']." ";
	// 			}
	// 		}	
 //            if($where != ""){
	// 			$result = $Model->Query("select t.*,t1.sumbheadimg,t1.headimg from talk t,user t1 where t.user_id=t1.user_id and (".$where.") order by t.replycount desc limit ".$startcount.",".$pagecount."");
	// 		}else{
	// 			$result = array();
	// 		}			
	// 	}else if($type == 1){
	// 		//获取我喜欢的
	// 		$classify = $Model->Query("select classify from user where user_id=".$user_id."");
	// 		$classify = $classify[0]['classify'];
	// 		$classify = explode(',',$classify);
	// 		for($i=0;$i<sizeof($classify);$i++){
	// 			if($i == 0){
	// 				$where.="t.classify_id=".$classify[$i]." ";
	// 			}else{
	// 				$where.="or t.classify_id=".$classify[$i]." ";
	// 			}
	// 		}
	// 		if($where != ""){
	// 			$result = $Model->Query("select t.*,t1.sumbheadimg,t1.headimg from talk t,user t1 where t.user_id=t1.user_id and (".$where.") order by t.replycount desc limit ".$startcount.",".$pagecount."");
	// 		}else{
	// 			$result = array();
	// 		  }
	// 	}else if($type == 2){
	// 		//获取头条
	// 		$result = $Model->Query("select t.*,t1.sumbheadimg,t1.headimg from talk t,user t1 where t.user_id=t1.user_id and t.toutiao=1 order by t.replycount desc limit ".$startcount.",".$pagecount."");
	// 	}else if($type == 3){
	// 		//获取热点
	// 		$result = $Model->Query("select t.*,t1.sumbheadimg,t1.headimg from talk t,user t1 where t.user_id=t1.user_id and t.hot=1 order by t.replycount desc limit ".$startcount.",".$pagecount."");
	// 	}else if($type == 4){
	// 		//获取同城
	// 		$city = $_REQUEST['city'];
	// 		$result = $Model->Query("select t.*,t1.sumbheadimg,t1.headimg from talk t,user t1 where t.user_id=t1.user_id and t.location like '%".$city."%' order by t.replycount desc limit ".$startcount.",".$pagecount."");
	// 	}else if($type == 5){
	// 		$classify_id = $_REQUEST['classify_id'];
	// 		$result = $Model->Query("select t.*,t1.sumbheadimg,t1.headimg from talk t,user t1 where t.user_id=t1.user_id and t.classify_id=".$classify_id." order by t.replycount desc limit ".$startcount.",".$pagecount."");
	// 	}else if($type == 6){
	// 		$to_user_id = $_REQUEST['to_user_id'];
	// 		$result = $Model->Query("select t.*,t1.sumbheadimg,t1.headimg from talk t,user t1 where t.user_id=t1.user_id and t.user_id=".$to_user_id." order by t.replycount desc limit ".$startcount.",".$pagecount."");
	// 	}
		
	// 	$result = array($result);
	// 	echo getSuccessJson($result);
	// }
	
}