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
	
	<form method="post" action="index.php?c=Index&a=addPropery" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
		<div class="pageFormContent" layoutH="58">
			<foreach name="ProList" item="ProItem" key="k">
				<ul>
					<foreach name="ProItem" item="son">
							<div class="unit">
								<label>{$k}：</label>
								<input type="text" class="cinput" name="fTitle[]"  value="{$son.fTitle}" class="required" />
								<input type="text" name="proid[]"  hidden="hidden" value="{$son.proid}" />
								<label>属性价格：</label>
								<input type="text" class="cinput" name="price[]" value="{$son.price}" class="required" />
								<span style="color:blue;font-size:17px;font-weight: 600;height:22px;line-height:22px;margin-left:20px;cursor: pointer;" onclick="addPro(this)" class="addPro">+</span>
							</div>
					</foreach>
				</ul>

			</foreach>

			
		</div>
		<input name="goodsid" value="{$goodsid}" hidden="hidden"/>
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
		$addNode.appendChild($('<span style="color:blue;font-size:17px;font-weight: 600;height:22px;line-height:22px;margin-left:20px;cursor: pointer;" onclick="addPro(this)" class="addPro">-</span>'));
		$addNode.find('.cinput').val("");
		$addNode.insertAfter($cloneNode);
	}

</script>
