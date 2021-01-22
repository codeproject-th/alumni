<?php
$party = module::model('models:party')->select(array(),'*','ORDER BY PartyDate DESC');
$row= module::model('models:party_table')->select(array('party_id'=>$party[0]['party_id']),'*',' ORDER BY CONVERT( PartyTableCode USING tis620 )');

if($party[0]['PartyStatus']=='1'){
	echo 'ปิดการจองโต๊ะ';
}else{
///////////////// Start ////////////////////
?>
<script src="<?=theme_url('default')?>/resources/jquery-validation/jquery.validate.min.js"></script>
<script src="<?=theme_url('default')?>/resources/facebox/src/facebox.js"></script>
<link rel="stylesheet" href="<?=theme_url('default')?>/resources/facebox/src/facebox.css">
    
<h3><?=$party[0]['PartyName']?></h3>
<? if($party[0]['PartyImg']!=''){ ?>
	<div style="display: none;">
		<img src="./apps/data/images/<?=$party[0]['PartyImg']?>">
	</div>
<? } ?>

<? 
if(count($row)>0){
?>
<b>จองโต๊ะ</b>
&nbsp;&nbsp;&nbsp;&nbsp;จองแบบที่นั้ง >>> <a href="#info" rel="facebox">คลิ๊ก</a> <<<
<form method="POST" action="index.php?module=/home/home/book_save">
<table border="1" width="100%" cellpadding="0" cellspacing="0">
	<tr height="30">
		<th width="10%" bgcolor="#f2bf62">เลือก</th>
		<th width="20%" bgcolor="#0549c9"><span style="color: #ffffff;">หมายเลขโต๊ะ</span></th>
		<th width="20%" bgcolor="#b3e2f2">จำนวนที่นั่ง</th>
		<th width="40%" bgcolor="#fbb5ee">รายละเอียด</th>
	</tr>
	<? 
	$i = 0;
	$bg[1] = "#fafafa";
	$bg[2] = "#e2e2e2";
	$bg[3] = "#ffc8c8";
	$n = 2;
	foreach($row as $val){
		$i++;
		$bg_old = $n;
		if($n==2){
			$n = 1;
		}else if($n==1){
			$n = 2;
		}
		if($val['status']=='1'){
			$n = 3;
		}
	?>
	<tr height="25" bgcolor="<?=$bg[$n]?>">
		<td align="center"><? if($val['status']=='0'){ ?><input type="checkbox" name="select[]" value="<?=$val["party_table_id"]?>"/><? }else{ ?> <b style="color: #ff0000;">จองแล้ว</b> <? } ?></td>
		<td align="center"><?=$val["PartyTableCode"]?></td>
		<td align="center"><?=$val["PartyTableNumber"]?></td>
		<td><<?=$val["PartyTableDetail"]?>/td>
	</tr>
	<?	
		if($val['status']=='1'){
			$n = $bg_old;
		}
	}
	?>
</table>
	<div style="text-align: center; margin-top: 10px;">
		<input type="submit" value="จอง">
	</div>
<? } ?>
	<input type="hidden" name="party_id" value="<?=$party[0]['party_id']?>"/>
</form>


<div id="info" style="display: none; padding: 10px;">
<b>จองแบบที่นั่ง</b>
<br><br>
<form method="POST" action="index.php?module=/home/home/book_seat_save">
<table width="800">
	<tr>
		<td align="right" width="300">หมายเลขบัตรประชาชนที่ลงทะเบียนศิยษ์เก่า :</td>
		<td><input type="text" style="width: 200px;" name="id_card" required /></td>
	</tr>
	<tr>
		<td align="right">จำนวนที่นั่ง :</td>
		<td><input type="text" style="width: 50px;" name="seat" required /></td>
	</tr>
	<tr valign="top">
		<td align="right">วิธีการชำระเงิน :</td>
		<td>
			<input type="radio" name="payment" value="1" required /> Paysbuy <br>
			<input type="radio" name="payment" value="2" required /> โอนเงิน <br>
		</td>
	</tr>
	<tr height="40">
		<td></td>
		<td><input type="submit" value="จอง"/></td>
	</tr>
</table>
<input type="hidden" name="party_id" value="<?=$party[0]['party_id']?>"/>
</form>
</div>
<script>
$(window).load(function() {
	$('a[rel*=facebox]').facebox({
		loadingImage : '<?=theme_url('default')?>/resources/facebox/src/loading.gif',
      	closeImage   : '<?=theme_url('default')?>/resources/facebox/src/closelabel.png'
	});
});
</script>
<?
///////////////// END ////////////////////
}
?>