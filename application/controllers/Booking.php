<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->checkSession();
		$this->load->model("booking_model");
	}

	public function getListBookingByStockId() {
		header('Content-Type: application/json');
		$response = $this->booking_model->getListBookingByStockId($_GET['stock_id']);
		echo json_encode($response);
	}

	public function addBooking() {
		header('Content-Type: application/json');
		$data = array(
			'quantity' => $_POST['quantity'],
			'notes' => $_POST['notes'],
			'stock_id' => $_POST['stock_id'],
			'created_by' => $this->getUsername(),
		);
		$response = $this->booking_model->addBooking($data);
		echo json_encode($response);
	}

	public function deactiveBooking() {
		$id = $_GET['id'];
		$stockId = $_GET['stockId'];
		header('Content-Type: application/json');
		$response = $this->booking_model->deactiveBooking($id, $stockId);
		echo json_encode($response);
	}
}
