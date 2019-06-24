<?php
include("../conn.php");
error_reporting(0);
include("cnof.php");

$dir = str_replace("\\", "/", dirname(__FILE__)."/file/");

$string = file_get_contents('php://input');


if (isset($string)) {
	
	$filename = $dir.'back_data.txt';
	if (!file_exists($dir)) {
		mkdir($dir,0777);
	}
	$fp = fopen($filename,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".date("Y-m-d H:i:s")."\r\n"."接收数据为:"."\r\n".$string."\r\n");
	flock($fp, LOCK_UN);
	fclose($fp);

	$xml = simplexml_load_string($string);  //加载指定的xml文件,并读取到一个数组当中
	$arr = null;

	$arr = (string)$xml->sign;
	$out_trade_no = (string)$xml->out_trade_no;
	$return_code = (string)$xml->return_code;
	$result_code = (string)$xml->result_code;
	$out = trim($out_trade_no);
	$ret = trim($return_code); 
	$resul = trim($result_code);
	$resg = trim($arr);//sign



	$xml = new XMLReader();
	// $url = 'http://www.php230.com/baidu_sitemap1.xml';
	// $xml->open($url);
	$xml->XML($string);
	$assoc = xml2assoc($xml);
	$xml->close();

	if ($ret == "SUCCESS") {

		$res = $assoc[0]['value'];
		$i=0;
		$row=null;
		foreach ($res as $item) {
			$resf[] = $item;
			foreach ($resf as $key => $value) {
				$resulttag[$i] = $value['tag'];
				$resultvalue[$i] = $value['value'];
				
			}
			$row .= trim($resulttag[$i]).'='.trim($resultvalue[$i]).'&';
			$i++;

		}

		$signkey = strtoupper(md5($row.'key=acb6e126fa691a85af34205a5f6a5153'));
		
		if ($resul == "SUCCESS") {

		
	file_put_contents("a.txt", "aaaaaaa");
		
	// 添加红包
	$res = mysql_query("SELECT * FROM top_up_config order by quantity desc");
	$list = array();
	while($row = mysql_fetch_assoc($res)){
		$list[] = $row;
	}
	$up = 0;
	$down = 0;
	foreach($list as $v){
		if($mess['price'] >= $v['quantity']){
			$up = (int) $v['up_data'];
			$down = (int) $v['down_data'];
			break;
		}
	}
	if($up != 0){
		$data = urlencode("{\"up\":$up, \"down\":$down}");
		file_get_contents("http://www.fondfell.com/superDao/apis/128/Model_RedPacket/add_red_packet/index.php?uid=$uid&type=1&data=$data");
	}
	// --------
		
			
		
		$prize = array();
		$prize=explode("1244193002",$out);
		$danhao=$prize[1];
				
				$rert301=mysql_query("select *from goodsorders where  numbers='".$danhao."'");
$rowf1=mysql_fetch_array($rert301);
				if ($rowf1['state'] == 0) {
					  $states=1;
   $srat=mysql_query("update goodsorders set state='".$states."' where numbers='".$danhao."'");
					
					$str = "<xml>
  <return_code><![CDATA[SUCCESS]]></return_code>
  <return_msg><![CDATA[OK]]></return_msg>
</xml>";
					if ($srat) {
						echo($str);
					}
				
				}

			}else{
				$str = "<xml>
  <return_code><![CDATA[FAIL]]></return_code>
</xml>";
				echo ($str);exit;
			}

	
		
	}
}else{
	
	$filename = $dir.'error_log.txt';
	if (!file_exists($dir)) {
		mkdir($dir,0777);
	}
	$fp = fopen($filename,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".date("Y-m-d H:i:s")."\n".' 无数据传入'."\r\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}





?>