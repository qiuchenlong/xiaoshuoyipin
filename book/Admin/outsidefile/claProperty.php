<style>
    .unit{
        padding:20px;
        border-bottom: 1px dotted #eaeaea;
        overflow: hidden;
    }

    .pageFormContent .unit label{
        width:auto;
    }
</style>
<div >

    <form method="post" action="index.php?c=Classify&a=addProperty" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
        <div class="pageFormContent" layoutH="58">

                <ul>
                    <if condition="$count == 0">

                        <div class="unit">
                            <label>属性名：</label>
                            <input type="text" name="property[]"   class="required" />
                            <span style="color:blue;font-size:17px;font-weight: 600;height:22px;line-height:22px;margin-left:20px;cursor: pointer;" onclick="addPro(this)" class="addPro">+</span>
                        </div>

                        <else />
                        <volist name="proList" id="proItem">
                            <div class="unit">
                                <label>属性名：</label>
                                <input type="text" name="property[]"  value="{$proItem.property}" class="required" />
                                <span style="color:blue;font-size:17px;font-weight: 600;height:22px;line-height:22px;margin-left:20px;cursor: pointer;" onclick="addPro(this)" class="addPro">+</span>
                            </div>
                        </volist>
                    </if>
                </ul>


        </div>
        <input name="classifyid" value="{$classifyid}" hidden="hidden"/>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
            </ul>
        </div>
    </form>

</div>

<script>
    function addPro(elem){
        var $cloneNode = $(elem).parent();
        $addNode = $cloneNode.clone();
        $addNode.find('input').val("");
        $addNode.insertAfter($cloneNode);
    }

</script>
