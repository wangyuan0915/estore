<h2>Customer Home Page</h2>
<h3>Welcome, <?php echo $_SESSION['customer']->login; ?>!</h3>

<?php
	ini_set('display_errors', 'On');


	//echo "<p>" . anchor('store/index','Home') . "</p>";
	echo "<p>" . anchor('customers/newForm','Update Profile') . "</p>";
	//echo "<p>" . anchor('customers/shopCart','Shopping Cart') . "</p>";

	

	echo "<table>";
	echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
	

	//need to work
	//echo form_open('cart/addtoCart');

	foreach ($products as $product) {
			echo form_open('customers/add');
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				
			
			echo "<td>" . anchor("customers/read/$product->id",'View') . "</td>";
			echo "<td><input type=number name=" . $product->id . " /></td>";
			
			echo "<td>" . form_hidden('id', $product->id) . "</td>";			
			echo "<td>" . form_submit('action', 'add/edit cart') . "</td>";
			//echo "<td>" . anchor("store/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
			//echo "<td>" . anchor("store/editForm/$product->id",'Edit') . "</td>";
			//echo "<td>" . anchor("store/read/$product->id",'View') . "</td>";
				
			echo form_close();
			echo "</tr>";
		}
	//endforeach;
	echo "</table>";
	
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
			echo "<td>" . anchor('customers/remove/'. $item['rowid'],'x') . "</td>";
			echo "</tr>";
			# code...
		}
		
		echo "<tr>";
		echo "<td colspan='3'><strong>Total</strong></td>";
		echo "<td>" . $this->cart->total()  . "</td>";

		echo "</tr>"; 

		echo "</table>";
	}

	echo "<p>" . anchor('customers/checkout','Checkout') . "</p>";
	echo "<p>" . anchor('customers/logout','Logout') . "</p>";

?>




