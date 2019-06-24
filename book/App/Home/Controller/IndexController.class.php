<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php"); 
include_once("mysqlha.php");
header('Content-type:text/html;charset=utf-8'); 

class IndexController extends Controller { 
    //测试
    public function index2(){   
        $time = date('Y-m-d H:i:s',time());
        echo "2017-09-16 16:25:46".S('ceshi').'||'.$time."<br/>";
        echo S('component_verify_ticket_wx54756e40d1f8a5ea')."<br/>";
        echo S('component_access_token_wx54756e40d1f8a5ea');  
    }  
    
    //测试  
    public function index3(){  
        // vendor("phpWxbiz.wxBizMsgCrypt");   
        // $wxData = C("platform_setting");
        // $encodingAesKey = $wxData['encodingAesKey'];     
        // $token = $wxData['token'];  
        // $appId = $wxData['appId'];  
        // $wx = new \WXBizMsgCrypt($token, $encodingAesKey, $appId);
        // var_dump($wx);     
        echo 11;    
    }  
    
     /**
     * 授权事件接收URL  接收微信服务器推送的信息
     */
    public function msg() {    
        //获取微信服务器信息 
        $timestamp = empty($_GET ['timestamp']) ? '' : trim($_GET ['timestamp']);
        $nonce = empty($_GET ['nonce']) ? '' : trim($_GET ['nonce']);
        $msgSign = empty($_GET ['msg_signature']) ? '' : trim($_GET ['msg_signature']);
        $encryptType = empty($_GET ['encrypt_type']) ? '' : trim($_GET ['encrypt_type']);
        $encryptMsg =file_get_contents('php://input');

        //读取配置好的第三方配置信息
        $wxData = C("platform_setting"); 
        $encodingAesKey = $wxData['encodingAesKey']; 
        $token = $wxData['token']; 
        $appId = $wxData['appId'];

        //解密
        vendor("phpWxbiz.wxBizMsgCrypt");  
        $Wxcrypt = new \WXBizMsgCrypt($token, $encodingAesKey, $appId);  
        $xml_tree = new \DOMDocument();   
        $xml_tree->loadXML($encryptMsg);   
        $array_e = $xml_tree->getElementsByTagName('Encrypt');     
        $encrypt = $array_e->item(0)->nodeValue;  
        $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
        $fromXml = sprintf($format,$encrypt); //$postArr['Encrypt']
        //第三方收到公众号平台发送的消息  
        $msg = ''; 
        $errCode = $Wxcrypt->decryptMsg($msgSign,$timestamp,$nonce,$fromXml,$msg); // 解密

        if ($errCode == 0) {          

            $xml = new \DOMDocument();     
            $xml->loadXML($msg);     
            $array2 = $xml->getElementsByTagName('ComponentVerifyTicket');
            $array3 = $xml->getElementsByTagName('InfoType');
            $array4 = $xml->getElementsByTagName('AuthorizerAppid');//小程序appid
            $component_verify_ticket = $array2->item(0)->nodeValue;
            $InfoType = $array3->item(0)->nodeValue;    
            $AuthorizerAppid = $array4->item(0)->nodeValue;  
   
            // $fp = fopen('abc.txt','a+'); 
            // fwrite($fp,'infotype:'.$InfoType."\r\n".'authorizerappid:'.$AuthorizerAppid."\r\n");  
            // fclose($fp);        
 
            switch ($InfoType) {   
                case 'component_verify_ticket' :    // 授权凭证
                    S('component_verify_ticket_'.$appId, $component_verify_ticket); //缓存起来覆盖起来一直变    
                    break;
                case 'unauthorized' :                // 取消授权 
                    $Model = M();
                    $Model->execute("DELETE FROM wxshop WHERE auth_appid='".$AuthorizerAppid."';"); 
                    break;
                case 'authorized' :                 // 授权
                    break;
                case 'updateauthorized' :           // 更新授权
                    break;
            }
        }
        exit("success");
    }


