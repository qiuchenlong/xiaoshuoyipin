<style>
    .pageFormContent p{
        float:none;
    }

</style>
<div class="pageContent">
    <form method="post" action="?m=FeiAdmin&c=User&a=ShenHe" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone);">
        <div class="pageFormContent" layoutH="56">
		    <input value="{$user_id}" name="user_id" hidden="hidden"/>
            <div style="overflow: hidden">
                <label>真实姓名：</label>
				<label>{$Obj.realname}</label>
            </div>
            <div style="overflow: hidden">
                <label>工作类型：</label>
				<label>{$Obj.worktype}</label> 
            </div>
			<div style="overflow: hidden">
                <label>工作单位：</label>
				<label>{$Obj.companyname}</label>
            </div>
            <div style="overflow: hidden">
                <label>职位：</label>
				<label>{$Obj.job}</label>
            </div>
            <div style="overflow: hidden;margin-top:20px">
                <label>身份证正面：</label>
                <div style="position:relative;float:left;">
                   
                    <img src="{$Obj.identificationu}" style="width: 100px;height:100px;border:1px solid #eaeaea;" id="pic_master_img"/>
                </div>
            </div>
			<div style="overflow: hidden;margin-top:20px">
                <label>身份证反面：</label>
                <div style="position:relative;float:left;">
                    <img src="{$Obj.identificationd}" style="width: 100px;height:100px;border:1px solid #eaeaea;" id="pic_master_img"/>
                </div>
            </div>
			<div style="overflow: hidden;margin-top:20px">
                <label>工作证/学生证：</label>
                <div style="position:relative;float:left;">
                    <input type="file" class="add_img" style="opacity: 0;position:absolute;top:0px;left:0px;width: 100px;height:100px;" value="" name="image"  onchange="file(this)" class="required"/>
                    <img src="{$Obj.workimg}" style="width: 100px;height:100px;border:1px solid #eaeaea;" id="pic_master_img"/>
                </div>
            </div>
			
			<div style="overflow: hidden;margin-top:20px;">
				<label>是否通过审核：</label>
				<select class="required" name="state">
					<option value="2">通过</option>
					<option value="3">不通过</option>
				</select>
			</div> 
            <div style="overflow:hidden;margin-top:20px;">
                <label>认证类型</label>
                <select class="required" name="authentication"> 
                    <option value="0">请选择认证类型</option>
                    <option value="1">个人认证</option>
                    <option value="2">专业认证</option>
                    <option value="3">专家认证</option>
                </select>
            </div> 
            <div style="clear:both;"></div>
            <div style="overflow:hidden;margin-top:20px;"> 
                <div>系统消息提示给用户：
                </div>
                <div style="overflow: hidden">
                   <label>系统消息标题：</label>
                    <input type="text" name="title" size="30"/>
                </div>
                <br/>
                <div style="overflow: hidden"> 
                    <label>系统消息内容：</label>
                    <input type="text" name="content" size="30" />
                </div>

                <!-- </div> -->
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



</script>
