	      <?php include("conn.php");
             mysql_query('SET NAMES UTF8'); 

	  

class MyPrizeBean
{
	
	public $shang;
	
	function __construct($shang)
	{
		
	
		$this->shang      = $shang;
	
	}
}





  $prize = array();
 
  
     $rert32=mysql_query("select *from system where system_id=1");
     $rowf3=mysql_fetch_array($rert32);




   
		$prize[] = new MyPrizeBean($rowf3['shang']);
		


echo json_encode($prize);


?>