<?php

class party_table_module{
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
		$theme_var['content'] = module::view('administrator:admin/party_table_list',array('table'=>$table));
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
			$save = $this->save_edit();
		}
		$theme_var['content'] = module::view('administrator:admin/party_table_edit',array('save'=>$save,'id'=>$id,'error'=>$this->error));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function delete(){
		module::model('models:party_table')->delete($_GET['item']);
		$this->reload();
	}
	
	private function search(){
		if($_GET['alumni']!=''){
			$alumni_ex = explode('-',$_GET['alumni']);
		}
		
		
		$search['PartyTableCode'] = $_GET['PartyTableCode'];
		$searchWhere['party.party_id'] = $_GET['party_id'];
		$searchWhere['status'] = $_GET['status'];
		$searchWhere['party_table.alumni_id'] = $alumni_ex[0];
		$searchWhere['PartyTableNumber'] = $_GET['PartyTableNumber'];
		
		$dataSearch = module::model('models:party_table')->search_data($search,$searchWhere,'ORDER BY PartyTableCode');
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
				if($val['status']=='0'){
					$status = '<span style="color:#ff0000;">ว่าง<span>';
				}else if($val['status']=='1'){
					$status = '<span style="color:#43ee11;">จองแล้ว</span>';
				}
				
				$data[$i] = $val;
				$data[$i]['no'] = $no;
				$data[$i]['status'] = $status;
				$data[$i]['FullName'] = $val['FirstName'].' '.$val['SurName'];
				$data[$i]['PartyStatus'] = $PartyStatus;
				$data[$i]['PartyDate'] = date_th($val['PartyDate']);
				$data[$i]['PartyImg'] = "<a href='./apps/data/images/".$data[$i]['PartyImg']."' target='_blank'>".$data[$i]['PartyImg']."</a>";
				$data[$i]['action'] = '
									   <a href="index.php?module=/administrator/party_table/edit&item='.$val['party_table_id'].'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
									   <a href="index.php?module=/administrator/party_table/delete&item='.$val['party_table_id'].'" onclick="return confirm(\'Clear confirm\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
										';
				$i++;
			}
		}
		
		$header['no'] = array('label'=>'No.','width'=>'50');
		$header['PartyName'] = array('label'=>'ชื่องาน');
		$header['PartyTableCode'] = array('label'=>'หมายเลขโต๊ะ','align'=>'center');
		$header['PartyTableNumber'] = array('label'=>'จำนวนที่นั่ง','align'=>'center');
		$header['PartyTableDetai'] = array('label'=>'รายละเอียด');
		$header['status'] = array('label'=>'สถานะ','align'=>'center');
		$header['FullName'] = array('label'=>'ผู้จอง');
		
		$header['action'] = array('align'=>'center','width'=>'100');
		$TableData = AdminTable::Table($header,$data,$dataSearch['pages'],input::post('page'),$js);
		return $TableData;
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
	
}

?>