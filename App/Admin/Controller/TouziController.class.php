<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class TouziController extends CommonController {

  //项目收益表
    public function index(){
        
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['name'] = array('like', "%$con%");
            $info=M('user')->where($data)->find();
            $a['user_id']=$info['user_id'];
            $arr=M('touzi')->where($a)->select();

            //命名
            foreach ($arr as $k => $v) {
              $a['user_id']=$v['user_id'];
              $info=M("user")->where($a)->find();
              $arr[$k]['user_id']=$info['name'];

              $b['xiangmu_id']=$v['xiangmu_id'];
              $info1=M("xiangmu")->where($b)->find();
              $arr[$k]['xiangmu_id']=$info1['xiangmu'];
            }
           
           
            $this->assign('arr',$arr);
            $this->display(); 
        }else{
            //查询数据并分页
            $model =M("touzi");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
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

              $info=M('xiangmu')->select();
              foreach ($info as $k => $v) {
                
              }
            }

            if(!empty($_GET['fid'])){
              $x['xiangmu']=I('fid');
            
              //计算该项目收益
              $info=M('xiangmu')->where($x)->find();
              $t['shouyi']=round($info['bili']*I('tid'),2);
              $t['id']=I('id');
              // var_dump( $t);
              if( $t['shouyi']>0){
              M('touzi')->save($t);


              
              $touzi=M('touzi')->find(I('id'));
             

             

              

                $f['user_id']=$touzi['user_id'];
                $f['xiangmu_id']=$info['xiangmu_id'];
                $f['shouyi']=$t['shouyi'];

                $xiaji['xiaji_id']=$f['user_id'];
                $xia=M('xiaji')->where($xiaji)->find();
                
                $bili=M('tuanti_bili')->find(1);
                $tuanti['xiaji_id']=$touzi['user_id'];
                $tuanti['user_id']=$xia['user_id'];
                $tuanti['xiangmu_id']=$info['xiangmu_id'];
                $tii=$touzi['shouyi']*0.01*$bili['bili'];
                $tuanti['shouyi']=round($tii,2);
                  // var_dump($tuanti);die;
                $fb=M('shouyi')->where($f)->select();
                  foreach ($fb as $k => $v) {
                    $stat[]=substr($v['time'],0,10);

                     
                  }
                // var_dump($stat);die;
                   $ss=in_array(date('Y-m-d'),$stat);
                   if($ss==true){
                        echo '<script>alert("今天收益已发布，请明天再来");location.href="index"</script>';die;
                      }else{
                        $cha=M('xiaji')->where($xiaji)->find();
                        if(!empty($cha)){
                          M('tuanti')->add($tuanti);
                        }
                         M('shouyi')->add($f);

                          //合伙人收益安全记录
                          $ok['user_id']=$tuanti['user_id'];
                          $jilu=M('zijinanquan')->where($ok)->find();

                          $l['tuanti']=$jilu['tuanti']+$tuanti['shouyi'];
                          $l['time']=date('Y-m-d H:i:s');
                          $j['user_id']=$tuanti['user_id'];
                          // var_dump($m);die;
                          M('zijinanquan')->where($j)->save($l);



                          //用户投资收益
                          $sy=M('user')->find($touzi['user_id']);
                          $a['shouyi']=$sy['shouyi']+$touzi['shouyi'];
                          $a['user_id']=$touzi['user_id'];
                          M('user')->save($a);

                           //用户下级投资收益
                          $oo=$j['user_id'];
                          $xx=M('user')->find($oo);
                          $ux['shouyi']=$xx['shouyi']+$tuanti['shouyi'];
                          $ux['user_id']=$j['user_id'];
                          M('user')->save($ux);


                          //用户投资团体收益流水
                          $tliushui=M('user')->find($touzi['user_id']);
                          $liushui['shouyi']='+'.$tuanti['shouyi'];
                          $liushui['user_id']=$j['user_id'];
                          $liushui['shijian']=$tliushui['name'].'合伙人投资';
                          M('liushui')->add($liushui);
                          
                           //安全记录
                          $op['user_id']=$touzi['user_id'];
                          $jilu=M('zijinanquan')->where($op)->find();
                          $m['touzi']=$jilu['touzi']+$touzi['shouyi'];
                          $n['user_id']=$touzi['user_id'];
                          M('zijinanquan')->where($n)->save($m);

                           //用户项目投资收益流水
                          $axiang=M('xiangmu')->find($info['xiangmu_id']);
                          $liushui['shouyi']='+'.$touzi['shouyi'];
                          $liushui['user_id']=$touzi['user_id'];
                          $liushui['shijian']=$axiang['xiangmu'].'收益';
                           M('liushui')->add($liushui);

                         //单个项目总收益
                          $s['zongshouyi']=$touzi['zongshouyi']+$touzi['shouyi'];
                          $s['id']=I('id');
                           M('touzi')->save($s);
                        
                        echo '<script>alert("发布成功，详情请看收益管理");location.href="index"</script>';
                      }
                   
                  
              }else{
                echo '<script>alert("该项目未满额，请耐心等待");history.go(-1)</script>';die; 
              }
              
            }


            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        }
        
    }

    //添加投资
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
        $info['touzi']=$_POST['touzi'];

        $sql=M('touzi')->add($info);
        if ($sql> 0){
                 echo '<script>alert("添加成功");location.href="index"</script>';
         }

      }else{
        $arr=M('xiangmu')->select();
            
        $this->assign('arr',$arr);     
        $this->display();

      }
       
    }

   
        

    
    public function tuichu(){
        // //实验ajax
        $a=$_GET['id'];
       
        $v=M('touzi')->find($a);
        $u=$v['user_id'];
        $s=M('user')->find($u);

        $m['user_id']=$s['user_id'];
        $m['money']= $v['touzi']+$s['money'];
        // var_dump($m);die;
        $sql=M('touzi')->delete($a);

       if ($sql> 0){

                 //用户项目退出流水
                  $axiang=M('xiangmu')->find($v['xiangmu_id']);
                  $liushui['benjin']='+'.$v['touzi'];
                  $liushui['user_id']=$v['user_id'];
                  $liushui['shijian']=$axiang['xiangmu'].'退出';
                  M('liushui')->add($liushui);

                M('user')->save($m);
                 echo '<script>alert("退出项目成功,资金已返还");location.href="index"</script>';
         }

            
            
        // //推荐使用
        // $this->ajaxReturn(2);
    }


     public function sqdel(){
        // //实验ajax
      $a=$_GET['id'];
     
        $sql=M('touzishenqing')->delete($a);

       if ($sql> 0){
                 echo '<script>alert("删除成功");location.href="touzishenqing"</script>';
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


    //项目收益表
    public function touzishenqing(){
        
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['name'] = array('like', "%$con%");
            $info=M('user')->where($data)->find();
            $a['user_id']=$info['user_id'];
            $arr=M('touzishenqing')->where($a)->select();

            //命名
            foreach ($arr as $k => $v) {
              $a['user_id']=$v['user_id'];
              $info=M("user")->where($a)->find();
              $arr[$k]['user_id']=$info['name'];

              $b['xiangmu_id']=$v['xiangmu_id'];
              $info1=M("xiangmu")->where($b)->find();
              $arr[$k]['xiangmu_id']=$info1['xiangmu'];

              if($v['chuli']==0){
                    $arr[$k]['chuli']='<font color="red">未处理</font>';
                }else{
                    $arr[$k]['chuli']='<font color="green">已处理</font>';
                }
            }
           
           
            $this->assign('arr',$arr);
            $this->display(); 
        }else{
            //查询数据并分页
            $model =M("touzishenqing");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order('chuli asc,id desc')->limit($page->firstRow.','.$page->listRows)->select();
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

              if($v['chuli']==0){
                    $arr[$k]['chuli']='<font color="red">未处理</font>';
                }else{
                    $arr[$k]['chuli']='<font color="green">已处理</font>';
                }
            }
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        }
        
    }

    //处理投资
     public function chuli(){
          if(IS_GET){
           
            $arr=M('touzishenqing')->find(I('id'));
            if($arr['chuli']==0){
            $yue=M('user')->find($arr['user_id']);
            if($yue['money']<$arr['money']){
              echo '<script>alert("该用户余额不足");location.href="touzishenqing"</script>';die;
            }else{
              $y['money']=$yue['money']-$arr['money'];
              $y['user_id']=$yue['user_id'];
              // var_dump($yue);die;
              M('user')->save($y);
            }
            

            $a['user_id']=$arr['user_id'];
            $a['xiangmu_id']=$arr['xiangmu_id'];

            $c['xiangmu_id']=$arr['xiangmu_id'];

            $xiangmu=M('xiangmu')->where($c)->find();
            if($xiangmu['yitouzi']<$xiangmu['zonge']){
              $c['yitouzi']=$xiangmu['yitouzi']+$arr['money'];
              if($c['yitouzi']>$xiangmu['zonge']){
                echo '<script>alert("此次投资超过项目总额");location.href="touzishenqing"</script>';die;
              }
              M('xiangmu')->save($c);
            }else{
              echo '<script>alert("该项目投资已满额,更新项目信息");location.href="touzishenqing"</script>';die;
            }

            $info=M('touzi')->where($a)->find();

            if($info==NULL){
              $b['user_id']=$arr['user_id'];
              $b['xiangmu_id']=$arr['xiangmu_id'];
              $b['touzi']=$arr['money'];
              M('touzi')->add($b);
            }else{
              $a['touzi']=$info['touzi']+$arr['money'];
              $a['id']=$info['id'];
              M('touzi')->save($a);
            }

           
                
                $a['id']=$_GET['id'];
                $a['chuli']=1;
                 // var_dump($a);die;
                $info=M('touzishenqing')->save($a);
                  if ( $info> 0){
                  //用户项目投资流水
                  $axiang=M('xiangmu')->find($arr['xiangmu_id']);
                  $liushui['benjin']='-'.$arr['money'];
                  $liushui['user_id']=$arr['user_id'];
                  $liushui['shijian']=$axiang['xiangmu'].'投资';
                  M('liushui')->add($liushui);
                    echo '<script>alert("投资成功");location.href="touzishenqing"</script>';
                }      

              }else{
                  echo '<script>alert("该投资已被处理");location.href="touzishenqing"</script>';
              }
            
          }
                
            
    }

     public function hetong(){
      $arr=M('hetong')->find(1);
      $this->assign('v',$arr); 
       $this->display(); 
     }

    public function htedit(){

      if(IS_POST){
        if(empty($_POST['title']) | empty($_POST['conter'])){
            echo '<script>alert("请填写完整信息");history.go(-1)</script>';die;
        }

        $info=M('hetong')->save($_POST);
        if($info>0){
           echo '<script>alert("修改成功");location.href="hetong"</script>';
        }else{
          echo '<script>alert("修改失败");history.go(-1)</script>';
        }
      }




      $arr=M('hetong')->find(1);
      $this->assign('v',$arr); 
       $this->display(); 
     }
    


}
