<?php
namespace Admin\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class LoginController extends Controller{ 
	//后台登录
	public function login(){
		if(IS_POST){
      
			$a['name']=I('phone');
      $a['pass']=I('password');
      $arr=M('admin')->where($a)->find();
      if($arr>0){
        session('aid',$arr['id']);
        session('name',$arr['name']);
        session('guanli',$arr['name']);
        // $time=time();
        // session('login_time',$time);
        echo '<script>alert("登录成功");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Admin"</script>';
      }else{
        echo '<script>alert("账号密码错误");history.go(-1)</script>';
        
      }

		}else{
			$this->display();   
		}
	}

  

}



?>