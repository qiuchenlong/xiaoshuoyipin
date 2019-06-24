<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class UserController extends CommonController {
    public function index(){
      $model =M("jieqi_system_users");
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
            // var_dump($arr);exit；
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
     
    }

    public function kanbi(){
      
            $model =M("chongzhi");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            foreach ($arr as $k => $v) {
              $info=M('jieqi_system_users')->find($v['uid']);
              $arr[$k]['uid']=$info['uname'];
            }
            

            // var_dump($info);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
     
    }

     public function chongzhi(){
          if(IS_POST){
             $arr=M('chongzhi')->add($_POST);
             $a['uid']=$_POST['uid'];
             $info=M('jieqi_system_users')->where($a)->find();
             $k['uid']=$_POST['uid'];
             $k['egold']=$_POST['kanbi']+$info['egold'];
             if($arr>0){
                M('jieqi_system_users')->save($k);
                echo '<script>alert("充值成功");window.parent.location.reload()</script>';
             }
           }
      
            $this->display();
    }

    public function daijinquan(){
        if(IS_POST){
            $arr=M('daijinquan')->add($_POST);
            $a['uid']=$_POST['uid'];
            $info=M('jieqi_system_users')->where($a)->find();
            $k['uid']=$_POST['uid'];
            $k['daijin']=$_POST['daijin']+$info['daijin'];
            if($arr>0){
                M('jieqi_system_users')->save($k);
                echo '<script>alert("充值成功");window.parent.location.reload()</script>';
            }
       }
  
        $this->display();
    }    


    public function add(){
        if(IS_POST){
            // var_dump(I());
            if(empty($_POST['uname']) | empty($_POST['name']) | empty($_POST['pass']) | empty($_POST['email']) ){
                    echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
                 }

                  $a['uname']=$_POST['uname'];
                  $b['email']=$_POST['email'];
                // var_dump($a);die;
                  $arr=M('jieqi_system_users')->where($a)->find();
                  if($arr!==NULL){
                    echo '<script>alert("账户已存在");history.go(-1)</script>';die;
                  }
                  $info=M('jieqi_system_users')->where($b)->find();
                  if($info!==NULL){
                    echo '<script>alert("邮箱已存在");history.go(-1)</script>';die;
                  }

                $sql=M('jieqi_system_users')->add($_POST);
                 if ($sql> 0){
                    echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                } else {
                    echo '<script>alert("添加失败");history.go(-1)</script>';
                }
              
               
        }else{
           
           $this->display();  
        }
    }


    public function edit(){
        if(IS_POST){
            // var_dump(I());
            if(empty($_POST['uname']) | empty($_POST['name'])  | empty($_POST['email']) ){
                    echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
                 }

                  $a['uname']=$_POST['uname'];
                  $a['uid']=array('neq',$_POST['uid']);
                  $b['email']=$_POST['email'];
                  $b['uid']=array('neq',$_POST['uid']);
                 // var_dump($a);die;
                  $arr=M('jieqi_system_users')->where($a)->find();
                  if($arr!==NULL){
                    echo '<script>alert("账户已存在");history.go(-1)</script>';die;
                  }
                  $info=M('jieqi_system_users')->where($b)->find();
                  if($info!==NULL){
                    echo '<script>alert("邮箱已存在");history.go(-1)</script>';die;
                  }
                  
                $sql=M('jieqi_system_users')->save($_POST);
                 if ($sql> 0){
                    echo '<script>alert("修改成功");window.parent.location.reload()</script>';
                } else {
                    echo '<script>alert("用户信息无更改");history.go(-1)</script>';
                }
              
               
        }else{
            $a=$_GET['id'];
           $v=M('jieqi_system_users')->find($a);
           $this->assign('v',$v);
           $this->display();  
        }
    }
    
     public function del(){
        // var_dump(I());die;
        $id=$_GET['id'];
        $arr=M('jieqi_system_users')->delete($id);
        if($arr>0){
           
                echo '<script>alert("删除成功");location.href="index"</script>';
            

          
        }
    }

    //发送消息
    public function xiaoxi(){
          if(IS_POST){
            $arr=M('system')->add(I());
              if($arr>0){
                echo '<script>alert("信息发送成功");window.parent.location.reload()</script>';
              }
           }
      
            $this->display();   
        
     
    }

     //信息记录
    public function xinxi(){
            $model =M("system");
            //查出总条数 
            $count = $model->where(['types'=>['not in',[2,3]]])->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where(['types'=>['not in',[2,3]]])->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            

            // var_dump($info);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
          
      
           
        
     
    }

    public function xinxiedit(){

      if(IS_POST){
        $save=M('system')->save(I());
        if($save>0){
           echo '<script>alert("修改成功");window.parent.location.reload()</script>';
         }else{
             echo '<script>alert("修改成功");window.parent.location.reload()</script>';
         }
      }

      $arr=M('system')->find(I('id'));
      $this->assign('arr',$arr);
      $this->display(); 
    }


     public function xinxidel(){
        // var_dump(I());die;
        $id=$_GET['id'];
        $arr=M('system')->delete($id);
        if($arr>0){
           
                echo '<script>alert("删除成功");location.href="xinxi"</script>';
            

          
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
    // 用户奖励代金券记录
    public function daijin()
    {
          $model =M("jieqi_users_fx_record");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->alias('a')->field('a.*,b.uname,b.name')->join('__JIEQI_SYSTEM_USERS__ b ON a.uid = b.uid')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();
            foreach ($arr as $k => $v) {
              $arr[$k]['time']=date('Y-m-d h:i:s',$v['time']);
            }
            

            // var_dump($arr);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display(); 
    }

  

   

}