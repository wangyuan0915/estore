<h2>The Shopping Cart is empty.</h2>
<h2>Please put items in the shopping cart and then check out.</h2>

<?php
	echo "<p>" . anchor('customers/index','Continue Shopping') . "</p>";
	echo "<p>" . anchor('customers/logout','Logout') . "</p>";
?>

