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

                </li>
            </ul>
            <div class="subBar">
                <ul>

                </ul>
            </div>
        </div>
    </form>
</div>

<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" href="index.php?c=Ad&a=addAd" target="dialog" width="800" height="600"><span>添加</span></a></li>
            <li><a class="delete" href="index.php?c=Ad&a=delOne" callback="Delcb" target="ajaxTodo" title="确定要删除吗？" warn="请选择一个商品"><span>删除</span></a></li>

        </ul>
    </div>

    <div id="w_list_print">
        <table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
            <thead>
            <tr>
                <th align="center" width="80" orderField="name" >轮播ID</th>

                <th align="center" width="100">轮播图</th>
                <th align="center" width="100">排序</th>
            </tr>
            </thead>
            <tbody id="Ads">
            <volist name="AdList" id="ad">
                <tr target="{$ad.id}" rel="1">
                    <td align="center">{$ad.id}</td>
                    <td align="center"><img src="{$ad.pic_images}" width="200px" height="100px"/></td>
                    <td align="center"><input onchange="mySort(this,{$ad.id})" style="width:80px;height:100%;text-align: center;border: none" type="text" value="{$ad.sort}"/></td>
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
        $deltr = $('#Ads').find('tr.selected');
        $deltr.remove();
    }

    function mySort(elem,id){
        var sort = $(elem).val();
        $.ajax({
            url:"index.php?c=Ad&a=ChangeSort&sort="+sort+'&id='+id,
            method:'get'
        }).done(function(ret){
            var ret = JSON.parse(ret);
            var code = ret.code;
            if(code == 200){
                navTab.reload(ret.forwardUrl);
            }
        })
    }
</script>