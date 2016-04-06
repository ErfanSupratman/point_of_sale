<?php
class Inventory_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->model('dataWrapper_dto');
		$this->load->model('history_stock_model');
	}
	function getAllInventory() {
		$this->db->from("pos_stock");
		return $this->db->get();
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
		$query = $this->db->query($sql);
		// Fetch the result array from the result object and return it

		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function getPriceByProductIdAndLocationId($id,$locationId){
		$sql = 'SELECT ps.id,ps.harga_beli,ps.harga_bengkel,ps.harga_dealer,ps.harga_dist_area, ps.harga_retail  FROM pos_stock ps
				WHERE
					ps.product_id=? and ps.location_id=?';
		$query = $this->db->query($sql,array($id,$locationId));
		return $query->result();
	}

	function getProduct($id) {
		$sql = 'SELECT ps.id,ps.stock_code, pp.id as product_id, pb.id as brand_id, pp.product_code, pp.name as product_name, pb.name as brand_name,
				ps.stock-(select COALESCE(sum(pbo.quantity),0) as quantity FROM pos_booking pbo WHERE pbo.active=true and pbo.stock_id=ps.id) as stock, ps.harga_bengkel, ps.harga_dist_area, ps.harga_dealer, ps.harga_retail, pw.id as  warehouse_id,
				pw.name as location_name   FROM pos_stock ps
				JOIN pos_product pp ON pp.id=ps.product_id
				JOIN pos_warehouse pw ON pw.id=ps.location_id
				JOIN pos_brand pb ON pb.id=pp.brand_id
				WHERE
					ps.active=true and ps.id=' . $id;
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getStockByProductIdAndLocationId($productId, $locationId) {
		$sql = 'SELECT id FROM pos_stock WHERE product_id=? and location_id=? and active=true';
		$query = $this->db->query($sql, array($productId, $locationId));
		return $query->result();
	}

	function getAvailableQuantity($id) {
		$sql = 'SELECT ps.stock-(select COALESCE(sum(pbo.quantity),0) as quantity FROM pos_booking pbo WHERE pbo.active=true and pbo.stock_id=ps.id) as stock
				FROM pos_stock ps
				JOIN pos_product pp ON pp.id=ps.product_id
				JOIN pos_warehouse pw ON pw.id=ps.location_id
				JOIN pos_brand pb ON pb.id=pp.brand_id
				WHERE
					ps.active=true and ps.id=' . $id;
		$query = $this->db->query($sql);
		return $query->result();
	}

	function modifyStock($data, $operand, $operationName) {
		$success = true;
		try {
			$this->db->trans_start();
			$productId = intval($data['product_id']);
			$locationId = intval($data['location_id']);
			$stockAdded = intval($data['stock']);
			$hargaBeli = $data['harga_beli'];
			$hargaBengkel = $data['harga_bengkel'];
			$hargaDistArea = $data['harga_dist_area'];
			$hargaRetail = $data['harga_retail'];
			$hargaDealer = $data['harga_dealer'];

			if ($operand != '+') {
				$stockAdded = $stockAdded * (-1);
			}

			$result = $this->getStockByProductIdAndLocationId($productId, $locationId);
			if ($result == null) {
				$this->db->set('stock_code', 'getCounterSequence(4)', FALSE);
				$this->db->set('created_date', 'now()', FALSE);
				$this->db->insert('pos_stock', $data);
				$resultInsert = $this->getStockByProductIdAndLocationId($productId, $locationId);
				$this->history_stock_model->addHistory($resultInsert[0]->id, $stockAdded, $operationName);
			} else {
				$stockId = $result[0]->id;
				$sqlUpdateStock = "UPDATE pos_stock SET
					stock=(SELECT * FROM (SELECT SUM(stock) FROM pos_stock WHERE id=?) AS X)+? ,
					updated_date=now(),
					harga_beli=?,
					harga_bengkel=?,
					harga_dist_area=?,
					harga_retail=?,
					harga_dealer=?
					WHERE id = ?";
				$this->db->query($sqlUpdateStock, array(
					$stockId,
					$stockAdded,
					$hargaBeli,
					$hargaBengkel,
					$hargaDistArea,
					$hargaRetail,
					$hargaDealer,
					$stockId,
				)
				);
				$resultFinal = $this->getAvailableQuantity($stockId);
				if ($resultFinal[0]->stock < 0) {
					throw new Exception('Stock cannot min');
				}

				$this->history_stock_model->addHistory($stockId, $stockAdded, $operationName);
				
			}
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			error_log($e->getMessage());
			$success = false;
		}
		
		$response = array(
			'success' => $success,
		);
		return $response;
	}

	function addStock($data, $operationName) {
		$result = $this->modifyStock($data, '+', $operationName);
		$response = array(
			'success' => $result['success'],
		);
		return $response;
	}

	function decreaseStock($data, $operationName) {
		$result = $this->modifyStock($data, '-', $operationName);
		$response = array(
			'success' => $result['success'],
		);
		return $response;
	}

	function updateStock($data) {
		$resultAvailable = $this->getAvailableQuantity($data['id']);
		$difference = intval($data['stock']) - intval($resultAvailable[0]->stock);
		$data['stock'] = $difference;
		$modifyStockResult = $this->modifyStock($data, '+', 'updateStock');
		$response = array(
			'success' => $modifyStockResult['success'],
		);
		return $response;
	}

	function deactiveStock($id) {
		$data = array(
			'active' => false,
		);
		$this->db->set('updated_date', 'now()', FALSE);
		$this->db->update('pos_stock', $data, "id = " . $id);
		$response = array(
			'success' => true,
		);
		return $response;
	}
}

?>
