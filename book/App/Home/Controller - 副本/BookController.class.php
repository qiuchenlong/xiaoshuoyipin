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

	public function bookdetail(){//书籍详情 
		$id=$_REQUEST[id];
		$Model = M();
		$data = $Model->Query("SELECT t1.shortname,t.authorid,t.images,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.articleid=".$id.";");
            $data[0][lasttime]=date("Y-m-d H:i",$data[0]['lastupdate']);
             
             $suodudata = $Model->Query("SELECT t1.shortname,t.images,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid order by t.allvisit limit 0,4;");

          $ahdata = $Model->Query("SELECT t1.shortname,t.images,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.authorid=".$data[0]['authorid']." limit 0,4;");
           $fendata = $Model->Query("SELECT t1.shortname,t.images,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.sortid=".$data[0]['sortid']." limit 0,4;");
		
		$data = array($data[0],$ahdata,$fendata,$suodudata);
		echo getSuccessJson($data,'操作成功'); 
	}

	//作者还写了哪些
	public function authorbook(){ 
			if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*5;
	    }
	    else
	    {
	    $page=5;
	    }
		$author=$_REQUEST['author'];
		$Model = M();
		$data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.authorid ='".$author."' limit 0,$page ");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

	//都在读
	public function userlookbook(){ 
			if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*5;
	    }
	    else
	    {
	    $page=5;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid order by allvisit desc limit 0,$page ");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}


	//分类下的小说
	public function sortbook(){ 
		$sortid=$_REQUEST['sortid'];
		$Model = M();
		$data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.sortid like'%".$sortid."%'");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}


	//小说章节
	public function chapter(){ 
		$articleid=$_REQUEST['id'];
		$Model = M();
		$data = $Model->Query("SELECT * FROM jieqi_article_chapter where articleid =".$articleid.";");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}


		//热词排行榜
	public function hotbook(){ 
		$author=$_REQUEST['author'];
		$Model = M();
		$data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid order by t.allvisit desc limit 0,5");

		
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
	    $page=10	;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articletype=1   limit 0,$page");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

		//精选
	public function goodbook(){ 
		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page'];
	    }
	    else
	    {
	    $page=0	;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articletype=2  limit $page,10");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

	//精选
	public function overbook(){ 
		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page'];
	    }
	    else
	    {
	    $page=0	;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articletype=3  limit $page,10");

		
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
	    $page=10;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid  order by t.$paixu limit 0,$page");

		
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
		$page=$_REQUEST['page'];
	    }
	    else
	    {
	    $page=0	;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid  order by t.$paixu limit $page,10");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}


		//分类
	public function  sort(){ 
		$Model = M();
		$data1 = $Model->Query("SELECT * FROM  jieqi_article_sort  where types=1 ");
              
              foreach ($data1 as $key => $value) {
              	$data1[$key]['list1'] = $Model->Query("SELECT * FROM  jieqi_article_sort  where layer=".$value['sortid']." limit 0,8");
              }

         $data2 = $Model->Query("SELECT * FROM  jieqi_article_sort  where types=2 ");

              foreach ($data2 as $key => $value) {
              	$data1[$key]['list2'] = $Model->Query("SELECT * FROM  jieqi_article_sort  where layer=".$value['sortid']."limit 0,8");
              }


         $data3 = $Model->Query("SELECT * FROM  jieqi_article_sort  where types=3 ");
		
		foreach ($data3 as $key => $value) {
              	$data1[$key]['list3']= $Model->Query("SELECT * FROM  jieqi_article_sort  where layer=".$value['sortid']." limit 0,8");
              }

		$data = array($data1,$data2,$data3);
		echo getSuccessJson($data,'操作成功'); 
	}

		//分类
	public function  zisort(){ 
		$Model = M();
		$data1 = $Model->Query("SELECT * FROM  jieqi_article_sort  where layer =".$_REQUEST['sortid']." ");
              
              $data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.sortid=".$data1[0][sortid]."  order by t.articleid limit 0,10");

		$data = array($data,$data1);
		echo getSuccessJson($data,'操作成功'); 
	}


	//分类详情页
	public function sortdetail(){ 
		$null=0;
		$where=" where t.articleid!=".$null."";
		if($_REQUEST['zishu']==1)//字数
		{
		$where=$where." and t.size< 300000";
	   }

	   else if($_REQUEST['zishu']==2)
		{
		$where=$where." and (t.size>= 300000 && t.size<= 1000000)";
	   }
	    else if($_REQUEST['zishu']==3)
		{
		$where=$where." and  t.size>= 1000000";
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
	    $page=10	;
	    }
		$Model = M();
		$data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid ".$where." order by t.articleid limit 0,$page");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}



}

?>