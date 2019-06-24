	      <?php include("conn.php");
             mysql_query('SET NAMES UTF8'); 

	  
class MyPrizeBean
{
	public $code;
        public $xieyi;

	function __construct($code,$xieyi)
	{
		$this->code      = $code;
                $this->xieyi      = $xieyi;
	}
}



	$prize = array();
	
 
$rert30=mysql_query("select *from system  where system_id=1");
 $rowf=mysql_fetch_array($rert30);         
$der=100;
		  

$prize[] = new MyPrizeBean($der,$rowf[xieyi]);
echo json_encode($prize);


?>