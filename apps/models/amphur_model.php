<?php

class amphur_model extends model{
	
	public function __construct(){
		$this->table('amphur');
		$this->pk('AMPHUR_ID');
		//$this->page_rows(30);
	}
	
}

?>