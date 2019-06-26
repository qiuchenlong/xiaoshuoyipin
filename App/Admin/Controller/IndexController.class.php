<?php
namespace Admin\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class IndexController extends CommonController {
   /**
    * 主页 
    * ================   
    * @AuthorHTL
    * @DateTime  2017-04-14T21:15:40+0800 
    * ================ 
    * @return    [type]                   [description]
    */



    public function index(){
        // $wxshop_appid = $this->getappid();
        //每日订单
        $fu['state']=1;
        $con=date('Y-m-d');
        $fu['addtime'] = array('like', "%$con%");
        $dingdan=M('orders')->where($fu)->select();
        foreach ($dingdan as $k => $v) {
          $risum[]=$v['allprice'];
        }
          $ri=array_sum($risum);  

         //每月订单
        $fu1['state']=1;
        $con1=date('Y-m');
        $fu1['addtime'] = array('like', "%$con1%");
        $dingdan1=M('orders')->where($fu1)->select();
        foreach ($dingdan1 as $k1 => $v1) {
          $risum1[]=$v1['allprice'];
        }
          $yue=array_sum($risum1);  
    
        $this->assign('ri',$ri);
        $this->assign('yue',$yue);
        // $this->assign('goods',$goods); 
        $this->display();

    }

    //账号退出
    public function tuichu(){
        session_destroy();
        $this->success("退出成功",U('/Admin/Login/login'));
    }

   //公用头部模版
    public function header(){
    	$this->display();
    }

    //公用底部模版
    public function footer(){
    	$this->display();
    }

    // 左侧列表
    public function leftmenu(){
    	$this->display();
    }

    //修改密码
    public function editpass(){
        
    }
}