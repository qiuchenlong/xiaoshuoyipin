<?php 
header('Content-Type:text/html;charset=utf8');
$conn=@mysql_connect('localhost','root','') or die('����ʧ�ܣ�'.mysql_error());
mysql_select_db('db_feida',$conn) or die('���ݿ�ѡ��ʧ��:' . mysql_error());
mysql_query('SET NAMES UTF8');  
@session_start(); 
error_reporting(E_ALL^E_NOTICE);

?>
