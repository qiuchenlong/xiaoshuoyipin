<?php
namespace Home\Controller;
use Think\Controller;
include_once("Common.php");
include_once("mysqlha.php");

class WfxhongbaoController extends Controller{

	public function http_curl($url,$data=''){
	    $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//请求协议
        if(!empty($data)) 
        {
          curl_setopt($ch,CURLOPT_POST,1); //模拟POST 
          curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data, JSON_UNESCAPED_UNICODE)); //将$data数组转成json
        }
        
        $outopt = curl_exec($ch);   
        curl_close($ch); 
        $outopt = json_decode($outopt,true); //数组
        return $outopt; //返回数组
}


	//
	 public function zhifu(){  
    	$user_id = $_REQUEST['user_id'];
    	$type = $_REQUEST['type'];//0支付宝，1微信
    	$money = $_REQUEST['money'];//支付金额
    	$danhao = date('Ymdhis').str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT).$user_id;
    	$InsertArr = array(
    		'user_id'=>$user_id, 
			'type'=>$type, 
			'money'=>$money,
			'danhao'=>$danhao   
         ); 
    	$model = M('hb_chongzhi');
    	if($model->add($InsertArr)){ 
    		$result = array("code"=>200,"danhao"=>$danhao); 
    	}else{
    		$result = array("code"=>201,'msg'=>'购买失败'); 
    	} 
    	$this->ajaxReturn($result);   
    }



	public function adduser(){
		//添加用户
		  $code = $_REQUEST['code']; 
          $userinfo = $_REQUEST['userinfo'];
          $weixin = C("weifenxiang");
          $getopenidurl = "https://api.weixin.qq.com/sns/jscode2session?appid=".$weixin['appId']."&secret=".$weixin['appsecret']."&js_code=".$code."&grant_type=authorization_code"; 
          $result = $this->http_curl($getopenidurl); 
          $fp = fopen('jiejie.txt','a+');
          fwrite($fp,$result);
          fclose($fp); 
          if($result['errcode']>0){   
          	$result =  ['code'=>201,'msg'=>'请联系服务管理员'];
          	echo json_encode($result);
          	exit;
          }  
          $userinfo = json_decode($userinfo,true);//把用户信息转成数组形式
          $data['openid'] = $result['openid'];
          $data['session_key'] = $result['session_key']; 
          $data['nickName'] = $userinfo['nickName']; 
          $data['gender'] = $userinfo['gender'];
          $data['city'] = $userinfo['city'];  
          $data['province'] = $userinfo['province'];   
          $data['country'] = $userinfo['country']; 
          $data['avatarUrl'] = $userinfo['avatarUrl'];//超链接头像

          $DB = M('hb_user');
          $user = $DB->query("SELECT user_id FROM hb_user WHERE openid='".$data['openid']."';");
          if(sizeof($user)>0&&$user[0]['user_id']){    
             $user_id = $user[0]['user_id'];    
            //更新操作 
               $jieguo = $DB->where('user_id='.$user_id)->save($data);
            if($jieguo===false){ 
                $result = ['code'=>201,"msg"=>"更新失败","nickName"=>$data['nickName']];
            }else{ 
                // $_3rd_session = _3rd_session($data['openid'].$data['session_key']);//生成3rd_session
                // S(array($_3rd_session=>$data['openid'].','.$data['session_key'],'expire'=>7200));  
                $result = ['code'=>200,"msg"=>"更新成功","user_id"=>$user_id];   //"_3rd_session"=>$_3rd_session,
             }    
          }else{    
            //添加操作  
            $jieguo = $DB->add($data);  //true返回
            if($jieguo){  
                //$_3rd_session = _3rd_session($data['openid']);//生成3rd_session
                // S(array($_3rd_session=>$data['openid'].','.$data['session_key'],'expire'=>7200));
                $result = ['code'=>200,"user_id"=>$jieguo]; //"_3rd_session"=>$_3rd_session,
            }else{    
                $result = ['code'=>201,"msg"=>"添加失败"];  
            }
          }
          $this->ajaxReturn($result); 
	} 

	//搜索愿望
	public function searchyuanwang(){
		$name = $_REQUEST['id'];
		$Model = M();
		if(!empty($name)){
			$data = $Model->Query("SELECT * FROM hb_xuyuan WHERE ispublic=0 AND label_id=".$name.";");
		}else{
			$data = $Model->Query("SELECT * FROM hb_xuyuan WHERE ispublic=0;");
		}
		echo getSuccessJson(array($data),'查询成功');
	}

    public function labellst(){ 
    	$Model = M();
    	$keywords = $_REQUEST['keywords'];
    	if($keywords==''){
		    	$data = $Model->Query("SELECT * FROM hb_label;");
    	}else{
    	        $data = $Model->Query("SELECT * FROM hb_label WHERE name like '%".$keywords."%';");	
    	}	
    	echo getSuccessJson(array($data),'查询成功'); 
    }

    //添加红包分类
    public function addclassify(){
    	$name = $_REQUEST['name'];
    	$map['name'] = $name; 
    	$map['type'] = 0;//待审核状态
    	$Model = M('hb_label');
    	if($Model->add($map)){ 
           $result = array('code'=>200,'msg'=>'红包标签添加成功');
    	}else{
    		$result = array('code'=>201,'msg'=>'红包标签添加失败');
    	}
    	$this->ajaxReturn($result);
    }

  //多图片上传 
    public function uploadimg(){
    	if($_FILES){ 
			$UpFileTool = new \Think\UpFileTool('file');
			$UpFileTool->upImage(0.3,'Uploads','Uploads');
			$srcImage = $UpFileTool->srcImage;
			$sumbImage = $UpFileTool->sumbImage;
			$result = array('code'=>200,'data'=>array('srcImage'=>$srcImage,'sumbImage'=>$sumbImage));
		}else{
			$result = array('code'=>201,'msg'=>'请上传文件');
		}
		$this->ajaxReturn($result); 
    } 

    public function deluploadimg(){ 
		    	$img = $_REQUEST['srcimage'];
		    	$sumbimg = $_REQUEST['sumbimage'];
		    	$images = explode(",",$img);
		    	$sumbimg = explode(",",$sumbimg);
		    	$rp = C('IMG_rootPath');
		    	//删除原图图片
		        if(is_array($images)){  
		            foreach ($images as $v){
		                    unlink($rp.$v);
			         }  
		         }else{
		         unlink($rp.$images);
		         } 
		         //删除压缩图片
		         if(is_array($sumbimg)){
		         	foreach ($sumbimg as $value) {
		         		unlink($rp.$value);
		         	}
		         }else{
		         	unlink($rp.$sumbimg);
		         }
        } 
  //发表愿望   单个红包不能低于0.01
	public function addyuanwang(){
		$user_id = $_REQUEST['user_id'];
		$content = $_REQUEST['content'];
		$label_id = $_REQUEST['label_id'];
		$ispublic = $_REQUEST['ispublic'];
		$hongbaomoney = $_REQUEST['hongbaomoney'];
		$hongbaonum = $_REQUEST['hongbaonum'];
		$completetime = $_REQUEST['completetime'];
		$Insert = array(
			'user_id'=>$user_id,
			'label_id'=>$label_id,
			'content'=>$content,
			'ispublic'=>$ispublic,
			'hongbaomoney'=>$hongbaomoney, 
			'hongbaonum'=>$hongbaonum,
			'shengyunum'=>$hongbaonum,
			'completetime'=>$completetime
			);
		$Insert['duoimg'] = !empty($_REQUEST['duoimg'])?$_REQUEST['duoimg']:'';
		$Insert['sumbduoimg'] = !empty($_REQUEST['sumbduoimg'])?$_REQUEST['duoimg']:'';  
		if($_FILES){   
			$UpFileTool = new \Think\UpFileTool('flie');
			$UpFileTool->multiImage(0.3,'Uploads','Uploads');
			$duoimg = $UpFileTool->multiSrcImage; 
			$sumbduoimg = $UpFileTool->multiSumbImage;
			$Insert['duoimg'] = !empty($duoimg)?$duoimg:''; 
			$Insert['sumbduoimg'] = !empty($sumbduoimg)?$sumbduoimg:'';  
		}  
		// 	$fp = fopen('aiya.txt','a+');
		// 	fwrite($fp,json_encode($_FILES));
		// 	fclose($fp);
		// die; 
		M()->startTrans();//开启事务    
		$xuyuan_id = M('hb_xuyuan')->data($Insert)->add();
		if($xuyuan_id){
					//操作分配红包   
					$data = hongbao($hongbaomoney,$hongbaonum,$xuyuan_id);
					$lowfen = bcdiv($hongbaomoney,$hongbaonum,2);  
					if(M('hb_hongbao_user')->addAll($data)&&$lowfen>=0.01){  
						$servicecharge = M('system')->where('id=1')->getField('servicecharge');
						$shouxufee = $servicecharge*$hongbaomoney;
						$totalmoney = $shouxufee+$hongbaomoney;
						$usermoney = M('hb_user')->where('user_id='.$user_id)->getField('money');
						if($usermoney>=0){
								M()->execute("UPDATE hb_user SET `money`=`money`-".$totalmoney." WHERE user_id=".$user_id.";");
						        M()->commit();//事务提交  
						         $result = array('code'=>200,'msg'=>'发表成功');
						}else{ 
						        M()->rollback();//事务提交   
						        $result = array('code'=>201,'msg'=>'用户余额不足！');
						}
						 
					}else{ 
						M()->rollback();//回滚 
						$result = array('code'=>201,'msg'=>'服务器压力大,请重试！');
					}
		}else{
					M()->rollback();//回滚
					$result = array('code'=>201,'msg'=>'发表失败');
		}
		$this->ajaxReturn($result); 
	}   

	public function shixianxuyuan(){
		$id = $_REQUEST['id'];
		$states = $_REQUEST['states'];
		$Model = M('hb_xuyuan');
		$updateArr = array(
			'id'=>$id,
			'states'=>$states
			);
		if($Model->save($updateArr)){
			$result = array('code'=>200,'msg'=>'愿望实现状态改变成功');
		}else{
			$result = array('code'=>201,'msg'=>'愿望实现状态改变失败');
		}
		$this->ajaxReturn($result); 
	}

      //检测金额是否足够
	 public function checkmoney(){
	 	 	$money = $_REQUEST['money'];
	 	 	$num = $_REQUEST['num'];
	 	    $user_id = $_REQUEST['user_id']; 
	 	    $lowfen = bcdiv($money,$num,2);
	 	    if($lowfen>=0.01&&$num<=100){
			 	    $servicecharge = M('system')->where('id=1')->getField('servicecharge');
					$shouxufee = $servicecharge*$money;
					$totalmoney = $shouxufee+$money; 
			 	    $usermoney = M('hb_user')->where('user_id='.$user_id)->getField('money');
			 	    if($usermoney>=$totalmoney){  
			 	  		$result = array('code'=>200,'shouxufei'=>$shouxufee,'hongtotal'=>$money,'msg'=>'可以发红包啦！');
			 	    }else{ 
			 	  		$result = array('code'=>201,'msg'=>'余额不足够，请充值');
			 	    }
			 }elseif($num>100){
			 	$result = array('code'=>201,'msg'=>'一次最多可发100个红包');
			 }else{ 
			 	$result = array('code'=>201,'msg'=>'单个红包金额不可低于0.01元');
			 }
	 	  $this->ajaxReturn($result); 
	 }

 

