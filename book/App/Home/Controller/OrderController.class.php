<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
class OrderController extends Controller{   
	//单个商品立即购买提交订单 
	public function add_buy(){     
		$address_id = $_REQUEST['address_id'];//地址id
		$goods_id = $_REQUEST['goods_id'];//商品主键id
		$goods_num	= $_REQUEST['goods_num'];//数量 
		$sku_path = $_REQUEST['sku_path'];//商品规格组合表字符串 
		$sku_id = $_REQUEST['sku_id'];//商品规格组合表id
		$appid = $_REQUEST['appid']; //商家小程序 
		$user_id = $_REQUEST['user_id']; //消费者id  
		$post_desc = $_REQUEST['post_desc'];//订单留言  
		$coupon_id = $_REQUEST['coupon_id'];
		$yumoney = $_REQUEST['yumoney'];  
		$kaituanshi = empty($_REQUEST['kaituanshi'])?0:1; //拼团订单
		$groupbuying_id = $_REQUEST['groupBuying_id']; //在有团的基础上，需要传过来

		$Model = M('orders');   
		if(empty($goods_id)||empty($goods_num)){      
			echo '{"code":201,"msg":"请添加商品"}';die;         
		 }  
		$totalyunfei = $this->yunfei($address_id,$goods_id,$appid); //商品运费
		$totalgoodsMoney = $this->dingdan_totalmoney($goods_id,$sku_id,$goods_num,1,$kaituanshi); //商品总价
	

		if($totalgoodsMoney<0){ 
			echo '{"code":201,"msg":"库存不足"}';die; 
		}else{
			/*扣除优惠券操作star*/
		   if(!empty($coupon_id)){ 
				$coupon_money = $Model->Query("SELECT top_price,price FROM coupon WHERE id=".$coupon_id.";");//优惠券满多少减多少
				$top_price = $coupon_money[0]['top_price'];
				$price = $coupon_money[0]['price']; 
				if($totalgoodsMoney<$top_price){ 
					echo '{"code":201,"msg":"你选择的优惠券不满足满'.$top_price.'送'.$price.'"}';die;
				}
				$Model->execute("UPDATE my_coupon SET is_use=1 WHERE user_id=".$user_id." AND wxshop_appid='".$appid."' AND coupon_id=".$coupon_id.";");//改变优惠券已用
				$totalgoodsMoney = $totalgoodsMoney-$price;//商品总价扣除优惠券之后的价格
		   }  
		/*扣除优惠券操作end*/
			$weixin_totalMoney = $totalgoodsMoney+$totalyunfei;
		}

		//用户余额来抵扣
		if(empty($yumoney)&&is_numeric($yumoney)){
		     $weixin_totalMoney = $weixin_totalMoney-$yumoney;
		}
		//查询地址
		$address = $Model->Query("SELECT address FROM user_address WHERE id=".$address_id.";");

		//生成订单
		$time = explode (" ", microtime ());        
		$time = $time[1].($time[0] * 1000);  
		$time2 = explode ( ".", $time); 
		$time = $time2[0];

		$OrderArr = array(  
			"number"=>$time,  
			"address_id"=>$address_id, 
			"user_id"=>$user_id, 
			"totalprice"=>$weixin_totalMoney,//商品总价   
			"wxshop_appid"=>$appid,
			"post_desc"=>$post_desc,
			"address_detail"=>$address[0]['address'], 
			"state"=>1, //0购物车 1订单   
			"yunfarefee"=>$totalyunfei,//运费 
			"coupon_id"=>$coupon_id,  
			"type"=>$kaituanshi,  //0普通订单，1拼团订单 
			"groupbuying_id"=>$groupbuying_id 
			);

		if($orders_id=$Model->add($OrderArr)){
			    $M = M('ordersitem');
			    //查询商品价格图片名称 
				$realprice = $Model->Query("SELECT price FROM goods_sku WHERE id=".$sku_id.";");  
				$goods = $Model->Query("SELECT name,summary,price,mastersumbimage FROM goods WHERE id=".$goods_id.";");
				$realprice = !empty($realprice[0]['price'])?$realprice[0]['price']:$goods[0]['price'];
				// $sheng_kucun = !empty($realprice[0]['kucun'])?$realprice[0]['price']:$goods[0]['kucun'];
				//查询规格
				$sku_miaoshu = $this->getguige($sku_path); 
			    $itemArr = array( 
			    'goodname'=>$goods[0]['name'], 
			    'goods_img'=>$goods[0]['mastersumbimage'],
			    'price'=>$realprice, 
				'goods_id'=>$goods_id,  
				'goods_num'=>$goods_num, 
				'sku_path'=>$sku_miaoshu,    
				'sku_id'=>$sku_id, 
				'orders_id'=>$orders_id 
				); 
			    if($M->add($itemArr)){  
			          $result = array("code"=>200,"msg"=>"提交订单成功","orders_id"=>$orders_id,"number"=>$time,"weixin_totalMoney"=>$weixin_totalMoney); 
			       }else{
			          $result = array("code"=>201,"msg"=>"提交订单失败"); 
			       }
		    }else{ 
			         $result = array("code"=>201,"msg"=>"提交订单失败"); 
		     }
		     $this->ajaxReturn($result); 
	}


