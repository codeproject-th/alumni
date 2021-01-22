<?

class model{
	
	public $table;
	public $pk;
	public $page_rows;
	public $order_by;
	
	public function table($table=''){
		$this->table = MYSQL_PREFIX.$table;
	}
	
	public function pk($pk=''){
		$this->pk = $pk;
	}
	
	public function page_rows($r=''){
		$this->page_rows = $r;
	}
	
	public function order_by($order_by=''){
		$this->order_by = $order_by;
	}
	
	public function insert($var = array()){
		$query = db::insert($this->table,$var);
		return $query;
	}
	
	public function insert_id(){
		return db::insert_id();
	}
	
	public function update($var = array(),$id=""){
		$query = db::update($this->table,$var,array($this->pk => $id));
		return $query;
	}
	
	public function update_all($var = array(),$where = array()){
		$query = db::update($this->table,$var,$where);
		return $query;
	}
	
	public function select($where_var = array(),$fields = "*" ,$order_by = ""){
		if($order_by==''){
			$order_by = $this->order_by;
		}
		$data = db::select($this->table,$where_var,$fields,$order_by);
		return $data;
	}
	
	public function delete($id=""){
		$query = db::delete($this->table,array($this->pk => $id));
		return $query;
	}
	
	
	public function delete_all($where=array()){
		$query = db::delete($this->table,$where);
		return $query;
	}
	
	
	public function get($id=""){
		$data = db::select($this->table,array($this->pk => $id));
		return $data[0];
	}
	
	public function all(){
		$data = db::select($this->table);
		return $data;
	}
	
	public function search($where_var = array(),$where_set = array(),$order_by = ""){
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
		
		$sql = "SELECT * FROM ".$this->table." WHERE 1=1 ".$where." ".$order_by;
		//echo $sql;
		$data = db::pagination($sql,$_REQUEST["page"],$this->page_rows);
		return $data;
	}
	
	public function fetch($sql){
		$data = db::fetch($sql);
		return $data;
	}
	
	public function db_date($date='',$type='date'){
		$return = '';
		switch($type){
			case 'date': 
				if($date!=''){
					$date_ex = explode('/',$date);
					$return = $date_ex[2].'-'.$date_ex[1].'-'.$date_ex[0];
				}
			break;
		}
		
		return $return;
	}
	
}

?>