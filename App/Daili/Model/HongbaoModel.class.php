<?php 
namespace Daili\Model;
use Think\Model;

class HongbaoModel extends Model 
{
	


	public function getDate()
	{
		//性别
		
		



		//查询数据并分页
		$model =M('k_hongbao');

		//查出总条数 
		$count = $model->count();

		//引入分页类 

		$page = new \Think\Page($count,10); //传入一个总条数，和每页显示的条数

		$arr = $model->limit($page->firstRow.','.$page->listRows)->select();




		
		

		$btn = $page->show();

		$info = [];


		$info[0] = $arr;

		$info[1]  = $btn;
		
		$info[2] =$count;
		return $info;
	}

	 

}