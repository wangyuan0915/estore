<h2>Customer Entry For Admin</h2>
<?php 
	echo "<p>" . anchor('store/Admin','Back') . "</p>";

	echo "<p> Username = " . $customer->login . "</p>";
	echo "<p> Firstname = " . $customer->first . "</p>";
	echo "<p> Lastname = " . $customer->last . "</p>";
	echo "<p> email = " . $customer->email . "</p>";
	//echo "<p><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px'/></p>";
		
?>	
