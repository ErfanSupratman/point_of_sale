<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
class PrintExcel extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->checkSession();
		$this->load->model("invoice_model");
		$this->load->model('document_dto');
	}

	public function invoiceXls(){

		if(isset($_GET['id']) && $_GET['id']!=''){
			$id = $_GET['id'];
			$this->load->library('excel');

			$result = $this->invoice_model->getInvoiceHeaderAndItemByInvoiceId($id);
			if($result!=null){
				$countList = count($result->detail);

				$objPHPexcel = PHPExcel_IOFactory::load(APPPATH.'third_party/template/invoice.xlsx');
				$objWorksheet = $objPHPexcel->getActiveSheet();
				/*$objWorksheet->insertNewRowBefore(2,1);*/
				$objWorksheet->getCell('F4')->setValue(date("d/m/Y"));
				//strtotime("2011-01-07")
				$objWorksheet->getCell('F5')->setValue($result->header->invoice_code);
				$objWorksheet->getCell('F6')->setValue($result->header->term_of_payment);

				if($countList>2){
					$objWorksheet->insertNewRowBefore(10,$countList-2);
				}
				$i = 9;
				$number = 1;
				foreach ($result->detail as $obj) {
					$objWorksheet->getCell('A'.$i)->setValue($number);
					$objWorksheet->getCell('B'.$i)->setValue($obj->product_name);
					$objWorksheet->getCell('D'.$i)->setValue($obj->quantity);
					$objWorksheet->getCell('E'.$i)->setValue($obj->price);
					$objWorksheet->getCell('F'.$i)->setValue(intval($obj->price)*intval($obj->quantity));
					$i++;
					$number++;
				}

				if($countList<2){
					$objWorksheet->getCell('F11')->setValue($result->header->freight);
				}else{
					$objWorksheet->getCell('F'.$i)->setValue($result->header->freight);
				}

				$filename='invoice_'.date("Y-m-d").'.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				            
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
			}
		}else{
			echo "cannot print invoice";
		}
	}

	public function incomeReport(){
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

		if($isValid){
			$startDate = $_GET['startDate'];
			$endDate = $_GET['endDate'];


			$this->load->library('excel');

			$result = $this->invoice_model->invoiceIncomeReport($startDate, $endDate);
			$countList = count($result);

			$objPHPexcel = PHPExcel_IOFactory::load(APPPATH.'third_party/template/invoice_report.xlsx');
			$objWorksheet = $objPHPexcel->getActiveSheet();
			/*$objWorksheet->insertNewRowBefore(2,1);*/
			$objWorksheet->getCell('G1')->setValue(date("d/m/Y"));
			//strtotime("2011-01-07")
			$objWorksheet->getCell('A2')->setValue($startDate.' until '.$endDate);

			if($countList>2){
				$objWorksheet->insertNewRowBefore(6,$countList-2);
			}
			$i = 5;
			foreach ($result as $obj) {
				$objWorksheet->getCell('A'.$i)->setValue($obj->created_date);
				$objWorksheet->getCell('B'.$i)->setValue($obj->finalize_date);
				$objWorksheet->getCell('C'.$i)->setValue($obj->updated_by);
				$objWorksheet->getCell('D'.$i)->setValue($obj->invoice_code);
				$objWorksheet->getCell('E'.$i)->setValue($obj->booking_code);
				$objWorksheet->getCell('F'.$i)->setValue($obj->billing_name);
				$objWorksheet->getCell('G'.$i)->setValue($obj->freight);
				$objWorksheet->getCell('H'.$i)->setValue($obj->amount);
				$i++;
			}

			$filename='invoice_report'.date("Y-m-d").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			            
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		}else{
			echo $error;	
		}
	}

	public function example() {
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$filename='just_some_random_name.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		            
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
}

