<?php

class to_party_module{
	
	// Start Class
	public function __construct(){
		//ส่วนผู้ดูแลระบบ
	}
	
	// End Class
	public function  __destruct(){
		
	}
	// ------ //
	
	public function index(){
		$theme_var['content'] = module::view('home:to_party',array());
		echo module::theme('theme',$theme_var);
	}
	
	public function chk(){
		$code = $_POST['code'];
		$sql = "SELECT order_data.* , alumni.* , party.* , order_detail.* FROM order_detail
				LEFT JOIN order_data ON order_detail.order_data_id = order_data.order_data_id 
				LEFT JOIN alumni ON alumni.alumni_id = order_data.alumni_id 
				LEFT JOIN party ON order_data.party_id = order_data.party_id
				WHERE order_code='".$code."' ".$order_by;
		
		$theme_var['content'] = module::view('home:to_party_chk',array('sql'=>$sql));
		echo $theme_var['content'];
	}
		
}

?>