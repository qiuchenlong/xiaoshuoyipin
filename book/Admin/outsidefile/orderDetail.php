<style>
	.goodDetail .outItem{
		margin:15px;
	}

	.goodDetail p label{
		font-size:16px;
	}

	.goodDetail p span{
		font-size:16px;
	}

	.MygoodList{

	}

	.MygoodList .MyItem{
		border-bottom:1px solid #eaeaea;
		overflow: hidden;
		padding:10px;
	}

	.MygoodList .MyItem img{
		width:80px;
        height:80px;
		float:left;
	}

	.MygoodList .MyItem .content{
		margin-left:90px;
	}
	.MygoodList .MyItem .content p{
		font-size:15px;
	}

</style>
<div class="goodDetail">
	<p class="outItem">
		<label>订单号:</label>
        <span>{$order.number}</span>
	</p>
	<p class="outItem">
		<label>价格:</label>
		<span>￥{$order.totalmoney}</span>
	</p>
	<p class="outItem">
		<label>购买用户:</label>
		<span>{$order.name}</span>
	</p>
	<p  style="font-size:16px;margin-left:15px;">购买的商品列表:</p>
	<ul class="MygoodList">
		<volist name="goodList" id="good">
			<li class="MyItem">
				<img src="{$good.pic_master_img}">
				<div class="content">
					<p>{$good.goodname}</p>
					<p style="margin-top:10px">{$good.price}x{$good.quantity}</p>
					<p style="margin-top:10px">规格:{$good.format}</p>
				</div>
			</li>
		</volist>
	</ul>
</div>
