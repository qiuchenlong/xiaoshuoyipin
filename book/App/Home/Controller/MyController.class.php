<?php
namespace Home\Controller;
use Think\Controller;
 include_once("mysqlha.php");
 include_once("Common.php");

class MyController extends Controller{

    //我的书架
    public function mybookcase(){ 
        $userid=$_REQUEST['user_id'];
        if($_REQUEST['page']){
            $page=$_REQUEST['page'];
        }else{
            $page=0 ;
        }

        $Model = M();
        $data = $Model->Query("SELECT t1.caseid,t1.lastvisit,t.lastchapter,t.images,t.sortid,t.author,t.articlename,t.intro,t.articleid,t.size FROM jieqi_article_article t inner join jieqi_article_bookcase t1 on t.articleid =t1.articleid where t1.userid=".$userid." and t1.flag=0  limit $page,10");

        // foreach ($data as $key => $value) {
        //       $gen=floor($value['articleid']/1000);
        //       $data[$key]['images']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
        //     }
           // var_dump($data);die;
        foreach ($data as $key => $value) {
            $sortname = $Model->Query("SELECT * FROM jieqi_article_sort where sortid=".$value['sortid'].";");
            $data[$key]['shortname']=$sortname[0]['shortname'];

            $time = $value['lastvisit'];
            if(!$time){
                $time = "无记录";
            }else{
                $diff = time()-$time;
                if($diff<60){
                    $time = "刚刚";
                }else if($diff<3600) {
                    $time = floor($diff/60)."分钟前";
                }else if($diff<86400) {
                    $time = floor($diff/3600)."小时前";
                }else if($diff<(86400*7)) {
                    $time = floor($diff/86400)."天前";
                }else if($diff<(86400*30)) {
                    $time = floor($diff/86400/7)."周前";
                }else if($diff<(86400*183)) {
                    $time = floor($diff/86400/30)."个月前";
                }else{
                    $time = date("Y-m-d H:i:s",$time);
                }
            }
            $data[$key]['lastvisit']=$time;
            
            if($value['lastvisit']){
                $data[$key]['read']=1;
            }else{
                $data[$key]['read']=0;
            }
        }

        
    
        $data = array($data);
        echo getSuccessJson($data,'操作成功'); 
  }

    //删除我的书架
    public function delbookcase()
    { 
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
    public function addcase()
    { 
        $userid=$_REQUEST['user_id'];
        $bookid=$_REQUEST['bookid'];
       
        $Model = M();
        $usercase = $Model->Query("SELECT * FROM jieqi_article_bookcase where articleid='".$bookid."'and userid='".$userid."'and flag=0;");
        if($usercase[0]['userid']){
            $data = array('msg'=>'书架已经有该书本了','code'=>'201');
        }else{
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
    public function delbookreply()
    { 
        $replyid=$_REQUEST['replyid'];

        $Model = M();
        $del = $Model->Query("DELETE  FROM new_reply where id=".$replyid.";");
        
        $data = array($data);
        echo getSuccessJson($data,'操作成功');
    }

    //系统通知列表首页轮播
    public function systemslst()
    {
        $Model = M();
        $data = $Model->Query("SELECT * FROM system where id=1 order by id desc;");
         
        $data = array($data[0]);
        echo getSuccessJson($data,'操作成功'); 
    }

    public function chapter()
    {
        $userid = $_REQUEST['userid'];
        $articleid = $_REQUEST['articleid'];
        $num = $_REQUEST['num'];

        // $usercase = M('jieqi_article_bookcase')->where(['articleid'=>$articleid,'userid'=>$userid,'flag'=>1])->find();

        // //检测是否有阅读记录
        // if($usercase){
        //     $z = $usercase['zhixu'];
        // }else{
        //     $z = 0;
        // }

        $chapter = M('jieqi_article_chapter')->where(['articleid'=>$articleid])->limit($num,1)->select()[0];

        // var_dump($chapter);die;

        if($attachment !== false){
            $result = ['code' => 200,'title'=>$chapter['chaptername'],'attachment'=>$chapter['attachment'],'msg' =>'操作成功'];
        }else{
            $result = ['code' => 220,'attachment'=>$chapter['attachment'],'msg' =>'操作失败'];
        }
        $this->ajaxReturn($result); 
    }


    //推荐通知
    public function adsystem()
    {
        $data = M('system')->where(['types'=>4])->select();

        $arr = [];
        foreach ($data as $k => $v) {
          $item = [];
          $item['title'] = $v['content'];
          $item['articleid'] = $v['title'];
          $arr[] = $item;
        }

        $returnarr = ['code' => 200,'data'=>$arr,'msg'=>'操作成功'];           
        $this->ajaxReturn($returnarr);
    }


    //系统通知列表
    public function systemlst(){
        $page = $_REQUEST['page'];

        if($page == null || $page <= 0){
            $page = 0;
        }

        $pagecount = 10;
        $startcount = $page * $pagecount;

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

        $bookid = $Model->Query("SELECT did FROM jieqi_article_article where articleid='".$_REQUEST['id']."'");

if($datas){
 $data = array('msg'=>'已经购买过了','code'=>'201');
    echo getSuccessJson($data,'操作成功'); 
}else{
    $wodejin=$user[0]['egold']+$user[0]['gcount'];
     if($wodejin<$_REQUEST['jiage'])
     {
     $state=0;
     $pay=$_REQUEST['jiage']-$wodejin;

      $data = array('msg'=>'余额不够请充值','code'=>'202');
    echo getSuccessJson($data,'操作成功'); 
}else{
                 if($user[0]['gcount']<$_REQUEST['jiage'])//扣代金券和余额
                 {
                  $Model->Query("UPDATE jieqi_system_users SET gcount=0   where user_id='".$_REQUEST['user_id']."'");
                  $yue=$_REQUEST['jiage']-$user[0]['gcount'];

                  $Model->Query("UPDATE jieqi_system_users SET egold=egold-".$yue."   where user_id='".$_REQUEST['user_id']."'");
                   $daijin=$user[0]['gcount'];$money=$yue;




                   //代理商

                    if($bookid['did']>0){
                      $dai['time']=date('Y-m');
                      $dai['uid']=$bookid['did'];
                      $daili=M('dai_jiesuan')->where($dai)->find();
                      if($daili>0){
                        $dli['id']=$daili['id'];
                        $dli['num']=$daili['num']+1;
                        $dli['money']=$daili['money']+$yue;
                        M('dai_jiesuan')->save($dli);
                      }else{
                        $dali['uid']=$bookid['did'];
                        $dali['num']=1;
                        $dali['money']=+$yue;
                        $dali['time']=date('Y-m');
                        M('dai_jiesuan')->add($dali);
                      }

                    }

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