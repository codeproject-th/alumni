<?php

class party_table_model extends model{
	
	public function __construct(){
		$this->table('party_table');
		$this->pk('party_table_id');
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
		
		$sql = "SELECT party.*, party_table.* , alumni.* FROM ".$this->table."
				LEFT JOIN party ON party.party_id = party_table.party_id
				LEFT JOIN alumni ON alumni.alumni_id = party_table.alumni_id
				WHERE 1=1 ".$where." ".$order_by;
		//echo $sql;
		$data = db::pagination($sql,$_REQUEST["page"],$this->page_rows);
		return $data;
	}
	
}

?>