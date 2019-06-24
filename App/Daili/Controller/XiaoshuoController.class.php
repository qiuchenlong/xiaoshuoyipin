<?php
namespace Daili\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class XiaoshuoController extends CommonController {

  //小说
    public function xiaoshuo(){
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['articlename|author'] = array('like', "%$con%");
            $arr=M('jieqi_article_article')->where(['did'=>session('user_id')])->where($data)->select();
               foreach ($arr as $k => $v) {
                
                 $a['sortid']=$v['sortid'];
                $info=M("jieqi_article_sort")->where($a)->find();
                $arr[$k]['sortid']=$info['caption'];

                $b['sortid']=$info['layer'];
                $info1=M("jieqi_article_sort")->where($b)->find();
                $arr[$k]['lanmu']=$info1['caption'];


                $q=$v['size']*0.66;
                $arr[$k]['size']=round($q,2);

                 if($v['did']==session('user_id') || session('guanli')>0){
                    $arr[$k]['quan']=1;
                }else{
                    $arr[$k]['quan']=0;
                }


            }
            
            $this->assign('arr',$arr);
            $this->display(); 
        }else{

            if(session('user_id')>0){

                $pai='did desc';
            }else{
                $pai='articleid desc';
            }
            $model =M("jieqi_article_article");
            //查出总条数 
            $count = $model->where(['did'=>session('user_id')])->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where(['did'=>session('user_id')])->order($pai)->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            foreach ($arr as $k => $v) {
               
                $a['sortid']=$v['sortid'];
                $info=M("jieqi_article_sort")->where($a)->find();
                $arr[$k]['sortid']=$info['caption'];

                $b['sortid']=$info['layer'];
                $info1=M("jieqi_article_sort")->where($b)->find();
                $arr[$k]['lanmu']=$info1['caption'];


                $q=$v['size']*0.66;
                $arr[$k]['size']=round($q,2);
                // $f=$v['intro'];
                // preg_match_all('/./u', $f, $aq);
                // $arr[$k]['intro']=$aq[0][1].$aq[0][2].$aq[0][3].$aq[0][4].$aq[0][5].$aq[0][6].'...';
                // var_dump($f);
                if($v['did']==session('user_id') || session('guanli')>0){
                    $arr[$k]['quan']=1;
                }else{
                    $arr[$k]['quan']=0;
                }
            }


            

            // var_dump($info);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        

        }
          
        
    }

    //小说
    public function xszhangjie(){
        
            $a['articleid']=I('id');
            $model =M("jieqi_article_chapter");
            //查出总条数 
            $count = $model->where($a)->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($a)->limit($page->firstRow.','.$page->listRows)->order('chapterid asc')->select();
            //分页
            
            $btn = $page->show();

            

            

            // var_dump($info);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
            
    }


    //推送
    public function tuisong(){
        
           
            //查询数据并分页
            $model =M("jieqi_article_article");
            //查出总条数 
            $a['isshou']=1;
            $count = $model->where($a)->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
             $a['isshou']=1;
            $arr = $model->where($a)->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            foreach ($arr as $k => $v) {
                if($v['articletype']==1){
                    $arr[$k]['articletype']='推荐';
                }else if($v['articletype']==2){
                    $arr[$k]['articletype']='精选';
                }else if($v['articletype']==3){
                    $arr[$k]['articletype']='完结';
                }else if($v['articletype']==4){
                    $arr[$k]['articletype']='免费';
                }

                if($v['display']==0){
                     $arr[$k]['display']='<font color="green">上架中</font>';
                }else{
                     $arr[$k]['display']='已下架'; 
                }

                 if($v['isshou']==1){
                     $arr[$k]['isshou']='<font color="blue">是</font>';
                }else{
                     $arr[$k]['isshou']='否'; 
                }
                
            }

           
            

           
            //分配数据
            $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
    }

    //销售
    public function xiaoshou(){

            //代理商
           $da['lei']=1;
           $dai=M('jieqi_system_users')->where($da)->select();

           // if(session('user_id')>0){
           $did['did']=session('user_id');
           // }else{
           //      if(I('id')>0){
           //          $did['did']=I('id');
           //      }
           // }
           
        
            //查询数据并分页
            $model =M("jieqi_article_article");
            //查出总条数 
            $count = $model->where($did)->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($did)->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

           foreach ($arr as $k => $v) {
                //销售数量
               $xiao['aid']=$v['articleid'];
               $shu=M('orders')->where($xiao)->count();
               $daijin=M('orders')->where($xiao)->sum('daijin');
               $money=M('orders')->where($xiao)->sum('money');
               $arr[$k]['zongshu']=$shu;
               $arr[$k]['daijin']=$daijin;
               $arr[$k]['money']=$money;
               //阅读数量
               $yue['articleid']=$v['articleid'];
               $yue['flag']=1;
               $yuedu=M('jieqi_article_bookcase')->where($yue)->count();
               $arr[$k]['yuedu']=$yuedu;
               //代理
               if($v['did']>0){
                    $dname=M('jieqi_system_users')->find($v['did']);
                    $arr[$k]['dainame']=$dname['uname'];
               }else{
                    $arr[$k]['dainame']='无';
               }
               
           }

           

           
            

           
            //分配数据
            $this->assign('dai',$dai);
            $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
        
    }



     //销售
    public function orders(){
        
            //查询数据并分页
            $model =M("orders");
            //查出总条数 
            $count = $model->join('__JIEQI_ARTICLE_ARTICLE__ ON __ORDERS__.aid = __JIEQI_ARTICLE_ARTICLE__.articleid')->where(['did'=>session('user_id')])->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->join('__JIEQI_ARTICLE_ARTICLE__ ON __ORDERS__.aid = __JIEQI_ARTICLE_ARTICLE__.articleid')->where(['did'=>session('user_id')])->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            foreach ($arr as $k => $v) {
                $user=M('jieqi_system_users')->find($v['user_id']);
                $arr[$k]['user_id']=$user['name'];
                $user=M('jieqi_article_article')->find($v['aid']);
                $arr[$k]['aid']=$user['articlename'];
                if ($v['path']==0) {
                    $arr[$k]['path']='全集购买';
                }else{
                    $arr[$k]['path']=$v['path']*100;
                }
                $z=strpos($v['cid'],',');
                if($z==false){
                    $a['chapterid']=$v['cid'];
                    $zhangjie=M('jieqi_article_chapter')->where($a)->find();
                    $arr[$k]['cid']=$zhangjie['chaptername'];
                }else{
                    $zhang=explode(",",$v['cid']);
                    foreach ($zhang as $ke => $va) {
                        $a['chapterid']=$va;
                        $zhangjie=M('jieqi_article_chapter')->where($a)->find();
                        $zz[]=$zhangjie['chaptername'];
                         // var_dump($zhangjie);die; 
                    }
                    $arr[$k]['cid']=implode(",",$zz);  
                    
                }

            }

           

           
            

           
            //分配数据
            $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
        
    }

   
    public function del(){
        // var_dump(I());die;
        $id=$_GET['id'];
        $arr=M('jieqi_article_article')->delete($id);
        if($arr>0){
           
                echo '<script>alert("删除成功");location.href="xiaoshuo"</script>';
            

          
        }
    }

    public function zjdel(){
        
        $id['chapterid']=$_GET['id'];
       


              // var_dump($id);die;
        $arr=M('jieqi_article_chapter')->where($id)->delete();
         // var_dump( $arr);die;
        if($arr>0){
           
                echo '<script>alert("删除成功");location.href="xszhangjie?id='.$_GET['fid'].'"</script>';
            

          
        }
    }

    public function ajaxfenlei(){ 
            $Model = M('');
            
            $pindao=$_REQUEST['id'];
            
        
            $data = $Model->Query("SELECT imgurl,sortid,shortname FROM jieqi_article_sort  where `layer`=".$pindao."  order by sortid desc  ");
               
            // $data = array($data);
            echo json_encode($data); 


    }

   
    
  public function add(){

          $f['layer']=0;
            $fenlei=M('jieqi_article_sort')->where($f)->select();

            $s['pindao']=1;
            $pin1=M('jieqi_article_fenlei')->where($s)->select();
             $s1['pindao']=2;
            $pin2=M('jieqi_article_fenlei')->where($s1)->select();

             $s2['pindao']=3;
            $pin3=M('jieqi_article_fenlei')->where($s2)->select();

             $s3['pindao']=4;
            $pin4=M('jieqi_article_fenlei')->where($s3)->select();

        if(IS_AJAX){
            $a['types']=I('id');
            $a['layer']=array('gt',0);
            $b['layer']=0;
            $arr=M('jieqi_article_sort')->where($a)->select();
            foreach ($arr as $k => $v) {
              $info=M('jieqi_article_sort')->where($b)->select();
                foreach ($info as $j => $s) {
                    if($v['layer']==$s['sortid']){
                       $arr[$k]['layer']= $s['caption'];
                    }
                } 
            }
            $this->ajaxReturn($arr);

        }

        if(IS_POST){
         // var_dump(I(''));exit;

          //获得标签
         $biaoqian= array();
         $biaoqian=$_POST['biaoq'];
         $biaoqians="";
         foreach ($biaoqian as $key => $value)
          {
          if($biaoqians=="")
          {
           $biaoqians=$value; 
           }
           else{ 
          $biaoqians=$biaoqians.",".$value; 
               }
         }

                //获得fenlei 
         $fenlei= array();
         $fenlei=$_POST['fenlei'];
         $fenleis="";
         foreach ($fenlei as $key => $value)
          {
          if($fenleis=="")
          {
           $fenleis=$value; 
            $sorts=$value; 
           }
           else{ 
          $fenleis=$fenleis.",".$value; 
               }
         }

            if(empty($_POST['articlename']) | empty($_POST['author']) | empty($_POST['intro']) ){
                    echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
                 }
             //上传图片
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath  =     'Public/uploads/'; // 设置附件上传根目录
                $upload->savePath  =     ''; // 设置附件上传（子）目录
                 // 上传文件 
                $info   =   $upload->upload();
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError()); die;
                }else{// 上传成功
                    // $this->success('上传成功！'); 
                    $b='uploads/'.$info['images']['savename'];
                   
                }
                //articlename  author duanping typeid articletype
                //saleprice  ffee keywords intro
                $add['articlename']=I('articlename');
                $add['author']=I('author');
                $add['typeid']=I('typeid');
                $add['articletype']=I('articletype');
                // $add['isshou']=I('isshou');
                $add['newbook']=0;
                $add['fengyun']=0;
                $add['duanping']=I('duanping');
                $add['lianzai']=0;
                $add['wanjie']=0;
                $add['intro']=I('intro');
                $add['did']=session('user_id');
                $add['ffee']=I('ffee');
                $add['sortid']=$sorts;
                $add['fenlei']=$fenleis;
                $add['biaoqian']=$biaoqians;
                // $add['allvisit']=I('allvisit');
                // $add['salenum']=I('salenum');
                $add['keywords']=I('keywords');
                $add['images']=$b;

                $add['saleprice']=I('saleprice');
                $add['lastupdate']=date("Y-m-d H:i:s");
                // var_dump($add);die;
            $sql=M('jieqi_article_article')->add($add);


            if ($sql> 0){
                echo '<script>alert("添加成功");window.parent.location.reload()</script>';
            } else {
                echo '<script>alert("添加失败");history.go(-1)</script>';
            }
              
               
        }else{
            
            $this->assign('pin1',$pin1);
            $this->assign('pin2',$pin2);
            $this->assign('pin3',$pin3);
            $this->assign('pin4',$pin4);
            $this->assign('fenlei',$fenlei);
           $this->display();  
        }

        

    }
    

     public function zhangjie(){
        if(IS_POST){
             // var_dump(I());die;
            if(empty($_POST['lastchapter']) | empty($_POST['attachment'])  ){
                    echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
                 }
            $a['articleid']=I('id');
            $a['lastchapter']=$_POST['lastchapter'];
            $a['lastupdate']=date("Y-m-d H:i:s");                      
            $sql=M('jieqi_article_article')->save($a);

            $b['articleid']=I('id');
            $b['articlename']=$_POST['name'];            //小说名
            $b['chaptername']=$_POST['lastchapter'];     //最新一章       
            $b['attachment']=$_POST['attachment'];      //内容
            $b['lastupdate']=time(); 
            $b['size']=strlen($_POST['attachment']);
            $sql=M('jieqi_article_chapter')->add($b);
            
            // var_dump( $sum);die;
            if ($sql> 0){
                echo '<script>alert("添加成功");window.parent.location.reload()</script>';
            } else {
                echo '<script>alert("添加失败");history.go(-1)</script>';
            }
              
               
        }else{
            $a['articleid']=I('id');
            $v=M('jieqi_article_article')->where($a)->find();
             $this->assign('v',$v);
           $this->display();  
        }

        

    }



     public function sjadd(){
        if(IS_POST){
             // var_dump(I());die;
            if(empty($_POST['caption'])){
                    echo '<script>alert("添加失败：请填写完整的资料");history.go(-1)</script>';die;
                 }

                 $a['layer']=$_POST['layer'];
                 $a['caption']=$_POST['caption'];
                 $a['types']=$_POST['types'];
              
               
                // $a['images']=$b;
                // var_dump($a);die;
                $sql=M('jieqi_article_sort')->add($a);
                 if ($sql> 0){
                    if($_POST['types']==1){
                            echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                    }else if($_POST['types']==2){
                            echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                    }else{
                            echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                    }
                    
                } else {

                    echo '<script>alert("添加失败");history.go(-1)</script>';
                }
              
               
        }else{
            $a['layer']=0;
            $arr=M("jieqi_article_sort")->where($a)->select();
            $this->assign('arr',$arr);
           $this->display();  
        }

        

    }

     public function edit(){

          $f['layer']=0;
            $fenlei=M('jieqi_article_sort')->where($f)->select();

            $s['pindao']=1;
            $pin1=M('jieqi_article_fenlei')->where($s)->select();
             $s1['pindao']=2;
            $pin2=M('jieqi_article_fenlei')->where($s1)->select();

             $s2['pindao']=3;
            $pin3=M('jieqi_article_fenlei')->where($s2)->select();

             $s3['pindao']=4;
            $pin4=M('jieqi_article_fenlei')->where($s3)->select();
            
        if(IS_POST){

       
               //获得标签
         $biaoqian= array();
         $biaoqian=$_POST['biaoq'];
         $biaoqians="";
         foreach ($biaoqian as $key => $value)
          {
          if($biaoqians=="")
          {
           $biaoqians=$value; 
           }
           else{ 
          $biaoqians=$biaoqians.",".$value; 
               }
         }

         //获得fenlei 
         $fenlei= array();
         $fenlei=$_POST['fenlei'];
         $fenleis="";
         foreach ($fenlei as $key => $value)
          {
          if($fenleis=="")
          {
           $fenleis=$value; 
            $sorts=$value; 
           }
           else{ 
          $fenleis=$fenleis.",".$value; 
               }
         }   

                 // var_dump(I());die;
                 if(empty($_POST['articlename']) | empty($_POST['author']) | empty($_POST['intro']) ){
                    echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
                 }
                
                  //上传图片

                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize   =     3145728 ;// 设置附件上传大小
                    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                    $upload->rootPath  =     'Public/uploads/'; // 设置附件上传根目录
                     $upload->savePath  =     ''; // 设置附件上传（子）目录
                 // 上传文件 
                    $info   =   $upload->upload();
                    if($info>0){
                        if(!$info) {// 上传错误提示错误信息
                            $this->error($upload->getError()); die;
                        }else{// 上传成功
                        // $this->success('上传成功！'); 
                            $b='uploads/'.$info['images']['savename'];
                            $add['images']=$b;
                        } 
                    }
                    
                    if($sorts){

                $add['sortid']=$sorts;
                 $add['fenlei']=$fenleis;
                  }
              if($biaoqians){

                $add['biaoqian']=$biaoqians;

                 }
                
                 $add['articleid']=I('articleid');
                $add['articlename']=I('articlename');
                $add['author']=I('author');
                $add['typeid']=I('typeid');
                $add['articletype']=I('articletype');
                // $add['isshou']=I('isshou');
                // $add['newbook']=I('newbook');
                $add['duanping']=I('duanping');
                // $add['fengyun']=I('fengyun');
                // $add['lianzai']=I('lianzai');
                $add['ffee']=I('ffee');
                // $add['wanjie']=I('wanjie');
                // $add['sortid']=I('fenlei');
                $add['biaoqian']=$biaoqians;
                $add['intro']=I('intro');
                $add['keywords']=I('keywords');
                // $add['allvisit']=I('allvisit');
                // $add['salenum']=I('salenum');
                $add['saleprice']=I('saleprice');
                $add['lastupdate']=date("Y-m-d H:i:s");

              // var_dump($add);die;

                $sql=M('jieqi_article_article')->save($add);
                 if ($sql> 0){
                   
                    echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                   
                    
                } else {

                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
              
               
        }else{

            

            $a['articleid']=I('id');
            $arr=M("jieqi_article_article")->where($a)->find();
         
             
            
             $this->assign('v',$arr);
               // var_dump($arr);
            $this->assign('pin1',$pin1);
            $this->assign('pin2',$pin2);
            $this->assign('pin3',$pin3);
            $this->assign('pin4',$pin4);
            $this->assign('fenlei',$fenlei);
           $this->display();  
        }

        

    }


     public function zjedit(){
        if(IS_POST){
            // if(empty($_POST['chaptername']) | empty($_POST['saleprice']) | empty($_POST['attachment'])  ){
            //         echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
            // }
            // var_dump(I(''));die;
            $file_path =I('texts');
             $attachment=I('attachment');
            if ($_FILES['images']['name']!='') {
              //上传图片
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     53145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt','docx');// 设置附件上传类型
                $upload->rootPath  =     'Public/text/'; // 设置附件上传根目录
                $upload->savePath  =     ''; // 设置附件上传（子）目录
                 // 上传文件 
                $info   =   $upload->upload();
                 // var_dump($info);die;
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError()); die;
                }else{// 上传成功
                    // $this->success('上传成功！'); 
                    $b='text/'.$info['images']['savename'];
                }
                $file_path ="Public/".$b;
                if(file_exists($file_path)){
                    $fp = fopen($file_path,"r");
                    $str = "";
                    $buffer = 1024;//每次读取 1024 字节
                    while(!feof($fp)){//循环读取，直至读取完整个文件
                        $str .= fread($fp,$buffer);
                    } 


                    //将编码转换utf-8
                    if(!empty($str) ){    
                            $fileType = mb_detect_encoding($str, array('UTF-8','GBK','LATIN1','BIG5')) ;   
                    if( $fileType != 'UTF-8'){   
                            $data = mb_convert_encoding($str ,'utf-8' , $fileType);   
                            }   
                     }   

                    
                    // $oop=iconv("gb2312", "utf-8", $str);    
                    // var_dump($data);die;
                    // $str = str_replace("\r\n","<br />",$str);
                    $pc=ltrim($data,"#");
                    $arr=explode("#",$pc);
                    $attachment=$arr[0];
                    // var_dump();die;
                    //删除旧文件
                    unlink(I('texts'));
                         
                }
            }

            
                  
                 
             

               
                 $c['chapterid']=I('chapterid');
                 $a['chaptername']=$_POST['chaptername'];
                 $a['texts']=$file_path;
                 $a['saleprice']=$_POST['saleprice'];
                 $a['attachment']=$attachment;
                 $a['lastupdate']=date('Y-m-s H:i:s');
                $sql=M('jieqi_article_chapter')->where($c)->save($a);
                 if ($sql> 0){
                   
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                   
                    
                } else {

                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
              
               
        }else{

            

            $a['chapterid']=I('id');
            $arr=M("jieqi_article_chapter")->where($a)->find();
           
             
             // var_dump($arr);die;
             $this->assign('v',$arr);
              
           
           $this->display();  
        }

        

    }


   

    public function tsedit(){
        if(IS_POST){
              // var_dump(I());die;
            

             

               

                 $a['articleid']=$_POST['id'];
                 $a['articletype']=$_POST['wenzhang'];
                 $a['display']=$_POST['shangxia'];
                  $a['isshou']=$_POST['shouye'];
                  $a['issort']=$_POST['issort'];

              
               
                // $a['images']=$b;
                // var_dump($a);die;
                $sql=M('jieqi_article_article')->save($a);
                 if ($sql> 0){
                   
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                   
                    
                } else {

                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
              
               
        }else{

             $d['articleid']=$_GET['id'];
            $arr=M("jieqi_article_article")->where($d)->find();
               
            
          
             $this->assign('v',$arr);
             // var_dump($arr);
           
           $this->display();  
        }

        

    }


    public function tuijian()
    {

        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['articlename|author'] = array('like', "%$con%");
            $data['articletype']=1;
            $arr=M('jieqi_article_article')->where($data)->select();
              $this->assign('arr',$arr);
              $this->display(); 

        }else{
             $model =M("jieqi_article_article");
            //查出总条数 
             $a['articletype']=1;
            $count = $model->where($a)->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $a['articletype']=1;
            $arr = $model->where($a)->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();
            // var_dump($info);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        }     
           
            
    }

    public function jingxuan()
    {       
         if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['articlename|author'] = array('like', "%$con%");
            $data['articletype']=2;
            $arr=M('jieqi_article_article')->where($data)->select();
              $this->assign('arr',$arr);
              $this->display(); 

        }else{
            $model =M("jieqi_article_article");
         
             //查出总条数 
             $a['articletype']=2;
            $count = $model->where($a)->count();

            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
             $a['articletype']=2;
            $arr = $model->where($a)->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();
            // var_dump($info);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display(); 
        }  
            
    }

    public function mianfei()
    {       
         if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['articlename|author'] = array('like', "%$con%");
            $data['articletype']=4;
            $arr=M('jieqi_article_article')->where($data)->select();
              $this->assign('arr',$arr);
              $this->display(); 

        }else{
            $model =M("jieqi_article_article");
              //查出总条数 
             $a['articletype']=4;
            $count = $model->where($a)->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
             $a['articletype']=4;
            $arr = $model->where($a)->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();
            // var_dump($info);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display(); 
        }  
            
    }

    public function wanjie()
    {
         if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['articlename|author'] = array('like', "%$con%");
            $data['articletype']=3;
            $arr=M('jieqi_article_article')->where($data)->select();
              $this->assign('arr',$arr);
              $this->display(); 

        }else{
            $model =M("jieqi_article_article");
              //查出总条数 
             $a['articletype']=3;
            $count = $model->where($a)->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
             $a['articletype']=3;
            $arr = $model->where($a)->limit($page->firstRow.','.$page->listRows)->select();

            //分页
            
            $btn = $page->show();
            // var_dump($info);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        }
            
    }



     //标签
    public function biaoqian(){
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['articlename|author'] = array('like', "%$con%");
            $arr=M('jieqi_article_article')->where($data)->select();
               foreach ($arr as $k => $v) {
                
                 $a['sortid']=$v['sortid'];
                $info=M("jieqi_article_sort")->where($a)->find();
                $arr[$k]['sortid']=$info['caption'];

                $b['sortid']=$info['layer'];
                $info1=M("jieqi_article_sort")->where($b)->find();
                $arr[$k]['lanmu']=$info1['caption'];


                $q=$v['size']/1024/1024;
                $arr[$k]['size']=round($q,2);

            }
            
            $this->assign('arr',$arr);
            $this->display(); 
        }else{

            $model =M("jieqi_article_article");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order('articleid desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            foreach ($arr as $k => $v) {
                $shu=strlen($v['biaoqian']);
                if($shu>1){
                    $shu=explode(",",$v['biaoqian']);         
                    foreach ($shu as $o => $p) {
                        $bb=M('jieqi_article_fenlei')->find($p);
                        $shu[$o]=$bb['title'];
                    }
                    $ming=implode("&nbsp;,&nbsp;",$shu);
                    $arr[$k]['biaoti']=$ming;
                }else if($shu==1){
                    $biaoqian=M('jieqi_article_fenlei')->find($v['biaoqian']);
                    $arr[$k]['biaoti']=$biaoqian['title'];
                }
               
                 
            }
          
            

           
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        

        }
          
        
    }

    //修改标签
     public function bedit(){
        if(IS_POST){
               
            $arr=M('jieqi_article_article')->find(I('articleid'));
            if($arr['biaoqian']==null){
                $sql=M('jieqi_article_article')->save($_POST);  
            }else{
                $a['articleid']=I('articleid');
                $a['biaoqian']=$arr['biaoqian'].','.I('biaoqian');
                $sql=M('jieqi_article_article')->save($a);
            }


                if ($sql> 0){
                   
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                   
                    
                } else {

                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
              
               
        }else{

            

            $a['articleid']=I('id');
            $arr=M("jieqi_article_article")->where($a)->find();
            $f['pindao']=$arr['typeid'];
            $fenlei=M('jieqi_article_fenlei')->where($f)->select();
               
             $this->assign('v',$arr);
             $this->assign('fenlei',$fenlei);
               // var_dump($arr);
           
           $this->display();  
        }

        

    }


public function czedit(){

        if(IS_POST){
         
               
                $add['cname']=I('cname');
                $add['shijian']=I('shijian');
                $add['jianjie']=I('jianjie');
                $add['price']=I('price');
                $add['egold']=I('egold');
                $add['gcount']=I('gcount');
            $sql=M('chongzhipath')->add($add);


            if ($sql> 0){
                echo '<script>window.parent.location.reload();</script>';
            } else {
                echo '<script>alert("添加失败");</script>';
            }
              
               
        }else{
           $this->display();  
        }

        

    }

//添加充值样式
    public function chongzhi(){
        if(IS_POST){

           
            
            $this->assign('arr',$arr);
            $this->display(); 
        }else{

            $model =M("chongzhipath");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            // foreach ($arr as $k => $v) {
            //     $shu=strlen($v['biaoqian']);
            //     if($shu>1){
            //         $shu=explode(",",$v['biaoqian']);         
            //         foreach ($shu as $o => $p) {
            //             $bb=M('jieqi_article_fenlei')->find($p);
            //             $shu[$o]=$bb['title'];
            //         }
            //         $ming=implode("&nbsp;,&nbsp;",$shu);
            //         $arr[$k]['biaoti']=$ming;
            //     }else if($shu==1){
            //         $biaoqian=M('jieqi_article_fenlei')->find($v['biaoqian']);
            //         $arr[$k]['biaoti']=$biaoqian['title'];
            //     }
               
                 
            // }
          
            

           
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        

        }
          
        
    }


    //清除标签
     public function qingdel(){
       $a['articleid']=I("id");
       $a['biaoqian']=NULL;
        $sql=M('jieqi_article_article')->save($a);
        if($sql>0){
             echo '<script>alert("清除标签成功");location.href="biaoqian"</script>';
        }else{
            echo '<script>alert("清除失败");location.href="biaoqian"</script>';
        }
    }

        //清除充值样式
     public function chongdel(){
       $id=I("id");
        $sql=M('chongzhipath')->delete($id);;
        if($sql>0){
             echo '<script>alert("清除标签成功");window.parent.location.reload()</script>';
        }else{
            echo '<script>alert("清除失败");location.href="chongzhi"</script>';
        }
    }


      //分类
    public function fenlei(){
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['articlename|author'] = array('like', "%$con%");
            $arr=M('jieqi_article_article')->where($data)->select();
               foreach ($arr as $k => $v) {
                
                 $a['sortid']=$v['sortid'];
                $info=M("jieqi_article_sort")->where($a)->find();
                $arr[$k]['sortid']=$info['caption'];

                $b['sortid']=$info['layer'];
                $info1=M("jieqi_article_sort")->where($b)->find();
                $arr[$k]['lanmu']=$info1['caption'];


                $q=$v['size']/1024/1024;
                $arr[$k]['size']=round($q,2);

            }
            
            $this->assign('arr',$arr);
            $this->display(); 
        }else{

            $model =M("jieqi_article_article");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order('articleid desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            foreach ($arr as $k => $v) {
                $shu=strlen($v['biaoqian']);
                if($shu>1){
                    $shu=explode(",",$v['biaoqian']);         
                    foreach ($shu as $o => $p) {
                        $bb=M('jieqi_article_fenlei')->find($p);
                        $shu[$o]=$bb['title'];
                    }
                    $ming=implode("&nbsp;,&nbsp;",$shu);
                    $arr[$k]['biaoti']=$ming;
                }else if($shu==1){
                    $biaoqian=M('jieqi_article_fenlei')->find($v['biaoqian']);
                    $arr[$k]['biaoti']=$biaoqian['title'];
                }
        



                    $fenlei=M('jieqi_article_sort')->find($v['sortid']);
                    
                    if($fenlei>0){
                        $yi=M('jieqi_article_sort')->find($fenlei['layer']);
                        $arr[$k]['yi']=$yi['shortname'];
                        $arr[$k]['er']=$fenlei['shortname'];
               
                    }
                    
               
           
               
                 
            }
          
          
             // var_dump( $fenlei);die;
           
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        

        }
          
        
    }



     //修改分类
     public function fenedit(){
        if(IS_POST){
            
      
                $a['articleid']=I('articleid');
                $a['sortid']=I('biaoqian');
                $sql=M('jieqi_article_article')->save($a);
         


                if ($sql> 0){
                   
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                   
                    
                } else {

                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
              
               
        }else{

            

            $a['articleid']=I('id');
            $arr=M("jieqi_article_article")->where($a)->find();
            $f['types']=$arr['typeid'];
            $f['layer'] = array('neq',0);
            $fenlei=M('jieqi_article_sort')->where($f)->order('layer desc')->select();
            foreach ($fenlei as $k => $v) {
                $fenlei[$k]['er']=$v['shortname'];
                $yi=M('jieqi_article_sort')->find($v['layer']);
                $fenlei[$k]['yi']=$yi['shortname'];
            }

            // var_dump($fenlei);die;
             $this->assign('v',$arr);
             $this->assign('fenlei',$fenlei);
               // var_dump($arr);
           
           $this->display();  
        }

        

    }



//目录
 public  function exl(){
        

        if(IS_POST){
                 //上传图片
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt');// 设置附件上传类型
                $upload->rootPath  =     'Public/text/'; // 设置附件上传根目录
                $upload->savePath  =     ''; // 设置附件上传（子）目录
                 // 上传文件 
                $info   =   $upload->upload();
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError()); die;
                }else{// 上传成功
                    // $this->success('上传成功！'); 
                    $b='text/'.$info['images']['savename'];
                }


            $file_path ="Public/".$b;
            if(file_exists($file_path)){
                $fp = fopen($file_path,"r");
                $str = "";
                $buffer = 1024;//每次读取 1024 字节
                while(!feof($fp)){//循环读取，直至读取完整个文件
                    $str .= fread($fp,$buffer);
                } 
                //将编码转换utf-8
                if( !empty($str) ){    
                        $fileType = mb_detect_encoding($str, array('UTF-8','GBK','LATIN1','BIG5')) ;   
                if( $fileType != 'UTF-8'){   
                        $data = mb_convert_encoding($str ,'utf-8' , $fileType);   
                        }   
                 }   
                // $str = str_replace("\r\n","<br />",$str);
                 

                $pc=ltrim($data,"#");
                $arr=explode("#",$pc);
                
                foreach ($arr as $k => $v) {
                    
                        $xiao=explode(" ",$v);
                        // var_dump($xiao);die;
                        if($xiao>0){
                            $x['articlename']=$xiao[0];
                            $x['author']=$xiao[1];
                            $x['saleprice']=$xiao[2];
                            $x['intro']=$xiao[3];
                            $x['did']=$xiao[4];
                            $x['salenum']=0;
                            // $x['did']=session('user_id');
                            $x['lastupdate']=date('Y-m-d H:i:s');
                       
                            $xiaoshuo=M('jieqi_article_article')->add($x);
                            if($xiaoshuo>0){
                                echo '<script>window.parent.location.reload()</script>';
                            }
                        }
                    
                    
                }
                
            }

        }
   
   $this->display();
}


