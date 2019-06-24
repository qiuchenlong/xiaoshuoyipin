<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
class ShopController extends Controller{   
	
	//商家购买的应用模块
	public function getmodule(){
		$appid = $_REQUEST['appid'];
		$Model = M();
		$data = $Model->Query("SELECT t1.temp FROM shop_module t INNER JOIN module t1 ON t.module_id=t1.id WHERE t.wxshop_appid='".$appid."' AND t.deitime>unix_timestamp(now());"); 
		$data = array($data);
		echo getSuccessJson($data,'操作成功');  
	} 

  

	//商家信息
	public function getlocation(){ 
		$appid = $_REQUEST['appid'];  
		$Model = M();
		$data = $Model->Query("SELECT * FROM shop_system WHERE wxshop_appid='".$appid."';");
		echo getSuccessJson($data,'操作成功');   
	}
 
	// public function getdu(){
	// 	$appid = $_REQUEST['appid'];   
	// 	$Model = M();
	// 	$data = $Model->Query("SELECT * FROM shop_system WHERE wxshop_appid='".$appid."';");
	// 	echo getSuccessJson($data,'操作成功'); 
	// }




}


?>