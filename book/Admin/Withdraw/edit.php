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
    <form method="post" action="<?php echo U('Withdraw/edit')?>" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">   
        <div class="pageFormContent" layoutH="56">
             <input type="hidden" name="withdraw_id" value="{$data.withdraw_id}"/>
              <p>
                <label>提现状态：</label>
                <select name="state">
                    <option value="0" <if condition="$data.state eq 0">selected = "selected"</if> >提现中</option> 
                    <option value="1" <if condition="$data.state eq 1">selected = "selected"</if> >提现成功</option> 
                    <option value="2" <if condition="$data.state eq 2">selected = "selected"</if> >提现失败</option>
                </select>
            </p> 

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
