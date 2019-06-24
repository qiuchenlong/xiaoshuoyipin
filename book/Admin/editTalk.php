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
    <form method="post" action="<?php echo U('Talk/showTalk')?>" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <!--            <input name="id" type="hidden" size="30" class="required" value="{$id}"/>-->
            <!-- <p>
                <label>选择用户：</label>
                    <select name="user_id" width="30"> 
                      <volist name="data" id="vo">
                        <option value="{$vo.user_id}">{$vo.name}</option>
                       </volist>
                    </select>
            </p> -->
            <p style="margin-bottom:20px;"> 
                <label>用户名：</label>
                <input name="money" disabled type="text" value="{$data.nickName}" size="30"  />
            </p>
            <p style="margin-bottom:20px;">
                <label>话题分类：</label>
                <input name="money" disabled type="text" value="{$seclassify.0.name}" size="30"  />
            </p>
            <!-- <p style="margin-bottom:20px;">
                <label>选择话题：</label>
                    <select name="seclassify_id" width="30">
                      <volist name="seclassify" id="vo">
                        <option value="{$vo.seclassify_id}" <if condition="$data.seclassify_id eq $vo.seclassify_id">selected</if> >{$vo.name}</option>
                       </volist> 
                    </select> 
            </p> -->
            <div style="overflow: hidden;margin-bottom:20px;">
                <label><a onclick='addnew1(this);' href='javascript:void(0);'>[+]</a>话题图片：</label>
                <?php foreach ($images as $key => $value): ?>
                    <div style="position:relative;float:left;">
                    <input type="file" disabled class="add_imgs" style="opacity: 0;position:absolute;top:0px;left:0px;width: 100px;height:100px;" value="" name="pic_images"  onchange="file2(this)" />
                    <img src="{$value}" style="width: 100px;height:100px;border:1px solid #eaeaea;" id="pic_master_img2"/>  
                </div>
                <?php endforeach ?>
            </div>
             <!-- <p style="margin-bottom:20px;">
                <label>话题金额：</label>
                <input name="money" type="text" value="0" size="30"  />元
            </p>
            <div style="overflow: hidden;margin-bottom:20px;">
                <label>话题视频：</label>
                <div style="position:relative;float:left;"> 
                    <input type="file" class="add_img" name="pic_master_img"  />
                    id="pic_master_img" onchange="file(this)"
                    <img src="images/timg.jpg" style="width: 100px;height:100px;border:1px solid #eaeaea;" id="pic_master_img"/>
                </div>
            </div>
             <div style="overflow: hidden;margin-bottom:20px;">
                <label><a onclick='addnew1(this);' href='javascript:void(0);'>[+]</a>话题图片：</label>
                <div style="position:relative;float:left;">
                    <input type="file" class="add_img" style="opacity: 0;position:absolute;top:0px;left:0px;width: 100px;height:100px;" value="" name="pic_images"  onchange="file2(this)" />
                    <img src="images/timg.jpg" style="width: 100px;height:100px;border:1px solid #eaeaea;" id="pic_master_img2"/>  
                </div>
            </div> -->
           <p>
                <label>话题简介：</label>
                <input name="summary" disabled value="{$data.title}" type="text" size="30" /> 
            </p>
            <div >
                <label>话题内容：</label> 
                <textarea name="content" disabled="disabled" id="textContent" style="width:600px;height:400px;">{$data.content}</textarea>
                <!-- <textarea name="content" class="required textInput" cols="80" rows="50" style="margin: 0px; height:100px; width:483px;">{$data.content}</textarea>  -->
            </div>

            <div style="margin-top:20px;">
                <label>审核结果：</label>
                <select name="states">
                    <option value="1">审核不通过</option>
                    <option value="2">审核通过</option>
                </select>
            </div>
            <input type="hidden" name="talk_id" value="{$data.talk_id}"/>
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
    // var ai = 3;

    // function file(el) {
    //     for (var i = 0; i < el.files.length; i++) {
    //         $('#pic_master_img').attr('src',window.URL.createObjectURL(el.files[i]));
    //     } 
    // }

    // function file2(el) {
    //     for (var i = 0; i < el.files.length; i++) {
    //         $('#pic_master_img2').attr('src',window.URL.createObjectURL(el.files[i]));
    //     }
    // }
    // function file3(el) {
    //     for (var i = 0; i < el.files.length; i++) {
    //         $('#pic_master_img3').attr('src',window.URL.createObjectURL(el.files[i]));
    //     }
    // }
    // function file4(el) {
    //     for (var i = 0; i < el.files.length; i++) {
    //         $('#pic_master_img4').attr('src',window.URL.createObjectURL(el.files[i]));
    //     }
    // }
    // function file5(el) {
    //     for (var i = 0; i < el.files.length; i++) {
    //         $('#pic_master_img5').attr('src',window.URL.createObjectURL(el.files[i]));
    //     }
    // }
    // function file6(el) {
    //     for (var i = 0; i < el.files.length; i++) {
    //         $('#pic_master_img6').attr('src',window.URL.createObjectURL(el.files[i]));
    //     }
    // }
    // function file7(el) {
    //     for (var i = 0; i < el.files.length; i++) {
    //         $('#pic_master_img7').attr('src',window.URL.createObjectURL(el.files[i]));
    //     }
    // }
    // function file8(el) {
    //     for (var i = 0; i < el.files.length; i++) {
    //         $('#pic_master_img8').attr('src',window.URL.createObjectURL(el.files[i]));
    //     }
    // }


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
   
    //   function addnew(a){
    //     var p = $(a).parent().parent();
    //     if($(a).html() == "[+]")
    //     {
    //         // 把p克隆一份
    //         var newP = p.clone();
    //         newP.find("a").html("[-]");

    //         // 放在后面
    //         p.after(newP);
    //     }else
    //     {
    //         var id = $(a).attr('id');
    //         if(confirm("确定要删除吗？"))
    //         {
                   
    //                     p.remove();
    //         }
    //     }
    // }
    
    // function addnew1(a){
    //     var p = $(a).parent().parent();
    //     if($(a).html() == "[+]")
    //     {
    //         // 把p克隆一份
    //         var newP = p.clone();
    //         newP.find("a").html("[-]");
    //         newP.find("input").attr('onchange','file'+ai+'(this)');
    //         newP.find("img").attr('id','pic_master_img'+ai);
    //         newP.find("input").attr('name','goods_image'+ai);
    //         if(ai>6){
    //             alert('幅图太多啦');
    //         }

    //         ai++;

    //         // 放在后面
    //         p.after(newP);
    //     }else
    //     {
    //         var id = $(a).attr('id');
    //         if(confirm("确定要删除吗？"))
    //         {
                   
    //                     p.remove(); 
    //         }
    //     }
    // }
    //  function addnew2(a){
    //     var p = $(a).parent().parent().parent();
    //     if($(a).html() == "[+]")
    //     {
    //         // 把p克隆一份 
    //         var newP = p.clone();
         
    //         newP.find("a").html("[-]");
    //         // 放在后面
    //         p.after(newP);
    //     }else
    //     {
    //         var id = $(a).attr('id');
    //         if(confirm("确定要删除吗？"))
    //         {
                   
    //                     p.remove();
    //         }
    //     }
    // }
</script>
