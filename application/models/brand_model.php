<?php
	class DataWrapper {
		public $data = 	"";
	}

	class Brand_model extends CI_Model  {
		
		function __construct() 
		{ 
			parent::__construct(); 
		} 
		
		function getAllBrand() 
		{
			$this->db->from("pos_brand");
			return $this->db->get();
		}
		
		function getAllBrandSummary() 
		{
			$dataWrapper = new DataWrapper();
			$sql = 'SELECT pb.id, pb.brand_code, pb.name, pb.active FROM pos_brand pb WHERE 
					pb.active=true ORDER BY lower(pb.name) asc';
			$query = $this->db->query($sql);
			// Fetch the result array from the result object and return it
			
			$dataWrapper->data = $query->result();
			return $dataWrapper;
		}

		function getBrand($id)
		{
			
		}

		function addBrand($data)
		{
			$this->db->set('brand_code', 'getCounterSequence(2)', FALSE);
			$this->db->insert('pos_brand', $data); 
			$response = array( 'success' => true);
			return $response;
		}

		function updateBrand($data,$id)
		{
			$this->db->update('pos_brand', $data, "id = ".$id);
			$response = array( 'success' => true);
			return $response;
		}

		function deactiveBrand($id)
		{
			$data = array(
               'active' => false
            );
			$this->db->update('pos_brand', $data, "id = ".$id);
			$response = array( 'success' => true);
			return $response;
		}
	}

?>