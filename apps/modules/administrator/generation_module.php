<?php

class generation_module{
	
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
		$theme_var['content'] = module::view('administrator:admin/generation_list',array('table'=>$table));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function add(){
		$save = false;
		if($_POST){
			$save = $this->save();
		}
		$theme_var['content'] = module::view('administrator:admin/generation_add',array('save'=>$save));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function edit(){
		$id = $_GET['item'];
		$save = false;
		if($_POST){
			$save = $this->save();
		}
		$theme_var['content'] = module::view('administrator:admin/generation_add',array('save'=>$save,'id'=>$id));
		echo module::theme_admin('theme',$theme_var);
	}
	
	public function delete(){
		module::model('models:generation')->delete($_GET['item']);
		$this->reload();
	}
	
	private function save(){
		$insert['YearStart'] = $_POST['YearStart'];
		$insert['YearEnd'] = $_POST['YearEnd'];
		$insert['GenNO'] = $_POST['GenNO'];
		$insert['ThirdStudy'] = $_POST['ThirdStudy'];
		$insert['M3'] = $_POST['M3'];
		$insert['M6Year'] = $_POST['M6Year'];
		$insert['GenNOM6'] = $_POST['GenNOM6'];
		$insert['GenCode'] = $_POST['GenCode'];
		$insert['Reference1'] = $_POST['Reference1'];
		$insert['Reference2'] = $_POST['Reference2'];
		$insert['Reference3'] = $_POST['Reference3'];
		$insert['Reference4'] = $_POST['Reference4'];
		
		$action = $_POST["action"];
		if($action=="add"){
			$query = module::model('models:generation')->insert($insert);
		}else{
			$query = module::model('models:generation')->update($insert,$_POST["id"]);
		}
		
		return $query;
	}
	
	private function search(){
		$dataSearch = module::model('models:generation')->search($search,array(),'ORDER BY YearStart');
		$i=0;
		$no = $dataSearch['no'];
		if(count($dataSearch['data'])>0){
			foreach($dataSearch['data'] as $key => $val){
				$no++;
				$data[$i] = $val;
				$data[$i]['no'] = $no;
				$data[$i]['action'] = '
									   <a href="index.php?module=/administrator/generation/edit&item='.$val['GenID'].'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
									   <a href="index.php?module=/administrator/generation/delete&item='.$val['GenID'].'" onclick="return confirm(\'Clear confirm\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
										';
				$i++;
			}
		}
		
		$header['no'] = array('label'=>'No.','width'=>'50');
		$header['YearStart'] = array('label'=>'ปีการศึกษา');
		$header['YearEnd'] = array('label'=>'ปีที่จบ');
		$header['GenNO'] = array('label'=>'รุ่นโรงเรียน');
		$header['ThirdStudy'] = array('label'=>'ชั้น ม.ศ.3');
		$header['M3'] = array('label'=>'ปรับเป็น ม.3');
		$header['M6Year'] = array('label'=>'ปีที่จบ ม.6');
		$header['GenNOM6'] = array('label'=>'รุ่น ม.6');
		$header['GenCode'] = array('label'=>'รุ่น D.S.');
		$header['Reference1'] = array('label'=>'พระสงฆ์');
		$header['Reference2'] = array('label'=>'ครู');
		$header['Reference3'] = array('label'=>'ประธานรุ่น');
		$header['Reference4'] = array('label'=>'แกนนำรุ่น');
		$header['action'] = array('align'=>'center','width'=>'100');
		$TableData = AdminTable::Table($header,$data,$dataSearch['pages'],input::post('page'),$js);
		return $TableData;
	}
	
	private function reload(){
		header('Location: index.php?module=/administrator/generation/index');
		exit;
	}
}

?>