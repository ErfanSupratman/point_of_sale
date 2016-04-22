<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Product extends MY_Controller {
	function __construct() {
		parent::__construct ();
		$this->checkSession();
		$this->load->model ( "product_model" );
	}
	public function index() {
		$data['permissions'] = $this->getUserPagePermissions();
		$data ['inventory_content'] = '';
		$this->load->view ( 'inventory/product', $data );
	}
	public function getAllProduct() {
		header ( 'Content-Type: application/json' );
		$response = $this->product_model->getAllProductSummary ();
		echo json_encode ( $response );
	}
	public function findProductByNameLike() {
		header ( 'Content-Type: application/json' );
		$response = $this->product_model->findProductByNameLike ( $_POST ['name'] );
		echo json_encode ( $response );
	}
	public function findProductByBrandId() {
		header ( 'Content-Type: application/json' );
		$response = $this->product_model->findProductByBrandIdNoWrapper ( $_GET ['brandId'] );
		echo json_encode ( $response );
	}
	public function updateProduct() {
		header ( 'Content-Type: application/json' );
		
		$data = array (
				'name' => $_POST ['name_new'],
				'brand_id' => $_POST ['brand_new'] 
		);
		
		$response = $this->product_model->updateProduct ( $data, $_GET ['id'] );
		echo json_encode ( $response );
	}
	public function addProduct() {
		header ( 'Content-Type: application/json' );
		$data = array (
				'name' => $_POST ['name_new'],
				'brand_id' => $_POST ['brand_new'] 
		);
		$response = $this->product_model->addProduct ( $data );
		echo json_encode ( $response );
	}
	public function deactiveProduct() {
		$id = $_GET ['id'];
		header ( 'Content-Type: application/json' );
		$response = $this->product_model->deactiveProduct ( $id );
		echo json_encode ( $response );
	}
}
