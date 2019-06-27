<?php
namespace Admin\Controller;

use Admin\Model\AdminMenuModel;
use Think\Cache;
use Think\Db;
use Vendor\Tree\Tree;
include_once("Common.php");
include_once("mysqlha.php");
header('content-type:text/html;charset=utf-8');
class MenuController extends CommonController
{
    /**
     * 后台菜单管理
     * @adminMenu(
     *     'name'   => '后台菜单',
     *     'parent' => 'admin/Setting/default',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '后台菜单管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        session('admin_menu_index', 'Menu/index');
        $result     = M('AdminMenu')->order(["list_order" => "ASC"])->select();
        $tree       = new Tree();
        $tree->icon = ['&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

        $newMenus = [];
        foreach ($result as $m) {
            $newMenus[$m['id']] = $m;
        }
        foreach ($result as $key => $value) {
            $result[$key]['parent_id_node'] = ($value['parent_id']) ? ' class="child-of-node-' . $value['parent_id'] . '"' : '';
            $result[$key]['style']          = empty($value['parent_id']) ? '' : 'display:none;';
            $result[$key]['str_manage']     = '<a href="' . U("Menu/add", ["parent_id" => $value['id'], "menu_id" => $_REQUEST["menu_id"]])
                . '">添加子菜单</a>  <a href="' . U("Menu/edit", ["id" => $value['id'], "menu_id" => $_REQUEST["menu_id"]])
                . '">编辑</a>  <a class="js-ajax-delete" href="' . U("Menu/delete", ["id" => $value['id'], "menu_id" => $_REQUEST["menu_id"]]) . '">删除</a> ';
            $result[$key]['status']         = $value['status'] ? '展示' : '隐藏';
            if (APP_DEBUG) {
                $result[$key]['app'] = $value['app'] . "/" . $value['controller'] . "/" . $value['action'];
            }
        }

        $tree->init($result);
        $str      = "<tr id='node-\$id' \$parent_id_node style='\$style'>
                        <td style='padding-left:20px;'><input name='list_orders[\$id]' type='text' size='3' value='\$list_order' class='input input-order'></td>
                        <td>\$id</td>
                        <td>\$spacer\$name</td>
                        <td>\$app</td>
                        <td>\$status</td>
                        <td>\$str_manage</td>
                    </tr>";
        $category = $tree->getTree(0, $str);
        $this->assign('category',$category);
        $this->display();
    }

    /**
     * 后台所有菜单列表
     * @adminMenu(
     *     'name'   => '所有菜单',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '后台所有菜单列表',
     *     'param'  => ''
     * )
     */
    public function lists()
    {
        session('admin_menu_index', 'Menu/lists');
        $result = M('AdminMenu')->order(["app" => "ASC", "controller" => "ASC", "action" => "ASC"])->select();
        $this->assign("menus", $result);
        $this->display();
    }

