<?php
namespace Daili\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class XiaoshuoController extends Controller {

  //小说
    public function xiaoshuo(){
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


                $q=$v['size'];
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
               
                $a['sortid']=$v['sortid'];
                $info=M("jieqi_article_sort")->where($a)->find();
                $arr[$k]['sortid']=$info['caption'];

                $b['sortid']=$info['layer'];
                $info1=M("jieqi_article_sort")->where($b)->find();
                $arr[$k]['lanmu']=$info1['caption'];


                $q=$v['size'];
                $arr[$k]['size']=round($q,2);
                // $f=$v['intro'];
                // preg_match_all('/./u', $f, $aq);
                // $arr[$k]['intro']=$aq[0][1].$aq[0][2].$aq[0][3].$aq[0][4].$aq[0][5].$aq[0][6].'...';
                // var_dump($f);
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
        
            //查询数据并分页
            $model =M("jieqi_article_article");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

           

           
            

           
            //分配数据
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
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            foreach ($arr as $k => $v) {
                $user=M('jieqi_system_users')->find($v['user_id']);
                $arr[$k]['user_id']=$user['name'];
                $user=M('jieqi_article_article')->find($v['aid']);
                $arr[$k]['aid']=$user['articlename'];
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

   
    
    public function add(){
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
                $add['articlename']=I('articlename');
                $add['author']=I('author');
                $add['typeid']=I('typeid');
                $add['articletype']=I('articletype');
                $add['isshou']=I('isshou');
                $add['newbook']=I('newbook');
                $add['fengyun']=I('fengyun');
                $add['lianzai']=I('lianzai');
                $add['wanjie']=I('wanjie');
                $add['intro']=I('intro');
                $add['allvisit']=I('allvisit');
                $add['salenum']=I('salenum');
                $add['images']=$b;
                $add['saleprice']=I('saleprice');
                $add['lastupdate']=date("Y-m-d H:i:s");

            $sql=M('jieqi_article_article')->add($add);


            if ($sql> 0){
                echo '<script>alert("添加成功");location.href="xiaoshuo"</script>';
            } else {
                echo '<script>alert("添加失败");history.go(-1)</script>';
            }
              
               
        }else{
            
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
                echo '<script>alert("添加成功");location.href="xiaoshuo"</script>';
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
                            echo '<script>alert("添加成功");location.href="nanpin"</script>';
                    }else if($_POST['types']==2){
                            echo '<script>alert("添加成功");location.href="nvpin"</script>';
                    }else{
                            echo '<script>alert("添加成功");location.href="chuban"</script>';
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
        if(IS_POST){
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
                    if(!$info) {// 上传错误提示错误信息
                        $this->error($upload->getError()); die;
                    }else{// 上传成功
                    // $this->success('上传成功！'); 
                        $b='uploads/'.$info['images']['savename'];
                   
                    }
                
                
                 $add['articleid']=I('articleid');
                $add['articlename']=I('articlename');
                $add['author']=I('author');
                $add['typeid']=I('typeid');
                $add['articletype']=I('articletype');
                $add['isshou']=I('isshou');
                $add['newbook']=I('newbook');
                $add['fengyun']=I('fengyun');
                $add['lianzai']=I('lianzai');
                $add['wanjie']=I('wanjie');
                $add['intro']=I('intro');
                $add['allvisit']=I('allvisit');
                $add['salenum']=I('salenum');
                $add['images']=$b;
                $add['saleprice']=I('saleprice');
                $add['lastupdate']=date("Y-m-d H:i:s");

              // var_dump($add);die;

                $sql=M('jieqi_article_article')->save($add);
                 if ($sql> 0){
                   
                            echo '<script>alert("修改成功");location.href="xiaoshuo"</script>';
                   
                    
                } else {

                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
              
               
        }else{

            

            $a['articleid']=I('id');
            $arr=M("jieqi_article_article")->where($a)->find();
           
             
            
             $this->assign('v',$arr);
               // var_dump($arr);
           
           $this->display();  
        }

        

    }

    public function zjedit(){
        if(IS_POST){
                  // var_dump(I());die;
                 if(empty($_POST['chaptername']) | empty($_POST['saleprice']) | empty($_POST['attachment'])  ){
                    echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
                 }
             

               
                 $b['chapterid']=$_POST['chapterid'];
                 $a['chaptername']=$_POST['chaptername'];
                 $a['saleprice']=$_POST['saleprice'];
                 $a['attachment']=$_POST['attachment'];
                 $a['lastupdate']=time();
                 // var_dump($a);die;
                $sql=M('jieqi_article_chapter')->where($b)->save($a);
                 if ($sql> 0){
                   
                            echo '<script>alert("修改成功");location.href="xszhangjie"</script>';
                   
                    
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
                   
                            echo '<script>alert("修改成功");location.href="tuisong"</script>';
                   
                    
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
            $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
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
                   
                            echo '<script>alert("修改成功");location.href="biaoqian"</script>';
                   
                    
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
            $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
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
                        $arr[$k]['yi']=$yi['caption'];
                        $arr[$k]['er']=$fenlei['caption'];
               
                    }
                    
               
           
               
                 
            }
          
          

           
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
                   
                            echo '<script>alert("修改成功");location.href="fenlei"</script>';
                   
                    
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
                $fenlei[$k]['er']=$v['caption'];
                $yi=M('jieqi_article_sort')->find($v['layer']);
                $fenlei[$k]['yi']=$yi['caption'];
            }
             $this->assign('v',$arr);
             $this->assign('fenlei',$fenlei);
               // var_dump($arr);
           
           $this->display();  
        }

        

    }




function exl(){
        

        if(IS_POST){
                 //上传图片
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt');// 设置附件上传类型
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


            $file_path ="Public/".$b;
            if(file_exists($file_path)){
                $fp = fopen($file_path,"r");
                $str = "";
                $buffer = 1024;//每次读取 1024 字节
                while(!feof($fp)){//循环读取，直至读取完整个文件
                    $str .= fread($fp,$buffer);
                } 
                $str=iconv("gb2312", "utf-8", $str);
                // $str = str_replace("\r\n","<br />",$str);
                $arr=explode("@",$str);
                foreach ($arr as $k => $v) {
                    $xiao=explode(" ",$v);
                    
                    if($xiao>0){
                        $x['articlename']=$xiao[0];
                        $x['author']=$xiao[1];
                        $x['saleprice']=$xiao[2];
                        $x['intro']=$xiao[3];
                        $x['salenum']=rand(8,88);
                        $x['lastupdate']=date('Y-m-d H:i:s');
                        $xiaoshuo=M('jieqi_article_article')->add($x);
                        if($xiaoshuo>0){
                             echo '<script>alert("添加成功");location.href="xiaoshuo"</script>';
                        }
                    }
                }
                
            }
        }
    
   $this->display();
}

function text(){
        

        if(IS_POST){
                 //上传图片
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     23145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt');// 设置附件上传类型
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
                // $oop=iconv("gb2312", "utf-8", $str);    
                // var_dump($data);die;
                // $str = str_replace("\r\n","<br />",$str);
                $pc=ltrim($data,"#");
                $arr=explode("#",$pc);
                 // var_dump($arr);die;
                foreach ($arr as $k => $v) {
                    $xiao=explode("\r\n",$v);
                   
                    if($xiao>0){
                        $xx=M('jieqi_article_article')->find(I('id'));
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
                            $x['salenum']=rand(8,88);

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
                            }
                            $sumx=array_sum($dax);
                            $geng['lastchapter']=$xxx[0]['chaptername'];
                            $geng['articleid']=I('id');
                            $geng['size']=$sumx;    
                            $geng['lastupdate']=date('Y-m-d H:i:s');
                            M('jieqi_article_article')->save($geng);
                              
                             echo '<script>alert("添加成功");location.href="xiaoshuo"</script>';die;
                        }else{
                             echo '<script>alert("所提交的章节内容没变化,更新失败");location.href="xiaoshuo"</script>';
                        }
            }
        }
    
   $this->display();
}


    


}
