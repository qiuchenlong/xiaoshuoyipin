<?php
namespace Home\Controller;
use Think\Controller;
class ShujiaController extends Controller {


	//书架
    public function index(){
      
       //  if(!session("user_id")){

       //   echo '<script>window.location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/s.php"</script>';exit();
       // }

      $u['userid']=session("user_id");
      $u['flag']=0;
      $arr=M('jieqi_article_bookcase')->where($u)->select();
      foreach ($arr as $k => $v) {
       
        $info[]=M('jieqi_article_article')->find($v['articleid']);
        $info[$k]['caseid']=$v['caseid'];
      }
        // var_dump($info);
         $this->assign('arr',$arr);
          $this->assign('info',$info);
       $this->display();
    }


  

    
}