<?php
$title = "ข้อมูลศิษย์เก่า";
$action = "add";

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
    	<h3 class="box-title">ค้นหา</h3>
  	</div><!-- /.box-header -->
    <!-------------------------------------------------------->
	<form role="form" method="GET">
		<input type="hidden" name="module" value="/administrator/alumni/index"/>
		<div class="box-body">
        	<div class="form-group">
            	<label for="">ชื่อ</label>
                <input class="form-control" name="FirstName" value="<?=$_GET['FirstName']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">นามสกุล</label>
                <input class="form-control" name="SurName" value="<?=$_GET['SurName']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">หมายเลขบัตรประชาชน</label>
                <input class="form-control" name="IDCard" value="<?=$_GET['IDCard']?>" placeholder="" type="text">
            </div>
			<div class="form-group">
            	<label for="">รุ่น </label>
				<select class="form-control" name="GenID">
					<option value="">-----เลือก-----</option>
				<? 
				if(count($generation)>0){
					foreach($generation as $val){
				?>
					<option value="<?=$val["GenID"]?>" <? if($val["GenID"]==$_GET["GenID"]){ ?> selected <? } ?>><?=$val["GenCode"]?>(<?=$val["YearStart"]?> - <?=$val["YearEnd"]?>)</option>
				<? 
					}
				} ?>
				</select>
            </div>
		</div>
		<div class="box-footer">
        	<button type="submit" class="btn btn-primary">ค้นหา</button>
        </div>
	</form>
	<!-------------------------------------------------------->	
</div>

<!-------------------------------------------------------------->
<div class="box box-solid box-default">
	<div class="box-header with-border">
    	<h3 class="box-title"><?=$title?></h3>
  	</div><!-- /.box-header -->
  	<div class="box-body">
    <!-------------------------------------------------------->
	<?=$table?>
	<!-------------------------------------------------------->	
  	</div><!-- /.box-body -->
</div>
<!---------------------------End------------------------------>
</section><!-- /.content -->
