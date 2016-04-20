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
		/*$deletePermission = false;
		$detailPermission = false;
		$showBuyPricePermission = false;
		$showPricePermission = false;*/

		$data['inventory_content'] = '';
		$this->load->view('inventory/inventory', $data);
	}
	public function getPriceByProductIdAndLocationId() {
		header('Content-Type: application/json');
		$response = $this->inventory_model->getPriceByProductIdAndLocationId($_GET['productId'], $_GET['locationId']);
		echo json_encode($response);
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

		$response = $this->inventory_model->updateStock($data, $this->getUsername());
		echo json_encode($response);
	}

	public function getHistoryStock() {
		header('Content-Type: application/json');
		$search = $_GET['search'];
		error_log($search['value']);
		$response = $this->history_stock_model->getHistoryStockByStockId(intval($_GET['draw']), $_GET['id'], intval($_GET['start']), intval($_GET['length']), $search['value']);
		echo json_encode($response);
	}

	function validateInputStock() {
		$error = "";
		if (!isset($_POST['product_id'])) {
			$error .= "Produk harus diisi, ";
		} else if ($_POST['product_id'] == "") {
			$error .= "Produk harus diisi, ";
		}
		if (!isset($_POST['lokasi'])) {
			$error .= "Lokasi harus diisi, ";
		}
		if (!isset($_POST['jumlah'])) {
			$error .= "Jumlah harus diisi, ";
		} else if ($_POST['jumlah'] == "") {
			$error .= "Jumlah harus diisi, ";
		}
		if (!isset($_POST['hargab'])) {
			$error .= "harga beli harus diisi, ";
		} else if ($_POST['hargab'] == "") {
			$error .= "harga beli harus diisi, ";
		}
		if (!isset($_POST['hargabe'])) {
			$error .= "harga cnt harus diisi, ";
		} else if ($_POST['hargabe'] == "") {
			$error .= "harga cnt harus diisi, ";
		}
		if (!isset($_POST['hargada'])) {
			$error .= "harga distributor harus diisi, ";
		} else if ($_POST['hargada'] == "") {
			$error .= "harga distributor harus diisi, ";
		}
		if (!isset($_POST['hargare'])) {
			$error .= "harga retail harus diisi, ";
		} else if ($_POST['hargare'] == "") {
			$error .= "harga retail harus diisi, ";
		}
		if (!isset($_POST['hargadl'])) {
			$error .= "harga dealer harus diisi, ";
		} else if ($_POST['hargadl'] == "") {
			$error .= "harga dealer harus diisi, ";
		}

		return $error;
	}

	public function addStock() {
		header('Content-Type: application/json');
		$error = $this->validateInputStock();
		if ($error == "") {
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

			$response = $this->inventory_model->addStock($data, 'addStock', $this->getUsername());
			echo json_encode($response);
		} else {
			$response = array('success' => false, 'error' => $error);
			echo json_encode($response);
		}

	}
	public function deactiveStock() {
		$id = $_GET['id'];
		header('Content-Type: application/json');
		$response = $this->inventory_model->deactiveStock($id);
		echo json_encode($response);
	}
}
