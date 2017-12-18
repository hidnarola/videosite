<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public $img_var = '';

	public function __construct() {
		parent::__construct();
		$this->load->model(['Users_model','Post_model']);
        $this->load->library('pagination');
        if(empty(is_client_loggedin())){ redirect('home'); }
	}

	public function index() {
        
		$data['all_channels'] = $this->db->get_where('user_channels',['is_deleted'=>'0','is_blocked'=>'0'])->result_array();		
		$this->load->view('front/dashboard/index', $data);
	}

	public function edit_profile(){
		
		$client_data = $this->session->userdata('client');
		$data['user_data'] = $this->Users_model->get_data(['id'=>$client_data['id']],true);

		$this->img_var = $data['user_data']['avatar'];

		$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check',
                                          ['username_check'=>'Username should be unique.']);
		$this->form_validation->set_rules('fname', 'fname', 'trim');
		$this->form_validation->set_rules('lname', 'lname', 'trim');
		$this->form_validation->set_rules('file_upload', 'File Upload', 'callback_file_upload');

        if($this->form_validation->run() == FALSE){
            $data['subview']='front/dashboard/edit_profile';
            $this->load->view('front/layouts/layout_main',$data);
        }else{

        	$username = $this->input->post('username');
			$fname = $this->input->post('fname');
			$lname = $this->input->post('lname');	
                        $designation = $this->input->post('designation');
                        $birth_date = $this->input->post('birth_date');

			$upd_arr = [
							'fname'=>$fname,
							'lname'=>$lname,
							'designation'=>$designation,
							'username'=>$username,							
							'avatar'=>$this->img_var,
							'birth_date'=>$birth_date
						];
			$this->Users_model->update_user_data($client_data['id'],$upd_arr);
			
			$user_data = $this->Users_model->get_data(['id'=>$client_data['id']],true);
			$this->session->set_userdata('client',$user_data);

			$this->session->set_flashdata('success','Profile has been updated successfully.');
			redirect('dashboard/edit_profile');
        }
	}

	public function change_password(){
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|callback_verify_password',
										  ['verify_password'=>'Old password does not match with current one.']);
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
        	redirect('home');
        }
	}
	
	public function logout(){
		$this->session->unset_userdata('client');
		$this->session->set_flashdata('success','Logout successful.');
		redirect('home');
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

	public function file_upload(){

    	$config['upload_path'] = './uploads/avatars/';
    	$config['allowed_types'] = 'gif|jpg|png';
    	$config['max_size']  = '1000000';    	
    	$config['encrypt_name'] = true;

    	$this->load->library('upload', $config);
    	
    	if ( ! $this->upload->do_upload('my_img')){    		
    		$error_msg = strip_tags($this->upload->display_errors());
    		if($error_msg == 'You did not select a file to upload.'){
    			return true;
    		}else{
	    		$this->form_validation->set_message('file_upload', $this->upload->display_errors());
    			return false;
    		}    		
    	} else {
    		$data = array('upload_data' => $this->upload->data());
    		$this->img_var = 'uploads/avatars/'.$data['upload_data']['file_name'];
    		return true;
    	}
    }

	/*=====  End of Form validation callback functions comment block  ======*/

    public function view_history()
    {
        $sess_data = $this->session->userdata('client');
        
        $config['base_url'] = base_url().'dashboard/view_history';
        $config['total_rows'] = $this->Post_model->get_history_count(['user_id' => $sess_data['id']]);

        $config['per_page'] = 12;
        $offset = $this->input->get('per_page');
        $config = array_merge($config,pagination_front_config());
        
        $this->pagination->initialize($config);
        
        $data['history'] = $this->Post_model->get_history($sess_data['id'],$config['per_page'],$offset);

        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
        
        $data['subview'] = 'front/dashboard/history';
        $this->load->view('front/layouts/layout_main', $data);
    }
    
    public function view_bookmarked_post()
    {
        $sess_data = $this->session->userdata('client');
        
        $config['base_url'] = base_url().'dashboard/view_bookmarked_post';
        $config['total_rows'] = $this->Post_model->get_bookmarked_post_count(['user_id' => $sess_data['id']]);
        $config['per_page'] = 12;
        $offset = $this->input->get('per_page');
        $config = array_merge($config,pagination_front_config());
        
        $this->pagination->initialize($config);
        
        $data['book'] = $this->Post_model->get_bookmarked_post($sess_data['id'],$config['per_page'],$offset);
        
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
        
        $data['subview'] = 'front/dashboard/bookmarks';
        $this->load->view('front/layouts/layout_main', $data);
    }

    public function view_my_posts()
    {
        $sess_data = $this->session->userdata('client');
        $data['session_info'] = $sess_data;
        
        $config['base_url'] = base_url().'dashboard/view_my_posts';
        $config['total_rows'] = $this->Post_model->get_my_posts_count($sess_data['id']);
        $config['per_page'] = 12;
        $offset = $this->input->get('per_page');
        $config = array_merge($config,pagination_front_config());
        
        $this->pagination->initialize($config);
        
        $data['posts'] = $this->Post_model->get_my_posts_data($sess_data['id'],$config['per_page'],$offset);
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
        
        $data['subview'] = 'front/dashboard/my_posts';
        $this->load->view('front/layouts/layout_main', $data);
    } 
    
    
    public function view_recommended()
    {
        $sess_data = $this->session->userdata('client');
        
        $config['base_url'] = base_url().'dashboard/view_recommended';
        $config['total_rows'] = $this->Post_model->get_recommended_post_count(['user_id' => $sess_data['id']]);
        $config['per_page'] = 12;
        $offset = $this->input->get('per_page');
        $config = array_merge($config,pagination_front_config());
        
        $this->pagination->initialize($config);
        
        $data['recommended'] = $recommended = $this->Post_model->get_recommended_post($sess_data['id']);
        usort($recommended, function($a, $b)
        {
            return $b['total_views'] - $a['total_views'];
        });

        $data['recommend'] = array_slice($recommended,$offset, $config['per_page']);
//        pr($data['recommend']);die;
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
        
        $data['subview'] = 'front/dashboard/recommended';
        $this->load->view('front/layouts/layout_main', $data);
    } 

    

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */