<?php
	class EmptyReturn {
		public $id = '0';
		public $stock_id ="";
		public $booking_code = "";
		public $notes = "";
		public $quantity =0;
		public $created_date = null;
		public $created_by = "";
		public $active = false;
	}

	class Booking_model extends CI_Model  {
		
		function __construct() 
		{ 
			parent::__construct(); 
			$this->load->model('inventory_model');
			$this->load->model('dataWrapper_dto');
		} 
		
		function getAllBookings() 
		{
			$this->db->from("pos_booking");
			return $this->db->get();
		}
		
		function getListBookingByStockId($stockId) 
		{
			$dataWrapper = new $this->dataWrapper_dto();

			if(isset($stockId)){
				$sql = 'SELECT pb.id, pb.stock_id, pb.booking_code, pb.notes, pb.quantity, pb.created_date, pb.created_by, pb.active FROM pos_booking pb WHERE pb.active=true and pb.stock_id='.$stockId.' ORDER BY pb.created_date desc';
				$query = $this->db->query($sql);
				$dataWrapper->data = $query->result();
			}else{
				$emptyReturn = new EmptyReturn();
				$dataWrapper->data = $emptyReturn;
			}
			return $dataWrapper;
		}

		function addBooking($data)
		{
			error_log(json_encode($data));
			$sql = "SELECT updateAvailableStock(".$data['stock_id'].",".$data['quantity'].",'".$data['notes']."', 'febryo') as result FROM dual";
			$query = $this->db->query($sql);
			$result = $query->result();
			$resultNonArray = $result[0];
			$returnSplited = explode(",", $resultNonArray->result);
			if(1==$returnSplited[0]){
				$response = array( 'success' => true,'availableStock' => $returnSplited[1]);
			}else{
				$response = array( 'success' => false,'error' => 'Quantity tidak cukup');
			}
			
			return $response;
		}

		function deactiveBooking($id,$stockId)
		{
			$data = array(
               'active' => false
            );
            
			$this->db->update('pos_booking', $data, "id = ".$id);
			$getAvailableQuantityResponse = $this->inventory_model->getAvailableQuantity($stockId);
			$quantity = $getAvailableQuantityResponse[0];
			$response = array( 'success' => true, 'stock' => $quantity->stock);
			return $response;
		}
	}

?>
