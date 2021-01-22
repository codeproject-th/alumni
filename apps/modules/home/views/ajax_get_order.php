<?

?>
<br><br>
<u>รายการจอง</u>
<br>
คุณ : <?=$data[0]['FirstName']?> <?=$data[0]['SurName']?>
<br><br>
<center>
<table border="1" width="500">
	<tr align="center">
		<td>INV.</td>
		<td>จำนวนเงิน</td>
		<td>สถานะ</td>
		<td>แจ้งชำระเงิน</td>
		<td>พิมพ์ใบจอง</td>
	</tr>
	<?
	foreach($data as $val){
		$status = '';
		if($val['order_status']=='0'){
			$status = '<span style="color:#ff0000;">รอยืนยันจากผู้ดูแล<span>';
		}else if($val['order_status']=='1'){
			$status = '<span style="color:#43ee11;">ยืนยันแล้ว</span>';
		}
		
		if($val['order_type']=='1'){
			$sql = "SELECT * FROM order_detail 
				LEFT JOIN party_table ON party_table.party_table_id = order_detail.party_table_id
				WHERE order_data_id = '".$val['order_data_id']."'
				
			";
			$dbarr = db::fetch($sql);
			if(count($dbarr)>0){
				$txt = '<ul>';
				foreach($dbarr as $val2){
					$txt .= "<li>".$val2['PartyTableCode']."</li>";
				}
				$txt .= '</ul>';
				$div[] = "<div id='info".$val['order_data_id']."' style='display:none;'>
						<b>หมายเลขโต๊ะ</b><br>
						".$txt."
					</div>";
			}
		}else if($val['order_type']=='2'){
			$sql = "SELECT COUNT(*) AS N FROM order_detail WHERE order_data_id = '".$val['order_data_id']."'";
			$dbarr = db::fetch($sql);
			$div[] = "<div id='info".$val['order_data_id']."' style='display:none;'>
						<b>จำนวนที่จอง</b>
						".$dbarr[0]['N']." ที่นั่ง
					</div>";
		}
	?>
	<tr align="center">
		<td><a href="#info<?=$val['order_data_id']?>" rel="facebox"><?=str_pad($val['order_data_id'],7,'0',STR_PAD_LEFT)?></a></td>
		<td align="right"><?=number_format($val['order_price'])?></td>
		<td align="center"><?=$status?></td>
		<td><a href="#payment_form<?=$val['order_data_id']?>" rel="facebox">แจ้งชำระเงิน</a></td>
		<td align="center">
			<? if($val['order_status']=='1'){ ?>
				<a href="index.php?module=/home/pdf/index&id=<?=$val['order_data_id']?>">พิมพ์</a>
			<? } ?>
		</td>
	</tr>
	<?	
	}
	?>
</table>
</center>

<? if(count($data)>0){ 
	foreach($data as $val){
?>		
	<div id="payment_form<?=$val['order_data_id']?>" style="display: none;">
		<form method="POST" action="index.php?module=/home/home/confirm_payment"  style="font-size: 12px;" id="FormPayment<?=$val['order_data_id']?>">
			<table width="500">
				<tr height="25">
					<td width="100">INV.</td>
					<td><?=str_pad($val['order_data_id'],7,'0',STR_PAD_LEFT)?></td>
				</tr>
				<tr height="25">
					<td>จำนวนเงิน</td>
					<td><?=number_format($val['order_price'])?> บาท</td>
				</tr>
				<tr height="25">
					<td>ธนาคาร</td>
					<td><input type="text" name="bank" required />(ระบุธนาคารของลูกค้า)</td>
				</tr>
				<tr height="25">
					<td>สาขา</td>
					<td><input type="text" name="branch" required />(ระบุธนาคารของลูกค้า)</td>
				</tr>
				<tr height="25">
					<td>ธนาคารที่โอนเข้า</td>
					<td><input type="text" name="acc" required /></td>
				</tr>
				<tr height="25">
					<td>วิธีการชำระเงิน</td>
					<td><input type="text" name="kind" required />(เช่น โอนผ่านตู้ ATM)</td>
				</tr>
				<tr height="25">
					<td>วันที่ชำระเงิน</td>
					<td><input type="text" name="date" required />(ตัวอย่าง 23/4/58)</td>
				</tr>
				<tr height="25">
					<td>เวลาชำระเงิน</td>
					<td><input type="text" name="time" />(ตัวอย่าง 13:45 น.)</td>
				</tr>
				<tr height="25">
					<td>จำนวนเงิน</td>
					<td><input type="text" name="amount" required /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="ยืนยันการโอนเงิน"/></td>
				</tr>
			</table>
			<input type="hidden" name="order_data_id" value="<?=$val['order_data_id']?>"/>
		</form>
	</div>
<? 
	}
} ?>


<?
if(count($div)>0){
	foreach($div as $val){
		echo $val;
	}
}
?>
<script>


</script>
