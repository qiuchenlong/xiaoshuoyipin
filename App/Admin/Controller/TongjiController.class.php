<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class TongjiController extends CommonController 
{
	public function dingdan(){
		    $model =M("chongzhi");
            //查出总条数 
            $count = $model->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->order('time desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

            foreach ($arr as $k => $v) {
               $user=M('jieqi_system_users')->find($v['uid']);
               $arr[$k]['name']=$user['uname'];
               $down['down']=$v['uid'];
               $shang=M('invite')->where($down)->find();

               $upper=M('jieqi_system_users')->find($shang['upper']);
                 // var_dump($upper);die;
               $arr[$k]['dainame']=$upper['uname'];
            }

            //本日未付款
            $con=date('Y-m-d');
            $data['time'] = array('like', "%$con%");
            $data['zhifu'] =0;
            $jin=M('chongzhi')->where($data)->select();
            foreach ($jin as $k => $v) {
                $ben[]=$v['kanbi'];
            }
            $benri=array_sum($ben); 

             //本日已付款
            $con=date('Y-m-d');
            $data1['time'] = array('like', "%$con%");
            $data1['zhifu'] =1;
            $jin1=M('chongzhi')->where($data1)->select();
            foreach ($jin1 as $k1 => $v1) {
                $ben1[]=$v1['kanbi'];
            }
            $benri1=array_sum($ben1);

              //本月未付款
            $con2=date('Y-m');
            $data2['time'] = array('like', "%$con2%");
            $data2['zhifu'] =0;
            $jin2=M('chongzhi')->where($data2)->select();
            foreach ($jin2 as $k2 => $v2) {
                $ben2[]=$v2['kanbi'];
            }
            $benri2=array_sum($ben2);

               //本月已付款
            $con3=date('Y-m');
            $data3['time'] = array('like', "%$con3%");
            $data3['zhifu'] =1;
            $jin3=M('chongzhi')->where($data3)->select();
            foreach ($jin3 as $k3 => $v3) {
                $ben3[]=$v3['kanbi'];
            }
            $benri3=array_sum($ben3);

            //总额未付款
            $data4['zhifu'] =0;
            $jin4=M('chongzhi')->where($data4)->select();
            foreach ($jin4 as $k4 => $v4) {
                $ben4[]=$v4['kanbi'];
            }
            $benri4=array_sum($ben4);

            //总额已付款
            $data5['zhifu'] =1;
            $jin5=M('chongzhi')->where($data5)->select();
            foreach ($jin5 as $k5 => $v5) {
                $ben5[]=$v5['kanbi'];
            }
            $benri5=array_sum($ben5);

            // var_dump($info);die;
            //分配数据
            $this->assign('benri5',$benri5);   //总额已付款
            $this->assign('benri4',$benri4);   //总额未付款
             $this->assign('benri3',$benri3);   //本月已付款
              $this->assign('benri2',$benri2);  //本月未付款
            $this->assign('benri1',$benri1);     //本日已付款
             $this->assign('benri',$benri);     //本日未付款
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
            
	}


    public function daidingdan(){
            $shang['upper']=session('user_id');
            $xia=M('invite')->where($shang)->select();
            // var_dump($xia);die;
        foreach ($xia as $k6 => $v6) {
            $down['uid']=$v6['down'];
            // $arr=M('chongzhi')->where($down)->select();

            $model =M("chongzhi");
            //查出总条数 
            $count = $model->where($down)->count();
            //引入分页类 
            $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
            //引入数据
            $arr = $model->where($down)->order('time desc')->limit($page->firstRow.','.$page->listRows)->select();
            //分页
            
            $btn = $page->show();

             foreach ($arr as $k => $v) {
               $user=M('jieqi_system_users')->find($v['uid']);
               $arr[$k]['name']=$user['uname'];
               $down['down']=$v['uid'];
               $shang=M('invite')->where($down)->find();

               $upper=M('jieqi_system_users')->find($shang['upper']);
                 // var_dump($upper);die;
               $arr[$k]['dainame']=$upper['uname'];
            }

             //本日未付款
            $con=date('Y-m-d');
            $data['time'] = array('like', "%$con%");
            $data['zhifu'] =0;
            $data['uid'] =$v6['down'];
            $jin=M('chongzhi')->where($data)->select();
            foreach ($jin as $k => $v) {
                $ben[]=$v['kanbi'];
            }
            $benri=array_sum($ben); 

             //本日已付款
            $con=date('Y-m-d');
            $data1['time'] = array('like', "%$con%");
            $data1['zhifu'] =1;
            $data1['uid'] =$v6['down'];
            $jin1=M('chongzhi')->where($data1)->select();
            foreach ($jin1 as $k1 => $v1) {
                $ben1[]=$v1['kanbi'];
            }
            $benri1=array_sum($ben1);

              //本月未付款
            $con2=date('Y-m');
            $data2['time'] = array('like', "%$con2%");
            $data2['zhifu'] =0;
            $data2['uid'] =$v6['down'];
            $jin2=M('chongzhi')->where($data2)->select();
            foreach ($jin2 as $k2 => $v2) {
                $ben2[]=$v2['kanbi'];
            }
            $benri2=array_sum($ben2);

               //本月已付款
            $con3=date('Y-m');
            $data3['time'] = array('like', "%$con3%");
            $data3['zhifu'] =1;
            $data3['uid'] =$v6['down'];
            $jin3=M('chongzhi')->where($data3)->select();
            foreach ($jin3 as $k3 => $v3) {
                $ben3[]=$v3['kanbi'];
            }
            $benri3=array_sum($ben3);

            //总额未付款
            $data4['zhifu'] =0;
            $data4['uid'] =$v6['down'];
            $jin4=M('chongzhi')->where($data4)->select();
            foreach ($jin4 as $k4 => $v4) {
                $ben4[]=$v4['kanbi'];
            }
            $benri4=array_sum($ben4);

            //总额已付款
            $data5['zhifu'] =1;
            $data5['uid'] =$v6['down'];
            $jin5=M('chongzhi')->where($data5)->select();
            foreach ($jin5 as $k5 => $v5) {
                $ben5[]=$v5['kanbi'];
            }
            $benri5=array_sum($ben5);

        }
            // var_dump($info);die;
            //分配数据
            $this->assign('benri5',$benri5);   //总额已付款
            $this->assign('benri4',$benri4);   //总额未付款
             $this->assign('benri3',$benri3);   //本月已付款
              $this->assign('benri2',$benri2);  //本月未付款
            $this->assign('benri1',$benri1);     //本日已付款
             $this->assign('benri',$benri);     //本日未付款
            $this->assign('arr',$arr);          //用户
            $this->assign('btn',$btn);          //分页
            $this->assign('shu',$count);        //总条数   
            $this->display();   
            
    }


    public function user(){
        $model =M("jieqi_system_users");
        
        //用户统计
        $u['lei']=0;
        $user=$model->where($u)->count();
        //代理商统计
        $d['lei']=array(array('eq',1),array('eq',2),'or');
        $dai=$model->where($d)->count();

         //本日用户统计
        $con=date('Y-m-d');
        $ri['time'] = array('like', "%$con%");
        $ri['lei']=0;
        $user1=$model->where($ri)->count();
        //代理商统计
        $ri1['time'] = array('like', "%$con%");
        $ri1['lei']=array(array('eq',1),array('eq',2),'or');
        $dai1=$model->where($ri1)->count();

          //本月用户统计
        $con1=date('Y-m');
        $yue['time'] = array('like', "%$con1%");
        $yue['lei']=0;
        $user2=$model->where($yue)->count();
        //月代理商统计
        $yue1['time'] = array('like', "%$con1%");
        $yue1['lei']=array(array('eq',1),array('eq',2),'or');
        $dai2=$model->where($yue1)->count();

            $this->assign('user1',$user1);          //本日用户
            $this->assign('dai1',$dai1);          //本日代理
             $this->assign('user2',$user2);          //本月用户
            $this->assign('dai2',$dai2);          //本月代理
            $this->assign('user',$user);          //用户总数
            $this->assign('dai',$dai);          //代理总数
            $this->assign('shu',$count);        //总条数   
            $this->display();   
            
    }

	
}