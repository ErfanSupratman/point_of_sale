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

	function getInvoiceHeaderAndItemByInvoiceId($id){
$dataWrapper = new $this->document_dto();
		$sql = 'SELECT pi.id,
				pi.invoice_code,
				pi.billing_name,
				pi.billing_address,
				pi.customer_id,
				pi.billing_phone,
				pi.billing_email,
				pi.location_id,
				pi.freight,
				pi.notes,
				pw.name,
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

	function finalizeInvoice($id){
		$sql = 'UPDATE pos_invoice SET state=1 WHERE id=?';
		$query = $this->db->query($sql, array($id));
		$response = array('success' => true);
		return $response;
	}

	function getAllInvoiceByStateSummary($state) {
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
				pi.billing_name,
				pi.billing_address,
				pi.customer_id,
				pi.billing_phone,
				pi.billing_email,
				pi.location_id,
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
			$this->db->set('invoice_code', 'getCounterSequence(6)', FALSE);
			$this->db->set('created_date', 'now()', FALSE);
			$this->db->set('created_by', "'".$username."'", FALSE);
			$this->db->insert('pos_invoice', $data->dataHeader);
			$headerId = $this->db->insert_id();
			foreach ($data->dataDetail as $obj) {
				$result = $this->inventory_model->getStockByProductIdAndLocationId($obj->product_id,$data->dataHeader->location_id);
				$this->db->set('invoice_id', $headerId, FALSE);
				$this->db->insert('pos_invoice_detail', $obj);
				$stock = array('product_id' => $obj->product_id, 'stock' => $obj->quantity, 'location_id' =>$data->dataHeader->location_id );
				$this->inventory_model->decreaseStock( $stock, 'addInvoice',  $username);
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

	function updateInvoice($data,$headerId) {
		$success = true;
		error_log("updateInvoice id ".$headerId." data :" . json_encode($data));
		error_log("dataHeader " . json_encode($data->dataHeader));
		error_log("dataDetail " . json_encode($data->dataDetail));
		foreach ($data->dataDetail as $obj) {
			error_log($obj->product_id);
		}

		try {
			$this->db->trans_start();
			$this->db->set('updated_date', 'now()', FALSE);
			$this->db->update('pos_invoice', $data->dataHeader, array('id' => $headerId));

			$this->db->delete('pos_invoice_detail', array('invoice_id' => $headerId)); 

			foreach ($data->dataDetail as $obj) {
				$this->db->set('invoice_id', $headerId, FALSE);
				$this->db->insert('pos_invoice_detail', $obj);
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

}

?>