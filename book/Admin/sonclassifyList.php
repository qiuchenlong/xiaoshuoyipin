<form id="pagerForm" method="post" action="?m=FeiAdmin&c=SonClassify&a=showList">
    <input type="hidden" name="pageNum" value="{$param.pageNum}" />
    <input type="hidden" name="keywords" value="{$param.keywords}">
    <input type="hidden" name="numPerPage" value="{$param.numPerPage}" />
    <input type="hidden" name="orderField" value="{$param.orderField}" />
</form>
<div class="pageHeader">
    <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="index.php?m=FeiAdmin&c=SonClassify&a=showList" method="post">
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
            <li><a class="add" href="?m=FeiAdmin&c=SonClassify&a=addClassify" target="dialog" width="800" height="600"><span>添加</span></a></li> 
            <li><a class="delete" href="?m=FeiAdmin&c=SonSonClassify&a=delOne" callback="Delcb" target="ajaxTodo" title="确定要删除吗？" warn="请选择一个商品"><span>删除</span></a></li>

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
            <tbody id="SonClassifys">
            <volist name="classifyList" id="SonClassify">
                <tr target="{$SonClassify.seclassify_id}" rel="1">
                    <td align="center">{$SonClassify.seclassify_id}</td>
                    <td align="center">{$SonClassify.name}</td> 
                    <td align="center">{$SonClassify.classifyname}</td>
                    <td align="center"><a href="?m=FeiAdmin&c=SonClassify&a=changeOne&id={$SonClassify.seSonClassify_id}" target="dialog" width="800" height="600">修改</a></td> 
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
        $deltr = $('#SonClassifys').find('tr.selected');
        $deltr.remove();
    }


</script>