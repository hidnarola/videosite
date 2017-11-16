<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    
    public function __construct() {
        parent::__construct();             
        $this->load->model(array('Users_model'));
    }

    public function index() {
        //$this->session->unset_userdata('client');

        $data['user_data'] = $this->session->userdata('client');
        
        if (!empty($data['user_data'])) {
            $this->Users_model->update_user_data($data['user_data']['id'], ['last_login' => date('Y-m-d H:i:s')]);
            redirect('dashboard');
        }

        $this->form_validation->set_rules('email_id', 'Email', 'required|valid_email');        
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run() == FALSE){
            $data['email'] = $this->session->flashdata('login_email');
            $this->session->set_flashdata('login_email',$data['email']);
            $data['subview']='front/login_front';
            $this->load->view('front/layouts/layout_main',$data);
        }else{
            
            $email = $this->input->post('email_id');
            $password = $this->input->post('password');
            // check_if_user_exist - three params 1->where condition 2->is get num_rows for query 3->is fetech single or all data
            $fetch_user_data = $this->db->get_where('users',['email_id'=>$email])->row_array();
            $user_data = $this->Users_model->check_if_user_exist(['email_id' => $email], false, true,['4','5']); 

            if (!empty($user_data)) 
            {
                if($user_data['is_verified'] == 1)
                {
                    $msg="Thank you for visiting us. In order to use your account, please check your emails for our Welcome message 
                            and click on the activation link to use your account with us. If you haven’t received the email, please, 
                            find in our <a href='".base_url('faq')."'>FAQ </a> (Account Activation) for help.";
                    $this->session->set_flashdata('error',$msg);
                    redirect('login');
                }
                else
                {
                    $db_pass = $this->encrypt->decode($user_data['password']);
                    if ($db_pass == $password) {

                        if($user_data['is_blocked'] == 1){
                            $msg = 'Please contact our customer support <ahref="contact_us">Contact us</a> and request to manually activate your existing account.';
                            $this->session->set_flashdata('error',$msg);
                            redirect('login');
                        }
                        $user_login = $this->session->userdata('client');
                        if(!empty($user_login)){
                            $this->session->set_flashdata('error','Can not allow login because of user login.Try another browser.');
                            redirect('login');
                        }
                        
                        $this->session->set_userdata(['client' => $user_data, 'loggedin' => TRUE]); // Start Loggedin User Session
                        $this->session->set_flashdata('success','Login Successfull');
                        $this->Users_model->update_user_data($user_data['id'], ['last_login' => date('Y-m-d H:i:s')]); // update last login time

                        // If quick RFP form is Filled up earlier then it should update the record
                        // ------------------------------------------------------------------------
                        $quick_rfp = $this->session->userdata('quick_data');
                        if(!empty($quick_rfp)){
                            if($quick_rfp['quick_email'] == $user_data['email_id']){
                                $this->db->update('rfp', ['patient_id'=>$user_data['id']], ['rfp_mail'=>$quick_rfp['quick_email']]);
                                $this->db->update('rfp', ['rfp_mail'=>NULL], ['rfp_mail'=>$quick_rfp['quick_email']]);
                                $this->session->set_userdata('redirect_url',base_url().'rfp/view_rfp/'.encode($quick_rfp['rfp_id']).'?show_popup=yes');
                                $this->session->unset_userdata('quick_data'); // Unset Request data
                            }
                        }
                        // ------------------------------------------------------------------------

                        //----------- For check redirect url is set or not --------
                        if($this->session->userdata('redirect_url')){
                            redirect($this->session->userdata('redirect_url'));
                        }else{   
                            redirect('dashboard');
                        }
                        //------------ End For check redirect url is set or not -----------------

                    } else {
                        $this->session->set_flashdata('error', 'Password is incorrect.');
                        redirect('login');
                    } // End of else for if($db_pass == $password) condition
                } 
            } else {

                if(empty($fetch_user_data)){
                    $this->session->set_flashdata('error','Username and password incorrect.');
                }else if($fetch_user_data['is_deleted'] == '1') {                    
                    $msg = 'The Email is already in use - please, use the login screen. If you need to reset your password check here <a href="faq"> FAQ </a> Password reset';
                    $this->session->set_flashdata('error',$msg);
                }
                redirect('login');
            } 
        }
        
    }

    public function logout(){
        $this->session->unset_userdata('client');
        $this->session->unset_userdata('redirect_url');
        $this->session->set_flashdata('success','Logout Successfull');
        redirect('login');
    }    

    public function set_password($rand_no){
        
        $this->session->unset_userdata('client');
        
        $res = $this->Users_model->get_data(['activation_code'=>$rand_no],true);        

        if(empty($res)) { show_404(); }
        // pr($res,1);
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('re_password', 'Re-type Password', 'required|matches[password]');

        if($this->form_validation->run() == FALSE){
            $data['subview']='front/set_password';
            $this->load->view('front/layouts/layout_main',$data);
        }else{
            $password = $this->input->post('password');
            $encode_password = $this->encrypt->encode($password);
            $this->Users_model->update_user_data($res['id'],['password'=>$encode_password,'is_verified'=>'0','activation_code'=>'']);
            $this->session->set_flashdata('success', 'Password has been successfully set.Try email and password to login.');
            redirect('login');
        }
    }
}
