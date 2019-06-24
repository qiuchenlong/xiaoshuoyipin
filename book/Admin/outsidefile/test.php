	      <?php include("conn.php");
             mysql_query('SET NAMES UTF8'); 


 //$u=mysql_query("select MAX(user_id) from user ");
 //$user=mysql_fetch_array($u);//获得最大ID

        $t=mysql_query("select MAX(talkreply_id) as talkreply_id from talkreply ");
 $rids=mysql_fetch_assoc($t);//获得最大ID

// var_dump($rids);die;
 $maxid=$rids[talkreply_id];
    //$rid=19;

 echo $maxid;

  
  

?>