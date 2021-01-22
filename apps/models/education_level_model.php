<?php

class education_level_model extends model{
	
	public function __construct(){
		$this->table('education_level');
		$this->pk('EduID');
		//$this->page_rows(30);
	}
	
}

?>