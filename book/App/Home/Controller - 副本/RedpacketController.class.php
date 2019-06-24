<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
class RedpacketController extends Controller{  
	public function test(){
		$InsertArr = array(
			'wxshop_appid'=>'dddddd', 
			'user_id'=>22,
			'redpack_id'=>7
			);
		$id = myinsert('group_redpacket',$InsertArr);  
		echo $id;
	}
	//领取页面 
	public function redpacket_page(){ 
		$wxshop_appid = $_REQUEST['wxshop_appid'];
		$Model = M();
		$data = $Model->Query("SELECT * FROM redpacket WHERE wxshop_appid='".$wxshop_appid."';");
		$data = array($data);
		echo getSuccessJson($data,'操作成功');
	}

	//获取红包，做团长
	public function getredpacket(){ 
		$user_id = $_REQUEST['user_id'];
		$wxshop_appid = $_REQUEST['appid'];//商家的标识
		$redpacket_id = $_REQUEST['redpacket_id'];//红包表主键id
		$Model = M();
		//查询是否已经参与这次红包活动
		$join_in = $Model->Query("SELECT group_redpacket_id FROM group_redpacket_lst WHERE redpack_id=".$redpacket_id." AND user_id=".$user_id.";");
        $fenhong = $Model->Query("SELECT * FROM group_redpacket WHERE id=".$join_in[0]['group_redpacket_id'].";");
        if($fenhong[0]['type']==1){  
        	echo json_encode(array('code'=>202,'msg'=>'团活动已结束！','group_redpacket_id'=>$join_in[0]['group_redpacket_id']));   
			exit;  
        }   
		if($join_in[0]['group_redpacket_id']!=''){ 
			echo json_encode(array('code'=>200,'msg'=>'你已参加红包分利活动，去邀请人吧！','group_redpacket_id'=>$join_in[0]['group_redpacket_id']));  
			exit;  
			// $this->groupRedpacket($join_in[0]['group_redpacket_id'],$user_id);
			// exit;
		}
		//查询是否已经红包发完了  
		$rdpacket = $Model->Query("SELECT * FROM redpacket WHERE id=".$redpacket_id.";");
		if($rdpacket[0]['number']==0){ 
			echo json_encode(array('code'=>201,'msg'=>'红包领取完了，下次请早'));
			exit; 
		}
		//减红包组
		$Model->execute("UPDATE redpacket SET `number`=`number`-1 WHERE id=".$redpacket_id.";");//
		//把该用户作为团长
		$InsertArr = array(
			'wxshop_appid'=>$wxshop_appid, 
			'user_id'=>$user_id,
			'redpack_id'=>$redpacket_id  
			);
		$id = myinsert('group_redpacket',$InsertArr);  
		//并把团长写入组员表内 
		$Model->execute("INSERT INTO group_redpacket_lst (group_redpacket_id,redpack_id,user_id) VALUES (".$id.",".$redpacket_id.",".$user_id.");");  
		echo json_encode(array('code'=>200,'msg'=>'领取成功','group_redpacket_id'=>$id));   
	}


	//领取团长发起的红包活动
	public function groupRedpacket($group_redpacket_id,$user_id){  
		//$group_redpacket_id = $_REQUEST['group_redpacket_id'];//团活动表信息
		//$user_id = $_REQUEST['user_id'];   
		$Model = M('group_redpacket_lst');  
		$JOINS = $Model->Query("SELECT count(*) as count FROM group_redpacket_lst WHERE user_id=".$user_id." AND group_redpacket_id=".$group_redpacket_id.";");
		if($JOINS[0]['count']>0){
			echo json_encode(array('code'=>200,'msg'=>'你已参加过该活动'));
			exit;
		}
		$data = $Model->Query("SELECT * FROM group_redpacket WHERE id=".$group_redpacket_id.";");//查询是否满员了
		$xianzhi = $Model->Query("SELECT * FROM redpacket WHERE id=".$data[0]['redpack_id'].";");//查询可参加人数
		$count = $Model->Query("SELECT count(*) as count FROM group_redpacket_lst WHERE group_redpacket_id=".$group_redpacket_id.";"); 
		if($count[0]['count']<$xianzhi[0]['canyu']){ 
			//可以加入红包活动（插入）
			$InsertArr = array(
				'user_id'=>$user_id, 
				'redpack_id'=>$data[0]['redpack_id'], 
				'group_redpacket_id'=>$group_redpacket_id
				); 
			if($Model->add($InsertArr)){
					$result = array('code'=>200,'msg'=>'参加团红包活动成功！');
			}else{
					$result = array('code'=>201,'msg'=>'参加团红包活动失败！'); 
			} 
		}else{  
			//满员了
			$result = array('code'=>200,'msg'=>'改团红包活动已够人！'); 
		} 

		$this->ajaxReturn($result);
	}

