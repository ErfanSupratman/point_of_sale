<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->checkSession();
		$this->load->model('invoice_model');
	}

	public function index() {
		$data['inventory_content'] = '';
		$this->load->view('invoice/invoice', $data);
	}

	public function getAllInvoice(){
		header('Content-Type: application/json');
		$response = $this->invoice_model->getAllInvoiceSummary();
		echo json_encode($response);
	}

	public function getAllInvoiceByState(){
		header('Content-Type: application/json');
		$response = $this->invoice_model->getAllInvoiceByStateSummary($_GET['state']);
		echo json_encode($response);
	}

	public function countAllStates(){
		header('Content-Type: application/json');
		$response = $this->invoice_model->countState();
		echo json_encode($response);
	}

	public function addInvoice(){
		header('Content-Type: application/json');
		$data = json_decode($_POST['invoice']);
		$response = $this->invoice_model->addInvoice($data);
		echo json_encode($response);

	}

}
