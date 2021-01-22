<?php

$alumni_get = explode('-',$_GET['alumni']);
$alumni_data = module::model('models:alumni')->get($alumni_get[0]);
if(count($alumni_data)>0){
	$alumni_name = $alumni_data['alumni_id']."-".$alumni_data['FirstName']." ".$alumni_data['SurName'];
}


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
$party = module::model('models:party')->select(array(),'*','ORDER BY PartyDate DESC');
?>
<script src="<?=theme_url('admin')?>/resources/typeahead/dist/typeahead.bundle.js"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>โต๊ะจีน<small></small></h1>
    <ol class="breadcrumb">
    	<li><a href="index.php?module=/administrator/admin/index"><i class="fa fa-dashboard"></i> Main</a></li>
        <li class="active">การจัดงาน</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Your Page Content Here -->
<div class="box box-solid box-default">
	<div class="box-header with-border">
    	<h3 class="box-title">ค้นหา</h3>
  	</div><!-- /.box-header -->
    <!-------------------------------------------------------->
	<form role="form" method="GET" enctype="multipart/form-data">
		<input type="hidden" value="/administrator/party_table/index" name="module"/>
		<div class="box-body">
        	<div class="form-group">
            	<label for="">ชื่องาน</label>
				<select name="party_id" class="form-control">
					<option value="">-----เลือก-----</option>
					<?
					if(count($party)>0){
						foreach($party as $val){
					?>
					<option value="<?=$val['party_id']?>" <? if($_GET['party_id']==$val['party_id']){?>selected<?}?>><?=$val['PartyName']?></option>
					<?		
						}
					}
					?>
				</select>
            </div>
            <div class="form-group">
            	<label for="">รหัสโต๊ะ</label>
				<input class="form-control" name="PartyTableCode" value="<?=$_GET['PartyTableCode']?>" placeholder="" type="text">
            </div>
            <div class="form-group">
            	<label for="">สถานะ</label>
				<select class="form-control" name="status">
					<option value="">-----เลือก-----</option>
					<option value="0" <? if($_GET['status']=='0'){?>selected<?}?>>ว่าง</option>
					<option value="1" <? if($_GET['status']=='1'){?>selected<?}?>>จองแล้ว</option>
				</select>
            </div>
            <div class="form-group" style="">
            	<label for="">ผู้จอง</label>
    			<br>
				<input class="form-control" id="typeahead" style="width:300px; " name="alumni" value="<?=$_GET['alumni']?>" placeholder="" type="text">
            </div>
        </div>
         <!-- /.box-body -->
        <div class="box-footer">
        	<button type="submit" class="btn btn-primary">ค้นหา</button>
        </div>
	</form>
	<!-------------------------------------------------------->	
</div>
<!---------------------------Start------------------------------>
<div class="box box-solid box-default">
	<div class="box-header with-border">
    	<h3 class="box-title">โต๊ะจีน</h3>
  	</div><!-- /.box-header -->
  	<div class="box-body">
    <!-------------------------------------------------------->
	<form role="form" method="POST">
		<div class="box-body">
        	<?=$table?>
        </div>
         <!-- /.box-body -->
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