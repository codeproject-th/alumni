<?php

class login_module{
	
	// Start Class
	public function __construct(){
		//ส่วนผู้ดูแลระบบ
	}
	
	// End Class
	public function  __destruct(){
		
	}
	// ------ //
	
	public function index(){
		if($_POST){
			$arr['admin_user'] = input::post('username');
			$arr['admin_pass'] = input::post('password');
			$row = module::model('models:admin')->select($arr);
			if(count($row)>0){
				$_SESSION['admin_id'] = $row[0]['admin_id'];
				module::redirect(module_url('/administrator/order/index'));
				exit;
			}else{
				$theme_var['login'] = 'NO';
			}
		}
		echo module::theme_admin('login',$theme_var);
	}
	
}

?>