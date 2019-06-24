<?php
function hongbao($money,$number,$xuyuan_id,$ratio = 0.5){
        $bijiao = $money;
        $res = array(); //结果数组
        $min = ($money / $number) * (1 - $ratio);   //最小值 0.9
        if($min<0.01){ 
            $min = 0.01;
        }
        $max = ($money / $number) * (1 + $ratio);   //最大值 1.1
        /*--- 第一步：分配低保 ---*/
        for($i=0;$i<$number;$i++){
            $res[$i]['xuyuan_id'] = $xuyuan_id;
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



?>