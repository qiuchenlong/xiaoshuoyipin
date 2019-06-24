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
    <form method="post" action="<?php echo U('User/addXyUser')?>" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <input type="hidden" name="type" value="1"/>
            <input type="hidden" name="authentication" value="1"/>
            <input type="hidden" name="state" value="2"/>
            <p>
                <label>用户名称：</label>
                <input name="name" type="text" size="30" class="required" />
            </p>
             <p>
                <label>手机账号：</label>
                <input name="phone" type="text" size="30" class="required" />
            </p>
             <p>
                <label>密码</label>
                <input name="password" type="text" size="30" class="required" />
            </p>
            <p>
                <label>用户飞币金额：</label>
                <input name="money" type="text" size="30" />
            </p>
            <p>
                <label>私聊所需费用：</label>
                <input name="talkmoney" type="text" size="30" />
            </p>
            <p>
                <label>提问所需费用：</label>
                <input name="needmoney" type="text" size="30" />
            </p>
             <p>
                <label>用户职位：</label>
                <input name="job" type="text" size="30" />
            </p>
            <div style="overflow: hidden">
                <label>用户头像：</label>
                <div style="position:relative;float:left;">
                    <input type="file" class="add_img" style="opacity: 0;position:absolute;top:0px;left:0px;width: 100px;height:100px;" value="" name="img"  onchange="file(this)" />
                    <img src="images/timg.jpg" style="width: 100px;height:100px;border:1px solid #eaeaea;" id="pic_master_img"/>
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
