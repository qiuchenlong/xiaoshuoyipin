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
            <li><a class="delete" href="index.php?c=topUp&a=delOne" callback="Delcb" target="ajaxTodo" title="确定要删除吗？" warn="请选择一个商品"><span>删除</span></a></li>
        </ul>
    </div>

    <div id="w_list_print">
        <table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
            <thead>
            <tr>
                <th align="center" width="40"  >充值ID</th>
                <th align="center" width="80">充值订单号</th>
                <th align="center" width="80">充值用户</th>
                <th align="center" width="80">充值时间</th>
                <th align="center" width="40">充值金额</th>
                <th align="center" width="40">充值类型</th>
            </tr>
            </thead>
            <tbody id="topUps">
            <volist name="topUpList" id="topItem">
                <tr target="{$topItem.id}" rel="1">
                    <td align="center">{$topItem.id}</td>
                    <td align="center">{$topItem.numbers}</td>
                    <td align="center">{$topItem.name}</td>
                    <td align="center">{$topItem.addtime}</td>
                    <td align="center">{$topItem.price}</td>
                    <td align="center">
                        <if condition="$topItem.type eq 1">微信充值
                            <elseif condition="$order.type eq 0"  />支付宝充值
                        </if>
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
        $deltr = $('#topUps').find('tr.selected');
        $deltr.remove();
    }

</script>