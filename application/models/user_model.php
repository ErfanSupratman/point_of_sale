<?php
class DataWrapper {
	public $data = "";
}

class User_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function login($username, $password) {
		$this->db->select('id, username, password');
		$this->db->from('pos_user');
		$this->db->where('username', $username);
		$this->db->where('active', true);
		$this->db->where('password', MD5($password));
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	function getAllUsers() {
		$this->db->from("pos_user");
		return $this->db->get();
	}

	function getAllUsersSummary() {
		$dataWrapper = new DataWrapper();
		$sql = 'SELECT pu.id,username,full_name,pp.permission_name,pu.telepon,pp.id as permission_id, pu.active FROM pos_user pu JOIN pos_permission pp ON pp.id=pu.permission WHERE
					pu.active=true ORDER BY id desc';
		$query = $this->db->query($sql);
		// Fetch the result array from the result object and return it

		$dataWrapper->data = $query->result();
		return $dataWrapper;
	}

	function getUser($id) {

	}

	function addUser($data) {
		$this->db->insert('pos_user', $data);
		$response = array('success' => true);
		return $response;
	}

	function updateUser($data, $id) {
		$this->db->update('pos_user', $data, "id = " . $id);
		$response = array('success' => true);
		return $response;
	}

	function deactiveUser($id) {
		$data = array(
			'active' => false,
		);
		$this->db->update('pos_user', $data, "id = " . $id);
		$response = array('success' => true);
		return $response;
	}
}

?>