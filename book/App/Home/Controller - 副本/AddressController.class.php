<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller; 
include_once("Common.php");
include_once("mysqlha.php");
header("Content-Type:text/html; charset=utf-8"); 

class AddressController extends Controller {
public function test(){
	$openid = ''; 
    $time = explode ( " ", microtime());     
    $time = $time[1].($time[0] * 1000);
    $time2 = explode ( ".", $time); 
    $time = $time2[0];  
    echo md5($openid.$time.rand(10,99));//32位 
}
	
	//获取用户地址
	public function getUserAddress(){  
		// $_3rdsession = $_REQUEST["_3rdsession"];
		// $key = explode(",",S($_3rdsession));   
		// $openid = $key[0]; //openid  
		// $session_key = $key[1]; 
		// echo $openid;die;
		$user_id = $_REQUEST['user_id'];
		$Model = M();		
		$UserAddress = $Model->Query("SELECT * FROM user_address WHERE user_id='".$user_id."'");
		$UserAddress = array($UserAddress);
		echo getSuccessJson($UserAddress);
	} 

	//新增用户地址
    public function addUserAddress(){           
			// $_3rdsession = $_REQUEST["_3rdsession"];
			// $key = explode(",",S($_3rdsession));  
			// $openid = $key[0]; //openid  
			// $session_key = $key[1];         
			$user_id = $_REQUEST['user_id'];
			$name = $_REQUEST["name"]; //收货人
			$phone = $_REQUEST["phone"]; //收货手机号
			$address = $_REQUEST["address"];//详细地址
			$provice = $_REQUEST['provice'];//省份
			$city  = $_REQUEST['city'];
			$country = $_REQUEST['country'];
			$post_code = $_REQUEST['post_code'];  
			// $mdefault = $_REQUEST["mdefault"];    
			//当用户设为默认地址时，把原来的默认地址变为0
			// if($mdefault == 1){ 
			// 	$Model->execute("update user_address set mdefault = 0 where fk_userid =".$userid." and mdefault = 1");
			// }																											
			//插入
			$insertArr = array(
				'user_id'=>$user_id,
				'name'=>$name,
				'phone'=>$phone,
				'address'=>$address,
				'provice'=>$provice,
				'city'=>$city,
				'country'=>$country,
				'post_code'=>$post_code
				);
			$Model = M('user_address');   
			$result = $Model->data($insertArr)->add();
			// $result = $Model->execute("INSERT INTO user_address (user_id,openid,name,phone,address,mdefault,provice,city,country) VALUES (".$user_id.",'".$openid."','".$name."',".$phone.",'".$address."','".$provice."','".$city."','".$country."')");
			if($result){    
			   echo '{"code":"200","msg":"添加成功"}';  
			}else{  
			   echo '{"code":"201","msg":"添加失败"}';   
				
			}
    }


	//删除用户地址
	public function deleteUserAddress(){
			// $_3rdsession = $_REQUEST["_3rdsession"];
			// $key = explode(",",S($_3rdsession)); 
			// $openid = $key[0]; //openid  
			// $session_key = $key[1];  
			$address_id = $_REQUEST['address_id']; 
		    del('user_address',"id=".$address_id.""); 
			echo '{"code":"200","msg":"删除成功"}'; 
	} 
	
 

