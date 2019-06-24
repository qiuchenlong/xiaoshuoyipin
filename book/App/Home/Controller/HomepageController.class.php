<?php
namespace Home\Controller;
use Think\Controller;
include_once('Common.php');
class HomepageController extends Controller{

	//首页模块列表
	public function model_lst(){
		$appid = $_REQUEST['appid'];
		$Model = M(); 
		$returnArr = array(); 
		$data = $Model->Query("SELECT t.id,t.sort,t1.name,t1.sortArr FROM shophome_page t LEFT JOIN home_page t1 ON t.homepage_id=t1.id WHERE t.wxshop_appid='".$appid."' AND display=1 ORDER BY t.sort;");//获得模块id
		foreach ($data as $key => $value) { 
			$obj['model_name'] = $value['name'];
			$obj['sortArr'] = $value['sortArr'];  
			$obj['paixu'] = $value['sort'];  
			$obj['list'] = $Model->Query("SELECT t1.id,t1.name,t1.summary,t1.price,t1.masterimage,t1.mastersumbimage FROM homepage_goods t INNER JOIN goods t1 ON t.goods_id=t1.id WHERE t1.xiajia=1 AND t.shophome_page_id=".$value['id'].";");
			array_push($returnArr,$obj); 
		}
		$returnArr = array($returnArr);  
		echo getSuccessJson($returnArr);  
	}
}


?>