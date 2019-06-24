<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
class PingtuanController extends Controller{   
     /*
     **团购满人了，后台才会发货，否则把钱打回给用户
     */

    //测试 
     public function test(){ 
     	$pingtuan[0]['groupsize']='10';
     	$count[0]['count']='9'; 
     	$cynum = $count[0]['count']+1;
					if($pingtuan[0]['groupsize']===$cynum){
						echo 11;
					}
     }

    //获取拼团id
     public function getpingtuanid(){
     	$where = array(); 
     	$where['user_id'] = $_REQUEST['user_id'];
     	$where['good_id'] = $_REQUEST['good_id']; 
     	$where['order_id'] = $_REQUEST['order_id'];
     	$Model = M('groupbuyingcus');
     	$data = $Model->where($where)->field('groupBuying_id')->find();
     	if($data){  
     		$result = array('code'=>200,'result'=>$data);
     	}else{
     		$result = array('code'=>201,'result'=>'获取拼团id失败');
     	}
     	$this->ajaxReturn($result); 
     }


	//第一个人进行团购 
	public function firstBuy($orders_id,$user_id,$wxshop_appid){ //一个用户开多个团 
		  $Model = M(); 
		  $ordersitem = $Model->Query("SELECT goods_id,sku_id,goods_num FROM ordersitem WHERE orders_id=".$orders_id.";");
		  if(!empty($ordersitem[0]['goods_id'])){
		  	//非空
		  	$good = $Model->Query("SELECT groupPrice,groupSize,groupValidHours FROM goods WHERE id=".$ordersitem[0]['goods_id'].";");
		  	if(!empty($good[0]['groupSize']&&!empty($good[0]['groupValidHours']))){
		  		$updateArr = array( 
		  			'wxshop_appid'=>$wxshop_appid, 
		  			'endtime'=> date('Y-m-d H:i:s',strtotime('+'.$good[0]['groupValidHours'].' hour')),
		  			'groupsize'=> $good[0]['groupSize'],
		  		    'sku_id'=>$ordersitem[0]['sku_id'],//empty($ordersitem[0]['sku_id']):0?
		  		    'good_id'=>$ordersitem[0]['goods_id'], 
		  		    'user_id'=>$user_id 
		  		);
		  	  $groupBuying_id = myinsert('groupbuying',$updateArr);//写进拼团表

		  	  $insertArr = array( 
		  	  	'groupBuying_id'=>$groupBuying_id,
		  	  	'wxshop_appid'=>$wxshop_appid,
		  	  	'user_id'=>$user_id,
		  	  	'order_id'=>$orders_id,
		  	  	'isheader'=>1,
		  	  	'status'=>1,//0初始 1已付款 2待退款 3已退款 4作废
		  	  	'sku_id'=>$ordersitem[0]['sku_id'],
		  	  	'good_id'=>$ordersitem[0]['goods_id'],
		  	  	'num'=>$ordersitem[0]['goods_num']
		  	  	);
		  	  myinsert('groupbuyingcus',$insertArr); //写拼团明细表
		  	}
		  }
  
	} 




	//在有团购队伍的基础上进行团购
	public function secondBuy($orders_id,$groupbuying_id,$user_id){
		  //把不通过的写进去日志表里
		$Model = M();
		$ordersitem = $Model->Query("SELECT goods_id,sku_id,goods_num FROM ordersitem WHERE orders_id=".$orders_id.";");
		if(!empty($ordersitem[0]['goods_id'])){
					$pingtuan = $Model->Query("SELECT * FROM groupbuying WHERE id=".$groupbuying_id.";");
					$count = $Model->Query("SELECT count(*) as count FROM groupbuyingcus WHERE groupBuying_id=".$groupbuying_id.";");
					$cynum = $count[0]['count']+1;

					if($pingtuan[0]['groupsize']==$cynum){//改变状态团满员
						$Model->execute("UPDATE groupbuying SET status=1 WHERE id=".$groupbuying_id.";");
					}      

					if($pingtuan[0]['groupsize']>$count[0]['count']){//检查是否未满人。
							if(!empty($pingtuan[0]['id'])){
								   $insertArr = array( 
								   	    'wxshop_appid'=>$pingtuan[0]['wxshop_appid'],
								  	  	'groupBuying_id'=>$groupbuying_id, 
								  	  	'user_id'=>$user_id,
								  	  	'order_id'=>$orders_id,
								  	  	'isheader'=>0,//0为成员，1为团长
								  	  	'status'=>1,//0初始 1已付款 2待退款 3已退款 4作废
								  	  	'sku_id'=>$ordersitem[0]['sku_id'],
								  	  	'good_id'=>$ordersitem[0]['goods_id'],
								  	  	'num'=>$ordersitem[0]['goods_num']
								  	  	);
								  	myinsert('groupbuyingcus',$insertArr); //写拼团明细表
					  	}else{ 
					  		// 日志处理
					  	}
					}else{
						//日志处理
					}
					
		}else{
			//日志处理
		}
		

	}



