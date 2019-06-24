<?php
namespace Home\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class ChongzhiController extends Controller {

  //主页
  public function index(){
    $a=session('user_id');
    $arr=M('user')->find($a);
    // var_dump(session('user_id'));
    $this->assign('s',$arr['money']);
    $this->display();
  }

    //投资项目首页
  public function touzi(){
    $a['edu']=0;
  	$arr=M('xiangmu')->where($a)->select();

     $b['edu']=1;
    $info=M('xiangmu')->where($b)->select();

  
    $this->assign('info',$info);
  	$this->assign('arr',$arr);
    $this->display();
  }

   public function touzia(){
    $a['edu']=0;
    $arr=M('xiangmu')->where($a)->select();

     $b['edu']=1;
    $info=M('xiangmu')->where($b)->select();

  
    $this->assign('info',$info);
    $this->assign('arr',$arr);
    $this->display();
  }
      //项目详情首页
  public function xiangmuxiangqing(){
  	if(IS_GET){

  		$a['xiangmu_id']=I('xiangmu_id');
  		$arr=M('xiangmu')->find(I('xiangmu_id'));
  		if($arr['edu']==1){
  			$arr['xianshi']='该项目已满额';
  		}

  		$info=M('zongshouyi')->where($a)->order('id desc')->select();
  		foreach ($info as $k => $v) {
  			$z[]=$v['zongshouyi'];
        $info[$k]['time']=substr($v['time'],0,10);
  		}
  			
  		$zong=array_sum($z);

      //百分比
      $bai=$arr['yitouzi']/$arr['zonge']*100;

  		$this->assign('z',$zong);
  		$this->assign('arr',$info);
      $this->assign('bai',$bai);
  		$this->assign('v',$arr);	
  	}

     if(session('user_id')==NULL){
      $a="/moneys/index.php/Home/Login/login.html";
    }else{
      $a="/moneys/index.php/Home/Chongzhi/woyaotou.html";
    }

  	$this->assign('a',$a);
    $this->display();
  }

      //项目详情首页
  public function woyaotou(){

    if(session('yanzheng')<3){
      echo '<script>alert("请先实名认证");location.href="/moneys/index.php/Home/User/renzheng.html"</script>';die;
    }

  	$arr=M("xiangmu")->find(I('xiangmu_id'));
  	if($arr['edu']==1){
  		echo '<script>alert("该项目已满额，请选择其他项目投资");location.href="touzi"</script>';die;
  	}
    $a=session('user_id');
    $info=M('user')->find( $a);
    // var_dump($info);
      $hetong=M('hetong')->find(1);
    $this->assign('hetong',$hetong); 
    $this->assign('s',$info['money']);
  	$this->assign('v',$arr);
    $this->display();
  }

      //利息详情
  public function lixi(){
      $a['user_id']=session('user_id');
       
      $info=M('user')->where($a)->find();
      $arr=M('user_lixi')->where($a)->select();
      foreach ($arr as $k => $v) {
        $sy[]=$v['shouyi'];
        $arr[$k]['time']=substr($v['time'],0,10);
      }
        $shouyi=array_sum($sy);
       
      
    $this->assign('shouyi',$shouyi); 

    $this->assign('arr',$arr);
    $this->assign('s',$info); 
    $this->display();
  }

  //充值
  public function czhou(){
  	// var_dump(I());
  	if(IS_POST){
  		if(empty($_POST['chongzhi'])){
	  		echo '<script>alert("投资失败：请填写金额");location.href="index"</script>';die;
	  	}

   		$a=session('user_id');
      $arr=M('user')->find($a);
      $b['money']=I('chongzhi');

      if($arr['money']<$b['money']){

        echo '<script>alert("投资失败：余额不足");location.href="index"</script>';die;
      }

  		$b['xiangmu_id']=I('id');
      $b['user_id']=$arr['user_id'];
  		M('touzishenqing')->add($b);


  	}
  	



    $this->display();
  }

  //充值
  public function chongzhihou(){
    
    if(IS_POST){

      if(empty($_POST['chongzhi'])){
        echo '<script>alert("请填写金额");location.href="chongzhi"</script>';die;
      }

      $a['user_id']=session('user_id');
      $a['chongzhi']=$_POST['chongzhi'];
       $a['shijian']=$_POST['shijian'];
      $arr=M('chongzhi')->add($a);
     


    }
    



    $this->display();
  }
  
  

  
}