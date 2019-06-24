<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class ReciController extends CommonController {
    public function index(){
      $model =M("jieqi_article_searchcache");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            foreach ($arr as $k => $v) {
              if($v['types']==0){
                $arr[$k]['types']='用户搜索';
              }else{
                $arr[$k]['types']='系统设置';
              }
            }

            // var_dump($info);die;
            //分配数据
           
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
                echo '<script>alert("充值成功");location.href="index"</script>';
             }
           }
      
            $this->display();   
        
     
    }


    public function add(){
        if(IS_POST){
            // var_dump(I());
            if(empty($_POST['keywords']) ){
                    echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
                 }

                 $add['keywords']=$_POST['keywords'];
                 $add['types']=$_POST['types'];
                 $add['hashid']=time();
                $sql=M('jieqi_article_searchcache')->add($add);

                 if ($sql> 0){
                    echo '<script>alert("添加成功");location.href="index"</script>';
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
            if(empty($_POST['keywords']) ){
                    echo '<script>alert("添加失败：请填写完整信息");history.go(-1)</script>';die;
                 }

                 
                  
                $sql=M('jieqi_article_searchcache')->save($_POST);
                 if ($sql> 0){
                    echo '<script>alert("修改成功");location.href="index"</script>';
                } else {
                    echo '<script>alert("用户信息无更改");history.go(-1)</script>';
                }
              
               
        }else{
            $a=$_GET['id'];
           $v=M('jieqi_article_searchcache')->find($a);
           $this->assign('v',$v);
           $this->display();  
        }
    }
      
    
     public function del(){
        // var_dump(I());die;
        $id=$_GET['id'];
        $arr=M('jieqi_article_searchcache')->delete($id);
        if($arr>0){
           
                echo '<script>alert("删除成功");location.href="index"</script>';
            

          
        }
    }

}