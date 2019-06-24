<style>
    .pageFormContent p{
        float:none;
    }

</style>
<div class="pageContent">
    <form method="post" action="?m=FeiAdmin&c=SonClassify&a=AddOne" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <div style="overflow: hidden"> 
                <label>分类名：</label>
                <input type="text"   value="" name="name"  class="required"  />
            </div>

        <div style="overflow: hidden;margin-top:20px;">
            <label>所属主分类：</label>
            <select class="required" name="classify_id">
                <volist name="classifyList" id="classify">
                    <option value="{$classify.classify_id}">{$classify.name}</option>
                </volist>
            </select>
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


</script>
