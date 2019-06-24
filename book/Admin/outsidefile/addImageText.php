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
    <form method="post" action="index.php?c=Imagetext&a=AddOne" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p>
                <label>标题：</label>
                <input name="title" type="text" size="30" class="required" />
            </p>

            <input type="text" value="" name="images" id="myValue" hidden="hidden"/>

            <div style="overflow: hidden">
                <label>主图：</label>
                <div style="position:relative;float:left;">
                    <input type="file" class="add_img" style="opacity: 0;position:absolute;top:0px;left:0px;width: 100px;height:100px;" value="" name="image"  onchange="file(this)" />
                    <img src="images/timg.jpg" style="width: 100px;height:100px;border:1px solid #eaeaea;" id="pic_master_img"/>
                </div>
            </div>
            <div><label>内容：</label>
            <textarea name="content" id="textContent" style="width:600px;height:400px;"></textarea>
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



    function file(el) {
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    }


</script>
