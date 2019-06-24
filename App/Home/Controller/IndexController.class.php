<?php
namespace Home\Controller;
use Think\Controller;
header("content-type:text/html;charset=utf-8"); 
// Header("Content-type: application/octet-stream");
// Header("Accept-Ranges: bytes");
header("Access-Control-Allow-Origin: *");
class IndexController extends Controller {

   //删除历史记录

    public function shanchuhis()
    {      


        $id=$_GET['id'];
        $arr=M('jieqi_article_bookcase')->delete($id);
        if($arr>0){
            echo '<script>window.history.go(-1);</script>';
        }

    }
    //女频
    public function index(){
        /*  Vendor('payssion-php-master.lib.PayssionClient');
          $payssion= new PayssionClient('live_d405958aac043b70','86557e07fd31754665b9c96e13d173f7'); 
        如果您使用sandbox api_key 
        $ payssion = new PayssionClient（'your api key'，'your secretkey'，false），请取消注释以下内容;
        var_dump($payssion);die;
        $response=null; 
        try{
        $response=$payssion->create(array('amount'=>1,'currency'=>'USD','pm_id'=>'cashu','order_id'=>'163','return_url'=>'http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/User/chong_zhi.html')); 
        }catch($e){
         //处理异常回显“异常：”。
          $e->getMessage();
        }  
             


        if（$payssion->isSuccess(){ 
          echo '<script>alert("处理成功");location.href="index"<script>';die;
        }else{
          echo '<script>alert("处理失败");location.href="index"<script>';die;
        }  


        $_SESSION['user_id']=88;*/
            if($_GET['userid']){
            $_SESSION['uid']=$_GET['userid'];
          
        }

        $Model = M('');
        $data = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=1 order by paixu limit 2,7 ");

        $data1 = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=1 order by paixu limit 0,1 ");

        $data2 = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=1 order by paixu limit 1,1 ");

        $datasum = $Model->Query("SELECT COUNT(*) AS count FROM jieqi_article_article  where biaoqian like '%".$data[0]['id']."%' ");
     
        $data1sum = $Model->Query("SELECT COUNT(*) AS count FROM jieqi_article_article  where biaoqian like '%".$data1[0]['id']."%' ");

        $data2sum = $Model->Query("SELECT COUNT(*) AS count FROM jieqi_article_article  where biaoqian like '%".$data2[0]['id']."%' ");
          
        $zongshu=$datasum[0]['count'];
        $zongshu1=$datasum1[0]['count'];
        $zongshu2=$datasum2[0]['count'];
        $kai=rand(0,$zongshu);
        $kai1=rand(0,$zongshu1);
        $kai2=rand(0,$zongshu2);

        $xiaoshu1 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$data1[0]['id']."%' limit $kai1,300000;");

        $sum = count($xiaoshu1);

        $arr = [];
        $container = [];
        if($sum >= 3){
            for ($i=0; $i < 3; $i++) { 
                $num = mt_rand(0,$sum-1);

                if(!in_array($num,$arr)){
                    $arr[] = $num;
                }else{
                    $i--;
                }
            }
            foreach ($arr as $v) {
                $container[] = $xiaoshu1[$v];
            }
            $xiaoshu1 = $container;
        }

