<?php 
function shouqihongbao($money,$number,$hongbao_id,$ratio = 0.5){
        $bijiao = $money;
        $res = array(); //结果数组
        $min = ($money / $number) * (1 - $ratio);   //最小值 0.9
        if($min<0.01){ 
            $min = 0.01;
        }
        $max = ($money / $number) * (1 + $ratio);   //最大值 1.1
        /*--- 第一步：分配低保 ---*/
        for($i=0;$i<$number;$i++){
            $res[$i]['hongbao_id'] = $hongbao_id;
            $res[$i]['money'] = $min;
        }
        
        $money = $money - $min * $number;//1

        /*--- 第二步：随机分配 ---*/
        $randRatio = 100;
        $randMax = ($max - $min) * $randRatio;//0.2*100=20
        for($i=0;$i<$number;$i++){
            //随机分钱
            $randRes = mt_rand(0,$randMax);
            $randRes = $randRes / $randRatio;//0-20/100
            if($money >= $randRes){ //余额充足
                $res[$i]['money']    += $randRes;
                $money      -= $randRes; 
            }
            elseif($money > 0){     //余额不足
                $res[$i]['money']    += $money;
                $money      -= $money;
            }
            else{                   //没有余额
                break; 
            }
        }
        /*--- 第三步：平均分配上一步剩余 ---*/
        if($money > 0){   
            $avg = $money / $number; 
            for($i=0;$i<$number;$i++){
                $res[$i]['money'] += $avg;
            }
            $money = 0;  
        } 
        /*--- 第四步：格式化金额(可选) ---*/
        foreach($res as $k=>$v){
            //两位小数，不四舍五入
            // preg_match('/^\d+(\.\d{1,2})?/',$v['money'],$match);
            $match[0]   = number_format($v['money'],2);
            $res[$k]['money']    = $match[0]; 
        }

        //第五步检验是否等于总数 
        $resonearr = array_column($res,'money');
        $totalmoney = array_sum($resonearr);
        if($totalmoney!=$bijiao){
            if($totalmoney<$bijiao){ 
                  //未超出 
                $resonearr = array_column($res,'money');
                $key = array_search(min($resonearr),$resonearr);
                $bu = bcsub($bijiao,$totalmoney,2);
                $res[$key]['money'] = bcadd($res[$key]['money'],$bu,2);
            }elseif($totalmoney>$bijiao){
                //超出
                $bu = bcsub($totalmoney,$bijiao,2);
                $resonearr = array_column($res,'money');
                $key = array_search(max($resonearr),$resonearr);
                $is_sub = bcsub($res[$key]['money'],$bu,2);
                if($is_sub>0.01){
                    $res[$key]['money'] = $is_sub; 
                }else{
                    // return $is_sub;
                    $res[$key]['money'] = 0.01;
                    $is_sub = $is_sub+(-0.01);
                    while($is_sub!=0){
                        $resonearr = array_column($res,'money');
                        $key = array_search(max($resonearr),$resonearr);
                        $is_sub = bcsub($res[$key]['money'],abs($is_sub),2);
                        if($is_sub>0.01){
                            $res[$key]['money'] = $is_sub; 
                            $is_sub = 0;
                        }else{ 
                            $res[$key]['money']=0.01;
                            $is_sub = $is_sub+(-0.01);
                        }
                    }
                }
            } 
        } 

        /*--- 第六步：打乱顺序 ---*/
        // return $res;
        shuffle($res); 

        return $res;
    }

  
    //普通红包 
    function putonghongbao($money,$num,$hongbao_id){
        $pingjun = bcdiv($money,$num,2); 
        $flag = $pingjun*$num==$money?true:false;
        if($flag && $money){//可以被整除
            $result = [];    
            for ($i=0; $i<$num;$i++) { 
                $arr = array('hongbao_id'=>$hongbao_id,'money'=>$pingjun);
                array_push($result,$arr);
            }
            return $result;
        }else{
            return false;
        }
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

/**
 * 邮件发送函数
 */
    function sendMail($to, $title, $content) {
     
        Vendor('PHPMailer.PHPMailerAutoload');     
        $mail = new PHPMailer(); //实例化
        $mail->IsSMTP(); // 启用SMTP
        $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
        $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
        $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
        $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
        $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
        $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
        $mail->AddAddress($to,"尊敬的客户");
        $mail->WordWrap = 50; //设置每行字符长度
        $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
        $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
        $mail->Subject =$title; //邮件主题
        $mail->Body = $content; //邮件内容
        $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
        return($mail->Send());
    }


    // function kuayu(){
    //     header("Access-Control-Allow-Origin: *");
    //     header('Access-Control-Allow-Headers: *'); 
    //     header("Content-type: text/json; charset=utf-8");
    //     // exit(json_encode(array( 's'=>$s, 'm'=>$m, 'd'=>$d )));
    // }



    //post提交
    function send_post($url,$post_data) {
 
 
    $postdata = http_build_query($post_data);
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
 
    return $result;
}

function curl_post($url='',$postdata=''){
        $ch=curl_init($url);
        $header = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        //curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,true); ;
        curl_setopt($ch,CURLOPT_CAINFO,dirname(__FILE__).'/cacert.pem');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch, CURLOPT_TIMEOUT,0);
        $data=curl_exec($ch);
        if(curl_errno($ch))
        {
                 echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        return $data;
    }


    /**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
function http($url, $params, $method = 'POST', $header = array(), $multi = false){
    $opts = array(
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => $header
    );
    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if($error) throw new Exception('请求发生错误：' . $error);
    return  $data;
}


function curl_post3($url, $postData) {

   $postData = json_encode($postData);
   $curl = curl_init();  //初始化
   curl_setopt($curl,CURLOPT_URL,$url);  //设置url
   curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);  //设置http验证方法
   curl_setopt($curl, CURLOPT_TIMEOUT,3);   //只需要设置一个秒的数量就可以
   curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);  //设置curl_exec获取的信息的返回方式
   curl_setopt($curl,CURLOPT_POST,1);  //设置发送方式为post请求
   curl_setopt($curl,CURLOPT_POSTFIELDS,$postData);  //设置post的数据

   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
         'Content-Type: application/json',
         'Content-Type: application/x-www-form-urlencoded',
         'Content-Length: ' . strlen($postData))
   );

   $result = curl_exec($curl);
   curl_close($curl);
   return json_decode($result,true);
}

function curl_it($url = "", $first_call = true, $additional_header = NULL, $post = NULL, $put = NULL, $return_header = false, &$http_code = NULL, $basic_authentication = NULL, $proxy = NULL, $cookie = 'cookiefile', $follow_location = true, $timeout =0)
    {
        if ($cookie == 'cookiefile')
            $cookie = $_SERVER['DOCUMENT_ROOT'].'/cookie/curl.php';
        $curl_max_loops = 5;
        $html = $redirect_url = "";
        static $curl_loop_counter = 0;
        if ($first_call)
            $curl_loop_counter = 0;
        $curl_loop_counter++;
        
        if ($curl_loop_counter >= $curl_max_loops)
            return $html;
        $response ='';
        if (strlen($url) > 0)
        {
            $ch = curl_init();
            
            if (!is_null($proxy))
            {
                curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_PROXY, constant(strtoupper($proxy).'_PROXY'));
                curl_setopt($ch, CURLOPT_PROXYPORT, constant(strtoupper($proxy).'_PROXYPORT'));
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, constant(strtoupper($proxy).'_PROXYUSERPWD'));
            }
            
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            //curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie); # SAME cookiefile
            curl_setopt($ch, CURLOPT_ENCODING, '');
            $header = array();
            if (!is_null($additional_header) && is_array($additional_header))
                $header = $additional_header;
            if (!in_array('Pragma', $header)) $header[] = 'Pragma: no-cache';
            if (!in_array('Cache-Control', $header)) $header[] = 'Cache-Control: no-cache';
            if (!preg_grep('/^Accept\-Language:/i', $header)) $header[] = "Accept-Language: en-US,en;q=0.5";
            if (!preg_grep('/^Expect:/i', $header)) $header[] = "Expect:";  //HTTP/1.1 100 Continue <- sucks
            if (!preg_grep('/^Accept:/i', $header)) $header[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
            if (!preg_grep('/^Accept\-Encoding/i', $header)) $header[] = "Accept-Encoding: gzip, deflate";
            if (!preg_grep('/^User\-Agent:/i', $header)) $header[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0";
            //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            if (!is_null($post))
            {
                curl_setopt($ch, CURLOPT_POST, 1);
                //this is already a finished post string
                //rawurlencode kills it!
                //recurse($post, '$value=rawurlencode($value)');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            }
            if (!is_null($put))
            {
                if ($put == 'DELETE')
                {
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, '');
                }
                elseif ($put == 'OPTIONS')
                {
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'OPTIONS');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, '');
                }
                else
                {
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $put);
                }
            }
            if (!is_null($basic_authentication))
            {
                //username:password
                //nor username or password can be emtpy
                if (preg_match('/.+:.+/', $basic_authentication))
                    curl_setopt($ch, CURLOPT_USERPWD, $basic_authentication);
            }
            curl_setopt($ch, CURLOPT_URL, $url);
            $response = curl_exec($ch);
            //remove proxy header
            $pattern = '~^HTTP/1\.(0|1) 200 Connection established~i';
            if (preg_match($pattern, $response))
            {
                $response = ltrim(preg_replace($pattern, '', $response));
                $ar_pattern = array(    '~^Transfer\-Encoding\: chunked~i',
                                        '~^Proxy\-agent\: Online_Application~i',
                                        '~^Connection: close~i');
                foreach ($ar_pattern as $pattern)
                {
                    if (preg_match($pattern, $response))
                        $response = ltrim(preg_replace($pattern, '', $response));
                }
            }
            //list($header, $html) = explode("\r\n\r\n", $response, 2);
            list($header, $html) = preg_split("/\R{2}/", $response, 2);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($follow_location && ($http_code == 301 || $http_code == 302 || $http_code == 307))      //permanently moved || found || temporary redirect
            {
                $matches = array();
                //preg_match('/Location:(.*?)\n/', $header, $matches);
                //$c_url = @parse_url(trim(array_pop($matches)));
                $c_url = false;
                if (preg_match('/Location:(.*?)($|\R)/', $header, $matches))
                    $c_url = parse_url(trim($matches[1]));
                if ($c_url)
                {
                    $last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
                    if (!$c_url['scheme'])
                        $c_url['scheme'] = $last_url['scheme'];
                    if (!$c_url['host'])
                        $c_url['host'] = $last_url['host'];
                    if (!$c_url['path'])
                        $c_url['path'] = $last_url['path'];
                    if (!$c_url['fragment'])
                        $c_url['fragment'] = $last_url['fragment'];
                    $redirect_url = $c_url['scheme'].'://'.$c_url['host'].$c_url['path'].($c_url['query'] ? '?'.$c_url['query'] : '').($c_url['fragment'] ? '#'.$c_url['fragment'] : '');
                }
            }
            //curl_close($ch);
            if (strlen($redirect_url) > 0)  //redirect
                $html = curl_it($redirect_url, false, $additional_header, $post, $put, $return_header, $http_code, $basic_authentication, $proxy, $cookie, $follow_location, $timeout);
        }
                if(curl_errno($ch))
        {
                 return 'Curl error: ' . curl_error($ch);
        }
        
        return ($return_header ? $header."\r\n\r\n" : "").$html;

    }




// //中转

// function getA() {
//     $headers = [];
//     foreach ($_SERVER as $name => $value) {
//         if (substr($name, 0, 5) == 'HTTP_') {
//             $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
//         }
//     }
//     return $headers;
// }
 
// $content = file_get_contents('php://input');
 
// $headers = getA();
// $header_joins = [];
// foreach ($headers as $k => $v) {
//     if ($k == 'X-Pingplusplus-Signature' || $k == 'Content-Type')
//     array_push($header_joins, $k . ': ' . $v);
// }
 
//  // print_r($header_joins);die();
 
// function post($url, $headers, $raw_data) {
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  // POST
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $raw_data);  // Post Data
//     curl_setopt($ch, CURLOPT_URL, $url);//设置要访问的 URL
//     curl_setopt($ch, CURLOPT_USERAGENT, $user_agent); //模拟用户使用的浏览器
//     @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1 );  // 使用自动跳转
//     curl_setopt($ch, CURLOPT_TIMEOUT, 60);  //设置超时时间
//     curl_setopt($ch, CURLOPT_AUTOREFERER, 1 ); // 自动设置Referer
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 收集结果而非直接展示
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // 自定义 Headers
//     $result = curl_exec($ch);
//     curl_close($ch);
//     return $result;
// }

function cu_post($url,$data){ // 模拟提交数据函数
$curl = curl_init(); // 启动一个CURL会话
curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
// curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
$tmpInfo = curl_exec($curl); // 执行操作
if (curl_errno($curl)) {
echo $_SERVER['REQUEST_METHOD'];//捕抓异常
}
curl_close($curl); // 关闭CURL会话
return $tmpInfo; // 返回数据
}


function request_by_curl($remote_server, $post_string) {  
  $ch = curl_init();  
  curl_setopt($ch, CURLOPT_URL, $remote_server);  
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'mypost=' . $post_string);  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
  curl_setopt($ch, CURLOPT_USERAGENT, "qianyunlai.com's CURL Example beta");  
  $data = curl_exec($ch);  
  curl_close($ch);  
  
  return $data;  
} 





?>