	//显示团长团员
	public function grouplst(){
		$group_redpacket_id = $_REQUEST['group_redpacket_id'];
		$result = array();
		$Model = M(); 
		$data = $Model->Query("SELECT t1.avatarUrl,t.redpack_id FROM group_redpacket_lst t INNER JOIN user t1 ON t.user_id=t1.user_id WHERE t.group_redpacket_id=".$group_redpacket_id." ORDER BY t.addtime desc;");
		$redpacket = $Model->Query("SELECT * FROM redpacket WHERE id=".$data[0]['redpack_id'].";");//钱还有人数
		$result['lst'] = $data;
		$result['redpacket'] = $redpacket[0];
		// $result = array($result);  
		echo getSuccessJson($result,'操作成功');  
	}

	//瓜分红包
	public function guafen(){  
		$group_redpacket_id = $_REQUEST['group_redpacket_id']; 
		$Model = M();//查出该红包有多少人和金额多大
		$group = $Model->Query("SELECT * FROM group_redpacket WHERE id=".$group_redpacket_id.";");
		$redpacket = $Model->Query("SELECT * FROM redpacket WHERE id=".$group[0]['redpack_id'].";");
		$zuyuan = $Model->Query("SELECT count(*) as count  FROM group_redpacket_lst WHERE group_redpacket_id=".$group_redpacket_id.";");
		if($zuyuan[0]['count']==$redpacket[0]['canyu']&&$group[0]['type']==0&&!empty($group_redpacket_id)){
			//可以分
			$fenhong = new \Think\CBonus($zuyuan[0]['count'],$redpacket[0]['price']);
		    $fenhong->compute();//计算红包分额
		    $money = $fenhong->bonus;//数组
		    $user = $Model->Query("SELECT user_id FROM group_redpacket_lst WHERE group_redpacket_id=".$group_redpacket_id.";");
		    foreach ($user as $key => $value) {
		    	$Model->execute("UPDATE user SET `money`=`money`+".$money[$key]." WHERE user_id=".$value['user_id'].";");
		    	//插入流水表
		    	$InsertArr = array(
		    		'user_id'=>$value['user_id'], 
		    		'money'=>$money[$key],
		    		'group_redpacket_id'=>$group_redpacket_id,
		    		'redpacket_id'=>$group[0]['redpack_id']
		    		);
		    	myinsert('redpacket_bounty',$InsertArr); 
		    } 
		    $Model->execute("UPDATE group_redpacket SET type=1 WHERE id=".$group_redpacket_id.";");//更改这个团发起的活动已经是分红的啦
		    $result = array('code'=>200,'msg'=>'分利成功');
		}else{
			//不可以分
			$result = array('code'=>201,'msg'=>'不符合分利红包的条件');
		}
		    $this->ajaxReturn($result);
	  }

	  //某活动参与的红包分利奖励
	  public function bountlst(){
	  		$group_redpacket_id = $_REQUEST['group_redpacket_id']; 
	  		$Model = M();
	  		$data = $Model->Query("SELECT t1.avatarUrl,t1.nickName,t.money,t.addtime FROM redpacket_bounty t INNER JOIN user t1 ON t.user_id=t1.user_id WHERE t.group_redpacket_id=".$group_redpacket_id.";"); 
	  		$data = array($data);
	  		echo getSuccessJson($data);   
	  }


	  //获得最新一次红包拆分结果
	  public function getzuixin(){
	  	    $user_id = $_REQUEST['user_id'];  
	  	    $Model = M();
	  	    //$获得最新一次
	  	    $xin = $Model->Query("SELECT group_redpacket_id,MAX(ADDTIME) FROM redpacket_bounty  WHERE user_id=".$user_id." GROUP BY user_id;");//取时间最大值
	  	    if($xin[0]['group_redpacket_id']){  
	  	    		$data = $Model->Query("SELECT t1.avatarUrl,t1.nickName,t.money,t.addtime FROM redpacket_bounty t INNER JOIN user t1 ON t.user_id=t1.user_id WHERE t.group_redpacket_id=".$xin[0]['group_redpacket_id'].";"); 
	  		        $data = array($data);
	  	    }else{
	  	    	$data = array(); 
	  	    } 

	  	    echo getSuccessJson($data,'操作成功');
	  }

}
?>