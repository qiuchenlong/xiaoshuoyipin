<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
class FenxiangController extends Controller{   
	public function daily()
	{
		$uid=$_REQUEST['user_id'];
        $today=strtotime(date("Y/m/d"));
        $ming=$today+86400;
        $where['time']=['BETWEEN',"$today,$ming"];
        $where['uid']=$uid;
        //查询用户分享信息
        $user=M('jieqi_system_users')->where(['uid'=>$uid])->find();
        if (!$user) {
            $returnArr = array(
               "code"=>400,
               "msg"=>'用户不存在',
            );
            echo json_encode($returnArr);
            exit;
        }
        //查询当日分享
        $sum=M('jieqi_users_fx_record')->field('sum(daijin) sum')->where($where)->find();
        if (!$sum['sum']) {
           $sum=0;
        }else{
           $sum=$sum['sum']; 
        }
        //获取分享奖励配置 'types'=3分享相关配置
        $daijin=M('system')->where(['types'=>3,'title'=>['like',"%每次分享奖励代金券数量%"]])->find();
        $max=M('system')->where(['types'=>3,'title'=>['like',"%每日分享上限%"]])->find();
        //判断是否开启分享奖励
        if ($max&&$daijin) {
            $max=intval($max['content']);
            $daijin=intval($daijin['content']);
            if ($sum+$daijin<=$max) {
                $res1=M('jieqi_system_users')->where(['uid'=>$uid])->setInc('daijin',$daijin);
                $res2=M('jieqi_system_users')->where(['uid'=>$uid])->setInc('daijin_num',$daijin);
                $data=[
                    'uid'=>$uid,
                    'content'=>'分享奖励代金券',
                    'daijin'=>$daijin,
                    'time'=>time()
                ];
                $res3=M('jieqi_users_fx_record')->add($data);
                $returnArr = array(
                   "code"=>200,
                   "msg"=>'分享奖励代金券',
                );
                
                echo json_encode($returnArr);
            }else{
                $returnArr = array(
                   "code"=>400,
                   "msg"=>'超出当日分享奖励上限',
                );
                
                echo json_encode($returnArr);
            }
            
        }else{
            $returnArr = array(
               "code"=>400,
               "msg"=>'暂未开启分享奖励',
            );
            echo json_encode($returnArr);
        }
	}
	
}

?>