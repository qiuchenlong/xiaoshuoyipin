<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");
class CouponController extends Controller{   
	//某一个商家的优惠劵
	public function couponlst(){ 
		$user_id = $_REQUEST['user_id'];
		$appid = $_REQUEST['appid'];
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		if($page==null||$page<0){ 
			$page = 0;
		} 
		if($pagecount==null||$pagecount<0){ 
			$pagecount = 10;
		}
		$starcount = $page*$pagecount;
		$Model = M();
		$data = $Model->Query("SELECT * FROM coupon WHERE wxshop_appid='".$appid."' ORDER BY addtime desc LIMIT ".$starcount.",".$pagecount.";");
		foreach ($data as $key => $value) {
			$my_coupon = $Model->Query("SELECT count(*) as count FROM my_coupon WHERE user_id=".$user_id." AND wxshop_appid='".$appid."' AND coupon_id=".$value['id'].";");
			$data[$key]['isling'] = 0;
			if($my_coupon[0]['count']>0){
				$data[$key]['isling'] = 1; 
			} 
		}
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

	//消费者领取某商家优惠券列表
	public function xiaolst(){
		$user_id = $_REQUEST['user_id'];
		$appid = $_REQUEST['appid'];
		$page = $_REQUEST['page'];
		$pagecount = $_REQUEST['pagecount'];
		if($page==null||$page<0){
			$page = 0;
		}
		if($pagecount==null||$pagecount<0){
			$pagecount = 10;
		}
		$starcount = $page*$pagecount;
		$Model = M();
		$data = $Model->Query("SELECT t1.*,t.is_use FROM my_coupon t INNER JOIN coupon t1 ON t.coupon_id=t1.id WHERE t.wxshop_appid='".$appid."' AND t.user_id=".$user_id." ORDER BY t.addtime desc LIMIT ".$starcount.",".$pagecount.";");
		$data = array($data);
		echo getSuccessJson($data,'操作成功'); 
	}

	//删除优惠券
	public function delquan(){
		$coupon_id = $_REQUEST['coupon_id'];
		$Model = M('my_coupon');
		if($Model->delete($coupon_id)){
			$result = array('code'=>200,'msg'=>'删除优惠券成功');
		}else{
			$result = array('code'=>201,'msg'=>'删除优惠券失败');
		}
		$this->ajaxReturn($result);
	} 

	//消费者领取用户
	public function lingqu(){
		//一定要关联店家，要不然在其他小程序会搜出来
		$appid = $_REQUEST['appid'];
		$user_id = $_REQUEST['user_id'];
		$coupon_id = $_REQUEST['coupon_id']; 
		$Model = M('my_coupon'); 
		$where = array();
		$where['wxshop_appid'] = $appid;
		$where['coupon_id'] = $coupon_id;
		$where['user_id'] = $user_id;
		$getcoupon = $Model->WHERE($where)->find();
		if($getcoupon){
			$result = array('code'=>200,'msg'=>'你已领取过该商家的优惠券');
		}else{
			$InsertArr = array(
				'user_id'=>$user_id,
				'wxshop_appid'=>$appid,
				'coupon_id'=>$coupon_id
				);
			if($Model->add($InsertArr)){
				//用户领取成功就减少优惠券一张。
				$Model->execute("UPDATE coupon SET `number`=`number`=1 WHERE id=".$coupon_id.";");
				$result = array('code'=>200,'msg'=>'领取优惠券成功');
			}else{
				$result = array('code'=>201,'msg'=>'领取优惠券失败');
			}
		}
		$this->ajaxReturn($result);
	} 



}

?>