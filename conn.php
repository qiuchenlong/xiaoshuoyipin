<?php 
error_reporting(0);
$conn=mysql_connect('ypmysql','root','123456') or die('����ʧ�ܣ�'.mysql_error());
mysql_select_db('k_xiaoshuoyipin',$conn) or die('���ݿ�ѡ��ʧ��:' . mysql_error());
mysql_query('SET NAMES UTF8');  
@session_start(); 
//$rert=mysql_query("select * from app_user where userid='".$_SESSION['userid']."'"); 
//$admin=mysql_fetch_array($rert);


 //$der=1;$count5=mysql_query("select count(*) from app_car  where  userid='".$_SESSION['userid']."' and state='".$der."' ");

// ���ﳵ ����
//$rs5=mysql_fetch_array($count5);
//$t5=$rs5[0];

?>
