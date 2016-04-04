<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Inventory extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->checkSession();
		$this->load->model('inventory_model');
		$this->load->model('history_stock_model');
	}
	public function index() {
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['inventory_content'] = '';
		$this->load->view('inventory/inventory', $data);
	}
	public function create_po() {
		$data['inventory_content'] = $this->load->view('inventory/purchase_order_detail', NULL, TRUE);
		$this->load->view('inventory/inventory', $data);
	}
	public function getAllStock() {
		header('Content-Type: application/json');
		$response = $this->inventory_model->getAllStockSummary();
		echo json_encode($response);
	}
	public function updateStock() {
		header('Content-Type: application/json');

		$data = array(
			'product_id' => $_POST['product_id'],
			'location_id' => $_POST['lokasi'],
			'stock' => $_POST['jumlah'],
			'harga_beli' => $_POST['hargab'],
			'harga_bengkel' => $_POST['hargabe'],
			'harga_dist_area' => $_POST['hargada'],
			'harga_retail' => $_POST['hargare'],
			'harga_dealer' => $_POST['hargadl'],
			'id' => $_GET['id'],
		);

		$response = $this->inventory_model->updateStock($data);
		echo json_encode($response);
	}

	public function getHistoryStock() {
		header('Content-Type: application/json');
		$response = $this->history_stock_model->getHistoryStockByStockId($_GET['id'], 5);
		echo json_encode($response);
	}

	public function addStock() {
		header('Content-Type: application/json');
		$data = array(
			'product_id' => $_POST['product_id'],
			'location_id' => $_POST['lokasi'],
			'stock' => $_POST['jumlah'],
			'harga_beli' => $_POST['hargab'],
			'harga_bengkel' => $_POST['hargabe'],
			'harga_dist_area' => $_POST['hargada'],
			'harga_retail' => $_POST['hargare'],
			'harga_dealer' => $_POST['hargadl'],
		);
		$response = $this->inventory_model->addStock($data, 'addStock');
		echo json_encode($response);
	}
	public function deactiveStock() {
		$id = $_GET['id'];
		header('Content-Type: application/json');
		$response = $this->inventory_model->deactiveStock($id);
		echo json_encode($response);
	}
}
