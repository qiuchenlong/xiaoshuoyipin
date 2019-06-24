<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
header("Content-Type:text/html; charset=utf-8");

class CircleTalkController extends Controller {
	
	//搜索话题或用户
	public function searchHua(){
		$name = $_REQUEST['name'];
		
		$Model = M();
		
		$topiclist = $Model->Query("SELECT *,@num:=1 AS TYPE FROM topic WHERE content LIKE '%".$name."%' ");
		$userlist = $Model->Query("select *,@num:=0 AS TYPE FROM user WHERE name LIKE '%".$name."%' ");
		$result = array_merge($topiclist, $userlist); 
		
		$result = array($result);
		echo getSuccessJson($result);
	}

    //发布圈子
    public function addTalk(){
		$user_id = $_REQUEST['user_id'];
		$content = $_REQUEST['content'];
        $circle_id =$_REQUEST['circle_id'];
		$topic_id =$_REQUEST['topic_id'];
		$lon = $_REQUEST['lon'];
		$lat = $_REQUEST['lat'];
		$tips = $_REQUEST['tips'];
		$location =$_REQUEST['location'];
        $Model = M();

		

		if ($_FILES) {

			$UpFileTool = new \Think\UpFileTool('file');// 实例化上传类
			$UpFileTool->multiImage(0.2,'Uploads', 'Uploads');
			$multiSumbImage = $UpFileTool->multiSumbImage;
			$multiSrcImage = $UpFileTool->multiSrcImage;
			$insertArr = array(
			    "content"=>$content,
				"user_id"=>$user_id,
                "circle_id"=>$circle_id,
				"images"=>$multiSrcImage,
				"sumbimages"=>$multiSumbImage,
				// "topic_id"=>$topic_id,
				// "tips"=>$tips,
				// "longitude"=>$lon,
				// "latitude"=>$lat,
				// "location"=>$location
			);
            $circletalk_id = myinsert('circletalk',$insertArr);
			$resultArr = array(
			   "code"=>200,
				"msg"=>"发布成功"
			);
			echo json_encode($resultArr);
		}else{
			$insertArr = array(
			    "content"=>$content,
				"user_id"=>$user_id,
                "circle_id"=>$circle_id,
				// "topic_id"=>$topic_id,
				// "tips"=>$tips,
				// "longitude"=>$lon,
				// "latitude"=>$lat,
				// "location"=>$location
			);
			
            $circletalk_id = myinsert('circletalk',$insertArr);
			$resultArr = array(
			   "code"=>200,
				"msg"=>"发布成功"
			);
			echo json_encode($resultArr);
		}
		$Model->execute("update user set talkcore=talkcore+5 where user_id=".$user_id."");
		$Model->execute("update circle set replycount=replycount+1 where circle_id=".$circle_id."");
		$Model->execute("update circle set huoyue=huoyue+3 where circle_id=".$circle_id."");
		// $tips = explode(',',$tips);
		// for($i=0;$i<sizeof($tips);$i++){
		// 	$insertArr = array(
		// 	  "circletalk_id"=>$circletalk_id,
		// 	  "touserid"=>$tips[$i],
		// 	  "type"=>1
		// 	);
			
		// 	myinsert('message',$insertArr);
		// }
		
		
	}
	
	//添加话题
	public function addTopic(){
		$user_id = $_REQUEST['user_id'];
		$content = $_REQUEST['content'];
		$circle_id = $_REQUEST['circle_id'];
		
		$insertArr = array(
		   "circle_id"=>$circle_id,
		   "content"=>$content,
		   "user_id"=>$user_id
		);
		
		myinsert('topic',$insertArr);
		$resultArr = array(
		   "code"=>200,
		   "msg"=>"添加成功"
		);
		echo json_encode($resultArr);
		
	}
	
	//获取精选动态
	public function getHotTalk(){
		
        //$myuserid = $_REQUEST['myuserid'];
		$user_id = $_REQUEST['user_id'];
		$page = $_REQUEST["page"];
		$pagecount = $_REQUEST['pagecount'];
		$longitude =$_REQUEST['lon'];
    	$latitude = $_REQUEST['lat'];
		
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}


		$startcount = $page*$pagecount;


		
		$Model = M();
		
	 
		
