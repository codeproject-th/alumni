<?php

class party_model extends model{
	
	public function __construct(){
		$this->table('party');
		$this->pk('party_id');
		$this->page_rows(30);
	}
	
}

?>