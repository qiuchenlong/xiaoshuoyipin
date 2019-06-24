<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class ZhishiController extends CommonController {
    public function index(){
        //遍历管理员名单
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['title'] = array('like', "%$con%");
            $arr=M('zhishi')->where($data)->select();
            
            
           
            $this->assign('arr',$arr);
            $this->display(); 
        }else{

           //推荐下架
        
            if(I('tuijian')==1){
              M('zhishi')->save(I());
            }else if(I('tuijian')==0){
              M('zhishi')->save(I());
            }
            //查询数据并分页
            $model =M("zhishi");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            $btn = $page->show();
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        }
        
    }

   //添加商品 
    public function add(){  
       if(IS_POST){
            if(empty($_POST['title']) | empty($_POST['content']) ){
             echo '<script>alert("添加失败：请添写完整信息");location.href=""</script>';die;
             }
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
                $a=$info['images']['savename'];
            }
            
            $arr['title']=$_POST['title'];
            $arr['content']=$_POST['content'];
            $arr['images']=$a;
            $arr['time']=date('Y-m-d H:i:s');
            $sql = M('zhishi')->add($arr); 
            // $data = $Model->execute("INSERT INTO classify (`name`,`sort`,`images`) VALUES ('".$name."','".$sort."','".$sumbimage."');");   
            //  echo $Model->_sql();die;
            if ($sql> 0){
                 echo '<script>alert("添加成功");location.href="index"</script>';
            }  

             
        }else{
            $this->display();
        }
        
    }

             
        

    
    public function del(){
        // //实验ajax
      $a=$_GET['id'];
     
        $sql=M('zhishi')->delete($a);

       if ($sql> 0){
                 echo '<script>alert("删除成功");location.href="index"</script>';
         }

            
            
        // //推荐使用
        // $this->ajaxReturn(2);
    }

     public function jin(){
        $info['id']=$_POST['id'];
             if($_POST['jin']=='已启用'){
               $info['jin']=2;
             
               $con=M('admin')->save($info);
                
             }else if($_POST['jin']=='已停用'){
                $info['jin']=1;
                $con=M('admin')->save($info);
             }
    }

    public function edit(){
         // $this->display(); 
        
                
        if(IS_POST){
            if(empty($_POST['title']) | empty($_POST['content']) ){
             echo '<script>alert("请添写完整信息");location.href=""</script>';die;
             }

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
                $a['images']=$info['images']['savename'];
            }

             $a['id']=$_POST['id'];
            $a['title']=$_POST['title'];
            $a['content']=$_POST['content'];
                $sql=M('zhishi')->save($a);
                 if ($sql> 0){
                    echo '<script>alert("修改成功");location.href="index"</script>';
                } else {
                    echo '<script>alert("修改失败,无更改");history.go(-1)</script>';
                }
              
               
            
            }else{
                // var_dump(I());
                 
                 $sql=M('zhishi')->find(I('id'));
                $this->assign('v', $sql);
                 // var_dump($sql);  
                 $this->display();

            }

        

          
        

    }

    
    


}
