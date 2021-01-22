<div style="font-size: 24px; margin-top: 20px; text-align: center;">
	เข้างาน
</div>
<form method="post" id="FormLogin">
<div style="text-align: center; margin-top: 20px;">
	<input type="text" style="font-size: 20px; width: 500px;" name="code"  id="code"/>
</div>
<div style="text-align: center; margin-top: 5px; margin-bottom: 20px;">
	<input type="submit" value="เข้างาน" style="font-size: 20px; width: 508px;"/>
</div>
</form>
<div id="OutPut">
	
</div>
<script>
$(window).load(function() {
	$("#code").focus();
	$('#FormLogin').submit(function(){
		//alert('xx');
		$.ajax({
			type: "POST",
			url: "index.php?module=/home/to_party/chk",
			cache: false,
			data: "code="+$("#code").val(),
			success: function(data){
				$('#OutPut').html(data);
				$("#code").val('');
				$("#code").focus();
			}
		});
		return false;
	});
});
</script>