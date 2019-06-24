<form id="pagerForm" method="post" action="index.php?c=Index&a=userList">
	<input type="hidden" name="pageNum" value="{$param.pageNum}" />
	<input type="hidden" name="keywords" value="{$param.keywords}">
	<input type="hidden" name="numPerPage" value="{$param.numPerPage}" />
	<input type="hidden" name="orderField" value="{$param.orderField}" />
</form>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="index.php?c=User&a=userList" method="post">
		<div class="searchBar">
			<ul class="searchContent">
				<li>
					<label>用户名：</label>
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
		</ul>
	</div>

	<div id="w_list_print">
		<table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
			<thead>
			<tr>
				<th align="center" width="80" >用户ID</th>
				<th align="center" width="80">用户名</th>
				<th align="center" width="60">添加时间</th>
				<th align="center" width="100">用户头像</th>
				<th align="center" width="80">用户手机号</th>
				<th align="center" width="50">用户余额</th>
				<th align="center" width="50">用户支付名称</th>
				<th align="center" width="50">用户支付账号</th>
				<th align="center" width="50">用户微信名称</th>
				<th align="center" width="50">用户微信账号</th>
				<th align="center" width="50">用户绑定手机</th>
				<th align="center" width="50">用户邀请码</th>
			</tr>
			</thead>
			<tbody id="Classifys">
			<volist name="UserList" id="user">
				<tr target="{$user.id}" rel="1">
					<td align="center">{$user.id}</td>
					<td>{$user.name}</td>
					<td>{$user.addtime}</td>
					<td align="center"><img width="80" height="80" src="{$user.pic_headimg}"/></td>
					<td>{$user.phone}</td>
					<td>{$user.money}</td>
					<td>{$user.zhifuname}</td>
					<td>{$user.zhifucount}</td>
					<td>{$user.wxname}</td>
					<td>{$user.wxcount}</td>
					<td>{$user.bindphone}</td>
					<td>{$user.code}</td>
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
		$deltr = $('#Users').find('tr.selected');
		$deltr.remove();
	}
</script>