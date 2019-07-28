<?php
namespace Home\Controller;
use Think\Controller;
 include_once("mysqlha.php");
 include_once("Common.php");
header("Access-Control-Allow-Origin: *");
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

    public function readtime()
    {
        if(!isset($_REQUEST['user_id']) || !isset($_REQUEST['readtime'])){
            $result = ['code' => 220,'msg' =>'操作失败,缺少参数'];
            $this->ajaxReturn($result);
        }

        $id = $_REQUEST['user_id'];
        $readtime = $_REQUEST['readtime'];

        $res =    M('jieqi_system_users')->save(['uid'=>$id,'readtime'=>$readtime]);

        if($res !== false){
            $result = ['code' => 200,'msg' =>'操作成功'];
        }else{
            $result = ['code' => 220,'msg' =>'操作失败'];
        }
        $this->ajaxReturn($result); 
    }


  public function faxian(){
    $user_id = $_REQUEST['user_id'];
    $Model = M();
    $data = $Model->Query("SELECT gcount,egold,images,name,readtime  FROM jieqi_system_users WHERE uid=".$user_id.";");

        $data = $Model->Query("SELECT gcount,egold,images,name,readtime  FROM jieqi_system_users WHERE uid=".$user_id.";");
         $zongshu=$Model->Query("SELECT COUNT(*)AS count FROM invite WHERE `upper`=".$user_id.";");
          $shuliang=$zongshu[0]['count'];
         $yiji=$Model->Query("SELECT  *  FROM invite WHERE `upper`=".$user_id.";");

          foreach ($yiji as $key => $value) {//遍历二级
           
              $erji=$Model->Query("SELECT  *  FROM invite WHERE `upper`=".$value['down'].";");
              $ershu=$Model->Query("SELECT COUNT(*)AS count FROM invite WHERE `upper`=".$value['down'].";");
            $shuliang=$shuliang+$ershu[0]['count'];
                      foreach ($erji as $key => $value) {//遍历三级
           
              $sanji=$Model->Query("SELECT  *  FROM invite WHERE `upper`=".$value['down'].";");
              $sanshu=$Model->Query("SELECT COUNT(*)AS count FROM invite WHERE `upper`=".$value['down'].";");
              $shuliang=$shuliang+$sanshu[0]['count'];


                   }

          }
    $data[0]['yshuliang']=$shuliang;

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
        
      $Model = M();


   $user = $Model->Query("SELECT * FROM jieqi_system_users WHERE uname='".$phone."' ");
    
    if($user[0]['uid']>0){
  $returnArr = array(
                "code"=>201,
                "msg"=>"账号已经存在"
            );
      echo json_encode($returnArr);

      }
    
    else
{


          	    // $sortname = $Model->Query("INSERT INTO jieqi_system_users(pass,email,uname,name)VALUES('".$password."','".$phone."','".$phone."','".$phone."')");
              $add['pass']=I('password');
              $add['email']=I('phone');
              $add['uname']=I('phone');
              $add['name']=I('phone');

              $arr=M('jieqi_system_users')->add($add);
              $info=M('jieqi_system_users')->find($arr);
     $returnArr = array(
                "code"=>200,
                "phone"=>$info['uname'],
                "pass"=>$info['pass'],
            );
if($_REQUEST['yq'])
{
     $id=$arr['uid'];
    $sid = $_REQUEST['yq'];
    $invite['upper']=$sid;
    $invite['down']=$id;
    M('invite')->add($invite);

    $Model->Query("UPDATE jieqi_system_users SET gcount=gcount+180 WHERE uid='".$sid."' ");

     $Model->Query("UPDATE jieqi_system_users SET gcount=gcount+180 WHERE uid='".$id."' ");

}
      echo json_encode($returnArr);

}

}
 

    //用户登录
    public function login(){
      $phone = $_REQUEST['phone'];
      $password = $_REQUEST['password'];
      session('ip',I('ip'));
      $Model = M();
      $user = $Model->Query("SELECT * FROM jieqi_system_users WHERE uname='".$phone."' AND pass='".$password."'");
    
    if($user[0]['uid']>0){
    	$user = array($user);
      session('user_id',$user[0]['uid']);
      echo getSuccessJson($user);
    
    }
    else
    {
   $returnArr = array(
                "code"=>201,
                "msg"=>"密码或手机号错误"
            );
      echo json_encode($returnArr);
      exit();

    }
      
    }

    //更新
    public function registerWan(){
      $name = $_REQUEST['name'];
    //   $sex = $_POST['sex'];
    //   $birthday = $_POST['birthday'];
    // $address = $_POST['address'];
      $user_id =$_REQUEST['user_id'];
      $registerWa=$_REQUEST['intro'];
    // $autograph = $_POST['autograph'];
    
     if ($_FILES) {
//上传图片
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     614572800 ;// 设置附件上传大小
           $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
          $upload->rootPath  =     '../Public/Uploads/'; // 设置附件上传根目录
           $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传文件 
           $info   =   $upload->upload();
          if(!$info) {// 上传错误提示错误信息
           $this->error($upload->getError()); 
        }else{// 上传成功
                $this->success('上传成功'); 
             $a=$info['headimg']['savename'];
           }
           $dates=date("Y-m-d");
            $updateArr = array(
                "name"=>$name,
                "intro"=>$registerWa, 
                "images"=>'Uploads/'.$dates."/".$a, 
            );

           // var_dump( $info);die;
       
      update('jieqi_system_users',$updateArr,"uid=".$user_id."");
            
            $returnArr = array(
                "code"=>200,
                "msg"=>"修改成功"
            );
           // echo json_encode($returnArr);
    //         $Model = M();
    //         $data = $Model->Query("SELECT * FROM jieqi_system_users WHERE uid=".$user_id.";");
    // echo getSuccessJson($data,'操作成功');
        }else{
      // $updateArr = array(
      //           "name"=>$name,
      //           "intro"=>$registerWa, 
      //       );

      
      update('jieqi_system_users',$updateArr,"uid=".$user_id."");
            
            // $returnArr = array(
            //     "code"=>200,
            //     "msg"=>"修改成功"
            // );
            
    }
    
$Model = M();
            $data = $Model->Query("SELECT * FROM jieqi_system_users WHERE uid=".$user_id.";");
		echo getSuccessJson($data,'操作成功');
      
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
         "mobile"=>"",
         "sign"=>"",
         "intro"=>"",
         "setting"=>"",
         "badges"=>"",
         "uname"=>$name,
         "name"=>$name,
         "email"=>$name,

         //"username"=>$name,
       //"userheadimg"=>$images,
       //"sumbuserheadimg"=>$sumbimages
      );
      $id = myinsert('jieqi_system_users',$insertArr);
    
    $insertC = array(
       "user_id"=>$id
    );


        // 查询数据库user
        $users = $Model->query("select * from jieqi_system_users where uid=".$id);
        $user = json_encode($users[0], JSON_FORCE_OBJECT);

        //myinsert('core',$insertC);
      echo '{"code":"200","msg":"更新成功","uid":"'.$id.'", "result": '.$user.'}';
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

 //修改密码
    public function xiugaipass(){
      $phone['uname']= $_REQUEST['phone'];
      $save['pass']= $_REQUEST['password'];
      
      $arr=M('jieqi_system_users')->where($phone)->save($save);
      if($arr>0){
           $returnArr = array(
                "code"=>200,
                "msg"=>"修改成功"
            );
      }else{
          $returnArr = array(
                "code"=>220,
                
            );
      }

            
           
            echo json_encode($returnArr);
      
    }


    //人脉
    public function renmai(){ 
       $a['upper']=I('user_id');
        $arr=M('invite')->where($a)->select();
            
        foreach ($arr as $k => $v) {
          $user=M('jieqi_system_users')->find($v['down']);

          $b['upper']=$v['down'];
          $info=M('invite')->where($b)->select();
          
          if($info>0){
              foreach ($info as $k1 => $v1) {
                $user1=M('jieqi_system_users')->find($v1['down']);
                $hehuo1['phone']=$user1['mobile'];
                $hehuo1['time']=$user1['time'];
                $hehuo1['name']=$user1['name'];
                $he1[]=$hehuo1;
              }
          }

          $hehuo['phone']=$user['mobile'];
          $hehuo['time']=$user['time'];
          $hehuo['name']=$user['name'];
          $he[]=$hehuo;
        }
            $hehe=$he+$he1;
            // $hehe[]=;
              $result = array(
                "code"=>200,
                "msg"=>"查询合伙人信息",
                "xiaji"=>$hehe,
               
                
            );


        echo json_encode($result);
    }

     public function fxbook()
    {
   
    $user['uname']=I('uid');
    $user['name']=I('name');
   

    $user['groupid']=I('uid');
    $arr=M('jieqi_system_users')->where($user)->find();
    

      if($arr>0){
        //ip
        $ip['user_id']=$arr['uid'];
        $ip['ip']=I('ip');
        M('new_ip')->add($ip);
        $result = array(
                "code"=>210,
                "paw"=>$arr,
                
            );

      }else{
        
        $pa=rand(123456,987654);
        $user['pass']='twxs'.$pa;
        $user['email']=time();
        $info=M('jieqi_system_users')->add($user);

        //ip
        $ip['user_id']=$info;
        $ip['ip']=I('ip');
        M('new_ip')->add($ip);

        if($info>0){
            $sql=M('jieqi_system_users')->find($info);
            $result = array(
                "code"=>200,
                "arr"=>$sql,
                
            );
        }else{
             $result = array(
                "code"=>220,
                
                
            );
        }
        
       
      }
     
       echo json_encode($result);
    }

      public function youjian()
    {
       if(SendMail(I('mail'),I('title'),I('content'))){
                $result = array(
                  "code"=>200,
                );
        }else{
               $result = array(
                  "code"=>220,
                ); 
        }
        echo json_encode($result);
    }

      public function ip()
    {
      $ip['ip']=I('ip');
      $arr=M('new_ip')->where($ip)->order('id desc')->select();
      // var_dump($arr);die;
      $info=M('jieqi_system_users')->find($arr[0]['user_id']);
      if(I('ip')>0){
        $result = array(
                "code"=>200,
                "ip"=>I('ip'),
                "user"=>$info,
                
            );
      }else{
        $result = array(
                "code"=>220,
                
                
            );
      }
      
       echo json_encode($result);
    }

     public function gonggao()
    {
      $arr=M('new_gonggao')->select();
       $result = array(
                "code"=>200,
                "arr"=>$arr,
             
                
            );
      echo json_encode($result);
    }


    //检测是否绑定银行卡号
    public function checkbank()
    {
        $uid = $_REQUEST['user_id'];
        $bankcard = M('jieqi_system_users')->where(['uid'=>$uid])->getField("bankcard");

        if($bankcard){
            $data = [
                'bankcard' => $bankcard
            ];
            $result = ['code' => 200,'data' =>$data,'msg'=>'操作成功'];
        }else{
            $data = [
                'bankcard' => $bankcard
            ];
            $result = ['code' => 220,'data' =>$data,'msg'=>'操作失败'];          
        }

        $this->ajaxReturn($result);

    }

    //银行卡信息
    public function bankinfo()
    {
        $uid = $_REQUEST['user_id'];

        $user = M('jieqi_system_users')->where(['uid'=>$uid])->select()[0];

        $data = [
            'bankcard' => $user['bankcard'],
            'bank_name' => $user['bank_name'],
            'postname' => $user['postname']            
        ];

        $result = ['code' => 200,'data' =>$data,'msg'=>'操作成功'];
        $this->ajaxReturn($result);
    }

    //充值记录
    public function volleydesc()
    {
        $uid = $_REQUEST['user_id'];
        $page = $_REQUEST['page'];               
        $pagesize = $_REQUEST['pagesize'];

        $volley = M('topup')->where(['fk_userid'=>$uid])->order('addtime desc')->select();


        $count = count($volley);
        $count = ceil($count/$pagesize);
        $num = $page * $pagesize;

        if($page == 0){
            $volley = null;
        }

        $number = ($page - 1) * $pagesize;


        for ($i=0; $i<$number; $i++){
            unset($volley[$i]);
        };

        $arr = [];
        foreach($volley as $v){
            if($v['state']==0){
                $state = "充值中断";
                $msg = "请检查您的余额是否充足";
            }else if($v['state']==1){
                $state = "充值成功";
                $msg = "感谢您对我们的支持";
            }
            $times = strtotime($v['addtime']);
            $arr[] = array(
                "time"=>@date("m-d H:i:s",$times),
                "price"=>$v['price'],
                "state"=>$state,
                "msg"=>$msg,
                "number"=>$v['numbers']
            );
        }
        $data = [
            "result"=>$arr
        ];

        $result = ['code' => 200,'data' =>$data,'msg'=>'操作成功'];
        $this->ajaxReturn($result);          
    }

    //提现
    public function tixian()
    {
        $money = $_REQUEST['money'];
        $userid = $_REQUEST['user_id'];
        $time = date("Y-m-d H:i:s")+259200;
        $insertArr = array(
            "userid"=>$userid,
            "money"=>$money,
            "daotime"=>$time
        );

        myinsert('withdraw',$insertArr);
        $Model = M();
        $res = $Model->execute("update jieqi_system_users set egold=egold-".$money." where uid=".$userid."");

        if($res !== false){
            $returnarr = ['code' => 200,'msg'=>'提现成功'];           
        }else{
            $returnarr = ['code' => 220,'msg'=>'提现失败'];
        }
        $this->ajaxReturn($returnarr);       
    }

    //获取用户的提现记录
    public function getRecord()
    {
        $userid = $_REQUEST['user_id'];
        $Model = M();
        $resultlist = $Model->Query("select t.money,t.addtime,t.daotime,t.state,t1.bankcard,t1.postname from withdraw t,jieqi_system_users t1 where t.userid=".$userid." and t1.uid=t.userid order by t.id desc");

        $returnarr = ['code' => 200,'data' =>$resultlist,'msg'=>'操作成功'];

        $this->ajaxReturn($returnarr);
    }

    //提交绑定银行卡信息
    public function tobankcard()
    {
        $uid = $_REQUEST['user_id'];
        $bankcard = $_REQUEST['bankcard'];
        $postname = $_REQUEST['postname'];
        $bank_name = $_REQUEST['bank_name'];

        $data = [
            'bankcard' => $bankcard,
            'bank_name' => $postname,
            'postname'  => $postname
        ];

        $res = M('jieqi_system_users')->where('uid='.$uid)->save($data);

        if($res !== false) {
            $returnarr = ['code' => 200,'msg'=>'提交成功'];          
        }else{
            $returnarr = ['code' => 220,'msg'=>'提交失败'];
        }
        $this->ajaxReturn($returnarr);                        
    } 
   
}
 

?>
