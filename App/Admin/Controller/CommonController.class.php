<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller{ 

	//检测登录方是否登录或（未实现）
	public function _initialize(){   
		 $login_user = session('aid');
        return true;
        /*if($login_user == 1){
            return true;
        }*/
        if (!empty($login_user)) {
//验证具体权限
            $url = ltrim(__SELF__,'/index.php');
            $url_arr = explode('/', $url);
            $c = $url_arr[1];
            $m = ACTION_NAME;
            //查询角色，通过用户查询角色
            $roleLists = $this->roleList($login_user);
            if(!empty($roleLists)){
                //查询权限，通过角色查询权限
                $roleLists = $this->menuList($roleLists);
            }else{
                $this->error("您没有权限！");
            }
            var_dump($c);die;
            $levelstr_arr = explode(',', $_SESSION['levelstr']);
            if(!in_array($data['id'], $levelstr_arr) && ($c <> 'index' && $m <> 'index') && $_SESSION['levelstr'] <> 'all' && in_array($m, C('ACTION'))){
                if(in_array($m, array('add','update','xiangqing'))){
                    echo '<div style="margin-top:200px;float: none;margin-right: 0px;margin-left: 0px;text-align:center;">您没有权限! </div>';exit;
                }
                exit('您没有权限');
                $result = array('result'=>false,'data'=>'','message'=>'您没有权限！');
                echo json_encode($result);exit;
            }
            if(intval(session('adminid')) != 1 || intval(session('groupid')) != 1){
                $adminData = M('my_admin')->where('id='.intval(session('adminid')))->find();
                if(!empty($adminData['merchantid'])){
                    session('adminmerchantid',$adminData['merchantid']);
                }else{
                    echo '<div style="margin-top:200px;float: none;margin-right: 0px;margin-left: 0px;text-align:center;">联系管理员给您授权商户! <a href="/admin/Login/sendemail">点击发送邮件</a></div>';exit;
                }
            }
        } else {
            $this->error("您还没有登录！", U("Login/login"));
        }
	}
    /**
     *  排序 排序字段为list_orders数组 POST 排序字段为：list_order
     */
    protected function listOrders($model)
    {
        if (!is_object($model)) {
            return false;
        }
        $pk  = $model->getPk(); //获取主键名称
        $ids = $_REQUEST("list_orders/a");
        if (!empty($ids)) {
            foreach ($ids as $key => $r) {
                $data['list_order'] = $r;
                $model->where([$pk => $key])->update($data);
            }
        }
        return true;
    }

    /**
     * @param $adminId
     * @return string
     * 根据用户id查询角色信息
     */
    protected function roleList($adminId){
        $roles = M('AdminRole')
            ->field('r.id')
            ->join('LEFT JOIN Admin a ON a.id = admin_role.user_id')
            ->join('LEFT JOIN Role r ON r.id = admin_role.role_id')
            ->where(["admin_role.user_id" => $adminId])
            ->select();
        $roleIds = "";
        foreach($roles as $v){
            $roleIds .= $v['id'].',';
        }
        $roleIds = trim($roleIds,',');
        return $roleIds;
    }
    protected function menuList($roleId){

    }
}
?>