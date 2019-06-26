<?php
use Think\Url;
    //批量删除html代码1
    function plsch1()
    {
        echo '                     
                <th align="center" width="50" >
                    <input type="checkbox" id="allChecks"  onclick="ckAll()" /> 全选/全不选
                    <input type="button" onclick="delAllProduct()" value="批量删除" />
                </th>';
    }

    //批量删除html代码2
     function plsch2($id)
    {
        echo '                     
               <td style="CURSOR: hand; HEIGHT: 22px" align="center" width="23">
                 <input type="checkbox" name="check" value="'.$id.'"/>
                </td>
            ';
    }

    //批量删除js代码**********js
     function plscjs()
    {
        echo '  
                <script>                   
               //全选
                function ckAll(){
                    var flag=document.getElementById("allChecks").checked;
                    var cks=document.getElementsByName("check");
                    for(var i=0;i<cks.length;i++){
                        cks[i].checked=flag;
                    }
                }

                //批量删除
                function delAllProduct(){
                    if(!confirm("确定批量删除评论吗？")){
                        return ;
                }
                var cks=document.getElementsByName("check");
                var str="";
                //拼接所有的图书id
                for(var i=0;i<cks.length;i++){
                    if(cks[i].checked){
                         str+=cks[i].value+".";
                    }
                }
            //去掉字符串末尾的‘&’
                str=str.substring(0, str.length-1);
            // alert(str);
            // location.href="${pageContext.request.contextPath}/servlet/delAllBooksServlet?"+str;
                location.href="<{:U(pidel)}>?id="+str+"";}
            </script>
            ';
    }


     //批量删除php代码
     function plscphp($biao,$id,$dizhi)
    {
        
            $arr=explode(".",$id);
            foreach ($arr as $k => $v) {
               $del=M($biao)->delete($v);
            }
            if($del>0){
                 echo '<script>alert("删除成功");location.href="'.$dizhi.'"</script>';
            }
        
    }

    // //邮箱验证函数
    // function sendMail($to, $title, $content) {
     
    //     Vendor('PHPMailer.PHPMailerAutoload');     
    //     $mail = new PHPMailer(); //实例化
    //     $mail->IsSMTP(); // 启用SMTP
    //     $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
    //     $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
    //     $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
    //     $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
    //     $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
    //     $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
    //     $mail->AddAddress($to,"尊敬的客户");
    //     $mail->WordWrap = 50; //设置每行字符长度
    //     $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    //     $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
    //     $mail->Subject =$title; //邮件主题
    //     $mail->Body = $content; //邮件内容
    //     $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
    //     return($mail->Send());
    // }


    // //邮箱验证配置******在config.php配置文件配置：
    // function youconfig{
    //     //邮件发送
    //     'MAIL_HOST' =>'smtp.qq.com',//smtp服务器的名称
    //     'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    //     'MAIL_USERNAME' =>'416939702@qq.com',//你的邮箱名
    //     'MAIL_FROM' =>'416939702@qq.com',//发件人地址
    //     'MAIL_FROMNAME'=>'台湾书城',//发件人姓名
    //     'MAIL_PASSWORD' =>'avxkmtpeittebjea',//邮箱密码
    //     'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    //     'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
    // } 
    

    // //邮箱验证php*************php
    // function youjian(){    
    //      if(IS_POST){
    //           if(SendMail($_POST['mail'],$_POST['title'],$_POST['content'])){
    //              $this->success('发送成功！');
    //           }else{
    //              $this->error('发送失败');
    //           }
    //     }
    //        $this->display();  
    //        //要下载PHPMailer类         
    // }

/**
 * Url生成
 * @param string        $url 路由地址
 * @param string|array  $vars 变量
 * @param bool|string   $suffix 生成的URL后缀
 * @param bool|string   $domain 域名
 * @return string
 */
function url($url = '', $vars = '', $suffix = true, $domain = false)
{
    return Url::build($url, $vars, $suffix, $domain);
}
?>