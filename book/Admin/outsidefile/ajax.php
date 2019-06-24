<?php

/* ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT); */


mysql_query('SET NAMES UTF8'); 
date_default_timezone_set('Asia/Shanghai');
$type=array('*'); 

if(isset($_GET[periods])){
	$periods = $_REQUEST[periods];
	$per=mysql_fetch_app("periods",$type,"id=$periods","1");
	$img = explode(',',$per[0][goods_images]);
	$goodsimg = $img[0];
	$num = $per[0][existing].'/'.$per[0][headcount];
	$goodsname = $per[0][goodsname];
	$arr= array('number'=>"$num",'name'=>"$goodsname",'image'=>"$goodsimg");
	echo json_encode($arr);
}else if(isset($_GET[goods])){
	//$periodsql=mysql_query("SELECT * from periods where state=0 and fk_goodsid=$_REQUEST[goods] order by id desc limit 1");
	$goods = $_REQUEST[goods];
	$per=mysql_fetch_app("periods",$type," state=0 and fk_goodsid=$goods order by id desc","1",0,1);

	$img = explode(',',$per[0][goods_images]);
	$goodsimg = $img[0];
	$fk_number = $per[0][fk_number];
	$num = $per[0][existing].'/'.$per[0][headcount];
	$arr= array('number'=>"$num",'periods'=>"$fk_number",'image'=>"$goodsimg");
	echo json_encode($arr);
}

?>

<?php
// GLOBAL_FUNCTION_DEFINE
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// 描述：以下不要修改，自动会更新
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

/* MySQL快速插入 */
function mysql_insert_app($table_name, $arr_field_names, $arr_field_values){
	return mysql_insert_db(db_connection(), $table_name, $arr_field_names, $arr_field_values);
}
function mysql_insert_dic($table_name, $dic_fields){
	return mysql_insert_app($table_name, array_keys($dic_fields), array_values($dic_fields));
}

/* MySQL快速查找 */
function mysql_fetch_app($table_name, $arr_field_names, $str_where, $return_type = 0, $page = 0, $pagesize = 100){
	return mysql_fetch_db(db_connection(), $table_name, $arr_field_names, $str_where, $return_type, $page, $pagesize);
}

/* MySQL快速更新 */
function mysql_update_app($table_name, $arr_field_names, $arr_field_values, $str_sql_where){
	return mysql_update_db(db_connection(), $table_name, $arr_field_names, $arr_field_values, $str_sql_where);
}
function mysql_update_dic($table_name, $dic_fields, $str_sql_where){
	return mysql_update_app($table_name, array_keys($dic_fields), array_values($dic_fields), $str_sql_where);
}

/* MySQL快速删除 */
function mysql_delete_app($table_name, $sql_where){
	return mysql_delete_db(db_connection(), $table_name, $sql_where);
}


// 核心基础代码-----------------------------------------------------------------------------------------------------------------------

/**
 * 根据当前API路径，获取appid
 */
function get_appid(){
	$api_path = $_SERVER['SCRIPT_NAME'];
	$appid = null;
	while(!is_numeric($appid = basename($api_path))){
		$api_path = dirname($api_path);
	}
	return $appid;
}

/**
 * 获取当前api路径根目录
 */
function get_apiroot(){
	$api_path = $_SERVER['SCRIPT_FILENAME'];
	$appid = null;
	while(!is_numeric($appid = basename($api_path))){
		$api_path = dirname($api_path);
	}
	return $api_path;
}

/**
 * 文件上传自动处理函数
 */
function upload_file($file){
	$appid = get_appid();
	
	// 上传目录获取
	$absolute_path = get_root_dir() . "/";
	$sql_path      = "uploads/" . "{$appid}/";
	$to_path       = $absolute_path . $sql_path;
	if (!is_dir($to_path)) { mkdir($to_path, 777, true); }
	
	$extension_name = pathinfo($file['name'], PATHINFO_EXTENSION);
    do {
		$new_name = date('YmdHis') . rand(10000000, 99999999) . rand(10000000, 99999999). '.' . $extension_name;
    } while(file_exists($to_path.$new_name));
  
    // upload file
    if(is_uploaded_file($file['tmp_name'])){
		if(move_uploaded_file($file['tmp_name'], $to_path.$new_name)){
			// $db_field_name[$key] = $sql_path.$new_name;
			// 生成略缩图
			if($extension_name == "jpg" || $extension_name == "jpeg" || $extension_name == "png"){
				if($extension_name == "jpg" || $extension_name == "jpeg"){
					$im = imagecreatefromjpeg($to_path.$new_name);
				}else if( $extension_name == "png"){
					$im = imagecreatefrompng($to_path.$new_name);
				}
				
				// itm\resize_image($im, 100, 100, $to_path.$new_name . ".smallest" );
				resize_image($im, 200, 200, $to_path.$new_name . ".small" );
				resize_image($im, 400, 400, $to_path.$new_name . ".medium" );
				// itm\resize_image($im, 600, 600, $to_path.$new_name . ".large" );
				// itm\resize_image($im, 800, 800, $to_path.$new_name . ".largest" );
			}
			
			return ($sql_path.$new_name);
			
			// $text_size += mb_strlen($db_field_name[$key], 'iso-8859-1');
			// $file_size += $file["size"];
        }else{
			return false;
        }
    } else {
		return false;
    }
}

