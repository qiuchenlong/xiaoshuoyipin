<?php
namespace Home\Controller;
use Think\Controller;
 
class WfxkefuController extends Controller{
	public function index(){
	     //判断是否为认证　
         if(isset($_GET['echostr'])){ 
            //如果认证去验证
            $this->cunfile('kefu1.txt','验证:'.date('Y-m-d H:i:s',time())."\r\n"); 
            $this->valid();
        }else{ 
          //否则接收客户发送消息
            $this->responseMsg(); 
        } 
        
    } 

     public function cunfile($file,$data){
        $fp = fopen($file,'a+');
        fwrite($fp,$data);
        fclose($fp);
     }

 
    //验证前置方法  
    public function valid()    
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){ 
            header('content-type:text');
            echo $echoStr;
            exit;
        }else{
            echo $echoStr.'+++'.TOKEN;
            exit;
        }
    }
 

      //签名校验
    private function checkSignature()
    {
    //微信加密签名
        $signature = $_GET["signature"];
       //时间戳
        $timestamp = $_GET["timestamp"];
       //随机数
        $nonce = $_GET["nonce"];
       //服务端配置的TOKEN
        $token = 'feixiang';
        //将token,时间戳,随机数进行字典排序
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING); 
         //拼接字符串
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1($tmpStr );
    
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"]; 
        // $this->cunfile('kefu2.txt','验证:'.date('Y-m-d H:i:s',time()).'::'.$postStr."\r\n");  

        if (!empty($postStr) && is_string($postStr)){	   
            
            //$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $postArr = json_decode($postStr,true);
            if(!empty($postArr['MsgType']) && $postArr['MsgType'] == 'text'){   //文本消息
                $fromUsername = $postArr['FromUserName'];   //发送者openid
                $toUserName = $postArr['ToUserName'];       //小程序id
                $textTpl = array(
                    "ToUserName"=>$fromUsername, 
                    "FromUserName"=>$toUserName,
                    "CreateTime"=>time(),
                    "MsgType"=>"transfer_customer_service",
                );
                exit(json_encode($textTpl));
            }elseif(!empty($postArr['MsgType']) && $postArr['MsgType'] == 'image'){ //图文消息
                $fromUsername = $postArr['FromUserName'];   //发送者openid
                $toUserName = $postArr['ToUserName'];       //小程序id
                $textTpl = array(
                    "ToUserName"=>$fromUsername,
                    "FromUserName"=>$toUserName, 
                    "CreateTime"=>time(), 
                    "MsgType"=>"transfer_customer_service",
                );
                exit(json_encode($textTpl)); 
            }elseif($postArr['MsgType'] == 'event' && $postArr['Event']=='user_enter_tempsession'){ //进入客服动作
               // $this->cunfile('kefu2.txt','token:'.date('Y-m-d H:i:s',time()).'::limingjie'."\r\n");  

                $fromUsername = $postArr['FromUserName'];   //发送者openid
                $content = '您好，有什么能帮助你?';
                $data=array(
                    "touser"=>$fromUsername,
                    "msgtype"=>"text", 
                    "text"=>array("content"=>$content)
                ); 
                $json = json_encode($data,JSON_UNESCAPED_UNICODE);  //php5.4+
                
                $access_token = $this->get_accessToken();
                /* 
                 * POST发送https请求客服接口api
                 */ 

                $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
                //以'json'格式发送post的https请求
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
                if (!empty($json)){
                    curl_setopt($curl, CURLOPT_POSTFIELDS,$json);
                }
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                //curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
                $output = curl_exec($curl);
                if (curl_errno($curl)) {
                    echo 'Errno'.curl_error($curl);//捕抓异常
                }
                curl_close($curl);
                if($output == 0){
                    echo 'success';exit; 
                }
                
            }else{
                exit('aaa');
            }
        }else{
            echo "";
            exit;
        }
    }

    /* 调用微信api，获取access_token，有效期7200s -xzz0704 */
    public function get_accessToken(){
        /* 在有效期，直接返回access_token */
        if(S('wfxaccess_token')){
            return S('wfxaccess_token'); 
        }
        /* 不在有效期，重新发送请求，获取access_token */ 
        else{
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx0ba806b9709f9b26&secret=44c95537e5b215e723913259daaad924';
            $result = $this->http_request($url);
            $res = json_decode($result,true);   //json字符串转数组
            if($res){
                S('wfxaccess_token',$res['access_token'],7100);
                return S('wfxaccess_token');
            }else{
                return 'api return error';
            }
        }
    }
 

    // public function message(){ 

    //     $code = $_GET['code'];
    //     $appid='wx0ba806b9709f9b26';
    //     $appSecret='e64fa3f371bb91bfc2b6c28f008f3174';
    //     $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$appSecret.'&js_code='.$code.'&grant_type=authorization_code';
    //     $res = $this->http_request($url);
    //     $res1 = json_decode($res);
    //     $access_token = $this->oauth2_access_token($code); 
    //     $this->ajaxReturn(array('data'=>$res1,'access_token'=>$access_token));
    // }

    public function oauth2_access_token($code)
     {
         $appid='wx0ba806b9709f9b26'; 
        $appSecret='e64fa3f371bb91bfc2b6c28f008f3174';
         $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appSecret."&code=".$code."&grant_type=authorization_code";
         $res = $this->http_request($url);
         return json_decode($res, true);
     }

    protected function http_request($url, $data = null)
     {
         $curl = curl_init();
         curl_setopt($curl, CURLOPT_URL, $url);
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
         if (!empty($data)){
             curl_setopt($curl, CURLOPT_POST, 1);
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         }
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
         $output = curl_exec($curl);
         curl_close($curl);
         return $output;
     }


}
?>