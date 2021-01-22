<?php

class table{
	
	public static function table_admin($header = array() ,$data = array()){
		$html = '<table class="table table-striped table-bordered table-hover">
					<thead>';
		if(count($header)>0){
			foreach($header as $val){
				$html.= '<th width="'.$val['width'].'">'.$val['label'].'</th>';
			}
		}
		
		$html .= '</thead>';
		$html .= '<tbody>';
		if(count($data)>0){
			foreach($data as $val){
				$html .= '<tr>';
				foreach($val as $td){
					$html .= '<td align="'.$td['align'].'">'.$td['label'].'</td>';
				}
				$html .= '</tr>';
			}
		}else{
			$html .= '<tr><td colspan="'.count($header).'" align="center">----- ไม่พบข้อมูล -----</td></tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		return $html;
	}
	
}

?>