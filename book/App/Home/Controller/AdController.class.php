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
		$books = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.isshou=1 order by t.issort limit 0,4 ");
		
		    foreach ($books as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$books[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }

		$books1 = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.isshou=1 order by t.issort limit 4,4 ");
		  foreach ($books1 as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$books1[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }

		$books2 = $Model->Query("SELECT t.images,t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.isshou=1 order by t.issort limit 8,4 ");
		  foreach ($books2 as $key => $value) {
		    	$gen=floor($value['articleid']/1000);
		    	$books2[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		    }
		$data = array($data,$datas,$books,$books1,$books2);
		echo getSuccessJson($data,'操作成功'); 
	}

	 public function Find(){
		$Model = M();
		$result = $Model->Query("select * from new_ad where path=2 order by id  desc limit 0,1");
		$result = array($result[0]);
		echo getSuccessJson($result);
	}


    /**
     * dudj 修改 获取广告信息
     */
    public function bookad(){
        $path = 2;
        $bid = 1;
		$model = M('bookAd');
        $where['path'] = $path;
        $map['bookid'] = ["like",$bid];
		$count = $model->where($map)->where($where)->count()-1;
        $start = rand(0,$count);
        $result = $model->where($map)->where($where)->limit("$start,1")->order('id desc')->select();
		$result = array($result[0]);
		echo getSuccessJson($result,'操作成功');
	}

//书评广场
	public function bounty(){ 
		if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*10;
	    }
	    else
	    {
	    $page=0;
	    }
		$Model = M();
		 $user_id = $_REQUEST['user_id'];

		// $data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articleid =".$articleid.";");
			
		// $data = $Model->Query("SELECT intro,articlename,articleid FROM jieqi_article_article where articleid =".$articleid.";");

		// $gen=floor($data[0]['articleid']/1000);
		//     	$data[0]['imagess']=$gen.'/'.$data[0]['articleid'].'/'.$data[0]['articleid'].'s.jpg';

			// $count = $Model->Query("SELECT COUNT(*) AS count FROM new_reply where aid =".$articleid.";");
   //        $data[0]['count']=$count[0]['count'];
		$pinglun = $Model->Query("SELECT * FROM db_bounty  where user_id=".$user_id." order by id  desc limit $page,10;");
		   

		$pinglun = array($pinglun);
		echo getSuccessJson($pinglun,'操作成功'); 
	}


  //充值列表
    public function czxqs(){
        $Model = M('');
 $lunbo = $Model->Query("SELECT * FROM chongzhipath order by price ");

     $pinglun = array($lunbo);
		echo getSuccessJson($pinglun,'操作成功'); 

    }

  //上架状态
    public function shang(){
        $Model = M('');
 $lunbo = $Model->Query("SELECT shang FROM system where id=1 ");

     $pinglun = array($lunbo);
		echo getSuccessJson($pinglun,'操作成功'); 

    }


  //系统设置
    public function xitong(){
        $Model = M('');
 $lunbo = $Model->Query("SELECT * FROM sys where id=1 ");

     $pinglun = array($lunbo);
		echo getSuccessJson($pinglun,'操作成功'); 

    }



}

?>