<h2>Customer Information Update Page</h2>

<h3>Welcome, <?php 
echo $_SESSION['customer']->login; ?> !</h3>

<?php
    echo validation_errors();
	
   
	echo form_open("customers/update");
    
   
    echo form_label('Firstname')."<br/>"; 	
	echo form_input('firstname',$customer->last,'required');   
    echo "<br/>";
	echo "<br/>";


    echo form_label('Lastname')."<br/>";
	echo form_input('lastname', $customer->last, 'required');
	echo "<br/>";
	echo "<br/>";
	
	echo form_label('Password')."<br/>"; 
	echo form_password('password', $customer->password, 'required');
	echo "<br/>";
	echo "<br/>";

	
	echo form_label('Email')."<br/>";
    //echo '<input type="email" name="email" value="' . $customer->email . '" required />';
    echo form_input('email', "", 'required');
	echo "<br/>";
	echo "<br/>";


	echo form_submit('submit', 'Submit');
	echo form_close();
    echo anchor('customers/index', 'Home');

?>





