<?php

class order_detail_model extends model{
	
	public function __construct(){
		$this->table('order_detail');
		$this->pk('order_detail_id');
		//$this->page_rows(30);
	}
	
}

?>