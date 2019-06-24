<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type:text/html;charset=utf-8'); 
class UserController extends Controller {

	//个人中心
    public function index(){
      // session('user_id',88);
      $arr=M('jieqi_system_users')->find(session('user_id'));
      $this->assign('v',$arr);
       $this->display();
    }

     public function chong_zhi(){

       if(!session("user_id")){

         echo '<script>alert("请先登录");window.location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/Login/login_frame.html"</script>';exit();
       }
       
      $arr=M('jieqi_system_users')->find(session('user_id'));
          $Model = M();
    $data = $Model->Query("SELECT * FROM chongzhipath  ");

      $this->assign('v',$arr);
       $this->assign('user',session('user_id'));
      $this->assign('chongzhi',$data);
       $this->display();
    }


    public function chongzhi(){
            $Model = M();
    $user_id = session("user_id");
    $id=$_GET['id'];      
    $data = $Model->Query("SELECT * FROM chongzhipath where id=".$id." ");
    $danhao=date("YmdHis");
              $add['uid']=$user_id;
                $add['kanbi']=$data[0]['egold'];
                $add['orders']=$danhao;
                $add['cid']=$id;
                
            $sql=M('chongzhi')->add($add);

            if($sql==true)
            {
              
               $returnArr = array(
                "code"=>200,
                "price"=>$data[0]['price'],
                "danhao"=>$danhao,
                "msg"=>"注册成功"
            );

               echo json_encode($returnArr);

            }

     
    }



    public function readHistory(){
      $userid =session('user_id');
    $Model = M();
    $data = $Model->Query("SELECT t1.chaptername,t1.chapterid,t1.caseid,t.sortid,t.author,t.articlename,t.images,t.intro,t.articleid,t.size FROM jieqi_article_article t inner join jieqi_article_bookcase t1 on t.articleid =t1.articleid where t1.userid=".$userid." and t1.flag=1  ");
     // foreach ($data as $key => $value) {
     //      $gen=floor($value['articleid']/1000);
     //      $data[$key]['images']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
     //    }
            foreach ($data as $key => $value) {
             
              $sortname = $Model->Query("SELECT * FROM jieqi_article_sort where sortid=".$value['sortid'].";");
                $data[$key]['shortname']=$sortname[0]['shortname'];

            }
    
// var_dump($data);
      $this->assign('v',$data);

       $this->display();
    }

    public function qb()
    {
        // session('user_id',7);
        $u['user_id']=session('user_id');
        $arr=M('orders')->where($u)->select();
        foreach ($arr as $k => $v) {
          $info=M('jieqi_article_article')->find($v['aid']);
          $arr[$k]['articlename']=$info['articlename'];
        }
         $this->assign('arr',$arr);
       $this->display();
    }

    public function recharge()
    {

       $u['uid']=session('user_id');
       $u['zhifu']=1;
        $arr=M('chongzhi')->where($u)->select();
        

        $this->assign('arr',$arr);
       $this->display();
    }



    public function payssion()
    {
        if(IS_AJAX){
                $api_key='live_57d9d64eb483ebeb';                 //api秘钥
                $pm_id='';                                  //支付方式 必须按官网类型填写,否则无效
                $amount=I('id');                                     //金额
                $currency='USD';                                     //货币类型
                $order_id=session('user_id');                                  //订单号
                $secret_key='e1dc804aa722278fd860d26e5f19398d';      //秘钥

                $msg = implode('|',array($api_key,$amount,$currency,$order_id,$secret_key));

                  $api_sig = md5($msg);
           
                 $this->ajaxReturn($api_sig);
        }
  
        $arr=M('jieqi_system_users')->find(session('user_id'));
        $Model = M();
        $data = $Model->Query("SELECT * FROM chongzhipath  ");

      $this->assign('v',$arr);
       $this->assign('user',session('user_id'));
      $this->assign('chongzhi',$data);
      $this->display();
    }


   
    
}