<?php
namespace Home\Controller;
use Think\Controller;
 include_once("mysqlha.php");
 include_once("Common.php");

class MyController extends Controller{


    //我的书架
  public function mybookcase(){ 
    $userid=$_REQUEST['user_id'];
    if($_REQUEST['page'])
    {
    $page=$_REQUEST['page'];
      }
      else
      {
      $page=0 ;
      }
    $Model = M();
    $data = $Model->Query("SELECT t.images,t1.caseid,t.sortid,t.author,t.articlename,t.intro,t.articleid,t.size FROM jieqi_article_article t inner join jieqi_article_bookcase t1 on t.articleid =t1.articleid where t1.userid=".$userid." and t1.flag=0  limit $page,10");
            foreach ($data as $key => $value) {
             
              $sortname = $Model->Query("SELECT * FROM jieqi_article_sort where sortid=".$value['sortid'].";");
                $data[$key]['shortname']=$sortname[0]['shortname'];

            }
    
    $data = array($data);
    echo getSuccessJson($data,'操作成功'); 
  }

 //删除我的书架
  public function delbookcase(){ 
    $caseid=$_REQUEST['caseid'];
    $shuzu=explode(",",$caseid);
   
    $Model = M();
       foreach ($shuzu as $key => $value) {

     
              $del = $Model->Query("DELETE  FROM jieqi_article_bookcase where caseid=".$value.";");
        }
    
    $data = array($data);
    echo getSuccessJson($data,'操作成功'); 
  }


 //加入书架
  public function addcase(){ 
    $userid=$_REQUEST['user_id'];
    $bookid=$_REQUEST['bookid'];
   
    $Model = M();
        $usercase = $Model->Query("SELECT * FROM jieqi_article_bookcase where articleid=".$bookid."and userid=".$userid."and flag=0;");
        if(!$usercase)
        {
      $data = array('msg'=>'书架已经有该书本了','code'=>'201');

        }
        else
        {
     $sortname = $Model->Query("INSERT INTO jieqi_article_bookcase(articleid,userid)VALUES($bookid,$userid)");

    $data = array('msg'=>'已经放入书架','code'=>'200');
          }
    echo getSuccessJson($data,'操作成功'); 
  }

//我的浏览记录
  public function mybookview(){ 
    $userid=$_REQUEST['user_id'];
    if($_REQUEST['page']>0)
    {
    $page=$_REQUEST['page']*10;
      }
      else
      {
      $page=10 ;
      }
    $Model = M();
    $data = $Model->Query("SELECT t.images,t1.chaptername,t1.chapterid,t1.caseid,t.sortid,t.author,t.articlename,t.intro,t.articleid,t.size FROM jieqi_article_article t inner join jieqi_article_bookcase t1 on t.articleid =t1.articleid where t1.userid=".$userid." and t1.flag=1  limit 0,$page");
            foreach ($data as $key => $value) {
             
              $sortname = $Model->Query("SELECT * FROM jieqi_article_sort where sortid=".$value['sortid'].";");
                $data[$key]['shortname']=$sortname[0]['shortname'];

            }
    
    $data = array($data);
    echo getSuccessJson($data,'操作成功'); 
  }



}


?>