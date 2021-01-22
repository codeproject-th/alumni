<?php

class home_module{
	
	// Start Class
	public function __construct(){
		//ส่วนผู้ดูแลระบบ
	}
	
	// End Class
	public function  __destruct(){
		
	}
	// ------ //
	
	public function index(){
		$theme_var['content'] = module::view('home:menu',array());
		echo module::theme('theme',$theme_var);
	}
	
	public function register(){
		$theme_var['content'] = module::view('home:register',array('table'=>$table));
		echo module::theme('theme',$theme_var);
	}
	
	public function register_save(){
		
		$chk = $this->chkIDcard($_POST["IDCard"],"add");
		if($chk==true){
			
		}else{
			$error[] = "หมายเลขบัตรประชาชนมีอยู่ในระบบแล้ว";
		}
		
		$insert["FirstName"] = $_POST["FirstName"];
		$insert["SurName"] = $_POST["SurName"];
		$insert["OldFirstName"] = $_POST["OldFirstName"];
		$insert["OldSurName"] = $_POST["OldSurName"];
		$insert["StdNumber"] = $_POST["StdNumber"];
		$insert["IDCard"] = $_POST["IDCard"];
		$insert["EduID"] = $_POST["EduID"];
		$insert["GenID"] = $_POST["GenID"];
		$insert["Tel"] = $_POST["Tel"];
		$insert["Mobile"] = $_POST["Mobile"];
		$insert["Email"] = $_POST["Email"];
		$insert["LineID"] = $_POST["LineID"];
		$insert["Facebook"] = $_POST["Facebook"];
		$insert["create_date"] = date('Y-m-d H:i:s');
		$insert["YearEnd"] = $_POST["YearEnd"];
		$insert["YearStart"] = $_POST["YearStart"];
		
		$insert_address["RoomNo"] = $_POST["RoomNo"];
		$insert_address["ApartmentNo"] = $_POST["ApartmentNo"];
		$insert_address["Building"] = $_POST["Building"];
		$insert_address["Class"] = $_POST["Class"];
		$insert_address["HouseNumber"] = $_POST["HouseNumber"];
		$insert_address["Village"] = $_POST["Village"];
		$insert_address["Swine"] = $_POST["Swine"];
		$insert_address["Alley"] = $_POST["Alley"];
		$insert_address["Road"] = $_POST["Road"];
		$insert_address["District"] = $_POST["District"];
		$insert_address["County"] = $_POST["County"];
		$insert_address["Province"] = $_POST["Province"];
		$insert_address["Zip"] = $_POST["Zip"];
		$insert_address["Overseas"] = $_POST["Overseas"];
		
		if($chk==true){
			$query = module::model('models:alumni')->insert($insert);
			if($query){
				$insert_address["alumni_id"] = db::insert_id();
				module::model('models:alumni_address')->insert($insert_address);
			}
		}
		
		$theme_var['content'] = module::view('home:register_save',array('error'=>$error,'query'=>$query));
		echo module::theme('theme',$theme_var);
	}
	
	public function book(){
		$theme_var['content'] = module::view('home:book',array());
		echo module::theme('theme',$theme_var);
	}
	
	
	public function book_save(){
		//print_r($_POST['select']);
		$theme_var['content'] = module::view('home:book_save',array());
		echo module::theme('theme',$theme_var);
	}
	
	public function order_save(){
		$id_card = $_POST['id_card'];
		$party = module::model('models:party')->select(array('party_id'=>$_POST['party_id']));
		$alumni = module::model('models:alumni')->select(array("IDCard"=>$id_card));
		$total = 0;
		$select = $_POST['select_table'];
		if(count($alumni)>0){
			foreach($select as $val){
				if($i==0){
					$in .= "'".$val."'";
				}else{
					$in .= ",'".$val."'";
				}
					$i++;
			}
			$sql = "SELECT * FROM party_table WHERE party_table_id IN(".$in.")";
			$table = db::fetch($sql);
			
			if(count($table)>0){
				foreach($table as $val){
					$total = $total+$party[0]['PartyPriceTable'];
				}
			}
			
			$insert['order_price'] = $total;
			$insert['alumni_id'] = $alumni[0]['alumni_id'];
			$insert['order_status'] = '0';
			$insert['payment_status'] = $_POST['payment'];
			$insert['order_type'] = '1';
			$insert['create_date'] = date('Y-m-d H:i:s');
			$insert['party_id'] = $party[0]['party_id'];
			$query = module::model('models:order_data')->insert($insert);
			if($query){
				$id = module::model('models:order_data')->insert_id();
				if(count($table)>0){
					foreach($table as $val){
						module::model('models:order_detail')->insert(
							array(
								'order_data_id' => $id,
								'party_table_id' => $val['party_table_id'],
								'price' => $party[0]['PartyPriceTable']
							));
					}
				}
				//////////////////////////////////
				if($insert['payment_status']=='1'){
					header('Location: index.php?module=/home/home/paysbuy&send_mail=1&order_id='.$id);
					exit;
				}else{
					header('Location: index.php?module=/home/home/book_end&send_mail=1&order_id='.$id);
					exit;
				}
				///////////////////////////////////
			}
			
		}else{
			$error[] = 'หมายเลขบัตรประชาชนยังไม่ได้ลงทะเบียนศิษย์เก่า &nbsp;&nbsp; >> <a href="index.php">ลงทะเบียนศิษย์เก่า</a> <<';
			$theme_var['content'] = module::view('home:order_error',array('error'=>$error));
			echo module::theme('theme',$theme_var);
		}
	}
	
