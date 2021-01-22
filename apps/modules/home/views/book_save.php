<?php
$party = module::model('models:party')->select(array('party_id'=>$_POST['party_id']));
$select = $_POST['select'];
if(count($select)>0){
?>
<form method="POST" action="index.php?module=/home/home/order_save">
<table border="1" width="100%" cellpadding="0" cellspacing="0">
	<tr height="30">
		<th width="20%" bgcolor="#0549c9"><span style="color: #ffffff;">หมายเลขโต๊ะ</span></th>
		<th width="20%" bgcolor="#b3e2f2">จำนวนที่นั่ง</th>
		<th width="40%" bgcolor="#fbb5ee">รายละเอียด</th>
	</tr>
<?
$i = 0;
foreach($select as $val){
	if($i==0){
		$in .= "'".$val."'";
	}else{
		$in .= ",'".$val."'";
	}
	
	$i++;
}
$sql = "SELECT * FROM party_table WHERE party_table_id IN(".$in.")";
$row = db::fetch($sql);
?>
<? 
	$i = 0;
	$bg[1] = "#fafafa";
	$bg[2] = "#e2e2e2";
	$bg[3] = "#ffc8c8";
	$n = 2;
	$total = 0;
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
		
		$total = $total+$party[0]['PartyPriceTable'];
	?>
	<tr height="25" bgcolor="<?=$bg[$n]?>">
		<td align="center"><?=$val["PartyTableCode"]?></td>
		<td align="center"><?=$val["PartyTableNumber"]?></td>
		<td><?=$val["PartyTableDetail"]?>
			<input type="hidden" name="select_table[]" value="<?=$val['party_table_id']?>"/>
		</td>
	</tr>
	<?	
		if($val['status']=='1'){
			$n = $bg_old;
		}
	}
	?>
	<tr height="30" bgcolor="#faffdb">
		<td colspan="2" align="right">ราคารวม</td>
		<td align="right"><?=number_format($total,2)?> บาท</td>
	</tr>
</table>
<br>	
<table>
	<tr>
		<td align="right">หมายเลขบัตรประชาชนที่ลงทะเบียนศิยษ์เก่า :</td>
		<td><input type="text" style="width: 200px;" name="id_card" required/></td>
	</tr>
	<tr valign="top">
		<td align="right">วิธีการชำระเงิน :</td>
		<td>
			<input type="radio" name="payment" value="1" required /> Paysbuy <br>
			<input type="radio" name="payment" value="2" required /> โอนเงิน <br>
		</td>
	</tr>
</table>
<input type="hidden" name="party_id" value="<?=$party[0]['party_id']?>"/>
<div style="margin-top: 20px; text-align: center;">
	<input type="submit" value="ทำการจอง"/>
</div>
</form>
<? } ?>