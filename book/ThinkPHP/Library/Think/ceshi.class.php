<?php
namespace Think;
class UpFileTool{
	
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
		
	}
	
}