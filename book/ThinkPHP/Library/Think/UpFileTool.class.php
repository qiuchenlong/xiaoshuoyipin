<?php
namespace Think;
class UpFileTool{
	protected $exts=array('jpg','png','jpeg','mp3');
	protected $file=NULL;
	protected $tmp_name=NULL;
	protected $name=NULL;
	protected $fileError=NULL;
	protected $size=1 ;//1M
	protected $errno=0;//错误号
	public $sumbImage=NULL;
	public $srcImage=NULL;
	public $multiSumbImage=NULL;
	public $multiSrcImage=NULL; 
	protected $error=array( 
							0=> '文件上传成功',
							1=> '文件大小超过了系统设定的大小',
							2=> '文件大小超过了网页表单选项指定的值',
							3=> '文件只有部分被上传',
							4=> '没有文件被上传',
							6=> '找不到临时文件夹',
							7=> '文件写入失败',
							8=> '文件后缀不被支持',
							9=> '上传文件过大',
							10=>'上传失败',
							11=>'目录创建失败',
							12=>'找不到该文件(添加水印)',
							13=>'找不到该文件(缩小图片)'
							);
	/*
		parm string $name
		return array $file
	*/
	public function __construct($name){ 
		$this->tmp_name=$_FILES[$name][tmp_name];
		$this->name=$_FILES[$name][name];
		$this->fileError=$_FILES[$name][error];
		return $this->file=$_FILES[$name];
		

	}
	public function upFile($srcimage='srcimage'){
		if ($this->fileError>0) {
			$this->errno=$this->fileError;
			return false;
		}
		$dir=$this->mk_dir($srcimage);
		// $name=explode('.', $this->name);
		// $name=$name[0];
		$name=$this->randName(8);
		$ext=$this->getExt($this->name);
		if (!$this->checkExt($ext)) {
			$this->errno=8;
			return false;
		}
		// if (!$this->checkSize()) {
		// 	$this->errno=9;
		// 	return false;
		// }
		$fileload=$dir.'/'.$name.'.'.strtolower($ext);
		$this->srcImage=$fileload;
		$result=move_uploaded_file($this->tmp_name, $fileload)? $fileload:false;
		return $result;
	}
	/*
		return string $dir
	*/
	public function mk_dir($savefile){
		$dir=$savefile.'/'.date('Ymd',time());
		if (is_dir($dir)||mkdir($dir,0777,true)) {
			return $dir;
		}
		$this->errno=11;
		return false;
	}
	/*
		parm int $length
		return string
	*/
	public function randName($length=6){
		$str='abcdefghijklmnopqrstuvwxyz1234567890';
		return date('His').substr(str_shuffle($str),0,$length);
	}
	/*
		parm string $filename
		return string $ext
	*/
	public function getExt($name){
		$ext=end(explode('.', $name));
		return $ext;
	}
	/*
		parm string $ext
		return bool
	*/
	public function checkExt($ext){
//		return in_array(strtolower($ext), $this->exts);
		return true;
	}
	/*
		parm string $size
		return bool
	*/
	public function checkSize(){
		$fileSize=$this->size*1024*1024;
		if ($this->file['size']>$fileSize) {
			return false;
		}
		return true;
	}
	protected function imageInfo($image){
		if (!is_file($image)) {
			$this->errno=12;
			return false;
		}
		$info=getimagesize($image);
		$im['width']=$info[0];
		$im['height']=$info[1];
		$mime=explode('/', $info['mime']);
		$im['ext']=end($mime);
		return $im;
	}	

	// // °´±ÈÀýËõ·Å
	// public function sumbImage1($src_im,$save,$pro=0.5){
	// 	//ÅÐ¶ÏÊÇ·ñ´æÔÚ¸ÃÎÄ¼þ
	// 	if (!is_file($src_im)) {
	// 		$this->errno=4;
	// 		return false;
	// 	}
	// 	//»ñÈ¡Í¼Æ¬ÐÅÏ¢
	// 	$src_info=$this->imageInfo($src_im);
	// 	$src_w=$src_info['width'];
	// 	$src_h=$src_info['height'];
	// 	$src_ext=$src_info['ext'];
	// 	//¼ÆËãËõ·Å±ÈÀý
	// 	//$pro_w=$w/$src_w;
	// 	//$pro_h=$h/$src_h;
	// 	//$pro=$pro_w<$pro_h?$pro_h:$pro_w;
	// 	//ËõÐ¡ºóÍ¼Æ¬µÄ¿í¡¢¸ß´óÐ¡
	// 	$dst_w=$src_w*$pro;
	// 	$dst_h=$src_h*$pro;
	// 	//½¨Á¢»­²¼
	// 	$createFuc='imagecreatefrom'.$src_ext;
	// 	$src_image=$createFuc($src_im);
	// 	$dst_image=imagecreatetruecolor($dst_w, $dst_h);
	// 	//»ñÈ¡ÑÕÉ«
	// 	$color=imagecolorallocate($dst_image, 255, 255, 255);
	// 	//Ìî³äÄ¿±ê»­²¼
	// 	imagefill($dst_image, 0, 0, $color);
	// 	//¼ÆËãËõ·ÅºóÍ¼Æ¬ÔÚÄ¿±ê»­²¼ÖÐµÄÆðÊ¼µã
	// 	$dst_x=($dst_w-$dst_w)/2;
	// 	$dst_y=($dst_h-$dst_h)/2;
	// 	//°´±ÈÀýËõ·ÅÍ¼Æ¬
	// 	imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	// 	//±£´æËõ·ÅÍ¼Æ¬
	// 	$mime=explode('.', $save);
	// 	$save_ext=end($mime);
	// 	if ($save_ext=='jpg') {
	// 		$save_ext='jpeg';
	// 	}
	// 	$saveFuc='image'.$save_ext;
	// 	$saveFuc($dst_image,$save);
	// 	imagedestroy($src_image);
	// 	imagedestroy($dst_image);
	// 	return true;
	// }

