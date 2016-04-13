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

	public function getInvoiceHeaderAndItemByInvoiceId(){
	header('Content-Type: application/json');
		$response = $this->invoice_model->getInvoiceHeaderAndItemByInvoiceId($_GET['id']);
		echo json_encode($response);	
	}

	public function finalizeInvoice(){
		header('Content-Type: application/json');
		$response = $this->invoice_model->finalizeInvoice($_GET['id'],$_GET['finalizeDate']);
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
		$username = $this->getUsername();
		$response = $this->invoice_model->addInvoice($data, $username);
		echo json_encode($response);

	}

	public function updateInvoice(){
		header('Content-Type: application/json');
		$data = json_decode($_POST['invoice']);
		$headerId = $_POST['headerId'];
		error_log("headerId ".$headerId);
		$response = $this->invoice_model->updateInvoice($data, $headerId);
		echo json_encode($response);

	}

}
