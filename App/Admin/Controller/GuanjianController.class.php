<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');

class GuanjianController extends Controller {
	
	
	
	//退换关键词
    public function quchu(){
        $ci = $_REQUEST["keywords"];
        $k = $_REQUEST['kaishiid'];
		$e = $_REQUEST['endid'];
		 $Model=M();
              $null='NULL';
            $goods = $Model->Query("select chapterid from jieqi_article_chapter where  chapterid>=".$k." and chapterid<=".$e.";");

              foreach ($goods as $key => $value) {
                    echo $value['chapterid'];
                      $id='2433';
                      $Model->Query("delete  from jieqi_article_chapter where  chapterid=2433 ");

        // $arr=M('jieqi_article_chapter')->delete($id);

              }

    }



}