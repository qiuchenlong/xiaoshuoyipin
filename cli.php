<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

define('APP_MODE','cli');
// 定义应用目录
define('APP_PATH','./App/');



// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';
//普通模式，解决官方分组不支持cli的问题
// $depr = '/';
// $path   = isset($_SERVER['argv'][1])?$_SERVER['argv'][1]:'';
// if(!empty($path)) {
//     $params = explode($depr,trim($path,$depr));
// }
// !empty($params)?$_GET['g']=array_shift($params):"";
// !empty($params)?$_GET['m']=array_shift($params):"";
// !empty($params)?$_GET['a']=array_shift($params):"";
// if(count($params)>1) {
// // 解析剩余参数 并采用GET方式获取
//     preg_replace('@(\w+),([^,\/]+)@e', '$_GET[\'\\1\']="\\2";', implode(',',$params));
// }
 
// //define('APP_MODE','cli');
// define('APP_DEBUG',True);
// define( 'APP_PATH', dirname(__FILE__).'/Application/' );
// require dirname(__FILE__).'/ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单