<?php

class province_model extends model{
	
	public function __construct(){
		$this->table('province');
		$this->pk('PROVINCE_ID');
		//$this->page_rows(30);
	}
	
}

?>