function handle_array_file($files, $index){
	$appid = get_appid();
	
	// 上传目录获取
	$absolute_path = get_root_dir() . "/";
	$sql_path      = "uploads/" . "{$appid}/";
	$to_path       = $absolute_path . $sql_path;
	if (!is_dir($to_path)) { mkdir($to_path, 777, true); }
	
	$extension_name = pathinfo($files['name'][$index], PATHINFO_EXTENSION);
    do {
		$new_name = date('YmdHis') . rand(10000000, 99999999) . rand(10000000, 99999999). '.' . $extension_name;
    } while(file_exists($to_path.$new_name));
  
    // upload file
    if(is_uploaded_file($files['tmp_name'][$index])){
		if(move_uploaded_file($files['tmp_name'][$index], $to_path.$new_name)){
			// $db_field_name[$key] = $sql_path.$new_name;
			if($extension_name == "jpg" || $extension_name == "jpeg" || $extension_name == "png"){
				if($extension_name == "jpg" || $extension_name == "jpeg"){
					$im = imagecreatefromjpeg($to_path.$new_name);
				}else if( $extension_name == "png"){
					$im = imagecreatefrompng($to_path.$new_name);
				}
				
				// itm\resize_image($im, 100, 100, $to_path.$new_name . ".smallest" );
				resize_image($im, 200, 200, $to_path.$new_name . ".small" );
				resize_image($im, 400, 400, $to_path.$new_name . ".medium" );
				// itm\resize_image($im, 600, 600, $to_path.$new_name . ".large" );
				// itm\resize_image($im, 800, 800, $to_path.$new_name . ".largest" );
			}
			
			return ($sql_path.$new_name);
			
			// $text_size += mb_strlen($db_field_name[$key], 'iso-8859-1');
			// $file_size += $file["size"];
        }else{
			return false;
        }
    } else {
		return false;
    }
}

function upload_files($files){
	$files_path = array();
	
	$count = count($files['name']);
	for($i = 0; $i < $count; $i++){
		$files_path[] = handle_array_file($files, $i);
	}
	return $files_path;
}

/**
 * 文件更新自动处理函数
 */
function upload_cover($table_name, $field_name, $id, $file){	
	$obj = mysql_fetch_app($table_name, array($field_name), "id={$id}")[0];
	
	unlink(get_root_dir() . "/" . $obj->$field_name);
	
	return uploadFile($file);
}

/**
 * 获取当前应用的数据库连接对象（mysqli）
 * 
 * (0) 请不要close该对象，因为所有数据库增删改查函数都用此对象，请确保后面的代码不再进行数据库操作才close
 * (1) 如果没有引入Model-Core，将返回false
 */
function db_connection(){
	if(isset($GLOBALS["nbryTNvRdE"])){
		return $GLOBALS["nbryTNvRdE"];
	}
	
	// $apiroot = get_apiroot();
	$apiroot = get_root_dir() . "/apis/" . get_appid();
	$config_root = $apiroot . "/Model_Core/core";
	if(is_dir($config_root)){
		$dbhost = file_get_contents($config_root . "/config.dbhost.data");
		$dbname = file_get_contents($config_root . "/config.dbname.data");
		$dbpassword = file_get_contents($config_root . "/config.dbpassword.data");
		$dbport = file_get_contents($config_root . "/config.dbport.data");
		$dbuser = file_get_contents($config_root . "/config.dbuser.data");
		
		$conn = new mysqli($dbhost, $dbuser, $dbpassword, $dbname, $dbport);
		$GLOBALS["nbryTNvRdE"] = $conn;
		$conn->query("SET NAMES UTF8");
		
		return $conn;
	}else {
		die("<br/>你没有引入核心模块，无法驱动数据库操作，请引入核心模块后再试！<br/>");
	}
}

/**
 * mysql插入
 */
function mysql_insert_db($db_conn, $table_name, $arr_field_names, $arr_field_values){
	$fields = implode(",", $arr_field_names);
	$values = "'" . implode("','", $arr_field_values) . "'";
	$sql = "INSERT INTO {$table_name}({$fields}) VALUES({$values})";
	$db_conn->query($sql);
	if($db_conn->affected_rows){
		return $db_conn->insert_id;
	}else{
		return false;
	}
}

/**
 * mysql查找
 */
function mysql_fetch_db($conn, $table_name, $arr_field_names, $str_where, $return_type = 0, $page = 0, $pagesize = 100){
	$field_names = implode(",", $arr_field_names);

	$page = $page * $pagesize;
	$limit_size = $page + $pagesize;
	
	$sql = "SELECT {$field_names} FROM {$table_name} WHERE {$str_where} limit {$page}, {$limit_size}";
	$result = $conn->query($sql);
	if(!$result){
		return false;
	}
	
	$arr_result = array();
	
	while($row = mysql_fetch_type($result, $return_type)){
		$arr_result[] = $row;
	}
	
	return $arr_result;
}
function mysql_fetch_type($mysqli_result, $type){
	if($type == 0){
		return $mysqli_result->fetch_object();
	}else{
		return $mysqli_result->fetch_assoc();
	}
}

