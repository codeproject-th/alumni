<?php

class party_module{
	
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
		$theme_var['content'] = module::view('administrator:admin/party_list',array('table'=>$table));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function add(){
		$save = false;
		if($_POST){
			$save = $this->save();
		}
		$theme_var['content'] = module::view('administrator:admin/party_add',array('save'=>$save,'error'=>$error));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function edit(){
		$id = $_GET['item'];
		$save = false;
		if($_POST){
			$save = $this->save();
		}
		$theme_var['content'] = module::view('administrator:admin/party_add',array('save'=>$save,'id'=>$id));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function delete(){
		module::model('models:party')->delete($_GET['item']);
		$this->reload();
	}
	
	private function search(){
		$search["FirstName"] = $_GET["FirstName"];
		$search["SurName"] = $_GET["SurName"];
		$search["IDCard"] = $_GET["IDCard"];
		$searchWhere["GenID"] = $_GET["GenID"];
		$dataSearch = module::model('models:party')->search($search,$searchWhere);
		$i=0;
		$no = $dataSearch['no'];
		
		
		if(count($dataSearch['data'])>0){
			foreach($dataSearch['data'] as $key => $val){
				$no++;
				
				$PartyStatus = "เปิดจอง";
				
				if($val['PartyStatus']=='1'){
					$PartyStatus = "ปิดจอง";
				}
				
				$data[$i] = $val;
				$data[$i]['no'] = $no;
				$data[$i]['PartyStatus'] = $PartyStatus;
				$data[$i]['PartyDate'] = date_th($val['PartyDate']);
				$data[$i]['PartyImg'] = "<a href='./apps/data/images/".$data[$i]['PartyImg']."' target='_blank'>".$data[$i]['PartyImg']."</a>";
				$data[$i]['action'] = '
									   <a href="index.php?module=/administrator/party/edit&item='.$val['party_id'].'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
									   <a href="index.php?module=/administrator/party/delete&item='.$val['party_id'].'" onclick="return confirm(\'Clear confirm\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
										';
				$i++;
			}
		}
		
		$header['no'] = array('label'=>'No.','width'=>'50');
		$header['PartyName'] = array('label'=>'ชื่องาน');
		$header['PartyDate'] = array('label'=>'วันที่จัด','align'=>'center');
		$header['PartyPriceTable'] = array('label'=>'ราคาโต๊ะ','align'=>'center');
		$header['PartySeatPrices'] = array('label'=>'ราคาที่นั่ง','align'=>'center');
		$header['PartyStatus'] = array('label'=>'สถานะการจอง','align'=>'center');
		$header['PartyImg'] = array('label'=>'ผังที่นั่ง','align'=>'center');
		
		$header['action'] = array('align'=>'center','width'=>'100');
		$TableData = AdminTable::Table($header,$data,$dataSearch['pages'],input::post('page'),$js);
		return $TableData;
	}
	
	private function save(){
		$insert["PartyName"] = $_POST["PartyName"];
		$insert["PartyDate"] = DateDB($_POST["PartyDate"]);
		$insert["PartyStatus"] = $_POST["PartyStatus"];
		$insert["PartySeatPrices"] = $_POST["PartySeatPrices"];
		$insert["PartyPriceTable"] = $_POST["PartyPriceTable"];
		$action = $_POST["action"];
		if($action=="add"){
			$insert["PartyImg"] = $this->uploadImg();
			$query = module::model('models:party')->insert($insert);
		}else{
			if($_POST['delete_img']==''){
				$insert["PartyImg"] = $this->uploadImg($_POST["img_h"]);
			}else{
				$insert["PartyImg"] = '';
				@unlink('./apps/data/images/'.$_POST["img_h"]);
			}
			$query = module::model('models:party')->update($insert,$_POST["id"]);
		}
		return $query;
	}
	
	private function uploadImg($old_img=''){
		if($_FILES["img"]["name"]!=""){
			$file_type = end(explode('.',$_FILES["img"]["name"]));
			$file_type = strtolower($file_type);
			if($file_type=="jpg" or $file_type=="jpeg" or $file_type=="gif" or $file_type=="png"){
				$new_file = date('YmdHis').".".$file_type;
				move_uploaded_file($_FILES["img"]["tmp_name"],'./apps/data/images/'.$new_file);
			}
		}else{
			$new_file = $old_img;
		}
		
		return $new_file;
	}
	
	
	private function reload(){
		header('Location: index.php?module=/administrator/party/index');
		exit;
	}
}

?>