//我的金额
			public function mymoney(){
                  $user_id = $_REQUEST['user_id'];
                  $Model = M();
                  $yue = $Model->Query("SELECT money FROM hb_user WHERE user_id=".$user_id.";");
                  echo getSuccessJson($yue,'查询成功');
			}


//联系客服
			public function lianxi(){
				$Model = M(); 
				$data = $Model->Query("SELECT phone,`call` FROM system WHERE id=1");
				echo getSuccessJson($data,'查询成功');
			}


  //我发布的愿望
			public function myyuanwanglst(){
					$user_id = $_REQUEST['user_id'];
					$page = $_REQUEST['page'];
					$pagecount = $_REQUEST['pagecount'];
					if($page==null||$page<=0){
						$page = 0;
					}
					if($pagecount==null||$pagecount<=0){
						$pagecount = 10;
					}
					$startcount = $page*$pagecount;
					$Model = M();
					$data = $Model->Query("SELECT t1.*,t2.nickName,t2.avatarUrl FROM  hb_xuyuan t1 INNER JOIN hb_user t2 ON t1.user_id=t2.user_id WHERE t1.user_id=".$user_id." ORDER BY t1.addtime desc LIMIT ".$startcount.",".$pagecount.";");
					echo getSuccessJson(array($data),'查询成功');
			}

  //我领取的红包
			public function myhongbao(){
				$user_id = $_REQUEST['user_id'];
				$page = $_REQUEST['page']; 
					$pagecount = $_REQUEST['pagecount'];
					if($page==null||$page<=0){
						$page = 0;
					}
					if($pagecount==null||$pagecount<=0){
						$pagecount = 10;
					}
					$startcount = $page*$pagecount;
				$Model = M();
				$zong = $Model->Query("SELECT IFNULL(SUM(`money`),0) as total FROM hb_hongbao_user WHERE user_id=".$user_id.";");
				$data = $Model->Query("SELECT t.*,t2.nickName,t2.avatarUrl,t3.name as label_name FROM hb_hongbao_user t INNER JOIN hb_xuyuan t1 ON t.xuyuan_id=t1.id INNER JOIN hb_user t2 ON t1.user_id=t2.user_id LEFT JOIN hb_label t3 ON t3.id=t1.label_id WHERE t.user_id=".$user_id." LIMIT ".$startcount.",".$pagecount.";");
				$arr = array( 
					'totalmoney'=>$zong[0]['total'], 
					'data'=>$data
					);
				echo getSuccessJson($arr,'查询成功');
			}

 //愿望详情
			public function yuanwangdetail(){
				   $yuanwang_id = $_REQUEST['yuanwang_id'];
				   $Model = M(); 
				   //改变愿望实现与否状态
				   $Model->execute("UPDATE hb_xuyuan SET states=2 WHERE states=0 AND now()>completetime;");
				   $data = $Model->Query("SELECT t1.* ,t2.nickName,t2.avatarUrl,t3.name as label_name FROM hb_xuyuan t1 INNER JOIN hb_user t2 ON t2.user_id=t1.user_id LEFT JOIN hb_label t3 ON t3.id=t1.label_id WHERE t1.id=".$yuanwang_id.";");
				   echo getSuccessJson($data,'查询成功');
			}

 //愿望列表 
			public function yuanwanglst(){
					$page = $_REQUEST['page'];
					$pagecount = $_REQUEST['pagecount'];
					$name = $_REQUEST['id'];
					if($page==null||$page<=0){
						$page = 0; 
					} 
					if($pagecount==null||$pagecount<=0){    
						$pagecount = 10;
					}
					$startcount = $page*$pagecount;  
					$Model = M();
					if(!empty($name)){
							$data = $Model->Query("SELECT t1.*,t2.nickName,t2.avatarUrl,t3.name as label_name FROM  hb_xuyuan t1 INNER JOIN hb_user t2 ON t1.user_id=t2.user_id LEFT JOIN hb_label t3 ON t3.id=t1.label_id WHERE t1.label_id=".$name." AND t1.ispublic=0 ORDER BY t1.addtime desc LIMIT ".$startcount.",".$pagecount.";");
					}else{
							$data = $Model->Query("SELECT t1.*,t2.nickName,t2.avatarUrl,t3.name as label_name FROM  hb_xuyuan t1 INNER JOIN hb_user t2 ON t1.user_id=t2.user_id LEFT JOIN hb_label t3 ON t3.id=t1.label_id WHERE t1.ispublic=0 ORDER BY t1.addtime desc LIMIT ".$startcount.",".$pagecount.";");
					}
					

					echo getSuccessJson(array($data),'查询成功'); 
			}  