	public function sumbImage($pro=0.5, $sumbimage='sumbimage'){
		$src_im=$this->tmp_name;
		//判断是否存在该文件
		if (!is_file($src_im)) {
			$this->errno=13;
			return false;
		}
		//获取图片信息
		$src_info=$this->imageInfo($src_im);
		$src_w=$src_info['width'];
		$src_h=$src_info['height'];
		$src_ext=$src_info['ext'];
		//计算缩放比例
		// $pro_w=$w/$src_w;
		// $pro_h=$h/$src_h;
		// $pro=$pro_w<$pro_h?$pro_w:$pro_h;
		//缩小后图片的宽、高大小
		$dst_w=$src_w*$pro;
		$dst_h=$src_h*$pro;
		//建立画布
		$createFuc='imagecreatefrom'.$src_ext;
		$src_image=$createFuc($src_im);
		$dst_image=imagecreatetruecolor($dst_w, $dst_h);
		//获取颜色
		$color=imagecolorallocate($dst_image, 255, 255, 255);
		//填充目标画布
		imagefill($dst_image, 0, 0, $color);
		//计算缩放后图片在目标画布中的起始点
		// $dst_x=($w-$dst_w)/2;
		// $dst_y=($h-$dst_h)/2;
		//按比例缩放图片
		imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
		//保存缩放图片
		$dir=$this->mk_dir($sumbimage);
		// $name=explode('.', $this->name);
		$name=$this->randName(8);
		$ext=$this->getExt($this->name);
		if (!$this->checkExt($ext)) {
			$this->errno=8;   
			return false;
		}
		$save=$dir.'/'.$name.'.'.strtolower($ext);
		$this->sumbImage=$save;
		$mime=explode('.', $save);
		$save_ext=end($mime);
		if ($save_ext=='jpg') {
			$save_ext='jpeg';
		}
		$saveFuc='image'.$save_ext;
		$saveFuc($dst_image,$save);
		imagedestroy($src_image);
		imagedestroy($dst_image);
		return true;
	}
	// 单图上传(包括图片缩放)
	public function upImage($pro=0.5,$sumbimage='sumbimage', $srcimage='srcimage'){
		$this->sumbImage($pro, $sumbimage);
		$this->upFile($srcimage);
	}
	// 多图上传(包括图片缩放)
	public function multiImage($pro=0.5,$sumbimage='sumbimage', $srcimage='srcimage'){
		if (is_array($this->file[tmp_name])) {
			$tmp_name=$this->file[tmp_name];
			$name=$this->file[name];
			$fileError=$this->file[error];
			$len = count($tmp_name);
			for ($i=0; $i < $len; $i++) { 
				$this->tmp_name = $tmp_name[$i];
				$this->name = $name[$i];
				$this->fileError = $fileError[$i];
				$this->sumbImage($pro, $sumbimage);
				$this->upFile($srcimage);
				if (strstr($this->sumbImage,"../../")) {
					$this->sumbImage = substr($this->sumbImage,6);
				}
				if (strstr($this->srcImage,"../../")) {
					$this->srcImage = substr($this->srcImage,6);
				}
				if (strstr($this->sumbImage,"../")) {
					$this->sumbImage = substr($this->sumbImage,3);
				}
				if (strstr($this->srcImage,"../")) {
					$this->srcImage = substr($this->srcImage,3);
				}
				$this->multiSumbImage.= ','.$this->sumbImage;
				$this->multiSrcImage.= ','.$this->srcImage;
			}
			$this->multiSumbImage=substr($this->multiSumbImage,1);
			$this->multiSrcImage=substr($this->multiSrcImage,1);
		}
	}

	// 多图上传
	public function multiImages($srcimage='srcimage'){
		if (is_array($this->file[tmp_name])) {
			$tmp_name=$this->file[tmp_name];
			$name=$this->file[name];
			$fileError=$this->file[error];
			$len = count($tmp_name);
			for ($i=0; $i < $len; $i++) { 
				$this->tmp_name = $tmp_name[$i];
				$this->name = $name[$i];
				$this->fileError = $fileError[$i];
				$this->upFile($srcimage);
				if (strstr($this->srcImage,"../")) {
					$this->srcImage = substr($this->srcImage,3);
				}
				if($this->tmp_name == ''){
					$this->srcImage = '';
				}
				$this->multiSrcImage.= ','.$this->srcImage;
			}
			$this->multiSrcImage=substr($this->multiSrcImage,1);
		}
	}
	public function getError(){
		return $this->error[$this->errno];
	}
	
}