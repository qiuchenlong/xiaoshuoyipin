<?php
namespace Admin\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class LoginController extends Controller{
    /**
     * dudj 后台登录改进
     */
	public function login(){
		if(IS_POST){
            $a['name']=I('phone');
            $a['pass']=I('password');
            $arr=M('admin')->where($a)->find();
            if($arr>0){
                session('user_id',$arr['id']);
                session('name',$arr['name']);
                $this->success("登录成功",U('/Admin/index'));
            }else{
                $this->error("账号密码错误");
            }
		}else{
			$this->display();   
		}
	}

  

}



?>