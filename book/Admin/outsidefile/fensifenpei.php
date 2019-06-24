	      <?php include("conn.php");
             mysql_query('SET NAMES UTF8'); 


$u=mysql_query("select MAX(user_id) as user_id from user ");
 $user=mysql_fetch_array($u);//获得最大ID

    
   $maxid=(int)$user[user_id];

     $rert32=mysql_query("select *from user ");
     while($rowf3=mysql_fetch_array($rert32))
     {
          



 //$rert33=mysql_query("UPDATE user SET sharecount = '".$userid."' where user_id='".$rowf3[user_id]."'");

 //随机填充数据
  //$rert34=mysql_query("UPDATE user SET talkcount=$huifu where user_id=$rowf3[user_id]");//随机填充数据
  // $rert35=mysql_query("UPDATE user SET dacount=$dianzan where user_id=$rowf3[user_id]");//随机填充数据
   // $rert36=mysql_query("UPDATE user SET tingcount=$fenxiang where user_id=$rowf3[user_id]");//随机填充数据
    $rert37=mysql_query("UPDATE user SET fans=fans+30 where user_id=$rowf3[user_id]");//随机填充数据
   // $rert37=mysql_query("UPDATE user SET attentions=$fensi where user_id=$rowf3[user_id]");//随机填充数据


//echo $userid,"#",$dianzan,"+",$fenxiang,"Y",$huifu,"/",$toutiao;


       for($i=0;$i<=30;$i++)
       {

       	$usersid=rand(30,$maxid);

       $rert38=mysql_query("INSERT INTO follow (user_id,to_user_id) VALUES ('$usersid','$rowf3[user_id]')");
         }
}


   echo "分配成功";

?>