	public function delorder(){
		$orders_id = $_REQUEST['orders_id']; 
		if(empty($orders_id)){
			echo json_encode(array('code'=>201,'msg'=>'检查参数'));
			exit;
		}
		$Model = M('orders');
		if($Model->delete($orders_id)){
			$Model->execute("DELETE FROM ordersitem WHERE orders_id=".$orders_id.";");
			$result = array('code'=>200,'msg'=>'取消订单成功');
		}else{
			$result = array('code'=>201,'msg'=>'取消订单失败');
		}
		$this->ajaxReturn($result);    
	}







	//运费计算
	public function yunfei($address_id,$goods_id,$appid){
		$Model = M();
		$goods_weight = 0;
		$address = $Model->Query("SELECT city FROM user_address WHERE id=".$address_id.";");//获取用户地址
		$peidui_fare = $Model->Query("SELECT * FROM fare_fee WHERE CONCAT(',',places,',') REGEXP CONCAT(',(',REPLACE('".$address[0]['city']."',',','|'),'),') AND wxshop_appid='".$appid."';");//获取商家可发货地址且价格。
		if($peidui_fare[0]['id']>0){ 
			//使用商家填写的运送方式
			$goods_id = explode(',',$goods_id);
			foreach ($goods_id as $key => $value) { 
			   $goods_weights = $Model->Query("SELECT IFNULL(weight,0) AS allweight FROM goods WHERE id=".$value.";");
			   $goods_weight = $goods_weight+$goods_weights[0]['allweight']; 
			}
			$chaozhong = floor(($goods_weight-$peidui_fare[0]['default_weight'])/$peidui_fare[0]['add_weight']);
			if($chaozhong>0){ 
				$zongjia = $chaozhong*$peidui_fare[0]['add_price']+$peidui_fare[0]['default_price'];
			}else{
				$zongjia = $peidui_fare[0]['default_price']; 
			} 
			// $result = array('code'=>200,'yunfei'=>$zongjia);  
			$yunfei = $zongjia; 
		}else{
			//使用商家填写的默认方式
			$goods_id = explode(',',$goods_id);
			foreach ($goods_id as $key => $value) { 
			   $goods_weights = $Model->Query("SELECT IFNULL(weight,0) AS allweight FROM goods WHERE id=".$value.";");
			   $goods_weight = $goods_weight+$goods_weights[0]['allweight']; 
			}
			$moren_yunfei = $Model->Query("SELECT * FROM fare WHERE wxshop_appid='".$appid."';");
			$chaozhong = floor(($goods_weight-$moren_yunfei[0]['default_weight'])/$moren_yunfei[0]['add_weight']);
			// echo $chaozhong;die;
			if($chaozhong>0){ 
				$zongjia = $chaozhong*$moren_yunfei[0]['add_price']+$moren_yunfei[0]['default_price'];
			}else{
				$zongjia = $moren_yunfei[0]['default_price'];
			} 
			// $result = array('code'=>200,'yunfei'=>$zongjia); 
			$yunfei = $zongjia;  
		}
		// $this->ajaxReturn($result); 
		return $yunfei;   
	}

