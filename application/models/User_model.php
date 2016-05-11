<?php
class DataWrapper {
	public $data = "";
}

class User_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function deleteSessions(){
		$this->db->empty_table('ci_session'); 
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

	function getUserPermissionList($username){
		$sql = 'SELECT ppm.action FROM pos_permission_map ppm 
		JOIN pos_user pu ON pu.permission=ppm.permission WHERE pu.username=? AND ppm.allowed=true';
		$query = $this->db->query($sql,array($username));
		return $query->result();

	}

	function getUser($username) {
		$sql = 'SELECT * FROM pos_user WHERE username=? and active=true';
		$result = $this->db->query($sql,array($username));
		return $result->row();
	}

	function addUser($data) {
		$success = true;
		$error = "";
		try {
			$this->db->trans_start();

			if($data['permission']=="0"){
				throw new Exception("Permission cannot be empty!");
			}

			if(empty($data['username'])){
				throw new Exception("Username cannot be empty!");	
			}

			if(empty($data['password'])){
				throw new Exception("Password cannot be empty!");	
			}

			$user = $this->getUser($data['username']);

			if($user!=null){
				throw new Exception("Username already exists!");
			}else{
				$this->db->insert('pos_user', $data);
			}

			
			$this->db->trans_complete();	
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$success = false;
			$error = $e->getMessage();
		}
		
		$response = array('success' => $success,'error' => $error);
		return $response;
	}

	function updateUser($data, $id) {
		$success = true;
		$error = "";
		try {
			$this->db->trans_start();

			if($data['permission']=="0"){
				throw new Exception("Permission cannot be empty!");
			}

			if(empty($data['username'])){
				throw new Exception("Username cannot be empty!");	
			}


			$user = $this->getUser($data['username']);

			if($user!=null){
				if($user->id!=$id){
					throw new Exception("Username already exists!");
				}
			}

			$this->db->update('pos_user', $data, "id = " . $id);

			$this->db->trans_complete();	
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$success = false;
			$error = $e->getMessage();
		}
		
		$response = array('success' => $success,'error' => $error);
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