/**
 * mysql更新
 */
function mysql_update_db($conn, $table_name, $arr_field_names, $arr_field_values, $str_sql_where){
	$field_length = count($arr_field_names);
	$sql_updatas = "";
	for($i = 0; $i < $field_length; $i++){
		$sql_update_value = addslashes($arr_field_values[$i]);
		$sql_updatas .= $arr_field_names[$i] . "='{$sql_update_value}'";
		if($i != ($field_length - 1)){
			$sql_updatas .= ", ";
		}
	}	
	
	$sql = "UPDATE {$table_name} SET {$sql_updatas} WHERE {$str_sql_where}";
	$result = $conn->query($sql);
	if($conn->affected_rows > 0){
		return true;
	}else{
		return false;
	}
}

/**
 * mysql删除
 */
function mysql_delete_db($conn, $table_name, $sql_where){
	$sql = "DELETE FROM {$table_name} WHERE {$sql_where}";
	$result = $conn->query($sql);
	if($conn->affected_rows > 0){
		return true;
	}else{
		return false;
	}
}

// ITMaterials-------------------------------------------------------------------------------------------------

// Name:get_root_dir
// Version:1.0
function get_root_dir(){
	$pa = "";
	$aar = explode("/" , $_SERVER['SCRIPT_NAME']);
	$aar_length = count($aar) - 2;
	if($aar_length == 0){ // 在apcha的www目录下
		$pa = preg_replace('/\/$/', "", $_SERVER['DOCUMENT_ROOT']);
	}else { // 在apcha的Alias目录下
	    $pa = $_SERVER['SCRIPT_FILENAME'];
		for($i = 0; $i < $aar_length; $i++){
			$pa = dirname($pa);
		}
	}
	return $pa;
}
// Name:get_root_dir

// Name:rand_string
// Version:1.0
function rand_string($length, $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz"){
   $str = "";
   $max = strlen($strPol) - 1;

   for($i=0; $i<$length; $i++){
    $str .= $strPol[rand(0, $max)];
   }

   return $str;
}
// Name:rand_string

// Name:start_with 
// Version:1.0
function start_with($string, $test){
	return strpos($string, $test) === 0;
}
// Name:start_with 


 
// Name:delete_dir
// Version:1.0

/**
 * 删除给定目录
 * 注意：此函数删除目录下的所有文件，包括目录本身。
 */
function delete_dir($dir) {
	//先删除目录下的文件：
	$dh = opendir($dir);
	while($file = readdir($dh)) {
		if($file != "." && $file != "..") {
			$fullpath = $dir . "/" . $file;
			if(!is_dir($fullpath)) {
			  unlink($fullpath);
			} else {
			  delete_dir($fullpath);
			}
		}
	}

	closedir($dh);
	
	//删除当前文件夹：
	if(rmdir($dir)) {
		return true;
	} else {
		return false;
	}
}
// Name:delete_dir

// Name:resize_image
// Version:1.0
/*
使用方法：

//参数是图片的存方路径
$im = imagecreatefromjpeg("./20140416103023202.jpg");
//设置图片的最大宽度
$maxwidth="600";
//设置图片的最大高度
$maxheight="400";
//图片保存的名称
$name="123";
//图片保存的类型
$filetype=".jpg";
// 压缩图片
resize_image($im, $maxwidth, $maxheight, $name, $filetype);
*/
function resize_image($im, $maxwidth, $maxheight, $name) {
    $pic_width = imagesx($im);
    $pic_height = imagesy($im);
    if (($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight)) {
        if ($maxwidth && $pic_width > $maxwidth) {
            $widthratio = $maxwidth / $pic_width;
            $resizewidth_tag = true;
        }
        if ($maxheight && $pic_height > $maxheight) {
            $heightratio = $maxheight / $pic_height;
            $resizeheight_tag = true;
        }
        if ($resizewidth_tag && $resizeheight_tag) {
            if ($widthratio < $heightratio) $ratio = $widthratio;
            else $ratio = $heightratio;
        }
        if ($resizewidth_tag && !$resizeheight_tag) $ratio = $widthratio;
        if ($resizeheight_tag && !$resizewidth_tag) $ratio = $heightratio;
        $newwidth = $pic_width * $ratio;
        $newheight = $pic_height * $ratio;
        if (function_exists("imagecopyresampled")) {
            $newim = imagecreatetruecolor($newwidth, $newheight); //PHP系统函数
            imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height); //PHP系统函数
        } else {
            $newim = imagecreate($newwidth, $newheight);
            imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
        }
        imagejpeg($newim, $name);
        imagedestroy($newim);
    } else {
        imagejpeg($im, $name);
    }
}
// Name:resize_image
// GLOBAL_FUNCTION_DEFINE
?>