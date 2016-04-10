<?php
	class DataWrapper_dto extends CI_Model {
		public $data = 	"";
		public $draw = 0;
		public $recordsTotal = 0;
		public $recordsFiltered = 0;

		function __construct() 
		{ 
			parent::__construct(); 
		} 
	}
?>