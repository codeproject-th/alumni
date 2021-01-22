<?php

class alumni_module{
	
	// Start Class
	public function __construct(){
		//ส่วนผู้ดูแลระบบ
		if($_SESSION['admin_id']==''){
			//module::redirect(module_url('/administrator/login'));
			//exit;
		}
		module::extension('AdminTable');
	}
	
	// End Class
	public function  __destruct(){
		
	}
	// ------ //
	
	public function index(){
		$table = $this->search();
		$theme_var['content'] = module::view('administrator:admin/alumni_list',array('table'=>$table));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function add_data(){
		$save = false;
		if($_POST){
			$chk = $this->chkIDcard($_POST["IDCard"],"add");
			if($chk==true){
				$save = $this->save();
			}else{
				$error[] = "หมายเลขบัตรประชาชนมีอยู่ในระบบแล้ว";
			}
		}
		$theme_var['content'] = module::view('administrator:admin/alumni_add',array('save'=>$save,'error'=>$error));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function edit(){
		$id = $_GET['item'];
		$save = false;
		if($_POST){
			$chk = $this->chkIDcard($_POST["IDCard"],"edit",$_POST["id"]);
			if($chk==true){
				$save = $this->save();
			}else{
				$error[] = "หมายเลขบัตรประชาชนมีอยู่ในระบบแล้ว";
			}
		}
		$theme_var['content'] = module::view('administrator:admin/alumni_add',array('save'=>$save,'id'=>$id));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function delete(){
		module::model('models:alumni')->delete($_GET['item']);
		$this->reload();
	}
	
	private function search(){
		$search["FirstName"] = $_GET["FirstName"];
		$search["SurName"] = $_GET["SurName"];
		$search["IDCard"] = $_GET["IDCard"];
		$searchWhere["GenID"] = $_GET["GenID"];
		$dataSearch = module::model('models:alumni')->search($search,$searchWhere);
		$i=0;
		$no = $dataSearch['no'];
		
		$row_arr =  module::model('models:generation')->select();
		if(count($row_arr)>0){
			foreach($row_arr as $val){
				$generation[$val["GenID"]] = $val["GenCode"];
			}
		}
		
		if(count($dataSearch['data'])>0){
			foreach($dataSearch['data'] as $key => $val){
				$no++;
				$data[$i] = $val;
				$data[$i]['no'] = $no;
				$data[$i]['FullName'] = $val['FirstName'].' '.$val['SurName'];
				$data[$i]['GenID'] = $generation[$val["GenID"]];
				$data[$i]['action'] = '
									   <a href="index.php?module=/administrator/alumni/edit&item='.$val['alumni_id'].'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
									   <a href="index.php?module=/administrator/blog/delete&item='.$val['blog_id'].'" onclick="return confirm(\'Clear confirm\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
										';
				$i++;
			}
		}
		
		$header['no'] = array('label'=>'No.','width'=>'50');
		$header['FullName'] = array('label'=>'ชื่อ-นามสกุล');
		$header['IDCard'] = array('label'=>'หมายเลขบัตรประชาชน','align'=>'center');
		$header['GenID'] = array('label'=>'รุ่น','align'=>'center');
		
		$header['action'] = array('align'=>'center','width'=>'100');
		$TableData = AdminTable::Table($header,$data,$dataSearch['pages'],input::post('page'),$js);
		return $TableData;
	}
	
	private function save(){
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
		
		$action = $_POST["action"];
		if($action=="add"){
			$query = module::model('models:alumni')->insert($insert);
			if($query){
				$insert_address["alumni_id"] = db::insert_id();
				module::model('models:alumni_address')->insert($insert_address);
			}
		}else{
			$query = module::model('models:alumni')->update($insert,$_POST["id"]);
			module::model('models:alumni_address')->update($insert_address,$_POST["id"]);
		}
		return $query;
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
				echo 'vv';
				$chk = false;
			}
		}
		
		return $chk;
	}
	
	private function reload(){
		header('Location: index.php?module=/administrator/alumni/index');
		exit;
	}
}

?>