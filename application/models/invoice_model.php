<?php

class Invoice_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->model('dataWrapper_dto');
	}

	function getAllInvoiceSummary() {
		$dataWrapper = new $this->dataWrapper_dto();
		$sql = 'SELECT id, 
				invoice_code, 
				billing_name, 
				billing_address, 
				customer_id, 
				billing_phone, 
				billing_email, 
				location_id, 
				state, 
				created_by, 
				created_date 
				FROM pos_invoice 
				ORDER BY created_date asc';
		$query = $this->db->query($sql);
		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function getInvoiceById($id) {
		$dataWrapper = new $this->dataWrapper_dto();
		$sql = 'SELECT id, 
				invoice_code, 
				billing_name, 
				billing_address, 
				customer_id, 
				billing_phone, 
				billing_email, 
				location_id, 
				state, 
				created_by, 
				created_date 
				FROM pos_invoice 
				WHERE id=?';
		$query = $this->db->query($sql, array($id));
		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function addInvoice($data) {
		$success = true;
		try {
			$this->db->trans_start();
			$this->db->set('created_date', 'now()', FALSE);
			$this->db->insert('pos_invoice', $data);
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			error_log($e->getMessage());
			$success = false;
		}
		$response = array('success' => $success);
		return $response;
	}

	function updateInvoice($data) {
		$this->db->set('updated_date', 'now()', FALSE);
		$this->db->insert('pos_invoice', $data);
		$response = array('success' => true);
		return $response;
	}

}

?>