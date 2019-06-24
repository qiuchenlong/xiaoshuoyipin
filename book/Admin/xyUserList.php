<form id="pagerForm" method="post" action="?m=FeiAdmin&c=User&a=xyUserList">
	<input type="hidden" name="pageNum" value="{$param.pageNum}" />
	<input type="hidden" name="keywords" value="{$param.keywords}">
	<input type="hidden" name="numPerPage" value="{$param.numPerPage}" />
	<input type="hidden" name="orderField" value="{$param.orderField}" />
</form>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="index.php?m=FeiAdmin&c=User&a=xyUserList" method="post"> 
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
			<li><a class="add" href="?m=FeiAdmin&c=User&a=addXyUser" target="dialog" width="800" height="600"><span>添加</span></a></li> 
			<li><a class="delete" href="index.php?c=Index&a=delOne" callback="Delcb" target="ajaxTodo" title="确定要删除吗？" warn="请选择一个用户"><span>删除</span></a></li>
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
				<th align="center" width="50">用户飞币</th>
				<th align="center" width="50">私聊所需费用</th>
				<th align="center" width="50">提问所需费用</th>
				<th align="center" width="50">认证信息</th>
				<th align="center" width="50">审核状态</th>
			</tr>
			</thead>
			<tbody id="Classifys">
			<volist name="UserList" id="user">
				<tr target="{$user.user_id}" rel="1">
					<td align="center">{$user.user_id}</td>
					<td align="center">{$user.name}</td>
					<td align="center">{$user.addtime}</td>
					<td align="center"><img width="80" height="80" src="{$user.headimg}"/></td>
					<td align="center">{$user.phone}</td>
					<td align="center">{$user.money}</td>
					<td align="center">{$user.talkmoney}</td>
					<td align="center">{$user.needmoney}</td>
					<td align="center">
					    <if condition="$user.authentication eq 0"> 未认证
							<else />已认证
						</if>
					</td>
					<td align="center">
					    <if condition="$user.state eq 0"> 未提交审核信息
							<elseif condition="$user.state eq 1"  /><a href="?m=FeiAdmin&c=User&a=showShenHe&user_id={$user.user_id}" target="dialog" width="800" height="600">审核</a>
							<elseif condition="$user.state eq 2"/>审核成功
							<elseif condition="$user.state eq 3"/>审核失败
						</if>
					</td>
				</tr>
			</volist>
			</tbody>
		</table>
	</div>

	<div class="panelBar">
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