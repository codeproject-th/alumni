<?php

class alumni_address_model extends model{
	
	public function __construct(){
		$this->table('alumni_address');
		$this->pk('alumni_address_id');
		$this->page_rows(30);
	}
	
}

?>