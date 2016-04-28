<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {

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
		$this->checkSession();
		$this->load->model("customer_model");
	}

	public function index()
	{
		$data['permissions'] = $this->getUserPagePermissions();
		$data['inventory_content'] = '';
		$this->load->view('management/customer',$data);
	}

	public function getAllCustomer(){
		header('Content-Type: application/json');
		$response = $this->customer_model->getAllCustomersSummary();
		echo json_encode($response);
	}
	
	public function updateCustomer(){
		header('Content-Type: application/json');
		
		$data = array(
				'nama' => $_POST['user_name_new'],
				'alamat' => $_POST['alamat_new'],
				'telepon' => $_POST['hp_new'],
				'email' => $_POST['email'],
				'pic' => $_POST['pic']
			  );
		
		$response = $this->customer_model->updateCustomer($data, $_GET['id']);
		echo json_encode($response);
	}

	public function addCustomer(){
		header('Content-Type: application/json');
		$data = array(
				'nama' => $_POST['user_name_new'],
				'alamat' => $_POST['alamat_new'],
				'telepon' => $_POST['hp_new'],
				'email' => $_POST['email'],
				'pic' => $_POST['pic']
			  );
		$response = $this->customer_model->addCustomer($data);
		echo json_encode($response);
	}
	
	public function deactiveCustomer(){
		$id = $_GET['id'];
		header('Content-Type: application/json');
		$response = $this->customer_model->deactiveCustomer($id);
		echo json_encode($response);
	}

	public function findByNamaLike(){
		header('Content-Type: application/json');
		$name = "";
		if(isset($_GET['nama'])){
			$name = $_GET['nama'];
		}
		$name = TRIM($name);
		$response = $this->customer_model->findByNamaLike($name);
		echo json_encode($response);
	}
}
