<?php
class Order_item_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('order_items');
		return $query->result('Order_item');
	}  
	
	function get($id)
	{
		$query = $this->db->get_where('order_items',array('id' => $id));
		
		return $query->row(0,'Order_item');
	}
	
	function delete($id) {
		return $this->db->delete("order_items",array('id' => $id ));
	}

	function deleteall() {
		$sql = "delete from order_items";
		return $this->db->query($sql);
	}
	
	function insert($order_item) {
		return $this->db->insert("order_items", array('id' => $order_item->id,
				                                  'order_id' => $order_item->order_id,
											      'product_id' => $order_item->product_id,
												  'quantity' => $order_item->quantity
												  ));
	}
	 
	function update($order_item) {
		$this->db->where('id', $order_item->id);
		return $this->db->update("order_items", array('id' => $order_item->id,
				                                  'order_id' => $order_item->order_id,
											      'product_id' => $order_item->product_id,
												  'quantity' => $order_item->quantity));
	}

	function getid($order_id){
		//$query = $this->db->get_where('order_items',array('order_id' => $order_id));
		//return $query->result_array();
		$sql = 'Select * from order_items a, products b where a.product_id
			= b.id and a.order_id = ?';

		return $this->db->query($sql,array($order_id))->result_array();

	}
}		
?>