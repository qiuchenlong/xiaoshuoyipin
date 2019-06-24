<form id="pagerForm" method="post" action="index.php?c=Classify&a=classifyList">
    <input type="hidden" name="pageNum" value="{$param.pageNum}" />
    <input type="hidden" name="keywords" value="{$param.keywords}">
    <input type="hidden" name="numPerPage" value="{$param.numPerPage}" />
    <input type="hidden" name="orderField" value="{$param.orderField}" />
</form>
<div class="pageHeader">
    <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="index.php?c=Classify&a=classifyList" method="post">
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
            <li><a class="add" href="index.php?c=SonClassify&a=addClassify" target="dialog" width="800" height="600"><span>添加</span></a></li>
            <li><a class="delete" href="index.php?c=Classify&a=delOne" callback="Delcb" target="ajaxTodo" title="确定要删除吗？" warn="请选择一个商品"><span>删除</span></a></li>

            <li class="line">line</li>
            <li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
            <li><a class="icon" href="javascript:$.printBox('w_list_print')"><span>打印</span></a></li>
        </ul>
    </div>

    <div id="w_list_print">
        <table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
            <thead>
            <tr>
                <th align="center" width="40" orderField="name" >分类ID</th>
                <th align="center" width="100" orderField="num">子分类名</th>
                <th align="center" width="100">主分类名</th>
                <th align="center" width="60">修改</th>
            </tr>
            </thead>
            <tbody id="Classifys">
            <volist name="classifyList" id="classify">
                <tr target="{$classify.id}" rel="1">
                    <td align="center">{$classify.id}</td>
                    <td align="center">{$classify.name}</td>
                    <td align="center">{$classify.title}</td>
                    <td align="center"><a href="index.php?c=Classify&a=changeOne&id={$classify.id}" target="dialog" width="800" height="600">修改</a></td>
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


</script>