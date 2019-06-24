<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
header("Content-Type:text/html; charset=utf-8");

class ClassifyController extends Controller {

	//获取所有分类
	public function getAll(){ 
	     // $user_id = $_REQUEST['user_id'];
	     $keywords = $_REQUEST['keywords']; 
		 $Model = M();
		 // $classify = $Model->Query("select classify from user where user_id=".$user_id."");
		 // $classify = $classify[0]['classify'];
		 
		 // $classify = explode(',',$classify);
		 // $where = "";
		 // for($i=0;$i<sizeof($classify);$i++){
			 
			//  if($i == 0){
			//      $where.="classify_id = ".$classify[$i]."";
			//  }else{
			// 	 $where.="or classify_id = ".$classify[$i]."";
			//  }
		 // }
		 $returnArr = array(); 
		 $classifyList = $Model->Query("select name,classify_id from hb_classify order by sort;");
		 
		 for($i=0;$i<sizeof($classifyList);$i++){
			$obj['name'] = $classifyList[$i]['name'];
			$obj['classify_id'] = $classifyList[$i]['classify_id'];
			if($keywords==''){
			$obj['list'] = $Model->Query("select * from hb_seclassify where classify_id=".$classifyList[$i]['classify_id'].""); 
			}
			array_push($returnArr,$obj);
		 }
		 if($keywords!=''){ 
			 $sosuo = $Model->Query("select * from hb_seclassify where name like '%".$keywords."%';"); 
		 }  
		 $returnArr = array('code'=>200,'result'=>$returnArr,'sosuo'=>$sosuo);
		 $this->ajaxReturn($returnArr);
		 // echo getSuccessJson($returnArr);  
	}
	
	//获取主分类的子分类
	public function getSonAll(){
		$classify_id = $_REQUEST['classify_id'];
		$Model = M();
		$result = $Model->Query("select * from hb_seclassify where classify_id=".$classify_id."");
		$returnArr = array($result); 
		echo getSuccessJson($returnArr);
	}
	
	//获取所有的主分类
	public function getParentAll(){
		$Model = M();
		$result = $Model->Query("select * from hb_classify");
		$returnArr = array($result);
		echo getSuccessJson($returnArr);
	}

//获取所有的子分类
	public function getAllSon(){
		$classify_id = $_REQUEST['classify_id'];
		$Model = M();
		$result = $Model->Query("select * from hb_seclassify ");
		$returnArr = array($result); 
		echo getSuccessJson($returnArr);
	}
	


}