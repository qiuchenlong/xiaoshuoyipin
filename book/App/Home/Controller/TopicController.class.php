<?php
// 本类由系统自动生成，仅供测试用途
namespace Api\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
header("Content-Type:text/html; charset=utf-8");

class TopicController extends Controller {

     //获取所有话题
	 public function getAll(){
		 $Model = M();
		 $circle_id = $_REQUEST['circle_id'];
		 $result = $Model->Query("select * from topic where circle_id=".$circle_id."");
		 $result = array($result);
		 echo getSuccessJson($result);
	 }
	 
	 //创建话题
	 public function createTopic(){ 
		 $circle_id = $_REQUEST['circle_id'];
		 $content = $_REQUEST['content'];
		 $user_id = $_REQUEST['user_id'];
		 
		 $insertArr = array(
		    "user_id"=>$user_id,
			"content"=>$content,
			"circle_id"=>$circle_id
		 );
		 if($_FILES){
		 	$UpFileTool1 = new \Think\UpFileTool('masterimg');
		 	$UpFileTool1->upImage(0.3,'Uploads','Uploads');
		 	$insertArr['masterimg'] = $UpFileTool1->srcImage;
		 	$insertArr['sumbmasterimg'] = $UpFileTool1->sumbImage;
		 	$UpFileTool2 = new \Think\UpFileTool('image');
		 	$UpFileTool2->upImage(0.3,'Uploads','Uploads');
		 	$insertArr['image'] = $UpFileTool2->srcImage;
		 	$insertArr['sumbimage'] = $UpFileTool2->sumbImage;
		 }  
		 $id = myinsert('topic',$insertArr);
		 $returnArr = array(
		    "code"=>200,
			"id"=>$id,
			"msg"=>"创建成功"
		 );
		 
		 echo json_encode($returnArr);
	 }
	 
	 //获取热门话题
	 public function getHotTopic(){
		
		
		$pagecount = $_REQUEST['pagecount'];
		$page = $_REQUEST['page'];
		

		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

		$Model=M();
		
		$startcount = $page*$pagecount;
        $result = $Model->Query("select * from topic order by replycount limit ".$startcount.",".$pagecount."");	
        $result = array($result);
		echo getSuccessJson($result);		
	 }
	 
	 //获取话题详情
	 public function getTopicDetail(){
		 $Model = M();
		 $topic_id = $_REQUEST['topic_id'];
		 $result = $Model->Query("select * from topic where topic_id=".$topic_id."");
		 $result = array($result);
		 echo getSuccessJson($result);		
	 }

}