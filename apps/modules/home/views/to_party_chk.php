<?
$data = db::fetch($sql);
?>
<div style="font-size: 30px; margin-top:50px; text-align: center;">
	ผลการตรวจสอบ
	<br>
<?
if(count($data)==0){
?>
	<div style="color: #ff0000; margin-top: 20px;">ไม่พบข้อมูล</div>
<? }else{ 
	module::model('models:check_in')->insert(
						array(
								'order_code' => $data[0]['order_code'],
								'check_in_date' => date('Y-m-d H:i:s')
							)
						);
						
	$n = module::model('models:check_in')->select(
						array(
								'order_code' => $data[0]['order_code']
							)
						);
?>
<br>
<table>
	<tr>
		<td align="right">ครั้งที่ :</td>
		<td align="left"><?=number_format(count($n))?></td>
	</tr>
	<tr>
		<td align="right">CODE :</td>
		<td align="left"><?=$data[0]['order_code']?></td>
	</tr>
	<tr>
		<td align="right">ชื่อ-นามสกุล :</td>
		<td align="left"><?=$data[0]['FirstName']?> &nbsp; <?=$data[0]['SurName']?></td>
	</tr>
	<tr>
		<td align="right">หมายเลขบัตรประชาชน :</td>
		<td align="left"><?=$data[0]['IDCard']?></td>
	</tr>
</table>

<? } ?>
</div>