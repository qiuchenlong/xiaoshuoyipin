<style>
    .pageFormContent p{
        float:none;
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



</style>
<div class="pageContent">
    <form method="post" action="?m=FeiAdmin&c=Index&a=qan_add" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56"> 
            <div><label>提问问题：</label>
            <textarea name="content" id="textContent" style="width:600px;height:400px;"></textarea>
            </div>
            <div><label>回答问题：</label> 
            <textarea name="answer" id="textContent" style="width:600px;height:400px;"></textarea>
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
       kedit('textarea[name="content"]');
   })

    $(function(){
       kedit('textarea[name="answer"]'); 
   })



    function file(el) {
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    }


</script>