	//查询规格
	public function getguige($sku_path){ 
		$Model = M('good_attr_value');
		$map['id'] = array('in',$sku_path);
		$sku_miaoshu = $Model->WHERE($map)->getField('name',3); 
		if($sku_miaoshu){
		    $result = implode('+',$sku_miaoshu);
		}else{
			$result = '';  
		}
		return $result; 
	}

	//调用计算订单总价 
	public function diaoyong_dingdan_totalmoney(){ 
		$address_id = $_REQUEST['address_id']; //地址id
		$goods_id = $_REQUEST['goods_id'];//一个id,或者多个id
		$appid = $_REQUEST['appid'];//小程序appid 
		$sku_id = $_REQUEST['sku_id'];
		$goods_num = $_REQUEST['goods_num'];
		$kaituanshi = $_REQUEST['kaituanshi']; //0普通订单 ，1为团购订单
		$totalyunfei = $this->yunfei($address_id,$goods_id,$appid);
		$totalgoodsMoney = $this->dingdan_totalmoney($goods_id,$sku_id,$goods_num,0,$kaituanshi);
		$totalMoney = $totalyunfei+$totalgoodsMoney; 
		echo '{"code":"200","totalyunfei":"'.$totalyunfei.'","totalgoodsMoney":"'.$totalgoodsMoney.'","totalMoney":"'.$totalMoney.'"}';
	} 
	//订单总价 
	//立即购买订单总价 
	/*
	**$kaituanshi 计算开团价格
	 */
	public function dingdan_totalmoney($goods_id,$sku_id,$goods_num,$type=0,$kaituanshi){   
		//立即购买只能是一种产品呀
		$Model = M(); 
		//查询商品价格图片名称  
		$realprice = $Model->Query("SELECT price,kucun FROM goods_sku WHERE id=".$sku_id.";");  
		$goods = $Model->Query("SELECT name,summary,price,mastersumbimage,kucun,groupPrice FROM goods WHERE id=".$goods_id.";");
		$realprice = !empty($realprice[0]['price'])?$realprice[0]['price']:$goods[0]['price'];
		$sheng_kucun = !empty($realprice[0]['kucun'])?$realprice[0]['kucun']:$goods[0]['kucun'];
		if($type==1){  
			if($sheng_kucun>=$goods_num){
				$totalgoodsMoney = $goods_num*$realprice;//商品总价
				//减库存
				if($realprice[0]['kucun']>0){
				   $Model->execute("UPDATE goods_sku SET `kucun`=`kucun`-".$goods_num." WHERE id=".$sku_id.";");
				}else{
				   $Model->execute("UPDATE goods SET `kucun`=`kucun`-".$goods_num." WHERE id=".$goods_id.";");
				}
			}else{
				$totalgoodsMoney = -1;    
			}  
		}else{
			$totalgoodsMoney = $goods_num*$realprice;
		} 
		    if($kaituanshi==1){    
		    	$totalgoodsMoney = $totalgoodsMoney*$goods[0]['groupPrice']; 
		    }   
		    return $totalgoodsMoney;  
		
	}

	
	/***购物车****/