	public function book_seat_save(){
		$id_card = $_POST['id_card'];
		$seat = $_POST['seat'];
		$party = module::model('models:party')->select(array('party_id'=>$_POST['party_id']));
		$alumni = module::model('models:alumni')->select(array("IDCard"=>$id_card));
		$total = 0;
		if(count($alumni)>0 and $seat>0){
			for($i=1;$i<=$seat;$i++){
				$total = $total+$party[0]['PartySeatPrices'];
			}
			$insert['order_price'] = $total;
			$insert['alumni_id'] = $alumni[0]['alumni_id'];
			$insert['order_status'] = '0';
			$insert['payment_status'] = $_POST['payment'];
			$insert['order_type'] = '2';
			$insert['create_date'] = date('Y-m-d H:i:s');
			$insert['party_id'] = $party[0]['party_id'];
			$query = module::model('models:order_data')->insert($insert);
			if($query){
				$id = module::model('models:order_data')->insert_id();
				for($i=1;$i<=$seat;$i++){
					module::model('models:order_detail')->insert(
							array(
								'order_data_id' => $id,
								'party_table_id' => '0',
								'price' => $party[0]['PartySeatPrices']
							));
					///////
				}
				//////////////////////////////////
				if($insert['payment_status']=='1'){
					header('Location: index.php?module=/home/home/paysbuy&send_mail=1&order_id='.$id);
					exit;
				}else{
					header('Location: index.php?module=/home/home/book_end&send_mail=1&order_id='.$id);
					exit;
				}
				///////////////////////////////////
			}
		}else{
			$error[] = 'หมายเลขบัตรประชาชนยังไม่ได้ลงทะเบียนศิษย์เก่า &nbsp;&nbsp; >> <a href="index.php">ลงทะเบียนศิษย์เก่า</a> <<';
			$theme_var['content'] = module::view('home:order_error',array('error'=>$error));
			echo module::theme('theme',$theme_var);
		}
	}
	