		$result = $Model->Query("SELECT ROUND((SQRT(POWER(MOD(ABS(t.longitude - '".$longitude."'),360),2) + POWER(ABS(t.latitude - '".$latitude."'),2))*160),2) AS distance,TIMESTAMPDIFF(SECOND,t.addtime,NOW()) AS `second`,TIMESTAMPDIFF(MINUTE,t.addtime,NOW()) AS MINUTE,TIMESTAMPDIFF(HOUR,t.addtime,NOW()) AS HOUR ,TIMESTAMPDIFF(DAY,t.addtime,NOW()) AS DAY,TIMESTAMPDIFF(WEEK,t.addtime,NOW()) AS WEEK,t.longitude,t.user_id,t.latitude,t1.name,t1.user_id,t1.headimg,t1.sumbheadimg,t.circletalk_id,t.sumbimages,t.images,t.content,t.location,t.addtime,t.likenum,t.replycount,t.location,t.topic_id FROM circletalk t,USER t1 WHERE  t.user_id=t1.user_id order by t.likenum desc  limit ".$startcount.",10");
		
		for($i=0;$i<sizeof($result);$i++){
            $count = $Model->Query("select count(*) as count from circletalklike where circletalk_id=".$result[$i]['circletalk_id']." and user_id=".$user_id."");
            $count = $count[0]['count'];
			$topic_id = $result[$i]['topic_id'];
            if($count == 0){
            	$result[$i]['isdan'] = 0;
            }else{
            	$result[$i]['isdan'] = 1;
            }
			
			$count = $Model->Query("select count(*) as count from friend where user_id=".$user_id." and touserid=".$result[$i]['user_id']."");
			$count = $count[0]['count'];
			
			if($count==0){
				$result[$i]['guan']=0;
			}else{
				$result[$i]['guan']=1;
			}
			
			if($topic_id!=""){
				$topicname = $Model->Query("select content from topic where topic_id=".$result[$i]['topic_id']."");
				$result[$i]['topicname'] = $topicname[0]['content'];
			}
		
            // 设置时间样式
            $row = $result[$i];
            $addtime = $row['addtime'];
			if ($row['WEEK']>1) {
                $addtime = $row['addtime'];
            }elseif ($row['WEEK'] == 1) {
                $addtime = '1周前';
            }elseif ($row['DAY'] >0 ) {
                $addtime = $row['DAY'].'天前';
            }elseif ($row['HOUR'] >0) {
                $addtime = $row['HOUR'].'小时前';
            }elseif ($row['MINUTE'] >0) {
                $addtime = $row['MINUTE'].'分钟前';
            }elseif ($row['SECOND'] >0) {
                $addtime = $row['SECOND'].'秒前';
            }
			 
			$result[$i]['addtime'] = $addtime;
        }

