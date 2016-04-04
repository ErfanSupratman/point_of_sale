<?php

class History_stock_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->model('dataWrapper_dto');
	}

	function getAllHistoryStockSummary() {
		$dataWrapper = new $this->dataWrapper_dto();
		$sql = 'SELECT phs.id, phs.stock_id, phs.stock_in, phs.stock_out, phs.created_date, phs.created_by FROM pos_history_stock phs ORDER BY phs.created_date asc';
		$query = $this->db->query($sql);
		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function getHistoryStockByStockId($stockId, $limit) {
		$dataWrapper = new $this->dataWrapper_dto();
		$sql = 'SELECT phs.id, phs.stock_id, phs.stock_in, phs.stock_out, phs.notes, phs.created_date, phs.created_by FROM pos_history_stock phs WHERE stock_id=? ORDER BY phs.created_date desc LIMIT ?';
		$query = $this->db->query($sql, array($stockId, $limit));
		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function addHistory($stockId, $stockChange, $notes) {
		if ($stockChange < 0) {
			$data = array(
				'stock_id' => $stockId,
				'stock_out' => abs($stockChange),
				'notes' => $notes,
			);
		} else {
			$data = array(
				'stock_id' => $stockId,
				'stock_in' => $stockChange,
				'notes' => $notes,
			);
		}

		$this->db->set('created_date', 'now()', FALSE);
		$this->db->insert('pos_history_stock', $data);
		$response = array('success' => true);
		return $response;
	}

}

?>