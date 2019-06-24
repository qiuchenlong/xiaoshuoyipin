<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
class AdController extends Controller{   
	//首页轮播
	public function adlst(){ 
		
		$Model = M();
		$data = $Model->Query("SELECT * FROM new_ad where path=0");
		$datas = $Model->Query("SELECT * FROM new_ad where path=1");
		$books = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.isshou=1 order by t.issort limit 0,4 ");
		$books1 = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.isshou=1 order by t.issort limit 4,4 ");
		$books2 = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.isshou=1 order by t.issort limit 8,4 ");
		$data = array($data,$datas,$books,$books1,$books2);
		echo getSuccessJson($data,'操作成功'); 
	}



}

?>