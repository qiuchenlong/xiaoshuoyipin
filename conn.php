<?php 
error_reporting(0);
$conn=mysql_connect('ypmysql','root','123456') or die('连接失败！'.mysql_error());
mysql_select_db('k_xiaoshuoyipin',$conn) or die('数据库选择失败:' . mysql_error());
mysql_query('SET NAMES UTF8');  
@session_start(); 
//$rert=mysql_query("select * from app_user where userid='".$_SESSION['userid']."'"); 
//$admin=mysql_fetch_array($rert);


 //$der=1;$count5=mysql_query("select count(*) from app_car  where  userid='".$_SESSION['userid']."' and state='".$der."' ");

// 购物车 计数
//$rs5=mysql_fetch_array($count5);
//$t5=$rs5[0];

?>
