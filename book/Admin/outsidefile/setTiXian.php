
<div class="pageContent">
    <form method="post" action="index.php?c=Withdraw&a=setState" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p style="width: 100%;">
                <input type="radio" name="tiState" value="0" checked="checked" style="font-size:16px;" class="tiradio">提现成功</input>
                <input type="radio" name="tiState" value="1" style="margin-left:30px;font-size:16px;" class="tiradio">提现失败</input>
            </p>
            <input name="ordersid" type="text" value="{$ordersid}" size="30" hidden="hidden"/>

            <p style="width: 100%;display: none;" id="ti_sb">
                <label>填写失败原因：</label>
                <textarea rows="20"  name="reason" cols="10" style="width:80%;border:1px solid #eaeaea;height:100px;" ></textarea>
            </p>
            <div class="unit" style="display: block;" id="ti_cb">
                <label>提现成功时间：</label>
                <input type="text" name="daotime" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true"/>
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

<script>
    $(function(){
        var $ti_sb = $("#ti_sb");
        var $ti_cb = $("#ti_cb");
        $('.tiradio').click(function(){
            var $this = $(this);
            var index = $this.index();
            if(index == 0){
                $ti_sb.css('display','none');
                $ti_cb.css('display','block');
            }else{
                $ti_sb.css('display','block');
                $ti_cb.css('display','none');
            }
        })
    })

</script>
