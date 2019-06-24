<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class TIxianController extends CommonController {

  //项目收益表
    public function index(){
        
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['name'] = array('like', "%$con%");
            $info=M('user')->where($data)->find();
            $a['user_id']=$info['user_id'];
            $arr=M('tixian')->where($a)->select();

            //命名
            foreach ($arr as $k => $v) {
              $a['user_id']=$v['user_id'];
              $info=M("user")->where($a)->find();
              $arr[$k]['user_id']=$info['name'];
              if($v['chuli']==0){
                    $arr[$k]['chuli']='<font color="red">未处理</font>';
                }else{
                    $arr[$k]['chuli']='<font color="green">已处理</font>';
                }
              if($v['zhifu']==0){
                  $arr[$k]['zhifu']='微信';
                }else{
                  $arr[$k]['zhifu']='支付宝';
                }

                if($v['lei']==0){
                  $arr[$k]['lei']='收益';
                }else{
                  $arr[$k]['lei']='本金';
                }
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
            $model =M("tixian");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order('chuli asc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            //命名
            foreach ($arr as $k => $v) {
              $a['user_id']=$v['user_id'];
              $info=M("user")->where($a)->find();
              $arr[$k]['user_id']=$info['name'];
                if($v['chuli']==0){
                    $arr[$k]['chuli']='<font color="red">未处理</font>';
                }else{
                    $arr[$k]['chuli']='<font color="green">已处理</font>';
                }
                if($v['zhifu']==0){
                  $arr[$k]['zhifu']='微信';
                }else{
                  $arr[$k]['zhifu']='支付宝';
                }

                 if($v['lei']==0){
                  $arr[$k]['lei']='收益';
                }else{
                  $arr[$k]['lei']='本金';
                  $arr[$k]['kouchu']='不扣';
                }
                $arr[$k]['weiimg']=$info['weiimg'];
                $arr[$k]['zhiimg']=$info['zhiimg'];
            }
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        }
        
    }

   
    // public function add(){

    //     if(IS_POST){
    //          if(empty($_POST['username']) | empty($_POST['pwd']) | empty($_POST['phone'])){
    //         echo '<script>alert("注册失败：请添写完整信息");location.href=""</script>';die;
    //         }
    //         $a="/[0-9]{11}/";
    //         if(!preg_match($a,$_POST['phone'])){
    //             echo '<script>alert("注册失败：请填写正确的手机号码");location.href=""</script>';die;
    //         }

    //         $info['username']=$_POST['username'];
    //         $info['pwd']=$_POST['pwd'];
    //         $info['sex']=$_POST['sex'];
    //         $info['phone']=$_POST['phone'];
    //         // date_default_timezone_set('PRC');
    //         $info['addtime']=date('y-m-d H:i:s');
    //         // var_dump($info);
    //         $sql=M('admin')->add($info);
    //     if ($sql> 0){
    //             echo '<script>alert("添加成功");location.href=""</script>';
    //         } else {
    //             echo '<script>alert("添加失败");location.href=""</script>';
    //         }
         
    //     }else{
    //        $this->display();
    //     }

                                
        

    
    public function del(){
        // //实验ajax
      $a=$_GET['id'];
     
        $sql=M('tixian')->delete($a);

       if ($sql> 0){
                 echo '<script>alert("删除成功");location.href="index"</script>';
         }

            
            
        // //推荐使用
        // $this->ajaxReturn(2);
    }

     public function chuli(){
          if(IS_GET){
            $arr=M('tixian')->find(I('id'));
            if($arr['chuli']==0){
            $tx=M('user')->find( $arr['user_id']);

              //本金提现
            if($arr['lei']==1){
                if($tx['money']<$arr['tixian']){
                  echo '<script>alert("该用户余额不足以提现");location.href="index"</script>';die;
                }else{
                  $a['money']=$tx['money']-$arr['tixian'];
                  $a['user_id']=$arr['user_id'];
                  $a['time']=date('Y-m-d H:i:s');
                  M('user')->save($a);


                          //用户本金提现流水
                         
                          $liushui['benjin']='-'.$arr['tixian'];
                          $liushui['user_id']=$a['user_id'];
                          $liushui['shijian']='本金提现';
                          M('liushui')->add($liushui);
                }
            }else{

                //收益提现
                if($tx['shouyi']<$arr['tixian']){
                  echo '<script>alert("该收益不足以提现");location.href="index"</script>';die;
                }else{
                  $a['shouyi']=$tx['shouyi']-$arr['tixian'];
                  $a['user_id']=$arr['user_id'];
                  $a['time']=date('Y-m-d H:i:s');
                  M('user')->save($a);

                      //用户收益提现流水
                         
                          $liushui['shouyi']='-'.$arr['tixian'];
                          $liushui['user_id']=$a['user_id'];
                          $liushui['shijian']='收益提现';
                          M('liushui')->add($liushui);
                }
            }
           

             
                $a['id']=$_GET['id'];
                $a['chuli']=1;
                 // var_dump($a);die;
                $info=M('tixian')->save($a);
                  if ( $info> 0){
                    echo '<script>alert("已提现成功");location.href="index"</script>';
                }      

              }else{
                  echo '<script>alert("该提现已被处理");location.href="index"</script>';
              }
            
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

    
    


}
