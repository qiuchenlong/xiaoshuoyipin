<?php
namespace Home\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class TixianController extends Controller {


  //提现主页
  public function index(){
      if(session('yanzheng')<3){
        echo '<script>alert("提现需要实名认证，请先进行实名认证");location.href="/moneys/index.php/Home/User/index"</script>';die;
      }

       //查询用户是否在提现申请单
    $b['user_id']=session('user_id');
    $b['chuli']=0;
    $tixian=M('tixian')->where($b)->find();
    if($tixian>0){
      echo '<script>alert("上一笔提现正在处理中,请不要重复提交");location.href="/moneys/index.php/Home/User/index"</script>';die;
    }
    
      
    //查出用户的余额
    $a['user_id']=session('user_id');
    $v=M('user')->where($a)->find();
    $this->assign('y',$v);
    $this->display();
  }

   public function txhou(){


        //查询用户是否在提现申请单
    $b['user_id']=session('user_id');
    $b['chuli']=0;
    $tixian=M('tixian')->where($b)->find();
    if($tixian>0){
      echo '<script>alert("上一笔提现正在处理中,请不要重复提交");location.href="/moneys/index.php/Home/User/index"</script>';die;
    }


    if(IS_POST){

       $a['user_id']=session('user_id');
        $v=M('user')->where($a)->find();
       
          // var_dump(I());die;
     

       if(empty($_POST['tixian']) ){

        echo '<script>alert("请填写金额");location.href="index"</script>';die;
      }

      if(empty($_POST['zhanghu'])  ){

        echo '<script>alert("请填写账户名");location.href="index"</script>';die;
      }
      //  if(empty($_POST['images'])  ){

      //   echo '<script>alert("请上传二维码");location.href="index"</script>';die;
      // }

       // //上传图片
       //      $upload = new \Think\Upload();// 实例化上传类
       //      $upload->maxSize   =     3145728 ;// 设置附件上传大小
       //      $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
       //      $upload->rootPath  =     'Public/images/'; // 设置附件上传根目录
       //      $upload->savePath  =     ''; // 设置附件上传（子）目录
       //      // 上传文件 
       //      $info   =   $upload->upload();
       //      if(!$info) {// 上传错误提示错误信息
       //          $this->error($upload->getError()); die;
       //      }else{// 上传成功
       //          // $this->success('上传成功！'); 
       //          $a['images']=$info['images']['savename'];
       //      }

      $a['user_id']=session('user_id');
      if($_POST['lei']==0){
        $shouyi=M('user')->find($a['user_id']);
        if($shouyi['shouyi']<$_POST['tixian']){
             echo '<script>alert("收益金额不足,请填写正确的金额");location.href="index"</script>';die;
        }
      }else{
        $shouyi=M('user')->find($a['user_id']);
        if($shouyi['money']<$_POST['tixian']){
             echo '<script>alert("本金余额不足,请填写正确的金额");location.href="index"</script>';die;
        }
      }
      $a['tixian']=$_POST['tixian'];
      $a['zhanghu']=$_POST['zhanghu'];
      $a['kouchu']=$_POST['tixian']*0.8;
      $a['zhifu']=$_POST['zhifu'];
      $a['lei']=$_POST['lei'];
     // var_dump($a);die;

      $arr=M('tixian')->add($a);

      if ($_POST!==null) {
              $_POST = array();
      }
    }
 
     $this->display();
   }

  
   public function receipt(){
      $user=M('user')->find(session('user_id'));
       // var_dump($user);die;
      if($user['weiimg']!==null){
          $weixin=1;

      }else{
         $weixin=0;
      }

      if($user['zhiimg']!==null){
        $zhifubao=1;
      }else{
         $zhifubao=0;
      }


      // var_dump($zhifubao);die;
      $this->assign('w',$weixin);
      $this->assign('z',$zhifubao);
      $this->assign('user',$user);
      $this->display();
        
        
         
   }

   public function zhifubao(){
     
        if(IS_POST){
           //上传图片
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     'Public/images/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传文件 
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError()); die;
            }else{// 上传成功
                // $this->success('上传成功！'); 
                $zm='images/'.$info['zhiimg']['savename'];
            }
            // var_dump($zm);die;
            $a['user_id']=session('user_id');
            $a['zhiname']=I('zhiname');
            $a['zhihao']=I('zhihao');
            $a['zhiimg']=$zm;
            $add=M('user')->save($a);

            if($add>0){
                 echo '<script>alert("微信二维码添加成功");location.href="receipt"</script>';die;
            }

        }
        
         
   }

   public function weixin(){
     
        if(IS_POST){
           //上传图片
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     'Public/images/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传文件 
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError()); die;
            }else{// 上传成功
                // $this->success('上传成功！'); 
                $zm='images/'.$info['weiimg']['savename'];
            }
            // var_dump($zm);die;
            $a['user_id']=session('user_id');
            $a['weiname']=I('weiname');
            $a['weihao']=I('weihao');
            $a['weiimg']=$zm;
            $add=M('user')->save($a);

            if($add>0){
                 echo '<script>alert("支付宝二维码添加成功");location.href="receipt"</script>';die;
            }

        }
        
         
   }

   //收益转换成本金
   public function transition(){
      $user=M('user')->find(session('user_id'));
      // var_dump($user['shouyi']);die;
      if(IS_POST){
        if(I('tixian')>$user['shouyi']){
            echo '<script>alert("可装换收益不足,请填写正确的金额");location.href="transition"</script>';die;
        }else{
            $u['user_id']=session('user_id');
            $u['money']=$user['money']+I('tixian')*0.8;
            $u['shouyi']=$user['shouyi']-I('tixian');
            if($u['shouyi']<0){
               echo '<script>alert("可装换收益不足,请填写正确的金额");location.href="transition"</script>';die;
            }
            $zhuan=M('user')->save($u);
            if($zhuan>0){
              //流水
              $liu['user_id']=session('user_id');
              $liu['shijian']='收益转换成本金';
              $liu['benjin']='+'.I('tixian')*0.8;
              $liu['shouyi']='-'.I('tixian');
              M('liushui')->add($liu);
               echo '<script>alert("转换成功");location.href="transition"</script>';die;
            }
        }
      }

      $this->assign('w',$weixin);
      $this->assign('z',$zhifubao);
      $this->assign('shouyi',$user['shouyi']);  //可转换的收益
      $this->display();
   }

  
}