<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class SousuoController extends CommonController 
{
	public function index()
	{
		$model =M("jieqi_article_searchcache");
        $a['types']=1;
            //查出总条数 
            $count = $model->where($a)->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($a)->order('cacheid desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            // var_dump($info);die;
            //分配数据
           
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
            
	}

	public function del(){
        // var_dump(I());die;
        $id=$_GET['id'];
        $arr=M('jieqi_article_searchcache')->delete($id);
        if($arr>0){
           
                echo '<script>alert("删除成功");location.href="index"</script>';
        
        }
    }


    public function add()
    {
        
        if(IS_POST){
            // var_dump(I());die;
            $a['keywords']=I('keywords');
            $a['types']=1;
            $a['hashid']=time();
            $sql=M('jieqi_article_searchcache')->add($a);

            if ($sql> 0){
                echo '<script>alert("添加成功");window.parent.location.reload()</script>';
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
                 // var_dump(I());die;
               
             
                $sql=M('jieqi_article_searchcache')->save($_POST);
                 if ($sql> 0){
                   
                            echo '<script>alert("修改成功");window.parent.location.reload()</script>';  
                    
                } else {

                    echo '<script>alert("修改失败");history.go(-1)</script>';
                }
              
        }else{

         
            $arr=M("jieqi_article_searchcache")->find(I('id'));

             $this->assign('v',$arr);
               // var_dump($arr);
           
           $this->display();  
        }
    }
}