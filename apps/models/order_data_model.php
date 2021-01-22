<?php

class order_data_model extends model{
	
	public function __construct(){
		$this->table('order_data');
		$this->pk('order_data_id');
		$this->page_rows(30);
	}
	
	public function search_data($where_var = array(),$where_set = array(),$order_by = ""){
		$where = "";
		if(count($where_var)>0){
			foreach($where_var as $key => $val){
				if($val!=""){
					$where .= " AND ".$key." LIKE '%".db::str($val)."%'";
				}
			}
		}
		
		if(count($where_set)>0){
			foreach($where_set as $key => $val){
				if($val!=""){
					$where .= " AND ".$key." = '".db::str($val)."'";
				}
			}
		}
		
		$sql = "SELECT order_data.* , alumni.* , party.* FROM ".$this->table."
				LEFT JOIN alumni ON alumni.alumni_id = order_data.alumni_id 
				LEFT JOIN party ON order_data.party_id = order_data.party_id
				WHERE 1=1 ".$where." ".$order_by;
		//echo $sql;
		$data = db::pagination($sql,$_REQUEST["page"],$this->page_rows);
		return $data;
	}
	
}

?>