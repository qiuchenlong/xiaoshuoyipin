<form id="pagerForm" method="post" action="?m=FeiAdmin&c=Talk&a=showList">
	<input type="hidden" name="pageNum" value="{$param.pageNum}" />
	<input type="hidden" name="keywords" value="{$param.keywords}">
	<input type="hidden" name="numPerPage" value="{$param.numPerPage}" />
	<input type="hidden" name="orderField" value="{$param.orderField}" />
</form>

<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="?m=FeiAdmin&c=Talk&a=showList" method="post">  
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
			<li><a class="add" href="?m=FeiAdmin&c=Talk&a=addtalk" target="dialog" width="800" height="600"><span>添加</span></a></li> 
			<li><a class="delete" href="?m=FeiAdmin&c=Talk&a=delOne" callback="Delcb" target="ajaxTodo" title="确定要删除吗？" warn="请选择一个商品"><span>删除</span></a></li>
		</ul>
	</div>

	<div id="w_list_print">

		<table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
			<thead>
			<tr>
				<th align="center" width="40" orderField="name" >话题ID</th>
				<th align="center" width="100" orderField="num">用户名</th>
				<th align="center" width="100" orderField="num">用户头像</th>
				<th align="center" width="100">话题类型</th>
				<th align="center" width="40">话题内容</th>
				<th align="center" width="40">话题观看费用</th>
				<th align="center" width="60">设置为头条</th>
				<th align="center" width="60">设置为热点</th> 
				<th align="center" width="40">修改</th>
			</tr>
			</thead>
			<tbody id="nlassifys">
			<volist name="classifyList" id="classify">
				<tr target="{$classify.talk_id}" rel="1">
					<td align="center">{$classify.talk_id}</td>
					<td align="center">{$classify.name}</td>
					<td align="center"><img width="80" height="80" src="{$classify.headimg}"/></td>
					<td align="center" height="20">
					    <if condition="$classify.type eq 0"> 图片话题
							<elseif condition="$classify.type eq 1"  />视频话题
							<elseif condition="$classify.type eq 2"/>文章话题
						</if> 
					</td>
					<td style="height:20px;">{$classify.content|substr=0,120}...</td> 
					<td align="center">{$classify.money}</td> 
					<td align="center"> 
					    <if condition="$classify.toutiao == 0 ">
						  <a href="?m=FeiAdmin&c=Talk&a=touTiao&talk_id={$classify.talk_id}&state=1"  target="ajax" rel="talk_list" title="确定设置为头条吗？" >设为头条</a>
							<elseif condition="$classify.toutiao == 1" /><a href="?m=FeiAdmin&c=Talk&a=touTiao&talk_id={$classify.talk_id}&state=0" style="margin-left:15px" target="ajax" rel="talk_list" title="确定取消头条吗？" >取消头条</a>
							
						</if>
					</td>
					<td align="center">
					    <if condition="$classify.hot == 0 ">
						  <a href="?m=FeiAdmin&c=Talk&a=Hot&talk_id={$classify.talk_id}&state=1"  target="ajax" rel="talk_list" title="确定设置为热点吗？" >设为热点</a>
							<elseif condition="$classify.hot == 1" /><a href="?m=FeiAdmin&c=Talk&a=Hot&talk_id={$classify.talk_id}&state=0" style="margin-left:15px" target="ajax" rel="talk_list" title="确定取消热点吗？" >取消热点</a>
						</if>
					</td>
					<td align="center">
						<a href="?m=FeiAdmin&c=Talk&a=showTalk&id={$classify.talk_id}" target="dialog" width="800" height="600">审核</a>
					</td>
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
		$deltr = $('#nlassifys').find('tr.selected');
		$deltr.remove();
	}

</script>