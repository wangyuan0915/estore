<h2>Admin Page</h2>
<?php 
		

		//echo "<p>" . anchor('store/index','Home') . "</p>";
		echo "<p>" . anchor('store/newForm','Add New Product') . "</p>";

		echo "<p>" . anchor('store/logout','Logout') . "</p>";

 	  
		

		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				
			echo "<td>" . anchor("store/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
			echo "<td>" . anchor("store/editForm/$product->id",'Edit') . "</td>";
			echo "<td>" . anchor("store/read/$product->id",'View') . "</td>";
				
			echo "</tr>";
		}

		echo "</table><h3>Customer Info</h3><table>";
		echo "<tr><th>Userid</th><th>Username</th>";
		
		foreach ($customers as $customer) {
			echo "<tr>";
			echo "<td>" . $customer->id . "</td>";
			echo "<td>" . $customer->login . "</td>";
			echo "<td>" . anchor("store/read_co/$customer->id",'View Customer Info') . "</td>";
			echo "</tr>";
		}
		echo "</table><h3>Order Info</h3><table>";
		echo "<tr><th>Orderid</th><th>Customer id</th><th>Order date</th><th>Order time</th><th>Total</th>";
		

		foreach ($orders as $order) {
			echo "<tr>";
			echo "<td>" . $order->id . "</td>";
			echo "<td>" . $order->customer_id . "</td>";
			echo "<td>" . $order->order_date . "</td>";
			echo "<td>" . $order->order_time . "</td>";			
			echo "<td>$" . $order->total . "</td>";
			echo "<td>" . anchor("store/read_order/$order->id",'View Customer Info') . "</td>";
			echo "</tr>";
		}

		echo "</table>";
		?>
		<?php echo "<p>" . anchor('store/deleteall','Delete All orders and customers',"onClick='return confirm(\"Do you really want to delete all the customers and orders record?\");'") . "</p>";

?>	