        //模拟get和post提交
 public function https_request($url,$data = null) {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//请求协议
        if(!empty($data))
        {
          curl_setopt($ch,CURLOPT_POST,1); //模拟POST 
          curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data, JSON_UNESCAPED_UNICODE)); //POST内容
        }
        
        $outopt = curl_exec($ch);  
        curl_close($ch); 
        $outopt = json_decode($outopt,true); 
        return $outopt;
  }

    //.获取自己接口的调用凭据component_access_token(也叫令牌)
    public function getComponent_access_toke(){
         $wxData = C("platform_setting");  
        //1. 取得component_verify_ticket
        $vt = S('component_verify_ticket_'.$wxData['appId']);//微信服务器推送的ticket.
        $at = S('component_access_token_'.$wxData['appId']);//调用凭证
         
        //2. 获取第三方平台component_access_token 
        if (empty($at) && !empty($vt)) {//$at有值假，$vt有值就是真 
            $url2 = "https://api.weixin.qq.com/cgi-bin/component/api_component_token";
            $post = array();
            $post['component_appid'] = $wxData['appId'];
            $post['component_appsecret'] = $wxData['appsecret'];
            $post['component_verify_ticket'] = $vt;
            $return2 = $this->https_request($url2, $post);    
            if (isset($return2['component_access_token'])) {  
                $at = $return2['component_access_token'];//调用接口凭证
                S('component_access_token_'.$wxData['appId'],$at,6600); //缓存1小时50分钟 = 6600秒
                $handle = fopen('./twohour.txt','a+'); 
                fwrite($handle,'||data:'.date('Y-m-d H:i:s')."\r\n");   
                fclose($handle);   
                return $at; 
            } else {
                return false;
            }
        }
        return $at;  
    } 



    //获取预预授权码pre_auth_code
    public function getPre_auth_code(){    
        // import("@.ORG.HttpTool");
        $wxData = C('platform_setting');     
        $appId = $wxData['appId'];
        // $HT = new \Org\HttpTool();   
        $at = $this->getComponent_access_toke();//$HT->getComponentAccessToken();//查看是否已经得到该值。//检测第三方平台component_access_token值
        if ($at) {
            //3.获取预授权码pre_auth_code 
            $url3 = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token={$at}";
            $post = array(); 
            $post['component_appid'] = $appId;//服务方appid
            $return3 = $this->https_request($url3, $post);//获得域授权码
            if (isset($return3['pre_auth_code'])) {
                $preauthcode = $return3['pre_auth_code'];   
                $redirectUrl = C('site_url') . U("Home/Index/getSuccess");//, array('uid' =>1)
                $weixinUrl = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$appId}&pre_auth_code={$preauthcode}&redirect_uri={$redirectUrl}"; 
                redirect($weixinUrl);    
                exit;
            } 
        }
        $this->error("亲, 授权失败了！");  
    } 

    //使用授权码换取公众号的接口调用凭证和授权信息  
    public function getSuccess(){
        // $HT = new \Org\HttpTool(); 
        $authcode = $_GET['auth_code'];//获取回调的授权码
        // $uid = $_GET['uid']; 
        $wxData = C('platform_setting');  
        $caccessToken = $this->getComponent_access_toke();//$HT->getComponentAccessToken();//检测第三方平台component_access_token值 
        $url1 = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token={$caccessToken}";
        $post = array(); 
        $post['component_appid'] = $wxData['appId'];//第三方平台appid
        $post['authorization_code'] = $authcode;//授权code,会在授权成功时返回给第三方平台，详见第三方平台授权流程说明
        $return = $this->https_request($url1, $post);
        // $handle =  fopen('./get.txt','a+'); 
        // fwrite($handle,'authcode:'.$authcode.'||caccessToken:'.$caccessToken.'||return:'.$return['authorization_info']['authorizer_appid']);
        // fclose($handle);   
        if (isset($return['authorization_info'])) {//获得授权方appid.
            $authinfo = $return['authorization_info']; 

            $authid = $authinfo['authorizer_appid'];//授权方appid
            // $deadline = $authinfo['expires_in']; //7200秒
            $accessToken = $authinfo['authorizer_access_token'];// 授权方接口调用凭据（在授权的公众号或小程序具备API权限时，才有此返回值），也简称为令牌
            $refreshToken = $authinfo['authorizer_refresh_token'];//此处token是2小时刷新一次，开发者需要自行进行token的缓存，避免token的获取次数达到每日的限定额度
            $funcInfo = $authinfo['func_info'];//公众号授权给开发者的权限集列表

 

            //2. 获取授权方的公众号帐号基本信息 
            $url2 = "https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token={$caccessToken}";//获取授权方的帐号基本信息
            $post = array();
            $post['component_appid'] = $wxData['appId'];//服务appid
            $post['authorizer_appid'] = $authid;//授权方appid
            $return2 = $this->https_request($url2, $post); 

            //测试
            // $handle =  fopen('./get.txt','a+'); 
            // fwrite($handle,'authid:'.$authid);
            // fclose($handle);  


            if (isset($return2['authorizer_info'])) {//如果有返回信息
                $wxinfo = $return2['authorizer_info']; //授权方的appid
                $fcinfo = $return2['authorization_info'];//有以下数据appid、func_info
                $Wxuser = M("wxshop");   

                //是否已经存在
                $extFilter = array();  
                $extFilter['auth_appid'] = $fcinfo['authorizer_appid'];//授权方appid
                $isExt = $Wxuser->where($extFilter)->find();//find方法没查询到放回null  查看是否已经存在这个公众号appid

                $wxuser = array();
                // $wxuser['token'] = $this->getToken();  
                // $wxuser['bind_type'] = 1; 
                $wxuser['wxid'] = $wxinfo['user_name'];     //原始ID  
                $wxuser['wxname'] = $wxinfo['nick_name'];   //昵称
                $wxuser['weixin_type'] = $wxinfo['service_type_info']['id'];  //微信类型  授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号
                $wxuser['weixin'] = $wxinfo['alias'];       //微信号 
                $wxuser['headerpic'] = $wxinfo['head_img']; //头像
                $wxuser['auth_appid'] = $fcinfo['authorizer_appid'];//授权方appid
                $wxuser['auth_access_token'] = $accessToken;//授权方令牌
                $wxuser['auth_refresh_token'] = $refreshToken;//授权方刷新令牌
                $wxuser['auth_functions'] = json_encode($fcinfo['func_info']);//公众号授权给开发者的权限集列表
                $wxuser['auth_business_info'] = json_encode($wxinfo['business_info']);//用以了解以下功能的开通状况（0代表未开通，1代表已开通）
                $wxuser['create_time'] = date('Y-m-d H:i:s',time()); 
                $wxuser['deadline'] = time()+6800;  
                $admin_id = session('admin_user_info');//获取后台登录主键id
                $wxuser['admin_id'] = $admin_id;
                if ($isExt) { //如果该公众号已在数据表
                    //数据库存在这个小程序appid
                    
                    if($isExt['admin_id']==$admin_id){
                        $sign = $Wxuser->where($extFilter)->save($wxuser);//处理丢失的刷新令牌重新加入的。
                    }else{
                         $this->error("亲，你绑定的小程序已经被绑定过了，请更换未绑定的小程序", U('Admin/Wxshop/shenqing'));

                                               }
                }else{
                    $sign = $Wxuser->add($wxuser);
                    //修改小程序服务器网址    
                    $this->modify_domain($fcinfo['authorizer_appid']);
                }
                if ($sign) {
                    redirect(C('site_url').U('Admin/Wxshop/lst'));  
                } 
            }
        }
        $this->error("亲，获取授权信息失败！", U('Admin/Wxshop/shenqing'));  
    }

         //修改服务器地址   
    private function modify_domain($appid){       
        //获取小程序的调用凭证
        $access_token = $this->shua_code($appid);   
        //提交数据
        $post = array(  
            "action"=>"add",       
            "requestdomain"=>array("https://www.youdingb.com","https://www.youdingb.com"),
            "wsrequestdomain"=>array("wss://www.youdingb.com","wss://www.youdingb.com"),
            "uploaddomain"=>array("https://www.youdingb.com","https://www.youdingb.com"),
            "downloaddomain"=>array("https://www.youdingb.com","https://www.youdingb.com")
            );
        $url = "https://api.weixin.qq.com/wxa/modify_domain?access_token={$access_token}";
        $this->https_request($url,$post);//post请求 
    }

    


    //刷新小程序调用凭证  authorization_code 
    public function shua_code($appid){ 
        $Model = M();
        $data = $Model->Query("SELECT auth_access_token,auth_refresh_token,deadline FROM wxshop WHERE auth_appid='".$appid."';");
        $data = $data[0];
        if($data['deadline']==''){ 
            return false; 
        } 
        if(time()>$data['deadline']){     
            //过期
            $caccessToken = $this->getComponent_access_toke();  
            $url = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token={$caccessToken}";
            $post = array();
            $wx_san = C('platform_setting'); 
            $component_appid = $wx_san['appId'];  
            $post['component_appid'] = $component_appid;
            $post['authorizer_appid'] = $appid;
            $post['authorizer_refresh_token'] = $data['auth_refresh_token'];    
            $return = $this->https_request($url, $post); 
            $authorization_code = $return['authorizer_access_token']; 
            $auth_refresh_token = $return['authorizer_refresh_token']; 
            $deadline = time()+6800;  
            $Model->execute("UPDATE wxshop SET auth_access_token='".$authorization_code."',auth_refresh_token='".$auth_refresh_token."',deadline='".$deadline."' WHERE auth_appid='".$appid."';");    
        }else{  
            $authorization_code = $data['auth_access_token']; 
        } 
        return $authorization_code;  
    } 


    /*
    *获取用户信息
     */
    public function getuserinfo(){ 
          $code = $_REQUEST['code'];
          $appid = $_REQUEST['extAppId'];//小程序appid.
          $userinfo = $_REQUEST['userinfo']; 
          $data = array();
          //根据授权方appid查出authorization_code
           $authorization_code = $this->shua_code($appid);

          //获取第三方的appid 
          $wx_san = C('platform_setting');  
          $component_appid = $wx_san['appId'];  
 
          //获取第三方平台的token
          $ACCESS_TOKEN = $this->getComponent_access_toke(); 

          //获取openid和session_key   
          $getopenidurl = "https://api.weixin.qq.com/sns/component/jscode2session?appid=".$appid."&js_code=".$code."&grant_type=".$authorization_code."&component_appid=".$component_appid."&component_access_token=".$ACCESS_TOKEN."";   

          $result = $this->https_request($getopenidurl); 
          //$result = json_decode($result,true);//把用户openid转成数组形式
          $userinfo = json_decode($userinfo,true);//把用户信息转成数组形式

          $data['openid'] = $result['openid'];
          $data['session_key'] = $result['session_key']; 
          $data['nickName'] = $userinfo['nickName'];
          $data['gender'] = $userinfo['gender'];
          $data['city'] = $userinfo['city'];
          $data['province'] = $userinfo['province']; 
          $data['country'] = $userinfo['country'];
          $data['avatarUrl'] = $userinfo['avatarUrl'];//超链接头像
          $data['wxshop_appid'] = $appid;  

          $Model = M('user'); 
          $user = $Model->Query("SELECT user_id FROM user WHERE openid='".$data['openid']."';");
          $user_id = $user[0]['user_id']; 
          if($user_id){   
            //更新操作
            $jieguo = $Model->where('user_id='.$user_id)->data($data)->save();
            if($jieguo===false){ 
                $result = array('code'=>201,"msg"=>"更新失败","nickName"=>$data['nickName']);
            }else{
                $_3rd_session = _3rd_session($data['openid'].$data['session_key']);//生成3rd_session
                S(array($_3rd_session=>$data['openid'].','.$data['session_key'],'expire'=>7200));  
                $result = array('code'=>200,"msg"=>"更新成功","_3rd_session"=>$_3rd_session,"user_id"=>$user_id);   
             }    
          }else{
            //添加操作  
            $jieguo = $Model->data($data)->add();
            if($jieguo){ 
                $_3rd_session = _3rd_session($data['openid']);//生成3rd_session
                S(array($_3rd_session=>$data['openid'].','.$data['session_key'],'expire'=>7200));
                $result = array('code'=>200,"_3rd_session"=>$_3rd_session,"user_id"=>$jieguo); 
            }else{   
                $result = array('code'=>201,"msg"=>"添加失败");  
            }
          }
          //增加浏览量 
          $current = $Model->Query("SELECT id FROM pageview WHERE to_days(addtime)=to_days(now()) AND wxshop_appid='".$appid."';");
          if($current){
              $Model->execute("UPDATE pageview SET count=`count`+1 WHERE wxshop_appid='".$appid."';");
          }else{
              $Model->execute("INSERT INTO  pageview (`wxshop_appid`) VALUES ('".$appid."');"); 
          }
          $this->ajaxReturn($result); 
    } 



    //获取商家店名
    public function getshopname(){
        $appid = $_REQUEST['appid'];
        $Model = M(); 
        $data = $Model->Query("SELECT wxname,headerpic FROM wxshop WHERE auth_appid='".$appid."';");
        $wxname = $data[0]['wxname'];
        $headerpic = $data[0]['headerpic'];
        echo '{"code":"200","wxname":"'.$wxname.'","headerpic":"'.$headerpic.'"}'; 
    }


    //模板号：
    public function commit_view(){ 
      $access_token = $this->getComponent_access_toke(); //获取自己的第三方调用凭证 
      $url = "https://api.weixin.qq.com/wxa/gettemplatelist?access_token={$access_token}";
      $result = $this->https_request($url); //get请求
      $result = $result['template_list']; 
      echo json_encode($result);  
    }



    










 



