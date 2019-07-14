<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
header('content-type:text/html;charset=utf-8');
class BookController extends Controller{   
	//首页广告
	public function shoubook(){ 
		
		$Model = M();
		$data = $Model->Query("SELECT t.author,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.isshou=1 order by t.issort ");

		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}
    /**
     * 获取某一个章节的数据
     * sx integer 章节
     * id integer 小说id
     * userid integer 用户id
     */
	public function chapterreads(){ 
	    $articleid = $_REQUEST['id'];
		$sx = $_REQUEST['sx'];
		$userid = $_REQUEST['userid'];
		$Model = M();
        //增加阅读时长
        $Model->Query("UPDATE jieqi_system_users SET readtime=readtime+2  where uid='".$userid."';");
        $book = $Model->Query("SELECT saleprice,ffee FROM jieqi_article_article where articleid =".$articleid.";");
        $mianfei = $book[0]['ffee'];//免费章节
        if($sx<100){
        	$shu = 1;
        }else if($sx%100==0){
        	$shu = $sx/100;
        }else if($sx%100!=0){
        	$shu = ($sx/100)+1;
        }
        //取下一章节的数据
		$data = $Model->Query("SELECT chapterid,articlename,chaptername,attachment FROM jieqi_article_chapter where articleid =".$articleid." order by chapterid limit $sx,1;");
        //加入浏览书架
 		$usercase = $Model->Query("SELECT * FROM jieqi_article_bookcase where articleid='".$articleid."'and userid='".$userid."'and flag=1;");
        $usershujia = $Model->Query("SELECT * FROM jieqi_article_bookcase where articleid='".$articleid."'and userid='".$userid."'and flag=0;");
        $shijiancuo=time();
        //更新书架时间
        if($usershujia){
            $Model->Query("UPDATE jieqi_article_bookcase SET chapterid='".$data[0]['chapterid']."',chaptername='".$data[0]['chaptername']."'  ,zhixu=$sx , lastvisit=$shijiancuo where caseid='".$usershujia[0]['caseid']."';");
        }
        //更新记录时间
        if($usercase){
        	$Model->Query("UPDATE jieqi_article_bookcase SET chapterid='".$data[0]['chapterid']."'  where caseid='".$usercase[0]['caseid']."';");
        	$Model->Query("UPDATE jieqi_article_bookcase SET chaptername='".$data[0]['chaptername']."'  where caseid='".$usercase[0]['caseid']."';");
            $Model->Query("UPDATE jieqi_article_bookcase SET zhixu=$sx  where caseid='".$usercase[0]['caseid']."';");
            $Model->Query("UPDATE jieqi_article_bookcase SET lastvisit=$shijiancuo  where caseid='".$usercase[0]['caseid']."';");
        }else{
        	$flag=1;
        	$cid=$data[0]['chapterid'];
        	$cname=$data[0]['chaptername'];
    		$sortname = $Model->Query("INSERT INTO jieqi_article_bookcase(articleid,userid,flag,chapterid,chaptername,zhixu,lastvisit)VALUES('$articleid','$userid','$flag','$cid','$cname','$sx','$shijiancuo')");
        }
        //加入浏览量
        $datas = $Model->Query("SELECT * FROM orders where aid='".$articleid."' and user_id='".$userid."' and path='".$shu."' and state=1 ");
        $quanji = $Model->Query("SELECT * FROM orders where aid='".$articleid."' and user_id='".$userid."' and path=0 and state=1 ");//购买全集
        if($datas  || $quanji || $mianfei>=$sx)//判断是否已经购买
        {
            $data[0]['du']=1;   
        }else{
            $data[0]['du']=0;
        }
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

	//女频首页
	public function pingdao(){ 

		if($_REQUEST['page']==0)
		{
		$page=2;
	    }

		
		else if($_REQUEST['page']>0)
		{
		$page=$_REQUEST['page']+2;
	    }

	    else
	    {
	    $page=0;
	    }

        $pindao=$_REQUEST['pindao'];
		
		$Model = M();
		$data = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=".$pindao." order by paixu limit $page,1 ");


	    foreach ($data as $key => $value) {

        	$xiaoshu = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$value['id']."%';");

			$sum = count($xiaoshu);

            $arr = [];
            $container = [];
            if($sum >= 4){
                for ($i=0; $i < 4; $i++) { 
                    $num = mt_rand(0,$sum-1);

                    if(!in_array($num,$arr)){
                        $arr[] = $num;
                    }else{
                        $i--;
                    }
                }
                foreach ($arr as $v) {
                    $container[] = $xiaoshu[$v];
                }
                $xiaoshu = $container;
            }

            $xiaoshu3 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$value['id']."%' limit 4,300000;");

            $sum = count($xiaoshu3);

            $arr = [];
            $container = [];
            if($sum >= 3){
                for ($i=0; $i < 3; $i++) { 
                    $num = mt_rand(0,$sum-1);

                    if(!in_array($num,$arr)){
                        $arr[] = $num;
                    }else{
                        $i--;
                    }
                }
                foreach ($arr as $v) {
                    $container[] = $xiaoshu3[$v];
                }
                $xiaoshu3 = $container;
            }
            

          	$data[0]['xiaoshuo']=$xiaoshu;
          	$data[0]['xiaoshuo1']=$xiaoshu3;
	    	
	    }

