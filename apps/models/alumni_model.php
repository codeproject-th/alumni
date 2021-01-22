<?php

class alumni_model extends model{
	
	public function __construct(){
		$this->table('alumni');
		$this->pk('alumni_id');
		$this->page_rows(30);
	}
	
}

?>