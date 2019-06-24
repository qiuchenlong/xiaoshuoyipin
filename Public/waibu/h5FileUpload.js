/**
*HTML5 ajax上传文件
*{object} id selector
*{object} suffix 文件类型 
*{object} prefixpath 上传到指定目录
 */

function h5FileUpload(id,suffix,prefixPath){
	var file_input = document.getElementById(id);
	var file_name = file_input.files[0].name;
	var file_suffix = file_name.substring(file_name.lastIndexOf('.')+1);

	var xurl;

	//判断类型
	if(suffix.indexOf(file_suffix) == -1){ 
		alert('所选文件类型不符合需要！'); 
		file_input.value= ''; 
	}else{
		var index = layer.msg('文件上传中.......',{icon:16,
			shadeClose:false,
			shade:[0.1,'#fff']   
		});

		//构造FormData对象用于发送数据
		var formData = new FormData();//构造空对象，下面用append方法赋值
		formData.append("simpleupload",$('#' + id)[0].files[0]);
		console.log(formData);
		$.ajax({ 
			url:'UploadImg', 
			type:"post", 
			data:formData,  
			processData:false,
			contentType:false,
			async:false,
			success:function(data){
				layer.close(index); //关闭弹出框。
				// id = id.replace('File','');
				// $('#' + id).val(data.url);  
				xurl = data.url;
				//图片生成
				// if()
				
			},
			error:function(data){    
				layer.close(index);
				showFailMessage('上传失败');    
			}

			
		}); 

				
			
	}
	return xurl;

}


function showFailMessage(msg){ 
	layer.msg(msg,{icon:1,time:6000});  
}

