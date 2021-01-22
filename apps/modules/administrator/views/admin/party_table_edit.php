<?php
$title = "เพิ่มข้อมูลโต๊ะจีน";
$action = "add";

if($id!=''){
	$title = "แก้ไขข้อมูลโต๊ะจีน";
	$action = "edit";
	$data = module::model('models:party_table')->get($id);
	$alumni_data = module::model('models:alumni')->get($data['alumni_id']);
}
$party = module::model('models:party')->select(array(),'*','ORDER BY PartyDate DESC');
$alumni = module::model('models:alumni')->select();
if(count($alumni)>0){
	$alumni_txt = '[';
	foreach($alumni as $key => $val){
		if($key==0){
			$alumni_txt .= '"'.$val['alumni_id'].'-'.$val['FirstName'].' '.$val['SurName'].'"';
		}else{
			$alumni_txt .= ',"'.$val['alumni_id'].'-'.$val['FirstName'].' '.$val['SurName'].'"';
		}
	}
	$alumni_txt .= ']';
}
?>
<script src="<?=theme_url('admin')?>/resources/typeahead/dist/typeahead.bundle.js"></script>
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
	<? if($error!=''){ ?>
	 <div class="alert alert-danger alert-dismissible">
     	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?=$error?>
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
					<option value="<?=$val['party_id']?>" <? if($data['party_id']==$val['party_id']){?>selected<?}?>><?=$val['PartyName']?></option>
					<?		
						}
					}
					?>
				</select>
            </div>
            <div class="form-group">
            	<label for="">รหัสโต๊ะ <span class="required">*</span></label>
				<input class="form-control" name="PartyTableCode" value="<?=$data['PartyTableCode']?>" placeholder="" type="text" required="">
            </div>
			<div class="form-group">
            	<label for="">จำนวนที่นั้งต่อ 1 โต๊ะ <span class="required">*</span></label>
				<input class="form-control" name="PartyTableNumber" value="<?=$data['PartyTableNumber']?>" placeholder="" type="text" required="">
            </div>
			<div class="form-group">
            	<label for="">รายละเอียด</label>
				<input class="form-control"  name="PartyTableDetail" value="<?=$data['PartyTableDetail']?>" placeholder="" type="text">
            </div>
            <div class="form-group">
            	<label for="">สถานะ</label>
				<select class="form-control" name="status">
					<option value="">-----เลือก-----</option>
					<option value="0" <? if($data['status']=='0'){?>selected<?}?>>ว่าง</option>
					<option value="1" <? if($data['status']=='1'){?>selected<?}?>>จองแล้ว</option>
				</select>
            </div>
            <div class="form-group" style="">
            	<label for="">ผู้จอง</label>
    			<br>
				<input class="form-control" id="typeahead" style="width:300px; " name="alumni" value="<?=$alumni_data['alumni_id']?>-<?=$alumni_data['FirstName']?> <?=$alumni_data['SurName']?>" placeholder="" type="text">
            </div>
        </div>
         <!-- /.box-body -->
        <div class="box-footer">
        	<button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
        </div>
		<input type="hidden" name="action" value="<?=$action?>"/>
		<input type="hidden" name="id" value="<?=$data['party_table_id']?>"/>
	</form>
	<!-------------------------------------------------------->	
  	</div><!-- /.box-body -->
</div>
<!---------------------------End------------------------------>
</section><!-- /.content -->
<script>
$(window).load(function() {
	
	var substringMatcher = function(strs) {
  	return function findMatches(q, cb) {
    var matches, substringRegex;
    // an array that will be populated with substring matches
    matches = [];
    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');
    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });

    cb(matches);
  };
};
	
	var states = <?=$alumni_txt?>;
	$('#typeahead').typeahead({
  			minLength: 1,
  			highlight: true,
  			classNames: {
    				input: 'form-control'
    			}
		},{
  			name: 'state',
  			source: substringMatcher(states)
	});
	
	$('#typeahead').bind('typeahead:select', function(ev, suggestion) {
		//alert('Selection: ' + suggestion);
	});
	
});
</script>
<style>
.typeahead,
.tt-query,
.tt-hint {
  width: 396px;
  height: 30px;
  padding: 8px 12px;
 
  line-height: 30px;
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}

.typeahead {
  background-color: #fff;
}

.typeahead:focus {
  border: 2px solid #0097cf;
}

.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
  color: #999
}

.tt-menu {
  width: 422px;
  margin: 12px 0;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.tt-suggestion {
  padding: 3px 20px;
  
  line-height: 24px;
}

.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}

.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;

}

.tt-suggestion p {
  margin: 0;
}

.gist {
  font-size: 14px;
}

</style>