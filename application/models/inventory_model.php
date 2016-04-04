<?php
class Inventory_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model( 'dataWrapper_dto' );
	}
	function getAllInventory() {
		$this->db->from ( "pos_stock" );
		return $this->db->get ();
	}
	function getAllStockSummary() {
		$dataWrapper = new $this->dataWrapper_dto();
		$sql = 'SELECT ps.id,ps.stock_code, pp.id as product_id, pb.id as brand_id, pp.product_code, pp.name as product_name, pb.name as brand_name,
				ps.stock-(select COALESCE(sum(pbo.quantity),0) as quantity FROM pos_booking pbo WHERE pbo.active=true and pbo.stock_id=ps.id) as stock, ps.harga_bengkel, ps.harga_dist_area, ps.harga_dealer, ps.harga_retail, pw.id as  warehouse_id,
				pw.name as location_name   FROM pos_stock ps
				JOIN pos_product pp ON pp.id=ps.product_id
				JOIN pos_warehouse pw ON pw.id=ps.location_id
				JOIN pos_brand pb ON pb.id=pp.brand_id
				WHERE
					ps.active=true ORDER BY lower(pp.name) asc, lower(ps.stock_code) asc';
		$query = $this->db->query ( $sql );
		// Fetch the result array from the result object and return it

		$dataWrapper->data = $query->result ();
		return $dataWrapper;
	}

	function getProduct( $id ) {
		$sql = 'SELECT ps.id,ps.stock_code, pp.id as product_id, pb.id as brand_id, pp.product_code, pp.name as product_name, pb.name as brand_name,
				ps.stock-(select COALESCE(sum(pbo.quantity),0) as quantity FROM pos_booking pbo WHERE pbo.active=true and pbo.stock_id=ps.id) as stock, ps.harga_bengkel, ps.harga_dist_area, ps.harga_dealer, ps.harga_retail, pw.id as  warehouse_id,
				pw.name as location_name   FROM pos_stock ps
				JOIN pos_product pp ON pp.id=ps.product_id
				JOIN pos_warehouse pw ON pw.id=ps.location_id
				JOIN pos_brand pb ON pb.id=pp.brand_id
				WHERE
					ps.active=true and ps.id='.$id;
		$query = $this->db->query ( $sql );
		return $query->result ();
	}

	function getStockByProductIdAndLocationId( $productId, $locationId ) {
		$sql = 'SELECT id FROM pos_stock WHERE product_id=? and location_id=? and active=true';
		$query = $this->db->query ( $sql, array( $productId, $locationId ) );
		return $query->result ();
	}

	function getAvailableQuantity( $id ) {
		$sql = 'SELECT ps.stock-(select COALESCE(sum(pbo.quantity),0) as quantity FROM pos_booking pbo WHERE pbo.active=true and pbo.stock_id=ps.id) as stock
				FROM pos_stock ps
				JOIN pos_product pp ON pp.id=ps.product_id
				JOIN pos_warehouse pw ON pw.id=ps.location_id
				JOIN pos_brand pb ON pb.id=pp.brand_id
				WHERE
					ps.active=true and ps.id='.$id;
		$query = $this->db->query ( $sql );
		return $query->result ();
	}

	function addStock( $data ) {
		error_log( $data['product_id'].' '.$data['location_id'] );
		$productId = intval( $data['product_id'] );
		$locationId = intval( $data['location_id'] );
		$stockAdded = intval( $data['stock'] );
		$hargaBeli = $data['harga_beli'];
		$hargaBengkel = $data['harga_bengkel'];
		$hargaDistArea = $data['harga_dist_area'];
		$hargaRetail = $data['harga_retail'];
		$hargaDealer = $data['harga_dealer'];
		$result  = $this->getStockByProductIdAndLocationId( $productId, $locationId );
		if ( $result==null ) {
			$this->db->set ( 'stock_code', 'getCounterSequence(4)', FALSE );
			$this->db->set ( 'created_date', 'now()', FALSE );
			$this->db->insert ( 'pos_stock', $data );
		}else {
			$stockId = $result[0]->id;
			$sql = "UPDATE pos_stock SET
					stock=(SELECT * FROM (SELECT SUM(stock) FROM pos_stock WHERE id=?) AS X)+? ,
					updated_date=now(),
					harga_beli=?,
					harga_bengkel=?,
					harga_dist_area=?,
					harga_retail=?,
					harga_dealer=?
					WHERE id = ?";
			$this->db->query( $sql, array(
					$stockId,
					$stockAdded,
					$hargaBeli,
					$hargaBengkel,
					$hargaDistArea,
					$hargaRetail,
					$hargaDealer,
					$stockId
				)
			);
		}

		$response = array (
			'success' => true
		);
		return $response;
	}
	function updateProduct( $data, $id ) {
		$this->db->set ( 'updated_date', 'now()', FALSE );
		$this->db->update ( 'pos_stock', $data, "id = " . $id );
		$response = array (
			'success' => true
		);
		return $response;
	}
	function deactiveStock( $id ) {
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
