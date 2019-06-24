<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
class BookController extends Controller{   
	//首页广告
	public function shoubook(){ 
		
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.isshou=1 order by t.issort ");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

		//女频首页
	public function pingdao(){ 
		
					if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*3;
	    }
	    else
	    {
	    $page=0;
	    }
        $pindao=$_REQUEST['pindao'];
		
		$Model = M();
		$data = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=".$pindao." order by paixu limit $page,3 ");

		// $ad = $Model->Query("SELECT * FROM new_ad  where `path`=".$pindao." order by sort  ");


  //        $data['ad']=$ad;
		    foreach ($data as $key => $value) {

                  $xiaoshu = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$value['id']."%' limit 0,7;");
              $data[0]['xiaoshuo']=$xiaoshu;
		    	
		    }

		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 

	}


	//频道轮播
	public function pad(){ 
		$Model = M();
		
        $pindao=$_REQUEST['pindao'];
		
	
		$data = $Model->Query("SELECT * FROM new_ad  where `path`=".$pindao." order by sort  ");
		   

		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 


}

//小说分类 2级分类
	public function fenlei(){ 
		$Model = M();
		
        $pindao=$_REQUEST['pindao'];
		
	
		$data = $Model->Query("SELECT imgurl,sortid,shortname FROM jieqi_article_sort  where `types`=".$pindao." order by sortid desc  ");
		   

		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 


}


	//书单
	public function shudan(){ 
		$Model = M();
		
        $pindao=$_REQUEST['pindao'];
		
		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*5;
	    }
	    else
	    {
	    $page=0;
	    }

	
		$data = $Model->Query("SELECT * FROM new_shudan   order by sort  limit $page,5  ");
		   

		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 


}



