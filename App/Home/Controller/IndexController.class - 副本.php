<?php
namespace Home\Controller;
use Think\Controller;
header("content-type:text/html;charset=utf-8"); 
class IndexController extends Controller {


	//女频
    public function index(){
       $this->display();
    }


    //男频
    public function index_male(){
       $this->display();
    }

    //出版
    public function index_publish(){
       $this->display();
    }


     //免费
    public function index_gratis(){
       $this->display();
    }


    //书单
    public function BookSelection(){
       $this->display();
    }

   

    //书本详情
    public function dtail(){
      //查询是否加入书架
      $cha['articleid']=I('id');
      $cha['userid']=session('user_id');
      $shujia=M('jieqi_article_bookcase')->where($cha)->find();
      // var_dump($shujia);die;
      //大家都在看
      $le=M('jieqi_article_article')->find(I('id'));
      $si=strstr($le['biaoqian'],',');

      // if($si!==false){
        $lei=explode(",",$le['biaoqian']);  
        $con=$lei[0];
        $data['biaoqian'] = array('like', "%$con%");
        $data['articleid'] = array('neq', I('id'));
        $yezai=M('jieqi_article_article')->where($data)->order('articleid asc')->limit(0,4)->select();

       //书友还关注
      $guanzhu=M('jieqi_article_article')->where($data)->order('articleid desc')->limit(0,4)->select();
        

      
      
      $arr=M('jieqi_article_article')->find(I('id'));
          $a=$arr['size']/10000/2;
          $arr['size']=round($a,1);


      //标签
       $sh=strstr($arr['biaoqian'],',');
                if($sh!==false){
                    $shu=explode(",",$arr['biaoqian']);         
                    foreach ($shu as $o => $p) {
                        $bb=M('jieqi_article_fenlei')->find($p);
                        $biao[$o]=$bb['title'];
                    }
                   
                }else{
                    $biaoqian=M('jieqi_article_fenlei')->find($arr['biaoqian']);
                    $biao=$biaoqian['title'];
                }

      //评论
      $pp['aid']=I('id');
      $shu=M('new_reply')->where($pp)->order('id desc')->limit(0,2)->select();
      foreach ($shu as $kk => $vv) {
        $u=M('jieqi_system_users')->find($vv['user_id']);
        $shu[$kk]['name']=$u['name'];
      }
        

      //点赞
      if(!empty(I('dian'))){
        $lik=M('new_reply')->find(I('dian'));
        $d['id']=I('dian');
        $d['likes']=$lik['likes']+1;
        $sql=M('new_reply')->save($d);
        if($sql>0){
          echo '<script>location.href="dtail.html?id='.I('id').'&shujia=1"</script>';
       
        }
      }



      
       $this->assign('shu',$shu); 
       $this->assign('arr',$arr);
       $this->assign('biao',$biao);
       $this->assign('shujia',$shujia);
       $this->assign('yezai',$yezai);
       $this->assign('guanzhu',$guanzhu);
       $this->display();
    }

    //免费试读
    public function book(){
       $this->display();
    }

     //更多评论
    public function pinglun(){
      $arr=M('jieqi_article_article')->find(I('id'));
          $a=$arr['size']/10000/2;
          $arr['size']=round($a,1);

      //评论
      $p['aid']=I('id');
        $pp['aid']=I('id');

          //查询数据并分页
            $model =M('new_reply');
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $shu = $model->where($pp)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            $btn = $page->show();
            //分配数据
      foreach ($shu as $k => $v) {
        $u=M('jieqi_system_users')->find($v['user_id']);
        if($u>0){
          $shu[$k]['name']=$u['name'];
        }
        
      }


      //点赞
      if(!empty(I('dian'))){
        $lik=M('new_reply')->find(I('dian'));
        $d['id']=I('dian');
        $d['likes']=$lik['likes']+1;
        $sql=M('new_reply')->save($d);
        if($sql>0){
          echo '<script>location.href="pinglun.html?id='.I('id').'&shujia=1"</script>';
       
        }
      }
        // var_dump($shu);
        $this->assign('shu',$shu); 
        $this->assign('btn',$btn); 
       $this->assign('arr',$arr);
       $this->display();
    }



    //书单
    public function pladd(){
      $a['content']=I('text');
      $a['user_id']=session('user_id');
      $a['aid']=I('id');
      // var_dump($a);die;
      $arr=M('new_reply')->add($a);
      if($arr>0){
        echo '<script>alert("评论成功");location.href="dtail.html?id='.I('id').'&shujia=1"</script>';
       
      }

      $this->display();
    }

    //加入书架 
   public function sjadd(){
      if(session('user_id')==null){
          echo '<script>alert("请先登录");location.href="dtail.html?id='.I('id').'"</script>';die;
      }
      $cha['articleid']=I('id');
      $cha['userid']=session('user_id');
      $shujia=M('jieqi_article_bookcase')->add($cha);
      if($shujia>0){
         echo '<script>alert("书架加入成功");location.href="dtail.html?id='.I('id').'"</script>';
      }
   }
    
}