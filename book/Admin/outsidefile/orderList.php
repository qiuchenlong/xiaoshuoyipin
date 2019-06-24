<form id="pagerForm" method="post" action="index.php?c=Orders&a=orderList">
	<input type="hidden" name="pageNum" value="{$param.pageNum}" />
	<input type="hidden" name="keywords" value="{$param.keywords}">
	<input type="hidden" name="numPerPage" value="{$param.numPerPage}" />
	<input type="hidden" name="orderField" value="{$param.orderField}" />
</form>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="index.php?c=Index&a=goodList" method="post">
		<div class="searchBar">
			<ul class="searchContent">
				<li>
					<label>订单号：</label>
					<input type="text" name="keywords"/>
				</li>
			</ul>
			<div class="subBar">
				<ul>
					<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
				</ul>
			</div>
		</div>
	</form>
</div>

<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			
			<li><a class="delete" href="index.php?c=Index&a=delOne" callback="Delcb" target="ajaxTodo" title="确定要删除吗？" warn="请选择一个商品"><span>删除</span></a></li>
			<li class="line">line</li>
			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
			<li><a class="icon" href="javascript:$.printBox('w_list_print')"><span>打印</span></a></li>
		</ul>
	</div>

	<div id="w_list_print">
		<table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
			<thead>
			<tr>
				<th align="center" width="80" >订单ID</th>
				<th align="center" width="80">订单号</th>
				<th align="center" width="80">购买用户名</th>
				<th align="center" width="80">购买时间</th>
				<th align="center" width="40">订单价格</th>
				<th align="center" width="30">订单状态</th>
				<th align="center" width="80">收货信息</th>
				<th align="center" width="80">发货时间</th>
				<th align="center" width="80">快递单号</th>
				<th align="center" width="80">快递公司</th>
				<th align="center" width="80">订单详情</th>
			</tr>
			</thead>
			<tbody id="Goods">
			<volist name="orderList" id="order">
				<tr target="{$order.id}" rel="1">
					<td align="center">{$order.id}</td>
					<td align="center">{$order.number}</td>
					<td align="center">{$order.name}</td>
					<td align="center">{$order.addtime}</td>
					<td align="center">{$order.totalmoney}</td>
					<td align="center">
						<if condition="$order.status eq 1"> 代付款
							<elseif condition="$order.status eq 2"  /><a href="index.php?c=Orders&a=addWuLiu&ordersid={$order.id}" target="dialog" width="800" height="600">发货</a>
							<elseif condition="$order.status eq 3"/>代收货
							<elseif condition="$order.status eq 4"/>代评论
							<elseif condition="$order.status eq 5"/>订单完成
						</if>
					</td>
					<td align="center">{$order.address}</td>
					<td align="center">{$order.delivery_time}</td>
					<td align="center">{$order.tracking_number}</td>
					<td align="center">{$order.deliveryname}</td>
					<td align="center"><a href="index.php?c=Orders&a=orderDetail&ordersid={$order.id}" target="dialog" width="800" height="600">查看详情</a></td>
				</tr>
			</volist>
			</tbody>
		</table>
	</div>

	<div class="panelBar" >
		<div class="pages">
			<span>显示</span>
			<select name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
				<option value="200">200</option>
			</select>
			<span>条，共{$param.count}条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="{$param.count}" numPerPage="{$param.numPerPage}" pageNumShown="10" currentPage="{$param.pageNum}"></div>

	</div>

</div>
<script>
	//删除回调
	function Delcb(){
		$deltr = $('#Goods').find('tr.selected');
		$deltr.remove();
	}
</script>