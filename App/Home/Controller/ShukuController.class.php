<?php
namespace Home\Controller;
use Think\Controller;
class ShukuController extends Controller {


	//女频
    public function index(){
            $a['layer']=0;
            $a['types']=1;
            $b['types']=1;
            //查询数据并分页
            $model =M("jieqi_article_sort");
       
            $arr = $model->where($a)->order('sortid asc')->limit(0,4)->select();
            //分页
            
          

            $info=$model->where($a)->order('sortid asc')->limit(4,5)->select();

            

            // var_dump($info);die;
            //分配数据
            $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
        
        
      
    }


    //男频
    public function nan(){
        $a['layer']=0;
            $a['types']=2;
            $b['types']=1;
            //查询数据并分页
            $model =M("jieqi_article_sort");
       
            $arr = $model->where($a)->order('sortid asc')->limit(0,4)->select();
            //分页
            
          

            $info=$model->where($a)->order('sortid asc')->limit(4,5)->select();

            

            // var_dump($info);die;
            //分配数据
            $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
    }

    //出版
    public function chuban(){
        $a['layer']=0;
            $a['types']=3;
            $b['types']=1;
            //查询数据并分页
            $model =M("jieqi_article_sort");
       
            $arr = $model->where($a)->order('sortid asc')->limit(0,4)->select();
            //分页
            
          

            $info=$model->where($a)->order('sortid asc')->limit(4,5)->select();

            

            // var_dump($info);die;
            //分配数据
            $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
    }


     //免费
    public function mianfei(){
      $a['layer']=0;
            $a['types']=4;
            $b['types']=1;
            //查询数据并分页
            $model =M("jieqi_article_sort");
       
            $arr = $model->where($a)->order('sortid asc')->limit(0,4)->select();
            //分页
            
          

            $info=$model->where($a)->order('sortid asc')->limit(4,5)->select();

            

            // var_dump($info);die;
            //分配数据
            $this->assign('info',$info);
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
    }


    //书单
    public function BookSelection(){

        //查询数据并分页
            $model =M("new_shudan");
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


     //分类
    public function fenlei(){
      $Model = M('');  
      if($_GET['fenlei']!="" || $_GET['zishu']!="" || $_GET['paixu']!=""){
        
            $a['layer']=I('id');
            $erji=M('jieqi_article_sort')->where($a)->select();
            foreach ($erji as $key => $value) {
                $erji[$key]['fenleis']=$_GET['fenlei'];
            }
            $where=" where t.sortid !=0";
            if($_GET['fenlei']!=""){
              $where=$where." and t.sortid =".$_GET['fenlei']."";
            }
          
            if($_GET['zishu']!=""){
                    
                     if($_GET['zishu']=="1")
                       {
                    $where.=" and t.size <=600000";
                      }
                      else if($_GET['zishu']=="2")
                       {
                    $where.=" and t.size <=2000000 and t.size >6000000";
                      }
                      else if($_GET['zishu']=="3")
                       {
                    $where.=" and t.size >2000000";
                      }
            }


            if($_GET['paixu']!=""){
                if($_GET['paixu']=="1"){
                   $where.=" and t.articletype !=3";
                }
                if($_GET['paixu']=="2"){
                 $where.=" and t.articletype =3";
                }
             }
        
   
            $xiaoshuo = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid  ".$where." limit 0,40;");
            foreach ($xiaoshuo as $key => $value) {
               $a=$value['size']/20;
              $xiaoshuo[$key]['size']=round($a,1);
            }

              // var_dump($erji);
             $this->assign('erji',$erji); 
             $this->assign('id',I('id'));    
             $this->assign('fenlei',I('fenlei'));
             $this->assign('zishu',I('zishu'));
             $this->assign('paixu',I('paixu'));            
             $this->assign('xiaoshuo',$xiaoshuo);           //二级分类  
            $this->display();   
            



      }else{
        $a['layer']=I('id');
        $erji=M('jieqi_article_sort')->where($a)->select();

        $sortid= $erji[0]['sortid'];
        $xiaoshuo = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.sortid=".$sortid." limit 0,6;");
           foreach ($xiaoshuo as $key => $value) {
               $a=$value['size']/20;
              $xiaoshuo[$key]['size']=round($a,1);
            }

               $this->assign('erji',$erji); 
               $this->assign('id',I('id'));            //二级分类     
               $this->assign('xiaoshuo',$xiaoshuo);           //二级分类  
              $this->display();   
            
          
     }
          

      
      
    }

   
    
}