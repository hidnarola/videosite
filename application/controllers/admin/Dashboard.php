<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Users_model']);
        check_admin_login();
    }

    /**
     * function use to display admin dashboard.(HPA)
     */
    public function index() {
        $session_data = $this->session->userdata('admin');
        $data['user_data'] = $this->Users_model->check_if_user_exist(['id' => $session_data['id']], false, true,['1','2','3']);        
        if (empty($data['user_data'])) { redirect('admin/login'); }        
            
        $data['subview'] = 'admin/dashboard';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * function use for logout from admin panel.(HDA)
     */
    public function log_out() {
        $this->session->unset_userdata('admin');
        $this->session->set_flashdata('message', array('message' => 'Log out Successfully.', 'class' => 'alert alert-success'));
        redirect('admin/login');
    }

    public function edit() {
        $session_data = $this->session->userdata('admin');
        $data['user_data'] = $this->Users_model->check_if_user_exist(['id' => $session_data['id']], false, true,['1','2','3']);

        if (empty($data['user_data'])) {
            redirect('admin/login');
        }                
        $data['heading'] = 'Edit Profile';
        
        $this->img_var = $data['user_data']['avatar'];

        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check',
                                  ['username_check'=>'Username should be unique.']);
        $this->form_validation->set_rules('fname', 'fname', 'trim');
        $this->form_validation->set_rules('lname', 'lname', 'trim');
        $this->form_validation->set_rules('file_upload', 'File Upload', 'callback_file_upload');

        if($this->form_validation->run() == FALSE){
            $data['subview']='admin/profile_edit';
            $this->load->view('admin/layouts/layout_main',$data);
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
                pr($upd_arr);die;
                $this->Users_model->update_user_data($session_data['id'],$upd_arr);

                $user_data = $this->Users_model->get_data(['id'=>$session_data['id']],true);
                $this->session->set_userdata('admin',$user_data);

                $this->session->set_flashdata('success','Profile has been updated successfully.');
                redirect('admin/profile_edit');
            }             
    }

    public function change_password() {
        $session_data = $this->session->userdata('admin');
        $data['user_data'] = $this->Users_model->check_if_user_exist(['id' => $session_data['id']], false, true,['1','2','3']);
        if (empty($data['user_data'])) {
            redirect('admin/login');
        }        
        $data['heading'] = 'Change Password';
        $sess_pass = $data['user_data']['password'];
        $decode_pass = $this->encrypt->decode($sess_pass);

        $user_id = $session_data['id'];
        $this->form_validation->set_rules('curr_pass', 'Current Password', 'trim|required|in_list[' . $decode_pass . ']', ['in_list' => 'Current Password Incorrect.', 'required' => 'Please fill the field' . ' %s .']);
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[6]|matches[re_pass]', array('required' => 'Please fill the field' . ' %s .', 'min_length' => 'Please enter password min 6 letter', 'matches' => 'Please enter same password'));
        $this->form_validation->set_rules('re_pass', 'Repeat Password', 'trim|required', array('required' => 'Please fill the field' . ' %s .'));

        if ($this->form_validation->run() == FALSE) {
            $data['subview'] = 'admin/change_password';
            $this->load->view('admin/layouts/layout_main', $data);
        } else {

            $password = $this->input->post('pass');

            if ($password == $decode_pass) {
                $this->session->set_flashdata('message', ['message'=>'Please do not use existing password.','class'=>'alert alert-danger']);
                redirect('admin/change_password');
            }
            $encode_pass = $this->encrypt->encode($password);

            $this->Users_model->update_user_data($user_id, ['password' => $encode_pass]);
            $this->session->set_flashdata('message', ['message'=>'Password has been set Successfully.','class'=>'alert alert-success']);
            redirect('admin/change_password');
        }
    }
    
    public function file_upload(){

    	$config['upload_path'] = './uploads/avatars/';
    	$config['allowed_types'] = 'gif|jpg|png|jpeg';
    	$config['max_size']  = '100000000000';    	
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
            
            $old_path = $data['upload_data']['full_path'];
            $new_path = $data['upload_data']['file_path'].$file_name;
            $file_name = random_string('alnum', 16).'.jpg';            
            exec(FFMPEG_PATH . ' -i '.$old_path.' -vf scale=500:-1 '.$new_path);
            unlink($data['upload_data']['full_path']);

    		$this->img_var = 'uploads/avatars/'.$file_name;
    		return true;
    	}
    }

}
