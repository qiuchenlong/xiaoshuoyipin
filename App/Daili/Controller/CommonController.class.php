<?php
namespace Daili\Controller;
use Think\Controller;

class CommonController extends Controller{ 

	//检测登录方是否登录或（未实现）
	public function _initialize(){   
		 $login_user = session('name');
		 $login_uid = session('user_id');
		 if($login_user == ''||$login_uid == ''){
		 	$this->redirect('Daili/Login/login');
		 }  

		 // //管理员信息  
		 // $Model = M();
		 // $user = $Model->Query("SELECT phone FROM k_admin WHERE id=".$login_user.";");
		 // $this->phone = $user[0]['phone'];  
		 // }
	
}

	// //ajax删除图 
 //     public	function deleteImage(){      
	// 		// 先取出图片所在目录
	// 		$images = $_REQUEST['images'];
	// 		$root = C('IMG_rootPath'); 
	// 		$imgpath = $root.$images;
	// 		if(unlink($imgpath)){ 
	// 		$result = array('state'=>1,'msg'=>'删除成功'); 
	// 		}else{
	// 		$result = array('state'=>0,'msg'=>'删除失败'); 
	// 		}
	// 		$this->ajaxReturn($result);
	// 	}


		//查询授权方的appid
		// public function getappid(){
		// 	$admin_id = session('admin_user_info');
		// 	$Model = M(); 
		// 	$shopappid = $Model->Query("SELECT auth_appid FROM wxshop WHERE admin_id=".$admin_id.";");//二维数组
		// 	$appid = $shopappid[0]['auth_appid']; 
		// 	if($appid!=''){
		// 		return $appid; 
		// 	}else{ 
		// 		return false; 
		// 	}

		// }



}

?>