/*************************万恶的分隔线***************************************/







    //授权页面
    public function shouquan(){
        $this->display(); 
    }


      public function testhttp(){   
        $post = array(); 
        $wxdata = C('platform_setting');  
        $authcode = "queryauthcode@@@uJFMczIya-BLojQ2mIfq0Us91M3mzqEV0_vGZbScw73OyK7CgSyaUZdQtmgaBGbzPrR5w1WceAKPz4nx5EDRNQ";  
        $caccessToken = "yLJrK3Z9UREDqGPz3goV-56PrY3pdCFwq3RY2WPfV5L1crPwghP5D6tnBh1UHYK8qXECHDqAWpLO9L8NJmVsBxmPI73ZbmYyPgUHv4ZaS2WPQy3zUNHs2AM0el8SX8AzPVGhAJASYJ";
       $url1 = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=".$caccessToken."";
        $post['component_appid'] = $wxdata['appId'];//第三方平台appid 
        $post['authorization_code'] = $authcode;//授权code,会在授权成功时返回给第三方平台，详见第三方平台授权流程说明
        $return = $this->https_request($url1,$post); 
        var_dump($return);       
    }





    //公众号消息与事件接收URL    
    public function index() {    
        $timestamp = empty($_GET['timestamp']) ? '' : trim($_GET['timestamp']);  
        $nonce = empty($_GET['nonce']) ? '' : trim($_GET ['nonce']);  
        $msgSign = empty($_GET['msg_signature']) ? '' : trim($_GET['msg_signature']);  
        $signature = empty($_GET['signature']) ? '' : trim($_GET['signature']);  
        $encryptType = empty($_GET['encrypt_type']) ? '' : trim($_GET['encrypt_type']);  
        $openid = trim($_GET['openid']);   

        $input = file_get_contents('php://input');    

        $xml_tree = new \DOMDocument();  
        $xml_tree->loadXML($encryptMsg);   
        $array_e = $xml_tree->getElementsByTagName('Encrypt');     
        $encrypt = $array_e->item(0)->nodeValue;


  
        //解密  
        $wxData = C("platform_setting");  
        $encodingAesKey = $wxData['encodingAesKey'];   
        $token = $wxData['token'];  
        $appId = $wxData['appId'];  
        //引入文件  
        vendor("phpWxbiz.wxBizMsgCrypt");  
        $Wxcrypt = new \WXBizMsgCrypt($token, $encodingAesKey, $appId);
        $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";  
        $fromXml = sprintf($format, $paramArr['Encrypt']);   
        $errCode = $Wxcrypt->decryptMsg($msgSign, $timestamp, $nonce, $fromXml, $toXml); // 解密 

        if ($errCode == 0) {  
            $param = new \DOMDocument();     
            $param->loadXML($toXml);     
            // $array_e = $xml->getElementsByTagName('ComponentVerifyTicket');
            // $array_s = $xml->getElementsByTagName('InfoType'); 
            // $component_verify_ticket = $array_e->item(0)->nodeValue;
            // $InfoType = $array_s->item(0)->nodeValue;

            $keyword = isset($param['Content']) ? trim($param['Content']) : '';  
            // 案例1 - 发送事件  
            if (isset($param['Event']) && $paramArr['ToUserName'] == 'gh_3c884a361561') {  
                $contentStr = $param ['Event'].'from_callback';  
            }  
            // 案例2 - 返回普通文本  
            elseif ($keyword == "TESTCOMPONENT_MSG_TYPE_TEXT") {  
                $contentStr = "TESTCOMPONENT_MSG_TYPE_TEXT_callback";  
            }  
            // 案例3 - 返回Api文本信息  
            elseif (strpos($keyword, "QUERY_AUTH_CODE:") !== false) {  
                import("@.ORG.HttpTool");  
                $authcode = str_replace("QUERY_AUTH_CODE:", "", $keyword);  
                $contentStr = $authcode . "_from_api";  
                $HT = new HttpTool();  
                $authDetail = $HT->getAccessTokenByAuthCode($authcode);  
                $accessToken = $authDetail['authorizer_access_token'];   
                $HT->sendFansText($accessToken, $param['FromUserName'], $contentStr);  
                //$tokenInfo = WechatOpenApiLogic::getAuthorizerAccessTokenByAuthCode($ticket);  
                //$param ['authorizerAccessToken'] = $tokenInfo ['authorization_info'] ['authorizer_access_token'];  
                //self::sendServiceMsg($param['FromUserName'], $param['ToUserName'], 1, $contentStr); // 客服消息接口  
                return 1;  
            }  
  
            $result = '';  
            if (!empty($contentStr)) {  
                $xmlTpl = "<xml>  
            <ToUserName><![CDATA[%s]]></ToUserName>  
            <FromUserName><![CDATA[%s]]></FromUserName>  
            <CreateTime>%s</CreateTime>  
            <MsgType><![CDATA[text]]></MsgType>  
            <Content><![CDATA[%s]]></Content>  
            </xml>";  
                $result = sprintf($xmlTpl, $param['FromUserName'], $param['ToUserName'], time(), $contentStr);  
                if (isset($_GET['encrypt_type']) && $_GET['encrypt_type'] == 'aes') { // 密文传输  
                    $wxData = C("platform_setting");   
                    $msgCryptObj = new \WXBizMsgCrypt($wxData['token'], $wxData['encodingAesKey'], $wxData['appId']);  
                    $encryptMsg = '';  
                    $msgCryptObj->encryptMsg($result, $_GET['timestamp'], $_GET['nonce'], $encryptMsg);  
                    $result = $encryptMsg;  
                }  
            }  
            echo $result;  
        }  
    } 



     public function shuza()
    {
         //查询是否加入书架
      $cha['articleid']=I('id');
        $cha['flag']=0;
      $cha['userid']=I('uid');

      $shujia=M('jieqi_article_bookcase')->where($cha)->find();
        if($shujia>0){
             $result = array(
                "code"=>200,
                "shujia"=>'已加书架',
              
               
            );
           
        }else{
             $result = array(
                "code"=>220,
                "shujia"=>'未加书架',
               
            );
        }
        
       
       
         echo json_encode($result);
     
    }

    public function shuzha()
    {
         //查询是否加入书架
        $cha['articleid']=I('id');
        $cha['flag']=0;
        $cha['userid']=session('user_id');
        $shujia=M('jieqi_article_bookcase')->add($cha);
        if($shujia>0){
             $result = array(
                "code"=>200,
                "shujia"=>'已加书架',
               
            );
           
        }else{
             $result = array(
                "code"=>220,
                "shujia"=>'未加书架',
               
            );
        }
        
       
       
         echo json_encode($result);
     
    }











}