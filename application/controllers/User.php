<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

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
		$this->load->model("user_model");
	}
	 
	public function index()
	{
		$data['permissions'] = $this->getUserPagePermissions();
		$this->load->view('management/user',$data);
	}
	
	public function getAllUsers(){
		header('Content-Type: application/json');
		$listUsers = $this->user_model->getAllUsersSummary();
		echo json_encode($listUsers);
	}
	
	public function deactiveUser(){
		header('Content-Type: application/json');
		$response = $this->user_model->deactiveUser($_GET['id']);
		echo json_encode($response);
	}

	public function updateUser(){
		header('Content-Type: application/json');
		
		if(!empty($_POST['password_new'])){
			$data = array(
				'username' => $_POST['username_new'],
				'password' => MD5($_POST['password_new']),
				'full_name' => $_POST['full_name_new'],
				'telepon' => $_POST['hp_new'],
				'permission' => $_POST['role_new']
			  );
		}else{
			$data = array(
			'username' => $_POST['username_new'],
			'full_name' => $_POST['full_name_new'],
			'telepon' => $_POST['hp_new'],
			'permission' => $_POST['role_new']
          );
		}
		$response = $this->user_model->updateUser($data, $_GET['id']);
		echo json_encode($response);
	}

	public function addUser(){
		header('Content-Type: application/json');
		if(empty($_POST['password_new'])){
				$response = array('success' => false,'error' => "Password cannot be empty!");
			}else{$data = array(
					'username' => $_POST['username_new'],
					'password' => md5($_POST['password_new']),
					'full_name' => $_POST['full_name_new'],
					'telepon' => $_POST['hp_new'],
					'permission' => $_POST['role_new']
				  );
		$response = $this->user_model->addUser($data);
	}
		
		echo json_encode($response);
	}
}
