<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class PindaoController extends CommonController {
    /**
     * 女频 修改列表
     */
    public function nvpin(){

             $a['layer']=0;
             $a['types']=1;
             $b['types']=1;
            //查询数据并分页
            $model =M("jieqi_article_sort");
            //查出总条数 
            $count = $model->where($a)->count();
            //引入分页类 
            $page = new \Think\Page($count,6); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($a)->order('sortnum desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            $btn = $page->show();
            $info=M("jieqi_article_sort")->where($b)->select();
            // var_dump($info);die;
            //分配数据
            $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
    }
    //男频
    public function nanpin(){
        
             $a['layer']=0;
             $a['types']=2;
              $b['types']=2;
            //查询数据并分页
            $model =M("jieqi_article_sort");
            //查出总条数 
            $count = $model->where($a)->count();
            //引入分页类 
            $page = new \Think\Page($count,6); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($a)->order('sortnum desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            $info=M("jieqi_article_sort")->where($b)->select();

            

           
            //分配数据
            $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
    }

    //出版
    public function chuban(){
        
              $a['layer']=0;
              $a['types']=3;
              $b['types']=3;
            //查询数据并分页
            $model =M("jieqi_article_sort");
            //查出总条数 
            $count = $model->where($a)->count();
            //引入分页类 
            $page = new \Think\Page($count,6); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($a)->order('sortnum desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            $info=M("jieqi_article_sort")->where($b)->select();

            

           
            //分配数据
            $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
        
    }

      //免费
    public function mianfei(){
        
              $a['layer']=0;
              $a['types']=4;
              $b['types']=4;
            //查询数据并分页
            $model =M("jieqi_article_sort");
            //查出总条数 
            $count = $model->where($a)->count();
            //引入分页类 
            $page = new \Think\Page($count,6); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($a)->order('sortid asc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            $info=M("jieqi_article_sort")->where($b)->select();

            

           
            //分配数据
            $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
        
    }

     //出版商
    public function erji(){
        
             // var_dump(I());die;
             $a['layer']=$_GET['id'];
             $a['types']=$_GET['type'];
            //查询数据并分页
            $model =M("jieqi_article_sort");
            //查出总条数 
            $count = $model->where($a)->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($a)->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            // $info=M("jieqi_article_sort")->where($b)->select();

            

           // var_dump($arr);die;
            //分配数据
            // $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
        
    }


   
    


   

    //  public function del(){
    //     $id=$_GET['id'];
    //     $arr=M('new_ad')->delete($id);
    //     if($arr>0){
    //        echo '<script>alert("删除成功");location.href="index"</script>';
    //     }
    // }


    public function del(){
        $id=$_GET['id'];
        $arr=M('jieqi_article_sort')->delete($id);
        if($arr>0){
            if($_GET['type']==1){
                echo '<script>alert("删除成功");location.href="nvpin"</script>';
            }else if($_GET['type']==2){
                echo '<script>alert("删除成功");location.href="nanpin"</script>';
            }else if($_GET['type']==3){
                echo '<script>alert("删除成功");location.href="chuban"</script>';
            }else if($_GET['type']==4){
                echo '<script>alert("删除成功");location.href="mianfei"</script>';
            }

          
        }
    }

   
    //增加一级栏目
    public function add(){
        if(IS_POST){
            // var_dump(I());
            if(empty($_POST['caption'])){
                    echo '<script>alert("添加失败：请填写一级栏目名称");history.go(-1)</script>';die;
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
             

               

                 $a['layer']=0;
                 $a['types']=I('type');
                  $a['imgurl']=$b;
                 $a['shortname']=$_POST['caption'];
                  $a['description']=$_POST['description'];
                  $a['sortnum'] = $_POST['sortnum'];

               
                // $a['images']=$b;
                // var_dump($a);die;
                $sql=M('jieqi_article_sort')->add($a);
                 if ($sql> 0){
                    if(I('type')==1){
                        echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                    }else if(I('type')==2){
                        echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                    }else if(I('type')==3){
                        echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                    }else if(I('type')==4){
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

    //增加二级栏目
     public function sjadd(){
        if(IS_POST){
             // var_dump(I());die;
            if(empty($_POST['caption'])){
                    echo '<script>alert("添加失败：请填写完整的资料");history.go(-1)</script>';die;
                 }

             

               echo $_POST['layer']; 

                 $a['layer']=$_POST['layer'];
                 $a['shortname']=$_POST['caption'];
                 $a['types']=$_POST['types'];
                 $a['sortnum']=$_POST['sortnum'];

               
                // $a['images']=$b;
                // var_dump($a);die;
                $sql=M('jieqi_article_sort')->add($a);
                 if ($sql> 0){
                    if($_POST['types']==1){
                            echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                    }else if($_POST['types']==2){
                            echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                    }else if($_POST['types']==3){
                            echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                    }else if($_POST['types']==4){
                            echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                    }
                    
                } else {

                    echo '<script>alert("添加失败");history.go(-1)</script>';
                }
              
               
        }else{
            $a['layer']=0;
             $a['types']=I('id');
            $arr=M("jieqi_article_sort")->where($a)->select();
            $this->assign('arr',$arr);
           $this->display();  
        }

        

    }

    public function edit(){
        if(IS_POST){
             // var_dump(I());die;
            // if(empty($_POST['caption'])){
            //         echo '<script>alert("修改失败：请填写完整的资料");history.go(-1)</script>';die;
            //      }

                if (!is_dir('./Public/Uploads/'.date('Ymd'))) mkdir('./Public/Uploads/'.date('Ymd'), 0777);
                  //上传图片
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath  =     './Public/Uploads/'.date('Ymd').'/'; // 设置附件上传根目录
                $upload->savePath  =     ''; // 设置附件上传（子）目录
                 // 上传文件 
                
                
                    // var_dump(I());die;
                     $info   =   $upload->upload();
                     // var_dump($info);die;
                 // var_dump($info);die;
                    // if($info!==false){
                       // var_dump($info);die;
                    if(!$info) {// 上传错误提示错误信息
                        $this->error($upload->getError()); die;
                    }else{// 上传成功
                        $b='Uploads/'.date('Ymd').'/'.$info['images']['savename'];
                        $a['imgurl']=$b;
                    }

                // }
               
             

               

                 $a['sortid']=$_POST['sortid'];
                 $a['shortname']=$_POST['caption'];
                 $a['description']=$_POST['description'];
                 $a['sortnum']=$_POST['sortnum'];

              
               
                // $a['images']=$b;
                 // var_dump($a);die;
                $sql=M('jieqi_article_sort')->save($a);
                 if ($sql> 0){
                   if($_POST['type']==1){
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                    }else if($_POST['type']==2){
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                    }else if($_POST['type']==3){
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                    }else{
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                    }
                } else {

                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
              
               
        }else{

            $a['sortid']=$_GET['id'];
            $arr=M("jieqi_article_sort")->where($a)->find();
            // var_dump($arr);die;
            $this->assign('v',$arr);
           $this->display();  
        }

        

    }


    public function ejedit(){
        if(IS_POST){
              // var_dump(I());die;
            if(empty($_POST['caption'])){
                    echo '<script>alert("修改失败：请填写二级栏目");history.go(-1)</script>';die;
                 }
                 $a['sortid'] = $_POST['sortid'];
                 $a['shortname'] = $_POST['caption'];
                 $a['sortnum'] = $_POST['sortnum'];
                 $sql=M('jieqi_article_sort')->save($a);
                 if ($sql> 0){
                    if($_POST['type']==1){
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                    }else if($_POST['type']==2){
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                    }else if($_POST['type']==3){
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                    }else{
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                    }
                    
                } else {

                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
              
               
        }else{
            
            $a['sortid']=$_GET['id'];
            $arr=M("jieqi_article_sort")->where($a)->find();
            // var_dump($arr);die;
            $this->assign('v',$arr);
           $this->display();  
        }

        

    }




    
    


}
