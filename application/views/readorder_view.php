<h2>Order Entry For Admin</h2>

<?php
	echo "<h3>Single Order Info</h3><table>";

	echo "<tr><th>Orderid</th><th>Product Name</th><th>Quantity</th><th>Unit Price</th><th>Subtotal</th>";
	foreach($order_items as $item){
		echo "<tr>";
		echo "<td>" .$item['order_id'] . "</td>";
		//echo $item['name']. "<br/>";
		echo "<td>" . $item['name'] . "</td>";
		// $this->load->model('product_model');
		// $pro = $this->product_model->get($item['product_id']);
		// echo $pro['name'];
		// echo $pro['price'];
		// foreach ($products as $pro) {
		// 	# code
		// 	if $pro['id'] == $item['']
		// }
		
		//echo $item['quantity']. "<br/>";
		echo "<td>" . $item['quantity'] . "</td>";		
		echo "<td>" . $item['price'] . "</td>";		
		echo "<td>" . $item['price']*$item['quantity'] . "</td>";				
	}

	echo "</table>";


	echo "<p>" . anchor('store/Admin','Back') . "</p>";
?>