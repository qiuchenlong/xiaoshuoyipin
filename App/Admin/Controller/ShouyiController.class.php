<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class ShouyiController extends CommonController {

  //项目收益表
    public function index(){
        
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['name'] = array('like', "%$con%");
            $info=M('user')->where($data)->find();
            $a['user_id']=$info['user_id'];
            $arr=M('shouyi')->where($a)->select();

            //命名
            foreach ($arr as $k => $v) {
              $a['user_id']=$v['user_id'];
              $info=M("user")->where($a)->find();
              $arr[$k]['user_id']=$info['name'];

              $b['xiangmu_id']=$v['xiangmu_id'];
              $info1=M("xiangmu")->where($b)->find();
              $arr[$k]['xiangmu_id']=$info1['xiangmu'];
            }
            //性别
            // $sex = [1 => '男',2 =>  '女'];
            // foreach ($arr as $k=>$v) {
            //     $arr[$k]['sex'] = $sex[$v['sex']];
            // }
            // 
            //两表查询
            // foreach ($info as $k=>$v) {
            //     $arr= M('user')->find($v['uid']); 
            //     $info[$k]['uid']=$arr['username'];
            // }
           
            $this->assign('arr',$arr);
            $this->display(); 
        }else{
            //查询数据并分页
            $model =M("shouyi");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            //命名
            foreach ($arr as $k => $v) {
              $a['user_id']=$v['user_id'];
              $info=M("user")->where($a)->find();
              $arr[$k]['user_id']=$info['name'];

              $b['xiangmu_id']=$v['xiangmu_id'];
              $info1=M("xiangmu")->where($b)->find();
              $arr[$k]['xiangmu_id']=$info1['xiangmu'];
            }
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        }
        
    }

    //团体收益表
    public function tuanti(){
        //遍历管理员名单
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['name'] = array('like', "%$con%");
            $info=M('user')->where($data)->find();
            $a['user_id']=$info['user_id'];
            $arr=M('tuanti')->where($a)->select();

            //命名
            foreach ($arr as $k => $v) {
              $a['user_id']=$v['user_id'];
              $info=M("user")->where($a)->find();
              $arr[$k]['user_id']=$info['name'];

              $b['xiangmu_id']=$v['xiangmu_id'];
              $info1=M("xiangmu")->where($b)->find();
              $arr[$k]['xiangmu_id']=$info1['xiangmu'];
            }
            //性别
            // $sex = [1 => '男',2 =>  '女'];
            // foreach ($arr as $k=>$v) {
            //     $arr[$k]['sex'] = $sex[$v['sex']];
            // }
            // 
            //两表查询
            // foreach ($info as $k=>$v) {
            //     $arr= M('user')->find($v['uid']); 
            //     $info[$k]['uid']=$arr['username'];
            // }
           
            $this->assign('arr',$arr);
            $this->display(); 
        }else{
            //查询数据并分页
            $model =M("tuanti");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            //命名
            foreach ($arr as $k => $v) {
              $a['user_id']=$v['user_id'];
              $info=M("user")->where($a)->find();
              $arr[$k]['user_id']=$info['name'];

              $b['user_id']=$v['xiaji_id'];
              $info1=M("user")->where($b)->find();
              $arr[$k]['xiaji_id']=$info1['name'];
            
            }
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        }
        
    }

    //添加投资收益
   public function add(){
      if(IS_POST){
        $a['name']=I('yonghu');
         $arr=M('user')->where($a)->find();
         if($arr==NULL){
            echo '<script>alert("用户不存在，请填写正确的用户名");history.go(-1)</script>';die;
         }

         if(empty($_POST['touzi']) | $_POST['xiangmu_id']==0 ){
                    echo '<script>alert("添加失败：请填写完整的资料");history.go(-1)</script>';die;
          }

        $info['user_id']=$arr['user_id'];
        $info['xiangmu_id']=$_POST['xiangmu_id'];
        $info['shouyi']=$_POST['touzi'];

        $sql=M('shouyi')->add($info);
        if ($sql> 0){
                 echo '<script>alert("添加成功");location.href="index"</script>';
         }

      }else{
        $arr=M('xiangmu')->select();
            
        $this->assign('arr',$arr);     
        $this->display();

      }
       
    }


     //添加团体收益
   public function ttadd(){
      if(IS_POST){
        $a['name']=I('yonghu');
         $arr=M('user')->where($a)->find();
         if($arr==NULL){
            echo '<script>alert("用户不存在，请填写正确的用户名");history.go(-1)</script>';die;
         }

         if(empty($_POST['touzi']) | $_POST['xiangmu_id']==0 ){
                    echo '<script>alert("添加失败：请填写完整的资料");history.go(-1)</script>';die;
          }

        $info['user_id']=$arr['user_id'];
        $info['xiangmu_id']=$_POST['xiangmu_id'];
        $info['shouyi']=$_POST['touzi'];

        $sql=M('shouyi')->add($info);
        if ($sql> 0){
                 echo '<script>alert("添加成功");location.href="index"</script>';
         }

      }else{
        $arr=M('xiangmu')->select();
            
        $this->assign('arr',$arr);     
        $this->display();

      }
       
    }


    public function del(){
        // //实验ajax
      $a=$_GET['id'];
     
        $sql=M('shouyi')->delete($a);

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
               // var_dump($_POST);
            
               $a="/[0-9]{11}/";
               $arr=M('admin')->find($_POST['id']); 

               if(empty($_POST['username']) | empty($_POST['pwd']) | empty($_POST['phone'])){
                    echo '<script>alert("修改失败：请填写完整的资料");history.go(-1)</script>';die;
                 }else if(!preg_match($a,$_POST['phone'])){
                    echo '<script>alert("修改失败：请填写正确的手机号码");history.go(-1)</script>';die;
                }else if($_POST['pwd1']!==$arr['pwd']){
                    echo '<script>alert("修改失败：原密码错误");history.go(-1)</script>';die;
                }




                $sql=M('admin')->save($_POST);
                 if ($sql> 0){
                    echo '<script>alert("修改成功");location.href="index.shtml"</script>';
                } else {
                    echo '<script>alert("修改失败,无更改");history.go(-1)</script>';
                }
              
               
            
            }else{
                // var_dump(I());
                 
                 $sql=M('admin')->find(I('id'));
                $this->assign('v', $sql);
                 // var_dump($sql);  
                 $this->display();

            }

        

          
        

    }


     public function zsedit(){
         // $this->display(); 
        if(IS_POST){
               // var_dump($_POST);
            
         
               $arr=M('xiangmu')->find($_POST['id']); 

               if(empty($_POST['xiaoyi']) ){
                    echo '<script>alert("修改失败：请填写总收益");history.go(-1)</script>';die;
               }  




                $sql=M('admin')->save($_POST);
                 if ($sql> 0){
                    echo '<script>alert("修改成功");location.href="index.shtml"</script>';
                } else {
                    echo '<script>alert("修改失败,无更改");history.go(-1)</script>';
                }
              
               
            
            }else{
                // var_dump(I());
                 
                 $sql=M('xiangmu')->find(I('xiangmu_id'));
                $this->assign('v', $sql);
                 // var_dump($sql);  
                 $this->display();

            }

        

          
        

    }


    public function zongshouyi(){
        
            //查询数据并分页
            $model =M("zongshouyi");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            //命名
            foreach ($arr as $k => $v) {
             

              $b['xiangmu_id']=$v['xiangmu_id'];
              $info1=M("xiangmu")->where($b)->find();
              $arr[$k]['xiangmu_id']=$info1['xiangmu'];
            }
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
    }

    public function zsdel(){
        // //实验ajax
      $a=$_GET['id'];
     
        $sql=M('zongshouyi')->delete($a);

       if ($sql> 0){
                 echo '<script>alert("删除成功");location.href="zongshouyi"</script>';
         }

            
            
        // //推荐使用
        // $this->ajaxReturn(2);
    }


     public function ttdel(){
        // //实验ajax
      $a=$_GET['id'];
     
        $sql=M('tuanti')->delete($a);

       if ($sql> 0){
                 echo '<script>alert("删除成功");location.href="tuanti"</script>';
         }

            
            
        // //推荐使用
        // $this->ajaxReturn(2);
    }


     public function lilv(){
        if(IS_POST){
          $add=M('fenhong')->save($_POST);
          if($add>0){
             echo '<script>alert("修改成功");location.href="lilv"</script>';
          }else{
               echo '<script>alert("修改失败");location.href="lilv"</script>';
          }
        }else{
          $arr=M('fenhong')->find(1);
          // var_dump($arr);die;
          $this->assign('arr',$arr);  
          $this->display(); 
        }
       
    }

    
    


}
