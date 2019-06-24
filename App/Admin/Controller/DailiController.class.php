<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class DailiController extends CommonController {
    public function index(){
      $model =M("jieqi_system_users");

        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['uname|mobile'] = array('like', "%$con%");
            $arr=M('jieqi_system_users')->where($data)->select();
          
          } else{  


            $dai['lei']=array(array('eq',1),array('eq',2),'or');
            //查出总条数 
            $count = $model->where($dai)->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($dai)->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            

             // var_dump($arr);die;
            //分配数据
          }
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
     
    }

   
     public function jiesuan()
    {

      if(!empty(I('fuid'))){
        $fu['id']=I('fuid');
        $fu['lei']=1;
        M('dai_jiesuan')->save($fu);
      }

      //代理商月结
      $arr=M('dai_jiesuan')->select();
      foreach ($arr as $k => $v) {
        $user=M('jieqi_system_users')->find($v['uid']);
        $arr[$k]['name']=$user['uname'];
        $arr[$k]['bili']=$user['yongjin'].'%';
        $arr[$k]['jiesuan']=$user['yongjin']*0.01*$v['money'];
        $chong[]=$v['money'];
        $bi[]=$v['num'];
        $jie[]=$user['yongjin']*0.01*$v['money'];
        if($v['lei']==0){
          $wei[]=$user['yongjin']*0.01*$v['money'];
        }else{
          $yi[]=$user['yongjin']*0.01*$v['money'];
        }
      }

      $chong=array_sum($chong);       //充值zonge
      $bi=array_sum($bi);             //充值笔数
      $jie=array_sum($jie);           //结算总数
      $wei=array_sum($wei);           //未结算
      $yi=array_sum($yi);             //已结算
      

        $this->assign('chong',$chong);
        $this->assign('bi',$bi);
        $this->assign('jie',$jie);
        $this->assign('wei',$wei);
        $this->assign('yi',$yi);
        $this->assign('arr',$arr);
        $this->display(); 
    }

   

    public function add(){
        if(IS_POST){
            // var_dump(I());
            // if(empty($_POST['uname']) | empty($_POST['name']) | empty($_POST['pass']) | empty($_POST['email']) ){
            //         echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
            //      }

                  $a['mobile']=$_POST['mobile'];
                  $b['email']=$_POST['email'];
                   $c['uname']=$_POST['uname'];
                // var_dump($a);die;
                  $arr=M('jieqi_system_users')->where($a)->find();
                  if($arr!==NULL){
                    echo '<script>alert("手机已存在");history.go(-1)</script>';die;
                  }
                  $info=M('jieqi_system_users')->where($b)->find();
                  if($info!==NULL){
                    echo '<script>alert("邮箱已存在");history.go(-1)</script>';die;
                  }
                   $sql=M('jieqi_system_users')->where($c)->find();
                  if($sql!==NULL){
                    echo '<script>alert("代理商名字已存在");history.go(-1)</script>';die;
                  }
                  for ($i = 1; $i <= 4; $i++) {
                    $sui=chr(rand(97, 122));
                    $sui1=chr(rand(65,90));
                    $sui2=chr(rand(65,90));
                    $sui3=chr(rand(97, 122));
                    $sui4=chr(rand(65,90));
                  }
                 
                  $ji=$sui.$sui1.$sui2.$sui3.$sui4;
                   
                  $add['mobile']=I('mobile');
                  $add['email']=I('email');
                  $add['uname']=I('uname');
                  $add['token']=$ji.time();
                  $add['pass']=I('pass');
                  $add['lei']=I('lei');
                  $add['yongjin']=I('yongjin');
                  $add['jiesuan']=I('jiesuan');
                  $add['zhifu']=I('zhifu');
                  $add['zhiname']=I('zhiname');
                  $add['zhihao']=I('zhihao');
                 
                  $f['token']=$ji.time();
                $sql=M('jieqi_system_users')->add($add);
                 if ($sql> 0){
                    $u=M('jieqi_system_users')->where($f)->find();
                    $g['uid']=$u['uid'];
                    $g['token']=$ji.time();
                    $g['urldizhi']='http://www.youdingb.com/xiangmu/xiaoshuoyipin/sqs.php/id='.$u['uid'];
                    M('gongzhonghao')->add($g);
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
            // if(empty($_POST['uname']) | empty($_POST['name'])  | empty($_POST['email']) ){
            //         echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
            //      }

                  $a['mobile']=$_POST['mobile'];
                  $a['uid']=array('neq',$_POST['uid']);
                  $b['email']=$_POST['email'];
                  $b['uid']=array('neq',$_POST['uid']);
                  $c['uname']=$_POST['uname'];
                  $c['uid']=array('neq',$_POST['uid']);
                 // var_dump($a);die;
                  $arr=M('jieqi_system_users')->where($a)->find();
                  if($arr!==NULL){
                    echo '<script>alert("手机已存在");history.go(-1)</script>';die;
                  }
                  $info=M('jieqi_system_users')->where($b)->find();
                  if($info!==NULL){
                    echo '<script>alert("邮箱已存在");history.go(-1)</script>';die;
                  }

                   $sql=M('jieqi_system_users')->where($c)->find();
                  if($sql!==NULL){
                    echo '<script>alert("代理商名字已存在");history.go(-1)</script>';die;
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

}