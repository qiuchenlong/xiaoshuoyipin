<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type:text/html;charset=utf-8'); 
class FaxianController extends Controller {

	//女频

    public function index(){
     // session('user_id',2); 

       if(!session("user_id")){

         echo '<script>alert("请先登录");window.location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/Login/login_frame.html"</script>';exit();
       }
      if(session("user_id")!==null){
        $user_id = session("user_id");
        $Model = M();

     


    $data = $Model->Query("SELECT gcount,egold,images,name,qiandao  FROM jieqi_system_users WHERE uid=".$user_id.";");

         $zongshu=$Model->Query("SELECT COUNT(*)AS count FROM invite WHERE `upper`=".$user_id.";");
          $shuliang=$zongshu[0]['count'];
         $yiji=$Model->Query("SELECT  *  FROM invite WHERE `upper`=".$user_id.";");

          foreach ($yiji as $key => $value) {//遍历二级
           
              $erji=$Model->Query("SELECT  *  FROM invite WHERE `upper`=".$value['down'].";");
              $ershu=$Model->Query("SELECT COUNT(*)AS count FROM invite WHERE `upper`=".$value['down'].";");
               $shuliang=$shuliang+$ershu[0]['count'];
                      foreach ($erji as $key => $value) {//遍历三级
           
              $sanji=$Model->Query("SELECT  *  FROM invite WHERE `upper`=".$value['down'].";");
              $sanshu=$Model->Query("SELECT COUNT(*)AS count FROM invite WHERE `upper`=".$value['down'].";");
               $shuliang=$shuliang+$sanshu[0]['count'];


                   }

          }
        $q['user_id']=$user_id;
        $con=date('Y-m-d');
        $q['time'] = array('like', "%$con%");
        $qi=M('user_qiandao')->where($q)->find();

        if($qi>0){
                $data[0]['yiqian']='200';

        }else{
           $data[0]['yiqian']='201';
        }

      $data[0]['yshuliang']=$shuliang;

      }
       $this->assign('faxian',$data[0]);
       $this->display();
    }


    //下级
    public function invite(){
      $user['upper']=session('user_id');
      $arr=M('invite')->where($user)->order('invite_id desc')->select();
      foreach ($arr as $k => $v) {
        $name=M('jieqi_system_users')->find($v['down']);
        $stat=substr($name['uname'],0,3);
        $arr[$k]['phone']=$stat.'******';
      }

      $this->assign('arr',$arr);
       $this->display();
    }

    //我的收益
    public function shouyi(){
      $user['user_id']=session('user_id');
      $arr=M('db_bounty')->where($user)->order('id desc')->select();
     

      $this->assign('arr',$arr);
       $this->display();
    }

    //评论
    public function review2()
    {
      $reviewRes=M('new_replay')->field('r.*,s.name')->alias('r')->join('jieqi_system_users s',"r.user_id=s.id")->order('r.id DESC')->select();
      $this->assign([
        'reviewRes'=>$reviewRes,
        ]);
        return view();
    }


    public function review(){
        $faxian=D('FaxianView');
        $count=$faxian->count();// 查询满足要求的总记录数
        $Page= new \Think\Page($count,100);
        $show=$Page->show();
        $list =M('new_reply')->where($user)->select();
        foreach ($list as $key => $value) {
           // echo  $value['aid'];
             $user['articleid']=$value['aid'];
     $book=M('jieqi_article_article')->where($user)->select();
             $list[$key]['book']=$book[0];
        }
        // var_dump($list);die;
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
   
   

    
}