	//购物车立即提交按钮
	public function cartodingdan_tijiao(){ 
		$address_id = $_REQUEST['address_id'];//地址id
		$user_id = $_REQUEST['user_id'];//获取购物车所有的商品goods_id或者sku_id
		$appid = $_REQUEST['appid']; //商家小程序
		$post_desc = $_REQUEST['post_desc'];//订单留言   
		$coupon_id = $_REQUEST['coupon_id'];  
		$yumoney = $_REQUEST['yumoney'];  

		$Model = M('orders');
		$orders = $Model->Query("SELECT `id`,`number` FROM orders WHERE user_id=".$user_id." AND state=0;");//购物车  
    	$goods = $Model->Query("SELECT goods_id,sku_id,goods_num FROM ordersitem WHERE orders_id=".$orders[0]['id'].";");//计算购物车商品id
    	foreach ($goods as $key => $value) {   
    		//检查库存 
			$realprice = $Model->Query("SELECT kucun FROM goods_sku WHERE id=".$value['sku_id'].";");  
			$goodskucun = $Model->Query("SELECT kucun FROM goods WHERE id=".$value['goods_id'].";");
			$sheng_kucun = !empty($realprice[0]['kucun'])?$realprice[0]['kucun']:$goodskucun[0]['kucun'];
		if($sheng_kucun<$value['goods_num']){
			    echo '{"code":201,"msg":"库存不足"}';die;        
			} 
			$sku_kucun[$key]['kucun'] = $realprice[0]['kucun'];// 查询库存
    	}


    	    //能执行到这一步证明库存足
    		foreach ($goods as $key => $value) {     
    			//可以优化直接在上面拿数据
    			//$realprice = $Model->Query("SELECT kucun FROM goods_sku WHERE id=".$value['sku_id'].";");  
				if($sku_kucun[$key]['kucun']>0){        
				   $Model->execute("UPDATE goods_sku SET `kucun`=`kucun`-".$value['goods_num']." WHERE id=".$value['sku_id'].";");
				}else{
				   $Model->execute("UPDATE goods SET `kucun`=`kucun`-".$value['goods_num']." WHERE id=".$value['goods_id'].";"); 
				} 
    		    $goods_id[] = $value['goods_id']; 
    		}
				

    	$goods_id = implode(",",$goods_id);   

		$totalyunfei = $this->yunfei($address_id,$goods_id,$appid);//运费模块
		$totalgoodsMoney = $Model->Query("SELECT IFNULL(SUM(price*goods_num),0) AS allprice FROM ordersitem WHERE orders_id=".$orders[0]['id'].";");//商品总价

		/*扣除优惠券操作star*/
		$goods_totalMoney = $totalgoodsMoney[0]['allprice'];
		if(!empty($coupon_id)){
			$coupon_money = $Model->Query("SELECT top_price,price FROM coupon WHERE id=".$coupon_id.";");//优惠券满多少减多少
			$top_price = $coupon_money[0]['top_price'];
			$price = $coupon_money[0]['price'];
			if($goods_totalMoney<$top_price){ 
				echo '{"code":201,"msg":"你选择的优惠券不满足满'.$top_price.'送'.$price.'"}';die;
			}
			$Model->execute("UPDATE my_coupon SET is_use=1 WHERE user_id=".$user_id." AND wxshop_appid='".$appid."' AND coupon_id=".$coupon_id.";");//改变优惠券已用
			$goods_totalMoney = $goods_totalMoney-$price;//商品总价扣除优惠券之后的价格
		}
		/*扣除优惠券操作end*/

		$weixin_totalMoney = $totalyunfei+$goods_totalMoney; 

		/*余额抵扣*/
		if(empty($yumoney)&&is_numeric($yumoney)){
		       $weixin_totalMoney = $weixin_totalMoney-$yumoney;
		 }  
		/*余额抵扣*/


		//更新订单
		$address = $Model->Query("SELECT address FROM user_address WHERE id=".$address_id.";");
		$updateArr = array(
			'id'=>$orders[0]['id'],  
			'address_detail'=>$address[0]['address'],
			'state'=>1,  
			'addtime'=>date('Y-m-d H:i:s'), 
			'post_desc'=>$post_desc,
			"yunfarefee"=>$totalyunfei,
			"wxshop_appid"=>$appid, 
			"totalprice"=>$weixin_totalMoney,  
			"address_id"=>$address_id, 
			"user_id"=>$user_id,
			"coupon_id"=>$coupon_id
			); 
		if($Model->save($updateArr)===false){
			$result = array("code"=>201,"msg"=>"提交订单失败");   
		}else{
			$result = array("code"=>200,"msg"=>"提交订单成功","number"=>$orders[0]['number'],"weixin_totalMoney"=>$weixin_totalMoney);	
		}
		$this->ajaxReturn($result);
		} 


