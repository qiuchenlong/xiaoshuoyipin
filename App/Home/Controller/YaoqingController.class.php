<?php
namespace Home\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class YaoqingController extends Controller {

  //主页
  public function index(){
  	$a['user_id']=session('user_id');
  	$arr=M('user')->where($a)->find();

    $yq['yaoqing']='yaoqing'.session('user_id').'.png';
    $yq['user_id']=session('user_id');
    M('user')->save($yq);
    $yaoqing=M('user')->where($a)->find();
  	// var_dump($arr);
  	if($arr['money']==0){
  		echo '<script>alert("充值后才能邀请伙伴");history.go(-1)</script>';die;
  	}

        $id=session('user_id');  
       

        $url="http://www.youdingb.com/moneys/index.php/Home/Login/zhuce.html?id=".$id;
        $level=3;  
        $size=4;  
        $filename = 'PUBLIC/images/yaoqing'.$id.'.png';
        Vendor('phpqrcode.phpqrcode');  
        $errorCorrectionLevel =intval($level) ;//容错级别  
        $matrixPointSize = intval($size);//生成图片大小  
        //生成二维码图片  
        $object = new \QRcode();  
        $object->png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);



        // session('yaoqing_id',$id);
        $this->assign('v',$yaoqing);
        $this->display();
  

 
  }



  // 1. 生成原始的二维码(生成图片文件)
 // public function qrcode()  
 //    {  
 //        $id=I('id');  
 //        $url="Home/index/index.html/".$id;  
 //        $level=3;  
 //        $size=4;  
 //        $filename = 'PUBLIC/images/'.$id.'.png';
 //        Vendor('phpqrcode.phpqrcode');  
 //        $errorCorrectionLevel =intval($level) ;//容错级别  
 //        $matrixPointSize = intval($size);//生成图片大小  
 //        //生成二维码图片  
 //        $object = new \QRcode();  
 //        $object->png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);



 //    }  

  

  
}