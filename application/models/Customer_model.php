<?php
	class DataWrapper {
		public $data = 	"";
	}

	class Customer_model extends CI_Model  {
		
		function __construct() 
		{ 
			parent::__construct(); 
		} 
		
		function getAllUsers() 
		{
			$this->db->from("pos_customer");
			return $this->db->get();
		}
		
		function getAllCustomersSummary() 
		{
			$dataWrapper = new DataWrapper();
			$sql = 'SELECT id, nama, telepon, alamat, customer_code, active FROM pos_customer WHERE active=true ORDER BY id desc';
			$query = $this->db->query($sql);
			$dataWrapper->data = $query->result();
			return $dataWrapper;
		}

		function getCustomer($id)
		{
			
		}

		function addCustomer($data)
		{
			$this->db->set('customer_code', 'getCounterSequence(1)', FALSE);
			$this->db->insert('pos_customer', $data);
			
			$response = array( 'success' => true);
			return $response;
		}

		function updateCustomer($data,$id)
		{
			$this->db->update('pos_customer', $data, "id = ".$id);
			$response = array( 'success' => true);
			return $response;
		}

		function deactiveCustomer($id)
		{
			$data = array(
               'active' => false
            );
			$this->db->update('pos_customer', $data, "id = ".$id);
			$response = array( 'success' => true);
			return $response;
		}
	}

?>
