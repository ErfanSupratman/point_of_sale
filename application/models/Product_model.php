<?php
class DataWrapper {
	public $data = "";
}
class Product_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	function getAllProduct() {
		$this->db->from ( "pos_product" );
		return $this->db->get ();
	}
	function getAllProductSummary() {
		$dataWrapper = new DataWrapper ();
		$sql = 'SELECT pp.id, pp.product_code, pp.name, pp.active, pb.name as brand_name, pp.brand_id FROM pos_product pp JOIN pos_brand pb ON pb.id=pp.brand_id WHERE
					pp.active=true ORDER BY lower(pp.name) asc';
		$query = $this->db->query ( $sql );
		// Fetch the result array from the result object and return it
		
		$dataWrapper->data = $query->result ();
		return $dataWrapper;
	}
	function findProductByNameLike($name) {
		$dataWrapper = new DataWrapper ();
		$sql = 'SELECT pp.id, pp.product_code, pp.name, pp.active, pb.name as brand_name, pp.brand_id FROM pos_product pp JOIN pos_brand pb ON pb.id=pp.brand_id WHERE
					pp.active=true and lower(pp.name) like lower("%' . $name . '%") ORDER BY lower(pp.name) asc';
		$query = $this->db->query ( $sql );
		// Fetch the result array from the result object and return it
		
		$dataWrapper->data = $query->result ();
		return $dataWrapper;
	}
	function findProductByBrandIdNoWrapper($brandId) {
		$sql = 'SELECT pp.id, pp.product_code, pp.name, pp.active, pb.name as brand_name, pp.brand_id FROM pos_product pp JOIN pos_brand pb ON pb.id=pp.brand_id WHERE
					pp.active=true and pp.brand_id=' . $brandId . ' ORDER BY lower(pp.name) asc';
		$query = $this->db->query ( $sql );
		// Fetch the result array from the result object and return it
		return $query->result ();
	}
	function getProduct($id) {
	}
	function addProduct($data) {
		$this->db->set ( 'product_code', 'getCounterSequence(3)', FALSE );
		$this->db->set ( 'created_date', 'now()', FALSE );
		$this->db->insert ( 'pos_product', $data );
		$response = array (
				'success' => true 
		);
		return $response;
	}
	function updateProduct($data, $id) {
		$this->db->set ( 'updated_date', 'now()', FALSE );
		$this->db->update ( 'pos_product', $data, "id = " . $id );
		$response = array (
				'success' => true 
		);
		return $response;
	}
	function deactiveProduct($id) {
		$data = array (
				'active' => false 
		);
		$this->db->update ( 'pos_product', $data, "id = " . $id );
		$response = array (
				'success' => true 
		);
		return $response;
	}
}

?>
