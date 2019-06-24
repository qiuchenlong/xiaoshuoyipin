<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
include_once("../../conn.php");
require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';
//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
$fp = fopen('in_test.txt','a+');
fwrite($fp,date("Y-m-d H:i:s")." 成功了！rn");
class PayNotifyCallBack extends WxPayNotify
{


						

	
        //查询订单
		
        public function Queryorder($transaction_id)
        {
                $input = new WxPayOrderQuery();
                $input->SetTransaction_id($transaction_id);
                $result = WxPayApi::orderQuery($input);
                Log::DEBUG("query:" . json_encode($result));
                if(array_key_exists("return_code", $result)
                        && array_key_exists("result_code", $result)
                        && $result["return_code"] == "SUCCESS"
                        && $result["result_code"] == "SUCCESS")
                {
                        $out_trade_no=$result['out_trade_no'];//私有订单号，你就用这个订单号来进行你自己订单的各种更新吧
                        $mch_id=$result['mch_id'];//商户号
                        $total_fee=$result['total_fee'];//支付金额，出来的金额要除以100
                        $transaction_id=$result['transaction_id'];//微信内部的订单流水号
                        $openid=$result['openid'];//微信加密的用户身份识别,app支付的话其实意义不大了
                        /*以下两行用做调试，会自动生成in_test.txt文件而且后期内容会自动追加到这个文件*/
                        $fp = fopen('in_test.txt','a+');
                        fwrite($fp,date("Y-m-d H:i:s").json_encode($result) . "|".$transaction_id." 成功了！rn");
                        /**/
						
					  
                        //逻辑处理
                        $numbers=substr($out_trade_no,10);
                        $sql = mysql_query("SELECT * FROM chongzhi WHERE orders=$numbers");
                        $mess = mysql_fetch_array($sql);

                        $user_id = $mess['uid'];
                        $money = $mess['price'];
                         $paths = '充值金币';
                         $type = '+';
                        $sql = "INSERT INTO db_bounty(user_id,`money`,type,paths) VALUES (".$user_id.",'".$money."','$type','$paths')";
                        mysql_query($sql);
                        //逻辑处理 end
						
                        return true;//这个很重要，微信的异步请求，当你执行完了你的内部处理以后给他返回true，微信就认为你的内部处理完成了，就不会再次请求你了，否则他会一直请求你这个文件，知道超时。
                }
                return false;
        }
       
        //重写回调处理函数
        public function NotifyProcess($data, &$msg)
        {
                Log::DEBUG("call back:" . json_encode($data));
                $notfiyOutput = array();
               
                if(!array_key_exists("transaction_id", $data)){
                        $msg = "输入参数不正确";
                        return false;
                }
                //查询订单，判断订单真实性
                if(!$this->Queryorder($data["transaction_id"])){
                        $msg = "订单查询失败";
                        return false;
                }
                return true;
        }
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);