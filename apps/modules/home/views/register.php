<?php
$title = "เพิ่มข้อมูลศิษย์เก่า";
$action = "add";

$EduLevel = module::model('models:education_level')->select();
$Province = module::model('models:province')->select(array(),'*','ORDER BY CONVERT( PROVINCE_NAME USING tis620 ) ASC');
$generation =  module::model('models:generation')->select(array(),'*','ORDER BY YearStart ASC');
?>
    <!-------------------------------------------------------->
    <script src="<?=theme_url('default')?>/resources/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?=theme_url('default')?>/resources/facebox/src/facebox.js"></script>
    <link rel="stylesheet" href="<?=theme_url('default')?>/resources/facebox/src/facebox.css">
    <div id="info" style="display: none;">
    <!------------->
    <br>
    <center>
    	<h3>ตารางเทียบรุ่น ศิยษ์เก่าโรงเรียนดาราสมุทร อ.ศรีราชา จ.ชลบุรี</h3>
    </center>
    <table width="1000" border="1" cellpadding="0" cellspacing="0">
    	<tr align="center" style="color:#ffffff;">
    		<td rowspan="2" bgcolor="#9a6427">เลือก</td>
    		<td rowspan="2" bgcolor="#0172c2">ปีการศึกษา</td>
    		<td rowspan="2" bgcolor="#204f79">ปีการที่จบ</td>
    		<td colspan="6" bgcolor="#0172c2">เทียบรุ่น</td>
    		<td colspan="4" bgcolor="#1f5079">บุคคลอ้างอิง</td>
    	</tr>
    	<tr align="center">
    		<td bgcolor="#fcc105">รุ่นโรงเรียน</td>
    		<td bgcolor="#92d248">ชั้น ม.ศ. 3</td>
    		<td bgcolor="#92cb5a">ปรับเป็น ม.3</td>
    		<td bgcolor="#fffb14">ปีที่จบ ม.6</td>
    		<td bgcolor="#fffd00">รุ่น ม.6</td>
    		<td bgcolor="#032259" style="color:#ffffff;">รุ่น D.S.</td>
    		<td bgcolor="#ffff01">พระสงฆ์</td>
    		<td bgcolor="#93d250">ครู</td>
    		<td bgcolor="#f4c30f">ประธานรุ่น</td>
    		<td bgcolor="#ff6afa">แกนนำรุ่น</td>
    	</tr>
    	<?
    	if(count($generation)>0){
    		foreach($generation as $val){
    	?>
    		<tr>
    			<td align="center"><input type="radio" name="select_generation" onclick="select_generation('<?=$val['GenID']?>')"/></td>
    			<td align="center"><?=$val["YearStart"]?></td>
    			<td align="center"><?=$val["YearEnd"]?></td>
    			<td align="center"><?=$val["GenNO"]?></td>
    			<td align="center"><?=$val["ThirdStudy"]?></td>
    			<td align="center"><?=$val["M3"]?></td>
    			<td align="center"><?=$val["M6Year"]?></td>
    			<td align="center"><?=$val["GenNOM6"]?></td>
    			<td align="center"><?=$val["GenCode"]?></td>
    			<td align="left"><?=$val["Reference1"]?></td>
    			<td align="left"><?=$val["Reference2"]?></td>
    			<td align="left"><?=$val["Reference3"]?></td>
    			<td align="left"><?=$val["Reference4"]?></td>
    		</tr>
    	<? 
    		}
    	} ?>
    </table>
    <!------------->
    </div>
    <div style="height:70px; background-image: url('http://www.ds80years.com/uploads/register/register-ds.jpg');">
    	
    </div>
	<form id="form_register" role="form" class="form" method="POST" action="index.php?module=/home/home/register_save">
        	<div class="form-group">
            	<label for="">ชื่อ <span class="required">*</span></label>
                <input class="form-control" name="FirstName" value="<?=$data['FirstName']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">นามสกุล <span class="required">*</span></label>
                <input class="form-control" name="SurName" value="<?=$data['SurName']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">ชื่อ(เดิม)</label>
                <input class="form-control" name="OldFirstName" value="<?=$data['OldFirstName']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">นามสกุล(เดิม)</label>
                <input class="form-control" name="OldSurName" value="<?=$data['OldSurName']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">เลขประจำตัว</label>
                <input class="form-control" name="StdNumber" value="<?=$data['StdNumber']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">หมายเลขบัตรประชาชน <span class="required">*</span></label>
                <input class="form-control" name="IDCard" id="IDCard" value="<?=$data['IDCard']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">ข้อมูลเกี่ยวกับปีที่เข้าเรียน</label>
				<select class="form-control" name="EduID">
					<option value="">-----เลือก-----</option>
				<? 
				if(count($EduLevel)>0){
					foreach($EduLevel as $val){
				?>
					<option value="<?=$val["EduID"]?>" <? if($val["EduID"]==$data["EduID"]){ ?> selected <? } ?>><?=$val["EduName"]?></option>
				<? 
					}
				} ?>
				</select>
            </div>
			<div class="form-group">
            	<label for="">ปีที่เข้า</label>
                <input class="form-control" name="YearStart" value="<?=$data['YearStart']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">ปีที่จบ</label>
                <input class="form-control" name="YearEnd" value="<?=$data['YearEnd']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">รุ่น </label>
				<select class="form-control" name="GenID" id="GenID">
					<option value="">-----เลือก-----</option>
				<? 
				if(count($generation)>0){
					foreach($generation as $val){
				?>
					<option value="<?=$val["GenID"]?>" <? if($val["GenID"]==$data["GenID"]){ ?> selected <? } ?>><?=$val["GenCode"]?>(<?=$val["YearStart"]?> - <?=$val["YearEnd"]?>)</option>
				<? 
					}
				} ?>
				</select>
				<a href="#info" rel="facebox">คลิกเพื่อดูตารางเทียบรุ่น</a>
            </div>
			<div style="border-top-style: solid; border-top-width: 1px; border-top-color: #e4e4e4; padding-top: 5px; padding-bottom: 10px;">
				<b><i><u>ที่อยู่ปัจจุบัน (ที่สามารถส่งไปรษณีย์ถึง)</u></i></b>
			</div>
			<div class="form-group">
            	<label for="">ห้องเลขที่</label>
                <input class="form-control" name="RoomNo" value="<?=$data['RoomNo']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">ห้องชุดที่</label>
                <input class="form-control" name="ApartmentNo" value="<?=$data['ApartmentNo']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">อาคาร</label>
                <input class="form-control" name="Building" value="<?=$data['Building']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">ชั้น</label>
                <input class="form-control" name="Class" value="<?=$data['Class']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">บ้านเลขที่</label>
                <input class="form-control" name="HouseNumber" value="<?=$data['HouseNumber']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">หมู่บ้าน</label>
                <input class="form-control" name="Village" value="<?=$data['Village']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">ม.</label>
                <input class="form-control" name="Swine" value="<?=$data['Swine']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">ซอย</label>
                <input class="form-control" name="Alley" value="<?=$data['Alley']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">ถนน</label>
                <input class="form-control" name="Road" value="<?=$data['Road']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">จังหวัด</label>
                <select class="form-control" name="Province" id="Province">
					<option value="">-----เลือก-----</option>
				<? 
				if(count($Province)>0){
					foreach($Province as $val){
				?>
					<option value="<?=$val["PROVINCE_ID"]?>" <? if($val["PROVINCE_ID"]==$data["Province"]){ ?> selected <? } ?>><?=$val["PROVINCE_NAME"]?></option>
				<? 
					}
				} ?>
				</select>
            </div>
			<div class="form-group">
            	<label for="">อำเภอ/เขต </label>
                <select class="form-control" name="County" id="County" value="<?=$data['']?>">
					<option value="">-----เลือก-----</option>
					<?
					if(count($amphur)>0){
						foreach($amphur as $val){
					?>
						<option value="<?=$val["AMPHUR_ID"]?>" <? if($data["County"]==$val["AMPHUR_ID"]){ ?> selected <? } ?>><?=$val["AMPHUR_NAME"]?></option>
					<?		
						}
					}
					?>
				</select>
            </div>
			<div class="form-group">
            	<label for="">ตำบล/แขวง </label>
				<select class="form-control" name="District" id="District" value="<?=$data['']?>">
					<option value="">-----เลือก-----</option>
					<?
					if(count($district)>0){
						foreach($district as $val){
					?>
						<option value="<?=$val["DISTRICT_ID"]?>" <? if($data["District"]==$val["DISTRICT_ID"]){ ?> selected <? } ?>><?=$val["DISTRICT_NAME"]?></option>
					<?		
						}
					}
					?>
				</select>
            </div>
			<div class="form-group">
            	<label for="">รหัสไปรษณีย์</label>
                <input class="form-control" name="Zip" value="<?=$data['Zip']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">ที่อยู่ต่างประเทศ</label>
                <input class="form-control" name="Overseas" value="<?=$data['Overseas']?>" placeholder="" type="text">
            </div>
			<div style="border-top-style: solid; border-top-width: 1px; border-top-color: #e4e4e4; padding-top: 5px; padding-bottom: 10px;">
				<b><i><u>การติดต่อ</u></i></b>
			</div>
			<div class="form-group">
            	<label for="">เบอร์โทรศัพท์</label>
                <input class="form-control" name="Tel" value="<?=$data['Tel']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">เบอร์์มือถือ</label>
                <input class="form-control" name="Mobile" value="<?=$data['Mobile']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">E-mail</label>
                <input class="form-control" name="Email" value="<?=$data['Email']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">FACEBOOK NAME</label>
                <input class="form-control" name="Facebook" value="<?=$data['Facebook']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">LINE ID</label>
                <input class="form-control" name="LineID" value="<?=$data['LineID']?>" placeholder="" type="text">
            </div>
           <div class="form-group">
            	<label for="">&nbsp;</label>
            	<input type="submit" value="ลงทะเบียน"/>
            </div>
	</form>
	
