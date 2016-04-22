<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

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
		$this->load->model("invoice_model");
		$this->load->model('dataWrapper_dto');
	}
	
	public function index()
	{
		$data['permissions'] = $this->getUserPagePermissions();
		$this->load->view('report/report',$data);
	}

	public function getIncomeReport(){
		$isValid = true;
		$error = "";

		if(!isset($_GET['startDate'])){
			$error = "startDate must be defined! ";
			$isValid = false;
		}

		if(!isset($_GET['endDate'])){
			$error .= "endDate must be defined! ";
			$isValid = false;
		}


		
		$dataWrapper = new $this->dataWrapper_dto();

		if($isValid){
			$startDate = $_GET['startDate'];
			$endDate = $_GET['endDate'];
			$dataWrapper->data = $this->invoice_model->invoiceIncomeReport($startDate,$endDate);
			$dataWrapper->recordsTotal = $this->invoice_model->countTotalByState(2,$startDate,$endDate);
			echo json_encode($dataWrapper);
		} else{
			echo json_encode($dataWrapper);
		}
	}
}
