<?php

class order_module{
	public $error;
	// Start Class
	public function __construct(){
		//ส่วนผู้ดูแลระบบ
		if($_SESSION['admin_id']==''){
			module::redirect(module_url('/administrator/login'));
			exit;
		}
		module::extension('AdminTable');
	}
	
	// End Class
	public function  __destruct(){
		
	}
	// ------ //
	
	public function index(){
		$table = $this->search();
		$theme_var['content'] = module::view('administrator:admin/order_list',array('table'=>$table));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function add(){
		$save = false;
		if($_POST){
			$save = $this->save();
		}
		$theme_var['content'] = module::view('administrator:admin/party_table_add',array('save'=>$save,'error'=>$error));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function edit(){
		$id = $_GET['item'];
		$save = false;
		if($_POST){
			//$save = $this->save_edit();
		}
		$theme_var['content'] = module::view('administrator:admin/party_table_edit',array('save'=>$save,'id'=>$id,'error'=>$this->error));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function delete(){
		//module::model('models:party_table')->delete($_GET['item']);
		//$this->reload();
	}
	
	private function search(){
		if($_GET['alumni']!=''){
			$alumni_ex = explode('-',$_GET['alumni']);
		}
		
		
		$searchWhere['party.party_id'] = $_GET['party_id'];
		$searchWhere['order_status'] = $_GET['status'];
		$searchWhere['order_data.alumni_id'] = $alumni_ex[0];
		
		$dataSearch = module::model('models:order_data')->search_data($search,$searchWhere,'ORDER BY order_data.create_date DESC');
		$i=0;
		$no = $dataSearch['no'];
		
		
		if(count($dataSearch['data'])>0){
			foreach($dataSearch['data'] as $key => $val){
				$no++;
				
				$PartyStatus = "เปิดจอง";
				
				if($val['PartyStatus']=='1'){
					$PartyStatus = "ปิดจอง";
				}
				
				$status = '';
				if($val['order_status']=='0'){
					$status = '<span style="color:#ff0000;">ยังไม่ยืนยัน<span>';
				}else if($val['order_status']=='1'){
					$status = '<span style="color:#43ee11;">ยืนยันแล้ว</span>';
				}
				
				if($val['order_type']=='1'){
					$type = 'โต๊ะ';
				}else if($val['order_type']=='2'){
					$type = 'ที่นั่ง';
				}
				
				$data[$i] = $val;
				$data[$i]['no'] = $no;
				$data[$i]['status'] = $status;
				$data[$i]['FullName'] = $val['FirstName'].' '.$val['SurName'];
				$data[$i]['PartyStatus'] = $PartyStatus;
				$data[$i]['PartyDate'] = date_th($val['PartyDate']);
				$data[$i]['Type'] = $type;
				$data[$i]['order_price'] = number_format($val['order_price']);
				$data[$i]['PartyImg'] = "<a href='./apps/data/images/".$data[$i]['PartyImg']."' target='_blank'>".$data[$i]['PartyImg']."</a>";
				$data[$i]['action'] = '
										<a href="javascript:void(0)" onclick="ViewDetail(\''.$val['order_data_id'].'\')"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
										<a href="index.php?module=/home/pdf/index&id='.$val['order_data_id'].'" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
									   <a href="javascript:void(0)" onclick="Approve(\''.$val['order_data_id'].'\')"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
									   <a href="javascript:void(0)" onclick="Canceled(\''.$val['order_data_id'].'\')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
										';
				$i++;
			}
		}
		
		$header['no'] = array('label'=>'No.','width'=>'50');
		$header['PartyName'] = array('label'=>'ชื่องาน');
		$header['order_price'] = array('label'=>'จำนวนเงิน','align'=>'center');
		$header['Type'] = array('label'=>'ประเภท','align'=>'center');
		$header['FullName'] = array('label'=>'ผู้จอง');
		$header['create_date'] = array('label'=>'เวลา');
		$header['status'] = array('label'=>'สถานะ','align'=>'center');
		$header['action'] = array('align'=>'center','width'=>'100');
		$TableData = AdminTable::Table($header,$data,$dataSearch['pages'],input::post('page'),$js);
		return $TableData;
	}
	
	public function get_detail(){
		echo module::view('administrator:admin/order_detail',array('id'=>$_POST['id']));
	}
	
	public function approve(){
		$id = $_POST['id'];
		$data = module::model('models:order_data')->get($id);
		module::model('models:order_data')->update(array('order_status'=>'1'),$id);
		
		if($data['order_type']=='1'){
			
			$party_table = module::model('models:order_detail')->select(array('order_data_id'=>$id));
			if(count($party_table)>0){
				/////
				foreach($party_table as $val){
					$chk = module::model('models:party_table')->get($val['party_table_id']);
					if($chk[0]['alumni_id']==''){
						module::model('models:party_table')->update(
									array(
										'status'=>'1',
										'alumni_id'=>$data['alumni_id']
									),$val['party_table_id']);
						/////////////////////
						module::model('models:order_detail')->update(array('order_code'=>$this->GenCode($data['party_id'],$val['order_detail_id'])),$val['order_detail_id']);
					}
				}
				/////
			}
		}else if($data['order_type']=='2'){
			$party_table = module::model('models:order_detail')->select(array('order_data_id'=>$id));
			if(count($party_table)>0){
				/////
				foreach($party_table as $val){
					$chk = module::model('models:party_table')->get($val['party_table_id']);
					/////////////////////
					module::model('models:order_detail')->update(array('order_code'=>$this->GenCode($data['party_id'],$val['order_detail_id'])),$val['order_detail_id']);
					
				}
				/////
			}
		}
	}
	
	public function canceled(){
		$id = $_POST['id'];
		$data = module::model('models:order_data')->get($id);
		module::model('models:order_data')->update(array('order_status'=>'0'),$id);
		
		if($data['order_type']=='1'){
			
			$party_table = module::model('models:order_detail')->select(array('order_data_id'=>$id));
			if(count($party_table)>0){
				/////
				foreach($party_table as $val){
					
						module::model('models:party_table')->update(
									array(
										'status'=>'0',
										'alumni_id'=>''
									),$val['party_table_id']);
					
				}
				/////
			}
		}
	}
	
	private function save(){
		$party_id = $_POST['party_id'];
		$PartyTableNumber = $_POST['PartyTableNumber'];
		$txt = $_POST['txt'];
		$no_start = $_POST['no_start'];
		$no_end = $_POST['no_end'];
		$PartyTableDetail = $_POST['PartyTableDetail'];
		if($no_end>=$no_start){
			for($i=$no_start;$i<=$no_end;$i++){
				$insert = array();
				$insert['party_id'] = $party_id;
				$insert['PartyTableCode'] = $txt.str_pad($i,4,'0',STR_PAD_LEFT);
				$insert['PartyTableNumber'] = $PartyTableNumber;
				$insert['PartyTableDetail'] = $PartyTableDetail;
				$chk = module::model('models:party_table')->select(array('PartyTableCode'=>$insert['PartyTableCode']));
				if(count($chk)=='0'){
					$query = module::model('models:party_table')->insert($insert);
				}
			}
		}
		
		return $query;
	}
	
	private function save_edit(){
		$this->error = '';
		if($_POST['alumni']!=''){
			$alumni_ex = explode('-',$_POST['alumni']);
		}
		
		$party_id = $_POST['party_id'];
		$PartyTableNumber = $_POST['PartyTableNumber'];
		$PartyTableCode = $_POST['PartyTableCode'];
		$PartyTableDetail = $_POST['PartyTableDetail'];
		$status = $_POST['status'];
		$alumni_id = $alumni_ex[0];
		
		$insert['party_id'] = $party_id;
		$insert['PartyTableNumber'] = $PartyTableNumber;
		$insert['PartyTableCode'] = $PartyTableCode;
		$insert['PartyTableDetail'] = $PartyTableDetail;
		$insert['status'] = $status;
		$insert['alumni_id'] = $alumni_id;
		$row= module::model('models:party_table')->select(array('PartyTableCode'=>$insert['PartyTableCode']));
		if(count($row)>0 AND $row[0]['party_table_id']!=$_POST['id']){
			$this->error = "หมายเลขโต๊ะซ้ำ";
		}else{
			if($insert['alumni_id']>'0'){
				$insert['status'] = 1;
			}
			$query = module::model('models:party_table')->update($insert,$_POST['id']);
		}
		return $query;
	}
	
	private function reload(){
		header('Location: index.php?module=/administrator/party_table/index');
		exit;
	}
	
	private function GenCode($order_id='',$t){
		$code = str_pad($order_id,2,'0',STR_PAD_LEFT);
		
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
        $ret_char = "";  
        $num = strlen($chars);
		$len = 6;
        for($i = 0; $i < $len; $i++) {  
            $ret_char.= $chars[rand()%$num];  
            $ret_char.="";   
        } 
		return $code.$ret_char.'-'.$t;
	}
	
}

?>