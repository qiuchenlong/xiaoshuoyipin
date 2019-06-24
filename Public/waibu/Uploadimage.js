   function file(el) {//this 
        for (var i = 0; i < el.files.length; i++) { 
            $('#pic_master_img').attr('src',window.URL.createObjectURL(el.files[i]));
        }  
    } 
    function file2(el) {   
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img2').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    }
    function file3(el) {   
        for (var i = 0; i < el.files.length; i++) {  
            $('#pic_master_img3').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    } 
    function file4(el) { 
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img4').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    } 
    function file5(el) {
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img5').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    }
    function file6(el) { 
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img6').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    }
    function file7(el) {
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img7').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    }
    function file8(el) {
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img8').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    }
     function file9(el) {
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img9').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    }
     function file10(el) { 
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img10').attr('src',window.URL.createObjectURL(el.files[i]));
        }
    }


     function file0(el,num) {
        for (var i = 0; i < el.files.length; i++) {
            $('#pic_master_img'+num).attr('src',window.URL.createObjectURL(el.files[i]));
            var img = $(el).next(); 
            img.attr('id','pic_master_img'+num);

        }
    }
  
  //***************************************************************
    var ai = 3;
    function addnew1(a){ 
        var p = $(a).parent().parent().next(); 
        if($(a).html() == "添加多图"){
            // 把p克隆一份
            var newP = p.clone();
            newP.find("a").html("[-]");  
            newP.find("input").attr('onchange','file'+ai+'(this)');
            newP.find("img").attr('id','pic_master_img'+ai);
            newP.find("input").attr('name','goods_image'+ai);//生成类名
            if(ai>6){
                alert('幅图太多啦,最多可上传9张'); 
            }
            ai++;
            // 放在后面
            p.after(newP); 
        }else{
            var id = $(a).attr('id');
            if(confirm("确定要删除吗？"))
            {
             p.remove(); 
            }
        } 
    }