<?php
class DataWrapper {
	public $data = "";
}

class Brand_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function getAllBrand() {
		$this->db->from("pos_brand");
		return $this->db->get();
	}

	function getAllBrandSummary() {
		$dataWrapper = new DataWrapper();
		$sql = 'SELECT pb.id, pb.brand_code, pb.name, pb.active FROM pos_brand pb WHERE
					pb.active=true ORDER BY lower(pb.name) asc';
		$query = $this->db->query($sql);
		// Fetch the result array from the result object and return it

		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function getBrandBy($name) {
		if ($name == null) {
			throw new Exception("Brand name cannot empty!");
		}
		$sql = 'SELECT * FROM pos_brand WHERE lower(name) = lower(?) AND active = true';
		$query = $this->db->query($sql, array(trim($name)));
		return $query->row();
	}

	function addBrand($data) {
		$success = true;
		$error = "";
		try {
			$this->db->trans_start();

			$brand = $this->getBrandBy($data['name']);

			if ($brand != null) {
				throw new Exception("Brand already exists!");
			}

			$this->db->set('brand_code', 'getCounterSequence(2)', FALSE);
			$this->db->insert('pos_brand', $data);
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$success = false;
			$error = $e->getMessage();
		}

		$response = array('success' => $success, 'error' => $error);
		return $response;
	}

	function updateBrand($data, $id) {

		$success = true;
		$error = "";
		try {
			$this->db->trans_start();

			$brand = $this->getBrandBy($data['name']);

			if ($brand != null) {
				if ($brand->id != $id) {
					throw new Exception("Brand already exists!");
				}
			}

			$this->db->update('pos_brand', $data, "id = " . $id);
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$success = false;
			$error = $e->getMessage();
		}

		$response = array('success' => $success, 'error' => $error);
		return $response;
	}

	function deactiveBrand($id) {
		$data = array(
			'active' => false,
		);
		$this->db->update('pos_brand', $data, "id = " . $id);
		$response = array('success' => true);
		return $response;
	}
}

?>
