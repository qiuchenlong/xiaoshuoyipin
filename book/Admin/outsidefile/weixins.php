	      <?php include("conn.php");
             mysql_query('SET NAMES UTF8'); 

	  

class MyPrizeBean
{
	public $dizhi;
	
	function __construct($dizhi)
	{
		$this->dizhi      = $dizhi;
		
	}
}





   $states=1;//充值成功后逻辑处理
   $srat=mysql_query("update top_up set state='".$states."' where numbers='".$_REQUEST[danhao]."'");
   
     $rert30=mysql_query("select *from top_up  where numbers='".$_REQUEST[danhao]."'");
     $rowf=mysql_fetch_array($rert30);
	 
	// $srat=mysql_query("update user set money=money+'".$rowf[price]."' where id='".$rowf[fk_userid]."'");
	 
  
   $mydizhi="12";

  $prize[] = new MyPrizeBean($mydizhi);
		


echo json_encode($prize);


?>