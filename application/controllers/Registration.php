<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Users_model'));

        if(!empty(is_client_loggedin())){
            redirect('home');
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

    public function ajax_login(){
        $this->form_validation->set_rules('email_id', 'Email', 'required|valid_email');        
        $this->form_validation->set_rules('password', 'Password', 'required|callback_password_match'); 
        
        if($this->form_validation->run() == FALSE){
            $res['email_error'] = strip_tags(form_error('email_id'));
            $res['password_error'] = strip_tags(form_error('password'));
            $res['success'] = false;
        }else{
            $email_id = $this->input->post('email_id');
            $user_data = $this->Users_model->get_data(['email_id'=>$email_id],true);

            $this->session->set_userdata(['client' => $user_data]); // Start Loggedin User Session
            $this->session->set_flashdata('success','Login Successfull');
            $this->Users_model->update_user_data($user_data['id'], ['last_login' => date('Y-m-d H:i:s')]); // update last login time            
            $res['success'] = true;            
        }
        echo json_encode($res);
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
            $res['all_erros'] = validation_errors();
            $res['success'] = false;
        }else{
            
            $username = $this->input->post('username');
            $email_id = $this->input->post('email_id');
            $password = $this->input->post('password');
            $encrypt_pass = $this->encrypt->encode($password);
            $birth_date = $this->input->post('birth_date');
            $random_no = random_string('alnum',5);

            $ins_data = [
                            'role_id'=>'3', // Here 3 means Normal User
                            'email_id'=>$email_id,
                            'username'=>$username,
                            'password'=>$encrypt_pass,
                            'birth_date' => $birth_date,
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
            
//           $data['my_link'] = base_url().'registration/verify_email/'.$random_no;
//           $html_content = $this->load->view('front/dashboard/email_test',$data,true);
//
//            $email_config = mail_config();
//            $this->email->initialize($email_config);
//            $subject=config('site_name'). ' - Thank you for your registration';
//            $this->email->from(config('contact_email'), config('sender_name'))
//                        ->to('vpa@narola.email,nik@narola.email,'.$email_id)
//                        ->subject($subject)
//                        ->message($html_content);
//            $this->email->send();
            
            $email_data = [];
            $email_data['url'] = base_url() . 'registration/verify_email/' . $random_no;
            $email_data['email'] = trim($email_id);
            $email_data['password'] = trim($this->encrypt->decode($encrypt_pass));
            $email_data['subject'] = 'Verify Email | An Amazing Site';
            send_mail(trim($email_id), 'verify_email', $email_data);

            $res['success'] = true; // Set final variable whether it is true or not
        } 
        echo json_encode($res);
    }   

    public function ajax_forgot_password(){
        $this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|valid_email|callback_forgot_email_check',
                                         ['forgot_email_check'=>'OOPS !! Email does not exists.']);
       $res = [];
        if($this->form_validation->run() == FALSE){   
            $res['email_error'] = strip_tags(form_error('email_id')); 
            $res['all_erros'] = validation_errors();
            $res['success'] = false;

        }else{

            $user_data=$this->Users_model->check_if_user_exist(['email_id' => $this->input->post('email_id')], false, true,['1','2','3']);
            if($user_data){

                $random_no=random_string('alnum',5);
                $email_id = $this->input->post('email_id');
                $this->db->set('activation_code', $random_no);
                $this->db->where('id',$user_data['id']);
                $this->db->update('users');

//                $data['my_link'] = base_url().'registration/reset_password/'.$random_no;
//                $html_content = $this->load->view('front/dashboard/email_test',$data,true);

                // $html_content = '<h1> Hello World </h1> <a href="'.base_url().'registration/reset_password/'.$random_no.'"> Click Here </a>';
                
//                $email_config = mail_config();
//                $this->email->initialize($email_config);
//                $subject= config('site_name').' - Forgot Password Request';    
//                $this->email->from(config('contact_email'), config('sender_name'))
//                            ->to($this->input->post('email_id'),'nik@narola.email')
//                            ->subject($subject)
//                            ->message($html_content);
//                $this->email->send();
//                 $this->session->set_flashdata('message', ['message' => 'Forgot password request sent successfully, You will receive the confirmation mail', 'class' => 'alert alert-success']);
                
            $email_data = [];
            $email_data['url'] = base_url() . 'registration/reset_password/' . $random_no;
            $email_data['email'] = trim($email_id);
            $email_data['subject'] = 'Reset Password | An Amazing Site';
            send_mail(trim($email_id), 'forgot_password', $email_data);
            }
        $res['success'] = true;
        }
        echo json_encode($res);
    }

    public function reset_password($rand_no){
        $this->session->unset_userdata('client');
        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
        $res = $this->Users_model->get_data(['activation_code'=>$rand_no],true);        

        if(empty($res)) { 
            $this->session->set_flashdata('error', 'Password Reset link is either invalid or expired.');
            redirect('home');
         }
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|matches[password]');

        if($this->form_validation->run() == FALSE){
             $data['subview']='front/registration/reset_password';            
             $this->load->view('front/layouts/layout_main',$data);
        }else{
            $password = $this->input->post('password');
            $encode_password = $this->encrypt->encode($password);
            $this->Users_model->update_user_data($res['id'],['password'=>$encode_password,'is_verified'=>'1','activation_code'=>'']);
            $this->session->set_flashdata('success', 'Password has been set successfully . Try email and password to login.');
            redirect('home');
        }
    }
    
    public function verify_email($code){
        
        $res = $this->Users_model->get_data(['activation_code'=>$code],true);
        if(!empty($res)){
            $this->session->set_flashdata('success','Your Email Has been verified. You can now Login to the site.'); 
            $this->Users_model->update_user_data($res['id'],['is_verified'=>'1','activation_code'=>'']);
            redirect('home');
        }else{
            $this->session->set_flashdata('error','Verification code is Invalid.');            
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

    /*================================================================
    =            Section Jquery Form validation functions            =
    ================================================================*/    
    
    
    /*=====  End of Section Jquery Form validation functions  ======*/
    
    
}
