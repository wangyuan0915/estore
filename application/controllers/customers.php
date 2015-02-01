<?php

/**
* 
*/
class Customers extends CI_Controller
{
	
	function __construct()
	{
		// Call the Controller constructor
	   	parent::__construct();
		# code...
	}

	function index()
	{
		ini_set('display_errors', 'On');
		session_start();
		$this->load->model('product_model');
    	$products = $this->product_model->getAll();
    	$data['products']=$products;
    	//print_r($data['products']);
    	$this->load->view('customer_view.php',$data);
	}


	function Signup()
	{
		ini_set('display_errors', 'On');
		$this->load->library('form_validation');
        $this->form_validation->set_rules('firstname','Firstname','required');
        $this->form_validation->set_rules('lastname','Lastname','required');
		$this->form_validation->set_rules('username','Username','required|is_unique[customers.login]');
		$this->form_validation->set_rules('password','Password','required|matches[passcf]|alpha_dash|min_length[6]');
		$this->form_validation->set_rules('passcf','Password Confirm','required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[customers.email]');
		
		if ($this->form_validation->run() == true) {
            $this->load->model('customer_model');
			$customer = new Customer();
			$customer->first = $this->input->get_post('firstname');
			$customer->last = $this->input->get_post('lastname');
            $customer->login = $this->input->get_post('username');
            $customer->password = $this->input->get_post('password');
            $customer->email = $this->input->get_post('email');
			$this->customer_model->insert($customer);


			redirect('store/index', 'refresh');
		}
		
		else {
			//echo "haha";
			$this->load->view('signup_view.php');
		}
	}

	function newForm(){
		ini_set('display_errors', 'On');
		session_start();
		$data['customer']=$_SESSION['customer'];
		$this->load->view('CustomereditForm_view.php',$data);

	}


	function update() {
		session_start();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('firstname','Firstname','required');
        $this->form_validation->set_rules('lastname','Lastname','required');
		$this->form_validation->set_rules('password','Password','required|alpha_dash|min_length[6]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');


		if ($this->form_validation->run() == true) {
			
			$customer = $_SESSION['customer'];
			$this->load->model('customer_model');

			$customer->first = $this->input->get_post('firstname');
			$customer->last = $this->input->get_post('lastname');
			$customer->password = $this->input->get_post('password');
			$customer->email = $this->input->get_post('email');
			

			$this->customer_model->update($customer);
			$customer = $this->customer_model->get($this->input->get_post('username'), $this->input->get_post('password'));

		
			redirect('customers/index', 'refresh');
		

		} else {
			$data['customer'] = $_SESSION['customer'];
			$this->load->view('CustomereditForm_view.php',$data);
		}
	}

	function read($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/csread_view.php',$data);
	}


	//update the cart
	function add() {
		$this->load->model('product_model');

		$product = $this->product_model->get($this->input->post('id'));

		$this->load->library('form_validation');

		$ids = array_column($this->cart->contents(),'qty','id');
		$this->form_validation->set_rules($product->id, $product->id,'integer');

		$qo = $this->input->get_post($product->id);

		

		//print_r(array_key_exists($this->input->post('id'), $ids));
		
		
		if (($key = array_key_exists($this->input->post('id'), $ids)) == NULL) 
		{
			if ($qo < 0){
				$qo = 0;
			}

		$insert = array('id' => $this->input->post('id'),
						'qty' => $qo,
						'price' => $product->price,
						'name' => $product->name);
		
		$this->cart->insert($insert);
		}

		else{
			
			$rowids = array_column($this->cart->contents(),'rowid', 'id');
			$rowid = $rowids[$this->input->post('id')];
			$q = $ids[$this->input->post('id')] + $qo;
			
			if ($q > 0){
			$this->cart->update(array(
				'rowid' => $rowid,
				'qty' => $q));
			}
			else{
				$this->cart->update(array(
				'rowid' => $rowid,
				'qty' => 0));
			}
			//print_r($q);
		}
		
		// print_r($this->cart->contents());
		// echo "<br>";
		// print_r($ids);
		// echo "<br>";
		// print_r($rowids);
		//$this->cart->insert($insert);
		redirect('customers/index');
	}

	//remove from cart
	function remove($rowid) {
		$this->cart->update(array(
				'rowid' => $rowid,
				'qty' => 0));

		redirect('customers/index');
	}

	function logout() {
		session_start();
		session_destroy();

		$this->cart->destroy();

		redirect('store/index','refresh');
	}

	function checkout(){
		session_start();
		$data['customer']=$_SESSION['customer'];
		$this->load->view('checkout_view.php',$data);
	}


	function order(){
		session_start();
		$data['customer']=$_SESSION['customer'];
		$this->load->library('form_validation');$this->form_validation->set_rules('credit'
		,'Credit Card Number','required|integer|exact_length[16]');
        $this->form_validation->set_rules('month','Expiry Month','required|integer|
        exact_length[2]|greater_than[0]|less_than[13]|callback__validate_expiry_month');
        $this->form_validation->set_rules('year','Expiry Year','required|integer|
        exact_length[2]|greater_than[' . (string)(((int)date('y'))-1) .']');
        if ($this->form_validation->run() == true) {
        	

        	if($cart = $this->cart->contents()) {
        	//order
        	$this->load->model('order_model');
        	$order = new Order();
        	$order->order_date = date("Y-m-d");
        	$order->order_time = date("H:i:s");
        	$order->customer_id = $_SESSION['customer']->id;
        	$order->total = $this->cart->total();
        	$order->creditcard_number = $this->input->get_post('credit');
            $order->creditcard_month = $this->input->get_post('month');
            $order->creditcard_year = $this->input->get_post('year');
			$this->order_model->insert($order);


			//order items
			$this->load->model('order_item_model');
			
			$order_id = $this->db->insert_id();
			foreach ($cart as $item) {
				# code...
				$order_item = new Order_item();
				$order_item->order_id = $order_id;
				$order_item->product_id = $item['id'];
				$order_item->quantity = $item['qty'];
				$this->order_item_model->insert($order_item);

			}

		
			$this->load->view("receipt_view.php",$data);


		

		} 
		

		// the shopping cart is empty
		else {
			$this->load->view("emptycart_view.php");
			}
       	
       	} 
   		
       	//original the page.
   		else{
   			$this->load->view("checkout_view.php",$data);
       }
	}
}
?>









