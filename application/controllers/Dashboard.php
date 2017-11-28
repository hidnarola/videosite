<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(['Users_model','Post_model']);
		
		if(empty(is_client_loggedin())){ redirect('registration/login'); }
	}

	public function index() {
		// pr($this->session->all_userdata());
		// $data = [];
             $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
		$data['all_channels'] = $this->db->get_where('user_channels',['is_deleted'=>'0','is_blocked'=>'0'])->result_array();
		// pr($data,1);
		$this->load->view('front/dashboard/index', $data);
	}

	public function edit_profile(){
		
		$client_data = $this->session->userdata('client');
                 $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
		$data['user_data'] = $this->Users_model->get_data(['id'=>$client_data['id']],true);

		$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check',
                                          ['username_check'=>'Username should be unique.']);
		$this->form_validation->set_rules('fname', 'fname', 'trim|required');
		$this->form_validation->set_rules('lname', 'lname', 'trim|required');
		$this->form_validation->set_rules('birth_date', 'birth_date', 'trim|required');

        if($this->form_validation->run() == FALSE){
            $data['subview']='front/dashboard/edit_profile';
            $this->load->view('front/layouts/layout_main',$data);
            
            
        }else{

        	$username = $this->input->post('username');
			$fname = $this->input->post('fname');
			$lname = $this->input->post('lname');
			$birth_date = $this->input->post('lname');

			$upd_arr = [
							'fname'=>$fname,
							'lname'=>$lname,
							'username'=>$username,
							'birth_date'=>$birth_date,
							'avatar'=>''
						];
//                        pr($upd_arr,1);
			$this->Users_model->update_user_data($client_data['id'],$upd_arr);
			$this->session->set_flashdata('success','Record has been updated successfully.');
			redirect('home');
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

	public function username_check($username){
		
		$client_data = $this->session->userdata('client');
		$user_data = $this->Users_model->get_data(['id'=>$client_data['id']],true);

		if($user_data['username'] != $username){
			$res = $this->Users_model->get_data(['username'=>$username,'is_blocked'=>'0','is_deleted'=>'0']);
	        if(count($res) == 0){
	            return true;
	        }else{
	            return false;
	        }
		}else{
			return true;
		}
	}

	/*=====  End of Form validation callback functions comment block  ======*/

    public function view_history()
    {
        $sess_data = $this->session->userdata('client');
        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
        $data['history'] = $this->db->get_where('user_history', ['user_id' => $sess_data['id']])->result_array();
        $data['subview'] = 'front/dashboard/history';
        $this->load->view('front/layouts/layout_main', $data);
    }
    
    public function view_bookmarked_post()
    {
        $sess_data = $this->session->userdata('client');
        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
        
        $this->load->library('pagination');
        $config = array();
        $config["base_url"] = base_url() . "dashboard/bookmarks";
        $total_row = $this->Post_model->record_count();
        $config["total_rows"] = $total_row;
        $config["per_page"] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $total_row;
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';

        $this->pagination->initialize($config);
        if($this->uri->segment(3)){
            $page = ($this->uri->segment(3)) ;
        }
        else{
            $page = 2;
        }
        $data["bookmark"] = $this->Post_model->fetch_data($config["per_page"], $page);
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
        $data['subview'] = 'front/dashboard/bookmarks';
        $this->load->view('front/layouts/layout_main', $data);
    }

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */