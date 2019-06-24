<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class ShudanController extends CommonController {

  //系统表
    public function index(){
        
        
            //查询数据并分页
            $model =M("new_shudan");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,7); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            foreach ($arr as $k => $v) {
                if($v['gotos']==0){
                    $arr[$k]['gotos']='书籍';
                }else if($v['gotos']==1){
                    $arr[$k]['gotos']='广告';
                }else{
                    $arr[$k]['gotos']='网站';
                }
            }

           
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
        
    }


    public function hengtu(){
        
        
            $a['path']=1;
            //查询数据并分页
            $model =M("new_shudan");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($a)->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            foreach ($arr as $k => $v) {
                if($v['gotos']==0){
                    $arr[$k]['gotos']='书籍';
                }else if($v['gotos']==1){
                    $arr[$k]['gotos']='广告';
                }else{
                    $arr[$k]['gotos']='网站';
                }
            }

           
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
        
        
    }

    

    //修改轮播图
    public function edit(){
         // $this->display(); 
        if(IS_POST){
               // var_dump($_POST);die;
            
            
              

               if(empty($_POST['title'])  |empty($_POST['content']) | empty($_POST['weburl'])
                ){
                    echo '<script>alert("修改失败：请填写完整的资料");history.go(-1)</script>';die;
                 }

                //  //上传图片
                // $upload = new \Think\Upload();// 实例化上传类
                // $upload->maxSize   =     3145728 ;// 设置附件上传大小
                // $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                // $upload->rootPath  =     'Public/uploads/'; // 设置附件上传根目录
                // $upload->savePath  =     ''; // 设置附件上传（子）目录
                //  // 上传文件 
                // // var_dump($upload);die;
                // $info   =   $upload->upload();
                // if(!$info) {// 上传错误提示错误信息
                //     $this->error($upload->getError()); die;
                // }else{// 上传成功
                //     // $this->success('上传成功！'); 
                //     $b='uploads/'.$info['images']['savename'];
                // }



                $a['id']=$_POST['id'];
                 $a['title']=$_POST['title'];
                $a['content']=$_POST['content'];
                $a['weburl']=$_POST['weburl'];
                $a['gotos']=$_POST['gotos'];
                $a['path']=$_POST['path'];
               
                // $a['images']=$b;
                // var_dump($a);die;
                $sql=M('new_shudan')->save($a);
                 if ($sql> 0){
                    echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                } else {
                    echo '<script>alert("修改失败,无更改");history.go(-1)</script>';
                }
              
               
            
            }else{
                // var_dump(I());
                 
                 $sql=M('new_shudan')->find(I('id'));
                
                $this->assign('v', $sql);
                 // var_dump($sql);  
                 $this->display();

            }

        

          
        

    }

    //修改横图
    public function htedit(){
         // $this->display(); 
        if(IS_POST){
               // var_dump($_POST);die;
            
            
              

               if(empty($_POST['title'])  |empty($_POST['content']) | empty($_POST['weburl'])
                ){
                    echo '<script>alert("修改失败：请填写完整的资料");history.go(-1)</script>';die;
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



                $a['id']=$_POST['id'];
                 $a['title']=$_POST['title'];
                $a['content']=$_POST['content'];
                $a['weburl']=$_POST['weburl'];
                $a['gotos']=$_POST['gotos'];
               
                $a['images']=$b;
                // var_dump($a);die;
                $sql=M('new_shudan')->save($a);
                 if ($sql> 0){
                    echo '<script>alert("修改成功");location.href="hengtu"</script>';
                } else {
                    echo '<script>alert("修改失败,无更改");history.go(-1)</script>';
                }
              
               
            
            }else{
                // var_dump(I());
                 
                 $sql=M('new_shudan')->find(I('id'));
                
                $this->assign('v', $sql);
                 // var_dump($sql);  
                 $this->display();

            }

        

          
        

    }

     public function del(){
        $id=$_GET['id'];
        $arr=M('new_shudan')->delete($id);
        if($arr>0){
           echo '<script>alert("删除成功");location.href="index"</script>';
        }
    }


    public function htdel(){
        $id=$_GET['id'];
        $arr=M('new_shudan')->delete($id);
        if($arr>0){
           echo '<script>alert("删除成功");location.href="hengtu"</script>';
        }
    }

   
    
    public function add(){
        if(IS_POST){
            // var_dump(I());
            // if(empty($_POST['title'])  | empty($_POST['weburl'])
            //     ){
            //         echo '<script>alert("添加失败：请填写完整的资料");history.go(-1)</script>';die;
            //      }

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
                    $b='uploads/'.$info['images1']['savename'];
                    $c='uploads/'.$info['images2']['savename'];
                    $d='uploads/'.$info['images3']['savename'];
                }



               

                 $a['title']=$_POST['title'];
                 $a['path']=$_POST['path'];
                  $a['bookid']=$_POST['acid'];
                $a['content']=$_POST['content'];
                $a['weburl']=$_POST['weburl'];
                $a['gotos']=$_POST['gotos'];
                 $a['path']=$_POST['path'];
                  $a['images']=$b;
                  $a['imagest']=$c;
                  $a['imagess']=$d;
                $sql=M('new_shudan')->add($a);
                 if ($sql> 0){
                    echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                } else {
                    echo '<script>alert("添加失败");history.go(-1)</script>';
                }
              
               
        }else{
           $this->display();  
        }

        

    }

     public function dizhi(){
        
       
            //查询
            if(!empty(I('id'))){

                $con=I('id');
                $data['articlename|author'] = array('like', "%$con%");
                $shu=M('jieqi_article_article')->where($data)->find();
                if($shu==null){
                    $this->ajaxReturn(null); 

                 } else{

                    $this->ajaxReturn($shu); 
                     
                }



            }else{
                $this->ajaxReturn(null); 
            }
            
           
           
       
    }


    
    


}
