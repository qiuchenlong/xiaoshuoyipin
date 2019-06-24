<?php include("../common/conn.php");
mysql_query('SET NAMES UTF8'); 

class MyPrizeBean
{
	public $ordernumber;
	public $totalvalue;

	function __construct($ordernumber,$totalvalue)
	{
		$this->ordernumber      = $ordernumber;
		$this->totalvalue      = $totalvalue;
	}
}

$prize = array();
$fk_number=$_REQUEST[fk_number];
$quantity=$_REQUEST[quantity];
$gid=$_REQUEST[goodsid];
$totalvalue=array();
if(strpos($gid,',')>0){
	$arr1=explode(',', $fk_number);
	$arr2=explode(',', $gid);
	$arr3=explode(',', $quantity);
	$arr4=array();
	for($i=0;$i<count($arr1);$i++){
		$a=$arr1[$i];
	    $b=$arr2[$i];
	    $c=$arr3[$i];
	    $arr4[$a][$b]=$c;
	}
	
	foreach($arr4 as $key=>$val){
		$goodsql=mysql_query("SELECT * from goods where id=$key");
		$goods=mysql_fetch_array($goodsql);
		$totalvalue[$key]=$goods[price]*$val;
	}
}else{
	$goodsql=mysql_query("SELECT * from goods where id=$gid");
	$goods=mysql_fetch_array($goodsql);
	$totalvalue[]=$goods[price]*$quantity;
}

$date=date('Y-m-d H:i:s',time());
$number=date('ymdhis',time()).$_REQUEST[userid];

if(count($totalvalue)>1){
	foreach($totalvalue as $k=>$v){
		$insersql=mysql_query("INSERT INTO goodsorders(number,fk_number,totalvalue,fk_userid,addtime,fk_goodsid) values('$number','$fk_number','$v','$_REQUEST[userid]','$date','$k')");
	}
}else{
	$insersql=mysql_query("INSERT INTO goodsorders(number,fk_number,totalvalue,fk_userid,addtime,fk_goodsid) values('$number','$fk_number','$totalvalue[0]','$_REQUEST[userid]','$date','$gid')");
}

$id=mysql_insert_id();

$ordersql=mysql_query("SELECT * from goodsorders where id=$id");
$order=mysql_fetch_array($ordersql);

$totalvalue=array_sum($totalvalue);


$prize[] = new MyPrizeBean($order[number],$totalvalue);
echo json_encode($prize);


?>
 