<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Users_model'));

        if(!empty(is_client_loggedin())){
            redirect('dashboard');
        }
    }

    public function login(){

        $this->form_validation->set_rules('email_id', 'Email', 'required|valid_email');        
        $this->form_validation->set_rules('password', 'Password', 'required|callback_password_match');

        if($this->form_validation->run() == FALSE){
            $data['subview']='front/login_front';
            $this->load->view('front/layouts/layout_main',$data);
        }else{
            
            $email_id = $this->input->post('email_id');
            $user_data = $this->Users_model->get_data(['email_id'=>$email_id],true);

            $this->session->set_userdata(['client' => $user_data]); // Start Loggedin User Session
            $this->session->set_flashdata('success','Login Successfull');
            $this->Users_model->update_user_data($user_data['id'], ['last_login' => date('Y-m-d H:i:s')]); // update last login time
            redirect('home');
        }
    }

    public function user(){

        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check',
                                          ['username_check'=>'Username should be unique.']);
        $this->form_validation->set_rules('email_id', 'email', 'required|valid_email|callback_email_check',
                                          ['email_check'=>'Email should be unique.']);
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('i_agree', 'I Agree', 'trim|required');

        if($this->form_validation->run() == FALSE){
        $data['subview']='front/registration/registration_user_1';
            // $data['subview']='front/home';
            $this->load->view('front/layouts/layout_main',$data);
        }else{
            
            $username = $this->input->post('username');
            $email_id = $this->input->post('email_id');
            $password = $this->input->post('password');
            $encrypt_pass = $this->encrypt->encode($password);
            $random_no = random_string('alnum',5);

            $ins_data = [
                            'role_id'=>'3', // Here 3 means Normal User
                            'email_id'=>$email_id,
                            'username'=>$username,
                            'password'=>$encrypt_pass,
                            'activation_code'  => $random_no,
                            'created_at'=>date('Y-m-d H:i:s')
                        ];

            $ins_id = $this->Users_model->insert_user_data($ins_data);

            $channel_name = $username.' '.random_string('alnum',10);
            $channel_slug = slugify($channel_name);

            $ins_channel = [
                                'user_id'=>$ins_id,
                                'channel_name'=>$channel_name,
                                'channel_slug'=>$channel_slug,
                                'created_at'=>date('Y-m-d H:i:s')
                            ];
            $this->Cms_model->insert_record('user_channels',$ins_channel);

            $html_content = '<h1> Hello World </h1> <a href="'.base_url().'registration/verify_email/'.$random_no.'"> Click Here </a>';

            $email_config = mail_config();
            $this->email->initialize($email_config);
            $subject='Thank you for your registration';
            $this->email->from('test@mail.com')
                        ->to('vpa@narola.email,nik@narola.email,'.$email_id)
                        ->subject($subject)
                        ->message($html_content);
            $this->email->send();

            $this->session->set_flashdata('success','User has been inserted successfully.');
            redirect('registration/login');
        } 
    }

    public function forgot_password(){

        $this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|valid_email|callback_forgot_email_check',
                                         ['forgot_email_check'=>'OOPS !! Email does not exists.']);

        if($this->form_validation->run() == FALSE){
            $data['subview']='front/registration/forgot_pass';
            $this->load->view('front/layouts/layout_main',$data);
        }else{
            $email_id = $this->input->post('email_id');
            $res = $this->Users_model->get_data(['email_id'=>$email_id],true);
            $random_no = random_string('alnum',5);

            $this->Users_model->update_user_data($res['id'],['activation_code'=>$random_no]);

            $html_content = '<h1> Hello World </h1> <a href="'.base_url().'registration/verify_email/'.$random_no.'"> Click Here </a>';

            $email_config = mail_config();
            $this->email->initialize($email_config);
            $subject='Reset Password';
            $this->email->from('test@mail.com')
                        ->to('vpa@narola.email')
                        ->subject($subject)
                        ->message($html_content);
            $this->email->send();

            $this->session->set_flashdata('success','User has been inserted successfully.');
            redirect('registration/user');
            echo "Success";
        }
    }

    public function reset_password(){

    }

    public function verify_email($code){
        
        $res = $this->Users_model->get_data(['activation_code'=>$code],true);
        if(!empty($res)){
            $this->Users_model->update_user_data($res['id'],['is_verified'=>'1','activation_code'=>'']);
            redirect('registration/login');
        }else{
            $this->session->set_flashdata('error','Verification code is Invalid.');
            // redirect here
        }
    }

    /*=============================================================
    =            All CallBack functions for valication            =
    =============================================================*/

    public function username_check($username){
        $res = $this->Users_model->get_data(['username'=>$username]);
        if(count($res) == 0){
            return true;
        }else{
            return false;
        }
    }

    public function email_check($email){
        $res = $this->Users_model->get_data(['email_id'=>$email]);
        if(count($res) == 0){
            return true;
        }else{
            return false;
        }
    }

    public function forgot_email_check($email){
        $res = $this->Users_model->get_data(['email_id'=>$email]);
        if(count($res) == 0){
            return false;
        }else{
            return true;
        }   
    }

    public function password_match($pass){
        
        $email_id = $this->input->post('email_id');

        $res = $this->Users_model->get_data(['email_id'=>$email_id],true);

        if(!empty($res)) {

            $decode_pass = $this->encrypt->decode($res['password']);

            if($res['is_deleted'] == '1'){
                $this->form_validation->set_message('password_match', 'Your account has been deleted. Please contact admin.');
                return false;
            }
            if($res['is_blocked'] == '1'){
                $this->form_validation->set_message('password_match', 'Your account has been blocked. Please contact admin.');
                return false;
            }

            if($res['is_verified'] == '0'){
                $this->form_validation->set_message('password_match', 'Your account is not verified.Please verify your email. ');
                return false;
            }            

            if($pass != $decode_pass){
                $this->form_validation->set_message('password_match', 'Creadentials mis-matched. Please try it again.');
                return false;
            }

            return true;
        }else{
            $this->form_validation->set_message('password_match', 'Creadentials mis-matched. Please try it again.');
            return false;
        }        
    }

    /*=====  End of All CallBack functions for valication  ======*/
    
}
