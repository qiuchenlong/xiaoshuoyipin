	      <?php include("conn.php");
             mysql_query('SET NAMES UTF8'); 

	  


     $rert32=mysql_query("UPDATE talk SET money = 0 ");
     $rowf3=mysql_fetch_array($rert32);
    echo "更换成功";

?>