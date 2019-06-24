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

            </ul>
            <div class="subBar">

            </div>
        </div>
    </form>
</div>

<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" href="index.php?c=Coupon&a=addCoupon" target="dialog" width="800" height="600"><span>添加</span></a></li>
            <li class="line">line</li>

        </ul>
    </div>

    <div id="w_list_print">
        <table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
            <thead>
            <tr>
                <th align="center" width="80" >ID</th>
                <th align="center" width="80">满多少元</th>
                <th align="center" width="60">减多少元</th>
                <th align="center" width="100">开始时间</th>
                <th align="center" width="60">结束时间</th>
                <th align="center" width="60">所属分类</th>
                <th align="center" width="60">发放个数</th>
                <th align="center" width="60">修改</th>
            </tr>
            </thead>
            <tbody id="Classifys">
            <volist name="CouponList" id="couponItem">
                <tr target="{$couponItem.id}" rel="1">
                    <td align="center">{$couponItem.id}</td>
                    <td align="center">{$couponItem.up}元</td>
                    <td align="center">{$couponItem.down}元</td>
                    <td align="center">{$couponItem.addtime}</td>
                    <td align="center">{$couponItem.endtime}</td>
                    <td align="center">{$couponItem.name}</td>
                    <td align="center">{$couponItem.number}</td>
                    <td><a href="index.php?c=Coupon&a=changeImageText&id={$textItem.id}" target="dialog" width="800" height="600">修改</a></td>
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