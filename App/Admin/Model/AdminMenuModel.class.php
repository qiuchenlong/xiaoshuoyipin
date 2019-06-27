<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace Admin\Model;

use Think\Model;
use Think\Cache;

class AdminMenuModel extends Model
{
    protected $rule = [
        'name'       => 'require',
        'app'        => 'require',
        'controller' => 'require',
        'parent_id'  => 'checkParentId',
        'action'     => 'require|unique:AdminMenu,app^controller^action',
    ];

    protected $message = [
        'name.require'       => '名称不能为空',
        'app.require'        => '应用不能为空',
        'parent_id'          => '超过了4级',
        'controller.require' => '名称不能为空',
        'action.require'     => '名称不能为空',
        'action.unique'      => '同样的记录已经存在!',
    ];

    protected $scene = [
        'add'  => ['name', 'app', 'controller', 'action', 'parent_id'],
        'edit' => ['name', 'app', 'controller', 'action', 'id', 'parent_id'],

    ];

    // 自定义验证规则
    protected function checkParentId($value)
    {
        $find = M('AdminMenu')->where(["id" => $value])->value('parent_id');
        if ($find) {
            $find2 =M('AdminMenu')->where(["id" => $find])->value('parent_id');
            if ($find2) {
                $find3 = M('AdminMenu')->where(["id" => $find2])->value('parent_id');
                if ($find3) {
                    return false;
                }
            }
        }
        return true;
    }
    /**
     * 按父ID查找菜单子项
     * @param int $parentId 父菜单ID
     * @param boolean $withSelf 是否包括他自己
     * @return mixed
     */
    public function adminMenu($parentId, $withSelf = false)
    {
        //父节点ID
        $parentId = intval($parentId);
        $result   = $this->where(['parent_id' => $parentId, 'status' => 1])->order("list_order", "ASC")->select();

        if ($withSelf) {
            $result2[] = $this->where(['id' => $parentId])->find();
            $result    = array_merge($result2, $result);
        }

        //权限检查
        if (session("user_id") == 1) {
            //如果是超级管理员 直接通过
            return $result;
        }

        $array = [];

        foreach ($result as $v) {

            //方法
            $action = $v['action'];

            //public开头的通过
            if (preg_match('/^public_/', $action)) {
                $array[] = $v;
            } else {

                if (preg_match('/^ajax_([a-z]+)_/', $action, $_match)) {

                    $action = $_match[1];
                }

                $ruleName = strtolower($v['app'] . "/" . $v['controller'] . "/" . $action);
//                print_r($ruleName);
                if (cmf_auth_check(cmf_get_current_admin_id(), $ruleName)) {
                    $array[] = $v;
                }

            }
        }

        return $array;
    }

    /**
     * 获取菜单 头部菜单导航
     * @param string $parentId 菜单id
     * @return mixed|string
     */
    public function subMenu($parentId = '', $bigMenu = false)
    {
        $array   = $this->adminMenu($parentId, 1);
        $numbers = count($array);
        if ($numbers == 1 && !$bigMenu) {
            return '';
        }
        return $array;
    }

    /**
     * 菜单树状结构集合
     */
    public function menuTree()
    {
        $data = $this->getTree(0);
        return $data;
    }

    /**
     * 取得树形结构的菜单
     * @param $myId
     * @param string $parent
     * @param int $Level
     * @return bool|null
     */
    public function getTree($myId, $parent = "", $Level = 1)
    {
        $data = $this->adminMenu($myId);
        $Level++;
        if (count($data) > 0) {
            $ret = NULL;
            foreach ($data as $a) {
                $id         = $a['id'];
                $app        = $a['app'];
                $controller = ucwords($a['controller']);
                $action     = $a['action'];
                //附带参数
                $params = "";
                if ($a['param']) {
                    $params = "?" . htmlspecialchars_decode($a['param']);
                }

                if (strpos($app, 'plugin/') === 0) {
                    $pluginName = str_replace('plugin/', '', $app);
                    $url        = cmf_plugin_url($pluginName . "://{$controller}/{$action}{$params}");
                } else {
                    $url = url("{$app}/{$controller}/{$action}{$params}");
                }

                $app = str_replace('/', '_', $app);

                $array = [
                    "icon"   => $a['icon'],
                    "id"     => $id . $app,
                    "name"   => $a['name'],
                    "parent" => $parent,
                    "url"    => $url,
                    'lang'   => strtoupper($app . '_' . $controller . '_' . $action)
                ];


                $ret[$id . $app] = $array;
                $child           = $this->getTree($a['id'], $id, $Level);
                //由于后台管理界面只支持三层，超出的不层级的不显示
                if ($child && $Level <= 3) {
                    $ret[$id . $app]['items'] = $child;
                }

            }
            return $ret;
        }

        return false;
    }

    /**
     * 更新缓存
     * @param  $data
     * @return array
     */
    public function menuCache($data = null)
    {
        if (empty($data)) {
            $data = $this->order("list_order", "ASC")->column('');
            Cache::set('Menu', $data, 0);
        } else {
            Cache::set('Menu', $data, 0);
        }
        return $data;
    }

    public function menu($parentId, $with_self = false)
    {
        //父节点ID
        $parentId = (int)$parentId;
        $result   = $this->where(['parent_id' => $parentId])->select();
        if ($with_self) {
            $result2[] = $this->where(['id' => $parentId])->find();
            $result    = array_merge($result2, $result);
        }
        return $result;
    }

    /**
     * 得到某父级菜单所有子菜单，包括自己
     * @param int $parentId
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getMenuTree($parentId = 0)
    {
        $menus = $this->where(["parent_id" => $parentId])->order(["list_order" => "ASC"])->select();

        if ($menus) {
            foreach ($menus as $key => $menu) {
                $children = $this->getMenuTree($menu['id']);
                if (!empty($children)) {
                    $menus[$key]['children'] = $children;
                }
                unset($menus[$key]['id']);
                unset($menus[$key]['parent_id']);
            }
            return $menus;
        } else {
            return $menus;
        }

    }

}
