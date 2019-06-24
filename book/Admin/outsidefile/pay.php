<?php 
require("./conn.php");
$number=$_REQUEST[number];
$query = mysql_query("select * from goodsorders where number='".$number."'");
while ($row = mysql_fetch_assoc($query)) {
	$result[] = $row;
}
// $result=$mysql->getAll($query);
if (!$result) {
	echo "<script>alert('该订单号不存在!');</script>";
}else{
	if (isset($_REQUEST[state])) {
			$flag=true;
			$periods=array();
			$number=array();
			foreach ($result as $v) {
				// 将期号和数量取出放在数组里
				$periods[]=$v[fk_number];
				$number[]=$v[quantity];
				// 将期号和数量取出放在数组里 end
				if ($v[state]==2) {
					$flag=false;
				}
			}

			if ($flag) {
				for($i=0;$i<count($periods);$i++){
					$sql = mysql_query("select * from periods where fk_number='".$periods[$i]."'");
					$periods_numbers = mysql_fetch_assoc($sql);
					// $periods_numbers=$mysql->getRow($sql);

					if ($periods_numbers[headcount]!=0) {
						$over=($periods_numbers[existing]+$number[$i])/$periods_numbers[headcount];
						$over=number_format("$over",3,".","")*100; 
						if($over<2&&$over>0){
							$over=1;
						}
					}else{
						$over=0;
					}
					$sql = mysql_query("UPDATE periods set existing=existing+".$number[$i].",remaining=remaining-".$number[$i].",percentage='".$over."' where fk_number='".$periods[$i]."'");
					// $sql="UPDATE periods set existing=existing+".$number[$i].",remaining=remaining-".$number[$i].",percentage='".$over."' where fk_number='".$periods[$i]."'";
					// $mysql->query($sql);
				}
				$update_result = mysql_query("UPDATE goodsorders SET state='2' where number='".$_REQUEST[number]."'");

				// $update="UPDATE goodsorders SET state='2' where number='".$_REQUEST[number]."'";
				// $update_result=$mysql->query($update);

				$user_query = mysql_query("select * from user where id='".$_REQUEST[fk_userid]."'");
				$user = mysql_fetch_assoc($user_query);
				// $user_query="select * from user where id='".$_REQUEST[fk_userid]."'";
				// $user=$mysql->getRow($user_query);

				if ($user[money]>=$_REQUEST[totalvalue]) {
					$money=$user[money]-$_REQUEST[totalvalue];
					$money_result = mysql_query("UPDATE user SET money='".$money."' where id='".$_REQUEST[fk_userid]."'");

					// $money_query="UPDATE user SET money='".$money."' where id='".$_REQUEST[fk_userid]."'";
					// $money_result=$mysql->query($money_query);
					
					if ($update_result) {
						echo "<script>alert('支付成功');window.location.href='afterpay.php?pay=1';</script>";
					}else{
						echo "<script>alert('支付失败');window.location.href='afterpay.php?pay=2';</script>";
					}
				}else{
					echo "<script>alert('账户余额不足');window.location.href='afterpay.php?pay=3';</script>";
				}
			}else{
				echo "<script>alert('该账号已支付过了');window.location.href='afterpay.php?pay=4';</script>";
			}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>支付订单</title>
	<meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <style type="text/css">
    	*{margin: 0;padding: 0;list-style: none;}
    	em{font-style: normal;}

    	html,body{height: 100%;position: relative;}
    	.payOrder-msg{padding: 10px;}
    	.payOrder-msg em{font-weight: bold;font-size: 16px;}
    	.payOrder-msg p{margin-top: 10px;font-size: 14px;color: #999;}

    	.payOrder-total{margin: 0 10px;padding:10px;color: #333;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;}
    	.payOrder-total span{color: red;float: right;}

		.payOrder-deliveryAdd{padding: 10px;color: #999;font-size: 14px;}

		.payOrder-payment{margin: 0 10px;color: #333;border-top: 1px solid #ddd;}
		.payOrder-payment li{padding:10px;border-bottom: 1px solid #ddd;line-height: 16px;font-size: 14px;}
		.payOrder-payment .title{line-height: 20px;font-size: 16px;}
		.payOrder-payment li span{ float: right;color: red; }
    	
    	.payOrder-btn{position:absolute;bottom:0;left:3%;display: block;width: 90%;margin: 10px 10px;border-top: 1px solid #eee;background: red;color: #fff;outline: none;border: none;line-height: 30px;}
    </style>
</head>
<body>
<?php 
$totalprice=0;
foreach ($result as $v) { 
$totalprice+=$v[totalvalue];
$fk_userid=$v[fk_userid];
?>
	<div class="payOrder-total">商品合计<span><?php echo $v[totalvalue]; ?>元</span></div>
	<div class="payOrder-deliveryAdd">
		<p>订单号：<span><?php echo $v[number]; ?></span></p>
	</div>
	<ul class="payOrder-payment">
		<li class="title">支付方式<span><?php echo $v[totalvalue]; ?>元</span></li>
		<li>夺宝币支付<span>√</span></li>
	</ul>
<?php } ?>
	<button class="payOrder-btn"><a href="?state=2&number=<?php echo $_REQUEST[number]; ?>&fk_userid=<?php echo $fk_userid ; ?>&totalvalue=<?php echo $totalprice; ?>">确认支付</a></button>
</body>
</html>