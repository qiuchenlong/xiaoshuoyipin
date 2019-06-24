<?php
namespace Home\Model;
use Think\Model\ViewModel;;
class FaxianViewModel extends ViewModel {
    
    public $viewFields = array(

    	'new_reply'=>array('id','content','_type'=>'LEFT'),
    	'jieqi_system_users'=>array('name','_on'=>'user_id=jieqi_system_users.uid'),

    	);

    
}