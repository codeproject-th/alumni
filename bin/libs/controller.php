<?php

class controller{
	
	public static $Controller_Affix = '_controller';
	public static $Model_Affix = '_model';
	
	////////// Controller Run
	
	public static function request(){
		$request = $_SERVER['PATH_INFO'];
		$request_ex = explode('/',$request);
		if(count($request_ex)==1){
			$return[0] = 'default';
			$return[1] = 'index';
		}else{
			$return[0] = $request_ex[1];
			$return[1] = $request_ex[2];
			if($return[1]==''){
				$return[1] = 'index';
			}
		}
		
		return $return;
	}
	
	public static function create($classname='',$methodname='index') {
		$class_file = './apps/'.controller::$Controller_Path.'/'.$classname.controller::$Controller_Affix.'.php';
		$classname = $classname.controller::$Controller_Affix;
		
		if(file_exists($class_file)){
			include_once($class_file);
			if(class_exists($classname)){
				controller::execute($classname,$methodname);
			}
		}
	}
	
	public static function execute($classname='',$methodname=''){
		if(method_exists($classname,$methodname)){
			$obj = new $classname;
			$obj->$methodname();
		}
	}
	
	////////// End
	
	public static function model($modelname=''){
		$model_file = './apps/model/'.$modelname.controller::$Model_Affix.'.php';
		$modelname = $modelname.controller::$Model_Affix;
		if(file_exists($model_file)){
			include_once($model_file);
			if(class_exists($modelname)){
				return new $modelname;
			}
		}
	}
	
	public static function view($script="",$vars=""){
		ob_start();
		if(is_array($vars)){
			extract($vars);
		}
		$script = "./apps/view/".$script.".php";
        $scriptStr = file_get_contents ( $script );    
        include $script;
        $html = ob_get_clean();
        return $html;  
	}
	
	public static function theme($script="",$vars=""){
		ob_start();
		if(is_array($vars)){
			extract($vars);
		}
		$script = "./apps/theme/".WEB_THEME."/".$script.".php";
        $scriptStr = file_get_contents ( $script );    
        include $script;
        $html = ob_get_clean();
        return $html;  
	}
	
	public static function url($url=''){
		return WEB_URL.'/'.$url;
	}
	
	public static function redirect($url=''){
		header( "location: ".$url);
 		exit(0);
	}
	
	public static function title($label=array(),$url=array()){
		$return_url = '';
		if(count($label)>0){
			foreach($label as $key => $val){
				if($key==0){
					if($url[$key]!=''){
						$return_url .= '<a href="'.$url[$key].'">'.$val.'</a>';
					}else{
						$return_url .= $val;
					}
				}else{
					
					if($url[$key]!=''){
						$return_url .= ' / <a href="'.$url[$key].'">'.$val.'</a>';
					}else{
						$return_url .= ' / '.$val.'';
					}
				}
			}
		}
		
		return $return_url;
	}
}

?>