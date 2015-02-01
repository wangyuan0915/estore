<!DOCTYPE html>

<html>
	<head>
		<style>
			input { display: block;}
		</style>
	</head> 
<body>  

<h2>New Customer Sign Up</h2>

<?php 
    echo validation_errors();
	echo form_open('customers/signup');
    echo form_label('Firstname'); 
	echo form_input('firstname', "", 'required');
    echo "<br/>";
    
    echo form_label('Lastname');
	echo form_input('lastname', "", 'required');
	echo "<br/>";
	
	
	echo "Once you create your account, you cannot change your username again.<br/><br/>";
	echo form_label('Username'); 
	echo form_input('username', "", 'required');
	echo "<br/>";
	
	echo form_label('Password'); 
	echo form_password('password', "", 'required');
	

	//pattern="[_0-9a-zA-Z]{6}[-_0-9a-zA-Z]*" onchange="form.passcf.pattern = this.value;"');
	echo "<br/>";


    echo form_label('Password Confirm'); 
	echo form_password('passcf', "", 'required');
	echo "<br/>";

	echo form_label('Email');
    //echo '<input type="email" name="email" value="" required />';
    echo form_input('email', "", 'required');
	
    echo "<br/>";
	echo form_submit('submit', 'Confirm');
	echo form_close();
    
    echo "<br/>";
    echo anchor('customers/login', 'Login') . "<br/><br/>";
    echo anchor('store/index', 'Back');

?>

</body>

</html>