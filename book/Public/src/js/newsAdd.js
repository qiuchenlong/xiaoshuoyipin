layui.use(['form','layer','layedit','laydate','upload'],function(){
    var form = layui.form
        layer = parent.layer === undefined ? layui.layer : top.layer,
        laypage = layui.laypage,
        upload = layui.upload,
        layedit = layui.layedit,
        laydate = layui.laydate,
        upurl = "<{:U('Index/addimages')}>",//上传图片地址
        duotu = true,//是否为多图上传true false
        $ = layui.jquery;

    //用于同步编辑器内容到textarea
    layedit.sync(editIndex);

    //上传缩略图
    // upload.render({
    //     elem: '.thumbBox',
    //     url: '../../json/userface.json',
    //     method : "get",  //此处是为了演示之用，实际使用中请将此删除，默认用post方式提交
    //     done: function(res, index, upload){
    //         var num = parseInt(4*Math.random());  //生成0-4的随机数，随机显示一个头像信息
    //         $('.thumbImg').attr('src',res.data[num].src);
    //         $('.thumbBox').css("background","#fff");
    //     }
    // });
    upload.render({
        elem: '#upload_img',
        url: upurl,
        multiple: duotu,
        before: function(obj) {
            layer.msg('图片上传中...', {
                icon: 16,
                shade: 0.01,
                time: 0
            })
        }, 
        done: function(res) {
            layer.close(layer.msg());//关闭上传提示窗口
            if (duotu == true) {//调用多图上传方法,其中res.imgid为后台返回的一个随机数字
            $('#upload_img_list').append('<dd class="item_img" id="' + res.imgid + '"><img style="max-height: 150px;max-width: 500px;" src="' + res.tolink + '" class="img" ><input type="hidden" name="dzd_img[]" value="' + res.tolink.substr(34) + '" /></dd>');
            }else{//调用单图上传方法,其中res.imgid为后台返回的一个随机数字
                $('#upload_img_list').html('<dd class="item_img" id="' + res.imgid + '"><img style="max-height: 150px;max-width: 500px;" src="' + res.tolink + '" class="img" ><input type="hidden" name="dzd_img" value="' + res.tolink.substr(34) + '" /></dd>');
                // $('#upload_img_listss').html('<span>limingjie</span>');
            } 
        }
    })

    //格式化时间
    // function filterTime(val){
    //     if(val < 10){
    //         return "0" + val;
    //     }else{
    //         return val;
    //     }
    // }
    //定时发布
    // var time = new Date();
    // var submitTime = time.getFullYear()+'-'+filterTime(time.getMonth()+1)+'-'+filterTime(time.getDate())+' '+filterTime(time.getHours())+':'+filterTime(time.getMinutes())+':'+filterTime(time.getSeconds());
    // laydate.render({
    //     elem: '#release',
    //     type: 'datetime',
    //     trigger : "click",
    //     done : function(value, date, endDate){
    //         submitTime = value;
    //     }
    // });
    // form.on("radio(release)",function(data){
    //     if(data.elem.title == "定时发布"){
    //         $(".releaseDate").removeClass("layui-hide");
    //         $(".releaseDate #release").attr("lay-verify","required");
    //     }else{
    //         $(".releaseDate").addClass("layui-hide");
    //         $(".releaseDate #release").removeAttr("lay-verify");
    //         submitTime = time.getFullYear()+'-'+(time.getMonth()+1)+'-'+time.getDate()+' '+time.getHours()+':'+time.getMinutes()+':'+time.getSeconds();
    //     }
    // });
   //验证
    form.verify({
        newsName : function(val){
            if(val == ''){
                return "文章标题不能为空";
            }
        },
        content : function(val){
            if(val == ''){
                return "文章内容不能为空";
            }
        } 
    })

    //一级分类出二级分类
    form.on('select(province)', function(data){
            $.getJSON("/shouquan/index.php/Client/Index/getseclassify?pid="+data.value, function(data){
                var optionstring = "";
                $.each(data, function(i,item){
                    optionstring += "<option value=\"" + item.seclassify_id + "\" >" + item.name + "</option>";
                });
                $("#city").html('<option value=""></option>' + optionstring);
                form.render('select'); //这个很重要
            });
}); 

    //提交
    form.on("submit(addNews)",function(data){
        //截取文章内容中的一部分文字放入文章摘要
        var abstract = layedit.getText(editIndex).substring(0,50);
        //弹出loading
        var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
        // 实际使用时的提交信息
        $.post("<{:U('Index/adddongtai')}>",{
            title : $(".newsName").val(),  //文章标题
            content : layedit.getContent(editIndex).split('<audio controls="controls" style="display: none;"></audio>')[0],  //文章内容
            newsImg : $(".thumbImg").attr("src"),  //缩略图
            images:'duoimages',
            classify : '1',    //文章一级分类
            seclassify:'2',    //文章二级分类
        },function(res){
            console.log(res); 
        })
        console.log(res);
        setTimeout(function(){
            top.layer.close(index);
            top.layer.msg("文章添加成功！");
            layer.closeAll("iframe");
            //刷新父页面 
            parent.location.reload();
        },500);
        return false;
    })

    //预览
    // form.on("submit(look)",function(){
    //     layer.alert("此功能需要前台展示，实际开发中传入对应的必要参数进行文章内容页面访问");
    //     return false;
    // })

    //创建一个编辑器
    var editIndex = layedit.build('news_content',{
        height : 535,
        uploadImage : {
            url : "<{:url('addimages')}>", 
            type: "post"  
        }
    }); 

})