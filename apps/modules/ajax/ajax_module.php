<?php

class ajax_module{
	
	// Start Class
	public function __construct(){
		//ส่วนผู้ดูแลระบบ
	}
	
	// End Class
	public function  __destruct(){
		
	}
	// ------ //
	
	public function getAmphur(){
		$province = $_POST["province_id"];
		$amphur = module::model('models:amphur')->select(array('PROVINCE_ID'=>$province),'*','ORDER BY CONVERT( AMPHUR_NAME USING tis620 ) ASC');
		echo json_encode($amphur);
	}
	
	public function getDistrict(){
		$amphur_id = $_POST["amphur_id"];
		$district = module::model('models:district')->select(array('AMPHUR_ID'=>$amphur_id),'*','ORDER BY CONVERT( DISTRICT_NAME USING tis620 ) ASC');
		echo json_encode($district);
	}
	
	public function getOrder(){
		$id = $_POST['id'];
		$sql = "SELECT alumni.* , order_data.* FROM alumni 
		LEFT JOIN order_data ON order_data.alumni_id = alumni.alumni_id
		WHERE alumni.IDCard='".$id."'";
		$row = db::fetch($sql);
		echo module::view('home:ajax_get_order',array('data'=>$row));
	}
	
	public function confirm_payment(){
		$insert['bank'] = $_POST['bank'];
		$insert['branch'] = $_POST['branch'];
		$insert['acc'] = $_POST['acc'];
		$insert['kind'] = $_POST['kind'];
		$insert['date'] = $_POST['date'];
		$insert['time'] = $_POST['time'];
		$insert['amount'] = $_POST['amount'];
		$insert['create_date'] = date('Y-m-d H:i:s');
		$insert['order_data_id'] = $_POST['order_data_id'];
		$insert['alumni_id'] = $_POST['alumni_id'];
		module::model('models:confirm_payment')->insert($insert);
	}
}

?>