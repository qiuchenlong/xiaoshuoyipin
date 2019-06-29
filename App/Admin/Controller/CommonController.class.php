<?php
namespace Admin\Controller;
use Admin\Model\AdminMenuModel;
use Think\Auth;
use Think\Controller;

class CommonController extends Controller{ 

	//检测登录方是否登录或（未实现）
	public function _initialize(){
        $adminMenuModel = new AdminMenuModel();
        $menus = $adminMenuModel->menuTree();
        $this->assign('menus',$menus);
		 $login_user = session('user_id');
        if($login_user == 1){
            session('guanli',$login_user);
            return true;
        }
        if (!empty($login_user)) {
            session('guanli',$login_user);
//验证具体权限
            $url = ltrim(__SELF__,'/index.php');
            $url_arr = explode('/', $url);
            $m = ACTION_NAME;
            $c = CONTROLLER_NAME;
            $ruleName = strtolower("admin/" . $c . "/" . $m);
            $auth = new Auth();
            if(!$auth->check(session('user_id'),$ruleName)){
                $this->error("无权限访问！", U("Index/index"));
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