		$result = array($result);
		echo getSuccessJson($result);
	}
	
	//获取我感兴趣的圈子
	public function getMyLuckTalk(){
		
		
		$user_id = $_REQUEST['user_id'];
		$page = $_REQUEST["page"];
		$pagecount = $_REQUEST['pagecount'];
		$longitude =$_REQUEST['lon'];
    	$latitude = $_REQUEST['lat'];
		
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}


		$startcount = $page*$pagecount;
		$Model = M();
		
		$classify = $Model->Query("select classify from user where user_id=".$user_id."");
		
		$classify = explode(',',$classify[0]['classify']);
		$where = "";
		for($i=0;$i<sizeof($classify);$i++){
			if($i==0){
			   $where.=" and t2.classify_id=".$classify[$i]." ";
			}else{
			   $where.="or t2.classify_id=".$classify[$i]." ";
			}
		}
	    
		$result = $Model->Query("SELECT ROUND((SQRT(POWER(MOD(ABS(t.longitude - '".$longitude."'),360),2) + POWER(ABS(t.latitude - '".$latitude."'),2))*160),2) AS distance,TIMESTAMPDIFF(SECOND,t.addtime,NOW()) AS `second`,TIMESTAMPDIFF(MINUTE,t.addtime,NOW()) AS MINUTE,TIMESTAMPDIFF(HOUR,t.addtime,NOW()) AS HOUR ,TIMESTAMPDIFF(DAY,t.addtime,NOW()) AS DAY,TIMESTAMPDIFF(WEEK,t.addtime,NOW()) AS WEEK,t.longitude,t.latitude,t1.name,t1.user_id,t1.headimg,t1.sumbheadimg,t.circletalk_id,t.sumbimages,t.images,t.content,t.location,t.addtime,t.likenum,t.replycount,t.location,t.topic_id FROM circletalk t,USER t1,circle t2 WHERE t.circle_id=t2.circle_id  and  t.user_id=t1.user_id    limit ".$startcount.",10");
		
		for($i=0;$i<sizeof($result);$i++){
            $count = $Model->Query("select count(*) as count from circletalklike where circletalk_id=".$result[$i]['circletalk_id']." and user_id=".$user_id."");
            $count = $count[0]['count'];
			$topic_id = $result[$i]['topic_id'];
            if($count == 0){
            	$result[$i]['isdan'] = 0;
            }else{
            	$result[$i]['isdan'] = 1;
            }
			
			if($topic_id!=""){
				$topicname = $Model->Query("select content from topic where topic_id=".$result[$i]['topic_id']."");
				$result[$i]['topicname'] = $topicname[0]['content'];
			}
		
            // 设置时间样式
            $row = $result[$i];
            $addtime = $row['addtime'];
			if ($row['WEEK']>1) {
                $addtime = $row['addtime'];
            }elseif ($row['WEEK'] == 1) {
                $addtime = '1周前';
            }elseif ($row['DAY'] >0 ) {
                $addtime = $row['DAY'].'天前';
            }elseif ($row['HOUR'] >0) {
                $addtime = $row['HOUR'].'小时前';
            }elseif ($row['MINUTE'] >0) {
                $addtime = $row['MINUTE'].'分钟前';
            }elseif ($row['SECOND'] >0) {
                $addtime = $row['SECOND'].'秒前';
            }
			 
			$result[$i]['addtime'] = $addtime;
        }

		$result = array($result);
		echo getSuccessJson($result);
	}
	
	//获取圈子话题
	public function getCircleTalk(){
		$circle_id = $_REQUEST['circle_id'];
		$topic_id = $_REQUEST['topic_id'];
		$myuserid = $_REQUEST['user_id'];
		$to_user_id = $_REQUEST['to_user_id'];
		
        
		$page = $_REQUEST["page"];
		$pagecount = $_REQUEST['pagecount'];
		
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}


		$startcount = $page*$pagecount;


		
		$Model = M();
		
	    $where = "";
		if($circle_id != null){
			$where.="t.circle_id=".$circle_id." and ";
		}
		if($topic_id != null){
			$where.="t.topic_id=".$topic_id." and ";
		}
		if($to_user_id != null){
			$where.="t.user_id=".$to_user_id." and ";
		}
		
		$result = $Model->Query("SELECT * FROM circletalk  WHERE circle_id=".$circle_id." order by circletalk_id desc limit $startcount,$pagecount ");
		foreach ($result as $key => $value) {
		
		$user = $Model->Query("SELECT * FROM jieqi_system_users  WHERE uid='".$value['user_id']."';");
		$result[$key]['name']=$user[0]['name'];
		$result[$key]['uimg']=$user[0]['images'];
		    }

		for($i=0;$i<sizeof($result);$i++){
            $count = $Model->Query("select count(*) as count from circletalklike where circletalk_id=".$result[$i]['circletalk_id']." and user_id=".$myuserid."");
            $count = $count[0]['count'];
			$topic_id = $result[$i]['topic_id'];
            if($count == 0){
            	$result[$i]['isdan'] = 0;
            }else{
            	$result[$i]['isdan'] = 1;
            }
			
			if($topic_id!=""){
				$topicname = $Model->Query("select content from topic where topic_id=".$result[$i]['topic_id']."");
				$result[$i]['topicname'] = $topicname[0]['content'];
			}
		
            // 设置时间样式
            $row = $result[$i];
            $addtime = $row['addtime'];
			if ($row['WEEK']>1) {
                $addtime = $row['addtime'];
            }elseif ($row['WEEK'] == 1) {
                $addtime = '1周前';
            }elseif ($row['DAY'] >0 ) {
                $addtime = $row['DAY'].'天前';
            }elseif ($row['HOUR'] >0) {
                $addtime = $row['HOUR'].'小时前';
            }elseif ($row['MINUTE'] >0) {
                $addtime = $row['MINUTE'].'分钟前';
            }elseif ($row['SECOND'] >0) {
                $addtime = $row['SECOND'].'秒前';
            }
			 
			$result[$i]['addtime'] = $addtime;
        }

		$result = array($result);
		echo getSuccessJson($result);
		
	}
	
	//添加点赞
	public function addLike(){
		$user_id = $_REQUEST['user_id'];
		$circletalk_id = $_REQUEST['circletalk_id'];
		$Model = M();
		$insertArr = array(
		   "user_id"=>$user_id,
		   "circletalk_id"=>$circletalk_id
		);
		$user = $Model->Query("select user_id,circle_id from circletalk where circletalk_id=".$circletalk_id."");
		$user_id = $user[0]['user_id'];
		$circle_id = $user[0]['circle_id'];
		myinsert('circletalklike',$insertArr);
		
		$insertMsg = array(
		   "touserid"=>$user_id,
		   "type"=>3,
		   "circletalk_id"=>$circletalk_id
		);
		myinsert('message',$insertMsg);
		$Model->execute("update circletalk set likenum=likenum+1 where circletalk_id=".$circletalk_id."");
		$Model->execute("update user set talkcore=talkcore+2 where user_id=".$user_id."");
		$Model->execute("update circle set huoyue=huoyue+0.6 where circle_id=".$circle_id."");
		$resultArr = array(
		   "code"=>200,
		   "msg"=>"添加成功"
		);
		echo json_encode($resultArr);
	}
	
	//删除评论
	public function delTalk(){
		$circletalk_id = $_REQUEST['circletalk_id'];
		del('circletalk',"circletalk_id=".$circletalk_id."");
		$resultArr = array(
		   "code"=>200,
		   "msg"=>"删除成功"
		);
		echo json_encode($resultArr);
	}
	
	public function likeList(){
		$page = $_REQUEST["page"];
		$pagecount = $_REQUEST['pagecount'];
		$circletalk_id = $_REQUEST['circletalk_id'];
		$Model = M();
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

      
		$startcount = $page*$pagecount;
		$likelist = $Model->Query("SELECT t1.sumbheadimg,t1.headimg,t1.name,t.addtime,t.user_id FROM circletalklike t,USER t1 WHERE t.circletalk_id=".$circletalk_id." AND t.user_id=t1.user_id limit ".$startcount.",".$pagecount."");
		$result = array($likelist);
		echo getSuccessJson($result);
	}
	
	//获取话题详情
	public function getTalkDetail(){
		$circletalk_id = $_REQUEST['circletalk_id'];
		$user_id = $_REQUEST['user_id'];
		$Model = M();
		
		
		
		$obj = $Model->Query("SELECT * FROM circletalk  WHERE circletalk_id='".$circletalk_id."';");

		$user = $Model->Query("SELECT * FROM jieqi_system_users  WHERE uid='".$obj[0]['user_id']."';");
		$obj[0]['name']=$user[0]['name'];
		$obj[0]['uimg']=$user[0]['images'];
		$likelist = $Model->Query("SELECT t1.images,t.user_id FROM circletalklike t,jieqi_system_users t1 WHERE t.circletalk_id=".$circletalk_id." AND t.user_id=t1.uid limit 0,15");
		
		// $count = $Model->Query("select count(*) as count from friend where user_id=".$user_id." and touserid=".$obj[0]['user_id']."");
		// $count = $count[0]['count'];
		// if($count==0){
		// 	$obj[0]['guan']=0;
		// }else{
		// 	$obj[0]['guan']=1;
		// }
		
		$count = $Model->Query("select count(*) as count from circletalklike where circletalk_id=".$obj[0]['circletalk_id']." and user_id=".$user_id."");
		$count = $count[0]['count'];
		
		if($count == 0){
			$obj[0]['isdan'] = 0;
		}else{
			$obj[0]['isdan'] = 1;
		}
		$returnArr = array(
		   "code"=>200,
		   "likelist"=>$likelist,
		   "obj"=>$obj[0]
		);
		
		echo json_encode($returnArr);
	}
	

	
	
}