	public function paysbuy(){
		include('./paysbuy.config.php');
		include('./apps/extension/nusoap/nusoap.php');
		$order_id = $_GET['order_id'];
		$sql = "SELECT order_data.* , alumni.* , order_detail.party_table_id , party.PartyName FROM order_data 
				LEFT JOIN alumni ON alumni.alumni_id=order_data.alumni_id 
				LEFT JOIN order_detail ON order_detail.order_data_id=order_data.order_data_id 
				LEFT JOIN party_table ON party_table.party_table_id=order_detail.party_table_id
				LEFT JOIN party ON party.party_id=party_table.party_id
				WHERE order_data.order_data_id = '".$order_id."'
				";
		$data = db::fetch($sql);
		
		$url = $Paysbuy['url']."/api_paynow/api_paynow.asmx?WSDL";
		$client = new nusoap_client($url, true);
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = true;
		$psbID = $Paysbuy['psbID'];
		$username = $Paysbuy['username'];
		$secureCode = $Paysbuy['secureCode'];
		$inv = str_pad($data[0]['order_data_id'],7,'0',STR_PAD_LEFT);
		$itm = "ร่วมงาน ".$data[0]['PartyName'];
		$amt = $data[0]['order_price']; // จานวนเงินรวมที่ต้องการชาระ
		$paypal_amt = "";
		$curr_type = "TH";
		$com = "";
		$method = "1";
		$language = "T";

		//Change to your URL
		$resp_front_url = $Paysbuy['resp_front_url']; // URL ที่ทาง PAYSBUY จะทาการเปลี่ยนหน้ากลับไปพร้อมทั้งส่งผลการชาระเงินให้
		$resp_back_url = WEB_URL_PATH.'/index.php?module=/home/home/book_end&send_mail=1&order_id='.$order_id; // URL ที่ทาง PAYSBUY จะทาการส่งผลการชาระเงินให้ทันทีที่รู้ผลการชาระเงิน โดยไม่มีการเปลี่ยนหน้าส่งข้อมูลแบบ background process

		//Optional data
		$opt_fix_redirect = "";
		$opt_fix_method = "";
		$opt_name = $data[0]['FirstName'].' '.$data[0]['SurName'];
		$opt_email = $data[0]['Email'];
		$opt_mobile = $data[0]['Mobile'];
		$opt_address = "";
		$opt_detail = "";
		$opt_param = "";
		$result = "";

		//1. Step 1 call method api_paynow_authentication
		$params = array(
					"psbID" => $psbID, 
					"username" => $username, 
					"secureCode" => $secureCode,
					"inv" => $inv,
					"itm" => $itm,
					"amt" => $amt,
					"paypal_amt" => $paypal_amt,
					"curr_type" => $curr_type,
					"com" => $com,
					"method" => $method,
					"language" => $language,
					"resp_front_url" => $resp_front_url,
					"resp_back_url" => $resp_back_url,
					"opt_fix_redirect" => $opt_fix_redirect,
					"opt_fix_method" => $opt_fix_method,
					"opt_name" => $opt_name,
					"opt_email" => $opt_email,
					"opt_mobile" => $opt_mobile,
					"opt_address" => $opt_address,
					"opt_detail" => $opt_detail,
					"opt_param" => $opt_param
				);
				
		$result = $client->call(
					'api_paynow_authentication_v3', 
						array(
							'parameters' => $params
						), 
					'http://tempuri.org/', 
					'http://tempuri.org/api_paynow_authentication_v3', 
					false, 
					true
				);
		
		if($client->getError()){
			echo "<h2>Constructor error</h2><pre>" . $client->getError() . "</pre>";
		} else {
			$result = $result["api_paynow_authentication_v3Result"];
			echo $result;
		}
		
		$approveCode = substr($result,0,2);
		//echo "<br>approveCode->".$approveCode;
		$intLen = strlen($result);
		$strRef = substr($result,2, $intLen-2);
		if($approveCode=="00") {
			echo "<meta http-equiv='refresh' content='0;url=".$Paysbuy['url']."/paynow.aspx?refid=".$strRef."'>";
		}else {
			//echo "<br>Can't login to paysbuy server";
		}	
		//$theme_var['content'] = module::view('home:paysbuy',array());
		//echo module::theme('theme',$theme_var);
	}
	
	public function inform_payments(){
		$theme_var['content'] = module::view('home:inform_payments',array('error'=>$error));
		echo module::theme('theme',$theme_var);
	}
	
	
	public function book_end(){
		$order_id = $_GET['order_id'];
		$theme_var['content'] = module::view('home:book_end',array('order_id'=>$order_id));
		echo module::theme('theme',$theme_var);
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
		$theme_var['content'] = module::view('home:confirm_payment',array());
		echo module::theme('theme',$theme_var);
	}
	
	private function paysbuy_chk($inv=''){
		include_once('./paysbuy.config.php');
		include_once('./apps/extension/nusoap/nusoap.php');
		$url = $Paysbuy['url']."/psb_ws/gettransaction.asmx?WSDL";
		$client = new nusoap_client($url,true);
		$PSBID = $Paysbuy['psbID'];
		$biz = $Paysbuy['username'];
		$secureCode = $Paysbuy['secureCode'];
		$inv = $inv;
		$params= array("psbID"=>$PSBID, "biz"=>$biz,"secureCode"=>$secureCode,"invoice"=>$inv);
		$result = $client->call('getTransactionDetailByInvoice', array('parameters' => $params), 'http://tempuri.org/', 'http://tempuri.org/getTransactionDetailByInvoice', false, true);
		$err = $client->getError();
		$_result = substr($result["getTransactionDetailByInvoiceResult"]["getTransactionDetailByInvoiceReturn"]["result"],0,2);
		if($_result=='00'){
			return true;
		}else{
			return false;
		}
	}
	
	private function chkIDcard($id_card="",$type="",$id=""){
		$chk = true;
		if($type=="add"){
			$row = module::model('models:alumni')->select(array("IDCard"=>$id_card));
			if(count($row)>0){
				$chk = false;
			}
		}else if($type=="edit"){
			$row = module::model('models:alumni')->select(array("IDCard"=>$id_card));
			if(count($row)>0 AND $row[0]['alumni_id']!=$id){
				$chk = false;
			}
		}
		
		return $chk;
	}
		
}

?>