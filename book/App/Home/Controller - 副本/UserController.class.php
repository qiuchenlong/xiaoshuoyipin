<?php
namespace Home\Controller;
use Think\Controller;
 include_once("mysqlha.php");
 include_once("Common.php");

class UserController extends Controller{
//用户的信息

	public function test(){ 
	  $redirectUrl = C('site_url') . U("Home/Index/getSuccess");
	  echo $redirectUrl;die;
	}


	public function userinfo(){
		$user_id = $_REQUEST['user_id'];
		$Model = M();
		$data = $Model->Query("SELECT * FROM jieqi_system_users WHERE uid=".$user_id.";");
		echo getSuccessJson($data,'操作成功');
	}



  //获取用户余额
    public function getUserMoney(){
      $userid = $_REQUEST['user_id'];
      $Model = M();
      $user = $Model->Query("select egold from jieqi_system_users where uid=".$userid."");
      $user = array($user);
      echo getSuccessJson($user);
    }

    //用户注册
    public function register(){
      $phone = $_REQUEST['phone'];
      $password = $_REQUEST['password'];
      $insertArr = array(
         "phone"=>$phone,
         "password"=>$password,
       "ztimes"=>1
      );
    
  

        
      $Model = M();
    
      $id = myinsert('user',$insertArr);
    $insertC = array(
       "user_id"=>$id
    );

        myinsert('core',$insertC);
      echo '{"code":"200","msg":"更新成功","id":"'.$id.'"}';
    }

    //用户登录
    public function login(){
      $phone = $_REQUEST['phone'];
      $password = $_REQUEST['password'];
      $Model = M();
      $user = $Model->Query("SELECT * FROM jieqi_system_users WHERE mobile=".$phone." AND pass=".$password."");
    
    if(sizeof($user)==0){
      $returnArr = array(
                "code"=>201,
                "msg"=>"密码或手机号错误"
            );
      echo json_encode($returnArr);
      exit();
    }
      $user = array($user);
      echo getSuccessJson($user);
    }

    //更新
    public function registerWan(){
      $name = $_REQUEST['name'];
    //   $sex = $_POST['sex'];
    //   $birthday = $_POST['birthday'];
    // $address = $_POST['address'];
      $user_id = $_REQUEST['user_id'];
    // $autograph = $_POST['autograph'];
    
     if ($_FILES) {

            $UpFileTool = new \Think\UpFileTool('headimg');// 实例化上传类

            $UpFileTool->upImage(0.3,'Uploads','Uploads');
            $images=$UpFileTool->srcImage;
            $sumbimages = $UpFileTool->sumbImage;

            $updateArr = array(
                "name"=>$name,  
                "avatar"=>$sumbimages,
            );
       
      update('jieqi_system_users',$updateArr,"uid=".$user_id."");
            
            $returnArr = array(
                "code"=>200,
                "msg"=>"修改成功"
            );
            echo json_encode($returnArr);
        }else{
      $updateArr = array(
                "name"=>$name,
            );
      
      update('jieqi_system_users',$updateArr,"uid=".$user_id."");
            
            $returnArr = array(
                "code"=>200,
                "msg"=>"修改成功"
            );
            echo json_encode($returnArr);
    }

      
    }


 //第三方登陆
    public function otherlogin(){
      $openid = $_REQUEST['openid'];
      $Model = M();
      $user = $Model->Query("SELECT * FROM USER WHERE openid='".$openid."'");
      $user = array($user);
      echo getSuccessJson($user);
    }

    //第三方注册
    public function otherRegister(){
      $openid = $_POST['openid'];
      $sex  = $_POST['sex'];
      $name = $_POST['name'];
      $Model = M();
        
    $UpFileTool = new \Think\UpFileTool('file');// 实例化上传类

    $UpFileTool->upImage(0.3,'Uploads','Uploads');
    $images=$UpFileTool->srcImage;
    $sumbimages = $UpFileTool->sumbImage;
      $insertArr = array(
         "openid"=>$openid,
         "sex"=>$sex,
         "username"=>$name,
       "userheadimg"=>$images,
       "sumbuserheadimg"=>$sumbimages
      );
      $id = myinsert('user',$insertArr);
    
    $insertC = array(
       "user_id"=>$id
    );

        myinsert('core',$insertC);
      echo '{"code":"200","msg":"更新成功","id":"'.$id.'"}';
    }



 
    //生成随机数
 protected function getRandChar($length){
   $str = null;
   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
      $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
 }   


}


?>