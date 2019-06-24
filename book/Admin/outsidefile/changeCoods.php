<style>
    .pageFormContent p{
        float:none;
    }


    .image_ct{
        margin-top:100px;
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
    <form method="post" action="index.php?c=Index&a=ChangeOne" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p>
                <label>商品名：</label>
                <input name="name" type="text" size="30" class="required" value="{$good.name}"/>
            </p>
            <p>
                <label>商品货号：</label>
                <input name="numbers" class="required" value="{$good.numbers}" type="text" size="30"/>
            </p>
            <input name="goodsid" class="required" value="{$good.id}" type="text" size="30" hidden="hidden"/>
            <p>
                <label>所属分类：</label>
                <select class="required" name="fk_classify">
                    <volist name="classifyList" id="classify">
                        <if condition="$classify.id == $good.fk_classify ">
                           <option  value="{$classify.id}" selected="selected">{$classify.name}</option>
                            <elseif condition="$classify.id != $good.fk_classify"/><option  value="{$classify.id}">{$classify.name}</option>
                        </if>
                    </volist>
                </select>
            </p>

            <p>
                <label>价格：</label>
                <input type="text" class="required" value="{$good.price}" name="price" class="textInput">
            </p>

            <input type="text" value="{$good.pic_images}" name="images" id="myValue" hidden="hidden"/>

            <div style="overflow: hidden">
                <label>商品主图：</label>
                <div style="position:relative;float:left;">
                    <input type="file" class="add_img" style="opacity: 0;position:absolute;top:0px;left:0px;width: 100px;height:100px;" value="" name="pic_master_img" onchange="file(this)"  />
                    <img src="{$good.pic_master_img}" style="width: 100px;height:100px;border:1px solid #eaeaea;"/>
                </div>
            </div>

            <div style="width: 90%;height:80px;border: 1px dotted #eaeaea;text-align: center;line-height:80px;font-size:18px;margin-top:20px;position:relative; ">
                <input id="testFileInput" type="file" name="image"
                       uploaderOption="{
                        swf:'uploadify/scripts/uploadify.swf',
                        uploader:'index.php?c=Index&a=addImage',
                        buttonText:'从这里上传商品相册',
                        fileSizeLimit:'2048KB',
                        fileTypeDesc:'*.jpg;*.jpeg;*.gif;*.png;',
                        fileTypeExts:'*.jpg;*.jpeg;*.gif;*.png;',
                        auto:true,
                        multi:true,
                        onUploadSuccess:function(ret,result){
                            UploadSC(result);
                        },
                        onQueueComplete:function(ret){


                        }
                    }"
                /></div>


            <div class="box">
                <ul class="image_ct">
                    <volist name="Images" id="image">
                        <li>
                            <span class="myclose" onclick="Mydelete(this)"></span>
                            <img  src='{$image}' />
                        </li>
                    </volist>
                </ul>
            </div>

            <div><label>内容：</label>
                <textarea name="content" id="textContent" style="width:750px;height:400px;" >{$good.content}</textarea>
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
    function myImage(){
        var imgs = $('.image_ct img');
        var imageurl = [];
        for(var i=0;i<imgs.length;i++){
            imageurl.push($(imgs[i]).attr('src'));
        }
        var myimageurl = imageurl.join(',');
        $('#myValue').val(myimageurl);
    }

    function Mydelete(elem){
        var $lis = $(elem).parent();
        $lis.remove();
        myImage();
    }

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


    function UploadSC(result){
        var result = JSON.parse(result);
        var code =result.code;

        if(code == 200){
            var multiSrcImage = result.multiSrcImage;
            html='<li><span class="myclose" onclick="Mydelete(this)"></span><img  src='+multiSrcImage+' /></li>';
            $('.image_ct').append(html);
            myImage();
        }
    }
</script>