<script>
$(window).load(function() {
   $("#Province").change(function(){
		$('#County').empty();
		html = '<option value="">-----เลือก-----</option>';
		$.ajax({
			type: "POST",
			url: "index.php?module=/ajax/ajax/getAmphur",
			cache: false,
			dataType: "json",
			data: "province_id="+$(this).val(),
			success: function(data){
					
					if (data === undefined || data === null) {
						
					}else{
						$.each(data, function(i, item) {
    						//alert(item.Idair);
    						html += '<option value="'+item.AMPHUR_ID+'">'+item.AMPHUR_NAME+'</option>';
						});
					}
					
					$('#County').append(html);
			}
		});
	});
	
	
	$("#County").change(function(){
		$('#District').empty();
		//alert($(this).val());
		html = '<option value="">-----เลือก-----</option>';
		$.ajax({
			type: "POST",
			url: "index.php?module=/ajax/ajax/getDistrict",
			cache: false,
			dataType: "json",
			data: "amphur_id="+$(this).val(),
			success: function(data){
					
					if (data === undefined || data === null) {
						
					}else{
						$.each(data, function(i, item) {
    						//alert(item.Idair);
    						html += '<option value="'+item.DISTRICT_CODE+'">'+item.DISTRICT_NAME+'</option>';
						});
					}
					
					$('#District').append(html);
			}
		});
	});

	$("#form_register").validate({
		rules: {
    		FirstName: "required",
    		SurName: "required",
    		IDCard: "required",
    		Email: {
      			email: true
    		}
  		 },
  		submitHandler: function(form) {
    		
    		if(checkNationalID($("#IDCard").val())==true){
				form.submit();
			}else{
				alert('หมายเลขบัตรประชาชนไม่ถูกต้อง');
			}	
  		}
	});
	
	$('a[rel*=facebox]').facebox({
		loadingImage : '<?=theme_url('default')?>/resources/facebox/src/loading.gif',
      	closeImage   : '<?=theme_url('default')?>/resources/facebox/src/closelabel.png'
	});
});

function checkNationalID(id) {
	if(id.length != 13) return false;
	for(i=0, sum=0; i < 12; i++) sum += parseFloat(id.charAt(i))*(13-i);
	if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false;
	return true;
}

function select_generation(ID){
	//alert(ID);
	$("#GenID").val(ID);
}

</script>