//评论列表
			public function pinglunlst(){
				    $page = $_REQUEST['page']; 
				    $xuyuan_id = $_REQUEST['xuyuan_id']; 
					$pagecount = $_REQUEST['pagecount'];
					if($page==null||$page<=0){ 
						$page = 0;
					} 
					if($pagecount==null||$pagecount<=0){ 
						$pagecount = 10;
					}
					$startcount = $page*$pagecount; 
					$Model = M();
					$data = $Model->Query("SELECT t1.*,t2.nickName,t2.avatarUrl FROM  hb_zhufu t1 INNER JOIN hb_user t2 ON t1.user_id=t2.user_id WHERE t1.xuyuan_id=".$xuyuan_id." ORDER BY t1.addtime desc LIMIT ".$startcount.",".$pagecount.";");
					foreach ($data as $key => $value) {
            	  	  $usermoney = $Model->Query("SELECT IFNULL(money,0.00) as usermoney FROM hb_hongbao_user WHERE user_id=".$value['user_id']." AND xuyuan_id=".$value['xuyuan_id']." AND type=2;");
            	  	  if(empty($usermoney[0]['usermoney'])){
            	  	  		$data[$key]['hongbaomoney'] = 0.00;
            	  	  }else{
            	  	  		$data[$key]['hongbaomoney'] = $usermoney[0]['usermoney'];
            	  	  }
            	  } 
					echo getSuccessJson(array($data),'查询成功'); 
			}

 //加油（是领取红包？）
 			public function jiayou(){ 
 				    //防止红包重复拿
 					$xuyuan_id = $_REQUEST['xuyuan_id'];
 					$user_id = $_REQUEST['user_id'];
 					if(!empty($xuyuan_id)&&!empty($user_id)){
 							$fp = fopen("lock.txt", "w+");  
							if(!flock($fp,LOCK_EX | LOCK_NB)){  
								$result = array('code'=>201,'msg'=>"系统繁忙，请稍后再试");
		                    }else{
		 					   // $Model->execute("UPDATE hb_xuyuan SET jiayou_num=jiayou_num+1 WHERE id=".$xuyuan_id.";");
		 					    $Model = M(); 
		 					    $count = $Model->Query("SELECT count(*) as count FROM hb_hongbao_user WHERE xuyuan_id=".$xuyuan_id." AND user_id=".$user_id.";");  
		 					    if($count[0]['count']==0){ 
		 					    		$id = $Model->Query("SELECT id,`money` FROM hb_hongbao_user WHERE xuyuan_id=".$xuyuan_id." AND user_id=0;");
				                    	if(!empty($id[0]['id'])){
				                    		$addtime = date('Y-m-d H:i:s',time());
				                    		$Model->execute("UPDATE hb_hongbao_user SET user_id=".$user_id.",addtime='".$addtime."' WHERE id=".$id[0]['id'].";");
				                    		$Model->execute("UPDATE hb_user SET `money`=`money`+".$id[0]['money']." WHERE user_id=".$user_id.";");
				                    		flock($fp,LOCK_UN);//释放锁 
				                    		$result = array('code'=>200,'msg'=>'红包领取成功');  
				                    	}else{
				                    		$result = array('code'=>201,'msg'=>'红包已领取完了'); 
		                    	         } 
		 					    }else{ 
		 					    		$result = array('code'=>201,'msg'=>'你已经领取过红包啦！'); 
		 					    }	 
		                    }
 					}else{
 						  $result = array('code'=>201,'msg'=>'请检查参数！！');
 					}
                    fclose($fp);//关闭文件
                    $this->ajaxReturn($result);
 			}


 			protected function lingquhongbao($xuyuan_id,$user_id,$type){ 
 				    //防止红包重复拿
 					if(!empty($xuyuan_id)&&!empty($user_id)){
 							$fp = fopen("lock.txt", "w+");  
							if(!flock($fp,LOCK_EX | LOCK_NB)){  
								$result = array('code'=>201,'msg'=>"系统繁忙，请稍后再试");
		                    }else{
		 					   // $Model->execute("UPDATE hb_xuyuan SET jiayou_num=jiayou_num+1 WHERE id=".$xuyuan_id.";");
		 					    $Model = M(); 
		 					    $count = $Model->Query("SELECT count(*) as count FROM hb_hongbao_user WHERE type=".$type." AND xuyuan_id=".$xuyuan_id." AND user_id=".$user_id.";");  
		 					    if($count[0]['count']<3){ //最多领取3次
		 					    		$id = $Model->Query("SELECT id,`money` FROM hb_hongbao_user WHERE xuyuan_id=".$xuyuan_id." AND user_id=0;");
				                    	if(!empty($id[0]['id'])){ 
				                    		$addtime = date('Y-m-d H:i:s',time()); 
				                    		$Model->execute("UPDATE hb_hongbao_user SET type=".$type.",user_id=".$user_id.",addtime='".$addtime."' WHERE id=".$id[0]['id'].";");
				                    		$Model->execute("UPDATE hb_xuyuan SET shengyunum=shengyunum-1 WHERE id=".$xuyuan_id.";");
				                    		$Model->execute("UPDATE hb_user SET `money`=`money`+".$id[0]['money']." WHERE user_id=".$user_id.";");
				                    		flock($fp,LOCK_UN);//释放锁 
				                    		switch ($type) { 
				                    			case '1':  
				                    				$msg = '你已点赞成功，并且领取到红包'.$id[0]['money'].'金额';
				                    				break;
				          						case '2':
				                    				$msg = '你已评论成功，并且领取到红包'.$id[0]['money'].'金额';
				                    				break;
				                    			case '3': 
				                    				$msg = '你已分享成功，并且领取到红包'.$id[0]['money'].'金额';
				                    				break;
				                    		}
				                    		$result = array('code'=>200,'msg'=>$msg,'hongbao'=>$id[0]['money']);   
				                    	}else{
				                    		switch ($type) {
				                    			case '1':
				                    				$msg = '你已点赞成功，但是红包已领取完了';//'.$id[0]['money'].'金额';
				                    				break;
				          						case '2':
				                    				$msg = '你已评论成功，但是红包已领取完了';//.$id[0]['money'].'金额';
				                    				break;
				                    			case '3':
				                    				$msg = '你已分享成功，但是红包已领取完了';//.$id[0]['money'].'金额';
				                    				break;
				                    		}
				                    		$result = array('code'=>201,'msg'=>$msg); 
		                    	         } 
		 					    }else{ 
		 					    		switch ($type) {
				                    			case '1':
				                    				$msg = '你已点赞成功，并且你已经领取过红包了';//'.$id[0]['money'].'金额';
				                    				break;
				          						case '2':
				                    				$msg = '你已评论成功，并且你已经领取过红包了';//.$id[0]['money'].'金额';
				                    				break;
				                    			case '3':
				                    				$msg = '你已分享成功，并且你已经领取过红包了';//.$id[0]['money'].'金额';
				                    				break;
				                    		}
		 					    		$result = array('code'=>201,'msg'=>$msg); 
		 					    }	  
		                    }
 					}else{
 						  $result = array('code'=>201,'msg'=>'请检查参数！！');
 					}
                    fclose($fp);//关闭文件
                    return $result;
 			}