//频道小说列表
	public function pindaolst(){ 
			if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0;
	    }
	    $pindao=$_REQUEST['id'];
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.biaoqian=".$pindao." order by t.allvisit desc limit $page,10 ");
              foreach ($data as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }
		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}


	public function bookdetail(){//书籍详情 
		$id=$_REQUEST['id'];
		$userid=$_REQUEST['user_id'];
		$Model = M();
		$data = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.articleid=".$id.";");
            $data[0][lasttime]=date("Y-m-d H:i",$data[0]['lastupdate']);
            $gen=floor($data[0]['articleid']/1000);
             $data[0][imagess]=$gen.'/'.$data[0]['articleid'].'/'.$data[0]['articleid'].'s.jpg';

             $suodudata = $Model->Query("SELECT t1.shortname,t.images,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid order by t.allvisit limit 0,4;");
              foreach ($suodudata as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$suodudata[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }


          $ahdata = $Model->Query("SELECT t1.shortname,t.images,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.authorid=".$data[0]['authorid']." limit 0,4;");

           foreach ($ahdata as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$ahdata[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }

           $fendata = $Model->Query("SELECT t1.shortname,t.images,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.sortid=".$data[0]['sortid']." limit 0,4;");

             foreach ($fendata as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$fendata[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }

		
		//加入浏览
		      $usercase = $Model->Query("SELECT * FROM jieqi_article_bookcase where articleid='".$bookid."'and userid='".$userid."'and flag=1;");
        if($usercase[0]['userid'])
        {
      

        }
        else
        {
        	$flag=1;
     $sortname = $Model->Query("INSERT INTO jieqi_article_bookcase(articleid,userid,flag)VALUES('$bookid','$userid','$flag')");

    
          }

        //加入浏览量

         $Model->Query("UPDATE jieqi_article_article SET allvisit=allvisit+1  where articleid=".$id.";");

         $pinglun = $Model->Query("SELECT * FROM new_reply where aid =".$id." order by id  desc limit 0,4;");
		   foreach ($pinglun as $key => $value) {
		   	   $user = $Model->Query("SELECT * FROM jieqi_system_users where uid =".$value['user_id'].";");
		   	   $pinglun[$key]['username']=$user[0]['name'];
		   	   $pinglun[$key]['uimg']=$user[0]['images'];
		   }


		$data = array($data[0],$ahdata,$fendata,$suodudata,$pinglun);
		echo getSuccessJson($data,'操作成功'); 
	}

	//作者还写了哪些
	public function authorbook(){ 
			if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0;
	    }
		$author=$_REQUEST['author'];
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.authorid ='".$author."' limit $page,10 ");

		    foreach ($data as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }

		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

	//都在读
	public function userlookbook(){ 
			if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid order by t.allvisit desc limit $page,10 ");
              foreach ($data as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }
		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}


	//分类下的小说
	public function sortbook(){ 
				if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0;
	    }
		$sortid=$_REQUEST['sortid'];
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.sortid like'%".$sortid."%'order by t.allvisit desc limit $page,10");
              foreach ($data as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }
		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}


	//小说章节
	public function chapter(){ 
		$articleid=$_REQUEST['id'];
		$Model = M();
		$data = $Model->Query("SELECT * FROM jieqi_article_chapter where articleid =".$articleid." order by chapterid ;");
		foreach ($data as $key => $value) {
			$data[$key]['paixu']=$key;
		}

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}


		//热词排行榜
	public function hotbook(){ 
		$author=$_REQUEST['author'];
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid order by t.allvisit desc limit 0,5");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

 
 		//推荐
	public function recommend(){ 
		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articletype=1   limit $page,10");
         foreach ($data as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }
		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

		//精选
	public function goodbook(){ 
		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0	;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articletype=2  limit $page,10");
              foreach ($data as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }
		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

	//精选
	public function overbook(){ 
		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0	;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articletype=3  limit $page,10");

		   foreach ($data as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }

		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

		//精选
	public function listbook(){ 
		if($_REQUEST['sort'])
		{
		$paixu=$_REQUEST['sort'];
	   }
	   else
	   {
	   	$paixu="allvisit";
	   }
		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0;
	    }
	    $biaoqian=$_REQUEST['biaoqian'];
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where biaoqian like '%".$biaoqian."%'  order by t.$paixu desc limit $page,10");
            foreach ($data as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }
		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

	//免费
	public function freebook(){ 
		if($_REQUEST['sort'])
		{
		$paixu=$_REQUEST['sort'];
	   }
	   else
	   {
	   	$paixu="allvisit";
	   }
		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0	;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid  order by t.$paixu limit $page,10");
           foreach ($data as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }
		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}


		//分类
	public function  sort(){ 
		$Model = M();
		$data = $Model->Query("SELECT * FROM  jieqi_article_sort order by sortid ");


		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

		//分类
	public function  zisort(){ 
		$Model = M();

		$data1 = $Model->Query("SELECT * FROM  jieqi_article_sort  where layer =".$_REQUEST['sortid']." ");
              
              $data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.sortid=".$_REQUEST['sortid']."  order by t.articleid limit 0,10");

                 foreach ($data as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }

		$data = array($data,$data1);
		echo getSuccessJson($data,'操作成功'); 
	}


	//分类详情页
	public function sortdetail(){ 
		$null=0;
		$where=" where t.articleid!=".$null."";
		if($_REQUEST['zishu']==1)//字数
		{
		$where=$where." and t.size< 600000";
	   }

	   else if($_REQUEST['zishu']==2)
		{
		$where=$where." and (t.size>= 600000 && t.size<= 2000000)";
	   }
	    else if($_REQUEST['zishu']==3)
		{
		$where=$where." and  t.size>= 2000000";
	   }

       if($_REQUEST['sortid'])//分类
       {
     $where=$where." and  t.sortid =".$_REQUEST['sortid']."";
       }
       if($_REQUEST['articletype'])//是否已完结
       {
     $where=$where." and  t.articletype =".$_REQUEST['articletype']."";
       }

		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid ".$where." order by t.articleid limit $page,10");

		    foreach ($data as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }

		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

		//小说阅读
	public function  readbook(){ 

		$handle = fopen('http://www.youdingb.com/1.txt', 'r');
    $content = '';
    while(!feof($handle)){
        $content .= fread($handle, 8080);
    }
    $varci=$content;
  echo '{"t":"sdhfjsdh","p":["',$varci,'"]}';
    // $Model = M();
		// $data = $Model->Query("SELECT * FROM new_ad where path=0");
	 //    $data[0]['xiangqing']=$varci;
		// $data = array($data);
		// echo getSuccessJson($data,'操作成功'); 
		  
	}

		//小说阅读2
	public function chapterread(){ 
		$articleid=$_REQUEST['id'];
		$Model = M();
		$data = $Model->Query("SELECT chapterid,articlename FROM jieqi_article_chapter where articleid =".$articleid." order by chapterid;");
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

	//评论表
	public function bookreply(){ 
		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0;
	    }

		$articleid=$_REQUEST['id'];
		$Model = M();

		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articleid =".$articleid.";");

		// $data = $Model->Query("SELECT intro,articlename,articleid FROM jieqi_article_article where articleid =".$articleid.";");

		$gen=floor($data[0]['articleid']/1000);
		    	$data[0]['imagess']=$gen.'/'.$data[0]['articleid'].'/'.$data[0]['articleid'].'s.jpg';

			$count = $Model->Query("SELECT COUNT(*) AS count FROM new_reply where aid =".$articleid.";");
          $data[0]['count']=$count[0]['count'];
		$pinglun = $Model->Query("SELECT * FROM new_reply where aid =".$articleid." order by id  desc limit $page,10;");
		   foreach ($pinglun as $key => $value) {
		   	   $user = $Model->Query("SELECT * FROM jieqi_system_users where uid =".$value['user_id'].";");
		   	   $pinglun[$key]['username']=$user[0]['name'];
		   	   $pinglun[$key]['uimg']=$user[0]['images'];
		   }

		$data = array($data,$pinglun);
		echo getSuccessJson($data,'操作成功'); 
	}

	//添加评论
  public function addreply(){ 
    $userid=$_REQUEST['user_id'];
    $aid=$_REQUEST['id'];
    $cid=$_REQUEST['cid'];
    $content=$_REQUEST['content'];
    $addtime=date("Y-m-d H:i:s");
    $Model = M();
     
     $sortname = $Model->Query("INSERT INTO new_reply(aid,user_id,cid,content,addtime)VALUES('$aid','$userid','$cid','$content','$addtime')");
      if($sortname){
    $data = array('msg'=>'发表成功','code'=>'200');
           }
    echo getSuccessJson($data,'操作成功'); 
  }

	//添加评论
  public function addlike(){ 
    $rid=$_REQUEST['rid'];
    $Model = M();
     
     $sortname = $Model->Query("UPDATE new_reply set likes=likes+1 where id='".$rid."'");
      if($sortname){
    $data = array('msg'=>'发表成功','code'=>'200');
           }
    echo getSuccessJson($data,'操作成功'); 
  }

  //评论表
	public function myreply(){ 
		$user_id=$_REQUEST['user_id'];
		$Model = M();
		// $data = $Model->Query("SELECT intro,articlename FROM jieqi_article_article where articleid =".$articleid.";");
			$count = $Model->Query("SELECT COUNT(*) AS count FROM new_reply where user_id =".$user_id.";");
          $data[0]['count']=$count[0]['count'];
		$pinglun = $Model->Query("SELECT * FROM new_reply where user_id =".$user_id." order by id  desc;");
		   foreach ($pinglun as $key => $value) {
		   	   $shu = $Model->Query("SELECT * FROM jieqi_article_article where articleid =".$value['aid'].";");

		   	    $user = $Model->Query("SELECT * FROM jieqi_system_users where uid =".$value['user_id'].";");
                $pinglun[$key]['bookname']=$shu[0]['articlename'];
		   	   $pinglun[$key]['username']=$user[0]['name'];
		   }

		$data = array($data,$pinglun);
		echo getSuccessJson($data,'操作成功'); 
	}



//书评广场
	public function allreply(){ 
		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0;
	    }
		$Model = M();

		// $data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articleid =".$articleid.";");
			
		// $data = $Model->Query("SELECT intro,articlename,articleid FROM jieqi_article_article where articleid =".$articleid.";");

		// $gen=floor($data[0]['articleid']/1000);
		//     	$data[0]['imagess']=$gen.'/'.$data[0]['articleid'].'/'.$data[0]['articleid'].'s.jpg';

			// $count = $Model->Query("SELECT COUNT(*) AS count FROM new_reply where aid =".$articleid.";");
   //        $data[0]['count']=$count[0]['count'];
		$pinglun = $Model->Query("SELECT * FROM new_reply order by id  desc limit $page,10;");
		   foreach ($pinglun as $key => $value) {
		   	   $user = $Model->Query("SELECT * FROM jieqi_system_users where uid =".$value['user_id'].";");
		   	   $pinglun[$key]['username']=$user[0]['name'];
		   	   $pinglun[$key]['uimg']=$user[0]['images'];

		   	   $data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articleid =".$value['aid'].";");
             $pinglun[$key]['book']=$data[0];

		   }

		$pinglun = array($pinglun);
		echo getSuccessJson($pinglun,'操作成功'); 
	}




}

?>