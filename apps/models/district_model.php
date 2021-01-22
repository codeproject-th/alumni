<?php

class district_model extends model{
	
	public function __construct(){
		$this->table('district');
		$this->pk('DISTRICT_ID');
		//$this->page_rows(30);
	}
	
}

?>