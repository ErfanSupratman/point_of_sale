<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Inventory extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'inventory_model' );
	}
	public function index() {
		$data ['inventory_content'] = '';
		$this->load->view ( 'inventory/inventory', $data );
	}
	public function create_po() {
		$data ['inventory_content'] = $this->load->view ( 'inventory/purchase_order_detail', NULL, TRUE );
		$this->load->view ( 'inventory/inventory', $data );
	}
	public function getAllStock() {
		header ( 'Content-Type: application/json' );
		$response = $this->inventory_model->getAllStockSummary ();
		echo json_encode ( $response );
	}
	public function updateStock() {
		header ( 'Content-Type: application/json' );
		
		$data = array (
				'name' => $_POST ['name_new'],
				'brand_id' => $_POST ['brand_new'] 
		);
		
		$response = $this->product_model->updateProduct ( $data, $_GET ['id'] );
		echo json_encode ( $response );
	}
	public function addStock() {
		header ( 'Content-Type: application/json' );
		$data = array (
				'product_id' => $_POST ['product_id'],
				'location_id' => $_POST ['lokasi'] 
		);
		$response = $this->inventory_model->addStock ( $data );
		echo json_encode ( $response );
	}
	public function deactiveStock() {
		$id = $_GET ['id'];
		header ( 'Content-Type: application/json' );
		$response = $this->inventory_model->deactiveStock ( $id );
		echo json_encode ( $response );
	}
}
