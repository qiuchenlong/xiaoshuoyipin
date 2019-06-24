<?php
define("KEY_PRIVATE", "
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCpvdExvx5zybwFboU1NSjuIghiuXNQSNiJ27G8iETbJdhtibKv
TlbyzBVhq0brhnG16MG29pf8055zwODYKpWC+hPVJTflzhcYEVEqRpstq9q2BHe7
5ErRgjYIQiNGZJ11czQUj82TgDP3xMKntpchel5J3XbYfGjMzG3nARoOpwIDAQAB
AoGAa42A3hqReyCaaH6tHRfABZO+6H9Fl9twiXmRVzqpFosWZeHYPMhQw6uY6LgU
Sex4ZKFFDV+W0nZsckAGuDHTZY+j9mrmz+DJLknBFSqIr29T4bPRDEkCKgQSALAE
Xu3XRDeichbQPbg1D79Stisg74Exu4w96cRiKUb4Gv4UeUECQQDf3rqH1Cf/ILZT
TWfVGknOYAITWXWrcgOGfetZElYlIoDdV0hMK9+JZFRNTODUcbftuEm0Fzssof5J
CoDPYkzRAkEAwhpWA3vQ/u4zXWED4QnGFsqnd1V8WUiKrKYxfQowNndUhEOXeSoz
cx0RoSTJZkzzEsAJRftGpRXwuJHbgmsh9wJASM6lF3u2LlEzOtBXzoSoMEglJKnZ
jRKdduYI3oUKIzWfd1zllHBIWOSaTjGMhUseqF9hCQLtKczdaF/UGJ49oQJAGLEi
+gR5PMTukdVymeEVavbSwPKGBBGfWoE10HNIWNVrUfwLO+Wrb9xlzrsQR8xIK710
MIvbm8qjuccMRpX8VwJBAJ7J8s0A7MBuKu89esWw0Rx6lkxy2cmHqOT4h1yN2HTV
WgygOJ/d+KdmPBoPeLI4cMj7hmH243hZcrN0qF9Q9BE=
-----END RSA PRIVATE KEY-----
");

//解密方法
function decrypt($msg){
    $decrypted = "";

    openssl_private_decrypt(base64_decode($msg),$decrypted,KEY_PRIVATE);//私钥解密
    return $decrypted;
}

function getParamArr($ParamStr){

    if(!$ParamStr){
        $ParamStr = 'z';
    } 

    $ParamStr = $_REQUEST[$ParamStr];

    $pattern = "/\[([^=]+)=\{\{(.*?)\}\}\]/";

    preg_match_all($pattern, $ParamStr,$match);

    $Params = array();
    for($i=0;$i<count($match[1]);$i++){
        $Params[$match[1][$i]] = strval($match[2][$i]);
    }

    return $Params; 
}

//去重
function assoc_unique($arr, $key) {    
    $tmp_arr = array();   
    foreach($arr as $k => $v) {   
        if(in_array($v[$key],$tmp_arr)){    
            unset($arr[$k]);    
        } else {       
            $tmp_arr[] = $v[$key];   
        }    
    }    
    $arr = array_values($arr); 
    return $arr;       
}    


function extend_1($file_name)     
{ 
    $retval=""; 
    $pt=strrpos($file_name, "."); 
    if ($pt) $retval=substr($file_name, $pt+1, strlen($file_name) - $pt); 
    return ($retval); 
} 


function getPostParamArr($ParamStr){

    if(!$ParamStr){
        $ParamStr = 'z';
    }

    $ParamStr = urldecode($_POST[$ParamStr]);
    $pattern = "/\[([^=]+)=\{\{(.*?)\}\}\]/";

    preg_match_all($pattern, $ParamStr,$match);

    $Params = array();
    for($i=0;$i<count($match[1]);$i++){
        $Params[$match[1][$i]] = strval($match[2][$i]);
    }

    return $Params;
}

//解开参数
function getRsaPostParamArr($ParamStr){

    if(!$ParamStr){
        $ParamStr = 'z';
    }

    $ParamStr = decrypt($_POST[$ParamStr]);

    $pattern = "/\[([^=]+)=\{\{(.*?)\}\}\]/";

    preg_match_all($pattern, $ParamStr,$match);

    $Params = array();
    for($i=0;$i<count($match[1]);$i++){
        $Params[$match[1][$i]] = strval($match[2][$i]);
    }

    return $Params;
}

function getSuccessJson($list,$errorname){
    $JsonArr = array();
    $JsonPrefix = strtolower(CONTROLLER_NAME."_".ACTION_NAME);

    $JsonArr["code"] = 200;
    $JsonArr["result"] = array();
    if($errorname){
        $JsonArr["errorname"] = $errorname;
    }else{
        $JsonArr["errorname"] = "操作失败"; 
    }
    if(sizeof($list) == 1){
        if($list[0] == null){
            $JsonArr['result']=[];
            return json_encode($JsonArr,JSON_UNESCAPED_UNICODE); 
        }else{
            $JsonArr['result']=$list[0];
            return json_encode($JsonArr,JSON_UNESCAPED_UNICODE);
        }
    }
    foreach ($list as $key => $value){
        if(!is_numeric($key)){
            $JsonArr["result"][$key] = $value;
        }
    }

    foreach ($list as $key => $value){
        if(is_numeric($key)){
            $key = $JsonPrefix."_list".(intval($key)+1);
            $JsonArr["result"][$key] = $value;
        }
    }
    return json_encode($JsonArr,JSON_UNESCAPED_UNICODE);
}

function getErrorJson($error,$errorname){
    $JsonArr = array();
    $JsonPrefix = strtolower(CONTROLLER_NAME."_".ACTION_NAME);

    if($error){
        $JsonArr["error"] = $error;
    }else{
        $JsonArr["error"] = "10001";
    }
    if($errorname){
        $JsonArr["errorname"] = $errorname;
    }else{
        $JsonArr["errorname"] = "操作失败";
    }
    return json_encode($JsonArr,JSON_UNESCAPED_UNICODE);
}
 

//生成随机数
function getRandChar($length){
   $str = null;
   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
      $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
 }
 
 //计算时间
 function time_tran($the_time,$re_time) {  
    $now_time = date("Y-m-d H:i:s", time());  
    //echo $now_time;  
    $now_time = strtotime($now_time);  
    $show_time = strtotime($the_time);  
    $dur = $now_time - $show_time;  
	
    if ($dur < 0) {  
        return $the_time;  
    } else {  
        if ($dur < 60) {  
            return $dur . '秒前';  
        } else {  
            if ($dur < 3600) {  
                return floor($dur / 60) . '分钟前';  
            } else {  
                if ($dur < 86400) {  
                    return floor($dur / 3600) . '小时前';  
                } else {  
                    if ($dur < 259200) {//3天内  
                        return floor($dur / 86400) . '天前';  
                    } else {  
					    if($re_time){
						   return $re_time;  
						}else{
                           return $the_time;
                        }						   
                    }  
                }  
            }  
        }  
    }  
}  

//获取金钱详情
function getMD($money){
	$result = "";
	if($money>=0&&$money<100){
		$result=$money."元";
	}else if($money>=100&&$money<1000){
		$b = (int)$money/100;
		$result=$b."百元";
	}else if($money>=1000&&$money<10000){
		$b = (int)$money/1000;
		$result=$b."千元";
	}else if($money>=10000){
		$b = (int)$money/10000;
		$result=$b."万元";
	}
	return $result;
}
  
