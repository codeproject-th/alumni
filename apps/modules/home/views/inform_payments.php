<script src="<?=theme_url('default')?>/resources/jquery-validation/jquery.validate.min.js"></script>
<script src="<?=theme_url('default')?>/resources/facebox/src/facebox.js"></script>
<link rel="stylesheet" href="<?=theme_url('default')?>/resources/facebox/src/facebox.css">
<b>ยื่นยันการชำระเงิน</b>
<table width="100%">
	<tr>
		<td width="300">หมายเลขบัตรประชาชนที่ลงทะเบียนศิยษ์เก่า</td>
		<td>
			<input type="text" name="id_card" id="id_card" style="width: 200px;">
			<input type="button" value="ค้นหา" id="butSearch"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div id="OutPut"></div>
		</td>
	</tr>
</table>
<script>
$(window).load(function() {
	$("#butSearch").on('click',function(){
		$.ajax({
			type: "POST",
			url: "index.php?module=/ajax/ajax/getOrder",
			cache: false,
			data: "id="+$("#id_card").val(),
			success: function(data){
				
				$("#OutPut").html(data);
				$('a[rel*=facebox]').facebox({
					loadingImage : '<?=theme_url('default')?>/resources/facebox/src/loading.gif',
      				closeImage   : '<?=theme_url('default')?>/resources/facebox/src/closelabel.png'
				});

			}
		});
	});
	
});

function FormPaymentPost(ID){
	var data_form = $('#FormPayment'+ID+"").serialize();
		alert(data_form);
		$.ajax({
			type: "POST",
			url: "index.php?module=/ajax/ajax/confirm_payment",
			cache: false,
			data: data,
			success: function(data){
					alert(data);
					alert('แจ้งยืนยันการโอนเงินเรียบร้อย');
			}
		});
	return false;
}
</script>