	//更新用户地址
	public function updateUserAddress(){
		    // $_3rdsession = $_REQUEST["_3rdsession"];
			// $key = explode(",",S($_3rdsession)); 
			// $openid = $key[0]; //openid  
			// $session_key = $key[1];  
			// $openid = $openid;
		    $address_id = $_REQUEST['address_id'];
			$name = $_REQUEST["name"];
			$phone = $_REQUEST["phone"]; 
			$address = $_REQUEST["address"];
			$provice = $_REQUEST['provice'];
			$city =$_REQUEST["city"];
			$country = $_REQUEST['country']; 
			$post_code = $_REQUEST['post_code'];
			
			
			// //当用户设为默认地址时，把原来的默认地址变为0 
			// if($mdefault == 1){ 
			// 	$Model->execute("update user_address set mdefault = 0 where fk_userid =".$userid." and mdefault = 1");
			// }																											
			//更新
			// $result = $Model->execute("update user_address set name='".$name."',phone='".$phone."',address='".$address."',provice='".$provice."',city='".$city."',country='".$country."' where id ='".$address_id."'");			
			// echo '{"code":"200","msg":"更新成功"}';
			   
			$Model = M('user_address');
			$updateArr = array(
				'id'=>$address_id,
				'name'=>$name,
				'phone'=>$phone, 
				'address'=>$address,
				'provice'=>$provice,
				'city'=>$city,
				'country'=>$country,
				'post_code'=>$post_code);
			$data = $Model->data($updateArr)->save();
			if(false===$data){
				$result = array('code'=>201,'msg'=>'更新失败');
			}else{
				$result = array('code'=>201,'msg'=>'更新失败');
			}
			$this->ajaxReturn($result);
	}


	public function threeaddress(){  
		$Model = M();
		$resultArr = array();
		$data = $Model->Query("SELECT name,id FROM district WHERE upid=0 AND level=1");
		foreach ($data as $k => $v) {
			$city = $Model->Query("SELECT id,name FROM district WHERE upid=".$v['id']." AND level=2");
			$obj['provice'] = $v['name'];
			$obj['city'] = $city; 
			foreach ($city as $k2 => $v2) {
				$qu = $Model->Query("SELECT name FROM district WHERE upid=".$v2['id']." AND level=3;");
			    $obj['city'][$k2]['qu'] = $qu;  
			}
			array_push($resultArr,$obj);
		}

		echo getSuccessJson(array($resultArr));
	}








/***************************************************************************************/
	//获取用户所有地址
   //  public function getUserAddressList(){  
   //         //根据3rdsession来查询openid 
			 
			// $page = $_REQUEST["page"]; 
			// $pagecount = $_REQUEST['pagecount'];
          		  
			// if($page == null||$page<=0){
			// 	$page=0;
			// }
			  
			// if($pagecount == null||$pagecount<=0){   
			// 	$pagecount=10; 
			// }
			
			// $startcount = $page*$pagecount; 
			
			// $Model = M();   												
			
			
			// //default这个字段是数据库的关键字，改为mdefault   
			// $UserAddressList = $Model->Query("select id,name,phone,address,area,mdefault from user_address where fk_userid =".$userid." limit ".$startcount.",".$pagecount."");			
			
			// //遍历UserAddressList，得到默认的地址的id
			// for($i=0;$i<sizeof($UserAddressList);$i++){ 
			// 	if($UserAddressList[$i].mdefault == 1){
			// 		$id = $UserAddressList[$i].id;
			// 		break;
			// 	}								
			// }
			// $UserAddressList = array($UserAddressList);
			// echo getSuccessJson($UserAddressList);
   //  }
   


    // //获取用户默认定址
    // public function getDefaultAddress(){
    // 	$Model = M();
    // 	$userid = $_REQUEST['userid'];
    	
    // 	$default = $Model->Query("select * from user_address where fk_userid=".$userid." and mdefault=1");
    //     $default = array($default);
    // 	echo getSuccessJson($default);
    // } 
    // 
    

    	// //设置默认地址
	// public function updateDefaut(){
	// 	$id = $_REQUEST['id'];
	// 	$userid = $_REQUEST['userid'];
	// 	$Model = M();
	// 	$Model->execute("update user_address set mdefault = 0 where fk_userid =".$userid." and mdefault = 1");
	// 	$Model->execute("update user_address set mdefault=1 where id =".$id."");
	// 	echo '{"code":"200","msg":"更新成功"}';			
	// }
    
}