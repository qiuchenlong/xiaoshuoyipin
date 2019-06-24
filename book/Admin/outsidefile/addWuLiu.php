<style>

</style>
<div class="pageContent">
    <form method="post" action="index.php?c=Orders&a=addWuMsg" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p style="width: 100%;">
                <label>快递单号：</label>
                <input name="tracking_number" type="text" size="30" class="required" />
            </p>
            <input name="ordersid" type="text" value="{$ordersid}" size="30" hidden="hidden"/>

            <p style="width: 100%;">
                <label>快递公司：</label>
                <select class="required" name="fk_delivery">
                    <volist name="deliveryList" id="delivery">
                        <option value="{$delivery.id}">{$delivery.name}</option>
                    </volist>
                </select>
            </p>
            <div class="unit">
                <label>发货时间：</label>
                <input type="text" name="delivery_time" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true"/>
                <a class="inputDateButton" href="javascript:;">选择</a>
            </div>

        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
                <li>
                    <div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
                </li>
            </ul>
        </div>
    </form>
</div>
