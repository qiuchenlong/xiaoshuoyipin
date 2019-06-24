<?php
namespace Home\Controller;
use Think\Controller;

class BuygoodsController extends Controller{

public function test(){
    //解释xml格式的操作
    $post_xml = "<xml> 
           <appid>sdfsdfsd2222</appid>
           <body>sdfasdfasd</body>
           <mch_id>werwerwe</mch_id>  
           <nonce_str>gsdfwe</nonce_str>
           <notify_url>fdsafasdfwe</notify_url>
           <openid>casdcasd</openid>
           <out_trade_no>dfaewwe</out_trade_no>
           <spbill_create_ip>asdfsdfasdf</spbill_create_ip>
           <total_fee>asdfasdfawe</total_fee>
           <trade_type>asdfasdf</trade_type> 
           <sign>fdfdfas</sign>
        </xml>"; 
    $p = xml_parser_create();
    xml_parse_into_struct($p, $post_xml, $vals, $index);
    var_dump($vals); 
    var_dump($index);
    die;
    xml_parser_free($p);  
    $data = ""; 
    foreach ($index as $key=>$value) {
        if($key == 'xml' || $key == 'XML') continue;
        $tag = $vals[$value[0]]['tag'];
        $value = $vals[$value[0]]['value'];
        $data[$tag] = $value; 
    }
  var_dump($data);  

} 
     // $sc=A("Index");   
     //微信支付 
public function Pay(){  
    $fee = $_REQUEST['fee'];//0.01;//0.01;//举例充值0.01
    $appid = $_REQUEST['appid'];//'wx65210a1c96929333';//'微信小程序的appid【自己填写】';//如果是公众号 就是公众号的appid
    $Model = M('pay_config');  
    $mch_id = $Model->where("appid='".$appid."'")->field('mchid,partnerkey')->find();
    $wx_key = trim($mch_id['partnerkey'],' '); 
    // $fp = fopen('pay.txt','a+');  
    // fwrite($fp,date('Y-m-d H:i:s').':'.$fee.','.$mch_id['mchid']);      
    // fclose($fp);   
    $body =         '商品购买';//'【自己填写】';
    $mch_id =       trim($mch_id['mchid'],' ');//'1496291252';//trim($mch_id['mchid']);//trim($mch_id);//'你的商户号【自己填写】';//根据提交小程序后台上来的进行处理 12345698778945632123654789523621
    $nonce_str =    $this->nonce_str();//'12345698778945632123654789523621';//随机字符串 
    $notify_url =   'https://www.youdingb.com/shouquan/index.php/Home/Buygoods/xiao_notify_url';//$_REQUEST['notify_url'];//'回调的url【自己填写】';
    $openid =       $_REQUEST['openid'];//'o-6UW0S7odRQMyBuFR5yHTbzDHqE';//'用户的openid【自己填写】';
    $out_trade_no = $_REQUEST['number'];//'1510189989944';//$this->order_number();//商户订单号 
    $spbill_create_ip = '39.108.194.179';//'服务器的ip【自己填写】'; 
    $total_fee =    $fee*100;//因为充值金额最小是1 而且单位为分 如果是充值1元所以这里需要*100
    $trade_type = 'JSAPI';//交易类型 默认 

    $post['appid'] = $appid;       
    $post['body'] = $body;  
    $post['mch_id'] = $mch_id;
    $post['nonce_str'] = $nonce_str;//随机字符串 
    $post['notify_url'] = $notify_url; 
    $post['openid'] = $openid;
    $post['out_trade_no'] = $out_trade_no;
    $post['spbill_create_ip'] = $spbill_create_ip;//终端的ip
    $post['total_fee'] = $total_fee;//总金额 最低为一块钱 必须是整数
    $post['trade_type'] = $trade_type; 
    $sign = $this->sign($post,$wx_key);//签名 
    // echo $sign;die;  
    $post_xml = '<xml> 
           <appid>'.$appid.'</appid>
           <body>'.$body.'</body>
           <mch_id>'.$mch_id.'</mch_id>  
           <nonce_str>'.$nonce_str.'</nonce_str>
           <notify_url>'.$notify_url.'</notify_url>
           <openid>'.$openid.'</openid>
           <out_trade_no>'.$out_trade_no.'</out_trade_no>
           <spbill_create_ip>'.$spbill_create_ip.'</spbill_create_ip>
           <total_fee>'.$total_fee.'</total_fee>
           <trade_type>'.$trade_type.'</trade_type>
           <sign>'.$sign.'</sign>
        </xml> ';
    //统一接口prepay_id
    $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    $xml = $this->http_request($url,$post_xml);  
    $array = $this->xml($xml);//全要大写 
    if($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS'){
        $time = time();
        $tmp='';//临时数组用于签名
        $tmp['appId'] = $appid;  
        $tmp['nonceStr'] = $nonce_str;//$array['NONCE_STR'];//
        $tmp['package'] = 'prepay_id='.$array['PREPAY_ID'];
        $tmp['signType'] = 'MD5';   
        $tmp['timeStamp'] = "$time";             
        $data['state'] = 1;   
        $data['timeStamp'] = "$time";//时间戳             
        $data['nonceStr'] = $nonce_str;//$array['NONCE_STR'];//nonce_str;//随机字符串 
        $data['signType'] = 'MD5';//签名算法，暂支持 MD5    
        $data['package'] = 'prepay_id='.$array['PREPAY_ID'];//统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
        $data['out_trade_no'] = $out_trade_no;         
        $data['sign'] = $this->sign($tmp,$wx_key);//$array['SIGN'];//$this->sign($tmp,$wx_key);//签名,具体签名方案参见微信公众号支付帮助文档;
        $data['result_code'] = 'SUCCESS';     
    }else{ 
        $data['state'] = 0;
        $data['text'] = "错误";   
        $data['RETURN_CODE'] = $array['RETURN_CODE'];
        $data['RETURN_MSG'] = $array['RETURN_MSG'];
    }
    echo json_encode($data);//返回给客户端。 
}




//curl请求啊
private function http_request($url,$data = null,$headers=array())
{
    $curl = curl_init();
    if( count($headers) >= 1 ){  
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}


public function ceshi(){
    $xml = "<xml>
   <return_code><![CDATA[SUCCESS]]></return_code>
   <return_msg><![CDATA[OK]]></return_msg>
   <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
   <mch_id><![CDATA[10000100]]></mch_id>
   <nonce_str><![CDATA[IITRi8Iabbblz1Jc]]></nonce_str>
   <sign><![CDATA[7921E432F65EB8ED0CE9755F0E86D72F]]></sign>
   <result_code><![CDATA[SUCCESS]]></result_code>
   <prepay_id><![CDATA[wx201411101639507cbf6ffd8b0779950874]]></prepay_id>
   <trade_type><![CDATA[JSAPI]]></trade_type>
</xml>";
$code = $this->xml($xml);
var_dump($code);
}

/* 回调操作*/
    public function xiao_notify_url(){  
        $post = $this->post_data();    //接受POST数据XML个数
        $post_data = $this->xml($post);   //微信支付成功，返回回调地址url的数据：XML转数组Array
        // $postSign = $post_data['SIGN'];
        // unset($post_data['SIGN']);
        
        // ksort($post_data);// 对数据进行排序
        $str = $this->xml($post_data);//对数组数据拼接成key=value字符串
        //$user_sign = strtoupper(md5($post_data)); //再次生成签名，与$postSign比较
        //验证码
        $where['number'] = $post_data['OUT_TRADE_NO'];
        $where['totalprice'] = $post_data['TOTAL_FEE']/100;   
        $where['status'] = 0;      
        $fp = fopen('pay.txt','a+');
        fwrite($fp,json_encode($post_data)); 
        fclose($fp); 
        $order_status = M('orders')->where($where)->find();//查询订单
        if($post_data['RETURN_CODE']=='SUCCESS'){
            if($order_status['status']=='1'){ 
                $this->return_success();
            }else{ 
                $updata['status'] = '1';   
                if(M('orders')->where($where)->save($updata)){
                    //处理逻辑star 
                    if($order_status['type']==1){
                        //拼团逻辑
                        $Pingtuan = A('Pingtuan'); 
                        if(!empty($order_status['groupbuying_id'])){//参加已有拼团队伍
                            $Pingtuan->secondBuy($order_status['id'],$order_status['groupbuying_id'],$order_status['user_id']);
                        }else{//自己另起一个团    
                            $Pingtuan->firstBuy($order_status['id'],$order_status['user_id'],$order_status['wxshop_appid']);
                        }  
                    }else{
                        //普通订单  
                    }  
                    //处理逻辑end
                    $this->return_success();
                }
            }
        }else{
            echo '微信支付失败';
        }
    } 

//签名 $data要先排好顺序
private function sign($data,$wx_key){ 
    $stringA = ''; 
    foreach ($data as $key=>$value){
        if(!$value) continue;
        if($stringA) $stringA .= '&'.$key."=".$value;
        else $stringA = $key."=".$value;
    } 
    //$wx_key = '';//注：key为商户平台设置的密钥key 
    $stringSignTemp = $stringA.'&key='.$wx_key;//申请支付后有给予一个商户账号和密码，登陆后自己设置key    
    return strtoupper(md5($stringSignTemp));
} 

//获取支付返回的数据
public function post_data(){
$receipt = $_REQUEST;  
if($receipt==null){ 
$receipt = file_get_contents("php://input");//接受微信服务器发送回来的数据
if($receipt == null){
$receipt = $GLOBALS['HTTP_RAW_POST_DATA']; //接受微信服务器发送回来的数据
}
}
return $receipt;
} 
 
//返回数据给微信服务器
private function return_success(){
    $return['return_code'] = 'SUCCESS';
    $return['return_msg'] = 'OK';
    $xml_post = '<xml> 
                <return_code>'.$return['return_code'].'</return_code>
                <return_msg>'.$return['return_msg'].'</return_msg>
                </xml>';
    echo $xml_post;exit; 
}


//将xml装换成数组(0)
private function xml($xml){ 
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml, $vals, $index);
    xml_parser_free($p);  
    $data = ""; 
    foreach ($index as $key=>$value) {
        if($key == 'xml' || $key == 'XML') continue;
        $tag = $vals[$value[0]]['tag'];
        $value = $vals[$value[0]]['value'];
        $data[$tag] = $value; 
    }
    return $data; 
} 

 
//随机32位字符串
private function nonce_str(){
    $result = '';
    $str = 'QWERTYUIOPASDFGHJKLZXVBNMqwertyuioplkjhgfdsamnbvcxz';
    for ($i=0;$i<32;$i++){ 
        $result .= $str[rand(0,48)];
    }
    return $result;
}


//生成订单号
private function order_number($openid){
    $time = explode ( " ", microtime());    
    $time = $time[1].($time[0] * 1000);
    $time2 = explode ( ".", $time); 
    $time = $time2[0];  
    return md5($openid.$time.rand(10,99));//32位 
}






}



?>