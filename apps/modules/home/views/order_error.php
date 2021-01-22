<?php
if(count($error)>0){
	foreach($error as $val){
		$txt .= $val."<br>";
	}
}
?>
<div class="div_error"><?=$txt?></div>
<style>
.div_error{
	border-style: solid;
	border-width: 1px;
	border-color: #ff0000;
	padding: 10px;
}
</style>