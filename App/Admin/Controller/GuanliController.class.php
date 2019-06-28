<?php
namespace Admin\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');

/**
 * Class GuanliController
 * @package Admin\Controller
 * 管理员控制器-dudj
 */
class GuanliController extends CommonController {
    public function index(){
        $model = M("admin");
        //查出总条数
        $count = $model->count();
        //引入分页类
        $page = new \Think\Page($count,8); //传入一个总条数，和每页显示的条数
        //引入数据
        $arr = $model->limit($page->firstRow.','.$page->listRows)->select();
        //分页
        $btn = $page->show();
        //分配数据
        $this->assign('arr',$arr);          //用户
        $this->assign('btn',$btn);          //分页
        $this->assign('shu',$count);        //总条数
        $this->display();
    }

    /**
     * @return mixed
     * 根据用户id 获取角色名称
     */
    public function getRoleName(){
        $user_id = $_REQUEST['user_id'];
        $res = M('AdminRole')->field('group_concat(role.name)')->join('LEFT JOIN Role on admin_role.role_id = role.id')
            ->where(['admin_role.user_id'=>$user_id])->select();
        return $res;
    }

    /**
     * 编辑用户，授予角色
     */
    public function edit(){
        if(IS_POST){
            if (!empty($_POST['role_id']) && is_array($_POST['role_id'])) {
                $role_ids = $_POST['role_id'];
                $id = $_POST['id'];
                unset($_POST['role_id']);
                unset($_POST['id']);
                $res = M('Admin')->where(['id'=>$id])->save($_POST);
                if ($res > 0){
                    M("AdminRole")->where(["user_id" => $id])->delete();
                    foreach ($role_ids as $role_id) {
                        M("AdminRole")->add(["role_id" => $role_id, "user_id" => $id]);
                    }
                    exit('<script>alert("修改成功");window.parent.location.reload()</script>');
                } else {
                    exit('<script>alert("用户信息无更改");history.go(-1)</script>');
                }
            }else{
                exit('<script>alert("请指定角色");history.go(-1)</script>');
            }
        }else{
            $id = $_GET['id'];
            $v = M('admin')->find($id);
            $role_ids = M('AdminRole')->where(["user_id" => $id])->getField("role_id",true);
            $this->assign("role_ids", $role_ids);
            $this->assign('data',$v);
            $roleData = M('Role')->where(['status'=>1])->where('id != 1')->select();
            $this->assign('roleData',$roleData);
            $this->display();
        }
    }

    /**
     * 添加管理员
     */
    public function add(){
        if(IS_POST){
            if (!empty($_POST['role_id']) && is_array($_POST['role_id'])) {
                $role_ids = $_POST['role_id'];
                unset($_POST['role_id']);
                $result = M('Admin')->add($_POST);
                if ($result > 0){
                    foreach ($role_ids as $role_id) {
                        M('AdminRole')->add(["role_id" => $role_id, "user_id" => $result]);
                    }
                    echo '<script>alert("添加成功");window.parent.location.reload()</script>';
                } else {
                    exit('<script>alert("用户信息无更改");history.go(-1)</script>');
                }
            }else{
                exit('<script>alert("请选择角色");history.go(-1)</script>');
            }
        }else{
            $roleData = M('Role')->where(['status'=>1])->where('id != 1')->select();
            $this->assign('roleData',$roleData);
            $this->display();
        }
    }

    /**
     * 删除
     */
    public function delete()
    {
        $id = isset($_REQUEST["id"])?$_REQUEST["id"]:0;
        if ($id == 1) {
            $this->error("超级管理员角色不能被删除！");
        }
        $status = M('Admin')->delete($id);
        if (!empty($status)) {
            M("AdminRole")->where(["user_id" => $id])->delete();
            $this->success("删除成功！", U('guanli/index'));
        } else {
            $this->error("删除失败！");
        }
    }
}