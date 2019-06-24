<?php 

include_once("conn.php");

 $k = $_REQUEST['kaishiid'];
		$e = $_REQUEST['endid'];
$null="0";
$yqz=mysql_query("select chapterid from jieqi_article_chapter  where  chapterid>=".$k." and chapterid<=".$e." and texts='".$null."'; ");
while($yaoqing=mysql_fetch_array($yqz))
{
  echo $yaoqing['chapterid'];
   $srat1=mysql_query("delete from jieqi_article_chapter  where chapterid='".$yaoqing['chapterid']."'");//
   
   }



?>
