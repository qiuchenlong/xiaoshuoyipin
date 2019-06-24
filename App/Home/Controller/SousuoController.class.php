<?php
namespace Home\Controller;
use Think\Controller;
class SousuoController extends Controller {


	//搜索主页
    public function index(){

      //大家都在搜
        $model =M("jieqi_article_searchcache");
        $a['types']=1;

        $count = $model->where($a)->count();
        $f=$count-2;
        if(empty(I('page'))){
          $b=0;
          $c=2;
        }else{
          $b=rand(0,$f);
          $c=2;
        }

        $arr = $model->where($a)->order('cacheid desc')->limit($b,$c)->select();

        $gg['user_id']=10;
        $gg['types']=0;
       //搜索历史
       $sql =  $model->where($gg)->order('cacheid  desc')->limit(0,3)->select();
         
      //热搜Top榜
       $info = M('jieqi_article_article')->order('allvisit desc')->limit(0,5)->select();
            

          
           
          $this->assign('arr',$arr);        
          $this->assign('info',$info);
          $this->assign('sql',$sql);  
          
       $this->display();
    }


   //搜索结果
    public function resou(){
      if(IS_POST){
             $con=I('lei');
            $data['articlename|author'] = array('like', "%$con%");
            $arr=M('jieqi_article_article')->where($data)->select();

        foreach ($arr as $k => $v) {
          $a=$v['size']/20;
          $arr[$k]['size']=round($a,1);
          $leixin=M('jieqi_article_sort')->find($v['sortid']);
          $arr[$k]['sortid']=$leixin['caption'];
        }

      }

      if(!empty(I('name'))){
            $con=I('name');
            $data['articlename'] = array('like', "%$con%");
            $arr=M('jieqi_article_article')->where($data)->select();

        foreach ($arr as $k => $v) {
          $a=$v['size']/20;
          $arr[$k]['size']=round($a,1);
          $leixin=M('jieqi_article_sort')->find($v['sortid']);
          $arr[$k]['sortid']=$leixin['caption'];
        }

      
      }



       $this->assign('arr',$arr);
       $this->display();
    }



    
}