<?php
$title = "เพิ่มข้อมูลการจัดงาน";
$action = "add";

if($id!=''){
	$title = "แก้ไขข้อมูลการจัดงาน";
	$action = "edit";
	$data = module::model('models:party')->get($id);
}

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
                <input class="form-control" name="PartyName" value="<?=$data['PartyName']?>" placeholder="" type="text" required>
            </div>
			<div class="form-group">
            	<label for="">วันที่จัด <span class="required">*</span></label>
                <input class="form-control" name="PartyDate" value="<?=date_th($data['PartyDate'])?>" placeholder="" type="text" required data-provide="datepicker" data-date-format="dd/mm/yyyy">
            </div>
			<div class="form-group">
            	<label for="">ราคาต่อ 1 โต๊ะ <span class="required">*</span></label>
                <input class="form-control" name="PartyPriceTable" value="<?=$data['PartyPriceTable']?>" placeholder="" type="text" required="">
            </div>
			<div class="form-group">
            	<label for="">ราคาต่อ 1 ที่นั่ง <span class="required">*</span></label>
                <input class="form-control" name="PartySeatPrices" value="<?=$data['PartySeatPrices']?>" placeholder="" type="text" required="">
            </div>
			<div class="form-group">
            	<label for="">ผังการจัดงาน </label>
                <input name="img" value="" placeholder="" type="file">
				<? if($data['PartyImg']!=''){ ?>
					<input type="checkbox" name="delete_img" value="1"/> ลบรูป <a href="./apps/data/images/<?=$data['PartyImg']?>" target="_blank"><?=$data['PartyImg']?></a>
				<? } ?>
            </div>
			<div class="form-group">
            	<label for="">การเปิดจอง </label>
				<br>
               	<input  type="checkbox" value="1" <? if($data['PartyStatus']=='1'){ ?> checked <? } ?> name="PartyStatus"/> ไม่เปิดจอง
            </div>
        </div>
         <!-- /.box-body -->
        <div class="box-footer">
        	<button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
        </div>
		<input type="hidden" name="action" value="<?=$action?>"/>
		<input type="hidden" name="id" value="<?=$data['party_id']?>"/>
		<input type="hidden" name="img_h" value="<?=$data['PartyImg']?>"/>
	</form>
	<!-------------------------------------------------------->	
  	</div><!-- /.box-body -->
</div>
<!---------------------------End------------------------------>
</section><!-- /.content -->