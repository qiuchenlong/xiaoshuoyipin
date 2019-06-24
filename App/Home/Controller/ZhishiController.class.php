<?php
namespace Home\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class ZhishiController extends Controller {
    public function index(){
    //知识
    $zhishi=M('zhishi')->order("id desc")->select();
    $this->assign('zhishi',$zhishi);



    $this->display();
  }


  public function detail(){

    if(IS_GET){
    	$zhishi=M('zhishi')->find(I('id'));
   		 // var_dump($zhishi);
      $a['liulan']=$zhishi['liulan']+1;
      $a['id']=I('id');
      M('zhishi')->save($a);
    	if (count($_GET) > 0) { unset($_GET);}
    	$this->assign('zhishi',$zhishi);
    	


    }
    



    $this->display();
  }



}
