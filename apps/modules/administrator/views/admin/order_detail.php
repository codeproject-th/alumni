<?
$data = module::model('models:order_data')->get($id);
$confirm_payment = module::model('models:confirm_payment')->select(array('order_data_id'=>$data['order_data_id']));

if($data['order_type']=='1'){
	$payment_status = '';
	if($data['payment_status']=='1'){
		$payment_status = 'Paysbuy';
	}else if($data['payment_status']=='2'){
		$payment_status = 'โอนเงิน';
	}
?>
INV. : <?=str_pad($data['order_data_id'],7,'0',STR_PAD_LEFT)?>
<br>
วิธีการชำระเงิน : <?=$payment_status?>
<table width="100%" border="1">
	<tr align="center" bgcolor="#1f4acd">
		<th style="text-align: center;" height="30"><div style="color: #ffffff;">No.</div></th>
		<th style="text-align: center;" height="30"><div style="color: #ffffff;">หมายเลขโต๊ะ</div></th>
		<th style="text-align: center;" height="30"><div style="color: #ffffff;">ผู้จอง</div></th>
	</tr>
<?
	$i = 0;
	$party_table = module::model('models:order_detail')->select(array('order_data_id'=>$id));
	if(count($party_table)>0){
		/////
		foreach($party_table as $val){
			$i++;
			$chk = module::model('models:party_table')->get($val['party_table_id']);
			$alumni = module::model('models:alumni')->get($chk['alumni_id']);
?>
		<tr align="center">
			<td style="text-align: center;"><?=$i?></td>
			<td style="text-align: center;"><?=$chk['PartyTableCode']?></td>
			<td style="text-align: center;"><?=$alumni['FirstName']?> &nbsp; <?=$alumni['SurName']?></td>
		</tr>
<?
		}
	}
?>
</table>

<? } ?>
<? 
if($data['order_type']=='2'){ 
	$payment_status = '';
	if($data['payment_status']=='1'){
		$payment_status = 'Paysbuy';
	}else if($data['payment_status']=='2'){
		$payment_status = 'โอนเงิน';
	}
	
	$sql = "SELECT COUNT(*) AS N FROM order_detail WHERE order_data_id='".$data['order_data_id']."'";
	$dbarr = db::fetch($sql);
?>
INV. : <?=str_pad($data['order_data_id'],7,'0',STR_PAD_LEFT)?>
<br>
วิธีการชำระเงิน : <?=$payment_status?>
<br>
จำนวนที่จอง : <?=$dbarr[0]['N']?>
<? } ?>

<?
if(count($confirm_payment)>0){
	echo '<br><u>แจ้งโอนเงิน</u>';
	foreach($confirm_payment as $val){
?>
			<table>
				<tr height="25">
					<td width="200">ธนาคาร</td>
					<td><?=$val['bank']?></td>
				</tr>
				<tr height="25">
					<td>สาขา</td>
					<td><?=$val['branch']?></td>
				</tr>
				<tr height="25">
					<td>ธนาคารที่โอนเข้า</td>
					<td><?=$val['acc']?></td>
				</tr>
				<tr height="25">
					<td>วิธีการชำระเงิน</td>
					<td><?=$val['kind']?></td>
				</tr>
				<tr height="25">
					<td>วันที่ชำระเงิน</td>
					<td><?=$val['date']?></td>
				</tr>
				<tr height="25">
					<td>เวลาชำระเงิน</td>
					<td><?=$val['time']?></td>
				</tr>
				<tr height="25">
					<td>จำนวนเงิน</td>
					<td><?=$val['amount']?></td>
				</tr>
			</table>
			<div style="border-top-style: solid; border-top-width: 1px; border-top-color: #ececec;"></div>

<?		
	}
}
?>
<br><br>