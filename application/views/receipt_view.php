<h2>Receipt Page</h2>
<h3>Thanks for your shopping, <?php echo $_SESSION['customer']->login; ?>!</h3>


<?php
	ini_set('display_errors', 'On');
	
	$cart = $this->cart->contents();
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
	}
		
	echo "<tr>";
	echo "<td colspan='3'><strong>Total</strong></td>";
	echo "<td>" . $this->cart->total()  . "</td>";

	echo "</tr>"; 

	echo "</table>";

	
	$receipt = "<table><tr><th>Name</th><th>Price</th><th>Quantity</th><th>Total</th></tr>";
	foreach($cart as $item){
        $receipt = $receipt . '<tr><td>' . $item['name'] . '</td><td>' . $item['price'] . 
        '</td><td>' . $item['qty'] . '</td><td>' . $item['subtotal'] . '</td></tr>';
        }
            

        $receipt = $receipt . '<tr>';
        $receipt = $receipt . '<td colspan="3"><strong>Total</strong></td>';
        $receipt = $receipt . '<td>' . $this->cart->total() . '</td>';
        $receipt = $receipt . '</tr></table>';


        $this->load->library('email');
        $this->email->from('g3naiver@gmail.com', 'Estore');
        $this->email->to($_SESSION['customer']->email); 
        $this->email->subject('Estore Reciept');
        $this->email->message('<html><body><h2>Thanks for you purchasing,' . 
        $_SESSION['customer']->login . '! here is your receipt.</h2>' . 
        $receipt . '</body></html>'); 
        $this->email->send();

    //print_r($receipt);
    

    echo '<form><input type=button value="Print Reciept" onClick="writeReciept()"></form>';
	
?>
   	<script language="JavaScript">
	<!--
	function writeReciept() {
 	top.wRef=window.open('','myconsole',
  	'width=500,height=450,left=10,top=10'
   	+',menubar=1'
   	+',toolbar=0'
   	+',status=1'
   	+',scrollbars=1'
   	+',resizable=1');
   
   	top.wRef.document.writeln(
  	'<html><head><title>Reciept</title></head>'
 	+'<body bgcolor=white onLoad=\"self.focus()\">'
 	+'<center><a href=# onclick=\"window.print();return false;\">Print</a>'
 	+'<table border=0 cellspacing=3 cellpadding=3>');
 
	top.wRef.document.writeln('<br/>');
	var reci = '<?=$receipt?>';


	top.wRef.document.writeln(reci);

 	
 	top.wRef.document.close()}

 	//-->
 	</script>
<?php

	$this->cart->destroy();

	//back to customer home page
 	echo anchor('customers/index', 'Home');

?>