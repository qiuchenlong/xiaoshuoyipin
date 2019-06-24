<?php
namespace Daili\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class LoginController extends Controller{ 
	//后台登录
	public function login(){
		if(IS_POST){
     
        $b['mobile']=I('phone');
        $b['pass']=I('password');
        $b['lei']=1;
        $brr=M('jieqi_system_users')->where($b)->find();
        if($brr>0){
          
          session('name',$brr['mobile']);
          session('user_id',$brr['uid']);
          echo '<script>alert("登录成功");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Daili"</script>';
        }else{
          echo '<script>alert("账号密码错误或你没有权限");history.go(-1)</script>';
        }
      

		}else{
			$this->display();   
		}
	}

  

}



?>