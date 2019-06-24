	      <?php include("conn.php");
             mysql_query('SET NAMES UTF8'); 
$kong="";

$rert55=mysql_query("UPDATE talkreply SET user_id = '".$kong."'");//

 $rert56=mysql_query("UPDATE talkreply SET talk_id = '".$kong."'");//初始化数据



// $u=mysql_query("select MAX(user_id) from user ");
 //$user=mysql_fetch_array($u);//获得最大ID

    
    $t=mysql_query("select MAX(talkreply_id) as talkreply_id  from talkreply ");
 $rids=mysql_fetch_array($t);//获得最大ID

 $maxid=(int)$rids[talkreply_id];
    //$rid=19;

 
  $rert39=mysql_query("select *from talk ");
     while($rowf4=mysql_fetch_array($rert39))
     {

   ///  $rert32=mysql_query("select *from talkreply");
     //$rowf3=mysql_fetch_array($rert32);
     
          


for($i=0;$i<=6;$i++)
{

  $userid=rand(30,650);
  $talkid=rand(17,$maxid);

   $ts=mysql_query("select * from talkreply where talkreply_id='".$talkid."' ");
 $rid=mysql_fetch_array($ts);//判断是否已经分配了


if($rid[user_id]!="")
{

        
 $rert33=mysql_query("UPDATE talkreply SET user_id = '".$userid."' where talkreply_id='".$talkid."'");//随机填充数据

 $rert34=mysql_query("UPDATE talkreply SET talk_id = '".$rowf4[talk_id]."' where talkreply_id='".$talkid."'");//随机填充数据
  }
 //$rid++;
}
//echo $userid,"#",$dianzan,"+",$fenxiang,"Y",$huifu,"/",$toutiao;


       //for($i=0;$i<=$fenxiang;$i++)
      // {

       //	$usersid=rand(30,$user[user_id]);

      // $rert38=mysql_query("INSERT INTO sharetalk (user_id,talk_id) VALUES ('$usersid','$rowf3[talk_id]')");
      //    }

}


   echo "分配成功";

?>