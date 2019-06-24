<?php
namespace Home\Controller;
use Think\Controller;
include_once('Common.php');
class GoodsController extends Controller{
	
	/*
	**根据商家小程序的appid来筛选属于自己商家的商品
	**@参数 小程序appid
	 */
	public function goodslst(){ 
		$appid = $_REQUEST['appid']; 
		$Model = M();
		$data = $Model->Query("SELECT id,mastersumbimage,name,price,summary FROM goods WHERE xiajia=1 AND wxshop_appid='".$appid."';");//下架后的商品不显示出来
		$data = array($data);
		echo getSuccessJson($data);    
	} 

	/*
	**商品详情
	**@参数 小程序appid   
	 */
	public function goodsdetail(){  
		$goodsid = $_REQUEST['goodsid'];//商品表id  
		$Model = M();
		$data = $Model->Query("SELECT * FROM goods WHERE id=".$goodsid." AND xiajia=1;");
		echo getSuccessJson($data); 
	}

	/*
	**根据商品名搜索
	** @参数商品字段 name keywords 
	** @参数 小程序appid
	 */
	public function sosuo(){
		$keywords = $_REQUEST['keywords'];
		$appid = $_REQUEST['appid'];
		$Model = M();
		$data = $Model->Query("SELECT id,mastersumbimage,name,price,summary FROM goods WHERE xiajia=1 AND wxshop_appid='".$appid."' AND name like '%".$keywords."%';"); 
		$data = array($data); 
		echo getSuccessJson($data); 
	}




	/*
	*根据商品id搜索
	*@参数 商品id  goodsid
	 */
	public function guige_lst(){
		$Model = M();
		$goodsid = $_REQUEST['goodsid'];
		$resultArr = array();
		$attr_key = $Model->Query("SELECT name,id FROM good_attr_key WHERE goods_id=".$goodsid.";");//先查属于商品的属性
		foreach ($attr_key as $key => $value) {
			//查属性下的规格
			$obj['name'] = $value['name'];
			$obj['list'] = $Model->Query("SELECT id,name FROM good_attr_value WHERE attr_key_id=".$value['id'].";");
			array_push($resultArr,$obj);
		}
		$resultArr = array($resultArr);
		echo getSuccessJson($resultArr); 
	}

	/* 
	*根据规格id查询商品价格和库存
	*@参数 商品的规格字符串，格式是英文逗号隔开 
	 */
	public function get_price_kucun(){   
		$Model = M(); 
		$sku_path = $_REQUEST['sku_path']; 
		$data = $Model->Query("SELECT id,price,kucun FROM goods_sku WHERE attr_value_path='".$sku_path."';");
		if($data[0]['price']!=''){
			$result = array("code"=>200,'result'=>$data);
		}else{ 
			$result = array("code"=>201,"result"=>"查询不到改商品价格,请选择其他规格！");
		}
		$this->ajaxReturn($result);
	}



	/************一级二级分类******************/
     /*
	**商品一级和二级分类
	**@参数 小程序appid
	 */
	public function getAll(){
	     // $user_id = $_REQUEST['user_id'];
	     $keywords = $_REQUEST['keywords'];
	     $appid = $_REQUEST['appid']; 
		 $Model = M(); 
		 $returnArr = array(); 
		 $classifyList = $Model->Query("select name,id from classify WHERE wxshop_appid='".$appid."' order by sort;");
		 
		 for($i=0;$i<sizeof($classifyList);$i++){
			$obj['name'] = $classifyList[$i]['name'];
			$obj['classify_id'] = $classifyList[$i]['id']; 
			if($keywords==''){
			$obj['list'] = $Model->Query("select * from categorys where classify_id=".$classifyList[$i]['id'].""); 
			}
			array_push($returnArr,$obj);
		 }
		 if($keywords!=''){  
			 $sosuo = $Model->Query("select * from categorys where name like '%".$keywords."%';"); 
		 }  
		 $returnArr = array('code'=>200,'result'=>$returnArr,'sosuo'=>$sosuo);
		 $this->ajaxReturn($returnArr); 
	}


	/*
	**商品二级分类
	**@参数 小程序appid
	 */
	public function catelst(){
		$appid = $_REQUEST['appid'];  
		$Model = M(); 
		$data = $Model->Query("SELECT * FROM categorys WHERE wxshop_appid='".$appid."';");
		$data = array($data);
		echo getSuccessJson($data);
	}

	/*
	**根据商品分类搜索出商品  
	**@参数 小程序appid
	 */
	public function searchgoods(){
		$cateid = $_REQUEST['cateid']; 
		$Model = M();
		$data = $Model->Query("SELECT id,mastersumbimage,name,price,summary FROM goods WHERE categorys_id=".$cateid.";");
		$data = array($data);
		echo getSuccessJson($data);
	}


}

?>