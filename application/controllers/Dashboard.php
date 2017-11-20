<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(empty(is_client_loggedin())){ redirect('registration/login'); }
	}

	public function index() {
		echo "hjkl";
		pr($this->session->all_userdata());
	}

	public function edit_profile(){
		
	}

	public function logout(){
		$this->session->unset_userdata('client');
		$this->session->set_flashdata('success','Logout successful.');
		redirect('registration/login');
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */