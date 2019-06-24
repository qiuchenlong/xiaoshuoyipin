<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
header("Content-Type:text/html; charset=utf-8");

class CircleController extends Controller {

	public function addCircle(){ 
		$post = I('param.','','trim');
		if(sizeof($post)===0){
			echo json_encode(array('code'=>201,'msg'=>'请检查参数'));
			exit;
		} 
		// var_dump();die;
		$UpFileTool1 = new \Think\UpFileTool('masterimg');// 实例化上传类
        $UpFileTool1->upImage(0.3,'Uploads','Uploads');
        $post['masterimg']=$UpFileTool1->srcImage; 
        $post['sumbmasterimg'] = $UpFileTool1->sumbImage;
        $UpFileTool = new \Think\UpFileTool('images');// 实例化上传类
        $UpFileTool->upImage(0.3,'Uploads','Uploads');
        // var_dump($UpFileTool);  
        // die; 
        $post['images'] = $UpFileTool->srcImage; 
        $post['sumbimages'] = $UpFileTool->sumbImage;
        $Model = M('circle');
        if($Model->add($post)){ 
        	$result = array('code'=>200,'msg'=>'添加圈子成功');
        }else{
        	$result = array('code'=>201,'msg'=>'添加圈子失败');
        }
        $this->ajaxReturn($result); 
	} 

     //获取圈子详情
    public function getDetail(){
       $user_id = $_REQUEST['user_id'];
	   $circle_id = $_REQUEST['circle_id'];
	   $Model = M();
	   $count = $Model->Query("SELECT COUNT(*) AS count FROM circlesignup WHERE  TO_DAYS(NOW()) - TO_DAYS(addtime)=0 and user_id=".$user_id." and circle_id=".$circle_id."");
	   $gcount = $Model->Query("select count(*) as count from circlefollow where user_id=".$user_id." and circle_id=".$circle_id."");
	   
	   $qiancount = $Model->Query("SELECT COUNT(*) AS count FROM circlesignup WHERE  TIMESTAMPDIFF(DAY,ADDTIME,NOW())=0");
	   $count = $count[0]['count'];
	   $gcount = $gcount[0]['count'];
	   
	  //   $mcount = $Model->Query("select count(*) as count,money from redpackrecord where user_id=".$user_id." and circle_id=".$circle_id."");
		 // $hcount = $mcount[0]['count'];
		
		 // $isqiang = 0;
		 // $money=0;
		 // if($hcount > 0){
			//  $isqiang=1;
			//  $money = $mcount[0]['money'];
		 // }
	   
	   
	   $qiancount = $qiancount[0]['count'];
	   if($count>0){
		   $issign = 1;
	   }else{
		   $issign = 0;
	   }
	   
	   if($gcount>0){
		   $attention = 1;
	   }else{
		   $attention = 0;
	   }
	   
	   $result = $Model->Query("select * from circle where circle_id=".$circle_id."");
	   $result[0]['issign'] = $issign;
	   $result[0]['qiancount'] = $qiancount;
	   $result[0]['attention'] = $attention;
	   
	   $Date_1=date("Y-m-d H:i:s"); 
	  
	   $Date_2=$result[0]['begintime']; 
	   
	   $d1=strtotime($Date_1); 
	   $d2=strtotime($Date_2);  
	   
	   
	   if($d1>$d2){
		   $result[0]['isbegin']=1;
	   }else{
		   $result[0]['isbegin']=0;
	   }
	   
	   $qianlist = $Model->Query("SELECT t1.images as sumbheadimg,t1.uid  FROM circlesignup t,jieqi_system_users t1 WHERE  TO_DAYS(NOW()) - TO_DAYS(t.addtime)=0 AND t.user_id=t1.uid and t.circle_id=".$circle_id." LIMIT 0,15");
	   
	   $returnArr = array(
	      "code"=>200,
		  "qianlist"=>$qianlist,
		  "obj"=>$result[0],
		  "isqiang"=>$isqiang,
		  "moeny"=>$money
	   );
	   
	   echo json_encode($returnArr);
    }
	
	//我感兴趣的圈子
	public function MyGanCircle(){
		$Model =M();
		
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		$user_id = $_REQUEST['user_id'];
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=6;
		}

		$startcount = $page*$pagecount;
		
		$result = $Model->Query("select * from circle  limit ".$startcount.",".$pagecount."");
		
		for($i=0;$i<sizeof($result);$i++){
			$count = $Model->Query("select count(*) as count from circlefollow where circle_id=".$result[$i]['circle_id']." and user_id=".$user_id."");
			$count = $count[0]['count'];
			
			if($count==0){
				$result[$i]['guan'] = 0;
			}else{
				$result[$i]['guan'] = 1;
			}
		}
		
		$list = array($result);
		echo getSuccessJson($list);
	}
	
		//我感兴趣的圈子
	public function getAllCircle(){
		$Model =M();
		
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		$user_id = $_REQUEST['user_id'];
		$fenid = $_REQUEST['classify_id'];
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=6;
		}

		$startcount = $page*$pagecount;
		
		$result = $Model->Query("select * from circle where classify_id=$fenid  limit ".$startcount.",".$pagecount."");
		
		for($i=0;$i<sizeof($result);$i++){
			$count = $Model->Query("select count(*) as count from circlefollow where circle_id=".$result[$i]['circle_id']." and user_id=".$user_id."");
			$count = $count[0]['count'];
			
			if($count==0){
				$result[$i]['guan'] = 0;
			}else{
				$result[$i]['guan'] = 1;
			}
		}
		
		$list = array($result);
		echo getSuccessJson($list);
	}
	
	//签到列表
	public function getQianList(){
		$circle_id = $_REQUEST['circle_id'];
		$Model =M();
		
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

		$startcount = $page*$pagecount;
		
		$list = $Model->Query("select t1.sumbheadimg,t1.headimg,t1.name,t1.user_id,t.addtime from  circlesignup t,user t1 where TO_DAYS(NOW()) - TO_DAYS(t.addtime)=0 AND t.user_id=t1.user_id and t.circle_id=".$circle_id." limit ".$startcount.",".$pagecount."");
		$list = array($list);
		echo getSuccessJson($list);
	}

    //关注圈子
	public function addGuan(){
		$circle_id = $_REQUEST['circle_id'];
		$user_id = $_REQUEST['user_id'];
		$Model =M();
		
		$insertArr = array(
		   "circle_id"=>$circle_id,
		   "user_id"=>$user_id
		);
		
		$count = $Model->Query("select count(*) as count from circlefollow where circle_id=".$circle_id." and user_id=".$user_id."");
		$count = $count[0]['count'];
		
		if($count>0){
			$returnArr = array(
			   "code"=>201,
			   "msg"=>"关注成功"
			);
			
			echo json_encode($returnArr);
			exit();
		}
		
		myinsert('circlefollow',$insertArr);
		$Model->execute("update circle set membercount=membercount+1 where circle_id=".$circle_id."");
		$returnArr = array(
		   "code"=>200,
		   "msg"=>"关注成功"
		);
		
		echo json_encode($returnArr);
	}
	
	//取消关注
	public function delGuan(){
		$circle_id = $_REQUEST['circle_id'];
		$user_id = $_REQUEST['user_id'];
		$Model =M();
		
		del('circlefollow',"circle_id=".$circle_id." and user_id=".$user_id."");
		$Model->execute("update circle set membercount=membercount-1 where circle_id=".$circle_id."");
		$returnArr = array(
		   "code"=>200,
		   "msg"=>"关注成功"
		);
		
		echo json_encode($returnArr);
	}
	
	//圈子列表
	public function getCircleMemberList(){
		$circle_id = $_REQUEST['circle_id'];
		$Model =M();
		
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

		$startcount = $page*$pagecount;
		
		$list = $Model->Query("SELECT t1.sumbheadimg,t1.name,t.addtime,t1.user_id FROM circlefollow t,USER t1 WHERE t1.user_id=t.user_id AND t.circle_id=".$circle_id." limit ".$startcount.",".$pagecount."");
		$list = array($list);
		echo getSuccessJson($list);
	}
	
	//圈子签到
	public function signup(){
		$Model = M();
		
		$core = 10;
		$user_id = $_REQUEST['user_id'];
		$circle_id = $_REQUEST['circle_id'];
		$result = $Model->Query("SELECT TO_DAYS(NOW()) - TO_DAYS(t.addtime) AS day FROM circlesignup t WHERE  TO_DAYS(NOW()) - TO_DAYS(t.addtime)=0 and t.circle_id=".$circle_id." and t.user_id=".$user_id." ORDER BY day");
		$isqian = false;
		for($i=0;$i<sizeof($result);$i++){
			$diff = $result[$i]['day'];
			if($diff==0){
				$isqian=true;
				break;
			}else if($diff==1){
				$core=12;
			}else if($diff==2){
				if($core==12){
					$core=13;
					break;
				}
			}
		}
		
		if($isqian){
			$returnArr = array(
			   "code"=>201,
			   "msg"=>"已经签到过了"
			);
			
			echo json_encode($returnArr);
			exit();
		}
		$insertArr = array(
		    "user_id"=>$user_id,
			"circle_id"=>$circle_id
		);
		myinsert('circlesignup',$insertArr);
		$huoyue = $core*0.2;
		$Model->execute("update user set signcore=signcore+".$core." where user_id=".$user_id."");
		$Model->execute("update circle set huoyue=huoyue+".$huoyue." where circle_id=".$circle_id."");
		$returnArr = array(
		   "code"=>200,
		   "msg"=>"签到成功"
		);
		echo json_encode($returnArr);
	}
	
	//热门圈子
	public function getHot(){
		// $returnArr = array();
		// $myresult = array();
		// $myresult['code'] = 200;
		// $obj = array();
		// $obj['name']="推荐";
		// $obj['classify_id']="28";
		$Model=M();
			$list = $Model->Query("SELECT * FROM circle ");
		$list = array($list);
		echo getSuccessJson($list);
	}
	
		//热门圈子
	public function searchCircle(){
				$name = $_REQUEST['name'];
		$Model =M();
		
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

		$startcount = $page*$pagecount;
		
		$list = $Model->Query("SELECT * FROM circle  WHERE name like '%".$name."%' limit ".$startcount.",".$pagecount."");
		$list = array($list);
		echo getSuccessJson($list);
	}
	
	
	//获取同城
	public function getFuJin(){
		$Model = M();
    	$userid = $_REQUEST['user_id'];
    	$longitude =$_REQUEST['lon'];
    	$latitude = $_REQUEST['lat'];
		
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		
		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

		$startcount = $page*$pagecount;
		
    	
    	$result = $Model->Query("select ROUND((SQRT(POWER(MOD(ABS(lon - ".$longitude."),360),2) + POWER(ABS(lat - ".$latitude."),2))*160),3) AS distance,name,sex,headimg,sumbheadimg,user_id from user where user_id!=".$userid." order by distance limit ".$startcount.",".$pagecount."");
    	
    	$fulist = array();
    	for($i=0;$i<sizeof($result);$i++){
    		$distance = $result[$i]['distance'];
    		if($distance){
    			if($distance<=1){
    				$distance = $distance*1000;
    				$distance = $distance."米以内";
    			}else{
    				$distance = $distance."千米以内";
    			}
    			$result[$i]['distance'] = $distance;
    			array_push($fulist,$result[$i]);
    		}
    	}
    	$fulist = array($fulist);
    	echo getSuccessJson($fulist);
	}
	
	//我的圈子
	public function getMyCircle(){
		$user_id = $_REQUEST['user_id'];
		
		$Model = M();
		$user = $Model->Query("SELECT headimg,sumbheadimg,name FROM USER  WHERE user_id=".$user_id." ");
		$list = $Model->Query("SELECT t1.name,t1.masterimg,t1.sumbmasterimg,t1.membercount,t1.circle_id FROM circlefollow t,circle t1 WHERE t.user_id=".$user_id." AND t.circle_id=t1.circle_id");
		
		$returnArr = array(
		    "code"=>200,
			"list"=>$list,
			"user"=>$user[0]
		);
		
		echo json_encode($returnArr);
	}
	
	public function getAllCore(){
		$Model = M();
		$type = $_REQUEST['type'];
		
		if($type == 0){
			$core = $Model->Query("select sum(core) as allcore from core");
			$core = $core[0]['allcore'];
			
			$returnArr = array(
			   "code"=>200,
			   "core"=>$core
			);
		}else{
			$core = $Model->Query("select sum(huoyue) as allcore from circle");
			$core = (int)$core[0]['allcore'];
			
			$returnArr = array(
			   "code"=>200,
			   "core"=>$core
			);
		}
		
		echo json_encode($returnArr);
	}
	
	//获取圈子最高详情
	public function getCircleTophy(){
		$user_id = $_REQUEST['user_id'];
		$Model = M();
		
		$circle_id = $Model->Query("SELECT t.circle_id FROM circlefollow t,circle t1 WHERE t.user_id=".$user_id." ORDER BY t1.huoyue");
		
		if(sizeof($circle_id)==0){
			
			$retrunArr = array(
				   "code"=>201,
				   "Obj"=>"没有关注"
				);
				
				echo json_encode($retrunArr);
				exit();
		}
		$circle_id = $circle_id[0]['circle_id'];
		
		
		
		$result = $Model->Query("SELECT
						obj_new.circle_id,
						obj_new.huoyue,
						obj_new.rownum,
						obj_new.name,
						obj_new.masterimg,
						obj_new.sumbmasterimg
					FROM
						(
							SELECT
								obj.circle_id,
								obj.huoyue,
								obj.name,
								obj.masterimg,
								obj.sumbmasterimg,
								@rownum := @rownum + 1 AS num_tmp,
								@incrnum := CASE
							WHEN @rowtotal = obj.huoyue THEN
								@incrnum
							WHEN @rowtotal := obj.huoyue THEN
								@rownum
							END AS rownum
							FROM
								(
									SELECT t.* FROM  circle t  ORDER BY huoyue DESC
								) AS obj,
								(
									SELECT
										@rownum := 0 ,@rowtotal := NULL ,@incrnum := 0
								) r
						) AS obj_new");
						
		for($i=0;$i<sizeof($result);$i++){
			if($result[$i]['circle_id'] == $circle_id){
				$retrunArr = array(
				   "code"=>200,
				   "Obj"=>$result[$i]
				);
				
				echo json_encode($retrunArr);
				exit();
			}
		}				
	}
	
	//获取圈子排行
	public function getCircleHuoYue(){
		
		
		$page = $_REQUEST['page'];
		$user_id = $_REQUEST['user_id'];
		$pagecount = $_REQUEST['pagecount'];
		
		

		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

		$Model=M();
		
		$startcount = $page*$pagecount;
		
		$result = $Model->Query("SELECT
						obj_new.circle_id,
						obj_new.huoyue,
						obj_new.rownum,
						obj_new.name,
						obj_new.masterimg,
						obj_new.sumbmasterimg,
						obj_new.replycount
					FROM
						(
							SELECT
								obj.circle_id,
								obj.huoyue,
								obj.name,
								obj.masterimg,
								obj.sumbmasterimg,
								obj.replycount,
								@rownum := @rownum + 1 AS num_tmp,
								@incrnum := CASE
							WHEN @rowtotal = obj.huoyue THEN
								@incrnum
							WHEN @rowtotal := obj.huoyue THEN
								@rownum
							END AS rownum
							FROM
								(
									SELECT t.* FROM  circle t  ORDER BY huoyue DESC
								) AS obj,
								(
									SELECT
										@rownum := 0 ,@rowtotal := NULL ,@incrnum := 0
								) r
						) AS obj_new LIMIT ".$startcount.",".$pagecount."");
		//$result = $Model->Query("select * from circle order by huoyue limit ".$startcount.",".$pagecount."");
		
		for($i=0;$i<sizeof($result);$i++){
			$count = $Model->Query("select count(*) as count from circlefollow where circle_id=".$result[$i]['circle_id']." and user_id=".$user_id."");
			$count = $count[0]['count'];
			
			if($count==0){
				$result[$i]['guan'] = 0;
			}else{
				$result[$i]['guan'] = 1;
			}
		}
		
		$fulist = array($result);
    	echo getSuccessJson($fulist);
	}
	
	//获取排行信息
	public function getHuoYueMessage(){
		$user_id = $_REQUEST['user_id'];
		$Model = M();
		$minnum = 0;
		$upnum = 0;
		$chanum = 0;
		
		$resultlist = $Model->Query("SELECT
			obj_new.user_id,
			obj_new.core,
			obj_new.rownum
		FROM
			(
				SELECT
					obj.user_id,
					obj.core,
					@rownum := @rownum + 1 AS num_tmp,
					@incrnum := CASE
				WHEN @rowtotal = obj.core THEN
					@incrnum
				WHEN @rowtotal := obj.core THEN
					@rownum
				END AS rownum
				FROM
					(
						SELECT user_id,core FROM  core ORDER BY core DESC
					) AS obj,
					(
						SELECT
							@rownum := 0 ,@rowtotal := NULL ,@incrnum := 0
					) r
			) AS obj_new");
		$minnum = $resultlist[0]['core'];
		$upnum = $resultlist[0]['core'];
		$count = 1;
		for($i=0;$i<sizeof($resultlist);$i++){
			
			
			if($user_id==$resultlist[$i]['user_id']){
				$chanum = $upnum-$resultlist[$i]['core'];
				$count = $resultlist[$i]['rownum'];
				break;
			}
			
			if($resultlist[$i]['core']<$minnum){
				$upnum = $minnum;
				$minnum = $resultlist[$i]['core'];
				
			}
		}
		
		$returnArr = array(
		   "code"=>200,
		   "count"=>$count,
		   "chanum"=>$chanum
		);
		
		echo json_encode($returnArr);
	}
	
	//获取个人活跃度排行
	public function getHuoYue(){
		$month = date('m')+1;
		$page = $_REQUEST['page'];
		$user_id = $_REQUEST['user_id'];
		$pagecount = $_REQUEST['pagecount'];
		
		

		if($page == null||$page<=0){
			$page=0;
		}

		if($pagecount == null||$pagecount<=0){
			$pagecount=10;
		}

		$Model=M();
		
		$startcount = $page*$pagecount;
		
		$result = $Model->Query("SELECT
						obj_new.user_id,
						obj_new.core,
						obj_new.rownum,
						obj_new.name,
						obj_new.headimg,
						obj_new.sumbheadimg
					FROM
						(
							SELECT
								obj.user_id,
								obj.core,
								obj.name,
								obj.headimg,
								obj.sumbheadimg,
								@rownum := @rownum + 1 AS num_tmp,
								@incrnum := CASE
							WHEN @rowtotal = obj.core THEN
								@incrnum
							WHEN @rowtotal := obj.core THEN
								@rownum
							END AS rownum
							FROM
								(
									SELECT t.user_id,t.core,t1.name,t1.headimg,t1.sumbheadimg FROM  core t,USER t1 WHERE t.user_id=t1.user_id ORDER BY t.core DESC
								) AS obj,
								(
									SELECT
										@rownum := 0 ,@rowtotal := NULL ,@incrnum := 0
								) r
						) AS obj_new LIMIT ".$startcount.",".$pagecount."");
		
		
		//$result = $Model->Query("SELECT t1.headimg,t1.sumbheadimg,t1.name,t.core FROM core t,USER t1 WHERE t.user_id=t1.user_id ORDER BY t.core desc limit ".$startcount.",".$pagecount."");
		
		$fulist = array($result);
    	echo getSuccessJson($fulist);
	}

}