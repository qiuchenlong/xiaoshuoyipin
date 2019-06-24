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
    $data = $Model->Query("SELECT t1.caseid,t.images,t.sortid,t.author,t.articlename,t.intro,t.articleid,t.size FROM jieqi_article_article t inner join jieqi_article_bookcase t1 on t.articleid =t1.articleid where t1.userid=".$userid." and t1.flag=0  limit $page,10");
    // foreach ($data as $key => $value) {
    //       $gen=floor($value['articleid']/1000);
    //       $data[$key]['images']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
    //     }
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
        $usercase = $Model->Query("SELECT * FROM jieqi_article_bookcase where articleid='".$bookid."'and userid='".$userid."'and flag=0;");
        if($usercase[0]['userid'])
        {
      $data = array('msg'=>'书架已经有该书本了','code'=>'201');

        }
        else
        {
     $sortname = $Model->Query("INSERT INTO jieqi_article_bookcase(articleid,userid)VALUES('$bookid','$userid')");

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
    $data = $Model->Query("SELECT t1.chaptername,t1.chapterid,t1.caseid,t.sortid,t.author,t.articlename,t.images,t.intro,t.articleid,t.size FROM jieqi_article_article t inner join jieqi_article_bookcase t1 on t.articleid =t1.articleid where t1.userid=".$userid." and t1.flag=1  limit 0,$page");
     // foreach ($data as $key => $value) {
     //      $gen=floor($value['articleid']/1000);
     //      $data[$key]['images']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
     //    }
            foreach ($data as $key => $value) {
             
              $sortname = $Model->Query("SELECT * FROM jieqi_article_sort where sortid=".$value['sortid'].";");
                $data[$key]['shortname']=$sortname[0]['shortname'];

            }
    
    $data = array($data);
    echo getSuccessJson($data,'操作成功'); 
  }


//我购买的
  public function mybookbuy(){ 
    $userid=$_REQUEST['user_id'];
    if($_REQUEST['page']>=0)
    {
    $page=$_REQUEST['page'];
      }
      else
      {
      $page=0 ;
      }
    $Model = M();
    $data = $Model->Query("SELECT t.sortid,t.author,t.articlename,t.images,t.intro,t.articleid,t.size FROM jieqi_article_article t inner join orders t1 on t.articleid =t1.aid where t1.user_id=".$userid." ");
     // foreach ($data as $key => $value) {
     //      $gen=floor($value['articleid']/1000);
     //      $data[$key]['images']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
     //    }
            foreach ($data as $key => $value) {
             
              $sortname = $Model->Query("SELECT * FROM jieqi_article_sort where sortid=".$value['sortid'].";");
                $data[$key]['shortname']=$sortname[0]['shortname'];

            }
    
    $data = array($data);
    echo getSuccessJson($data,'操作成功'); 
  }


//加入书架
  public function addfankui(){ 
    $userid=$_REQUEST['user_id'];
    $content=$_REQUEST['content'];
   
    $Model = M();
 
     $sortname = $Model->Query("INSERT INTO yijian(yijian,user_id)VALUES('$content','$userid')");

    $data = array('msg'=>'已经放入书架','code'=>'200');
          


    echo getSuccessJson($data,'操作成功'); 
  }

   //删除我的评论
  public function delbookreply(){ 
    $replyid=$_REQUEST['replyid'];
    $Model = M();
     
              $del = $Model->Query("DELETE  FROM new_reply where id=".$replyid.";");
    
    $data = array($data);
    echo getSuccessJson($data,'操作成功'); 
  }
 //系统通知列表首页轮播
  public function systemslst(){
    $Model = M();
    $data = $Model->Query("SELECT * FROM system where id=1 order by id desc;");
     
    $data = array($data[0]);
    echo getSuccessJson($data,'操作成功'); 
  }

  //系统通知列表
  public function systemlst(){
    $page = $_REQUEST['page'];
      if($page == null||$page<=0){
      $page=0;
    }

      $pagecount=10;
    $startcount = $page*$pagecount;

    $Model = M();
    $data = $Model->Query("SELECT title,id,addtime FROM system order by id desc limit ".$startcount.",".$pagecount.";");
     
    $data = array($data);
    echo getSuccessJson($data,'操作成功'); 
  }

    //系统通知详情
  public function systemdetails(){
    $id=$_REQUEST['id'];
    $Model = M();
    $data = $Model->Query("SELECT * FROM system where id=".$id.";");
     
    $data = array($data['0']);
    echo getSuccessJson($data,'操作成功'); 
  }


  public  function addorder()
  {

$Model=M('orders');
//生成订单
    $time = explode (" ", microtime ());        
    $time = $time[1].($time[0] * 1000);  
    $time2 = explode ( ".", $time); 
    $time = $time2[0];

$datas = $Model->Query("SELECT * FROM orders where aid='".$_REQUEST['id']."' and user_id='".$_REQUEST['user_id']."' and path='".$_REQUEST['zj']."' and state=1 ");

$user = $Model->Query("SELECT egold,gcount FROM jieqi_system_users where user_id='".$_REQUEST['user_id']."'");


if($datas)
{
 $data = array('msg'=>'已经购买过了','code'=>'201');
    echo getSuccessJson($data,'操作成功'); 

}
else
{
    $wodejin=$user[0]['egold']+$user[0]['gcount'];
     if($wodejin<$_REQUEST['jiage'])
     {
     $state=0;
     $pay=$_REQUEST['jiage']-$wodejin;

      $data = array('msg'=>'余额不够请充值','code'=>'202');
    echo getSuccessJson($data,'操作成功'); 

     }
     else
     {
                 if($user[0]['gcount']<$_REQUEST['jiage'])//扣代金券和余额
                 {
                  $Model->Query("UPDATE jieqi_system_users SET gcount=0   where user_id='".$_REQUEST['user_id']."'");
                  $yue=$_REQUEST['jiage']-$user[0]['gcount'];

                  $Model->Query("UPDATE jieqi_system_users SET egold=egold-".$yue."   where user_id='".$_REQUEST['user_id']."'");
                   $daijin=$user[0]['gcount'];$money=$yue;
                 }
                 else
                 {
                  $yue=$_REQUEST['jiage'];
$Model->Query("UPDATE jieqi_system_users SET gcount=gcount-".$yue."   where user_id='".$_REQUEST['user_id']."'");
                  $daijin=$yue;$money=0;

                 }
 $state=1;
 $pay=0;

 $OrderArr = array(  
      "numbers"=>$time,  
      "aid"=>$_REQUEST['id'], 
      "user_id"=>$_REQUEST['user_id'], 
      "allprice"=>$_REQUEST['jiage'],//商品总价   
      "path"=>$_REQUEST['zj'],
      "state"=>$state,
      "daijin"=>$daijin,
      "money"=>$money,
      );

    M('orders')->add($OrderArr);
 $data = array('msg'=>'已经购买','code'=>'202');
    echo getSuccessJson($data,'操作成功'); 

     }

   

    
}

  }


}


?>