<form id="pagerForm" method="post" action="index.php?c=Index&a=goodList">
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
					<label>商品名：</label>
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
			<li><a class="add" href="index.php?c=Index&a=addGoods" target="dialog" width="800" height="600"><span>添加</span></a></li>
			<li><a class="delete" href="index.php?c=Index&a=delOne" callback="Delcb" target="ajaxTodo" title="确定要删除吗？" warn="请选择一个商品"><span>删除</span></a></li>

		</ul>
	</div>

	<div id="w_list_print">
	<table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
		<thead>
			<tr>
				<th align="center" width="80" orderField="name" >商品ID</th>
				<th align="center" width="100" orderField="num">商品名</th>
				<th align="center" width="100">商品主图</th>
				<th align="center" width="100">商品货号</th>
				<th align="center" width="100">添加时间</th>
				<th align="center" width="100">价格</th>
				<th align="center" width="80">编辑</th>
				<th align="center" width="80">商品属性</th>
			</tr>
		</thead>
		<tbody id="Goods">
			<volist name="goods" id="good">
				<tr target="{$good.id}" rel="1">
					<td align="center">{$good.id}</td>
					<td>{$good.name}</td>
					<td align="center"><img width="80" height="80" src="{$good.pic_master_img}"/></td>
					<td>{$good.numbers}</td>
					<td>{$good.addtime}</td>
					<td>{$good.price}</td>
					<td><a href="index.php?c=Index&a=changeGood&goodsid={$good.id}" target="dialog" width="800" height="600">修改</a></td>
					<td align="center"><a href="index.php?c=Index&a=setPropery&goodsid={$good.id}&classifyId={$good.fk_classify}" target="dialog" width="800" height="600">商品属性</a></td>
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