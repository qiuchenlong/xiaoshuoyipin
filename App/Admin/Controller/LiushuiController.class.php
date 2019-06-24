<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class LiushuiController extends CommonController {
    public function index(){
        //遍历管理员名单
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['title'] = array('like', "%$con%");
            $arr=M('zhishi')->where($data)->select();
            
            
           
            $this->assign('arr',$arr);
            $this->display(); 
        }else{
            //查询数据并分页
            $model =M("liushui");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            $btn = $page->show();

            foreach ($arr as $k=> $v) {
              $sql=M('user')->find($v['user_id']);
              $arr[$k]['user_id']=$sql['name'];
            }
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        }
        
    }

   

}
