	      <?php include("conn.php");
             mysql_query('SET NAMES UTF8'); 


//$u=mysql_query("select MAX(user_id) from user ");
 //$user=mysql_fetch_array($u);//获得最大ID

    
  
     $rert32=mysql_query("select *from user ");
     while($rowf3=mysql_fetch_array($rert32))
     {
          $userid=rand(30,1650);
          $dianzan=rand(201,1000);
          $huifu=rand(331,1000);
          $fenxiang=rand(331,9999);
          $fensi=rand(100,2000);



 $rert33=mysql_query("UPDATE user SET sharecount = '".$userid."' where user_id='".$rowf3[user_id]."'");//随机填充数据
  $rert34=mysql_query("UPDATE user SET talkcount=$huifu where user_id=$rowf3[user_id]");//随机填充数据
   $rert35=mysql_query("UPDATE user SET dacount=$dianzan where user_id=$rowf3[user_id]");//随机填充数据
    $rert36=mysql_query("UPDATE user SET tingcount=$fenxiang where user_id=$rowf3[user_id]");//随机填充数据
    $rert37=mysql_query("UPDATE user SET fans=$fensi where user_id=$rowf3[user_id]");//随机填充数据
    $rert37=mysql_query("UPDATE user SET attentions=$fensi where user_id=$rowf3[user_id]");//随机填充数据


//echo $userid,"#",$dianzan,"+",$fenxiang,"Y",$huifu,"/",$toutiao;


      // for($i=0;$i<=30;$i++)
      // {

       //	$usersid=rand(30,$user[user_id]);

      // $rert38=mysql_query("INSERT INTO sharetalk (user_id,talk_id) VALUES ('$usersid','$rowf3[talk_id]')");
       //   }
}


   echo "分配成功";

?>