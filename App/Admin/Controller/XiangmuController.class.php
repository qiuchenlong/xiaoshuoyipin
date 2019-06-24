<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class XiangmuController extends CommonController {
    public function index(){
        //项目详情
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['xiangmu'] = array('like', "%$con%");
            $arr=M('xiangmu')->where($data)->select();
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

             //推荐下架
        
            if(I('tuijian')==1){
              M('xiangmu')->save(I());
            }else if(I('tuijian')==0){
              M('xiangmu')->save(I());
            }
        
            //查询数据并分页
            $model =M("xiangmu");
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
        
    }


      //项目额度
     public function edu(){
        //遍历管理员名单
        if(IS_POST){
            //查询
            $con=$_POST['id'];
            $data['xiangmu'] = array('like', "%$con%");
            $arr=M('xiangmu')->where($data)->select();
            foreach ($arr as $k => $v) {
               if($v['edu']==0){
                    $arr[$k]['edu']='<font color="red">未满额</font>';
                }else{
                    $arr[$k]['edu']='<font color="green">已满额</font>';
                }
              # code...
            }
           
            $this->assign('arr',$arr);
            $this->display(); 
        }else{
            //查询数据并分页
            $model =M("xiangmu");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            $btn = $page->show();

            foreach ($arr as $k => $v) {
               if($v['edu']==0){
                    $arr[$k]['edu']='<font color="red">未满额</font>';
                }else{
                    $arr[$k]['edu']='<font color="green">已满额</font>';
                }
              # code...
            }

            if(!empty($_GET['id'])){
              $fa['xiangmu_id']=$_GET['id'];
              $fabu=M('xiangmu')->where($fa)->find();
                if($fabu['edu']==0){
                  echo '<script>alert("发布失败了：该项目未满额");location.href="edu"</script>';die;
                }else{
                  $zong['xiangmu_id']=$_GET['id'];
                  $zong['zongshouyi']=$fabu['xiaoyi'];
                  // $zong['time']=date('Y-m-d');
                  $fb=M('zongshouyi')->where($zong)->select();
                 
                   // var_dump( $fb);die;
                   foreach ($fb as $k => $v) {
                      $stat[]=substr($v['time'],0,10);
                      
                   }
                    $ss=in_array(date('Y-m-d'),$stat);
                    if($ss==true){
                            echo '<script>alert("今天收益已发布，请明天再来");location.href="edu"</script>';die;
                        }
                        
                    $zz['zongshouyi']=$fabu['xiaoyi']+$fabu['zongshouyi'];
                    $zz['xiangmu_id']=$fabu['xiangmu_id'];
                    M('xiangmu')->save($zz);
                    M('zongshouyi')->add($zong);
                    echo '<script>alert("发布成功：详情请看收益管理");location.href="edu"</script>';
                 
                 
                  
                }
                // var_dump($fabu);
            }
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        }
        
    }


   //添加项目
    public function add(){ 


      

        if(IS_POST){
              
             if(empty($_POST['xiangmu']) | empty($_POST['xiaoyi'])  | empty($_POST['jieshao']) | empty($_POST['statime'])  | empty($_POST['endtime'])  | empty($_POST['zonge']) ){
                 echo '<script>alert("添加失败了：请添写完整信息");location.href=""</script>';die;
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

            $arr['xiangmu']=$_POST['xiangmu'];
            $arr['xiaoyi']=$_POST['xiaoyi'];
            $arr['jieshao']=$_POST['jieshao'];
            $arr['statime']=$_POST['statime'];
            $arr['endtime']=$_POST['endtime'];
            $arr['zonge']=$_POST['zonge'];
            $arr['images']=$a;
            

             $arr=M('xiangmu')->add($arr);

            if ($arr> 0){
                 echo '<script>alert("添加成功");location.href="index"</script>';
              } else {
                  echo '<script>alert("添加失败");location.href=""</script>';
              }


         
        }else{

          
            $this->display();
        } 
        
    }


    public function ajax(){
        if(IS_POST){
          var_dump(I());
        }
    }

    
    public function del(){
        // //实验ajax
      $a=$_GET['id'];
     
        $sql=M('xiangmu')->delete($a);

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

   
     public function chuli(){
          if(IS_GET){
            $arr=M('xiangmu')->find(I('id'));
              if($arr['edu']==0){
                $a['xiangmu_id']=$_GET['id'];
                $a['edu']=1;
                $a['bili']=$arr['xiaoyi']/$arr['yitouzi'];
                // var_dump($a);die;
                $info=M('xiangmu')->save($a);
                if ( $info> 0){
                    echo '<script>alert("处理成功");location.href="edu"</script>';
                }      

              }else{
                  echo '<script>alert("该项目已满额");location.href="edu"</script>';
              }
            
          }
                
            
    }



     //修改
    public function edit(){
         // $this->display(); 
        if(IS_POST){
               // var_dump($_POST);
            
            
              
            if(empty($_POST['xiangmu']) | empty($_POST['xiaoyi'])  | empty($_POST['jieshao']) | empty($_POST['statime'])  | empty($_POST['endtime'])  | empty($_POST['zonge']) ){
                 echo '<script>alert("添加失败了：请添写完整信息");location.href=""</script>';die;
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

            $arr['xiangmu']=$_POST['xiangmu'];
            $arr['xiaoyi']=$_POST['xiaoyi'];
            $arr['jieshao']=$_POST['jieshao'];
            $arr['statime']=$_POST['statime'];
            $arr['endtime']=$_POST['endtime'];
            $arr['zonge']=$_POST['zonge'];
            $arr['xiangmu_id']=$_POST['id'];
            $arr['images']=$a;
                // var_dump($a);die;
                $sql=M('xiangmu')->save($arr);
                 if ($sql> 0){
                    echo '<script>alert("修改成功");location.href="index"</script>';
                } else {
                    echo '<script>alert("修改失败,无更改");history.go(-1)</script>';
                }
              
               
            
            }else{
                // var_dump(I());
                 
                 $sql=M('xiangmu')->find(I('id'));
                $this->assign('v', $sql);
                 // var_dump($sql);  
                 $this->display();

            }

        

          
        

    }


     public function zsedit(){
         // $this->display(); 
        if(IS_POST){
               // var_dump($_POST);
            
         
              

               if(empty($_POST['xiaoyi']) ){
                    echo '<script>alert("修改失败：请填写总收益");history.go(-1)</script>';die;
               }  

                // var_dump(I());die;

                $arr=M('xiangmu')->find($_POST['id']); 
                // var_dump($arr);die;
                $a['bili']=$_POST['xiaoyi']/$arr['yitouzi'];
                $a['xiaoyi']=$_POST['xiaoyi'];
                $a['xiangmu_id']=$_POST['id'];
                // var_dump($a);die;

                 $zong['xiangmu_id']=$_POST['id'];
                  $zong['zongshouyi']=$arr['xiaoyi'];
                  // $zong['time']=date('Y-m-d');
                   $fb=M('zongshouyi')->where($zong)->select();
                 
                   // var_dump( $fb);die;
                   foreach ($fb as $k => $v) {
                      $stat[]=substr($v['time'],0,10);
                     
                   }
                      $ss=in_array(date('Y-m-d'),$stat);
                    if($ss==true){
                            echo '<script>alert("今天收益已发布，请明天再来");location.href="edu"</script>';die;
                        }
                  // var_dump($fb);die;
                $sql=M('xiangmu')->save($a);
                 if ($sql> 0){
                    echo '<script>alert("修改成功");location.href="edu"</script>';
                } else {
                    echo '<script>alert("修改失败,无更改");history.go(-1)</script>';
                }
              
               
            
            }else{
                // var_dump(I());
                 
                 $sql=M('xiangmu')->find(I('id'));
                 // var_dump($sql);die;
                 if($sql['edu']==0){
                     echo '<script>alert("该项目未满额，无法修改收益");history.go(-1)</script>';die;
                 }else{
                  $this->assign('v', $sql);
                  
                 $this->display();

                 }
                  
            }

        

          
        

    }


    public function yiedit(){
         if(IS_POST){
           $arr=M('xiangmu')->save(I());
           if($arr>0){
               echo '<script>alert("修改成功");location.href="edu"</script>';
           }else{
               echo '<script>alert("修改失败,无更改");history.go(-1)</script>';die;
           }
         }

        $v=M('xiangmu')->find(I('id'));
          $this->assign('v', $v);     
        $this->display();  
    }

    
    


}
