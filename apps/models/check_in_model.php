<?php

class check_in_model extends model{
	
	public function __construct(){
		$this->table('check_in');
		$this->pk('check_in_id');
		$this->page_rows(30);
	}
	
}

?>