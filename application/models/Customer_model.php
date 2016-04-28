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
			$sql = 'SELECT id, nama, email, telepon, alamat, customer_code, active FROM pos_customer WHERE active=true ORDER BY id desc';
			$query = $this->db->query($sql);
			$dataWrapper->data = $query->result();
			return $dataWrapper;
		}

		function addCustomer($data)
		{
			$isExist = $this->findByHash(MD5($data['nama'].$data['alamat']));

			if($isExist!=null){
				$this->updateCustomer($data,$isExist->id);
			}else{
				$this->db->set('customer_code', 'getCounterSequence(1)', FALSE);
				$this->db->set('hash',"'".MD5($data['nama'].$data['alamat'])."'", FALSE);
				$this->db->insert('pos_customer', $data);
			}
			
			
			$response = array( 'success' => true);
			return $response;
		}

		function findByHash($hash){
			$sql = 'SELECT id, email, nama as name, telepon, alamat, customer_code, active FROM pos_customer WHERE lower(hash) like lower(?) AND active=true';
			$query = $this->db->query($sql, array($hash));
			$row = $query->row();

			return $row;
		}

		function findByNamaLike($nama){
			$dataWrapper = new DataWrapper();

			if(strlen($nama)>1){
				$sql = 'SELECT id, email, nama as name, telepon, alamat, customer_code, active FROM pos_customer WHERE lower(nama) like lower(?) AND active=true ORDER BY id desc';
				$query = $this->db->query($sql, array('%'.$nama.'%'));
				$dataWrapper->data = $query->result();
			}

			return $dataWrapper;
		}

		function updateCustomer($data,$id)
		{
			$this->db->set('hash',"'".MD5($data['nama'].$data['alamat'])."'", FALSE);
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
