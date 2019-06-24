<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
include_once("UpFileTool.class.php");
header("Content-Type:text/html; charset=utf-8");
class UserTalkController extends Controller {
    
    //获取信息列表
	public function getOtherList(){
		$userid = $_REQUEST['user_id'];//接收信息用户
		$oldcount = $_REQUEST['count'];
		$allcount = 0;
		$Model = M();
		
        set_time_limit(0);//无限请求超时时间 
        session_write_close();
        $j=0;
        while (true){ 
            //sleep(1);
            usleep(500000);//0.5秒 
            $j++;  
            $result = $Model->Query("(SELECT userid,MAX(id) AS id FROM hb_usertalk WHERE touserid=".$userid."  GROUP BY userid ) UNION (SELECT touserid,MAX(id) AS id FROM hb_usertalk WHERE userid=".$userid."  GROUP BY touserid) ");
			
			$result = assoc_unique($result,'userid');
			
			for($i=0;$i<sizeof($result);$i++){
				$usertalk = $Model->Query("select * from hb_usertalk where id=".$result[$i]['id']."");
				
				$user = $Model->Query("select * from hb_user where user_id=".$result[$i]['userid']."");
				$count = $Model->Query("SELECT COUNT(*) AS count FROM hb_usertalk WHERE ((userid=".$usertalk[0]['userid']." AND touserid=".$usertalk[0]['touserid'].") OR (userid=".$usertalk[0]['touserid']." AND touserid=".$usertalk[0]['userid'].")) AND touserid=".$userid." and isRead=0");
				$result[$i]['content'] = $usertalk[0]['content'];
				$result[$i]['touserid'] = $result[$i]['userid'];
				$result[$i]['addtime'] = $usertalk[0]['addtime'];
				$result[$i]['name'] = $user[0]['name']; 
				$result[$i]['sumbheadimg'] = $user[0]['sumbheadimg'];
				$result[$i]['count'] = $count[0]['count'];
				//$allcount+=$count[0]['count'];
				$arr = array("png","jpg","jpeg");
				$last = extend_1($result[$i]['content']);
				if(in_array($last, $arr)){
					$result[$i]['content'] = "[图片]"; 
				}
				$arr = array("amr"); 
				//$last = extend_1($result[$i]['content']);
				if(in_array($last, $arr)){
					$result[$i]['content'] = "[语音]"; 
				}
			}
			$result = $this->bubbleSort($result);
			$allcount = $Model->Query("select count(*) as count from hb_usertalk where touserid=".$userid." and isRead=0");
			$allcount = $allcount[0]['count'];
			$arr = array();
			$arr['list']=$result;
			$arr['count']=$allcount;
			if($oldcount != $allcount){
				$resultArr = array(
				   "code"=>200,
				   "result"=>$arr,
				   
				); 
				echo json_encode($resultArr);  
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

		public function bubbleSort($arr)
	{  
	  $len=count($arr);
	  //该层循环控制 需要冒泡的轮数
	  for($i=1;$i<$len;$i++)
	  { //该层循环用来控制每轮 冒出一个数 需要比较的次数
		for($k=0;$k<$len-$i;$k++)
		{
		   if($arr[$k]['addtime']<=$arr[$k+1]['addtime'])
			{
				$tmp=$arr[$k+1];
				$arr[$k+1]=$arr[$k];
				$arr[$k]=$tmp;
			}
		}
	  }
	  return $arr;
	}



    //获取开始的20条信息
	public function getMsgList(){
		$userid = $_REQUEST['userid']; 
		$touserid = $_REQUEST['touserid'];
        $Model = M();
        $page = $_POST['page'];

		$count = $Model->Query("select count(*) as count from hb_usertalk where ((userid=".$userid." and touserid=".$touserid.") or (userid=".$touserid." and touserid=".$userid."))");
		$count = (int)$count[0]['count']; 

		if($page == null||$page<0){
			$page=0;
		} 
        $allpage = floor($count/20);
		$newpage = $allpage-$page;
		if($newpage<0){ 
			$returnArr = array(
			   "code"=>201,
				"msg"=>"没有更多数据" 
			);
			echo json_encode($returnArr);
			exit();
		}
		if($newpage == 0){
			$startcount = 0;
			$pagecount  = $count-$page*20;
		}else{
			$mypage = $page+1;
            $startcount =  $count-$mypage*20;
			$pagecount = 20;
		}
		$lastTime = "";
		$result = $Model->Query("select t1.headimg as pic_headimg,t1.name,t.content,t.second,t.id,t.type,t.userid from hb_usertalk t,hb_user t1 where t1.user_id=t.userid and ((t.userid=".$userid." and t.touserid=".$touserid.") or (t.userid=".$touserid." and t.touserid=".$userid.")) order by t.addtime ASC limit ".$startcount.",".$pagecount." ");
		for($i=sizeof($result)-1;$i>=0;$i--){
			if($userid == $result[$i]['userid']){
				$result[$i]['self'] = 1;//1就是自己靠右边
			}else{
				$result[$i]['self'] = 0;//0是别人靠左边显示
			} 

			$result[$i]['showtime'] = false;

			$row = $Model->Query("select *,TIMESTAMPDIFF(SECOND,`addtime`,NOW()) AS `second`,TIMESTAMPDIFF(MINUTE,`addtime`,NOW()) as minute,TIMESTAMPDIFF(HOUR,`addtime`,NOW()) as hour ,TIMESTAMPDIFF(DAY,`addtime`,NOW()) as day,TIMESTAMPDIFF(WEEK,`addtime`,NOW()) as week from hb_usertalk where id=".$result[$i]['id']."");


			// 设置时间样式
			$row = $row[0];
			$addtime = $row['addtime'];
			$smalltime = explode(" ",$addtime);
			$smalltime = $smalltime[1];
			$second=floor(strtotime($lastTime)-strtotime($addtime));

			$result[$i]['addtime'] = $second;
			if($second>300){
				$result[$i]['showtime'] = true;
			}else{
				$result[$i]['showtime'] = false;
			}
			$lastTime = $row['addtime'];
			if ($row['week']>1) {
				$addtime = $row['addtime'];
			}elseif ($row['week'] == 1) {
				$addtime = '1周前';
			}elseif ($row['day'] >0 ) {
				$addtime = $row['day'].'天前';
			}elseif ($row['hour'] >0) {
				$addtime = "今天"." ".$smalltime;
			}elseif ($row['minute'] >0) {
				$addtime = $row['minute'].'分钟前';
			}elseif ($row['second'] >0) {
				$addtime = $row['second'].'秒前';
			}
			$row['addtime'] = $addtime;
			$result[$i]['time'] = $row['addtime'];
			// 设置时间样式 end
		}


		$result = array($result);
        echo getSuccessJson($result);
	}

    
    //添加用户聊天信息
    public function addTalk(){ 
    	$userid = $_REQUEST['userid'];
    	$touserid = $_REQUEST['touserid'];
    	$type = $_REQUEST['type'];
    	$second = $_REQUEST['second'];
    	
    	if($type == 0){
    		$content = $_REQUEST['content'];
    		$insertArr = array(
    		   "userid"=>$userid,
    		   "touserid"=>$touserid,
    		   "type"=>$type,
    		   "content"=>$content
    		);
    		myinsert('hb_usertalk',$insertArr);
    		echo '{"code":"200","msg":"插入成功"}';
    	}else if($type == 1){
    		if ($_FILES) {
				$UpFileTool = new \Think\UpFileTool('file');
				$UpFileTool->upImage($pro=0.3,$sumbimage='Uploads',$srcimage='Uploads');
				$images=$UpFileTool->sumbImage;
				$insertArr = array(
	    		   "userid"=>$userid,
	    		   "touserid"=>$touserid,        
	    		   "type"=>$type,
	    		   "content"=>$images
	    		);
				myinsert('hb_usertalk',$insertArr);
				echo '{"code":"200","msg":"插入成功"}'; 
			}
    	}else if($type == 2){  
			if($_FILES){
				$UpFileTool = new \Think\UpFileTool('file');
				$UpFileTool->upFile($srcimage='Uploads');
				$sound=$UpFileTool->srcImage;
				$insertArr = array(
						"userid"=>$userid,
						"touserid"=>$touserid,
						"type"=>$type,
						"second"=>$second,
						"content"=>$sound
				);
				myinsert('hb_usertalk',$insertArr);
				echo '{"code":"200","msg":"插入成功"}';
			}
		}
    }
    
    //长轮询获取新信息
    public function getNewMsg(){
    	$userid = $_GET['userid'];
    	$Model = M(); 
    	
		set_time_limit(0);//无限请求超时时间  
		session_write_close();
		$j=0;  
		while (true){  
			//sleep(1);  
			usleep(500000);//0.5秒  
			$j++;  
			$result = $Model->Query("SELECT t1.headimg as pic_headimg,t1.name,t.content,t.id,t.type FROM hb_usertalk t,hb_USER t1 WHERE t.touserid=".$userid." AND t.isRead=0 AND t.userid=t1.user_id ORDER BY t.addtime");
			
			if(sizeof($result)>0){
				for($i=0;$i<sizeof($result);$i++){
					if($userid == $result[$i]['userid']){
						$result[$i]['self'] = 1;
					}else{
						$result[$i]['self'] = 0;
					}
					$updatearr = array(  
					   "isRead"=>1 
					);
					update('hb_usertalk',$updatearr,"id=".$result[$i]['id']."");
					
				}
				$result = array($result);
				echo getSuccessJson($result); 
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