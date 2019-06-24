<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
include_once("UpFileTool.class.php");
include_once("Common.php");
include_once("mysqlha.php");
header("Content-Type:text/html; charset=utf-8");

class ReplyController extends Controller {

    //添加子评论
    public function addOne(){
        $level = $_REQUEST['level'];
        $username = $_REQUEST['user'];
        $tousername=$_REQUEST['tousername'];
        $content = $_REQUEST['content'];

        $insertArr = array(
           "level"=>$level,
            "name"=>$username,
            "tosuername"=>$tousername,
            "content"=>$content
        );

        myinsert('app_reply',$insertArr);
        $returnArr = array(
          "code"=>"200"
        );
        echo json_encode($returnArr);
    }
}