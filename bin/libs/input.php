<?php
class input {
	
	public static function post($input,$xss=true){
		$input_data = $_POST[$input];
		if($xss==true){
			$input_data = input::xss_clean($input_data);
		}
		return $input_data;
		
	}
	
	public static function get($input,$xss=true){
		$input_data = $_GET[$input];
		if($xss==true){
			$input_data = input::xss_clean($input_data);
		}	
		return $input_data;
	}
	
	public static function xss_clean($string){
		if($string!=''){
			return @htmlspecialchars($string);
		}else{
			return $string;
		}
	}
	
	public static function is_date($string) {
		$pattern1 = '([0-9]{1,2}-[0-1]{0,1}[1-9]{1}-[0-9]{2,4})'; // dd-mm-yy(yy)
		$pattern2 = '([0-9]{1,2}\/[0-1]{0,1}[1-9]{1}\/[0-9]{2,4})'; // dd/mm/yy(yy)
		$pattern3 = '([0-1]{0,1}[1-9]{1}-[0-9]{1,2}-[0-9]{2,4})'; // mm-dd-yy(yy)
		$pattern4 = '([0-1]{0,1}[1-9]{1}\/[0-9]{1,2}\/[0-9]{2,4})'; // mm/dd/yy(yy)
		if(preg_match("/^($pattern1)$|^($pattern2)$|^($pattern3)$|^($pattern4)$/",$string)) {
			return(true);
		} else {
			return(false);
		}
		return(false);
	}
	
	public static function is_num($string) {
		$american = '(-){0,1}([0-9]+)(,[0-9][0-9][0-9])*([.][0-9]){0,1}([0-9]*)';
		$world = '(-){0,1}([0-9]+)(.[0-9][0-9][0-9])*([,][0-9]){0,1}([0-9]*)';
		if(preg_match("/^($american)$|^($world)$/",$string)) {
			return(true);
		} else {
			return(false);
		}
		return(false);
	}	
	
	public static function is_email($string) {
		if(preg_match('/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])([-a-z0-9_])+([a-z0-9])*(\.([a-z0-9])([a-z0-9])+)*$/i',$string)) {
			return(true);
		} else {
			return(false);
		}
		return(false);
	}
	
	public static function get_input_method($method="post"){
		$data = new stdClass();
		if($method=="post"){
			if(count($_POST)>0){
				foreach($_POST as $key => $val){
					$data->$key = $val;
				}
			}
		}else if($method=="get"){
			if(count($_GET)>0){
				foreach($_GET as $key => $val){
					$data->$key = $val;
				}
			}
		}
		
		return $data;
	}
		
}
