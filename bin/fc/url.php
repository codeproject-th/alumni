<?php

function theme_url($name=''){
	if($name == ''){
		$name = WEB_THEME;
	}
	$url = WEB_URL_PATH.'/apps/themes/'.$name;
	return $url;
}


function module_url($module_url='',$p=''){
	$url = WEB_URL.'?module='.$module_url.$p;
	return $url;
}

?>