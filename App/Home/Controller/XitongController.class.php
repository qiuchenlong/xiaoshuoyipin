<?php
namespace Home\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class XitongController extends Controller {

  //主页
  public function index(){

   $this->display();
  }

  //充值后
  public function kefu(){
  	$arr=M('xitong')->find();
  	// var_dump($arr);
  	$this->assign('v',$arr);
   $this->display();
  }

  

  
}