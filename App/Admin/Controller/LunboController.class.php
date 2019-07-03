<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');

/**
 * Class LunboController
 * @package Admin\Controller
 * new_ad 轮播图及广告图
 * book_ad 书籍广告
 * dudj修改
 */
class LunboController extends CommonController {
    //系统表
    public function index(){
            $a['path']=0;
            //查询数据并分页
            $model =M("new_ad");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,7); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            $btn = $page->show();
            foreach ($arr as $k => $v) {
                if($v['gotos']==0){
                    $arr[$k]['gotos']='书籍';
                }else if($v['gotos']==1){
                    $arr[$k]['gotos']='广告';
                }else{
                    $arr[$k]['gotos']='网站';
                }
            }
            //分配数据
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
    }
    /**
     * 阅读广告管理 列表
     */
    public function bookad(){
        $a['path']=0;
        //查询数据并分页
        $model =M("book_ad");
        //查出总条数
        $count = $model->count();
        //引入分页类
        $page = new \Think\Page($count,7); //传入一个总条数，和每页显示的条数
        //引入数据
        $arr = $model->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        //分页
        $btn = $page->show();
        foreach ($arr as $k => $v) {
            if($v['gotos']==0){
                $arr[$k]['gotos']='书籍';
            }else if($v['gotos']==1){
                $arr[$k]['gotos']='广告';
            }else{
                $arr[$k]['gotos']='网站';
            }
        }
        //分配数据
        $this->assign('arr',$arr);          //用户
        $this->assign('btn',$btn);          //分页
        $this->assign('shu',$count);        //总条数
        $this->display();
    }
    public function hengtu(){
        $a['path']=1;
        //查询数据并分页
        $model =M("new_ad");
        //查出总条数
        $count = $model->count();
        //引入分页类
        $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
        //引入数据
        $arr = $model->where($a)->limit($page->firstRow.','.$page->listRows)->select();
        //分页
        $btn = $page->show();
        foreach ($arr as $k => $v) {
            if($v['gotos']==0){
                $arr[$k]['gotos']='书籍';
            }else if($v['gotos']==1){
                $arr[$k]['gotos']='广告';
            }else{
                $arr[$k]['gotos']='网站';
            }
        }
        //分配数据
        $this->assign('arr',$arr);          //用户
        $this->assign('btn',$btn);          //分页
        $this->assign('shu',$count);        //总条数
        $this->display();
    }
    /**
     * 修改轮播图(焦点图)
     */
    public function edit(){
        if(IS_POST){
            if(empty($_POST['title'])  |empty($_POST['content'])){
                echo '<script>alert("修改失败：请填写完整的资料");history.go(-1)</script>';die;
            }
            //上传图片
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     'Public/uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传文件
            if(I('images')>0){
                $info   =   $upload->upload();
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError()); die;
                }else{// 上传成功
                    // $this->success('上传成功！'); 
                    $b='uploads/'.$info['images']['savename'];
                }  
                $a['images']=$b;
            }
            $a['id']=$_POST['id'];
            $a['title']=$_POST['title'];
            $a['content']=$_POST['content'];
            $a['weburl']=$_POST['weburl'];
            $a['gotos']=$_POST['gotos'];
            $a['path']=$_POST['path'];
            $sql=M('new_ad')->save($a);
            if ($sql> 0){
                echo '<script>alert("修改成功");window.parent.location.reload();</script>';
            } else {
                echo '<script>alert("修改失败,无更改");history.go(-1)</script>';
            }
        }else{
            $sql=M('new_ad')->find(I('id'));
            $this->assign('v', $sql);
            $this->display();
        }
    }
    //修改横图
    public function htedit(){
        if(IS_POST){
           if(empty($_POST['title'])  |empty($_POST['content']) | empty($_POST['weburl'])
            ){
                echo '<script>alert("修改失败：请填写完整的资料");history.go(-1)</script>';die;
             }
             //上传图片
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     'Public/uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
             // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError()); die;
            }else{// 上传成功
                // $this->success('上传成功！');
                $b='uploads/'.$info['images']['savename'];
            }
            $a['id']=$_POST['id'];
             $a['title']=$_POST['title'];
            $a['content']=$_POST['content'];
            $a['weburl']=$_POST['weburl'];
            $a['gotos']=$_POST['gotos'];
            $a['images']=$b;
            // var_dump($a);die;
            $sql=M('new_ad')->save($a);
             if ($sql> 0){
                echo '<script>alert("修改成功");location.href="hengtu"</script>';
            } else {
                echo '<script>alert("修改失败,无更改");history.go(-1)</script>';
            }
        }else{
             $sql=M('new_ad')->find(I('id'));
            $this->assign('v', $sql);
             $this->display();
        }
    }

    /**
     * 删除焦点图
     */
     public function del(){
        $id=$_GET['id'];
        $arr=M('new_ad')->delete($id);
        if($arr>0){
           echo '<script>alert("删除成功");location.href="index"</script>';
        }
    }
    /**
     * 删除横图
     */
    public function htdel(){
        $id=$_GET['id'];
        $arr=M('new_ad')->delete($id);
        if($arr>0){
           echo '<script>alert("删除成功");location.href="hengtu"</script>';
        }
    }
    /**
     * 添加轮播图
     */
    public function add(){
        if(IS_POST){
             //上传图片
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     'Public/uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
             // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                echo '<script>alert("'.$upload->getError().'");history.go(-1)</script>';
            }else{// 上传成功
                $b='uploads/'.$info['images']['savename'];
            }
            $a['title']=$_POST['title'];
            $a['path']=$_POST['path'];
            $a['content']=$_POST['content'];
            $a['weburl']=$_POST['weburl'];
            $a['bookid']=$_POST['acid'];
            $a['gotos']=$_POST['gotos'];
            $a['path']=$_POST['path'];
            $a['images']=$b;
            $sql=M('new_ad')->add($a);
            if ($sql> 0){
                echo '<script>alert("添加成功");window.parent.location.reload();</script>';
            } else {
                echo '<script>alert("添加失败");history.go(-1)</script>';
            }
        }else{
           $this->display();  
        }
    }

    /**
     * 添加阅读广告
     */
    public function addbookad(){
        if(IS_POST){
            $fenlei= array();
            $fenlei=$_POST['caid'];
            $fenleis="";
            if($fenlei != ""){
                foreach ($fenlei as $key => $value){
                    if($fenleis==""){
                        $fenleis=$value;
                        $sorts=$value;
                    }else{
                      $fenleis=$fenleis.",".$value;
                    }
                }
            }
            //上传图片
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     'Public/uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
             // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                echo '<script>alert("'.$upload->getError().'");history.go(-1)</script>';
            }else{// 上传成功
                // $this->success('上传成功！');
                $b='uploads/'.$info['images']['savename'];
            }
            $a['title'] = $_POST['title'];
            $a['path'] = $_POST['path'];
            $a['content'] = $_POST['content'];
            $a['weburl'] = $_POST['weburl'];
            $a['bookid'] = $fenleis;
            $a['gotos'] = $_POST['gotos'];
            $a['path'] = $_POST['path'];
            $a['images'] = $b;
            $sql=M('book_ad')->add($a);
             if ($sql> 0){
                echo '<script>alert("添加成功");window.parent.location.reload();</script>';
            } else {
                echo '<script>alert("添加失败");history.go(-1)</script>';
            }
        }else{
           $this->display();  
        }
    }

    /**
     *获取文章的地址
     */
     public function dizhi(){
         if(!empty(I('id'))){
             $con=I('id');
             $data['articlename|author'] = array('like', "%$con%");
             $shu=M('jieqi_article_article')->where($data)->find();
             if($shu==null){
                 $this->ajaxReturn(null);
              } else{
                 $this->ajaxReturn($shu);
              }
         }else{
             $this->ajaxReturn(null);
         }
    }
    /**
     * 修改阅读广告图
     */
    public function editbookad(){
        if(IS_POST){
            if(empty($_POST['title'])  |empty($_POST['content'])){
                echo '<script>alert("修改失败：请填写完整的资料");history.go(-1)</script>';die;
            }
            //上传图片
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     'Public/uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传文件
            if(I('images')>0){
                $info   =   $upload->upload();
                if(!$info) {// 上传错误提示错误信息
                    exit('<script>alert("'.$upload->getError().'");history.go(-1)</script>');
                }else{// 上传成功
                    // $this->success('上传成功！');
                    $b='uploads/'.$info['images']['savename'];
                }
                $_POST['images']=$b;
            }
            $res = M('book_ad')->save($_POST);
            if ($res> 0){
                exit('<script>alert("修改成功");window.parent.location.reload();</script>');
            } else {
                exit('<script>alert("修改失败,无更改");history.go(-1)</script>');
            }
        }else{
            $data = M('book_ad')->find(I('id'));
            $this->assign('data', $data);
            $this->display();
        }
    }
    /**
     * 删除阅读广告图
     */
    public function deletebookad(){
        $id = I('id');
        if(isset($id) && $id > 0){
            $arr = M('book_ad')->delete($id);
            if($arr>0){
                echo '<script>alert("删除成功");location.href="bookad"</script>';
            }else{
                echo '<script>alert("'.M('book_ad')->getError().'");history.go(-1)</script>';
            }
        }else{
            echo '<script>alert("删除错误");history.go(-1)</script>';
        }
    }
}
