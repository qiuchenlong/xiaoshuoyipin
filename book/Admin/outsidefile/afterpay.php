<?php 
switch ($_REQUEST[pay]) {
	case 1:
		$point="支付成功,返回app确认";
		break;
	case 2:
		$point="支付失败,返回app确认";
		break;
	case 3:
		$point="账户余额不足,返回app充值";
		break;
	case 4:
		$point="该账号已支付过了,返回app确认";
		break;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>支付订单</title>
	<meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <style type="text/css">
		.point{
			width: 100%;
			height: 10em;
			text-align:center;
			margin-top: 10em;
			font-size: 3em;
			color: #24A249;
		}
    </style>
</head>
<body>
	<div class="point">
		<?php echo $point; ?>
	</div>
</body>
</html>