<style>

</style>
<div class="pageContent">
    <form method="post" action="index.php?c=Coupon&a=addOne" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p style="width: 100%;">
                <label>满多少元:</label>
                <input name="up" type="text" size="30" class="required" />

            </p>
            <p style="width: 100%;">
                <label>减多少元:</label>
                <input name="down" type="text" size="30" class="required" />

            </p>
            <p style="width: 100%;">
                <label>发放个数:</label>
                <input name="number" type="text" size="30" class="required" />
            </p>

            <p style="width: 100%;">
                <label>有效使用分类：</label>
                <select class="required" name="classify">
                    <volist name="classifyList" id="classify">
                        <option value="{$classify.id}">{$classify.name}</option>
                    </volist>
                </select>
            </p>
            <div class="unit">
                <label>开始时间：</label>
                <input type="text" name="addtime" class="date" dateFmt="yyyy-MM-dd" readonly="true"/>
                <a class="inputDateButton" href="javascript:;">选择</a>
            </div>

            <div class="unit">
                <label>结束时间：</label>
                <input type="text" name="endtime" class="date" dateFmt="yyyy-MM-dd" readonly="true"/>
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