//章节内容
 public  function text(){
        

        if(IS_POST){
            set_time_limit(0);
                 //上传图片
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     53145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt','docx');// 设置附件上传类型
                $upload->rootPath  =     'Public/text/'; // 设置附件上传根目录
                $upload->savePath  =     ''; // 设置附件上传（子）目录
                 // 上传文件 
                $info   =   $upload->upload();
                 // var_dump($info);die;
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError()); die;
                }else{// 上传成功
                    // $this->success('上传成功！'); 
                    $b='text/'.$info['images']['savename'];
                }


            $file_path ="Public/".$b;
            if(file_exists($file_path)){
                $fp = fopen($file_path,"r");
                $str = "";
                $buffer = 1024;//每次读取 1024 字节
                while(!feof($fp)){//循环读取，直至读取完整个文件
                    $str .= fread($fp,$buffer);
                } 


                //将编码转换utf-8
                if(!empty($str) ){    
                        $fileType = mb_detect_encoding($str, array('UTF-8','GBK','LATIN1','BIG5')) ;   
                if( $fileType != 'UTF-8'){   
                        $data = mb_convert_encoding($str ,'utf-8' , $fileType);   
                        }   
                 }   

                
                // $oop=iconv("gb2312", "utf-8", $str);    
                // var_dump($data);die;
                // $str = str_replace("\r\n","<br />",$str);
                $pc=ltrim($data,"#");
                $arr=explode("#",$pc);
                  // var_dump($arr);die;
                foreach ($arr as $k => $v) {
                    $xiao=explode("\r\n",$v);
                   
                    if($xiao>0){
                        $us['articleid']=I('id');
                        $xx=M('jieqi_article_article')->where($us)->find();
                        //删除旧文件
                        if($xx['text']!==null){
                            $un="Public/".$xx['text'];
                            // var_dump($un);die;
                             unlink($un);
                        }

                        $gg['articleid']=I('id');
                        $gg['text']=$b;
                        M('jieqi_article_article')->save($gg);
                        //查询章节是否已存在
                        $chaz['articleid']=I('id');
                        $chaz['chaptername']=$xiao[0];
                        $chazhangjie=M('jieqi_article_chapter')->where($chaz)->find();
                        if($chazhangjie==null){
                            $x['articleid']=I('id');
                            $x['saleprice']=I('jiage');
                            $x['articlename']=$xx['articlename'];
                            $x['chaptername']=$xiao[0];
                            $x['attachment']=$v;
                            $s=strlen($v)*0.001;
                            $x['size']=round($s,2);
                            $x['salenum']=0;
                            $x['did']=session('user_id');
                            $x['lastupdate']=date('Y-m-d H:i:s');
                            $xiaoshuo=M('jieqi_article_chapter')->add($x);
                            
                        }
           
                       
                       
                        
                       
                    }
                }

                        if($xiaoshuo>0){

                            //更新书本的信息
                            $yy['articleid']=I('id');
                            $xxx=M('jieqi_article_chapter')->where($yy)->order('chapterid desc')->select();

                             foreach ($xxx as $kk => $o){
                                $dax[]=$o['size'];
                                $han=fopen("Public/text/".$kk.time().".text","w");
                                fwrite($han,$o['attachment']);
                                fclose($han);
                                $diz['texts']="Public/text/".$kk.time().".text";
                                $zzz['chapterid']=$o['chapterid'];
                                
                                $jiesu=M('jieqi_article_chapter')->where($zzz)->order('chapterid desc')->save($diz);
                                 // var_dump($jiesu);die;
                            }
                            

                            // var_dump($diz);die;
                            $sumx=array_sum($dax);
                            $geng['lastchapter']=$xxx[0]['chaptername'];
                            $geng['articleid']=I('id');
                            $geng['size']=$sumx;    
                            $geng['lastupdate']=date('Y-m-d H:i:s');
                             $us['articleid']=I('id');
                            M('jieqi_article_article')->where($us)->save($geng);

                            // var_dump($xxx);die;
                             foreach ($xxx as $ke => $va){
                               
                           
                               $tx['chapterid']=$ke;
                               $tx['texts']=$d;
                                $txx['chapterid']=$ke;
                               M('jieqi_article_chapter')->where($txx)->save($tx); 
                            } 
                              
                             echo '<script>alert("添加成功");window.parent.location.reload()</script>';die;

                             
                            //生成text
                             // var_dump($xxx);die;
                           
                        }else{
                             echo '<script>alert("所提交的章节内容没变化,更新失败");window.parent.location.reload()</script>';
                        }
            }
        }
    
   $this->display();
}


