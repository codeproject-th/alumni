<?php
$title = "เพิ่มรุ่น";
$action = "add";

if($id!=''){
	$title = "แก้ไขรุ่น";
	$action = "edit";
	$data = module::model('models:generation')->get($id);
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>รุ่น<small></small></h1>
    <ol class="breadcrumb">
    	<li><a href="index.php?module=/administrator/admin/index"><i class="fa fa-dashboard"></i> Main</a></li>
        <li class="active">รุ่น</li>
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
	<form role="form" method="POST">
		<div class="box-body">
        	<div class="form-group">
            	<label for="">ปีการศึกษา <span class="required">*</span></label>
                <input class="form-control" name="YearStart" value="<?=$data['YearStart']?>" placeholder="" type="text" required="">
            </div>
            <div class="form-group">
                <label for="">ปีที่จบ <span class="required">*</span></label>
                <input class="form-control" name="YearEnd" value="<?=$data['YearEnd']?>" placeholder="" type="text" required="">
            </div>
			<div class="form-group">
                <label for="">รุ่นโรงเรียน</label>
                <input class="form-control" name="GenNO" value="<?=$data['GenNO']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
                <label for="">ชั้น ม.ศ.3</label>
                <input class="form-control" name="ThirdStudy" value="<?=$data['ThirdStudy']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
                <label for="">ปรับเป็น ม.3</label>
                <input class="form-control" name="M3" value="<?=$data['M3']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
                <label for="">ปีที่จบ ม.6</label>
                <input class="form-control" name="M6Year" value="<?=$data['M6Year']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
                <label for="">รุ่น ม.6</label>
                <input class="form-control" name="GenNOM6" value="<?=$data['GenNOM6']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
                <label for="">รุ่น D.S. <span class="required">*</span></label>
                <input class="form-control" name="GenCode" value="<?=$data['GenCode']?>" placeholder="" type="text" required="">
            </div>
			<div class="form-group">
                <label for="">พระสงฆ์</label>
                <input class="form-control" name="Reference1" value="<?=$data['Reference1']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
                <label for="">ครู</label>
                <input class="form-control" name="Reference2" value="<?=$data['Reference2']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
                <label for="">ประธานรุ่น</label>
                <input class="form-control" name="Reference3" value="<?=$data['Reference3']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
                <label for="">แกนนำรุ่น</label>
                <input class="form-control" name="Reference4" value="<?=$data['Reference4']?>" placeholder="" type="text">
            </div>
        </div>
         <!-- /.box-body -->
        <div class="box-footer">
        	<button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
        </div>
		<input type="hidden" name="action" value="<?=$action?>"/>
		<input type="hidden" name="id" value="<?=$data['GenID']?>"/>
	</form>
	<!-------------------------------------------------------->	
  	</div><!-- /.box-body -->
</div>
<!---------------------------End------------------------------>
</section><!-- /.content -->