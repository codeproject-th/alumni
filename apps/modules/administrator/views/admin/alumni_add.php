<?php
$title = "เพิ่มข้อมูลศิษย์เก่า";
$action = "add";

if($id!=''){
	$title = "แก้ไขข้อมูลศิษย์เก่า";
	$action = "edit";
	$data = module::model('models:alumni')->get($id);
	$address = module::model('models:alumni_address')->select(array('alumni_id'=>$id));
	if(count($address)>0){
		foreach($address[0] as $key => $val){
			$data[$key] = $val;
		}
	}
	//print_r($data);
	$amphur = module::model('models:amphur')->select(array('PROVINCE_ID'=>$data["Province"]),'*','ORDER BY CONVERT( AMPHUR_NAME USING tis620 ) ASC');
	$district = module::model('models:district')->select(array('AMPHUR_ID'=>$data["County"]),'*','ORDER BY CONVERT( DISTRICT_NAME USING tis620 ) ASC');
}

$EduLevel = module::model('models:education_level')->select();
$Province = module::model('models:province')->select(array(),'*','ORDER BY CONVERT( PROVINCE_NAME USING tis620 ) ASC');
$generation =  module::model('models:generation')->select(array(),'*','ORDER BY YearStart ASC');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>ศิษย์เก่า<small></small></h1>
    <ol class="breadcrumb">
    	<li><a href="index.php?module=/administrator/admin/index"><i class="fa fa-dashboard"></i> Main</a></li>
        <li class="active">ศิษย์เก่า</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Your Page Content Here -->
<!---------------------------Start------------------------------>
<div class="box box-solid box-default">
	<div class="box-header with-border">
    	<h3 class="box-title"><?=$title?></h3>
  	</div><!-- /.box-header -->
  	<div class="box-body">
	<? if($save == true){ ?>
	 <div class="alert alert-success alert-dismissible">
     	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        บันทึกข้อมูลเรียบร้อย
     </div>
	<? } ?>
	<? if(count($error)>0){ ?>
	<div class="alert alert-danger alert-dismissible">
     	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?
		foreach($error as $val){
			echo $val.'<br>';
		}
		?>
     </div>
	<? } ?>
    <!-------------------------------------------------------->
	<form role="form" method="POST">
		<div class="box-body">
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
                <input class="form-control" name="IDCard" value="<?=$data['IDCard']?>" placeholder="" type="text">
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
				<select class="form-control" name="GenID">
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
        </div>
         <!-- /.box-body -->
        <div class="box-footer">
        	<button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
        </div>
		<input type="hidden" name="action" value="<?=$action?>"/>
		<input type="hidden" name="id" value="<?=$data['alumni_id']?>"/>
	</form>
	<!-------------------------------------------------------->	
  	</div><!-- /.box-body -->
</div>
<!---------------------------End------------------------------>
</section><!-- /.content -->
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
	
});
</script>