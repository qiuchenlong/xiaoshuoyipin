<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
header("Content-Type:text/html; charset=utf-8");

class MessageController extends Controller {
    
    
    public function getMessage(){
		$user_id = $_REQUEST['user_id'];
		$type = $_REQUEST['type'];
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		
		

		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}
        $startcount = $page*$pagecount;
		$Model=M();
		if($type==3){
		    $result = $Model->Query("SELECT t.circletalk_id,t.message_id,t1.name,t1.images as headimg,t1.images as sumbheadimg,t2.content,t.addtime FROM message t,jieqi_system_users t1,circletalk t2 WHERE t.circletalk_id=t2.circletalk_id AND t2.user_id=t1.user_id AND t.touserid=".$user_id." and t.type=".$type." limit ".$startcount.",".$pagecount."");
		}else if($type == 5||$type==6){
			$result = $Model->Query("select * from notice where type=".$type." limit ".$startcount.",".$pagecount."");
			for($i=0;$i<sizeof($result);$i++){
				$row = $Model->Query("select *,TIMESTAMPDIFF(SECOND,`addtime`,NOW()) AS `second`,TIMESTAMPDIFF(MINUTE,`addtime`,NOW()) as minute,TIMESTAMPDIFF(HOUR,`addtime`,NOW()) as hour ,TIMESTAMPDIFF(DAY,`addtime`,NOW()) as day,TIMESTAMPDIFF(WEEK,`addtime`,NOW()) as week from notice where notice_id=".$result[$i]['notice_id']."");
				// 设置时间样式
				$row = $row[0];
				$addtime = $row['addtime'];
				if ($row['week']>1) {
					$addtime = $row['addtime'];
				}elseif ($row['week'] == 1) {
					$addtime = '1周前';
				}elseif ($row['day'] >0 ) {
					$addtime = $row['day'].'天前';
				}elseif ($row['hour'] >0) {
					$addtime = $row['hour'].'小时前';
				}elseif ($row['minute'] >0) {
					$addtime = $row['minute'].'分钟前';
				}elseif ($row['second'] >0) {
					$addtime = $row['second'].'秒前';
				}
				$row['addtime'] = $addtime;
				$result[$i]['addtime'] = $row['addtime'];
				// 设置时间样式 end
			}
       
		}else if($type == 4){
			$result = $Model->Query("SELECT * FROM notice WHERE user_id=".$user_id." AND type=4 OR TYPE=7");
			for($i=0;$i<sizeof($result);$i++){
				$Date_1=date("Y-m-d H:i:s"); 
	  
			   $Date_2=$result[$i]['begintime']; 
			   
			   $d1=strtotime($Date_1); 
			   $d2=strtotime($Date_2);  
			   
			   
			   if($d1>$d2){
				   $result[$i]['isbegin']=1;
			   }else{
				   $result[$i]['isbegin']=0;
			   }
			}
		}else if($type == 0){
			$result =$Model->Query("SELECT t2.circletalk_id,t1.name,t1.images as headimg,t1.images as sumbheadimg,t2.content,t.addtime,t.message_id FROM message t,jieqi_system_users t1,circletalkreply t2 WHERE t.circletalk_id=t2.circletalkreply_id AND t2.user_id=t1.uid AND t.touserid=".$user_id." AND t.type=0 limit ".$startcount.",".$pagecount."");
		}
		
		$attention = array($result);
		echo getSuccessJson($attention);
	}
	
	//读取信息
	public function ReadMessage(){
		$type = $_REQUEST['type'];
		$oid = $_REQUEST['oid'];
		$user_id = $_REQUEST['user_id'];
		$Model = M();
        if($type==0 || $type==1 || $type==3){
			$Model->execute("update message set isRead=1 where message_id=".$oid."");
		}else if($type==4){
			$Model->execute("update notice set isRead=1 where notice_id=".$oid."");
        }else if($type==5||$type==6){
			$count = $Model->Query("select count(*) as count from noticeread where notice_id=".$oid." and user_id=".$user_id."");
			$count = $count[0]['count'];
			if($count==0){
				$insertArr = array(
				   "user_id"=>$user_id,
				   "notice_id"=>$oid
				);
				myinsert('noticeread',$insertArr);
			}
		}
		
		$resuntArr = array(
		   "code"=>200,
		);
		echo json_encode($resuntArr);
	}
	
	
	//长轮询获取新信息
    public function getNewMsg(){
        $user_id = $_REQUEST['user_id'];
        $oldcount = $_REQUEST['oldcount'];
		$allcount = 0;
        $Model = M();
		$arr = array();

        set_time_limit(0);//无限请求超时时间
        session_write_close();
        $j=0;
        while (true){
            //sleep(1);
            usleep(500000);//0.5秒
            $j++;
			
			$msgcount = $Model->Query("SELECT count(*) AS count FROM message WHERE touserid=".$user_id." AND isRead=0");
			
			$all5count = $Model->Query("SELECT COUNT(*) AS count FROM notice t WHERE t.type=5");
			$type5count = $Model->Query("SELECT COUNT(*) AS count FROM notice t,noticeread t1 WHERE t.type=5 AND t.notice_id=t1.notice_id AND t1.user_id=".$user_id."");
			$notread5 = $all5count[0]['count']-$type5count[0]['count'];
			$all6count = $Model->Query("SELECT COUNT(*) AS count FROM notice t WHERE t.type=6");
			$type6count = $Model->Query("SELECT COUNT(*) AS count FROM notice t,noticeread t1 WHERE t.type=6 AND t.notice_id=t1.notice_id AND t1.user_id=".$user_id."");
			$notread6 = $all6count[0]['count']-$type6count[0]['count'];
			$noticemsgcount = $Model->Query("SELECT count(*) AS count FROM notice WHERE TYPE=4 and user_id=".$user_id." AND isRead=0");
            $usertalkcount = $Model->Query("select count(*) as count from usertalk where touserid=".$user_id." and isRead=0");
			
			$allcount = $msgcount[0]['count']+$notread5+$notread6+$noticemsgcount[0]['count']+$usertalkcount[0]['count'];
			$arr['count'] = $allcount;
			if($allcount!=$oldcount||$allcount==0){
				$resuntArr = array(
				   "code"=>200,
				   "result"=>$arr
				);
                echo json_encode($resuntArr);
                exit();
			}
            
            //服务器($_POST['time']*0.5)秒后告诉客服端无数据
            if($j==$_GET['time']){
                $arr=array('code'=>"201");
                echo json_encode($arr);
                exit();
            }
        }

    }
}