	//订单总价
	//购物车过来成为订单的订单总价
	public function cartodingdan_totalmoney(){  
		$address_id = $_REQUEST['address_id']; 
		$appid = $_REQUEST['appid'];
    	$user_id = $_REQUEST['user_id'];  
    	
    	$Model = M();
		$orders = $Model->Query("SELECT id FROM orders WHERE user_id=".$user_id." AND state=0;");//购物车  
    	$goods = $Model->Query("SELECT goods_id FROM ordersitem WHERE orders_id=".$orders[0]['id'].";");//计算购物车商品id
    	foreach ($goods as $key => $value) {
    		$goods_id[] = $value['goods_id'];
    	}
    	$goods_id = implode(",",$goods_id);
		$totalgoodsMoney = $Model->Query("SELECT IFNULL(SUM(price*goods_num),0) as totalMoney FROM ordersitem WHERE orders_id=".$orders[0]['id'].";");   
    	$totalyunfei = $this->yunfei($address_id,$goods_id,$appid);
		$totalMoney = $totalyunfei+$totalgoodsMoney[0]['totalMoney'];  

		echo '{"code":"200","totalyunfei":"'.$totalyunfei.'","totalgoodsMoney":"'.$totalgoodsMoney[0]['totalMoney'].'","totalMoney":"'.$totalMoney.'"}';
	}  


	//购物车总价
	public function car_totalmoney(){   
		$Model = M();
		$user_id = $_REQUEST['user_id'];
		$orders = $Model->Query("SELECT id FROM orders WHERE user_id=".$user_id." AND state=0;");//购物车
		$totalMoney = $Model->Query("SELECT IFNULL(SUM(price*goods_num),0) as totalMoney FROM ordersitem WHERE orders_id=".$orders[0]['id'].";");
		if($totalMoney[0]['totalMoney']>0){
			$result = array('code'=>200,'totalMoney'=>$totalMoney[0]['totalMoney']);
		}else{
			$result = array('code'=>200,'totalMoney'=>'0.00');  
		}
		$this->ajaxReturn($result);
	}

