<style>
    .pageFormContent p{
        float:none;
    }


    .image_ct{
        overflow: hidden;
    }

    .image_ct li{

        width:130px;
        height:130px;
        margin-left:10px;
        float:left;
        margin-bottom:20px;
        border:1px solid #eaeaea;
        position:relative;
    }

    .image_ct li img{
        width:100%;
        height:100%;

    }

    #testFileInput{
        opacity:1;
    }

    .myclose{
        position:absolute;
        top:5px;
        right:5px;
        width:25px;
        height:25px;
        background: #fff url("images/cancel.png") no-repeat center;
        background-size:20px;
        cursor: pointer;
    }

    .swfupload{
        left: 0;
    }

    .uploadify-button{
        background-color: #fff;
        background-image:none;
        border:none;
    }

    .uploadify-button-text{
        font-size:16px;
        font-weight: 400;
        color:#000;

    }


</style>
<div class="pageContent">
    <form method="post" action="index.php?c=System&a=ChangeOne" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">

            <div><label>消费者保障说明协议：</label>
                <textarea name="consumer_protection" class="textContent" style="width:800px;height:400px;" >{$Obj.consumer_protection}</textarea>
            </div>

            <div><label>服务协议：</label>
                <textarea name="service_agreement" class="textContent" style="width:800px;height:400px;" >{$Obj.service_agreement}</textarea>
            </div>


            <div><label>联系我们：</label>
                <textarea name="contact_us" class="textContent" style="width:800px;height:400px;" >{$Obj.contact_us}</textarea>
            </div>

            <div><label>关于我们：</label>
                <textarea name="about_us" class="textContent" style="width:800px;height:400px;" >{$Obj.about_us}</textarea>
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

    function kedit(kedit){
        var editor = KindEditor.create(kedit,{
            allowFileManager : true,
             formatUploadUrl: false,
            afterBlur: function(){this.sync();}
        });
    }

    $(function(){
        kedit('.textContent');
    })
</script>
