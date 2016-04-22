<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 function __construct(){
		parent::__construct();
		$this->load->model("brand_model");
	}
	
	public function index()
	{
		$data['permissions'] = $this->getUserPagePermissions();
		$data['inventory_content'] = '';
		$this->load->view('inventory/brand',$data);
	}
	
	public function getAllBrand(){
		header('Content-Type: application/json');
		$response = $this->brand_model->getAllBrandSummary();
		echo json_encode($response);
	}
	
	public function updateBrand(){
		header('Content-Type: application/json');
		
		$data = array(
				'name' => $_POST['brand_name'],
				'updated_date' => 'now()'
			  );
		
		$response = $this->brand_model->updateBrand($data, $_GET['id']);
		echo json_encode($response);
	}

	public function addBrand(){
		header('Content-Type: application/json');
		$data = array(
				'name' => $_POST['brand_name'],
				'created_date' => 'now()'
			  );
		$response = $this->brand_model->addBrand($data);
		echo json_encode($response);
	}
	
	public function deactiveBrand(){
		$id = $_GET['id'];
		header('Content-Type: application/json');
		$response = $this->brand_model->deactiveBrand($id);
		echo json_encode($response);
	}
}
