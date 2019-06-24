<?php 
header('Content-Type:text/html;charset=utf8');
$conn=@mysql_connect('ypmysql','root','123456') or die('Á¬½ÓÊ§°Ü£¡'.mysql_error());
mysql_select_db('db_weifx',$conn) or die('Êý¾Ý¿âÑ¡ÔñÊ§°Ü:' . mysql_error());
mysql_query('SET NAMES UTF8');  
@session_start(); 
error_reporting(E_ALL^E_NOTICE); 

?>
