<?php

class admin_module{
	
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
		$theme_var['content'] = module::view('administrator:admin/admin',array('table'=>$table));
		echo module::theme_admin('theme',$theme_var);
	}
	
	private function search(){
		$dataSearch = module::model('models:admin')->search($search);
		$i=0;
		$no = $dataSearch['no'];
		if(count($dataSearch['data'])>0){
			foreach($dataSearch['data'] as $key => $val){
				$no++;
				$data[$i] = $val;
				$data[$i]['no'] = $no;
				$data[$i]['action'] = '
									   <a href="index.php?module=/administrator/blog/edit&item='.$val['blog_id'].'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
									   <a href="index.php?module=/administrator/blog/delete&item='.$val['blog_id'].'" onclick="return confirm(\'Clear confirm\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
										';
				$i++;
			}
		}
		
		$header['no'] = array('label'=>'No.','width'=>'50');
		$header['admin_name'] = array('label'=>'ชื่อ');
		$header['admin_user'] = array('label'=>'Username','width'=>'30%');
		$header['action'] = array('align'=>'center','width'=>'100');
		$TableData = AdminTable::Table($header,$data,$dataSearch['pages'],input::post('page'),$js);
		return $TableData;
	}
	
	public function change_password(){
		$save = false;
		if($_POST){
			$save = $this->change_password_pass_save();
		}
		$admin_id = admin_get_id();
		$theme_var['content'] = module::view('administrator:admin/admin_change_pass',array('save'=>$save));
		echo module::theme_admin('theme',$theme_var);
	}
	
	private function change_password_pass_save(){
		$data['admin_pass'] = input::post('NewPassword');
		return module::model('models:admin')->update($data,admin_get_id());
		
	}
	
	public function logout(){
		unset($_SESSION['admin_id']);
		module::redirect(module_url('/administrator/login'));
		exit;
	}
	
}

?>