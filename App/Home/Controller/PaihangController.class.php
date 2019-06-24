<?php
namespace Home\Controller;
use Think\Controller;
class PaihangController extends Controller {


	//女频
    public function index(){


      if($_REQUEST['sort'])
    {
    $paixu=$_REQUEST['sort'];
     }
     else
     {
      $paixu="newbook";
     }
    if($_REQUEST['page'])
    {
    $page=$_REQUEST['page']*10;
      }
      else
      {
      $page=0;
      }
       if($_REQUEST['biaoqian'])
       {
      $biaoqian=$_REQUEST['biaoqian'];
        }
        else
        {
         $biaoqian=1; 
        }
    $Model = M();
    $data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articletype like '%".$biaoqian."%'  order by t.$paixu desc limit $page,100");

        //     foreach ($data as $key => $value) {
        //   $gen=floor($value['articleid']/1000);
        //   $data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
        // }
      // var_dump($data);
       $this->assign('paihang',$data);
       $this->assign('biaoqian',$biaoqian);
       $this->assign('sort',$paixu);
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

     //搜索
    public function seek(){
       $this->display();
    }

    //书本详情
    public function dtail(){
       $this->display();
    }

    //免费试读
    public function book(){
       $this->display();
    }

    //本期主打
    public function resou(){
       $this->display();
    }

    
}