<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Users_model');
		if(empty(is_client_loggedin())){ redirect('registration/login'); }
	}

	public function index() {
		echo "hjkl";
		pr($this->session->all_userdata());
	}

	public function edit_profile(){
		
		$client_data = $this->session->userdata('client');
		$data['user_data'] = $this->Users_model->get_data(['id'=>$client_data['id']],true);
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check',
                                          ['username_check'=>'Username should be unique.']);
		$this->form_validation->set_rules('fname', 'fname', 'trim');
		$this->form_validation->set_rules('lname', 'lname', 'trim');

        if($this->form_validation->run() == FALSE){
            $data['subview']='front/dashboard/edit_profile';
            $this->load->view('front/layouts/layout_main',$data);
        }else{

        }
	}

	public function change_password(){

		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|callback_verify_password',
										  ['verify_password'=>'Old password doen not match with current one.']);
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'trim|required|matches[password]');

        if($this->form_validation->run() == FALSE){
            $data['subview']='front/dashboard/change_password';
            $this->load->view('front/layouts/layout_main',$data);
        }else{
        	$client_data = $this->session->userdata('client');
			$user_data = $this->Users_model->get_data(['id'=>$client_data['id']],true);

        	$password = $this->input->post('password');
        	$encrypt_pass = $this->encrypt->encode($password);
        	$this->Users_model->update_user_data($user_data['id'],['password'=>$encrypt_pass]);
        	$this->session->set_flashdata('success','Password successfully changed.');
        	redirect('dashboard');
        }
	}

	public function logout(){
		$this->session->unset_userdata('client');
		$this->session->set_flashdata('success','Logout successful.');
		redirect('registration/login');
	}

	/*========================================================================
	=            Form validation callback functions comment block            =
	========================================================================*/
	
	public function verify_password($password){
		$client_data = $this->session->userdata('client');
		$user_data = $this->Users_model->get_data(['id'=>$client_data['id']],true);
		$decode_pass = $this->encrypt->decode($user_data['password']);
		
		if($decode_pass == $password){
			return true;
		}else{
			return false;
		}		
	}

	/*=====  End of Form validation callback functions comment block  ======*/

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */