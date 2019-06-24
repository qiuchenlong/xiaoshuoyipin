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
            <li><a class="edit" href="orderList.php?uid={sid_user}" target="dialog" warn="请选择一个用户"><span>修改</span></a></li>
            <li class="line">line</li>
            <li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
            <li><a class="icon" href="javascript:$.printBox('w_list_print')"><span>打印</span></a></li>
        </ul>
    </div>

    <div id="w_list_print">
        <table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
            <thead>
            <tr>
                <th align="center" width="80"  >ID</th>
                <th align="center" width="50" >提现金额</th>
                <th align="center" width="80">提现时间</th>
                <th align="center" width="80">提现用户</th>
                <th align="center" width="50">提现方式</th>
                <th align="center" width="80">提现用户名</th>
                <th align="center" width="80">提现账号</th>
                <th align="center" width="80">提现状态</th>
                <th align="center" width="80">到账时间</th>
            </tr>
            </thead>
            <tbody id="Goods">
            <volist name="withdraws" id="withdraw">
                <tr target="{$withdraw.id}" rel="1">
                    <td align="center">{$withdraw.id}</td>
                    <td align="center">{$withdraw.money}</td>
                    <td align="center">{$withdraw.addtime}</td>
                    <td align="center">{$withdraw.name}</td>
                    <td align="center"><if condition="$withdraw.paymethod eq 0">微信提现
                            <elseif condition="$withdraw.paymethod eq 1"  />支付宝提现
                        </if></td>
                    <td align="center">{$withdraw.tiname}</td>
                    <td align="center">{$withdraw.ticount}</td>
                    <td align="center"><if condition="$withdraw.state eq 0"><a href="index.php?c=Withdraw&a=setTiXian&ordersid={$withdraw.id}" target="dialog" width="800" height="600">设置提现状态</a>
                            <elseif condition="$withdraw.state eq 1" />提现成功
                            <elseif condition="$withdraw.state eq 2" />提现失败
                        </if></td>
                    <td align="center">
                        {$withdraw.daotime}
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
        $deltr = $('#Goods').find('tr.selected');
        $deltr.remove();
    }
</script>