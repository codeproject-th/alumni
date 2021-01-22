<?php
if(count($error)>0){
	echo "<div class='div_error'>";
	foreach($error as $val){
		echo $val."<br>";
	}
	echo "</div>";
}

if($query==true){
	echo "<div class='div_complete'>ลงทะเบียนเรียบร้อย</div>";
}

?>