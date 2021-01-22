<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>ผู้ดูแลระบบ<small></small></h1>
    <ol class="breadcrumb">
    	<li><a href="index.php?module=/administrator/admin/index"><i class="fa fa-dashboard"></i> Main</a></li>
        <li class="active">Admin</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Your Page Content Here -->
<!---------------------------Start------------------------------>
<div class="box box-solid box-default">
	<div class="box-header with-border">
    	<h3 class="box-title">แก้ไขรหัสผ่าน</h3>
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
	<form role="form" method="POST" id="formChgPass">
		<div class="box-body">
        	<div class="form-group">
            	<label for="">รหัสผ่านใหม่ <span class="required">*</span></label>
                <input class="form-control" name="NewPassword" id="NewPassword" value="" placeholder="" type="password" required>
            </div>
			<div class="form-group">
            	<label for="">ยื่นยันรหัสผ่าน <span class="required">*</span></label>
                <input class="form-control" name="ConfirmPassword" id="ConfirmPassword" value="" placeholder="" type="password" required>
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
	$("#code").focus();
	$('#formChgPass').submit(function(){
		if($('#NewPassword').val()!=$('#ConfirmPassword').val()){
			alert('ยืนยันรหัสผ่านไม่ถูกต้อง');
			return false;
		}else{
			return true;
		}
		
	});
});
</script>