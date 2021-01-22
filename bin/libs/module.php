<?php

class module{
	
	public static $Module_Affix = '_module';
	public static $Model_Affix = '_model';
	
	////////// Controller Run
	
	public static function request($module_input = ''){
		//$request = $_SERVER['PATH_INFO'];
		$request = $_REQUEST['module'];
		if($module_input!=''){
			$request = $module_input;
		}
		$request_ex = explode('/',$request);
		if(count($request_ex)=='1' or count($request_ex)=='0' or $request==''){
			$return[0] = 'home';
			$return[1] = 'home';
			$return[2] = 'index';
		}else{
			$return[0] = $request_ex[1];
			$return[1] = $request_ex[2];
			$return[2] = $request_ex[3];
			if($return[1]==''){
				$return[1] = 'index';
			}
			if($return[2]==''){
				$return[2] = 'index';
			}
		}
		
		return $return;
	}
	
	public static function create($path='',$classname='',$methodname='index') {
		$class_file = './apps/modules/'.$path.'/'.$classname.module::$Module_Affix.'.php';
		$classname = $classname.module::$Module_Affix;
		
		if(file_exists($class_file)){
			include_once($class_file);
			if(class_exists($classname)){
				module::execute($classname,$methodname);
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
		// home:home
		$modelname = str_replace('/','',$modelname);
		$model_ex = explode(':',$modelname);
		
		$model_file = './apps/modules/'.$model_ex[0].'/models/'.$model_ex[1].module::$Model_Affix.'.php';
		
		if($model_ex[0]=='models'){
			$model_file = './apps/models/'.$model_ex[1].module::$Model_Affix.'.php';
		}
		
		$modelname = $model_ex[1].module::$Model_Affix;
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
		
		$theme = WEB_THEME;
		$script_ex = explode(':',$script);
		if(count($script_ex)=='2'){
			$script_chk = "./apps/themes/".$theme."/modules/".$script_ex[0]."/".$script_ex[1].".php";
		}
		
		if(file_exists($script_chk)){
			$script_file = $script_chk;
		}else{
			$script_chk = "./apps/themes/default/modules/".$script_ex[0]."/".$script_ex[1].".php";
			if(file_exists($script_chk)){
				$script_file = $script_chk;
			}else{
				$script_file = "./apps/modules/".$script_ex[0]."/views/".$script_ex[1].".php";
			}
		}
		
		if($script_file==''){
			
		}
		
		
        $scriptStr = file_get_contents ($script_file);    
       	include $script_file;
        $html = ob_get_clean();
        return $html;  
	}
	
	public static function theme($script="",$vars=""){
		ob_start();
		if(is_array($vars)){
			extract($vars);
		}
		$script = "./apps/themes/".WEB_THEME."/".$script.".php";
        $scriptStr = file_get_contents ( $script );    
        include $script;
        $html = ob_get_clean();
        return $html;  
	}
	
	public static function theme_admin($script="",$vars=""){
		ob_start();
		if(is_array($vars)){
			extract($vars);
		}
		$script = "./apps/themes/admin/".$script.".php";
        $scriptStr = file_get_contents ( $script );    
        include $script;
        $html = ob_get_clean();
        return $html;  
	}
	
	public static function theme_menu($type=''){
		$type_arr = array('admin'=>'TypeAdmin');
		$dir = './apps/modules';
		$objOpen = opendir($dir);
		$m = '';
		while (($path = readdir($objOpen)) !== false){
			if($path!='.' and $path!='..'){
				$path_file = $dir.'/'.$path.'/menu.inc.php';
				if(file_exists($path_file)){
					include_once($path_file);
				/**/
					if(count($MemuArr)>0){
						$active = '';
						
						$module_ex = explode('/',$_GET['module']);
						if($module_ex[1]==$MemuArr['name']){
							$active = 'class="active"';
						}
						
						$m .= '
								';
						if(count($MemuArr['TypeAdmin'])>0){
							$m .= '<ul class="list-group">';
							$m .= '<a href="#" class="list-group-item active">'.$MemuArr['label'].'</a>';
							foreach($MemuArr[$type_arr[$type]] as $val){
								$m .= '
											<a class="list-group-item" href="'.$val['link'].'">'.$val['label'].'</a>
											';
							}
							$m .= '
										</ul>';
						}			 
						$m .= '
								';
					}
				/**/	
				}
			}
		}
		
		
		return $m;
	}
	
	public static function url($url=''){
		return WEB_URL.'?'.$url;
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
	
	public static function extension($file=''){
		$file = "./apps/extension/".$file.".php";
		include_once($file);
	}
	
	public static function language(){
		$language = module::language_get();
		//$file = "./apps/languages/".$language.".php";
		$dir = "./apps/languages/";
		if($dh = opendir($dir)){
        	while(($file = readdir($dh))!== false) {
            	$file_ex = explode("_",$file);
            	$file_type = end($file_ex);
            	if($file_type == $language.'.php'){
					include_once($dir.$file);
				}
        	}
        	closedir($dh);
    	}
		
	}
	
	public static function language_get(){
		$language = $_SESSION['language'];
		if($language==""){
			$language = 'en';
		}
		return $language;
	}
}

?>