        $data1[0]['xiaoshuo']=$xiaoshu1;
        $xiaoshu2 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$data2[0]['id']."%' limit $kai2,600000;");

        $sum = count($xiaoshu2);

        $arr = [];
        $container = [];
        if($sum >= 6){
            for ($i=0; $i < 6; $i++) { 
                $num = mt_rand(0,$sum-1);

                if(!in_array($num,$arr)){
                    $arr[] = $num;
                }else{
                    $i--;
                }
            }
            foreach ($arr as $v) {
                $container[] = $xiaoshu2[$v];
            }
            $xiaoshu2 = $container;
        }

        $data2[0]['xiaoshuo']=$xiaoshu2;

        //$ad = $Model->Query("SELECT * FROM new_ad  where `path`=".$pindao." order by sort  ");


        //$data['ad']=$ad;
        foreach ($data as $key => $value) {
            $xiaoshu = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$value['id']."%';");

            $sum = count($xiaoshu);

            $arr = [];
            $container = [];
            if($sum >= 4){
                for ($i=0; $i < 4; $i++) { 
                    $num = mt_rand(0,$sum-1);

                    if(!in_array($num,$arr)){
                        $arr[] = $num;
                    }else{
                        $i--;
                    }
                }
                foreach ($arr as $v) {
                    $container[] = $xiaoshu[$v];
                }
                $xiaoshu = $container;
            }

            $xiaoshu3 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$value['id']."%';");

            $sum = count($xiaoshu3);

            $arr = [];
            $container = [];
            if($sum >= 3){
                for ($i=0; $i < 3; $i++) { 
                    $num = mt_rand(0,$sum-1);

                    if(!in_array($num,$arr)){
                        $arr[] = $num;
                    }else{
                        $i--;
                    }
                }
                foreach ($arr as $v) {
                    $container[] = $xiaoshu3[$v];
                }
                $xiaoshu3 = $container;
            }

            $data[$key]['xiaoshuo1']=$xiaoshu;
            $data[$key]['xiaoshuo2']=$xiaoshu3;    
        }

        $lunbo = $Model->Query("SELECT * FROM new_ad  where `path`=1 order by sort  ");

        $this->assign('xiaoshuo1',$data1[0]); 
        $this->assign('xiaoshuo2',$data2[0]); 
        $this->assign('xiaoshuo',$data); 
        $this->assign('lunbo',$lunbo); 
        $this->display();
    }


    //广告详情
    public function guanggao(){
        $Model = M('');
        $id=$_GET['id'];
        $lunbo = $Model->Query("SELECT * FROM new_ad  where id=".$id."  ");

        $this->assign('guanggao',$lunbo[0]); 
        $this->display();
    }


    //男频
    public function index_male()
    {
        $Model = M('');
        $data = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=2 order by paixu limit 2,7 ");

        $data1 = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=2 order by paixu limit 0,1 ");

        $data2 = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=2 order by paixu limit 1,1 ");

        $xiaoshu1 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$data1[0]['id']."%';");

        $sum = count($xiaoshu1);

        $arr = [];
        $container = [];
        if($sum >= 3){
            for ($i=0; $i < 3; $i++) { 
                $num = mt_rand(0,$sum-1);

                if(!in_array($num,$arr)){
                    $arr[] = $num;
                }else{
                    $i--;
                }
            }
            foreach ($arr as $v) {
                $container[] = $xiaoshu1[$v];
            }
            $xiaoshu1 = $container;
        }


        $data1[0]['xiaoshuo']=$xiaoshu1;


        $xiaoshu2 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$data2[0]['id']."%';");

        $sum = count($xiaoshu2);

        $arr = [];
        $container = [];
        if($sum >= 6){
            for ($i=0; $i < 6; $i++) { 
                $num = mt_rand(0,$sum-1);

                if(!in_array($num,$arr)){
                    $arr[] = $num;
                }else{
                    $i--;
                }
            }
            foreach ($arr as $v) {
                $container[] = $xiaoshu2[$v];
            }
            $xiaoshu2 = $container;
        }     

        $data2[0]['xiaoshuo']=$xiaoshu2;



        //$ad = $Model->Query("SELECT * FROM new_ad  where `path`=".$pindao." order by sort  ");


        //$data['ad']=$ad;
        foreach ($data as $key => $value) {
            $xiaoshu = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$value['id']."%';");

            $sum = count($xiaoshu);

            $arr = [];
            $container = [];
            if($sum >= 4){
                for ($i=0; $i < 4; $i++) { 
                    $num = mt_rand(0,$sum-1);

                    if(!in_array($num,$arr)){
                        $arr[] = $num;
                    }else{
                        $i--;
                    }
                }
                foreach ($arr as $v) {
                    $container[] = $xiaoshu[$v];
                }
                $xiaoshu = $container;
            }


            $xiaoshu3 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$value['id']."%' limit 4,1000000;");

            $sum = count($xiaoshu3);

            $arr = [];
            $container = [];
            if($sum >= 3){
                for ($i=0; $i < 3; $i++) { 
                    $num = mt_rand(0,$sum-1);

                    if(!in_array($num,$arr)){
                        $arr[] = $num;
                    }else{
                        $i--;
                    }
                }
                foreach ($arr as $v) {
                    $container[] = $xiaoshu3[$v];
                }
                $xiaoshu3 = $container;
            }            

            $data[$key]['xiaoshuo1']=$xiaoshu;
            $data[$key]['xiaoshuo2']=$xiaoshu3;
        }

        $lunbo = $Model->Query("SELECT * FROM new_ad  where `path`=2 order by sort  ");

        // $this->assign('max',$xiaoshu1); 
        $this->assign('xiaoshuo1',$data1[0]); 
        $this->assign('xiaoshuo2',$data2[0]); 
        $this->assign('xiaoshuo',$data); 
        $this->assign('lunbo',$lunbo); 
        $this->display();
    }

    //出版
    public function index_publish()
    {
        $Model = M('');
        $data = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=3 order by paixu limit 2,7 ");

        $data1 = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=3 order by paixu limit 0,1 ");

        $data2 = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=3 order by paixu limit 1,1 ");

        $xiaoshu1 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$data1[0]['id']."%';");

        $sum = count($xiaoshu1);

        $arr = [];
        $container = [];
        if($sum >= 3){
            for ($i=0; $i < 3; $i++) { 
                $num = mt_rand(0,$sum-1);

                if(!in_array($num,$arr)){
                    $arr[] = $num;
                }else{
                    $i--;
                }
            }
            foreach ($arr as $v) {
                $container[] = $xiaoshu1[$v];
            }
            $xiaoshu1 = $container;
        }

        $data1[0]['xiaoshuo']=$xiaoshu1;

        $xiaoshu2 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$data2[0]['id']."%';");

        $sum = count($xiaoshu2);

        $arr = [];
        $container = [];
        if($sum >= 6){
            for ($i=0; $i < 6; $i++) { 
                $num = mt_rand(0,$sum-1);

                if(!in_array($num,$arr)){
                    $arr[] = $num;
                }else{
                    $i--;
                }
            }
            foreach ($arr as $v) {
                $container[] = $xiaoshu2[$v];
            }
            $xiaoshu2 = $container;
        }

        $data2[0]['xiaoshuo']=$xiaoshu2;

        //$ad = $Model->Query("SELECT * FROM new_ad  where `path`=".$pindao." order by sort  ");


        //$data['ad']=$ad;
        foreach ($data as $key => $value) {
            $xiaoshu = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$value['id']."%';");

            $sum = count($xiaoshu);

            $arr = [];
            $container = [];
            if($sum >= 4){
                for ($i=0; $i < 4; $i++) { 
                    $num = mt_rand(0,$sum-1);

                    if(!in_array($num,$arr)){
                        $arr[] = $num;
                    }else{
                        $i--;
                    }
                }
                foreach ($arr as $v) {
                    $container[] = $xiaoshu[$v];
                }
                $xiaoshu = $container;
            }

            $xiaoshu3 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$value['id']."%' limit 4,300000;");

            $sum = count($xiaoshu3);

            $arr = [];
            $container = [];
            if($sum >= 3){
                for ($i=0; $i < 3; $i++) { 
                    $num = mt_rand(0,$sum-1);

                    if(!in_array($num,$arr)){
                        $arr[] = $num;
                    }else{
                        $i--;
                    }
                }
                foreach ($arr as $v) {
                    $container[] = $xiaoshu3[$v];
                }
                $xiaoshu3 = $container;
            }

            $data[$key]['xiaoshuo1']=$xiaoshu;
            $data[$key]['xiaoshuo2']=$xiaoshu3;
        }

        $lunbo = $Model->Query("SELECT * FROM new_ad  where `path`=3 order by sort  ");

        $this->assign('xiaoshuo1',$data1[0]); 
        $this->assign('xiaoshuo2',$data2[0]); 
        $this->assign('xiaoshuo',$data); 
        $this->assign('lunbo',$lunbo); 
        $this->display();
    }

    //免费
    public function index_gratis()
    {
        $Model = M('');
        $data = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=4 order by paixu limit 2,7 ");

        $data1 = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=4 order by paixu limit 0,1 ");

        $data2 = $Model->Query("SELECT * FROM jieqi_article_fenlei  where pindao=4 order by paixu limit 1,1 ");

        $xiaoshu1 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$data1[0]['id']."%';");

        $sum = count($xiaoshu1);

        $arr = [];
        $container = [];
        if($sum >= 3){
            for ($i=0; $i < 3; $i++) { 
                $num = mt_rand(0,$sum-1);

                if(!in_array($num,$arr)){
                    $arr[] = $num;
                }else{
                    $i--;
                }
            }
            foreach ($arr as $v) {
                $container[] = $xiaoshu1[$v];
            }
            $xiaoshu1 = $container;
        }

        $data1[0]['xiaoshuo']=$xiaoshu1;

        $xiaoshu2 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$data2[0]['id']."%';");

        $sum = count($xiaoshu2);

        $arr = [];
        $container = [];
        if($sum >= 6){
            for ($i=0; $i < 6; $i++) { 
                $num = mt_rand(0,$sum-1);

                if(!in_array($num,$arr)){
                    $arr[] = $num;
                }else{
                    $i--;
                }
            }
            foreach ($arr as $v) {
                $container[] = $xiaoshu2[$v];
            }
            $xiaoshu2 = $container;
        }

        $data2[0]['xiaoshuo']=$xiaoshu2;

        //$ad = $Model->Query("SELECT * FROM new_ad  where `path`=".$pindao." order by sort  ");


        //$data['ad']=$ad;
        foreach ($data as $key => $value) {
            $xiaoshu = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$value['id']."%';");

            $sum = count($xiaoshu);

            $arr = [];
            $container = [];
            if($sum >= 4){
                for ($i=0; $i < 4; $i++) { 
                    $num = mt_rand(0,$sum-1);

                    if(!in_array($num,$arr)){
                        $arr[] = $num;
                    }else{
                        $i--;
                    }
                }
                foreach ($arr as $v) {
                    $container[] = $xiaoshu[$v];
                }
                $xiaoshu = $container;
            }

            $xiaoshu3 = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$value['id']."%' limit 4,30000;");

            $sum = count($xiaoshu3);

            $arr = [];
            $container = [];
            if($sum >= 3){
                for ($i=0; $i < 3; $i++) { 
                    $num = mt_rand(0,$sum-1);

                    if(!in_array($num,$arr)){
                        $arr[] = $num;
                    }else{
                        $i--;
                    }
                }
                foreach ($arr as $v) {
                    $container[] = $xiaoshu3[$v];
                }
                $xiaoshu3 = $container;
            }

            $data[$key]['xiaoshuo1']=$xiaoshu;
            $data[$key]['xiaoshuo2']=$xiaoshu3;
        }

        $lunbo = $Model->Query("SELECT * FROM new_ad  where `path`=4 order by sort  ");

        $this->assign('xiaoshuo1',$data1[0]); 
        $this->assign('xiaoshuo2',$data2[0]); 
        $this->assign('xiaoshuo',$data); 
        $this->assign('lunbo',$lunbo); 
        $this->display();
    }

    //热搜
    public function resou()
    {
        $Model = M('');
        $id=$_GET['id'];
    

        $data = $Model->Query("SELECT t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.biaoqian like '%".$id."%' limit 0,100;");
        foreach ($data as $key => $value) {
               
               $a=$value['size']/20;
              $data[$key]['size']=round($a,1);
        }

        $this->assign('xiaoshuo',$data); 
        $this->display();
    }

    //书本详情
    public function dtail()
    {
        if($_GET['userid']){
            $_SESSION['uid']=$_GET['userid'];
            $_SESSION['bookid']=$_GET['id'];
        }

        //查询是否加入书架
        $cha['articleid']=I('id');
        $cha['flag']=0;
        $cha['userid']=session('user_id');
        $shujia=M('jieqi_article_bookcase')->where($cha)->find();

        //加入书架
        if(I('jia')==1){
            if(!session("user_id")){
                echo '<script>alert("请先登录");window.location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/Login/login_frame.html"</script>';exit();
            }

            $jshujia=M('jieqi_article_bookcase')->add($cha);

            if($jshujia>0){
                echo '<script>alert("书架加入成功");location.href="dtail.html?id='.I('id').'"</script>';
            }
        }
      
        // var_dump($shujia);die;
        //第一章
        $zhi['articleid']=I('id');
        $zhangi=M('jieqi_article_chapter')->where($zhi)->select();
       

        //大家都在看
        $le=M('jieqi_article_article')->find(I('id'));
        $si=strstr($le['biaoqian'],',');

        //书单的阅读量
        if(!empty(I('shudan'))){
            $shuli=M('new_shudan')->find(I('shudan'));
            $liu['id']=I('shudan');
            $liu['views']=$shuli['views']+1;
        
            $lian=M('new_shudan')->save($liu);
        }

        // if($si!==false){
        $lei=explode(",",$le['biaoqian']);  
        $con=$lei[0];
        $data['biaoqian'] = array('like', "%$con%");
        $data['articleid'] = array('neq', I('id'));
        $yezai=M('jieqi_article_article')->where($data)->order('articleid asc')->limit(0,4)->select();

        //书友还关注
        $guanzhu=M('jieqi_article_article')->where($data)->order('articleid desc')->limit(0,4)->select();

        $Model = M('');
        $id=$_GET['id'];

        $arr = $Model->Query("SELECT t.ffee,t1.shortname,t.images,t.authorid,t.author,t.keywords,t.lastchapter,t.lastupdate,t.articlename,t.saleprice,t.intro,t.articleid,t.size,t.sortid,t.duanping,t.allvisit,t.articletype FROM jieqi_article_article t inner join jieqi_article_sort t1 on t.sortid=t1.sortid where t.articleid = '".$id."' limit 0,1;");
        
           $arr[0]['diyi']=$zhangi[0]['chapterid'];
     
        // $arrs['articleid']=I('id');
        //  $arr=M('jieqi_article_article')->where($arrs)->order('articleid desc')->limit(0,1)->select();

        $a=$arr[0]['size']/20;
        $arr[0]['size']=round($a,1);

        //标签
        $sh=strstr($arr[0]['keywords'],',');
        if($sh!==false){
            $shu=explode(",",$arr[0]['keywords']);         
            foreach ($shu as $o => $p) {
                $bb=M('jieqi_article_fenlei')->find($p);
                $biao[$o]=$p;
            }  
        }else{
            $biaoqian=M('jieqi_article_fenlei')->find($arr['biaoqian']);
            $biao=$biaoqian['title'];
        }

        //评论
        $pp['aid']=I('id');
        $shu=M('new_reply')->where($pp)->order('id desc')->limit(0,2)->select();

        foreach ($shu as $kk => $vv) {
            // $u=M('jieqi_system_users')->find($vv['user_id']);
            // $shu[$kk]['name']=$u['name'];
            // // if($vv['xing']>5){
            // //   $vv['xing']=5;
            // // }
            if($vv['user_id']==null){
                $shu[$kk]['name']=$vv['jia'];   
            }else{
                $user=M('jieqi_system_users')->find($vv['user_id']);
                $shu[$kk]['name']=$user['name'];
            }
            $shu[$kk]['xing']=$vv['xing']*20;
        }

        //评论统计
        $renshu=M('new_reply')->where($pp)->count();
        $fenshu=M('new_reply')->where($pp)->select();

        foreach ($fenshu as $ke => $va) {
            $fe[]=$va['xing'];
        }

        $ff=array_sum($fe);  
        $fff= $ff*20/$renshu;

        //点赞
        if(!empty(I('dian'))){
            $lik=M('new_reply')->find(I('dian'));

            if(session('user_id')==null){
              echo '<script>alert("请先登录");history.go(-1)</script>';die;
            }
            $dian['uid']=session('user_id');
            $dian['pid']=$lik['id'];
            $zan=M('new_rdian')->where($dian)->find();
            if($zan>0){

            }else{
                M('new_rdian')->add($dian);
                $d['id']=I('dian');
                $d['likes']=$lik['likes']+1;
                $sql=M('new_reply')->save($d);

                if($sql>0){
                    echo '<script>location.href="dtail.html?id='.I('id').'&shujia=1"</script>';
                }
            }
        }


        // 可以购买的章节
        $id=I('id');
        $userid=session('user_id');
        $zhangjie = $Model->Query("SELECT COUNT(*) AS count  FROM jieqi_article_chapter where articleid=".$id.";");
        $zongshu=$zhangjie[0]['count'];//-$arr[0]['ffee'];
        $zhengshu=($zongshu/100);
        $arr[0]['zzhangjie']=$zongshu;
        $arr[0]['zongjia']=$zongshu*$arr[0]['saleprice']*0.85;
        $yushu=($zongshu%100);
        $jiage=(string)100*$data[0]['saleprice'];

        //组一下可以购买的章节
        $zj="";
        $shuzu='[';
        for ($i=1; $i <= $zhengshu; $i++) {

            $datas = $Model->Query("SELECT * FROM orders where aid='".$id."' and user_id='".$userid."' and path='".$i."' and state=1 ");

            if($datas){
                $mai='1';
            }else{
                $mai='0';
            }

            $jieshu1=($i-1)*100+1;
            $jieshu2=$i*100;

            if($i!=$zhengshu){
                $shuzu=$shuzu.'{"zj":'.$i.',"jiage":'.$jiage.',"mai":'.$mai.',"kaishi":'.$jieshu1.',"jieshu":'.$jieshu2.'},';
            }

            if($i==$zhengshu && $yushu==0){
                $shuzu=$shuzu.'{"zj":'.$i.',"jiage":'.$jiage.',"mai":'.$mai.',"kaishi":'.$jieshu1.',"jieshu":'.$jieshu2.'}]';
            }else if($i==$zhengshu && $yushu>0){
                $shuzu=$shuzu.'{"zj":'.$i.',"jiage":'.$jiage.',"mai":'.$mai.',"kaishi":'.$jieshu1.',"jieshu":'.$jieshu2.'},';
            } 
        } 

        if($yushu>0){
            $i=(string)$zhengshu;
            $datass = $Model->Query("SELECT * FROM orders where aid='".$id."' and user_id='".$userid."' and path='".$i."' and state=1 ");
            if($datass){
                $mai='1';
            }else{
                $mai='0';
            }
            $jieshu1=$i*100+1-$yushu;
            $jiages=(string)$yushu*$data[0]['saleprice'];
            $shuzu=$shuzu.'{"zj":'.$i.',"jiage":'.$jiages.',"mai":'.$mai.',"kaishi":'.$jieshu1.',"jieshu":'.$zongshu.'}]';
        }


        $zzj=json_decode($shuzu, true);
        // $zzjs=json_decode($zzj, true);

        $this->assign('fenshu',$fff);       //评论平均分 
        $this->assign('renshu',$renshu);    //评论人数
        $this->assign('shu',$shu); 
        $this->assign('arr',$arr[0]);
        $this->assign('biao',$biao);
        $this->assign('zhangjie',$zzj);
        $this->assign('shujia',$shujia);
        $this->assign('yezai',$yezai);
        $this->assign('guanzhu',$guanzhu);
        $this->display();
    }
                
    //免费试读
    public function book()
    {
        // $_SESSION['user_id']="";
        session('y_id',I('uid')); //
        $Model=M('');

      

        //邀请
        if($_SESSION['uid']){
            $yaoqing = $Model->Query("SELECT * FROM invite  where `upper` ='".$_SESSION['uid']."' and down ='".session('user_id')."' ");
            if(!$yaoqing){
                $yao['down']=session('user_id');
                $yao['upper']=$_SESSION['uid'];
                M('invite')->add($yao);
            }
        }
       
         $shangji = $Model->Query("SELECT * FROM invite  where  down ='".session('user_id')."' ");//判断是否有上级


        $cha['articleid']=I('id');
        $cha['userid']=session('user_id');
        $cha['flag']=1;

        if(session('user_id')>0){
            $yueduj=M('jieqi_article_bookcase')->where($cha)->find();
            if($yueduj==null){
                M('jieqi_article_bookcase')->add($cha);
            }
        }
     
        if(session('user_id')){
            $userid=session('user_id');
        }else{
            $userid=0;
        }

        $a['articleid']=I('id');
        $id=I('id');

        if(I('page')==null){
            $b=0;
            $c=2000;
        }else{
            $y=I('page');
            $b=$y*20+1;
            $c=20;
        }

        $Model=M('');
        $arr=M('jieqi_article_chapter')->where($a)->order('chapterid asc')->limit($b,$c)->select();

        foreach ($arr as $key => $value) {
            $arr[$key]['shu']=$key+1;

            //$maiid=ceil($key/100);
           
            //$yimai = $Model->Query("SELECT COUNT(*) AS count  FROM orders where aid=".$id." and user_id=".$userid." and path=".$maiid." and state=1;");

           //if($yimai[0]['count']>0)//已经购买
           //{
           //   $arr[$key]['mai']=1;
           //}
           //else
           //{
           //   $arr[$key]['mai']=0;
           //} 
        }

        $shuming=M('jieqi_article_article')->find(I('id'));
          
        // var_dump($arr);die;
        if(!empty(I('zid'))){
              // if(session('user_id')==null){
              //       echo '<script>alert("此章为收费章节，请先登录");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/login/login_frame.html"</script>';die;
              // }
              // echo I('mai');

            if(I('mai')==1){
                if(session('user_id')==null){
                    echo '<script>alert("此章为收费章节，请先登录");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/login/login_frame.html"</script>';die;
                }
                // echo '<script>alert("请购买");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/User/chong_zhi"</script>';
                    
                if($_SESSION['bookid']==I('id')){
                    //推荐的书本
                    $sharebook = $Model->Query("SELECT * FROM share_book  where bookid='".I('id')."' and userid ='".$_SESSION['uid']."' and touserid ='".session('user_id')."' ");
                    if(!$sharebook){
                        $tui['touserid']=session('user_id');
                        $tui['userid']=$_SESSION['uid'];
                        $tui['bookid']=I('id');
                        M('share_book')->add($tui);
                    }
                }

                $pag['chapterid']=I('zid');
                $jia1=M('jieqi_article_chapter')->where($pag)->find();
                $user1=M('jieqi_system_users')->find(session('user_id'));

                //查询余额
                if($user1['egold']<$jia1['saleprice']){
                    echo '<script>alert("此章为收费章节，您的余额不足，请充值");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/User/chong_zhi.html"</script>';die;
                }else{
                    $yuer1['egold']=$user1['egold']-$jia1['saleprice'];
                    $yuer1['uid']=session('user_id');

                    if($yuer1['uid']!==null){
                        $arr1=M('jieqi_system_users')->save($yuer1);
                        //消费记录
                        $xiaofei2['allprice']=$jia1['saleprice'];
                        $xiaofei2['user_id']=session('user_id');
                        $xiaofei2['cid']=I('zid');
                        $xiaofei2['aid']=I('id');
                        M('orders')->add($xiaofei2);

                        if($shangji){
                            //fenxiao记录
                            $dailip=$shuming['saleprice']*$shuming['bilv'];
                            $fenxiao['user_id']=$shangji[0]['upper'];
                            $fenxiao['money']=$dailip;
                            $xiaofei2['type']='+';
                            M('db_bounty')->add($fenxiao);
                          

                            $yue1['egold']=$yue1['egold']+$dailip;
                            $yue1['uid']=$shangji[0]['upper'];
                
                            $arr5=M('jieqi_system_users')->save($yue1);


                        }
                        //代理商

                        if($jia1['did']>0){

                                          if($shangji){
                                             $feiyong=$jia1['saleprice']-($shuming['saleprice']*$shuming['bilv']);
                                          }
                                          else
                                          {
                                           $feiyong=$jia1['saleprice'];
                                          }

                            $dai['time']=date('Y-m');
                            $dai['uid']=$jia1['did'];
                            $daili=M('dai_jiesuan')->where($dai)->find();

                            if($daili>0){
                                $dli['id']=$daili['id'];
                                $dli['num']=$daili['num']+1;
                                $dli['money']=$daili['money']+$feiyong;
                                M('dai_jiesuan')->save($dli);
                            }else{
                                $dali['uid']=$jia1['did'];
                                $dali['num']=1;
                                $dali['money']=+$feiyong;
                                $dali['time']=date('Y-m');
                                M('dai_jiesuan')->add($dali);
                            }
                        }
                        //添加阅读记录
                        $read1['user_id']=$yuer1['uid'];
                        $read1['book_id']=I('zid');
                        $read1['shubi']=$jia1['saleprice'];
                        M('orders_read')->add($read1);
                        echo '<script>location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/index/book.html?id='.I('id').'&zid='.I('zid').'&mai=2"</script>';die;
                    }
                }
            }

            $zh['chapterid']=I('zid');
            $zhang=M('jieqi_article_chapter')->where($zh)->find();
        }else{
            $zhang=$arr[1];
        }

        // var_dump($arr);die;
        //上一章
        if(I('shang')==1){
            $zh['chapterid']=I('zid')-1;
            $zh['articleid']=I('id');

            // var_dump($zh);die;
            $zhang=M('jieqi_article_chapter')->where($zh)->find();

            //公众章节
            $zhi['articleid']=I('id');
            $zhangi=M('jieqi_article_chapter')->where($zhi)->select();
            $zhjie=M('jieqi_article_article')->find(I('id'));
            $shou=$zhangi[0]['chapterid']+$zhjie['ffee']-1;
            // var_dump($shou);die;

            if($zhang==null){
                echo '<script>alert("此章为第一章");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/index/book.html?id='.I('id').'&zid='.I('zid').'"</script>';die;
            }else{
                $cha1['book_id']=I('zid')-1;
                $cha1['user_id']=session('user_id');
                $read2=M('orders_read')->where($cha1)->find();
               
                if($read2>0 || $zh['chapterid']<$shou){
                    echo '<script>location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/index/book.html?id='.I('id').'&zid='.$zh['chapterid'].'&mai=2"</script>';die;
                }else{
                    $uu=M('jieqi_system_users')->find(session('user_id'));

                    if($uu['egold']<$zhang['saleprice']){
                        echo '<script>alert("此章为收费章节，您的余额不足，请充值");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/User/chong_zhi.html"</script>';die;
                    }else{
                        $use['egold']=$uu['egold']-$zhang['saleprice'];
                        $use['uid']=session('user_id');

                        if($use['uid']!==null){
                            M('jieqi_system_users')->save($use);
                            //消费记录
                            $xiaofei['allprice']=$zhang['saleprice'];
                            $xiaofei['user_id']=session('user_id');
                            $xiaofei['cid']=I('zid')-1;
                            $xiaofei['aid']=I('id');
                            M('orders')->add($xiaofei);

                            //代理商收益   根据章节id取得的整一条的章节数据$zhang
                   
                            if($zhang['did']>0){   //判断这一章是否为代理商书籍的章节
                                $dai['time']=date('Y-m');
                                $dai['uid']=$zhang['did'];
                                $daili=M('dai_jiesuan')->where($dai)->find();
                                    if($daili>0){
                                        $dli['id']=$daili['id'];
                                        $dli['num']=$daili['num']+1;
                                        $dli['money']=$daili['money']+$zhang['saleprice'];
                                        M('dai_jiesuan')->save($dli);
                                    }else{
                                        $dali['uid']=$zhang['did'];
                                        $dali['num']=1;
                                        $dali['money']=$zhang['saleprice'];
                                        $dali['time']=date('Y-m');
                                        M('dai_jiesuan')->add($dali);
                                    }
                            }
                            //添加阅读记录
                            $read3['user_id']=$use['uid'];
                            $read3['book_id']=I('zid')-1;
                            $read3['shubi']=$zhang['saleprice'];
                            M('orders_read')->add($read3);
                            echo '<script>location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/index/book.html?id='.I('id').'&zid='.$zh['chapterid'].'&mai=2"</script>';die;
                        } 
                    }
                }
            }
        //下一章
        }else if(I('xia')==1){
            $zh1['chapterid']=I('zid')+1;
            $zh1['articleid']=I('id');

            if(I('zid')==null){
                $zhi['articleid']=I('id');
                $zhang1=M('jieqi_article_chapter')->where($zhi)->order('chapterid asc')->select();
                $zh['chapterid']=$zhang1[1]['chapterid']+1;
            }
            // var_dump($zh);die;
            $zhang1=M('jieqi_article_chapter')->where($zh1)->find();

            //公众章节
            $zhi['articleid']=I('id');
            $zhangi=M('jieqi_article_chapter')->where($zhi)->select();
            $zhjie=M('jieqi_article_article')->find(I('id'));
            $shou=$zhangi[0]['chapterid']+$zhjie['ffee']-1;

            if($zhang==null){
                echo '<script>alert("此章为最后一章");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/index/book.html?id='.I('id').'&zid='.I('zid').'"</script>';die;
            }else{
                $cha5['book_id']=I('zid')+1;
                $cha5['user_id']=session('user_id');
                $read5=M('orders_read')->where($cha5)->find();
                if($read5>0 || $zh1['chapterid']<$shou){
                    echo '<script>location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/index/book.html?id='.I('id').'&zid='.$zhang1['chapterid'].'&mai=2"</script>';die;
                }else{
                    $uu=M('jieqi_system_users')->find(session('user_id'));
                    if($uu['egold']<$zhang1['saleprice']){
                        echo '<script>alert("此章为收费章节，您的余额不足，请充值");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/User/chong_zhi.html"</script>';die;
                    }else{
                        $use['egold']=$uu['egold']-$zhang1['saleprice'];
                        $use['uid']=session('user_id');
                        if($use['uid']!==null){
                            M('jieqi_system_users')->save($use);
                            //消费记录
                            $xiaofei1['allprice']=$zhang1['saleprice'];
                            $xiaofei1['user_id']=session('user_id');
                            $xiaofei1['cid']=I('zid')+1;
                            $xiaofei1['aid']=I('id');
                            M('orders')->add($xiaofei1);
                                


                        if($shangji){
                            //fenxiao记录
                            $dailip=$shuming['saleprice']*$shuming['bilv'];
                            $fenxiao['user_id']=$shangji[0]['upper'];
                            $fenxiao['money']=$dailip;
                            $xiaofei2['type']='+';
                            M('db_bounty')->add($fenxiao);
                          

                            $yue1['egold']=$yue1['egold']+$dailip;
                            $yue1['uid']=$shangji[0]['upper'];
                
                            $arr5=M('jieqi_system_users')->save($yue1);


                        }


                            //代理商收益
                   
                            if($zhang1['did']>0){
                                
                                      if($shangji){
                                             $feiyong=$jia1['saleprice']-($shuming['saleprice']*$shuming['bilv']);
                                          }
                                          else
                                          {
                                           $feiyong=$jia1['saleprice'];
                                          }



                                $dai['time']=date('Y-m');
                                $dai['uid']=$zhang1['did'];
                                $daili=M('dai_jiesuan')->where($dai)->find();
                                if($daili>0){
                                    $dli['id']=$daili['id'];
                                    $dli['num']=$daili['num']+1;
                                    $dli['money']=$daili['money']+$feiyong;
                                    M('dai_jiesuan')->save($dli);
                                }else{
                                    $dali['uid']=$zhang1['did'];
                                    $dali['num']=1;
                                    $dali['money']=$feiyong;
                                    $dali['time']=date('Y-m');
                                    M('dai_jiesuan')->add($dali);
                                }
                            }
                        //添加阅读记录
                        $read3['user_id']=$use['uid'];
                        $read3['book_id']=I('zid')+1;
                        $read3['shubi']=$zhang1['saleprice'];
                        M('orders_read')->add($read3);
                            echo '<script>location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/index/book.html?id='.I('id').'&zid='.$zhang1['chapterid'].'&mai=2"</script>';die;
                    }
                }
            }
            
          }

        }

          //处理标题和换行
          $aa=explode("\n",$zhang['attachment']);
          $aa[0]="<font size='5' color='black'>".$aa[0]."</font><br>";
          $bb=implode("\n",$aa);  
          $a=str_replace("\n","<br>&nbsp;&nbsp;&nbsp;",$bb);

          $zhang['attachment']=$a;
          $zhang['mai']=$shuming['ffee']-1;

          
           //查找章节购买记录是否已购买
        $us['user_id']=session('user_id');
        $gou=M('orders_read')->where($us)->select();

          //处理收费章节
          foreach ($arr as $key => $value) {
              if($value['shu']>$zhang['mai']){
                $arr[$key]['mai']=1;
              }else{
                $arr[$key]['mai']=0;
              }

              foreach ($gou as $ki => $vi) {
                          if($value['chapterid']==$vi['book_id']){
                              $arr[$key]['mai']=2;
                          }
                  }
          }


        // $a=preg_replace('/\n|\r\n/','bj',$a);
        // var_dump($zhang);die;
        $this->assign('arr',$arr);
         // $this->assign('gou',$gou);
        $this->assign('shuming',$shuming['articlename']);
        $this->assign('zhang',$zhang);
       $this->display();
    }

     //更多评论
    public function pinglun(){
      $arr=M('jieqi_article_article')->find(I('id'));
          $a=$arr['size']/20*0.66;
          $arr['size']=round($a,1);

      //评论
      $p['aid']=I('id');
        $pp['aid']=I('id');

          //查询数据并分页
            $model =M('new_reply');
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $shu = $model->where($pp)->order('id desc')->select();
            //分页
            $btn = $page->show();
            //分配数据
      foreach ($shu as $k => $v) {
        $shu[$k]['xing']=$v['xing']*20;
        // $u=M('jieqi_system_users')->find($v['user_id']);
        // if($u>0){
        //   $shu[$k]['name']=$u['name'];
        //   // if($v['xing']>5){
        //   //   $v['xing']=5;
        //   // }
          

        // }
         if($v['user_id']==null){
                     $shu[$k]['name']=$v['jia'];
                   
                }else{
                    $user=M('jieqi_system_users')->find($v['user_id']);
                    $shu[$k]['name']=$user['name'];
                }
        
      }
       //评论统计
        $renshu=M('new_reply')->where($pp)->count();
        $fenshu=M('new_reply')->where($pp)->select();
        foreach ($fenshu as $ke => $va) {
          $fe[]=$va['xing'];
        }
        $ff=array_sum($fe);  
        $fff= $ff*20/$renshu;
        // var_dump($fff);

      // var_dump($shu);die;
      //点赞
      // if(!empty(I('dian'))){
      //   $lik=M('new_reply')->find(I('dian'));
      //   $d['id']=I('dian');
      //   $d['likes']=$lik['likes']+1;
      //   $sql=M('new_reply')->save($d);
      //   if($sql>0){
      //     echo '<script>location.href="pinglun.html?id='.I('id').'&shujia=1"</script>';
       
      //   }
      // }
         //点赞
      if(!empty(I('dian'))){
        $lik=M('new_reply')->find(I('dian'));
         if(session('user_id')==null){
          echo '<script>alert("请先登录");history.go(-1)</script>';die;
         }
        $dian['uid']=session('user_id');

        $dian['pid']=$lik['id'];
        $zan=M('new_rdian')->where($dian)->find();
        if($zan>0){

        }else{
            M('new_rdian')->add($dian);
            $d['id']=I('dian');
            $d['likes']=$lik['likes']+1;
            $sql=M('new_reply')->save($d);

            if($sql>0){
              echo '<script>location.href="pinglun.html?id='.I('id').'&shujia=1"</script>';
       
            }
        }
      }
         // var_dump($shu);die;
       $this->assign('fenshu',$fff);       //评论平均分 
      $this->assign('renshu',$renshu);       //评论人数
        $this->assign('shu',$shu); 
        $this->assign('btn',$btn); 
       $this->assign('arr',$arr);
       $this->display();
    }
    //书单
    public function pladd(){

      // var_dump(i());die;
      if(session('user_id')==null){
        echo '<script>alert("请先登录");location.href="dtail.html?id='.I('id').'&shujia=1"</script>';die;
      }


      $a['content']=I('text');
      $keywords=M('system')->where(['types'=>2])->find();
      $arr=explode(',', $keywords['content']);
      foreach ($arr as $k => $v) {
            $i=strpos($a['content'], $v);
            if ($i!==false) {
              echo '<script>alert("存在屏蔽字段");location.href="dtail.html?id='.I('id').'&shujia=1"</script>';die;
            }
      }
      $a['user_id']=session('user_id');
      $a['aid']=I('id');
      if(I('xing')>5){
        $a['xing']=5;
      }else{
        $a['xing']=I('xing');
      }
      
      // var_dump($a);die;
      $arr=M('new_reply')->add($a);
      if($arr>0){
        echo '<script>alert("评论成功");location.href="dtail.html?id='.I('id').'&shujia=1"</script>';
       
      }

      $this->display();
    }
    //加入书架 
   public function sjadd(){

      $cha['articleid']=I('id');
      $cha['userid']=session('user_id');
      $shujia=M('jieqi_article_bookcase')->add($cha);

      if($shujia>0){
         echo '<script>alert("书架加入成功");location.href="dtail.html?id='.I('id').'"</script>';
      }
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


    public function chongzhi(){
            $Model = M();
    $user_id = 81;
    $zj=$_GET['zj'];    
    $price=$_GET['price'];   
    $id=$_GET['id']; 
    $data = $Model->Query("SELECT * FROM jieqi_system_users where uid=".$user_id." ");

       $zongjia=$data[0]['egold']+$data[0]['gcount'];
             if($zongjia> $price)
             {

              // echo  $zongjia;exit();
                  if($price>$data[0]['gcount'])
                  {
                    // echo  $zongjia;exit();
$jine=$data[0]['egold']+$price-$data[0]['gcount'];
$Model->Query("UPDATE  jieqi_system_users SET gcount=0  where uid=".$user_id." ");
$Model->Query("UPDATE  jieqi_system_users SET egold=".$jine."  where uid=".$user_id." ");

                  }
                  else
                  {
            // echo  $zongjia,"3";exit();
// $zj=$data[0]['gcount']-$price;
// $Model->Query("UPDATE  jieqi_system_users SET egold=1  where uid=".$user_id."; ");


                  }

             


              $danhao=date("YmdHis");
                $add['user_id']=$user_id;
                $add['allprice']=$price;
                $add['numbers']=$danhao;
                $add['aid']=$id;
                $add['state']=1;
                $add['path']=$zj;
                
            $sql=M('orders')->add($add);

            if($sql==true)
            { 
                // $jine=$data[0]['price']*10; 
               echo '<script>window.location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/Index/dtail.html?id='.$id.'"</script>';

            }


            }
            else

            {
 echo '<script>window.location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/User/chong_zhi"</script>';

            }



     
    }

    
}
