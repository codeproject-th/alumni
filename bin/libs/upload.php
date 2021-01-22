<?php

class upload{
	public $path;
	public $file_type;
	public $file_size;
	public $file_name;
	
	public function __construct(){
	 	$this->path = "";
		$this->file_type = array("png","jpg","jpeg","gif","zip","rar","pdf","doc","xls","ppt","docx","xlsx","pptx");
		$this->file_size = 100*(1024*5);
		$this->file_name = date("YmdHis")."_".rand(1,9999);
	}
	
	public function add_file_type($file_type = array()){
		if(is_array($file_type) and count($file_type)>0){
			foreach($file_type as $val){
				$this->file_type[] = $val;
			}
		}
	}
	
	public function upload_file($file,$file_name = ""){
		if($file_name!=""){
			$this->file_name = $file_name;
		}
		$return = array();
		$file_type_chk = false;
		$size = $file["size"];
		$type = strtolower(end(explode('.',$file["name"])));
		if($size<=$this->file_size){
			foreach($this->file_type as $val){
				if($type==$val){
					$file_type_chk = true;
				}
			}
			
			if($file_type_chk==true){
				$file_n = $this->file_name.".".$type;
				$copy = move_uploaded_file($file["tmp_name"],$this->path.$file_n);
				if($copy){
					$return["name"] = $file_n;
					$return["path"] = $this->path;
				}
				
			}else{
				$return["error"][] = "ชนิดไฟล์ไม่ถูกต้อง";
			}
			
		}else{
			$return["error"][] = "ขนาดไฟล์เกิน";
		}
		
		return $return;
	}
	
}

class UploadImg {
	
	public $path;
	public $img;
	
	public function __construct($path="",$img){
	 	$this->path = $path;
		$this->file_name = $img;
	}
	
	public function save($file_name="",$file_tmp=""){
		$file_type_arr = explode(".",$file_tmp["name"]);
		$file_type = end($file_type_arr);
		$size = getimagesize($file_tmp["tmp_name"]);
		if($size[0]>0 and $size[0]>1){
			$fullName = $this->path.$file_name.".".$file_type;
			move_uploaded_file($file_tmp["tmp_name"],$fullName);
			return array("name"=>$file_name.".".$file_type,"path"=>$this->path);
		}
	}
}

?>