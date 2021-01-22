<?php

class admin_model extends model{
	
	public function __construct(){
		$this->table('admin');
		$this->pk('admin_id');
		$this->page_rows(30);
	}
	
}

?>