<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");  
include_once("mysqlha.php");
header('content-type:text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods：*');
header('Access-Control-Allow-Headers:x-requested-with,content-type');
// heeder('Content-Type:application/x-www-form-urlencoded');
class LoginController extends Controller {

	// public function test(){
	// 	error_reporting(0);
	// 	$fp = fopen('./ceshi.txt','a+');
	// 	fwrite($fp,'limingjie'); 
	// 	fclose($fp);
	// 	echo 200;
	// }

	
 		//登录  
	public function login(){
		// if(IS_POST){
		// 	echo 'post';die;
		// }else{
		// 	echo 'get';die;
		// }
	
		if(IS_POST){
			
			
			$phone = $_REQUEST['phone'];
			$password =$_REQUEST['pwd'];
			$map = array('uname'=>$phone,'pass'=>$password);
			$data = M('jieqi_system_users')->where($map)->find(); 
			 // var_dump($password);die;
			$a['user_id']=$data['user_id'];
			$arr = M('jieqi_system_users')->where($a)->find();
			 // var_dump($arr);die;
			if(!empty($data)){ 
				session('user_id',$data['uid']); 
				session('username',$data['name']); 
				
				session('yanzheng',$arr['tongguo']);
				
				 // var_dump(session('yangzheng'));die;
				echo '<script>alert("登录成功");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/index/index.html"</script>';die;
			}else{
				echo '<script>alert("用户密码错误");location.href="login_frame"</script>';die;
			}
			$this->ajaxReturn($result);  
		}else{  
			// echo '<script>alert("请先登录");location.href="login"</script>';
			$this->display();
		} 
	}


	 public function fxbook()                                                                            
    {
   
     	$user['uname']=I('uid');
     	$user['name']=I('name');
     	$user['groupid']=I('uid');
    	$arr=M('jieqi_system_users')->where($user)->find();
      if($arr>0){
	       echo '<script>alert("登录成功");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/"</script>';
	       session('user_id',$arr['uid']);

      }else{
        $pa=rand(123456,987654);
        $user['pass']='twxs'.$pa;
        $user['email']=time();
        $info=M('jieqi_system_users')->add($user);
        if($info>0){
        	session('user_id',$info);
			echo '<script>alert("登录成功");location.href="http://www.youdingb.com/xiangmu/xiaoshuoyipin/"</script>';
        }
        
       
      }
     
       
    }

 		//找回密码
	public function forget(){
		if(IS_POST){
		    $Model = M();  
			$phone = $_REQUEST['phone'];
			$password = $_REQUEST['password']; 
			$data = $Model->execute("UPDATE jieqi_system_users set pass='".$password."' WHERE mobile='".$phone."';");
			if($data){ 
				$result = array('code'=>200,'url'=>U('Login/login_frame'));
			}else{
				$result = array('code'=>201,'url'=>U('Login/login_frame'));
			}
			$this->ajaxReturn($result);  
		}else{  
			$this->display();
		} 
	}
  

// 	//注册   
	// public function zhuce(){ 

	
 //             $info['uname']=$_REQUEST['phone'];
 //             $info['pass']=$_REQUEST['password'];

            
		// $tel =18607638470;                                       //手机号
  //       $url = "http://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=".$tel;                //api接口地址
  //       $res = $this->request_get($url);
  //       $res_arr = json_decode($res,true);

  //       if($res_arr['status']=='1'){                                //如果成功获取数据
  //           $area['province'] = $res_arr['data']['province'];
  //           $area['city'] = $res_arr['data']['city'];

  //       }
  //       var_dump($area);


           
            // $this->display();
            
	 

// }
	/**

* 根据手机号码获取归属地

*/

