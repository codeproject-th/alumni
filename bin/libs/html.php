<?php

class html{
	
	public static function select_option($option=array(),$data_key=array('label'=>'','value'=>''),$data=array(),$select=""){
		$html['option'] = '';
		if(count($option)>0){
			foreach($option as $key => $val){
				$html['option'] .= ' '.$key.'="'.$val.'"';
			}
		}
		$html['list'] = '<option value="">--เลือก--</option>';
		if(count($data)>0){
			foreach($data as $val){
				$select_ed = "";
				if($val[$data_key['value']]==$select){
					$select_ed = 'selected';
				}
				$html['list'] .= '<option value="'.$val[$data_key['value']].'" '.$select_ed.'>'.$val[$data_key['label']].'</option>';
			}
		}
		
		return '<select '.$html['option'].'>'.$html['list'].'</select>';
	}
	
}

?>