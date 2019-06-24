<?php
namespace Home\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class HehuorenController extends Controller {

  //用户主页
  public function index(){

    $a['user_id']=session('user_id');
    $arr=M('user')->where($a)->find();
    // var_dump($arr);
    // if($arr==NULL){
    //   echo '<script>alert("投资项目后才能邀请伙伴");history.go(-1)</script>';die;
    // }
    if($arr['money']==0){
      echo '<script>alert("充值后才能邀请伙伴");history.go(-1)</script>';die;
    }
    
    $a['user_id']=session('user_id');
    $arr=M('xiaji')->where($a)->select();

      //查出下级
      foreach ($arr as $k => $v) {
        $b['user_id']=$v['xiaji_id'];
        $arr1=M('user')->where($b)->find();
        $arr[$k]['xiaji_id']=$arr1['name'];
        
      }

     $info=M('tuanti')->where($a)->order('id desc')->select();
      foreach ($info as $o => $p) {
        $r['user_id']=$p['xiaji_id'];
        $oop=M('user')->where($r)->find();
        $info[$o]['xiaji_id']=$oop['name'];
        $info[$o]['time']=substr($p['time'],0,10);
      }


        
    $this->assign('arr',$arr);
    $this->assign('info',$info);
    $this->display();
  }

 

 
  
}