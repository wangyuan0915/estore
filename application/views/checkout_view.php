<!DOCTYPE html>
<html>
	<head>
		<style>
			input{
				display: block;
			}
		</style>
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		 <!--jq for the vaild month and year-->
		<script>
            function checkCdate() {
                if (parseInt($("#month").val()) < 1 || parseInt($("#month").val()) > 12) {
                    $("#validError").html("Invalid Month");
                    return false;
                }
                
                var this_year = parseInt(new Date().getFullYear().toString().substr(2, 2));
                if (parseInt($("#year").val()) < this_year) {
                    $("#validError").html("Invalid Year.");
                    return false;
                }
                
                if (parseInt($("#year").val()) == this_year && parseInt($("#month").val()) <= new Date().getMonth()) {
                    $("#validError").html("Credit Card Already Expired.");
                }
                return true;
            }
		</script>

	</head>
<body>
<h2>Customer Checkout Page</h2>
<h3>Welcome, <?php echo $_SESSION['customer']->login; ?>!</h3>


<?php
	if($cart = $this->cart->contents()){
		echo "<table>";
		//print_r($cart);
		echo "<caption>Shopping Cart</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>Name</th>";
		echo "<th>Price</th>";
		echo "<th>Quantity</th>";
		echo "<th>Total</th>";
		echo "</tr>";		
		echo "</thead>";
		
		foreach ($cart as $item) {
			echo "<tr>";
			echo "<td>" . $item['name'] . "</td>";
			echo "<td>" . $item['price'] . "</td>";
			echo "<td>" . $item['qty'] . "</td>";
			echo "<td>" . $item['subtotal'] . "</td>";
			echo "</tr>";
			# code...
		}
		
		echo "<tr>";
		echo "<td colspan='3'><strong>Total</strong></td>";
		echo "<td>" . $this->cart->total()  . "</td>";

		echo "</tr>"; 

		echo "</table>";
	}
?>
<br/>
<br/>

<?php 
	echo "<h2>Payment Information</h2>";
	echo validation_errors();

	echo form_open('customers/order', array('onsubmit'=>'return checkCdate();'));
	 echo "<p id='validError'><strong></strong><p>";

	echo form_label('Credit Card (16 digits)') ."<br/>"; 
	echo form_input('credit', "", 'id="credit" required pattern = [0-9]{16}')."<br/>";

	echo "<br/>";	
	echo form_label('Expiry Month (2 digits)')."<br/>";
	echo form_input('month', "", 'id="month" required pattern = [0-9]{2}')."<br/>";
	echo form_label('Expiry Year (2 digits)')."<br/>";
	echo form_input('year', "", 'id="year" required pattern = [0-9]{2}')."<br/><br/>";

	echo form_submit('action', 'Checkout')."<br/><br/>";

	//echo form_close();


	echo "<br/>";



	echo anchor('customers/index', 'Continue Shopping')."<br/>";
	echo "<br/>";
	echo anchor('customers/logout', 'Logout');
?>



</body>
</html>












