<?php

function date_web($date='',$type='th'){
	switch($type){
		case 'th' :
			$return = date_th($date);
		break;
	}
	
	if($date==''){
		$return = '';
	}
	
	return $return;
}

function date_th($date=''){
	$date_ex = explode(' ',$date);
	if(count($date_ex)==2){
		$day_ex = explode('-',$date_ex[0]);
		$return = $day_ex[2].'/'.$day_ex[1].'/'.$day_ex[0];
	}else if(count($date_ex)==1){
		$day_ex = explode('-',$date);
		$return = $day_ex[2].'/'.$day_ex[1].'/'.$day_ex[0];
	}
	
	if($date==''){
		$return = '';
	}
	
	return $return;
}

function DateDB($date=""){
	if($date!=""){
		$date_ex = explode("/",$date);
		return $date_ex[2].'-'.$date_ex[1].'-'.$date_ex[0];
	}
}

?>