    /**
     * 后台菜单添加
     * @adminMenu(
     *     'name'   => '后台菜单添加',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '后台菜单添加',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        $tree     = new Tree();
        $parentId = isset($_REQUEST["parent_id"])?$_REQUEST["parent_id"]:0;
        $result   = M('AdminMenu')->order(["list_order" => "ASC"])->select();
        $array    = [];
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $parentId ? 'selected' : '';
            $array[]       = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
        $selectCategory = $tree->getTree(0, $str);
        $this->assign("select_category", $selectCategory);
        $this->display();
    }

    /**
     * 后台菜单添加提交保存
     * @adminMenu(
     *     'name'   => '后台菜单添加提交保存',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '后台菜单添加提交保存',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if (IS_POST) {
            $model = M('AdminMenu');
            if (!$model->create($_REQUEST)) {
                $this->error("错误");
            } else {
                $data = $_REQUEST;
                $res = $model->field(true)->add($data);
//                $res = true;
                if(!$res){
                    $this->error($model->getError());
                }
                $app = $_REQUEST["app"];
                $controller = $_REQUEST["controller"];
                $action = $_REQUEST["action"];
                $param = $_REQUEST["param"];
                $authRuleName = "$app/$controller/$action";
                $menuName = $_REQUEST["name"];
                $findAuthRuleCount = M('AuthRule')->where([
                    'app'  => $app,
                    'name' => $authRuleName,
                    'type' => 'admin_url'
                ])->count();
                if (empty($findAuthRuleCount)) {
                    M('AuthRule')->save([
                        "name"  => $authRuleName,
                        "app"   => $app,
                        "type"  => "admin_url", //type 1-admin rule;2-user rule
                        "title" => $menuName,
                        'param' => $param,
                    ]);
                }
                $sessionAdminMenuIndex = session('admin_menu_index');
                $to = empty($sessionAdminMenuIndex) ? "Menu/index" : $sessionAdminMenuIndex;
                $this->success("添加成功！", U($to));
            }
        }
    }

    /**
     * 后台菜单编辑
     * @adminMenu(
     *     'name'   => '后台菜单编辑',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '后台菜单编辑',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $tree   = new Tree();
        $id = isset($_REQUEST["id"])?$_REQUEST["id"]:0;
        $rs     = M('AdminMenu')->where(["id" => $id])->find();
        $result = M('AdminMenu')->order(["list_order" => "ASC"])->select();
        $array  = [];
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $rs['parent_id'] ? 'selected' : '';
            $array[]       = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
        $selectCategory = $tree->getTree(0, $str);
        $this->assign("data", $rs);
        $this->assign("select_category", $selectCategory);
        $this->display();
    }

    /**
     * 后台菜单编辑提交保存
     * @adminMenu(
     *     'name'   => '后台菜单编辑提交保存',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '后台菜单编辑提交保存',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        if (IS_POST) {
            $id = isset($_REQUEST["id"])?$_REQUEST["id"]:0;
            $oldMenu = M('AdminMenu')->where(['id' => $id])->find();
            $model = M('AdminMenu');
            if (!$model->create($_REQUEST)) {
                $this->error("错误");
            } else {
                $data = $_REQUEST;
                $model->field(true)->save($data);
                $app = $_REQUEST["app"];
                $controller = $_REQUEST["controller"];
                $action = $_REQUEST["action"];
                $param = $_REQUEST["param"];
                $authRuleName = "$app/$controller/$action";
                $menuName = $_REQUEST["name"];
                $findAuthRuleCount = M('AuthRule')->where([
                    'app'  => $app,
                    'name' => $authRuleName,
                    'type' => 'admin_url'
                ])->count();
                if (empty($findAuthRuleCount)) {
                    $oldApp        = $oldMenu['app'];
                    $oldController = $oldMenu['controller'];
                    $oldAction     = $oldMenu['action'];
                    $oldName       = "$oldApp/$oldController/$oldAction";
                    $findOldRuleId = M('AuthRule')->field('id')->where(["name" => $oldName])->find();
                    if (empty($findOldRuleId)) {
                        M('AuthRule')->save([
                            "name"  => $authRuleName,
                            "app"   => $app,
                            "type"  => "admin_url",
                            "title" => $menuName,
                            "param" => $param
                        ]);//type 1-admin rule;2-user rule
                    } else {
                        M('AuthRule')->where(['id' => $findOldRuleId])->save([
                            "name"  => $authRuleName,
                            "app"   => $app,
                            "type"  => "admin_url",
                            "title" => $menuName,
                            "param" => $param]);//type 1-admin rule;2-user rule
                    }
                } else {
                    M('AuthRule')->where([
                        'app'  => $app,
                        'name' => $authRuleName,
                        'type' => 'admin_url'
                    ])->save(["title" => $menuName, 'param' => $param]);//type 1-admin rule;2-user rule
                }
                $this->success("保存成功！");
            }
        }
    }

    /**
     * 后台菜单删除
     * @adminMenu(
     *     'name'   => '后台菜单删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '后台菜单删除',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:0;
        $count = M('AdminMenu')->where(["parent_id" => $id])->count();
        if ($count > 0) {
            $this->error("该菜单下还有子菜单，无法删除！");
        }
        if (M('AdminMenu')->delete($id) !== false) {
            $this->success("删除菜单成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 后台菜单排序
     * @adminMenu(
     *     'name'   => '后台菜单排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '后台菜单排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        $adminMenuModel = new AdminMenuModel();
        parent::listOrders($adminMenuModel);
        $this->success("排序更新成功！");
    }
}