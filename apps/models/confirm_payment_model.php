<?php

class confirm_payment_model extends model{
	
	public function __construct(){
		$this->table('confirm_payment');
		$this->pk('confirm_payment_id');
		$this->page_rows(30);
	}
	
}

?>