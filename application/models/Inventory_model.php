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
		$sql = 'SELECT ps.id,ps.stock_code, ps.harga_beli, pp.id as product_id, pb.id as brand_id, pp.product_code, pp.name as product_name, pb.name as brand_name,
				ps.stock-(select COALESCE(sum(pid.quantity),0) from pos_invoice_detail pid
				JOIN pos_invoice pi ON pi.id=pid.invoice_id
				WHERE pid.product_id=ps.product_id
				AND pid.location_id=ps.location_id
				AND pi.state in (0,1) ) as stock,
				ps.harga_bengkel,
				ps.harga_dist_area,
				ps.harga_dealer,
				ps.harga_retail,
				pw.id as  warehouse_id,
				pw.name as location_name FROM pos_stock ps
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

	function getAllStockSummaryFilter() {
		$dataWrapper = new $this->dataWrapper_dto();
		$sql = 'SELECT ps.id,ps.stock_code, pp.id as product_id, pb.id as brand_id, pp.product_code, pp.name as product_name, pb.name as brand_name,
				ps.stock-(select COALESCE(sum(pid.quantity),0) from pos_invoice_detail pid
				JOIN pos_invoice pi ON pi.id=pid.invoice_id
				WHERE pid.product_id=ps.product_id
				AND pi.location_id=ps.location_id
				AND pi.state in (0,1)) as stock,
				ps.harga_bengkel,
				ps.harga_dist_area,
				ps.harga_dealer,
				ps.harga_retail,
				pw.id as  warehouse_id,
				pw.name as location_name FROM pos_stock ps
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

	function getPriceByProductIdAndLocationId($id, $locationId) {
		$sql = 'SELECT ps.id,
		ps.harga_beli,ps.harga_bengkel,ps.harga_dealer,ps.harga_dist_area, ps.harga_retail, pw.name as location_name, pw.id as location_id  FROM pos_stock ps
		JOIN pos_warehouse pw ON pw.id = ps.location_id
				WHERE
					ps.product_id=? and ps.location_id=? and ps.active=true';
		$query = $this->db->query($sql, array($id, $locationId));
		return $query->result();
	}

	function getProduct($id) {
		$sql = 'SELECT ps.id,ps.stock_code, pp.id as product_id, pb.id as brand_id, pp.product_code, pp.name as product_name, pb.name as brand_name,
				ps.stock-(select COALESCE(sum(pid.quantity),0) from pos_invoice_detail pid
				JOIN pos_invoice pi ON pi.id=pid.invoice_id
				WHERE pid.product_id=ps.product_id and pi.state in (0,1)) as stock, ps.harga_bengkel, ps.harga_dist_area, ps.harga_dealer, ps.harga_retail, pw.id as  warehouse_id,
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
		$sql = 'SELECT ps.id, pp.name as product_name, pw.name as warehouse_name FROM pos_stock ps
		JOIN pos_product pp ON pp.id=ps.product_id
		JOIN pos_warehouse pw ON pw.id=ps.location_id
		WHERE ps.product_id=? and ps.location_id=? and ps.active=true';
		$query = $this->db->query($sql, array($productId, $locationId));
		return $query->row();
	}

	function getAvailableQuantity($id) {
		$sql = 'SELECT ps.stock-(select COALESCE(sum(pid.quantity),0) from pos_invoice_detail pid
		JOIN pos_invoice pi ON pi.id=pid.invoice_id
		WHERE pid.product_id=ps.product_id and pi.state in (0,1)) as stock
		FROM pos_stock ps
		JOIN pos_product pp ON pp.id=ps.product_id
		JOIN pos_warehouse pw ON pw.id=ps.location_id
		JOIN pos_brand pb ON pb.id=pp.brand_id
		WHERE ps.active=true and ps.id=' . $id;
		$query = $this->db->query($sql);
		return $query->row();
	}

	function modifyStock($data, $operand, $operationName, $username) {
		$success = true;
		try {
			$this->db->trans_start();
			$productId = intval($data['product_id']);
			$locationId = intval($data['location_id']);
			$stockAdded = $data['stock'];
			if(isset($data['harga_beli'])){
				$hargaBeli = str_replace(",", "", $data['harga_beli']);	
				$data['harga_beli'] = $hargaBeli;
			} 
			if(isset($data['harga_bengkel'])){
				$hargaBengkel = str_replace(",", "", $data['harga_bengkel']);
				$data['harga_bengkel'] = $hargaBengkel;
			}
			if(isset($data['harga_dist_area'])){
				$hargaDistArea = str_replace(",", "", $data['harga_dist_area']);
				$data['harga_dist_area'] = $hargaDistArea;
			}
			if(isset($data['harga_retail'])){
				$hargaRetail = str_replace(",", "", $data['harga_retail']);
				$data['harga_retail'] = $hargaRetail;
			}
			if(isset($data['harga_dealer'])){
				$hargaDealer = str_replace(",", "", $data['harga_dealer']);
				$data['harga_dealer'] = $hargaDealer;
			} 

			if ($operand != '+') {
				$stockAdded = $stockAdded * (-1);
			}

			$row = $this->getStockByProductIdAndLocationId($productId, $locationId);
			if ($row == null) {
				$this->db->set('stock_code', 'getCounterSequence(4)', FALSE);
				$this->db->set('created_date', 'now()', FALSE);
				$this->db->set('created_by', "'" . $username . "'", FALSE);
				$this->db->insert('pos_stock', $data);
				$row = $this->getStockByProductIdAndLocationId($productId, $locationId);
				$this->history_stock_model->addHistory($row->id, $stockAdded, $operationName, $username);
			} else {
				$stockId = $row->id;
				error_log("UPDATE NOW " . $stockId);

				if (!isset($data['harga_bengkel'])) {
					$sqlUpdateStock = "UPDATE pos_stock SET
					stock=(SELECT * FROM (SELECT SUM(stock) FROM pos_stock WHERE id=?) AS X)+? ,
					updated_date=now(),
					updated_by=?
					WHERE id = ?";
					$this->db->query($sqlUpdateStock, array(
						$stockId,
						$stockAdded,
						$username,
						$stockId,
					)

					);

				} else {
					$availableBefore = $this->getAvailableQuantity($stockId);
					$sqlUpdateStock = "UPDATE pos_stock SET
					stock=(SELECT * FROM (SELECT SUM(stock) FROM pos_stock WHERE id=?) AS X)+? ,
					updated_date=now(),
					harga_beli=?,
					harga_bengkel=?,
					harga_dist_area=?,
					harga_retail=?,
					harga_dealer=?,
					updated_by=?
					WHERE id = ?";
					$this->db->query($sqlUpdateStock, array(
						$stockId,
						$stockAdded,
						$hargaBeli,
						$hargaBengkel,
						$hargaDistArea,
						$hargaRetail,
						$hargaDealer,
						$username,
						$stockId,
					)

					);
				}
				error_log($this->db->affected_rows());
				$resultFinal = $this->getAvailableQuantity($stockId);
				if ($resultFinal->stock < 0) {
					throw new Exception('Stock cannot min');
				}
				//$resultDiff = intval($resultFinal->stock)-intval($availableBefore->stock);

				$this->history_stock_model->addHistory($stockId, $stockAdded, $operationName, $username);
			}
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			error_log('Error Modify ' . $e->getMessage());
			throw new Exception($e->getMessage());
		}

		$response = array(
			'success' => $success,
		);
		return $response;
	}

	function addStock($data, $operationName, $username) {
		$result = $this->modifyStock($data, '+', $operationName, $username);
		$response = array(
			'success' => $result['success'],
		);
		return $response;
	}

	function decreaseStock($data, $operationName, $username) {
		$result = $this->modifyStock($data, '-', $operationName, $username);
		$response = array(
			'success' => $result['success'],
		);
		return $response;
	}

	function updateStock($data, $username) {
		error_log("UPDATED");
		$resultAvailable = $this->getAvailableQuantity($data['id']);
		$difference = intval($data['stock']) - intval($resultAvailable->stock);
		$data['stock'] = $difference;
		$modifyStockResult = $this->modifyStock($data, '+', 'updateStock', $username);
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
