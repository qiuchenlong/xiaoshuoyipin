<?php
namespace Home\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class KuayuController extends Controller {
     public function _initialize(){
        //处理跨域问题
        header('Content-Type:application/json; charset=utf-8');
        header('Access-Control-Allow-Origin:*'); 
        header('Access-Control-Max-Age:86400'); // 允许访问的有效期
        header('Access-Control-Allow-Headers:*'); 
        header('Access-Control-Allow-Methods:OPTIONS, GET, POST, DELETE');


    }
}

?>