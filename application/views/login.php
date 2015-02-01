<!DOCTYPE html>
<html>
	<head>
		<style>
			input{
				display: block;
			}
		</style>
	</head>
<body>
	<h1>Welcome to estore!</h1>
<?php
	echo validation_errors();
	echo form_open('store/Login');
	echo form_label('Username'); 
	echo form_input('username',"",'required');
	echo form_label('Password');  
	echo form_password('password',"",'required'); 
	echo form_submit('submit', 'Comfirm'); 
	
	echo form_close();
	echo "<br/>";
	
	echo anchor('customers/signup', 'SignUp'). "<br/>";
	echo "<br/>";
	echo anchor('store/logout', 'Home');

?>
</body>
</html>