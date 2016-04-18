<?php

class Invoice_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->model('dataWrapper_dto');
		$this->load->model('document_dto');
		$this->load->model('inventory_model');
	}

	function getAllInvoiceSummary() {
		$dataWrapper = new $this->dataWrapper_dto();
		$sql = 'SELECT id,
				invoice_code,
				billing_name,
				billing_address,
				customer_id,
				billing_phone,
				billing_email,
				location_id,
				state,
				created_by,
				created_date
				FROM pos_invoice
				ORDER BY created_date asc';
		$query = $this->db->query($sql);
		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function invoiceIncomeReport($startDate,$endDate){
		$sql = 'SELECT 
				pi.created_date, 
				pi.finalize_date, 
				pi.updated_by, 
				pi.invoice_code, 
				pi.booking_code, 
				pi.billing_name, 
				COALESCE(pi.freight,0) as freight, 
				SUM(pid.quantity*pid.price) as amount 
				FROM pos_invoice pi 
				JOIN pos_invoice_detail pid ON pid.invoice_id=pi.id
				WHERE pi.state=2 and pi.created_date >= ? AND pi.created_date <?  
				GROUP by pi.id ORDER BY pi.created_date';
		$query = $this->db->query($sql,array($startDate.' 00:00:00',$endDate.' 23:59:00'));
		return $query->result();
	}

	function getInvoiceHeaderAndItemByInvoiceId($id){
$dataWrapper = new $this->document_dto();
		$sql = 'SELECT pi.id,
				pi.invoice_code,
				pi.booking_code,
				pi.billing_name,
				pi.billing_address,
				pi.customer_id,
				pi.billing_phone,
				pi.billing_email,
				pi.location_id,
				pi.freight,
				pi.notes,
				pw.name,
				pi.term_of_payment,
				pi.state,
				pi.created_by,
				pi.created_date
				FROM pos_invoice pi
				JOIN pos_warehouse pw ON pi.location_id=pw.id
				WHERE pi.id=?';
		$queryH = $this->db->query($sql, array($id));

		$sql = 'SELECT 
				pi.id,
				pp.name as product_name,
				pp.id as product_id,
				pp.product_code,
				pb.name as brand_name,
				pi.quantity,
				pi.price,
				pi.invoice_id
				FROM pos_invoice_detail pi 
				JOIN pos_product pp ON pp.id=pi.product_id
				JOIN pos_brand pb ON pb.id=pp.brand_id
				WHERE pi.invoice_id=?';
		$queryD = $this->db->query($sql, array($id));
		
		$dataWrapper->header = $queryH->result()[0];
		$dataWrapper->detail = $queryD->result();
		return $dataWrapper;
	}

	function finalizeInvoice($id, $finalizeDate){
		$sql = 'UPDATE pos_invoice SET state=2,finalize_date=? WHERE id=?';
		$query = $this->db->query($sql, array($finalizeDate, $id));
		$response = array('success' => true);
		return $response;
	}

	function voidInvoice($id,$username){
		$sqlHeader = 'UPDATE pos_invoice SET state=3,updated_date=now(),updated_by=? WHERE id=?';
		$queryHeader = $this->db->query($sqlHeader, array($username,$id));

		$sqlDetail = 'SELECT pid.product_id,pid.quantity,pi.location_id FROM pos_invoice pi JOIN pos_invoice_detail pid ON pid.invoice_id=pi.id WHERE pi.id=?';
		$queryDetail = $this->db->query($sqlDetail, array($id));

		foreach ($queryDetail->result() as $obj) {
			$stock = array('product_id' => $obj->product_id, 'stock' => $obj->quantity, 'location_id' =>$obj->location_id );
			$this->inventory_model->addStock( $stock, 'addInvoice',  $username);
		}
		$response = array('success' => true);
		return $response;
	}

	function getAllInvoiceByStateSummary($state) {
		$dataWrapper = new $this->dataWrapper_dto();
		$sql = 'SELECT id,
				invoice_code,
				booking_code,
				billing_name,
				billing_address,
				customer_id,
				billing_phone,
				billing_email,
				location_id,
				state,
				created_by,
				created_date
				FROM pos_invoice
				WHERE state=?
				ORDER BY created_date asc';
		$query = $this->db->query($sql,array($state));
		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function getInvoiceById($id) {
		$dataWrapper = new $this->dataWrapper_dto();
		$sql = 'SELECT pi.id,
				pi.invoice_code,
				pi.booking_code,
				pi.billing_name,
				pi.billing_address,
				pi.customer_id,
				pi.billing_phone,
				pi.billing_email,
				pi.location_id,
				pi.term_of_payment,
				pw.name,
				pi.state,
				pi.created_by,
				pi.created_date
				FROM pos_invoice pi
				JOIN pos_warehouse pw ON pi.location_id=pw.id
				WHERE pi.id=?';
		$query = $this->db->query($sql, array($id));
		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function addInvoice($data, $username) {
		$success = true;
		error_log("addInvoice " . json_encode($data));
		error_log("dataHeader " . json_encode($data->dataHeader));
		error_log("dataDetail " . json_encode($data->dataDetail));
		foreach ($data->dataDetail as $obj) {
			error_log($obj->product_id);
		}
		$headerId = 0;
		try {
			$this->db->trans_start();

			if($data->dataHeader->state==0){
				$this->db->set('booking_code', 'getCounterSequence(5)', FALSE);
			}else{
				$this->db->set('invoice_code', 'getCounterSequence(6)', FALSE);	
			}

			
			$this->db->set('created_date', 'now()', FALSE);
			$this->db->set('created_by', "'".$username."'", FALSE);
			$this->db->insert('pos_invoice', $data->dataHeader);
			$headerId = $this->db->insert_id();
			foreach ($data->dataDetail as $obj) {
				$stockId = $this->inventory_model->getStockByProductIdAndLocationId($obj->product_id,$data->dataHeader->location_id);
				$availableStock = $this->inventory_model->getAvailableQuantity($stockId->id);
				if((intval($availableStock->stock) - intval($obj->quantity)) < 0){
					throw new Exception('Stock tidak mencukupi');		
				}
				$this->db->set('invoice_id', $headerId, FALSE);
				$this->db->insert('pos_invoice_detail', $obj);
/*				$stock = array('product_id' => $obj->product_id, 'stock' => $obj->quantity, 'location_id' =>$data->dataHeader->location_id );
				$this->inventory_model->decreaseStock( $stock, 'addInvoice',  $username);*/
			}
			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			error_log($e->getMessage());
			$success = false;
		}
		$response = array('success' => $success,'id' =>$headerId);
		return $response;
	}

	function countState(){
		$sql = 'SELECT state,count(*) as total
				FROM pos_invoice
				GROUP BY state';
		$query = $this->db->query($sql);
		return $query->result();
	}

	function countTotalByState($state,$startDate,$endDate){
		$sql = 'SELECT count(*) as total
				FROM pos_invoice
				WHERE state=? AND created_date >=? AND created_date < ?';
		$query = $this->db->query($sql,array($state,$startDate.' 00:00:00',$endDate.' 23:59:00'));
		return $query->row();
	}

	function updateInvoice($data,$headerId,$username) {
		$success = true;
		$error = "";
		error_log("updateInvoice id ".$headerId." data :" . json_encode($data));
		error_log("dataHeader " . json_encode($data->dataHeader));
		error_log("dataDetail " . json_encode($data->dataDetail));
		foreach ($data->dataDetail as $obj) {
			error_log($obj->product_id);
		}

		try {
			$this->db->trans_start();

			$queryInvCode = $this->db->query('SELECT invoice_code FROM pos_invoice WHERE id=?',array('id' => $headerId));
			$invoice_code = $queryInvCode->row();

			if($data->dataHeader->state==1){
				$invoice_code = "";
				if(isset($data->dataHeader->invoice_code)){
					$invoice_code = $data->dataHeader->invoice_code;
				}
				$this->db->set('invoice_code', 'getCounterSequence(6)', FALSE);
			}

			$this->db->set('updated_date', 'now()', FALSE);
			$this->db->set('updated_by', "'".$username."'", FALSE);
			$this->db->update('pos_invoice', $data->dataHeader, array('id' => $headerId));

			$this->db->delete('pos_invoice_detail', array('invoice_id' => $headerId)); 

			foreach ($data->dataDetail as $obj) {
				$stockId = $this->inventory_model->getStockByProductIdAndLocationId($obj->product_id,$data->dataHeader->location_id);
				$availableStock = $this->inventory_model->getAvailableQuantity($stockId->id);
				if((intval($availableStock->stock) - intval($obj->quantity)) < 0){
					throw new Exception('Stock tidak mencukupi untuk product '.$stockId->product_name.' di lokasi '.$stockId->warehouse_name);		
				}
				$this->db->set('invoice_id', $headerId, FALSE);
				$this->db->insert('pos_invoice_detail', $obj);
			}

			error_log("state ".$data->dataHeader->state);

			if($data->dataHeader->state==2){
				foreach ($data->dataDetail as $obj) {
					$result = $this->inventory_model->getStockByProductIdAndLocationId($obj->product_id,$data->dataHeader->location_id);
					$stock = array('product_id' => $obj->product_id, 'stock' => $obj->quantity, 'location_id' =>$data->dataHeader->location_id );
					error_log("update stock ".json_encode($stock));
					$this->inventory_model->decreaseStock( $stock, 'PAID Invoice '+$invoice_code,  $username);
				}
			}

			if($data->dataHeader->state==3){
				foreach ($data->dataDetail as $obj) {
					$result = $this->inventory_model->getStockByProductIdAndLocationId($obj->product_id,$data->dataHeader->location_id);
					$stock = array('product_id' => $obj->product_id, 'stock' => $obj->quantity, 'location_id' =>$data->dataHeader->location_id );
					$this->inventory_model->addStock( $stock, 'VOID Invoice '+$invoice_code,  $username);
				}
			}

			$this->db->trans_complete();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$error = $e->getMessage();
			$success = false;
		}
		$response = array('success' => $success,'id' =>$headerId,'error' =>$error);
		return $response;
	}

}

?>
