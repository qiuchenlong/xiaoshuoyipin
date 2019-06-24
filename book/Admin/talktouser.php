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
    <form method="post" action="?m=FeiAdmin&c=User&a=edittalktouser" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
    <p style="color:red;font-size:15px;">tips:同时按住ctrl可以多选:</p>
        <div class="pageFormContent" layoutH="56">
            <p style="margin-top:10px;overflow:hidden;">
                <label>话题选择：</label>
                   <select name="talk_id">
                     <volist name="system_talk" id="vo" key="k">
                            <option value="{$vo.talk_id}">{$k}:{$vo.content|substr=0,30}...</option>
                     </volist> 
                   </select>
            </p>

              <p style="margin-top:10px;overflow:hidden;">
                <label>系统用户：</label>
                   <select name="user_id">
                            <option value="">请选择系统用户</option>
                     <volist name="system_user" id="vo">
                            <option value="{$vo.user_id}">{$vo.name}</option>
                     </volist> 
                   </select>
            </p>

             <p style="margin-top:10px;overflow:hidden;">
                <label>真实用户：</label>
                   <select name="real_user_id">
                            <option value="">请选择真实用户</option>
                     <volist name="real_user" id="vo">
                            <option value="{$vo.user_id}">{$vo.name}</option>
                     </volist> 
                   </select>
            </p>
            
         <!--    <div style="margin-top:10px;">
                <label>关注用户：</label>
                   <iframe name="content_frame" marginwidth=0 marginheight=0 width=100% height=100 src="index.php?m=FeiAdmin&c=User&a=follow" frameborder=1></iframe>
            </div>
 -->
             <div style="margin-top:10px;width:300px;height:100px;">
                <label>关注用户：</label>
                   <select name="follow_user_id[]" multiple=”multiple” size="5">
                            <option value="">请选择用户</option>
                     <volist name="user" id="vo">
                            <option value="{$vo.user_id}">{$vo.name}</option>
                     </volist> 
                   </select>
            </div> 
            


            <div style="margin-top:10px;width:300px;height:100px;">
                <label>分享用户：</label>
                   <select name="sharetalk_user_id[]" multiple=”multiple” size="5">
                            <option>请选择用户</option>
                     <volist name="user" id="vo">
                            <option value="{$vo.user_id}">{$vo.name}</option>
                     </volist> 
                   </select>
            </div> 
            
            <div style="margin-top:10px;width:300px;height:100px;">
                <label>点赞用户：</label>
                   <select name="talklike_user_id[]" multiple=”multiple”>
                            <option>请选择用户</option>
                     <volist name="user" id="vo">
                            <option value="{$vo.user_id}">{$vo.name}</option>
                     </volist> 
                   </select>
            </div>

             <p style="margin-top:10px;">
                <label>虚拟点赞数：</label>   
                <input type="text" name="likecount" value="0" class="number required"/>
            </p>

             <p style="margin-top:10px;overflow:hidden;">
                <label>虚拟分享数：</label>
                <input type="text" name="sharecount" value="0" class="number required"/>
            </p>

             <p style="margin-top:10px;overflow:hidden;">
                <label>虚拟粉丝数：</label>
                <input type="text" name="fans" value="0" class="number required"/>
            </p>

            <!-- <div><label>飞币充值规则：</label>
                <textarea name="share_gui" class="textContent" style="width:800px;height:400px;" >{$Obj.share_gui}</textarea> 
            </div>

            <div><label>关于我们：</label>
                <textarea name="about_us" class="textContent" style="width:800px;height:400px;" >{$Obj.about_as}</textarea> 
            </div> -->
			
			<!-- <div style="border-radius:4px;width:200px;text-align:center;height:50px;line-height:50px;font-size:25px;color:#fff;background:red;margin-top:25px;" id="share">
			分配分享奖励
			</div> -->
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
	 
	$('#share').click(function(){ 
		$.ajax({
		    url:'?m=FeiAdmin&c=System&a=FenMoney',
			method:'get'
		}).done(function(ret){
			var ret = JSON.parse(ret);
			var code = ret.code;
			if(code == 200){
				alert('分配成功');
			}
		})
	})
</script>
