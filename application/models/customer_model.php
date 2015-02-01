<?php
class Customer_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('customers');
		return $query->result('Customer');
	}  
	
	function get($login,$password)
	{
		$query = $this->db->get_where('customers',array('login' => $login, 'password' => $password));
		
		if($query->num_rows() > 0){
			//return $query->row(0,'Customer');
			//return 1;
			return $query->row(0,'Customer');
		}
		
		return -1;
	}


	function get_id($id)
	{
		$query = $this->db->get_where('customers',array('id'=> $id));
		
			//return $query->row(0,'Customer');
			//return 1;
		return $query->row(0,'Customer');
	}
		

	
	function delete($id) {
		return $this->db->delete("customers",array('id' => $id ));
	}

	function deleteall() {
		$sql = "delete from customers";
		return $this->db->query($sql);
	}
	
	function insert($customer) {
		return $this->db->insert("customers", array('first' => $customer->first,
				                                  'last' => $customer->last,
											      'login' => $customer->login,
												  'password' => $customer->password,
												  'email' => $customer->email));
	}
	 
	function update($customer) {
		$this->db->where("login", $customer->login);
		return $this->db->update("customers", array('first' => $customer->first,
				                                  'last' => $customer->last,
												  'password' => $customer->password,
												  'email' => $customer->email));
	}
}		
?>
