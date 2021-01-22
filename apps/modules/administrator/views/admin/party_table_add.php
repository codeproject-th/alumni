<?php
$title = "เพิ่มข้อมูลโต๊ะจีน";
$action = "add";

if($id!=''){
	$title = "แก้ไขข้อมูลการจัดงาน";
	$action = "edit";
	$data = module::model('models:party')->get($id);
}
$party = module::model('models:party')->select(array(),'*','ORDER BY PartyDate DESC');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>การจัดงาน<small></small></h1>
    <ol class="breadcrumb">
    	<li><a href="index.php?module=/administrator/admin/index"><i class="fa fa-dashboard"></i> Main</a></li>
        <li class="active">การจัดงาน</li>
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
	
    <!-------------------------------------------------------->
	<form role="form" method="POST" enctype="multipart/form-data">
		<div class="box-body">
        	<div class="form-group">
            	<label for="">ชื่องาน <span class="required">*</span></label>
				<select name="party_id" class="form-control">
					<option value="">-----เลือก-----</option>
					<?
					if(count($party)>0){
						foreach($party as $val){
					?>
					<option value="<?=$val['party_id']?>"><?=$val['PartyName']?></option>
					<?		
						}
					}
					?>
				</select>
            </div>
			<div class="form-group">
            	<label for="">จำนวนที่นั้งต่อ 1 โต๊ะ <span class="required">*</span></label>
				<input class="form-control" name="PartyTableNumber" value="" placeholder="" type="text" required="">
            </div>
			<div class="form-group">
            	<label for="">อักษรภาษาอังกฤษ <span class="required">*</span></label>
				<input class="form-control" name="txt" value="" placeholder="" type="text" required="">
            </div>
			<div class="form-group">
            	<label for="">เริ่ม <span class="required">*</span></label>
				<input class="form-control" name="no_start" value="" placeholder="" type="text" required="">
            </div>
			<div class="form-group">
            	<label for="">สิ้นสุด <span class="required">*</span></label>
				<input class="form-control" name="no_end" value="" placeholder="" type="text" required="">
            </div>
			<div class="form-group">
            	<label for="">รายละเอียด</label>
				<input class="form-control" name="PartyTableDetail" value="" placeholder="" type="text">
            </div>
        </div>
         <!-- /.box-body -->
        <div class="box-footer">
        	<button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
        </div>
		<input type="hidden" name="action" value="<?=$action?>"/>
		<input type="hidden" name="id" value=""/>
	</form>
	<!-------------------------------------------------------->	
  	</div><!-- /.box-body -->
</div>
<!---------------------------End------------------------------>
</section><!-- /.content -->