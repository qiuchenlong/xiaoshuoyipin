<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
class SearchController extends Controller{   
	//首页广告
	public function hot(){ 
		$id=$_REQUEST[user_id];
		$Model = M();
		$datas = $Model->Query("SELECT * FROM jieqi_article_searchcache where user_id=".$id."; ");
		$data = $Model->Query("SELECT * FROM jieqi_article_searchcache where types=1 ");
		
		$datas1 = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid order by t.allvisit desc limit 0,5");

		$data = array($data,$datas,$datas1);
		echo getSuccessJson($data,'操作成功'); 
	}


	//搜索历史
	public function history(){ 
		$id=$_REQUEST[user_id];
		$Model = M();
		$data = $Model->Query("SELECT * FROM jieqi_article_searchcache where user_id=".$id."; ");
		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

		//清楚搜索历史
	public function delhistory(){ 
		$id=$_REQUEST[user_id];
		$Model = M();
		$data = $Model->Query("DELETE  FROM jieqi_article_searchcache where user_id=".$id."; ");
		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}


	//搜索小说
	public function keywords(){ 
		$keywords=$_REQUEST['keywords'];
		$Model = M();
		$data = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.articlename like'%".$keywords."%'");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}





}

?>