<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerifyLogin extends MY_Controller {

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

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
	}

	function index() {
		//This method will have the credentials validation
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

		if ($this->form_validation->run() == FALSE) {
			//Field validation failed.  User redirected to login page
			$this->load->view('welcome_message');
		} else {
			//Go to private area
			if(in_array('VIEW_DASHBOARD',$this->getUserPagePermissions())||in_array('SUPER_ADMIN',$this->getUserPagePermissions())){
				redirect('Home', 'refresh');
			}else{
				redirect('Inventory?active=inv', 'refresh');
			}
			
		}
	}

	function check_database($password) {
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');

		//query the database
		$result = $this->user_model->login($username, $password);
		$permissions = $this->user_model->getUserPermissionList($username);
		if ($result) {
			$sess_array = array();
			foreach ($result as $row) {
				$sess_array = array(
					'id' => $row->id,
					'username' => $row->username,
					'permissions' => $permissions
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		} else {
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}

	function logout() {
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('/', 'refresh');
	}

	public function checkSession(){
		if ($this->session->userdata('logged_in')) {
		}else{
			redirect('/', 'refresh');
		}
	}


}