 public function zhuce(){
 	$user=$_SESSION['uid'];
 	// var_dump($user);
 	$this->assign('user',$user);
	$this->display();

}



public function login_frame(){
		
	if(!empty(I('code'))){
		// $header_joins=header('Access-Control-Allow-Origin:*');
		
      		$us['grant_type'] = 'authorization_code';
      		$us['code'] = I('code');
      		$us['redirect_uri'] = 'http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/Login/login_frame.html';
      		$us['client_id'] = '1600608013';
      		$us['client_secret']='ec197cf2cb3cc726ca778a75e6c3be14';
  		

		//定义一个要发送的目标URL；
$url = "https://api.line.me/oauth2/v2.1/token";

//定义传递的参数数组；
// var_dump($us);
//定义返回值接收变量；
$httpstr = curl_post($url,$us);

	var_dump($_SERVER['HTTP_USER_AGENT']);
		var_dump($httpstr);die;

	
	}

	if(I('id')==1){
		// $header_joins=header('Access-Control-Allow-Origin:*');
		
      		$us['grant_type'] = 'authorization_code';
      		$us['code'] = 'IYNqYtSInkE0qRajT2zk';
      		$us['redirect_uri'] = 'http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/Login/login_frame.html';
      		$us['client_id'] = '1600608013';
      		$us['client_secret']='ec197cf2cb3cc726ca778a75e6c3be14';

  		
			// $us['phone']=777888;
			// $us['pwd']=123456;
		// // var_dump($post_data);die;
		// $data =curl_post('https://api.line.me/oauth2/v2.1/token',$us);
		
		// // $result = post('https://api.line.me/oauth2/v2.1/token', $header_joins, $post_data);

		// // echo $result;
 
		// echo $data;

		//定义一个要发送的目标URL；
$url = "https://api.line.me/oauth2/v2.1/token";
//定义传递的参数数组；
// $data['aaa']='aaaaa';
// $data['bbb']='bbbb';
$lo='http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/Login/login.html';
$user['phone']=777888;
$user['pwd']=123456;
//定义返回值接收变量；
$httpstr = curl_post($lo,$user);

	echo $httpstr;

	}

	if(!empty(I('tuichu'))){
		session_destroy();
		echo '<script>alert("账号退出成功")</script>';
	}

	 if(!empty(I('title'))){
             if(SendMail($_POST['mail'],$_POST['title'],$_POST['content'])){
                 echo '<script>alert("邮件发送成功");</script>';
            }else{
               // $this->error('发送失败');
            	echo '<script>alert("邮件发送失败,请确认邮箱是否存在");</script>';
            }
               
     }
	
 	
	$this->display();

}




// class Abc extends Controller {


// /**
//  * 请求接口返回内容
//  * @param  string $url [请求的URL地址]
//  * @param  string $params [请求的参数]
//  * @param  int $ipost [是否采用POST形式]
//  * @return  string
//  */
//  function juhecurl($url,$params=false,$ispost=0){
//     $httpInfo = array();
//     $ch = curl_init();
 
//     curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
//     curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
//     curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
//     curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
//     curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//     if( $ispost )
//     {
//         curl_setopt( $ch , CURLOPT_POST , true );
//         curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
//         curl_setopt( $ch , CURLOPT_URL , $url );
//     }
//     else
//     {
//         if($params){
//             curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
//         }else{
//             curl_setopt( $ch , CURLOPT_URL , $url);
//         }
//     }
//     $response = curl_exec( $ch );
//     if ($response === FALSE) {
//         //echo "cURL Error: " . curl_error($ch);
//         return false;
//     }
//     $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
//     $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
//     curl_close( $ch );
//     return $response;
// }
	
	// public function facebook()
 //  {
 //      $user['uname']=I('name');
 //      $user['pass']=I('pass');
 //      $user['email']=I('email');
 //      $arr=M('jieqi_system_users')->where($user)->find();
 //      if($arr>0){
 //      		var_dump($arr);
          

 //      }else{

 //          $add=M('jieqi_system_users')->add($user);
 //      		if($add>0){
 //      			var_dump($add);
 //      		}else{
 //      			var_dump($add);
 //      		}
 //      }  
  
   

 
  // $order_number="订单号";
 
  // $post_data = array(
  //     'company_id' => '开放平台ID',
  //     'msg_type' => 'TRACEINTERFACE_NEW_TRACES',
  //     'data' => "[\"$order_number\"]",
  //     'data_digest' => '签名'
  // );
 








}