	      <?php include("conn.php");
             mysql_query('SET NAMES UTF8'); 


 $u=mysql_query("select MAX(user_id) from user ");
 $user=mysql_fetch_array($u);//获得最大ID

    
  
     $rert32=mysql_query("select *from talk where talk_id !=1");
     while($rowf3=mysql_fetch_array($rert32))
     {
          $userid=rand(30,650);
          $dianzan=rand(201,5555);
          $huifu=rand(331,9999);
          $fenxiang=rand(331,9999);
          $toutiao=rand(0,1);



 $rert33=mysql_query("UPDATE talk SET user_id = '".$userid."' where talk_id='".$rowf3[talk_id]."'");//随机填充数据
  $rert34=mysql_query("UPDATE talk SET replycount=$huifu where talk_id=$rowf3[talk_id]");//随机填充数据
   $rert35=mysql_query("UPDATE talk SET likecount=$dianzan where talk_id=$rowf3[talk_id]");//随机填充数据
    $rert36=mysql_query("UPDATE talk SET sharecount=$fenxiang where talk_id=$rowf3[talk_id]");//随机填充数据
    $rert37=mysql_query("UPDATE talk SET toutiao=$toutiao where talk_id=$rowf3[talk_id]");//随机填充数据


//echo $userid,"#",$dianzan,"+",$fenxiang,"Y",$huifu,"/",$toutiao;


      // for($i=0;$i<=30;$i++)
      // {

       //	$usersid=rand(30,$user[user_id]);

      // $rert38=mysql_query("INSERT INTO sharetalk (user_id,talk_id) VALUES ('$usersid','$rowf3[talk_id]')");
       //   }
}


   echo "分配成功";

?>