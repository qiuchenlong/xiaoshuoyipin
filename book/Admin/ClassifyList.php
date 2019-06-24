<form id="pagerForm" method="post" action="?m=FeiAdmin&c=Classify&a=showList">
	<input type="hidden" name="pageNum" value="{$param.pageNum}" />
	<input type="hidden" name="keywords" value="{$param.keywords}">
	<input type="hidden" name="numPerPage" value="{$param.numPerPage}" />
	<input type="hidden" name="orderField" value="{$param.orderField}" />
</form>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="index.php?m=FeiAdmin&c=Classify&a=showList" method="post">
		<div class="searchBar">
			<ul class="searchContent">
				<li>
					<label>分类名：</label>
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
			<li><a class="add" href="?m=FeiAdmin&c=Classify&a=addClassify" target="dialog" width="800" height="600"><span>添加</span></a></li>
			<li><a class="delete" href="index.php?m=FeiAdmin&c=Classify&a=delOne" callback="Delcb" target="ajaxTodo" title="确定要删除吗？" warn="请选择一个分类"><span>删除</span></a></li>
		</ul>
	</div>

	<div id="w_list_print">
		<table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
			<thead> 
			<tr>
				<th align="center" width="40" orderField="name" >分类ID</th>
				<th align="center" width="100" orderField="num">分类名</th>
				<th align="center" width="100">分类主图</th>
				<th align="center" width="40">分类排序</th>
				<th align="center" width="60">修改</th>
			</tr>
			</thead>
			<tbody id="Classifys">
			<volist name="classifyList" id="classify">
				<tr target="{$classify.classify_id}" rel="1">
					<td align="center">{$classify.classify_id}</td>
					<td align="center">{$classify.name}</td> 
					<td align="center"><img width="80" height="80" src="{$classify.images}"/></td>
					<td align="center"><input onchange="mySort(this,{$classify.id})" type="text" value="{$classify.sort}" style="width:80px;height:100%;text-align: center;border: none"></td>
					<td align="center"><a href="?m=FeiAdmin&c=Classify&a=changeOne&classify_id={$classify.classify_id}" target="dialog" width="800" height="600">修改</a></td>
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
		$deltr = $('#Classifys').find('tr.selected');
		$deltr.remove();
	}

	function mySort(elem,id){
		var sort = $(elem).val();
		$.ajax({
			url:"?c=Classify&a=ChangeSort&sort="+sort+'&id='+id,
			method:'get'
		}).done(function(ret){
            var ret = JSON.parse(ret);
			var code = ret.code;
			if(code == 200){
				navTab.reload(ret.forwardUrl);
				var forwardUrl = ret.forwardUrl;
			}
		})
	}
</script>