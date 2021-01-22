<?php
//theme_url('default');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title></title> 
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,200' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,500,600,700,900' rel='stylesheet' type='text/css'>	
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>		
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<link rel='stylesheet' id='wp-admin-css'  href='<?=theme_url('admin')?>/wp-admin/css/wp-admin.min.css?ver=3.8.10' type='text/css' media='all' />
	<link rel='stylesheet' id='colors-fresh-css'  href='<?=theme_url('admin')?>/wp-admin/css/colors.min.css?ver=3.8.10' type='text/css' media='all' />
	<link href="<?=theme_url('admin')?>/wp-admin/css/wp-admin.css"  type="text/css" rel="stylesheet">
	<link rel='stylesheet' id='buttons-css'  href='<?=theme_url('admin')?>/wp-includes/css/buttons.min.css?ver=3.8.10' type='text/css' media='all' />
</head>
<body class="login login-action-login wp-core-ui">
	<div id="login">
		<h1><img src="<?=theme_url('admin')?>/resources/images/logo.png"></h1>
		<form name="loginform" id="loginform" action="" method="post">
			<p>
				<label for="user_login">Username<br />
				<input type="text" name="username" id="user_login" class="input" value="" size="20" /></label>
			</p>
			<p>
				<label for="user_pass">Password<br />
				<input type="password" name="password" id="user_pass" class="input" value="" size="20" /></label>
			</p>
			<p class="forgetmenot">
				<? if($login=='NO'){ ?>
				<span style="color: #ff0000;"> User or Password is incorrect </span>
				<? } ?>
			</p>
			<p class="submit">
				<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In" />
				<input type="hidden" name="redirect_to" value="http://127.0.0.1/piyanas/wp-admin/" />
				<input type="hidden" name="testcookie" value="1" />
			</p>
		</form>
	</div>
	<div class="clear"></div>
</body>
</html>
	