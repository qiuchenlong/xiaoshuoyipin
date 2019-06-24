<?php
namespace Home\Controller;
use Think\Controller;

class TestController extends Controller{
	public function test(){
                $Wxuser = M("wxshop");
                $extFilter = array();  

                $extFilter['auth_appid'] = "wx0ba806b9709f9b26";//授权方appid

                $isExt = $Wxuser->where($extFilter)->find();//查看是否已经存在这个公众号appid
                // echo session('admin_user_info').'<br/>';//能拿的到
                var_dump($isExt['admin_id']);  
		 
	} 

}   
?>    