<?php
namespace Home\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class ShouyiController extends Controller {

  //用户主页
  public function index(){

    //用户信息
  	$a['user_id']=session('user_id');
  	$user=M('user')->where($a)->find();
    if($user==null){
      echo '<script>alert("账号已过期,请重新登录");location.href="/money/index.php/Home/Login/login.html"</script>';die;
    }
    $mon=$user['money'];
  	 // var_dump($mon);
    $arr=M('shouyi')->where($a)->select();
    //用户收益信息
    foreach ($arr as $k => $v){
        $c['xiangmu_id']=$v['xiangmu_id'];
        $arr2=M('xiangmu')->where($c)->find();
        $arr[$k]['xiangmu_id']=$arr2['xiangmu'];

        $d[]=$v['shouyi'];

        $stas=substr($v['time'],0,10);
        if($stas==date('Y-m-d')){
          $stass[]=$v['shouyi'];

        }
    }

     //当天投资收益和
    $syjin=array_sum($stass);
    // var_dump( $syjin);
    //分红总和
    $lixi=M('user_lixi')->where($a)->select();
      foreach ($lixi as $l => $x) {
        $lx[]=$x['shouyi'];

        $stat=substr($x['time'],0,10);
        if($stat==date('Y-m-d')){
          $lxjin=$x['shouyi'];
        }

      }
    $lixi=array_sum($lx);

    //当天分红
    // var_dump($lxjin);

     //团体总和
    $tuanti=M('tuanti')->where($a)->select();
      foreach ($tuanti as $t => $u) {
        $tut[]=$u['shouyi'];
        $sta=substr($u['time'],0,10);
        if($sta==date('Y-m-d')){
          $ttjin[]=$u['shouyi'];

        }
      }
    $tt=array_sum($tut);

     //当天团体收益和
    $tjin=array_sum($ttjin);
     // var_dump($tjin);


      //计算用户投资总收益
      $sum=array_sum($d);

    $info=M('tuanti')->where($a)->select();
    //用户收益信息
    foreach ($info as $k => $s){

        $t[]=$s['shouyi'];
    }
       //计算团体收益
      $st=array_sum($t);

      //当天所有收益
      $szong=$tjin+$lxjin+ $syjin;
      session('szong',$szong);
      $syzong= session('szong');
      // var_dump($syzong);
      // $a=date('Y-m-d');
      // $fff=str_split($ttt,10)[0];
      //     var_dump( $fff);
      // var_dump($s);die;
      $this->assign('dang',$syzong);
     $this->assign('shouyi',$user['shouyi']);
     $this->assign('tt', $tt);
    $this->assign('t', $st);
    $this->assign('q', $sum);
    $this->assign('money',$mon);
    $this->assign('arr',$arr);
    $this->display();
  }


  //项目收益详情
  public function xiangmujin(){
     $a['xiangmu']=I('xiangmu_id');
     $s=M('xiangmu')->where($a)->find();
     // var_dump($arr)
     $b['xiangmu_id']=$s['xiangmu_id'];
     $b['user_id']=I('id');
     $arr=M('shouyi')->where($b)->order('id desc')->select();
       // var_dump($arr);
     foreach ($arr as $k => $v) {
        $sum[]=$v['shouyi'];
        $arr[$k]['time']=substr($v['time'],0,10);
     }

     $mon=array_sum($sum);


     $this->assign('mon',$mon);
    $this->assign('arr',$arr);
    $this->assign('s',$s);
    $this->display();
  }


  //投资收益
  // public function tzshouyi(){
  //   $u['user_id']=session('user_id');
  //   $s=M('user')->where($u)->find();
  //   $info=M('shouyi')->where($u)->order('id desc')->select();
  //   foreach ($info as $k => $v) {
  //     $xx[]=$v['shouyi'];
  //     $m['xiangmu_id']=$v['xiangmu_id'];
  //     $arr=M('xiangmu')->where($m)->find();
  //     $info[$k]['xiangmu_id']=$arr['xiangmu'];
  //     $info[$k]['time']=substr($v['time'],0,10);
  //   }
  //   $x=array_sum($xx);
  //   $this->assign('info',$info);
  //   $this->assign('shouyi',$x);
  //   $this->assign('s',$s);
  //   $this->display();
  // }


  public function tzshouyi(){
    $a['user_id']=session('user_id');
    $info=M('touzi')->where($a)->select();
    foreach ($info as $k => $v) {
      $arr=M('xiangmu')->find($v['xiangmu_id']);
      $info[$k]['xiangmu']=$arr['xiangmu'];
      $info[$k]['images']=$arr['images'];
      $info[$k]['yitouzi']=$arr['zonge'];
      $info[$k]['zonge']=$arr['zonge'];
      $info[$k]['sum']=$arr['xiaoyi'];
      $info[$k]['yitou']=$arr['yitouzi'];
      $info[$k]['edu']=$arr['edu'];
    }


    $this->assign('arr',$info);
    $this->display();

  }






  public function xiangmuxiangqing(){
    if(IS_GET){

      $a['xiangmu_id']=I('xiangmu_id');
      $a['user_id']=session('user_id');
      $arr=M('xiangmu')->find(I('xiangmu_id'));
      if($arr['edu']==1){
        $arr['xianshi']='该项目已满额';
      }

      $info=M('shouyi')->where($a)->order('id desc')->select();
      foreach ($info as $k => $v) {
        $z[]=$v['shouyi'];
        $info[$k]['time']=substr($v['time'],0,10);
      }

      $zong=array_sum($z);

      $this->assign('z',$zong);
      $this->assign('arr',$info);
      $this->assign('v',$arr);
    }

     if(session('user_id')==NULL){
      $a="/money/index.php/Home/Login/zhuce.html";
    }else{
      $a="/money/index.php/Home/Shouyi/woyaotou.html";
    }

    $this->assign('a',$a);
    $this->display();
  }

  public function woyaotou(){
    $arr=M("xiangmu")->find(I('xiangmu_id'));
    if($arr['edu']==1){
      echo '<script>alert("该项目已满额，请选择其他项目投资");location.href="tzshouyi"</script>';die;
    }
    $a=session('user_id');
    $info=M('user')->find( $a);
    // var_dump($info);
    $this->assign('s',$info['money']);
    $this->assign('v',$arr);
    $this->display();
  }
}
