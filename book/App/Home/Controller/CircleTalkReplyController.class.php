<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
header("Content-Type:text/html; charset=utf-8");

class CircleTalkReplyController extends Controller {

    //发布子评论
    public function addTalk(){
		$user_id = $_REQUEST['user_id'];
		$content = $_REQUEST['content'];
        $circletalk_id =$_REQUEST['circletalk_id'];
		$parent_id =$_REQUEST['parent_id'];
		$level = $_REQUEST['level'];
		
        $Model = M();
		$insertArr = array(
			"content"=>$content,
			"user_id"=>$user_id,
			"circletalk_id"=>$circletalk_id,
			"parent_id"=>$parent_id,
			"level"=>$level
		);
		$touserid = $Model->Query("select user_id from circletalk where circletalk_id=".$circletalk_id."");
		$touserid = $touserid[0]['user_id'];
		$count = $Model->Query("select count(*) as count from circletalkreply where circletalk_id=".$circletalk_id." and user_id=".$user_id."");
		$count = $count[0]['count'];
		
		if($count==0){
			$Model->execute("update user set talkcore=talkcore+3 where user_id=".$user_id."");
		    $Model->execute("update circle set huoyue=huoyue+0.9 where circle_id=".$circle_id."");
		}
		
		$circletalkreply_id = myinsert('circletalkreply',$insertArr);
		$Model->execute("update circletalk set replycount=replycount+1 where circletalk_id=".$circletalk_id."");
		if($touserid!=$user_id){
			$MsgArr = array(
			   "touserid"=>$touserid,
			   "type"=>0,
			   "circletalk_id"=>$circletalkreply_id
			);
			
			myinsert('message',$MsgArr);
		}
		$resultArr = array(
		   "code"=>200,
		   "msg"=>"发布成功"
		);
		echo json_encode($resultArr);
		
	}
	
    //添加点赞
	public function addLike(){
		$circletalkreply_id = $_REQUEST['circletalkreply_id'];
		$user_id = $_REQUEST['user_id'];
		
		
		
		$insertArr = array(
		   "circletalkreply_id"=>$circletalkreply_id,
		   "user_id"=>$user_id
		);
		
		myinsert('circletalkreplylike',$insertArr);
		$Model = M();
		$Model->execute("update circletalkreply set likenum=likenum+1 where circletalkreply_id=".$circletalkreply_id."");
		$resultArr = array(
		   "code"=>200,
			"msg"=>"点赞成功"
		);
		echo json_encode($resultArr);
		
	}
	
	//获取子评论列表
	public function getReplyList(){
		$circletalk_id =$_REQUEST['circletalk_id'];
		$user_id = $_REQUEST['user_id'];
		
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		

		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

		$Model=M();
		
		$startcount = $page*$pagecount;
		
		$result = $Model->Query("SELECT TIMESTAMPDIFF(SECOND,t.addtime,NOW()) AS `second`,TIMESTAMPDIFF(MINUTE,t.addtime,NOW()) AS MINUTE,TIMESTAMPDIFF(HOUR,t.addtime,NOW()) AS HOUR ,TIMESTAMPDIFF(DAY,t.addtime,NOW()) AS DAY,TIMESTAMPDIFF(WEEK,t.addtime,NOW()) AS WEEK,t.content,t.addtime,t1.images as uimg,t1.name,t.likenum,t.level,t.circletalkreply_id,t.parent_id FROM circletalkreply t,jieqi_system_users t1 WHERE t.user_id=t1.uid AND t.circletalk_id=".$circletalk_id." order by t.addtime desc limit ".$startcount.",".$pagecount."");
		
		for($i=0;$i<sizeof($result);$i++){
			$count = $Model->Query("select count(*) as count from circletalkreplylike where circletalkreply_id=".$result[$i]['circletalkreply_id']." and user_id=".$user_id."");
			$count = $count[0]['count'];
			
			if($count==0){
				$result[$i]['isdian'] = 0;
			}else{
				$result[$i]['isdian'] = 1;
			}
		    $level = $result[$i]['level'];
			if($level==1){
				$obj = $Model->Query("SELECT t.content AS replycontent,t1.name AS replyname FROM circletalkreply t,jieqi_system_users t1 WHERE t.user_id=t1.uid AND t.circletalkreply_id=".$result[$i]['parent_id']."");
				$result[$i]['replycontent'] = $obj[0]['replycontent'];
				$result[$i]['replyname'] = $obj[0]['replyname'];
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
		$list = array($result);

    	echo getSuccessJson($list);
	}
	
	
}