<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
header("Content-Type:text/html; charset=utf-8");

class QiandaoController extends Controller {

    //公告
    public function qiandao(){ 
        $q['user_id']=I('user_id');
        $u['uid']=I('user_id');
        $con=date('Y-m-d');
        $q['time'] = array('like', "%$con%");
        $qi=M('user_qiandao')->where($q)->find();
        $uid=M('jieqi_system_users')->where($u)->find();
        // var_dump($uid);die;
        if($qi>0){
            $result = array(
                "code"=>220,
                "cishu"=>$uid['qiandao'],
                "msg"=>"今天已签到",
                "daijin" =>1
                
            );

        }else{
             $result = array(
                "code"=>200,
                "cishu"=>$uid['qiandao'],
                "msg"=>"未签到",
                "daijin" =>0
                
            );
           
        }
       
         echo json_encode($result);
    }

     //公告
    public function qiandaoj(){ 

        $q['user_id']=I('user_id');
        $con=date('Y-m-d');
        $q['time'] = array('like', "%$con%");
        $qi=M('user_qiandao')->where($q)->find();
        // var_dump($qi);die;
        if($qi>0){
            $result = array(
                "code"=>220,
                "msg"=>"今天已签到",
                "daijin" =>1
                
            );

        }else{

        $q['user_id']=I('user_id');
        $con=date('Y-m-d');
        $q['time'] = array('like', "%$con%");
        $qi=M('user_qiandao')->where($q)->find();
        

            $con=date('Y-m-d');
            $qq['time'] = array('like', "%$con%");
            $shu=M('user_qiandao')->where($qq)->count();
           


            $a['uid']=I('user_id');
            $arr=M('jieqi_system_users')->find(I('user_id'));
            $a['qiandao']=$arr['qiandao']+1;

            $a['daijin']=$arr['daijin']+1;
            $a['daijin_num']=$arr['daijin_num']+1;
        
            


            M('user_qiandao')->add($q);
            $info=M('jieqi_system_users')->save($a);
            $arr1=M('jieqi_system_users')->find(I('user_id'));
            $result = array(
                    "code"=>200,
                    "msg"=>"签到成功",
                    "fmc"=>$b,
                    "tianshu"=>$arr1['qiandao'],
                    "ren"=>$t,
                    "daijin" => 1

                );
        
        } 

        
         echo json_encode($result);
    }

                
   
}


 
