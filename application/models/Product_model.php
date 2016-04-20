<?php
class DataWrapper {
	public $data = "";
}
class Product_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function getAllProduct() {
		$this->db->from("pos_product");
		return $this->db->get();
	}

	function getAllProductSummary() {
		$dataWrapper = new DataWrapper();
		$sql = 'SELECT pp.id, pp.product_code, pp.name, pp.active, pb.name as brand_name, pp.brand_id FROM pos_product pp JOIN pos_brand pb ON pb.id=pp.brand_id WHERE
					pp.active=true ORDER BY lower(pp.name) asc';
		$query = $this->db->query($sql);
		// Fetch the result array from the result object and return it

		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function findProductByNameLike($name) {
		$dataWrapper = new DataWrapper();
		$sql = 'SELECT pp.id, pp.product_code, pp.name, pp.active, pb.name as brand_name, pp.brand_id FROM pos_product pp JOIN pos_brand pb ON pb.id=pp.brand_id WHERE
					pp.active=true and lower(pp.name) like lower("%' . $name . '%") ORDER BY lower(pp.name) asc';
		$query = $this->db->query($sql);
		// Fetch the result array from the result object and return it

		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function findProductByBrandIdNoWrapper($brandId) {
		$sql = 'SELECT pp.id, pp.product_code, pp.name, pp.active, pb.name as brand_name, pp.brand_id FROM pos_product pp JOIN pos_brand pb ON pb.id=pp.brand_id WHERE
					pp.active=true and pp.brand_id=' . $brandId . ' ORDER BY lower(pp.name) asc';
		$query = $this->db->query($sql);
		// Fetch the result array from the result object and return it
		return $query->result();
	}

	function getProductByName($name, $brandId) {
		if ($name == null || $brandId == null) {
			throw new Exception("Name or brand cannot empty!");
		}
		$sql = 'SELECT * FROM pos_product WHERE lower(name) =lower(?) and brand_id=? and active=true';
		$query = $this->db->query($sql, array($name, $brandId));
		return $query->row();
	}

	function addProduct($data) {
		$success = true;
		$error = "";
		try {
			$this->db->trans_start();
			$product = $this->getProductByName($data['name'], $data['brand_id']);

			if ($product == null) {
				$this->db->set('product_code', 'getCounterSequence(3)', FALSE);
				$this->db->set('created_date', 'now()', FALSE);
				$this->db->insert('pos_product', $data);
			} else {
				throw new Exception("Cannot Insert, Product already exists!");
			}
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$error = $e->getMessage();
			$success = false;
		}

		$response = array('success' => $success, 'error' => $error);
		return $response;
	}

	function updateProduct($data, $id) {
		$success = true;
		$error = "";
		try {
			$this->db->trans_start();

			$product = $this->getProductByName($data['name'], $data['brand_id']);
			
			if ($product != null) {
				if ($product->id != $id) {
					throw new Exception("Cannot Update, Product already exists!");
				}
			}

			$this->db->set('updated_date', 'now()', FALSE);
			$this->db->update('pos_product', $data, "id = " . $id);
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$success = false;
			$error = $e->getMessage();
		}

		$response = array('success' => $success, 'error' => $error);
		return $response;
	}

	function deactiveProduct($id) {
		$data = array(
			'active' => false,
		);
		$this->db->update('pos_product', $data, "id = " . $id);
		$response = array(
			'success' => true,
		);
		return $response;
	}
}

?>
