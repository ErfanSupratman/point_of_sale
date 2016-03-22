<?php
class DataWrapper {
	public $data = "";
}
class Inventory_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	function getAllInventory() {
		$this->db->from ( "pos_stock" );
		return $this->db->get ();
	}
	function getAllStockSummary() {
		$dataWrapper = new DataWrapper ();
		$sql = 'SELECT ps.id, pp.id as product_id, pb.id as brand_id, pp.product_code, pp.name as product_name, pb.name as brand_name,
				ps.stock, ps.harga_bengkel, ps.harga_dist_area, ps.harga_dealer, ps.harga_retail, pw.id as  warehouse_id,
				pw.name as location_name   FROM pos_stock ps
				JOIN pos_product pp ON pp.id=ps.product_id
				JOIN pos_warehouse pw ON pw.id=ps.location_id
				JOIN pos_brand pb ON pb.id=pp.brand_id
				WHERE
					ps.active=true ORDER BY lower(pp.name) asc';
		$query = $this->db->query ( $sql );
		// Fetch the result array from the result object and return it
		
		$dataWrapper->data = $query->result ();
		return $dataWrapper;
	}
	function getProduct($id) {
	}
	function addStock($data) {
		$this->db->set ( 'stock_code', 'getCounterSequence(4)', FALSE );
		$this->db->set ( 'created_date', 'now()', FALSE );
		$this->db->insert ( 'pos_stock', $data );
		$response = array (
				'success' => true 
		);
		return $response;
	}
	function updateProduct($data, $id) {
		$this->db->set ( 'updated_date', 'now()', FALSE );
		$this->db->update ( 'pos_stock', $data, "id = " . $id );
		$response = array (
				'success' => true 
		);
		return $response;
	}
	function deactiveStock($id) {
		$data = array (
				'active' => false 
		);
		$this->db->set ( 'updated_date', 'now()', FALSE );
		$this->db->update ( 'pos_stock', $data, "id = " . $id );
		$response = array (
				'success' => true 
		);
		return $response;
	}
}

?>