		$data1 = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=".$pindao." order by paixu limit 0,1 ");

		$data2 = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=".$pindao." order by paixu limit 1,1 ");

		$xiaoshu1 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$data1[0]['id']."%';");

		$sum = count($xiaoshu1);

        $arr = [];
        $container = [];
        if($sum >= 3){
            for ($i=0; $i < 3; $i++) { 
                $num = mt_rand(0,$sum-1);

                if(!in_array($num,$arr)){
                    $arr[] = $num;
                }else{
                    $i--;
                }
            }
            foreach ($arr as $v) {
                $container[] = $xiaoshu1[$v];
            }
            $xiaoshu1 = $container;
        }

		$data1[0]['xiaoshuo']=$xiaoshu1;


		$xiaoshu2 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$data2[0]['id']."%';");

		$sum = count($xiaoshu2);

        $arr = [];
        $container = [];
        if($sum >= 6){
            for ($i=0; $i < 6; $i++) { 
                $num = mt_rand(0,$sum-1);

                if(!in_array($num,$arr)){
                    $arr[] = $num;
                }else{
                    $i--;
                }
            }
            foreach ($arr as $v) {
                $container[] = $xiaoshu2[$v];
            }
            $xiaoshu2 = $container;
        }

		$data2[0]['xiaoshuo']=$xiaoshu2;


		$tongzhi = $Model->Query("SELECT title,id FROM system where types=1 order by id desc limit 0,1;");




		$data = array(
			"xiaoshuo"=>$data,
			"xiaoshuo1"=>$data1[0],
			"xiaoshuo2"=>$data2[0],
			"tongzhi"=>$tongzhi[0],
			);
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

    /**
     * dudj修改
     * 按照排序进行排序和后台保持一致
     * 小说分类 2级分类
     */
	public function fenlei(){ 
		$Model = M();
        $pindao=$_REQUEST['pindao'];
		$data = $Model->Query("SELECT imgurl,sortid,shortname FROM jieqi_article_sort  where `types`=".$pindao." and layer=0 order by sortnum desc");
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

		//参数id 筛选  start
		if(!isset($_REQUEST['id']) || !$_REQUEST['id']){
			$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname,t.biaoqian FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid order by t.allvisit desc limit $page,10 ");
		}else{
			$res = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname,t.biaoqian FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid order by t.allvisit desc");

			foreach ($res as $k => $v) {
				if(strpos($v['biaoqian'],',') !== false){
					$res[$k]['biaoqian'] = explode(',',$v['biaoqian']);
				}else{
					$v['biaoqian'] = $v['biaoqian'].',';
					$res[$k]['biaoqian'] = explode(',',$v['biaoqian']);
					unset($res[$k]['biaoqian'][1]);
				}
			}

			$data = [];
			foreach ($res as $j => $y) {
				if(in_array($pindao,$y['biaoqian'])){
					$data[] = $res[$j];
				}
			}

			$arr = [];
			if($page == 0){
				for ($i=0; $i < 10; $i++) { 
					$arr[] = $data[$i];
				}
			}else{
				$num = $page *10;
				for ($i=$num; $i < ($num + 10); $i++) { 
					$arr[] = $data[$i];
				}
			}

			$data = [];
			foreach ($arr as $key => $value) {
				if($value){
					$container['author'] = $value['author'];
					$container['images'] = $value['images'];
					$container['articlename'] = $value['articlename'];
					$container['intro'] = $value['intro'];
					$container['articleid'] = $value['articleid'];
					$container['size'] = $value['size'];
					$container['shortname'] = $value['shortname'];
					$data[] = $container;																		
				}
			}
		}
		//参数id 筛选  end

		// $data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.biaoqian like '%".$pindao."%' order by t.allvisit desc limit $page,10 ");
		
        foreach ($data as $key => $value) {
	    	$gen=floor($value['articleid']/1000);
	    	$data[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
	    }
		
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

public function zhangjie()
{
	$id=$_REQUEST['id'];
		$userid=$_REQUEST['user_id'];
		$Model = M();

$data = $Model->Query("SELECT saleprice FROM jieqi_article_article where articleid=".$id.";");

//章节情况
                $zhangjie = $Model->Query("SELECT COUNT(*) AS count  FROM jieqi_article_chapter where articleid=".$id.";");
                   $zongshu=$zhangjie[0]['count'];
                 $zhengshu=($zongshu/100);
               
                 $yushu=($zongshu%100);
                  $jiage=(string)100*$data[0]['saleprice'];
                 //组一下可以购买的章节
                   $zj="";
                 $shuzu='[';
                  for ($i=1; $i <= $zhengshu; $i++) { 
                  
                  $datas = $Model->Query("SELECT * FROM orders where aid='".$id."' and user_id='".$userid."' and path='".$i."' and state=1 ");
                  if($datas)
                  {

                  	$mai='1';
                  }
                  else
                  	{

                  	$mai='0';
                  } 
                  $jieshu1=($i-1)*100+1;
                  $jieshu2=$i*100;
                         if($i!=$zhengshu)
                         {
                          $shuzu=$shuzu.'{"zj":'.$i.',"jiage":'.$jiage.',"mai":'.$mai.',"kaishi":'.$jieshu1.',"jieshu":'.$jieshu2.'},';
                         }
                         if($i==$zhengshu && $yushu==0)
                         {
                          $shuzu=$shuzu.'{"zj":'.$i.',"jiage":'.$jiage.',"mai":'.$mai.',"kaishi":'.$jieshu1.',"jieshu":'.$jieshu2.'}]';
                         }
                         else if($i==$zhengshu && $yushu>0)
                         {
                         	 $shuzu=$shuzu.'{"zj":'.$i.',"jiage":'.$jiage.',"mai":'.$mai.',"kaishi":'.$jieshu1.',"jieshu":'.$jieshu2.'},';
                         }

                    


                    	
                    } 

                     if($yushu>0)
                      {
                      	$i=(string)$zhengshu;
                      	$datass = $Model->Query("SELECT * FROM orders where aid='".$id."' and user_id='".$userid."' and path='".$i."' and state=1 ");
                  if($datass)
                  {

                  	$mai='1';
                  }
                  else
                  	{

                  	$mai='0';
                  }
                  $jieshu1=$i*100+1-$yushu;
                      	$jiages=(string)$yushu*$data[0]['saleprice'];
                       $shuzu=$shuzu.'{"zj":'.$i.',"jiage":'.$jiages.',"mai":'.$mai.',"kaishi":'.$jieshu1.',"jieshu":'.$zongshu.'}]';

                       }
 echo   $shuzu;
                  
             
               

}
    //书籍详情 
	public function bookdetail()
    {
		$id=$_REQUEST['id'];
		$userid=$_REQUEST['user_id'];

		$Model = M();

		$data = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.saleprice,t.salenum,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype,t.text,t.duanping,t.collectvirtual FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.articleid=".$id.";");
        $data[0][lasttime]=date("Y-m-d H:i",$data[0]['lastupdate']);
        $gen=floor($data[0]['articleid']/1000);
        $data[0][imagess]=$gen.'/'.$data[0]['articleid'].'/'.$data[0]['articleid'].'s.jpg';

        //章节总数
        $zjsum = $Model->Query("SELECT COUNT(*) AS count  FROM jieqi_article_chapter where articleid=".$id.";");
               
        $data[0]['zjsum']=$zjsum[0]['count'];

        //购买情况
        $goumai = $Model->Query("SELECT COUNT(*) AS count FROM orders where aid=".$id." and user_id=".$userid." and state=1 ;");
            
        $data[0]['goumai']=$goumai[0]['count'];

        //是否已经加入书架
        $shujia = $Model->Query("SELECT COUNT(*) AS count FROM jieqi_article_bookcase where articleid=".$id." and userid=".$userid." and flag=0 ;");
                    
        $data[0]['shujia']=$shujia[0]['count'];      
            
        //评论数量
        $pingluns = $Model->Query("SELECT COUNT(*) AS count FROM new_reply where aid=".$id.";");
        if(!$pingluns){
            $data[0]['pingluns']=0;
        }else{
            $data[0]['pingluns']=$pingluns[0]['count'];            
        }
        //收藏数量
        $shoucangs = $Model->Query("SELECT COUNT(*) AS count FROM jieqi_article_bookcase where flag=0 and articleid=".$id.";");
        if(!$shoucangs){
            $data[0]['shoucangs'] = 0;  
        }else{
            $data[0]['shoucangs']=$shoucangs[0]['count'];            
        }
        //dudj修改 将收藏真实值和虚拟值累加
		$data[0]['shoucangs'] += $data[0]['collectvirtual'];
		unset($data[0]['collectvirtual']);
        $suodudata = $Model->Query("SELECT t1.shortname,t.images,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid order by t.allvisit limit 0,4;");

        foreach ($suodudata as $key => $value) {
		    $gen=floor($value['articleid']/1000);
		    $suodudata[$key]['imagess']=$gen.'/'.$value['articleid'].'/'.$value['articleid'].'s.jpg';
		  }

        $ahdata = $Model->Query("SELECT t1.shortname,t.images,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.sortid=".$data[0]['sortid']." limit 0,4;");

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

        if($usercase[0]['userid']){

        }else{
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
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.fenlei like'%".$sortid."%'order by t.allvisit desc limit $page,10");
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
		$userid=$_REQUEST['userid'];
				if($_REQUEST['page'])
		{
		$page=$_REQUEST['page']*15;
	    }
	    else
	    {
	    $page=0;
	    }

		$Model = M();
		$data = $Model->Query("SELECT chapterid,articleid,chaptername,attachment FROM jieqi_article_chapter where articleid =".$articleid." order by chapterid limit $page,15 ;");
		// var_dump($data);
		foreach ($data as $key => $value) {
			$data[$key]['paixu']=$key + $page;
                      
                       if($key<100)
            {
             $shu=1;
            }
              else if($key%100==0)
             {
             $shu=$key/100;	
             }
             else if($key%100!=0)
             {
             $shu=($key/100)+1;	
             }
                
                $book = $Model->Query("SELECT saleprice FROM jieqi_article_article where articleid =".$articleid.";");
             
             $mianfei=$book[0]['ffee'];//免费章节
        // $counts = $Model->Query("SELECT COUNT() AS count FROM jieqi_article_chapter where articleid =".$articleid."");
         

		// $datass = $Model->Query("SELECT chapterid,articlename,chaptername,texts FROM jieqi_article_chapter where articleid =".$articleid." order by chapterid limit $shu,1;");
               
                 

                      $datas = $Model->Query("SELECT * FROM orders where aid='".$articleid."' and user_id='".$userid."' and path='".$shu."' and state=1 ");
                      

                      $quanji = $Model->Query("SELECT * FROM orders where aid='".$articleid."' and user_id='".$userid."' and path=0 and state=1 ");//购买全集

			// $yimai = $Model->Query("SELECT * FROM orders where book_id =".$value['chapterid']." and user_id=".$userid.";");
               if($datas  || $quanji || $mianfei>=$key)//判断是否已经购买
               {
                 $data[$key]['mai']=1;
               }
               else
               {
               	$data[$key]['mai']=0;
               }

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
		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.typeid like '%".$biaoqian."%'  order by t.$paixu desc limit $page,10");
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
              
              $data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where t.fenlei like '%".$_REQUEST['sortid']."%'  order by t.articleid limit 0,10");

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
     $where=$where." and  t.sortid  like '%".$_REQUEST['sortid']."%'";
       }
       if($_REQUEST['articletype'])//是否已完结
       {
     $where=$where." and  t.articletype =".$_REQUEST['articletype']."";
       }
       if($_REQUEST['typeid'])//是否已完结
       {
     $where=$where." and  t.typeid =".$_REQUEST['typeid']."";
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
	// public function chapterread(){ 
	// 	$articleid=$_REQUEST['id'];
	// 	$Model = M();
	// 	$data = $Model->Query("SELECT chapterid,articlename,chaptername,texts FROM jieqi_article_chapter where articleid =".$articleid." order by chapterid;");
	// 	$data = array($data);
	// 	echo getSuccessJson($data,'操作成功'); 
	// }

    /**
     * 获取文章章节接口
     */
	public function chapterread(){ 
        $articleid = $_REQUEST['id'];
        $userid = $_REQUEST['userid'];
        $path = 1;
        $Model = M();
        $shijan = date('Y-m-d H:i:s');
        $usercase = $Model->Query("SELECT * FROM jieqi_article_bookcase where articleid='".$articleid."'and userid='".$userid."'and flag=1;");
        if($usercase)//检测是否有阅读记录
        {
            $z = $usercase[0]['zhixu'];
        }else{
            $z = 0;
        }
		$data = $Model->Query("SELECT chapterid,articlename,chaptername,attachment FROM jieqi_article_chapter where articleid =".$articleid." order by chapterid limit $z,1;");
        //获取章节数
		$shuliang = $Model->Query("SELECT COUNT(*) as count FROM jieqi_article_chapter where articleid =".$articleid.";");
        //随机获取广告
        $aid = 1;
        $adcount = $Model->Query("select COUNT(*) AS count from book_ad where path='".$path."' and bookid like '%".$aid."%' ");//广告
        $countss = $adcount[0]['count'];
        $x = rand(0,$countss);
        $result = $Model->Query("select * from book_ad where path='".$path."' and bookid like '%".$aid."%' order by id  desc limit $x,1");
        $dataRes = [
            'sl' =>$shuliang[0]['count'],
            'z' => $z,
            'gotos' => $result[0]['gotos'],
            'content' => $result[0]['content'],
            'title' => $result[0]['title'],
            'web_url' => $result[0]['web_url'],
        ];
        $res = array_merge($data[0],$dataRes);
        echo getSuccessJson($res,'操作成功');
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


		$data = $Model->Query("SELECT t.author,t.images,t.articlename,t.intro,t.articleid,t.size,t1.shortname,t.saleprice,t.salenum,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid =t1.sortid where articleid =".$articleid.";");



             $pingluns = $Model->Query("SELECT COUNT(*) AS count FROM new_reply where aid=".$articleid.";");
              $data[0]['pingluns']=$pingluns[0]['count'];
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
     $xing=$_REQUEST['xing'];
    $content=$_REQUEST['content'];
    $addtime=date("Y-m-d H:i:s");
    $Model = M();
     if($userid>1){
     $sortname = $Model->Query("INSERT INTO new_reply(aid,user_id,cid,content,addtime,xing)VALUES('$aid','$userid','$cid','$content','$addtime','$xing')");
      
    $data = array('msg'=>'发表成功','code'=>'200');
         }
         else
         {
     $data = array('msg'=>'发表','code'=>'201');
         }
    echo getSuccessJson($data,'操作成功'); 
  }

	//添加评论
  public function addlike(){ 
    $rid=$_REQUEST['rid'];
    $lik=M('new_reply')->find(I('rid'));
    $dian['uid']=I('uid');
    $dian['pid']=$lik['id'];
    $zan=M('new_rdian')->where($dian)->find();
    if($zan>0){
    	$data = array('msg'=>'发表失败','code'=>'220');
    	
    }else{
    	M('new_rdian')->add($dian);
    	$Model = M();
     
     	$sortname = $Model->Query("UPDATE new_reply set likes=likes+1 where id='".$rid."'");
      	if($sortname>0){
    		$data = array('msg'=>'发表成功','code'=>'200');
          }
    	
	}
	echo json_encode($data); 
  }


         //
       
            
        //     $d['id']=I('dian');
        //     $d['likes']=$lik['likes']+1;
        //     $sql=M('new_reply')->save($d);

        //     if($sql>0){
        //       echo '<script>location.href="pinglun.html?id='.I('id').'&shujia=1"</script>';
       
        //     }
        // }

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

    public function reread()
    {
        if(!isset($_REQUEST['user_id'])){
            $returnarr = ['code' => 220,'msg'=>'缺少参数user_id'];           
            $this->ajaxReturn($returnarr);
        }
        if(!isset($_REQUEST['articleid'])){
            $returnarr = ['code' => 220,'msg'=>'缺少参数articleid'];           
            $this->ajaxReturn($returnarr);
        }
        

        $userid=$_REQUEST['user_id'];

        $articleid=$_REQUEST['articleid'];

        $lastvisit = time();

        $res = M('jieqi_article_bookcase')->where(['userid'=>$userid,'articleid'=>$articleid])->save(['lastvisit'=>$lastvisit]);

        if($res !== false){
            $returnarr = ['code' => 200,'msg'=>'操作成功'];           
            $this->ajaxReturn($returnarr);
        }else {
            $returnarr = ['code' => 220,'msg'=>'操作失败'];           
            $this->ajaxReturn($returnarr);            
        }


    }




}

?>
