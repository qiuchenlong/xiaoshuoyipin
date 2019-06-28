<?php
namespace Admin\Controller;

use think\Db;
use Vendor\Tree\Tree;
use Admin\Model\AdminMenuModel;

class RoleController extends CommonController
{

    /**
     * 角色管理列表
     * @adminMenu(
     *     'name'   => '角色管理',
     *     'parent' => 'admin/User/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '角色管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $data = M('role')->order(["list_order" => "ASC", "id" => "DESC"])->select();
        $this->assign("roles", $data);
        $count = M('role')->count();
        $this->assign('count',$count);
        $this->display();
    }

    /**
     * 添加角色
     * @adminMenu(
     *     'name'   => '添加角色',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加角色',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 添加角色提交
     * @adminMenu(
     *     'name'   => '添加角色提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加角色提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if (IS_POST) {
            $post = $_POST;
            $model = M('Role');
            if(!empty($post['name'])){
                $data = $_REQUEST;
                if (!$model->create($data)) {
                    $this->error("错误");
                } else {
                    $result = $model->field(true)->add($data);
                    if ($result) {
                        exit('<script>alert("添加角色成功");window.parent.location.reload()</script>');
                    } else {
                        $this->error("添加角色失败");
                    }
                }
            }else{
                $this->error('添加失败：参数异常');
            }
        }
    }

    /**
     * 编辑角色
     * @adminMenu(
     *     'name'   => '编辑角色',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑角色',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $id = isset($_REQUEST["id"])?$_REQUEST["id"]:0;
        if ($id == 1) {
            $this->error("超级管理员角色不能被修改！");
        }
        $data = M('role')->where(["id" => $id])->find();
        if (!$data) {
            $this->error("该角色不存在！");
        }
        $this->assign("data", $data);
        $this->display();
    }

    /**
     * 编辑角色提交
     * @adminMenu(
     *     'name'   => '编辑角色提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑角色提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        $id = isset($_REQUEST["id"])?$_REQUEST["id"]:0;
        if ($id == 1) {
            $this->error("超级管理员角色不能被修改！");
        }
        if (IS_POST) {
            $data = $_POST;
            $model = M('Role');
            unset($data['id']);
            if (!$model->create($data)) {
                $this->error("错误");
            } else {
                $res = $model->where(['id'=>$id])->field(true)->save($data);
                if ($res) {
                    $this->success("保存成功！", U('role/index'));
                } else {
                    $this->error("保存失败！");
                }
            }
        }
    }

    /**
     * 删除角色
     * @adminMenu(
     *     'name'   => '删除角色',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除角色',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $id = isset($_REQUEST["id"])?$_REQUEST["id"]:0;
        if ($id == 1) {
            $this->error("超级管理员角色不能被删除！");
        }
        $count = M('AdminRole')->where(['role_id' => $id])->count();
        if ($count > 0) {
            $this->error("该角色已经有用户！");
        } else {
            $status = M('Role')->delete($id);
            if (!empty($status)) {
                $this->success("删除成功！", url('role/index'));
            } else {
                $this->error("删除失败！");
            }
        }
    }

    /**
     * 设置角色权限
     * @adminMenu(
     *     'name'   => '设置角色权限',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '设置角色权限',
     *     'param'  => ''
     * )
     */
    public function authorize()
    {
        $AuthAccess = M("AuthAccess");
        $adminMenuModel = new AdminMenuModel();
        //角色ID
        $roleId = isset($_REQUEST["id"])?$_REQUEST["id"]:0;
        if (empty($roleId)) {
            $this->error("参数错误！");
        }

        $tree = new Tree();
        $tree->icon = ['│ ', '├─ ', '└─ '];
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $result = $adminMenuModel->menuData();
        $newMenus = [];
        $privilegeData = $AuthAccess->where(["role_id" => $roleId])->getField('rule_name',true);//获取权限表数据
        foreach ($result as $m) {
            $newMenus[$m['id']] = $m;
        }
        foreach ($result as $n => $t) {
            $result[$n]['checked']      = ($this->_isChecked($t, $privilegeData)) ? ' checked' : '';
            $result[$n]['level']        = $this->_getLevel($t['id'], $newMenus);
            $result[$n]['style']        = empty($t['parent_id']) ? '' : 'display:none;';
            $result[$n]['parentIdNode'] = ($t['parent_id']) ? ' class="child-of-node-' . $t['parent_id'] . '"' : '';
        }
        $str = "<tr id='node-\$id'\$parentIdNode  style='\$style'>
                   <td style='padding-left:30px;'>\$spacer<input type='checkbox' name='menuId[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
    			</tr>";
        $tree->init($result);
        $category = $tree->getTree(0, $str);
        $this->assign("category", $category);
        $this->assign("roleId", $roleId);
        $this->display();
    }

    /**
     * 角色授权提交
     * @adminMenu(
     *     'name'   => '角色授权提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '角色授权提交',
     *     'param'  => ''
     * )
     */
    public function authorizePost()
    {
        if (IS_POST) {
            $roleId = isset($_REQUEST["roleId"])?$_REQUEST["roleId"]:0;
            if (!$roleId) {
                exit('<script>alert("需要授权的角色不存在！");history.go(-1)</script>');
            }
            if (is_array($_POST['menuId']) && count($_POST['menuId']) > 0) {
                M("authAccess")->where(["role_id" => $roleId, 'type' => 'admin_url'])->delete();
                foreach ($_POST['menuId'] as $menuId) {
                    $menu = M("adminMenu")->where(["id" => $menuId])->field("app,controller,action")->find();
                    if ($menu) {
                        $app    = $menu['app'];
                        $model  = $menu['controller'];
                        $action = $menu['action'];
                        $name   = strtolower("$app/$model/$action");
                        M("authAccess")->add(["role_id" => $roleId, "rule_name" => $name, 'type' => 'admin_url']);
                    }
                }
                exit('<script>alert("授权成功!");window.parent.location.reload()</script>');
            } else {
                //当没有数据时，清除当前角色授权
                M("authAccess")->where(["role_id" => $roleId])->delete();
                exit('<script>alert("没有接收到数据，执行清除授权成功！");history.go(-1)</script>');
            }
        }
    }

    /**
     * 检查指定菜单是否有权限
     * @param array $menu menu表中数组
     * @param $privData
     * @return bool
     */
    private function _isChecked($menu, $privData)
    {
        $app = $menu['app'];
        $model = $menu['controller'];
        $action = $menu['action'];
        $name = strtolower("$app/$model/$action");
        if ($privData) {
            if (in_array($name, $privData)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    /**
     * 获取菜单深度
     * @param $id
     * @param array $array
     * @param int $i
     * @return int
     */
    protected function _getLevel($id, $array = [], $i = 0)
    {
        if ($array[$id]['parent_id'] == 0 || empty($array[$array[$id]['parent_id']]) || $array[$id]['parent_id'] == $id) {
            return $i;
        } else {
            $i++;
            return $this->_getLevel($array[$id]['parent_id'], $array, $i);
        }
    }

}