	//加入购物车 
	public function add_car(){  
		$goods_id = $_REQUEST['goods_id']; 
		$goods_num	= $_REQUEST['goods_num'];  
		$sku_id = $_REQUEST['sku_id'];//规格表id
		$sku_path = $_REQUEST['sku_path'];//规格组合（字符串）
		$wxshop_appid = $_REQUEST['appid'];//小程序appid
		$user_id = $_REQUEST['user_id'];//用户user_id 
 
		//获取用户openid
		// $_3rdsession = $_REQUEST["_3rdsession"]; 
		// $key = explode(",",S($_3rdsession));     
		// $openid = $key[0]; //openid  

		//生成订单
		$time = explode (" ", microtime ());       
		$time = $time[1].($time[0] * 1000);  
		$time2 = explode ( ".", $time); 
		$time = $time2[0];     

		
		$Model = M('orders');//订单主表    
		$M = M('ordersitem');//订单详情     

		//查询商品价格图片名称
		$realprice = $Model->Query("SELECT price,kucun FROM goods_sku WHERE id=".$sku_id.";");  
		$goods = $Model->Query("SELECT name,summary,price,mastersumbimage FROM goods WHERE id=".$goods_id.";");
		$realprice = !empty($realprice[0]['price'])?$realprice[0]['price']:$goods[0]['price'];    
		// echo $realprice;die;
		// echo json_encode(array('sku_id'=>$sku_id));
		// die;

		//插入表数据     
		$OrderArr = array( 
			"openid"=>$openid,
			"wxshop_appid"=>$wxshop_appid, 
			"number"=>$time,
			"user_id"=>$user_id   
			);
		//查询规格
		$sku_miaoshu = $this->getguige($sku_path);
		$itemArr = array(  
					'goods_id'=>$goods_id, 
					'goods_num'=>$goods_num, 
					'sku_id'=>$sku_id,
					'sku_path'=>$sku_miaoshu, 
					'goodname'=>$goods[0]['name'],
					'price'=>$realprice, 
					'goods_img'=>$goods[0]['mastersumbimage']  
				);

 
		//查看是否有购物车  
		$data = $Model->WHERE("state=0 AND user_id=".$user_id."")->getField('id');//查看order表的state是否为1.

		if($data){
			 $itemArr['orders_id']=$data; //已成为同一订单
			 	    $samegoods = $Model->Query("SELECT count(*) AS count FROM ordersitem WHERE orders_id=".$data." AND goods_id=".$goods_id." AND sku_id=".$sku_id.";");
			 	if($samegoods[0]['count']>0){   
			 		//检测库存是否够
			 		$Model->execute("UPDATE ordersitem SET goods_num=`goods_num`+".$goods_num." WHERE orders_id=".$data." AND goods_id=".$goods_id.";"); 
			 	}else{
			 		if($M->add($itemArr)){ 
			          $result = array("code"=>200,"msg"=>"添加到购物车成功"); 
			       }else{
			          $result = array("code"=>201,"msg"=>"添加商品失败");
			       }  
			 	} 
			    
		 }else{ 
			if($orders_id=$Model->add($OrderArr)){
				$itemArr['orders_id']=$orders_id;
			    if($M->add($itemArr)){
			         $result = array("code"=>200,"msg"=>"添加到购物车成功");
			       }else{
			         $result = array("code"=>201,"msg"=>"添加商品失败");
			       }
		    }else{ 
			        $result = array("code"=>201,"msg"=>"添加到购物车失败");
		     }
		}  
		
		$this->ajaxReturn($result);  
	}   
 

  
	//查看购物车
	public function car_list(){  
		$user_id = $_REQUEST['user_id'];    
		$Model = M();
		$orders = $Model->Query("SELECT id FROM orders WHERE user_id=".$user_id." AND state=0;");//购物车
		$orders_id = $orders[0]['id']; // AS goodsprice  AS goodskucun   
		$data = $Model->Query("SELECT id,(price*goods_num) AS sumMoney,price,goods_num,addtime,goods_id,goods_num,goods_img,goodname,sku_path as miaoshu,orders_id,sku_id FROM ordersitem WHERE orders_id=".$orders_id.";");  
		// $M = M('good_attr_value');
		// foreach ($data as $key => $value) { 
		// 	$map['id'] = array('in',$value['sku_path']);
		//  	$sku_miaoshu = $M->WHERE($map)->getField('name',3); 
		//  	$data[$key]['miaoshu'] = implode('+',$sku_miaoshu);
		//  } 
		// echo $Model->_sql();die; 
		$data = array($data);   
		echo getSuccessJson($data,'操作成功');       
	}  
 

	//改变购物车商品数量
	public function addcargoodsnum(){   
		$sku_id = $_REQUEST['sku_id']; 
		$goods_id = $_REQUEST['goods_id'];
		$goods_num = $_REQUEST['goods_num']; 
		$ordersitem_id = $_REQUEST['ordersitem_id'];   
		//echo json_encode(array('sku_id'=>$sku_id,'goods_id'=>$goods_id,'goods_num'=>$goods_num,'ordersitem_id'=>$ordersitem_id));die;
		$Model = M('ordersitem');
		$sku_kucun = $Model->Query("SELECT kucun FROM goods_sku WHERE goods_id=".$goods_id." AND id=".$sku_id.";");//商品有规格的库存
		$goods_sku = $Model->Query("SELECT kucun FROM goods WHERE id=".$goods_id.";");
		$kucun = !empty($sku_id)?$sku_kucun[0]['kucun']:$goods_sku[0]['kucun']; 
		if($kucun>=$goods_num){      
			$updateArr = array( 
				'goods_num'=>$goods_num,    
				'id'=>$ordersitem_id  
				);  
			if($Model->save($updateArr)===false){    
				$result = array('code'=>201,'msg'=>'修改失败');  
			}else{
				$result = array('code'=>200,'msg'=>'修改成功');
			} 
		}else{
			$result = array('code'=>201,'msg'=>'库存不足！'); 
		}
		$this->ajaxReturn($result);  
	}  

