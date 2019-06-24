<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller{ 

	//检测登录方是否登录或（未实现）
	public function _initialize(){   
		 $login_user = session('aid');
		 if($login_user == ''){
		 	$this->redirect('Admin/Login/login');
		 }  
		// // 在登陆后的页面判断:
		// $online_time=time(); //记录当前时间
		// if($online_time-session('login_time')>20){ //判断是否超过600秒
		// // 执行 退出页面操作(代码自己写)
		// 	session_destroy();
		// 	header(U('Login/index'));
		// } else {
		// 	$time=time()
		// 	session('login_time',$time); //如果进行了操作，更新时间
		// }
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