	//查询出改商品有哪些团在进行（最新的10条）
	public function getTuanlst(){
          $goods_id = $_REQUEST['good_id'];
          //未过期，未满人，拼团中 
          if(empty($goods_id)){ 
          	echo json_encode(array('code'=>201,'msg'=>'请检查参数'));
          	exit;
          }
          $Model = M();
          $lst = $Model->Query("SELECT t.*,t1.nickName,t1.avatarUrl FROM groupbuying t INNER JOIN user t1 ON t.user_id=t1.user_id WHERE t.good_id=".$goods_id." AND t.status=0 AND endtime>NOW() ORDER BY t.creattime DESC LIMIT 0,9;");
          // echo $Model->_sql();die;
          $result = array();
          foreach ($lst as $key => $value) {
          	  $count = $Model->Query("SELECT count(*) as count FROM groupbuyingcus WHERE groupBuying_id=".$value['id'].";");
          	  if($value['groupsize']>$count[0]['count']){
          	  	  $value['curtime'] = time(); 
          	  	  $value['shengyu'] = $value['groupsize']-$count[0]['count'];
          	  	  array_push($result,$value); 
          	  }
          }  
          echo getSuccessJson(array($result),'查询成功');  

 
	} 

	//我的拼团
	public function mypingtuan(){
		$user_id = $_REQUEST['user_id'];
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		if($page==null||$page<=0){
			$page = 0;
		}
		if($pagecount==null||$pagecount<=0){
			$pagecount = 10;
		} 
		$startcount = $page*$pagecount;
		$Model = M();
		$data = $Model->Query("SELECT * FROM groupbuyingcus t INNER JOIN groupbuying t1 ON t.groupBuying_id=t1.id INNER JOIN user t2 ON t.user_id=t2.user_id INNER JOIN goods t3 ON t.good_id=t3.id ORDER BY t.jointime desc LIMIT ".$startcount.",".$pagecount.";"); 
		echo getSuccessJson(array($data),'查询成功');  
	}

 
	//查询某个团的详细情况
	public function getDetail(){
		$groupBuying_id = $_REQUEST['groupBuying_id']; 
		$user_id = $_REQUEST['user_id'];
		 if(empty($groupBuying_id)&&empty($user_id)){
          	echo json_encode(array('code'=>201,'msg'=>'请检查参数'));
          	exit;
          }
		$result = array();      
		$Model = M();    
		 
		$tuan = $Model->Query("SELECT * FROM groupbuying WHERE id=".$groupBuying_id.";");
		if(strtotime($tuan[0]['endtime'])>time()&&$tuan[0]['status']==0){
				$isjoin = $Model->Query("SELECT count(*) as count FROM groupbuyingcus WHERE groupBuying_id=".$groupBuying_id." AND user_id=".$user_id.";");//检查这人是否已参加这个团活动 
				if($isjoin[0]['count']>0){  
					$count = $Model->Query("SELECT count(*) as count FROM groupbuyingcus WHERE groupBuying_id=".$groupBuying_id.";");
					$yican = $Model->Query("SELECT t.*,t1.nickName,t1.avatarUrl FROM groupbuyingcus t INNER JOIN user t1 ON t.user_id=t1.user_id WHERE t.groupBuying_id=".$groupBuying_id.";"); 
					$data = array('code'=>200,'msg'=>'已参加','data'=>$yican,'tuan'=>$tuan,'yicanjia'=>$count[0]['count'],'currenttime'=>time()); 
				}else{ 
					$count = $Model->Query("SELECT count(*) as count FROM groupbuyingcus WHERE groupBuying_id=".$groupBuying_id.";");
					$yican = $Model->Query("SELECT t.*,t1.nickName,t1.avatarUrl FROM groupbuyingcus t INNER JOIN user t1 ON t.user_id=t1.user_id WHERE t.groupBuying_id=".$groupBuying_id.";"); 
					$data = array('code'=>201,'msg'=>'未参加','data'=>$yican,'tuan'=>$tuan,'yicanjia'=>$count[0]['count'],'currenttime'=>time()); //
				}  
		}else{    
		    $count = $Model->Query("SELECT count(*) as count FROM groupbuyingcus WHERE groupBuying_id=".$groupBuying_id.";");  
			$yican = $Model->Query("SELECT t.*,t1.nickName,t1.avatarUrl FROM groupbuyingcus t INNER JOIN user t1 ON t.user_id=t1.user_id WHERE t.groupBuying_id=".$groupBuying_id.";"); 
			$data = array('code'=>202,'msg'=>'该活动已经结束','data'=>$yican,'tuan'=>$tuan,'yicanjia'=>$count[0]['count'],'currenttime'=>time()); //
		}  
		echo getSuccessJson($data,'操作成功');    
	}  




}