//愿望点赞
 			public function dianzan(){
 				$user_id = $_REQUEST['user_id']; 
 				$xuyuan_id = $_REQUEST['xuyuan_id'];
 				$Model = M('hb_dianzan');
 				$count = $Model->Query("SELECT count(*) as count FROM hb_dianzan WHERE user_id=".$user_id." AND xuyuan_id=".$xuyuan_id.";");
 				if($count[0]['count']>0){
 					//点赞过了
 					$result = array('code'=>201,'msg'=>'你已经点赞过了啦！'); 
 				}else{
 					//点赞然后去领红包
 					$insertArr = array(
 						'user_id'=>$user_id,
 						'xuyuan_id'=>$xuyuan_id
 						);
 					if($Model->add($insertArr)){
 						 $Model->execute("UPDATE hb_xuyuan SET jiayou_num=jiayou_num+1 WHERE id=".$xuyuan_id.";");
 					     $result = $this->lingquhongbao($xuyuan_id,$user_id,1);
 					}else{
 						$result = array('code'=>201,'msg'=>'点赞失败'); 
 					}
 				}
 				$this->ajaxReturn($result);
 			} 
 
//分享
 			 public function share(){
 			 	 $user_id = $_REQUEST['user_id'];
 			 	 $xuyuan_id = $_REQUEST['xuyuan_id'];
 			 	 $Model = M('hb_share');
 			 	 $count = $Model->Query("SELECT count(*) as count FROM hb_share WHERE user_id=".$user_id." AND xuyuan_id=".$xuyuan_id.";");
 			 	 if($count[0]['count']==0){
 			 	 	//有红包
 			 	 	$insertArr = array(
 						'user_id'=>$user_id,
 						'xuyuan_id'=>$xuyuan_id 
 						);
 					if($Model->add($insertArr)){
 						 $Model->execute("UPDATE hb_xuyuan SET share_num=share_num+1 WHERE id=".$xuyuan_id.";");
 					     $result = $this->lingquhongbao($xuyuan_id,$user_id,3);
 					}else{
 						$result = array('code'=>201,'msg'=>'分享失败'); 
 					}
 			 	 }else{
 			 	 	//没红包
 			 	 	$insertArr = array(
 						'user_id'=>$user_id,
 						'xuyuan_id'=>$xuyuan_id
 						); 
 					if($Model->add($insertArr)){
 						 $Model->execute("UPDATE hb_xuyuan SET share_num=share_num+1 WHERE id=".$xuyuan_id.";");
 						$result = array('code'=>200,'msg'=>'分享成功'); 
 					}else{
 						$result = array('code'=>201,'msg'=>'分享失败'); 
 					}
 			 	 }
 			 	 $this->ajaxReturn($result);
 			 }

 //祝愿  
            public function zhufu(){
 			 	 $content = $_REQUEST['content'];
 				 $user_id = $_REQUEST['user_id'];
 				 $xuyuan_id = $_REQUEST['xuyuan_id']; 
 				 $Model = M('hb_zhufu');
 			 	 $count = $Model->Query("SELECT count(*) as count FROM hb_zhufu WHERE user_id=".$user_id." AND xuyuan_id=".$xuyuan_id.";");
 			 	 if($count[0]['count']==0){
 			 	 	//有红包
 			 	 	$insertArr = array( 
 				 	'user_id'=>$user_id,
 				 	'content'=>$content,
 				 	'xuyuan_id'=>$xuyuan_id
 				 	);
 					if($Model->add($insertArr)){
 						 $Model->execute("UPDATE hb_xuyuan SET zhuyuan_num=zhuyuan_num+1 WHERE id=".$xuyuan_id.";");
 					     $result = $this->lingquhongbao($xuyuan_id,$user_id,2);
 					}else{
 						$result = array('code'=>201,'msg'=>'评论失败，请重试！'); 
 					}
 			 	 }else{
 			 	 	//没红包
 			 	 	$insertArr = array( 
 				 	'user_id'=>$user_id,
 				 	'content'=>$content,
 				 	'xuyuan_id'=>$xuyuan_id
 				 	); 
 					if($Model->add($insertArr)){
 						 $Model->execute("UPDATE hb_xuyuan SET zhuyuan_num=zhuyuan_num+1 WHERE id=".$xuyuan_id.";");
 						 $result = array('code'=>200,'msg'=>'评论成功'); 
 					}else{
 						$result = array('code'=>201,'msg'=>'评论失败，请重试！'); 
 					}
 			 	 }
 			 	 $this->ajaxReturn($result); 
 			 }

 //用户信息
 			 public function userinfo(){
 			 	$user_id = $_REQUEST['user_id'];
 			 	$Model = M();
 			 	$data = $Model->Query("SELECT * FROM hb_user WHERE user_id=".$user_id.";");
 			 	echo getSuccessJson($data,'查询成功');
 			 }

 			 public function edituser(){
 			 	$nickName = $_REQUEST['nickName'];
				$summary = $_REQUEST['summary'];
				// $phone = $_REQUEST['phone'];
				$user_id = $_REQUEST['user_id'];
				$updateArr['user_id'] = $user_id;
				// if($phone != ''){ 
				//      $updateArr['phone'] = $phone;
				// }
				if($summary != ''){
				     $updateArr['summary'] = $summary;
				}
				if($nickName != ''){
				     $updateArr['nickName'] = $nickName;
				}
 			 	if ($_FILES) { 
 			 		$UpFileTool = new \Think\UpFileTool('headimg');// 实例化上传类
		            $UpFileTool->upImage(0.3,'Uploads','Uploads');
		            $headimg=$UpFileTool->srcImage;
		            deleteImage($headimg); 
				    $sumbheadimg = $UpFileTool->sumbImage;

				    $updateArr['avatarUrl'] = 'https://youdingb.com/shouquan/'.$sumbheadimg;
 			 	}
 			 	$Modle = M('hb_user');
 			 	if($Modle->save($updateArr)!==false){
 			 		$result = array('code'=>200,'msg'=>'更新成功'); 
 			 	}else{
 			 		$result = array('code'=>201,'msg'=>'更新失败'); 
 			 	}
 			 	$this->ajaxReturn($result);
 			 	
 			 }

 			 public function zhuce(){
 			 	$phone = $_REQUEST['phone'];
 			 	$password = $_REQUEST['password'];
 			 	$Model = M('hb_user');
 			 	$count = $Model->where('phone='.$phone)->count();
 			 	if($count>0){
                      $result = array('code'=>201,'msg'=>'电话号码已经存在');
 			 	}else{
 			 		  $insertArr = array('phone' => $phone,'password'=>$password);
 			 		  if($id = $Model->add($insertArr)){
 			 		  	$result = array('code'=>200,'msg'=>'注册成功','userid'=>$id);
 			 		  }else{ 
 			 		  	$result = array('code'=>201,'msg'=>'注册不成功');
 			 		  }
 			 	}
 			 	$this->ajaxReturn($result);
 			 } 

 			 //忘记密码
 			 public function forgetmi(){
 			 	$phone = $_REQUEST['phone'];
 			 	$password = $_REQUEST['password'];
 			 	$Model = M();
 			 	$code = $Model->execute("UPDATE hb_user SET password='".$password."' WHERE phone='".$phone."';");
 			 	if($code){
 			 		$result = array('code'=>200,'msg'=>'修改密码成功');
 			 	}else{
 			 		$result = array('code'=>201,'msg'=>'修改密码失败');
 			 	}
 			 	$this->ajaxReturn($result);
 			 }

 			 //微信登录
 			//  public function otherlogin(){
				// $openid = $_REQUEST['openid'];
				// $Model = M(); 
				// $user = $Model->Query("SELECT * FROM hb_user WHERE openid='".$openid."'");
				// $user = array($user); 
				// echo getSuccessJson($user); 
    //         }  

            public function otherlogin(){
			    	$openid = $_REQUEST['openid'];//微信唯一标识
			    	$name = $_REQUEST['nickname'];//微信名
					$Model = M();
					$user = $Model->Query("select count(*) as count,user_id from hb_user where openid='".$openid."'");
					$count = $user[0]['count'];
					if($count>0){
						$id = $user[0]['user_id'];  
					}else{     
						$UpFileTool = new \Think\UpFileTool('headimg');// 实例化上传类
			            $UpFileTool->upImage(0.3,'Uploads','Uploads');
			            $headimg=$UpFileTool->srcImage; 
						$sumbheadimg = $UpFileTool->sumbImage;
						deleteImage($sumbheadimg);
						$insertArr = array( 
						   "openid"=>$openid,
						   "nickName"=>$name,
						   "avatarUrl"=>'https://youdingb.com/shouquan/'.$headimg
						   // "sumbheadimg"=>$sumbheadimg
						);
						$id = myinsert('hb_user',$insertArr);
					}
					echo '{"code":"200","msg":"更新成功","userid":"'.$id.'"}';	 
                 }   
             

            //手机登录 
            public function phonelogin(){
            	$phone = $_REQUEST['phone'];
            	$password = $_REQUEST['password']; 
            	$map['phone'] = $phone; 
            	$map['password'] = $password;
            	$Model = M('hb_user');
            	$data = $Model->where($map)->find();
            	if(!empty($data['user_id'])){
            		echo getSuccessJson($data,'查询成功');
            		exit;
            	}else{
            		echo json_encode(array('code'=>201,'msg'=>'密码或账号错误，请重试！'));
            		exit;
            	}
            }


            public function tiXian(){
            	$money = $_REQUEST['money'];
            	$user_id = $_REQUEST['user_id'];
            	$Model = M('hb_withdraw');
            	$moneyarr = $Model->Query("SELECT money FROM hb_user WHERE user_id=".$user_id);
            	$usermoney = $moneyarr[0]['money'];
            	if($usermoney>=$money){
            		$insertArr  = array(
            			'user_id'=>$user_id,
            			'money'=>$money
            			);
            		if($Model->add($insertArr)){
            			$Model->execute("UPDATE hb_user SET `money`=`money`-".$money." WHERE user_id=".$user_id);
            			$result = array('code'=>200,'msg'=>'提现成功');
            		}else{
            			$result = array('code'=>201,'msg'=>'提现失败'); 
            		} 
            	}else{
            		$result = array('code'=>201,'msg'=>'余额不足够，请充值');
            	}
            	$this->ajaxReturn($result);
            }


            public function connectxuyuan(){
            	 $xuyuan_id = $_REQUEST['xuyuan_id'];
            	 $user_id = $_REQUEST['user_id'];
            	 $Model = M('hb_collect');
            	 $map['user_id'] = $user_id;
            	 $map['xuyuan_id'] = $xuyuan_id;
            	 $count = $Model->where($map)->count();
            	 if($count>0){
            	 	$result = array('code'=>201,'msg'=>'你已收藏过该愿望');
            	 }else{
            	 	if($Model->add($map)){
            	 		$result = array('code'=>200,'msg'=>'收藏该愿望成功');
            	 	}else{
            	 		$result = array('code'=>201,'msg'=>'收藏该愿望失败');
            	 	}
            	 }
            	 $this->ajaxReturn($result);
            }

            //点赞获得红包
            public function hongbaolst(){
            	 $Model = M();
            	 $page = $_REQUEST['page'];
				    $xuyuan_id = $_REQUEST['xuyuan_id']; 
					$pagecount = $_REQUEST['pagecount'];
					if($page==null||$page<=0){ 
						$page = 0;
					}  
					if($pagecount==null||$pagecount<=0){ 
						$pagecount = 10; 
					}
			     $startcount = $page*$pagecount;
            	 $data = $Model->Query("SELECT t1.*,t2.nickName,t2.avatarUrl FROM  hb_dianzan t1 INNER JOIN hb_user t2 ON t1.user_id=t2.user_id WHERE t1.xuyuan_id=".$xuyuan_id." ORDER BY t1.addtime desc LIMIT ".$startcount.",".$pagecount.";"); 
            	 foreach ($data as $key => $value) {
            	  	  $usermoney = $Model->Query("SELECT IFNULL(money,0.00) as usermoney FROM hb_hongbao_user WHERE user_id=".$value['user_id']." AND xuyuan_id=".$value['xuyuan_id']." AND type=1;");
            	  	  if(empty($usermoney[0]['usermoney'])){
            	  	  		$data[$key]['hongbaomoney'] = 0.00;
            	  	  }else{
            	  	  		$data[$key]['hongbaomoney'] = $usermoney[0]['usermoney'];
            	  	  }
            	  } 
					echo getSuccessJson(array($data),'查询成功');  
            }

            public function collectlst(){
            	 $Model = M();
            	 $page = $_REQUEST['page'];
				    $xuyuan_id = $_REQUEST['xuyuan_id']; 
					$pagecount = $_REQUEST['pagecount'];
					if($page==null||$page<=0){ 
						$page = 0;
					}  
					if($pagecount==null||$pagecount<=0){ 
						$pagecount = 10;
					}
			     $startcount = $page*$pagecount;
            	 $data = $Model->Query("SELECT t1.*,t2.nickName,t2.avatarUrl FROM  hb_collect t1 INNER JOIN hb_user t2 ON t1.user_id=t2.user_id WHERE t1.xuyuan_id=".$xuyuan_id." ORDER BY t1.addtime desc LIMIT ".$startcount.",".$pagecount.";"); 
					echo getSuccessJson(array($data),'查询成功');    
            }

            public function sharelst(){
            	 $Model = M();
            	 $page = $_REQUEST['page'];
				    $xuyuan_id = $_REQUEST['xuyuan_id']; 
					$pagecount = $_REQUEST['pagecount'];
					if($page==null||$page<=0){ 
						$page = 0;
					}  
					if($pagecount==null||$pagecount<=0){ 
						$pagecount = 10;
					}
			     $startcount = $page*$pagecount;
            	 $data = $Model->Query("SELECT t1.*,t2.nickName,t2.avatarUrl FROM  hb_share t1 INNER JOIN hb_user t2 ON t1.user_id=t2.user_id WHERE t1.xuyuan_id=".$xuyuan_id." ORDER BY t1.addtime desc LIMIT ".$startcount.",".$pagecount.";");
            	 foreach ($data as $key => $value) {
            	  	  $usermoney = $Model->Query("SELECT IFNULL(money,0.00) as usermoney FROM hb_hongbao_user WHERE user_id=".$value['user_id']." AND xuyuan_id=".$value['xuyuan_id']." AND type=3;");
            	  	  if(empty($usermoney[0]['usermoney'])){
            	  	  		$data[$key]['hongbaomoney'] = 0.00;
            	  	  }else{
            	  	  		$data[$key]['hongbaomoney'] = $usermoney[0]['usermoney'];
            	  	  }
            	  } 


					echo getSuccessJson(array($data),'查询成功');  
            }


            //绑定微信账号
            public function bangwei(){
            	$weixincount = $_REQUEST['weixincount'];
            	$user_id = $_REQUEST['user_id'];
            	$updateArr = array(
            		'weixincount'=>$weixincount,
            		'user_id'=>$user_id
            		);
            	$Model = M('hb_user');
            	if($Model->save($updateArr)!==false){
            		$result = array('code'=>200,'msg'=>'绑定微信账号成功');
            	}else{
            		$result = array('code'=>201,'msg'=>'绑定微信账号失败');
            	}
            	$this->ajaxReturn($result);
            }






}