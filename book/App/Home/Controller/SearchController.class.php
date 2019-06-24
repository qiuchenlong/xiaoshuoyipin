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
		
		$datas1 = $Model->Query("SELECT t.author,t.articlename,t.images,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid order by t.allvisit desc limit 0,5");
       //      foreach ($datas1 as $key => $value) {
		    	// $gen=floor($value['articleid']/1000);
		    	// $datas1[$key]['images']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    	//   }

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
		$userid=$_REQUEST['user_id'];
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname,t.images FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.articlename like'%".$keywords."%' or  t.author like'%".$keywords."%' or  t.keywords like'%".$keywords."%'");

       //           foreach ($data as $key => $value) {
		    	// $gen=floor($value['articleid']/1000);
		    	// $data[$key]['images']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    	//   }

			  //添加搜索记录
		       $usercases = $Model->Query("SELECT * FROM jieqi_article_searchcache where keywords='".$keywords."'and user_id='".$userid."';");
        if($usercases)
        {
      $yiliulan = array('msg'=>'书','code'=>'201');

        }
        else
        {
        	$flag=0;
     $sortnames = $Model->Query("INSERT INTO jieqi_article_searchcache(keywords,user_id,types)VALUES('$keywords','$userid','$flag')");
         }

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}





}

?>