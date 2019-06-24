<form id="pagerForm" method="post" action="?m=FeiAdmin&c=Buyfeibi&a=lst">
    <input type="hidden" name="pageNum" value="{$param.pageNum}" />
    <input type="hidden" name="keywords" value="{$param.keywords}">
    <input type="hidden" name="numPerPage" value="{$param.numPerPage}" />
    <input type="hidden" name="orderField" value="{$param.orderField}" />
</form>
<div class="pageHeader">
    <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="?m=FeiAdmin&c=Buyfeibi&a=lst" method="post">
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
            <li><a class="add" href="{:U('Buyfeibi/add')}" target="dialog" width="800" height="600"><span>添加</span></a></li>
            <li class="line">line</li>

        </ul>
    </div>

    <div id="w_list_print">
        <table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
            <thead>
            <tr>
                <th align="center" width="20">排序</th>
                <th align="center" width="60" >ID</th>
                <th align="center" width="60">用户名</th>
                <th align="center" width="60">充值金额</th>
                <th align="center" width="60">飞币数量</th>
                <th align="center" width="60">支付类型</th>
                <th align="center" width="60">支付成功</th>
                <th align="center" width="100">充值时间</th>
                <!-- <th align="center" width="60">修改</th> -->
            </tr>
            </thead> 
            <tbody id="Classifys">
            <volist name="data" id="v">
                <tr target="{$v.h_id}" rel="1">
                    <td align="center" width="20">{$i}</td>
                    <td align="center">{$v.b_id}</td>
                    <td align="center">{$v.name}</td>
                    <td align="center">{$v.money}元</td>
                    <td align="center">{$v.feibi}个飞币</td>
                    <td align="center"><if condition="$v.type eq 0 ">支付宝
                                        <else/>微信
                                        </if></td>
                    <td align="center"><if condition="$v.state eq 0 ">未支付
                                        <else/>已支付
                                        </if></td>
                    <td align="center">{$v.addtime}</td> 
                   <!--  <td><a href="index.php?m=FeiAdmin&c=Buyfeibi&a=editwen&id={$v.h_id}" target="dialog" width="800" height="600">修改</a></td> -->
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