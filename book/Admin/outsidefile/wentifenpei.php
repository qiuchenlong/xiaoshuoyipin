	      <?php include("conn.php");
             mysql_query('SET NAMES UTF8'); 


 $u=mysql_query("select MAX(user_id) from user ");
 $user=mysql_fetch_array($u);//获得最大ID

    
    $t=mysql_query("select MAX(user_id) from user ");
 $talk=mysql_fetch_array($t);//获得最大ID

  
     $rert32=mysql_query("select *from problem");
     while($rowf3=mysql_fetch_array($rert32))
     {
          $userid=rand(30,658);
          $talkid=rand(30,648);


 $rert33=mysql_query("UPDATE problem SET user_id = '".$userid."' where problem_id='".$rowf3[problem_id]."'");//随机填充数据

 $rert34=mysql_query("UPDATE problem SET to_user_id = '".$talkid."' where problem_id='".$rowf3[problem_id]."'");//随机填充数据

//echo $userid,"#",$dianzan,"+",$fenxiang,"Y",$huifu,"/",$toutiao;


       //for($i=0;$i<=$fenxiang;$i++)
      // {

       //	$usersid=rand(30,$user[user_id]);

      // $rert38=mysql_query("INSERT INTO sharetalk (user_id,talk_id) VALUES ('$usersid','$rowf3[talk_id]')");
      //    }
}


   echo "分配成功";

?>