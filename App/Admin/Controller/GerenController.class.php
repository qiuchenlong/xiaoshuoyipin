<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class GerenController extends CommonController {

  public function gong(){
      $model =M("jieqi_system_users");

       


            $dai['uid']=session('user_id');
            $arr=M('gongzhonghao')->where($dai)->find();

            

             // var_dump($arr);die;
            //分配数据
          
            $this->assign('v',$arr);         //用户
             
            $this->display();   
        
     
    }
    public function gongzhonghao(){
      $model =M("jieqi_system_users");

        if(IS_POST){
            //查询
            $u['uid']=I('uid');
            $add=M('gongzhonghao')->where($u)->save(I());
            if($add>0){
              echo '<script>alert("修改成功");location.href="gong"</script>';
            }else{
              echo '<script>alert("修改失败");location.href="gong"</script>';
            }
          } else{  


            $dai['uid']=session('user_id');
            $arr=M('gongzhonghao')->where($dai)->find();

            

             // var_dump($arr);die;
            //分配数据
          }
            $this->assign('v',$arr);         //用户
             
            $this->display();   
        
     
    }

    public function gongjie(){
      $model =M("jieqi_system_users");

        $model =M("jieqi_system_users");

       

            $dai['uid']=session('user_id');
            $arr=M('gongzhonghao')->where($dai)->find();

            

             // var_dump($arr);die;
            //分配数据
          
            $this->assign('v',$arr);         //用户
             
            $this->display();   
         
        
     
    }


     public function gongzhongjiekou(){
      $model =M("jieqi_system_users");

        $model =M("jieqi_system_users");

        if(IS_POST){
            //查询
            $u['uid']=I('uid');
            $add=M('gongzhonghao')->where($u)->save(I());
            if($add>0){
              echo '<script>alert("修改成功");window.parent.location.reload()</script>';
            }else{
              echo '<script>alert("修改失败");history.go(-1)</script>';
            }
          } else{  


            $dai['uid']=session('user_id');
            $arr=M('gongzhonghao')->where($dai)->find();

            

             // var_dump($arr);die;
            //分配数据
          }
            $this->assign('v',$arr);         //用户
             
            $this->display();   
         
        
     
    }

   
     public function jiesuan()
    {

      //代理商月结
      $u['uid']=session('user_id');
      $arr=M('dai_jiesuan')->where($u)->select();
      foreach ($arr as $k => $v) {
        $user=M('jieqi_system_users')->find($v['uid']);
        $arr[$k]['name']=$user['uname'];
        $arr[$k]['bili']=$user['yongjin'].'%';
        $arr[$k]['jiesuan']=$user['yongjin']*0.01*$v['money'];
        $chong[]=$v['money'];
        $bi[]=$v['num'];
        $jie[]=$v['money'];
        if($v['lei']==0){
          $wei[]=$v['money'];
        }else{
          $yi[]=$v['money'];
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
            // if(empty($_POST['uname']) | empty($_POST['name'])  | empty($_POST['email']) ){
            //         echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
            //      }

                  //查询小说章节
          $lianjie=I('lianjie');
          $qie=explode('&',$lianjie);
          $shu=explode('=',$qie[0]);
          $jie=explode('=',$qie[1]);
          $xiaoshuo=M('jieqi_article_article')->find($shu[1]);
          $zhang['chapterid']=$jie[1];
          $zhangjie=M('jieqi_article_chapter')->where($zhang)->find();
          $rukou=$xiaoshuo['articlename'].'**'.$zhangjie['chaptername'];

            //上传图片
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt');// 设置附件上传类型
                $upload->rootPath  =     'Public/tuierweima/'; // 设置附件上传根目录
                $upload->savePath  =     ''; // 设置附件上传（子）目录
                 // 上传文件 
                $info   =   $upload->upload();
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError()); die;
                }else{// 上传成功
                    // $this->success('上传成功！'); 
                    $b='tuierweima/'.$info['images']['savename'];
                }
          $add['id']=I('id');      
          $add['uid']=I('uid');
          $add['gongzhong']=I('gongzhong');
          $add['lianjie']=I('lianjie');
          $add['wenan']=I('wenan');
          $add['images']=$b;
          $add['xiaoshuo']=$xiaoshuo['articlename'];
          $add['zhangjie']=$zhangjie['chaptername'];
            // var_dump($add);die;
          $info=M('tuiguang')->save($add);
          if($info>0){
              echo '<script>alert("修改成功");window.parent.location.reload()</script>';die;
          }
               
        }else{
            $a=$_GET['id'];
           $v=M('tuiguang')->find($a);
           $this->assign('v',$v);
           $this->display();  
        }
    }
    
     public function del(){
        // var_dump(I());die;
        $id=$_GET['id'];
        $arr=M('tuiguang')->delete($id);
        if($arr>0){
           
                echo '<script>alert("删除成功");location.href="tuiguang"</script>';
            

          
        }
    }


    public function tuiguang()
    { 

       $u['uid']=session('user_id');
     
        $arr=M('tuiguang')->where($u)->select();

        $this->assign('arr',$arr);
        $this->display(); 
     
     $this->display();  
    }

    public function tgadd()
    {
      $u['uid']=session('user_id');
      // var_dump($u);die;
      $gong=M('gongzhonghao')->where($u)->find();
      if($gong['nicheng']==null){
         echo '<script>alert("请先设置公众号");window.parent.location.reload()</script>';die;
      }

      if(IS_POST){
           //查询小说章节
          $lianjie=I('lianjie');
          $qie=explode('&',$lianjie);
          $shu=explode('=',$qie[0]);
          $jie=explode('=',$qie[1]);
          $xiaoshuo=M('jieqi_article_article')->find($shu[1]);
          $zhang['chapterid']=$jie[1];
          $zhangjie=M('jieqi_article_chapter')->where($zhang)->find();
          $rukou=$xiaoshuo['articlename'].'**'.$zhangjie['chaptername'];

            //上传图片
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt');// 设置附件上传类型
                $upload->rootPath  =     'Public/tuierweima/'; // 设置附件上传根目录
                $upload->savePath  =     ''; // 设置附件上传（子）目录
                 // 上传文件 
                $info   =   $upload->upload();
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError()); die;
                }else{// 上传成功
                    // $this->success('上传成功！'); 
                    $b='tuierweima/'.$info['images']['savename'];
                }

          $add['uid']=I('uid');
          $add['gongzhong']=I('gongzhong');
          $add['lianjie']=I('lianjie');
          $add['wenan']=I('wenan');
          $add['images']=$b;
          $add['xiaoshuo']=$xiaoshuo['articlename'];
          $add['zhangjie']=$zhangjie['chaptername'];

          $info=M('tuiguang')->add($add);
          if($info>0){
              echo '<script>alert("添加成功");window.parent.location.reload()</script>';die;
          }
        }

      
      $this->assign('gg',$gong['nicheng']);     //公众号
     
     $this->display(); 
    }

    public function erweima()
    {
      $v=M('tuiguang')->find(I('id'));
      $this->assign('v',$v);
      $this->display(); 
    }

    public function mima()
    {

      if(IS_POST){
        if(I('mima')!==I('xinmima')){
          echo '<script>alert("两次密码不一样");history.go(-1)</script>';die;
        }

        $u['uid']=session('user_id');
        $u['pass']=I('mima');
        $arr=M('jieqi_system_users')->save($u);

        if($arr>0){
          echo '<script>alert("修改成功");window.parent.location.reload()</script>';
        }else{
          echo '<script>alert("密码无更改");history.go(-1)</script>';die;
        }
      }

      $v=M('jieqi_system_users')->find(session('user_id'));
      $this->assign('v',$v);
      $this->display(); 
    }
}