	//删除购物车的商品  
	public function delcargoods(){    
		$ordersitem_id = $_REQUEST['ordersitem_id']; 
		$Model = M('ordersitem');   
		if($Model->delete($ordersitem_id)){  
			$result = array('code'=>200,'msg'=>'删除成功');  
		}else{
			$result = array('code'=>201,'msg'=>'删除失败');
		} 
		$this->ajaxReturn($result); 
	}

	/*********订单状态***************/
	//获取各个状态的订单数
	public function getOrderCount(){
		$user_id = $_REQUEST['user_id'];
		$Model = M();
		$one = $Model->Query("select count(*) as count from orders where user_id=".$user_id." and state=1 and status=0");
		$two = $Model->Query("select count(*) as count from orders where user_id=".$user_id." and state=1 and status=1");
		$three = $Model->Query("select count(*) as count from orders where user_id=".$user_id." and state=1 and status=2");
		$four = $Model->Query("select count(*) as count from orders where user_id=".$user_id." and state=1 and status=3");
		$five = $Model->Query("select count(*) as count from orders where user_id=".$user_id." and state=1;");
		
		$one = $one[0]['count'];
		$two = $two[0]['count']; 
		$three = $three[0]['count'];
		$four = $four[0]['count'];
		$five = $five[0]['count'];
		
		$returnArr = array( 
		   "code"=>200,
		   "one"=>$one,
		   "two"=>$two, 
		   "three"=>$three, 
		   "four"=>$four,
		   "zong"=>$five 
		);
		echo json_encode($returnArr);
	}


	//订单状态
	public function orders_state(){
		$user_id = $_REQUEST['user_id']; 
		$page = $_REQUEST['page'];
    	$pagecount = $_REQUEST['pagecount'];
		$status = $_REQUEST['status'];//0代付款，1待发货，2待收货，3已完成，4订单关闭  
    	
    	if($page == null||$page<0){ 
            $page=0;
        }
         
        if($pagecount == null||$pagecount<=0){  
            $pagecount=10;   
        }
        $shoupagecount = $page*$pagecount;
		$Model = M();    
		$daifuorders = $Model->Query("SELECT id,number,totalprice,status FROM orders WHERE state=1 AND user_id=".$user_id." AND status=".$status." ORDER BY addtime desc limit ".$shoupagecount.",".$pagecount.";");  
		// echo $Model->_sql();die;
		foreach ($daifuorders as $key => $value) { 
		   $daifugoods = $Model->Query("SELECT goods_img,goodname,price,sku_path,goods_num FROM ordersitem WHERE orders_id=".$value['id']." limit 1;");  
		   $daifuorders[$key]['goodfirst'] = $daifugoods;
		}
		$daifuorders = array($daifuorders);
		echo getSuccessJson($daifuorders,'操作成功');  
	} 

	//获得所有订单
	public function allorderlist(){ 
		$user_id = $_REQUEST['user_id'];
		$page = $_REQUEST['page'];
    	$pagecount = $_REQUEST['pagecount'];

    	if($page == null||$page<0){
            $page=0;
        }
         
        if($pagecount == null||$pagecount<=0){    
            $pagecount=10;
        }
        $shoupagecount = $page*$pagecount; 
        $Model = M();   
		$daifuorders = $Model->Query("SELECT id,number,totalprice,status,yunfarefee,addtime FROM orders  WHERE state=1 AND user_id=".$user_id." ORDER BY addtime desc limit ".$shoupagecount.",".$pagecount.";");   
		foreach ($daifuorders as $key => $value) {       
		   $daifugoods = $Model->Query("SELECT goods_img,goodname,price,sku_path,goods_num,(price*goods_num) as pergoods_total FROM ordersitem WHERE orders_id=".$value['id']." limit 1;");  
		   $daifuorders[$key]['goodfirst'] = $daifugoods; 
		} 
		$daifuorders = array($daifuorders); 
		echo getSuccessJson($daifuorders,'操作成功'); 
	}