//文案
    public function wenan(){
        
            $a['articleid']=I('id');
            $model =M("jieqi_article_chapter");
           
            $arr = $model->where($a)->order('chapterid asc')->select();
            
            foreach ($arr as $k => $v) {
                if($v['chapterid']==I('zid')){
                    $ti=$k+1;
                }
            }

            $info = $model->where($a)->order('chapterid asc')->limit(0,$ti)->select();

            foreach ($info as $ke => $va) {
                 $aa=explode("\n",$va['attachment']);
                $aa[0]="<font size='4' color='black'>&nbsp;&nbsp;&nbsp;".$aa[0]."</font><br>";
                $bb=implode("\n",$aa);  
                $a=str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$bb);

                $info[$ke]['attachment']=$a;
            }
           
            

            

            // var_dump($info);die;
           
           
            $this->assign('arr',$arr);
            $this->assign('info',$info);          //用户
         
            $this->display();   
            
    }


     public function pinglun(){
         if(IS_POST){
            //查询
            $con=$_POST['id'];
            // $data['content'] = ;
            $arr=M('new_reply')->join('__JIEQI_ARTICLE_ARTICLE__ ON __NEW_REPLY__.aid = __JIEQI_ARTICLE_ARTICLE__.articleid')->where(['did'=>session('user_id'),'content'=>array('like', "%$con%")])->select();
             //分配数据
            foreach ($arr as $k => $v) {
                $shu=M('jieqi_article_article')->find($v['aid']);
                $arr[$k]['shuname']=$shu['articlename'];
                $user=M('jieqi_system_users')->find($v['user_id']);
                $arr[$k]['uname']=$user['uname'];
            }

             $this->assign('arr',$arr);          //用户
            
            $this->display();   
              
        }else{
            $model =M("new_reply");
            //查出总条数 
            $count = $model->join('__JIEQI_ARTICLE_ARTICLE__ ON __NEW_REPLY__.aid = __JIEQI_ARTICLE_ARTICLE__.articleid')->where(['did'=>session('user_id')])->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->join('__JIEQI_ARTICLE_ARTICLE__ ON __NEW_REPLY__.aid = __JIEQI_ARTICLE_ARTICLE__.articleid')->where(['did'=>session('user_id')])->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            

            // var_dump($arr);die;
            //分配数据
            foreach ($arr as $k => $v) {
                $shu=M('jieqi_article_article')->find($v['aid']);
                $arr[$k]['shuname']=$shu['articlename'];
                $user=M('jieqi_system_users')->find($v['user_id']);
                $arr[$k]['uname']=$user['uname'];
            }

           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
          }
    }

     public function pinglundel(){
        // var_dump(I());die;
        $id=$_GET['id'];
        $arr=M('new_reply')->delete($id);
        if($arr>0){
           
                echo '<script>alert("删除成功");location.href="pinglun"</script>';
            

          
        }
    }

    //批量删除
    public function pidel()
    {
       echo plscphp('new_reply',I('id'),'pinglun');
    }



    public function lanmu()
    {
        $model =M("jieqi_article_fenlei");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,12); //传入一个总条数，和每页显示的条数
            //引入数据
            if(empty(I('id'))){
                $arr = $model->order('id desc')->limit($page->firstRow.','.$page->listRows)->select(); 
            }else{
                $a['pindao']=I('id');
                $arr=$model->where($a)->order('paixu asc')->limit($page->firstRow.','.$page->listRows)->select();
            }
           
            //分页
            
            $btn = $page->show();

            // var_dump($info);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
            
    }

    //栏目删除
    public function lanmudel(){
        // var_dump(I());die;
        $id=$_GET['id'];
        $arr=M('jieqi_article_fenlei')->delete($id);
        if($arr>0){
           
                echo '<script>alert("删除成功");location.href="lanmu"</script>';
        
        }
    }


    //栏目添加
    public function lanmuadd(){
        // var_dump(I());die;
        if(IS_POST){
            $pin['pindao']=I('pindao');
            $zhao=M('jieqi_article_fenlei')->where($pin)->count();
            if($zhao==0){
                $add['pindao']=I('pindao');
                $add['title']=I('title');
                $add['paixu']=1;
            }else{
                $add['pindao']=I('pindao');
                $add['title']=I('title');
                $add['paixu']=$zhao+1;
            }
            $arr=M('jieqi_article_fenlei')->add($add);
            if($arr>0){
           
                echo '<script>alert("添加成功");window.parent.location.reload()</script>';
        
            }
        }
       
           $this->display();     
    }

    public function upchapter()
{
        
    $Model = M('');
    $xiaoid=I('id');

    if(IS_POST){
        // $res = M('jieqi_article_chapter')->where('chapterid',155318)->find();
        // var_dump($res);die;
        set_time_limit(0);

        //上传图片
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     553145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt','docx');// 设置附件上传类型
        $upload->rootPath  =     'Public/text/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();

        if(!$info) { // 上传错误提示错误信息
            $this->error($upload->getError()); die;
        } else { // 上传成功
            $b='text/'.$info['images']['savename'];
        }

        $file_path ="Public/".$b;
        if(file_exists($file_path)){
            $fp = fopen($file_path,"r");
            $str = "";
            $buffer = 1024;//每次读取 1024 字节
            while(!feof($fp)){//循环读取，直至读取完整个文件
                $str .= fread($fp,$buffer);
            } 

            //将编码转换utf-8
            if(!empty($str) ){    
                $fileType = mb_detect_encoding($str, array('UTF-8','GBK','LATIN1','BIG5')) ;   
                if($fileType != 'UTF-8'){   
                    $data = mb_convert_encoding($str ,'utf-8' , $fileType);   
                }   
            }   

            $pc=ltrim($data,"#");
            $arr=explode("#",$pc);
            foreach ($arr as $k => $v) {

                // var_dump($arr);die;
                $xiao=explode("\r\n",$v);
               

                if($xiao>0){
                    $us['articleid']=I('id');
                    $xx=M('jieqi_article_article')->where($us)->find();

                    //查询章节是否已存在
                    $chaz['articleid']=I('id');
                    $chaz['chaptername']=$xiao[0];
                    $chazhangjie=M('jieqi_article_chapter')->where($chaz)->find();

                    // if($chazhangjie==null){
                        $x['articleid']=I('id');
                        $x['saleprice']=I('jiage');
                        $x['articlename']=$xx['articlename'];
                        $x['chaptername']=$xiao[0];
                        $x['attachment']=$v;
                        $s=strlen($v)*0.001;
                        $x['size']=round($s,2);
                        $x['salenum']=0;
                        $x['did']=I('did');
                        $x['lastupdate']=date('Y-m-d H:i:s');
                        $x['texts']='Public/'.$b;

                        $xiaoshuo=M('jieqi_article_chapter')->add($x);   
                    // }
                }
            }

            if($xiaoshuo > 0){
                //更新书本的信息
                $yy['articleid']=I('id');
                $xxx=M('jieqi_article_chapter')->where($yy)->order('chapterid desc')->select();

                $geng['lastchapter']=$xxx[0]['chaptername'];
  
                $geng['lastupdate']=date('Y-m-d H:i:s');
                $us['articleid']=I('id');
                M('jieqi_article_article')->where($us)->save($geng);
                  
                echo '<script>alert("添加成功");window.parent.location.reload()</script>';die;
            }else{
                 echo '<script>alert("所提交的章节内容没变化,更新失败");window.parent.location.reload()</script>';
            }
        }
    }
    
    $this->display();
}


    //栏目修改
    public function lanmuedit()
    {
        if(IS_POST){
                 // var_dump(I());die;
               
             
                $sql=M('jieqi_article_fenlei')->save($_POST);
                 if ($sql> 0){
                   
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';  
                    
                } else {

                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
              
        }else{

            $a['id']=I('id');
            $arr=M("jieqi_article_fenlei")->where($a)->find();

             $this->assign('v',$arr);
               // var_dump($arr);
           
           $this->display();  
        }
    }


     public function xiaoshuopinglun(){
         if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['content'] = array('like', "%$con%");
            $data['aid']=$_POST['aid'];
            $arr=M('new_reply')->where($data)->select();
             //分配数据
            foreach ($arr as $k => $v) {
                $shu=M('jieqi_article_article')->find($v['aid']);
                $arr[$k]['shuname']=$shu['articlename'];
                
                if($v['user_id']==null){
                     $arr[$k]['uname']=$v['jia'];
                   
                }else{
                    $user=M('jieqi_system_users')->find($v['user_id']);
                    $arr[$k]['uname']=$user['uname'];
                }
               
            }

             $this->assign('arr',$arr);          //用户
            
            $this->display();   
              
        }else{
            $shuo['aid']=I('id');
            $model =M("new_reply");
            //查出总条数 
            $count = $model->where($shuo)->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($shuo)->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            

            // var_dump($arr);die;
            //分配数据
            foreach ($arr as $k => $v) {
                $shu=M('jieqi_article_article')->find($v['aid']);
                $arr[$k]['shuname']=$shu['articlename'];
               if($v['user_id']==null){
                     $arr[$k]['uname']=$v['jia'];
                   
                }else{
                    $user=M('jieqi_system_users')->find($v['user_id']);
                    $arr[$k]['uname']=$user['uname'];
                }
            }

           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
          }
    }




     public function xiaoshuopinglundel(){
        // var_dump(I());die;
        $id=$_GET['id'];
        $arr=M('new_reply')->delete($id);
        if($arr>0){
           
                echo '<script>alert("删除成功");location.href="xiaoshuopinglun?id='.$_GET['get'].'"</script>';
            

          
        }
    }

    function exex($maxsize=5242880,$exts=array('gif','jpg','jpeg','bmp','png','xls','xlsx'),$maxwidth=430){
 
  if(IS_POST){
    // var_dump(I());die;
     Vendor('PHPExcel.Classes.PHPExcel.IOFactory');
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     $maxsize;// 设置附件上传大小，单位字节(微信图片限制1M
    $upload->exts      =     $exts;// 设置附件上传类型
    $upload->rootPath  =     'Public/images/'; // 设置附件上传根目录
    $upload->savePath  =     $dir.'/'; // 设置附件上传（子）目录
    // 上传文件
    $info   =   $upload->upload();
    // var_dump($info ["images"] ["savename"]);die;
    $objPHPExcel = \PHPExcel_IOFactory::load("Public/images/".$info ["images"] ["savename"]."");
    $objPHPExcel->setActiveSheetIndex(0);
    $sheet0=$objPHPExcel->getSheet(0);

    $rowCount=$sheet0->getHighestRow();//excel行数
    $data=array();

    // $PHPExcel = $reader->load($uploadfile); // 文档名称
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $objWorksheet->getHighestRow(); // 取得总行数
    $highestColumn = $objWorksheet->getHighestColumn(); // 取得总列数
    $arr = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z');
    //echo $highestRow.$highestColumn;
    // 一次读取一列
    $res = array();
    for ($row = 3; $row <= $highestRow; $row++) {
        for ($column = 0; $arr[$column] != 'T'; $column++) {
            $val = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
            $res[$row-2][$column] = $val;
        }
    }
        // var_dump($res);die;
        foreach ($res as $k => $v) {
            if($v[0]!==null){
                $add['aid']=I('id');
                $add['content']=$v[0];
                $add['likes']=$v[1];
                $x=rand(3,5);
                $add['xing']=$x;
                $n=chr(rand(65,90)).chr(rand(97, 122)).chr(rand(97, 122)).chr(rand(65,90)).chr(rand(97, 122)).chr(rand(97, 122)).rand(123, 999);
                $add['jia']=$n;
                 $a=M('new_reply')->add($add);
            }
            
         
         
        }
          
      
      if($a>0){
        echo '<script>alert("数据导入成功");location.href="xiaoshuopinglun?id='.I('id').'"</script>';die;
      }else{
        echo '<script>alert("数据导入失败");location.href="xiaoshuopinglunid='.I('id').'"</script>';die;
      }
   
  
      
     


     
  }
   $this->display();
}


    


}
