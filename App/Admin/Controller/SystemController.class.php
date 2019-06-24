<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class SystemController extends CommonController
{
	public function index()
	{
		$model =M("system");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            // var_dump($info);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
            
	}

	public function add()
    {
        
        if(IS_POST){
            // var_dump(I());die;
            if(empty($_POST['title'])|empty($_POST['content'])| empty($_POST['types'])){
                    echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
                 }
            $data['title'] = $_POST['title'];
            $data['content'] = $_POST['content'];
            $data['addtime'] = date("Y-m-d h:i:s");
            $data['types'] = $_POST['types'];


            $sql=M('system')->add($data);

            if ($sql> 0){
                echo '<script>alert("添加成功");location.href="index"</script>';
            } else {
                echo '<script>alert("添加失败");history.go(-1)</script>';
            }
              
               
        }else{
            
           $this->display();  
        }

    }

    public function edit()
    {
        if(IS_POST){
                 // var_dump(empty($_POST['types']));die;
                 if(!isset($_POST['title']) | !isset($_POST['content']) | !isset($_POST['types'])){
                    echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
                 }
             	
             	$data['title'] = $_POST['title'];
                $data['content'] = $_POST['content'];
                $data['addtime'] = date("Y-m-d h:i:s");
                $data['types'] = $_POST['types'];
                $data['id'] = $_POST['id'];

                $sql=M('system')->save($data);
                 if ($sql> 0){
                   
                            echo '<script>alert("修改成功");location.href="index"</script>';  
                    
                } else {

                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
              
        }else{

            $a['id']=I('id');
            $arr=M("system")->where($a)->find();

             $this->assign('v',$arr);
               // var_dump($arr);
           
           $this->display();  
        }
    }

	public function del(){
        // var_dump(I());die;
        $id=$_GET['id'];
        $arr=M('system')->delete($id);
        if($arr>0){
           
                echo '<script>alert("删除成功");location.href="index"</script>';
        
        }
    }

    public function sys()
    {
        $model =M("sys");
        //查出总条数 
        $count = $model->count();
        //引入分页类 
        $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
        //引入数据
        $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
        //分页
        
        $btn = $page->show();
        //分配数据
       
        $this->assign('arr',$arr);          //信息
        $this->assign('btn',$btn);          //分页
        $this->assign('shu',$count);        //总条数   
        $this->display();
    }

    public function sysedit()
    {
        if(IS_POST){

                 // var_dump(empty($_POST['types']));die;
                 // if(!isset($_POST['title']) | !isset($_POST['content']) | !isset($_POST['types'])){
                 //    echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
                 // }
                
                $data['address'] = $_POST['address'];
                $data['title'] = $_POST['title'];
                $data['content'] = $_POST['content'];
                $data['about'] = $_POST['about'];
                $data['beizhu'] = $_POST['beizhu'];
                $data['content'] = $_POST['content'];
                $data['tel'] = $_POST['tel'];                
                $data['line'] = $_POST['line'];
                $data['id'] = $_POST['id'];

                $sql=M('sys')->save($data);

                if($sql !== false){
                    echo '<script>alert("修改成功");location.href="sys"</script>';
                } else {
                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
        }else{
            $a['id']=I('id');
            $arr=M("sys")->where($a)->find();

            $this->assign('v',$arr);
           
            $this->display();  
        }
    }

    public function sysadd()
    {
        
        if(IS_POST){
            // var_dump(I());die;
            // if(empty($_POST['title'])|empty($_POST['content'])| empty($_POST['types'])){
            //         echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
            //      }
            $data['address'] = $_POST['address'];
            $data['title'] = $_POST['title'];
            $data['content'] = $_POST['content'];
            $data['about'] = $_POST['about'];
            $data['beizhu'] = $_POST['beizhu'];
            $data['content'] = $_POST['content'];
            $data['tel'] = $_POST['tel'];                
            $data['line'] = $_POST['line'];


            $sql=M('sys')->add($data);

            if ($sql > 0){
                echo '<script>alert("添加成功");location.href="sys"</script>';
            } else {
                echo '<script>alert("添加失败");history.go(-1)</script>';
            }
              
               
        }else{
            
           $this->display();  
        }
    }

    public function sysdel()
    {
        $id=$_GET['id'];

        $arr=M('sys')->delete($id);

        if($arr>0){
            echo '<script>alert("删除成功");location.href="sys"</script>';
        }
    }


}