	//获取订单详情
	 //获取订单详情
    public function getOrderDetail(){  
        $ordersid = $_REQUEST['ordersid'];    
        $Model = M();     
        $orders = $Model->Query("select id,number,address_id,address_detail,status,totalprice,yunfarefee,addtime from orders where id=".$ordersid."");  
        $resultArray = $Model->Query("select goods_img,(price*goods_num) as money,goodname,goods_num,sku_path,id as orderitem_id,goods_id as good_id from ordersitem where orders_id=".$orders[0]['id'].""); 
        $address_detail = $Model->Query("SELECT * FROM user_address WHERE id=".$orders[0]['address_id'].";");
        $resultArr = array(   
            "number"=>$orders[0]['number'],   
            "address"=>$orders[0]['address_detail'],   
            "totalprice"=>$orders[0]['totalprice'], 
            "yunfarefee"=>$orders[0]['yunfarefee'],  
            "addtime"=>$orders[0]['addtime'],   
            "time"=>date('Y-m-d H:i:s'),   
            "status"=>$orders[0]['status'],
            "address_detail"=>$address_detail, 
            "goodList"=>$resultArray
        ); 
        $resultArr = array($resultArr);
        echo getSuccessJson($resultArr,'操作成功');
    }


    //获取快递信息 
    public function getkuaidi(){
    	//$postid = $_REQUEST['postid']; 
    	//$type = $_REQUEST['type'];//快递公司名称
    	$url = "https://m.kuaidi100.com/index_all.html?type=yunda&postid=3101449726243#resultArr";
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL,$url); 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//请求协议
		$response = curl_exec($ch);
		curl_close($ch); 
    	echo($response);  
    } 

    public function ceshi(){
			// $url = "http://m.kuaidi100.com/index_all.html?type=yunda&postid=3101449726243";//

		$url = "https://m.kuaidi100.com/index_all.html?type=yunda&postid=3101449726243";
		$handle = fopen($url, "rb"); 
$contents = stream_get_contents($handle); 
fclose($handle); 
echo $contents;
    } 






 	public function kill_orders(){

        $start_time = microtime(true); 

 		$Model = M(); 
 		$kill_orders = $Model->Query("SELECT id FROM orders WHERE UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(`addtime`)>=86400 AND state=1 AND status=0;");//status=0待付款 
 		foreach($kill_orders as $key=>$value){ 
 			$ordersitem = $Model->Query("SELECT id,goods_id,sku_id,goods_num FROM ordersitem WHERE orders_id=".$value['id'].";");
 			         foreach ($ordersitem as $k => $v) {  
		 				 if(!empty($v['sku_id'])){
		 				 	//sku_id不空就是要把库存加回去
		 				 	$Model->execute("UPDATE goods_sku SET `kucun`=`kucun`+".$v['goods_num']." WHERE id=".$v['sku_id'].";");
		 				 }else{
		 				 	$Model->execute("UPDATE goods SET `kucun`=`kucun`+".$v['goods_num']." WHERE id=".$v['goods_id'].";");
		 				 }
		 				 $Model->execute("DELETE FROM ordersitem WHERE id=".$v['id'].";");//删除订单详细列表的商品
 			        }
 			$Model->execute("DELETE FROM orders WHERE id=".$value['id'].";"); //删除订单表  
 		}     
 		$this->delgroupredpacket();
		$end_time = microtime(true);  
		$data = date('Y-m-d H:i:s').'循环执行时间为：'.($end_time-$start_time).' s';
		$fp = fopen('echotime.txt','a+');
		fwrite($fp,$data."\r\n");
		fclose($fp);
 	}

 	//删除一定期间红包未组团成功的 
 	public  function delgroupredpacket(){
 		$Model = M();
 		$data = $Model->Query("SELECT t1.id FROM redpacket t inner join group_redpacket t1 ON t.id=t1.redpack_id WHERE t1.type=0 and t1.addtime>(NOW() - INTERVAL 240 HOUR);");//自领取日起，如果没在5天内集齐人数开红包团
 		foreach ($data as $k => $val) {
 			del("group_redpacket_lst","group_redpacket_id=".$val['id']);
 			del("group_redpacket","id=".$val['id']);
 		}
 	}
 

}

?>