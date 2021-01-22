<?php

class generation_model extends model{
	
	public function __construct(){
		$this->table('generation');
		$this->pk('GenID');
		$this->page_rows(30);
	}
	
}

?>