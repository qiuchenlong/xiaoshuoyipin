<?php
namespace Home\Controller;
use Think\Controller;
header("content-type:text/html;charset=utf-8"); 
// Header("Content-type: application/octet-stream");
// Header("Accept-Ranges: bytes");
class ZhifuController extends Controller {

public function index(){

  if(IS_AJAX){
     $api_key='live_57d9d64eb483ebeb';                 //api秘钥
     $pm_id='';                                  //支付方式 必须按官网类型填写,否则无效
     $amount=I('id');                                     //金额
     $currency='USD';                                     //货币类型
     $order_id=123;                                  //订单号
     $secret_key='e1dc804aa722278fd860d26e5f19398d';      //秘钥

     $msg = implode('|',array($api_key,$amount,$currency,$order_id,$secret_key));

     $api_sig = md5($msg);

      $this->ajaxReturn($api_sig);
    }else{
      $this->display();
    }
  }

  public function zfhou()
  { 
     // session('user_id','83');
    if(IS_GET){
      $chong['price']=I('amt');
      $c=M('chongzhipath')->where($chong)->find();
      $chongzhi['orders']=I('tx');               //订单号
      $chongzhi['kanbi']=$c['egold'];                      //金额
      $chongzhi['uid']=I('item_name');
      $chongzhi['cid']=1;
      // var_dump($chongzhi);die;
        $arr=M('chongzhi')->where($chongzhi)->find();
          if($arr>0){
              
          }else{
              M('chongzhi')->add($chongzhi);
              $user=M('jieqi_system_users')->find(session('user_id'));
              $save['uid']=session('user_id');
              $save['egold']=$user['egold']+$c['egold'];
              $save['gcount']=$user['gcount']+$c['gcount'];
              M('jieqi_system_users')->save($save);
             
          }
    }
    $this->assign('v',$c['egold']);
    $this->assign('s',$c['gcount']);
    $this->display();
  }

   public function payssion()
  {
    // session('user_id','83');
    if(IS_GET){
      $chong['price']=I('amount');
      $c=M('chongzhipath')->where($chong)->find();
      $chongzhi['orders']=I('transaction_id');               //订单号
      $chongzhi['kanbi']=$c['egold'];                      //金额
      $chongzhi['uid']=I('order_id');
      $chongzhi['cid']=0;
      // var_dump($chongzhi);die;
        $arr=M('chongzhi')->where($chongzhi)->find();
          if($arr>0){
              
          }else{
              M('chongzhi')->add($chongzhi);
              $user=M('jieqi_system_users')->find(session('user_id'));
              $save['uid']=session('user_id');
              $save['egold']=$user['egold']+$c['egold'];
              $save['gcount']=$user['gcount']+$c['gcount'];
              M('jieqi_system_users')->save($save);
             
          }
    }
     $this->assign('v',$c['egold']);
     $this->assign('s',$c['gcount']);
    $this->display();
  }

 public function youjian(){    
          if(IS_POST){
             if(SendMail($_POST['mail'],$_POST['title'],$_POST['content'])){
                 $this->success('发送成功！');
            }else{
               $this->error('发送失败');
            }
               
          }
           

    $this->display();           
}
 
}