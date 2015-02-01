<?php

class Store extends CI_Controller {
     
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	
	    	
	    	$config['upload_path'] = './images/product/';
	    	$config['allowed_types'] = 'gif|jpg|png';
/*	    	$config['max_size'] = '100';
	    	$config['max_width'] = '1024';
	    	$config['max_height'] = '768';

*/
	    	   	
	    	$this->load->library('upload', $config);
    }

    function index() {
    		ini_set('display_errors', 'On');
    		session_start();
    		$this->load->model('product_model');
    		$products = $this->product_model->getAll();
    		$data['products']=$products;
    		//$this->load->view('product/list.php',$data);
    		//if ($this->session->userdata) {
    			# code...
    		//}
    		//if($_SESSION['admin'] && $_SESSION['admin'] == True) {
    			//redirect('product/list.php',"refresh");
    		//}

    		
    		$this->load->view('login.php');

    }
    
    

    function newForm() {
	    	$this->load->view('product/newForm.php');
    }
    
	function create() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[products.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		$fileUploadSuccess = $this->upload->do_upload();
		
		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');

			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];
			
			$this->product_model->insert($product);

			//Then we redirect to the index page again
			redirect('store/Admin', 'refresh');
		}
		else {
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$this->load->view('product/newForm.php',$data);
				return;
			}
			
			$this->load->view('product/newForm.php');
		}	
	}
	
	function read($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/read.php',$data);
	}

	function read_co($id) {
		$this->load->model('customer_model');
		$customer = $this->customer_model->get_id($id);
		$data['customer']=$customer;
		$this->load->view('readco_view.php',$data);
	}

	function read_order($order_id){
		$this->load->model('order_item_model');
		$order_items = $this->order_item_model->getid($order_id);
		$data['order_items']=$order_items;
		//print_r($order_items);
		##
    	$data['order_items']=$order_items;
		$this->load->view('readorder_view.php',$data);
		//unset($_SESSION['order_items']);
	}
	
	function editForm($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/editForm.php',$data);
	}
	
	function update($id) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		if ($this->form_validation->run() == true) {
			$product = new Product();
			$product->id = $id;
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$this->load->model('product_model');
			$this->product_model->update($product);
			//Then we redirect to the index page again
			redirect('store/Admin', 'refresh');
		}
		
		else {
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;
			$this->load->view('product/editForm.php',$data);
		}
	}
	
	function Login(){
		//session_start();
		ini_set('display_errors', 'On');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == true) {
			
			$this->load->model('customer_model');
			$customer = $this->customer_model->get($this->input->get_post('username'), 
			$this->input->get_post('password'));
			//admin module			

			if ($this->input->get_post('username') == 'admin' && 
			$this->input->get_post('password') == 'admin'){
                session_start();
                $_SESSION['admin'] = TRUE;
               	redirect('store/Admin', 'refresh');
		 	}

		 	//exactly no customers
		 	elseif ($customer === -1) {
		 		# code...
		 		echo "Username and Password do not match.<br/>";
		 		echo "<br/>";
		 		echo anchor('store/Login', 'Try Again');
		 	}

		 	//customer module
		 	else{
		 		session_start();
		 		$_SESSION['customer'] = $customer;
		 		redirect('customers/index',"refresh");
		 		//echo "lalala";
		 	}
		 }

		 else{
		 	$this->load->view('login.php','refresh');
		 }
	}
	

	function Admin(){
		ini_set('display_errors', 'On');
    	session_start();
    	$this->load->model('product_model');
    	$products = $this->product_model->getAll();
    	$data['products']=$products;
    	
    	$this->load->model('customer_model');
    	$customers = $this->customer_model->getAll();
    	$data['customers'] = $customers;


    	$this->load->model('order_model');
    	$orders = $this->order_model->getAll();
    	$data['orders'] = $orders;
    	$this->load->view('product/list.php',$data);
	}

	//for admin & customer log out
	function logout(){
		session_start();
		session_destroy();

		redirect('store/index','refresh');
	}

    	
	function delete($id) {
		$this->load->model('product_model');
		
		if (isset($id)) 
			$this->product_model->delete($id);
		
		//Then we redirect to the index page again
		redirect('store/Admin', 'refresh');
	}

	
	//just delete the customer haven't delete their order
	function delete_co($id) {
		$this->load->model('customer_model');

		if(isset($id))
		{
			$this->customer_model->delete($id);
		}	
		redirect('store/Admin', 'refresh');
	}


	function deleteall() {
		$this->load->model('customer_model');
		$this->load->model('order_model');
		$this->load->model('order_item_model');

		$this->order_model->deleteall();
		$this->order_item_model->deleteall();
		$this->customer_model->deleteall();

		redirect('store/Admin', 'refresh');
	}

}
?>
