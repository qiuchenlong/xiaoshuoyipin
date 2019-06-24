<?php
namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller{

//ajax删除图
     public	function deleteImage(){
			// 先取出图片所在目录
			$images = $_REQUEST['images'];
			$root = C('IMG_rootPath'); 

			$file = "$root.$images";
			if (!unlink($file)){
			$result = array('state'=>0,'msg'=>'删除失败');
			}else{
			$result = array('state'=>1,'msg'=>'删除成功');
			}
			$this->ajaxReturn($result);
		}





















}



?>