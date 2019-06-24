<style>
    .pageFormContent p{
        float:none;
    }

</style>
<div class="pageContent">
    <form method="post" action="?m=FeiAdmin&c=Classify&a=OneChange" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <div style="overflow: hidden">
                <label>分类名：</label>
                <input type="text"   value="{$classify.name}" name="name"  class="required"  />
            </div>
            <div style="overflow: hidden;margin-top:20px">
            <label>分类排序：</label>
            <input type="text"   value="{$classify.sort}" name="sort"   />
        </div>

        <input value="{$id}" hidden="hidden" name="id"/>

        
        <div style="margin-top:20px">
            <label>分类主图：</label>
            <div style="position:relative;float:left;">
                <input type="file" class="add_img" style="opacity: 0;position:absolute;top:0px;left:0px;width: 100px;height:100px;" value="" name="image"  onchange="file(this)" class="required"/>
                <img src="{$classify.images}" style="width: 100px;height:100px;border:1px solid #eaeaea;" id="pic_master_img"/>
            </div>
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

    function file(el) {
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    }


</script>
