<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quick_rfp extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->library('unirest');
	}
	
	public function register($treatment_cat_id) {
        
        $sess_data = $this->session->all_userdata();

        if(isset($sess_data['client'])){
            $client_role = $sess_data['client']['role_id'];
            if($client_role != '5'){
                show_404();
            }
        }

	    $treatment_cat_id = decode($treatment_cat_id);
        $treatment_cat_arr = explode('_',$treatment_cat_id);
        if(is_array($treatment_cat_arr) == FALSE){ show_404(); }

        $res = $this->db->get_where('treatment_category',['id'=>$treatment_cat_arr[0]])->row_array();
        if(empty($res)){ show_404(); }

        // $data['quick_treat_cat'] = $res;
        $data['rfp_def_val'] = 'Request for '.$res['title'];
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_validate_patientemail',
                                        ['validate_patientemail'=>'This email account cannot create requests, you need to use a patient account - please change your email address']);
		$this->form_validation->set_rules('fname', 'first name', 'required');
        $this->form_validation->set_rules('lname', 'last name', 'required');
        $this->form_validation->set_rules('birth_date', 'birth date', 'callback_validate_birthdate',
                                         ['validate_birthdate'=>'Date should be in MM-DD-YYYY Format.']);
        $this->form_validation->set_rules('zipcode', 'zipcode', 'required|callback_validate_zipcode',
                                         ['validate_zipcode'=>'Please, verify your ZIP Code.']);
        $this->form_validation->set_rules('title', 'Request Title', 'required');
        $this->form_validation->set_rules('distance_travel', 'Travel Distance', 'required');

        if($this->form_validation->run() === FALSE){

            if($res['is_blocked'] != '2'){ // If treatment category is not Quick request flag for is_blocked column
        	    $data['subview']="front/rfp/patient/redirect_view";
        		$this->load->view('front/layouts/layout_main',$data);
        	}else{
                $data['quick_without_login'] = TRUE;
        	    $data['subview']="front/rfp/patient/quick_rfp_form";
	            $this->load->view('front/layouts/layout_main',$data);
        	}

        } else {

            //-------- Fetch Longitude and Latitude based on zipcode ----
            $longitude='';
            $latitude='';
            $location_data = $this->validate_zipcode($this->input->post('zipcode'),1);
            if($location_data['status'] == 'OK'){
                $longitude = $location_data['results'][0]['geometry']['location']['lng'];
                $latitude= $location_data['results'][0]['geometry']['location']['lat'];
            }
            //--------------------------

            $a = explode('-',$this->input->post('birth_date'));
            $birth_date = $a[2].'-'.$a[0].'-'.$a[1];

            // ------------------------------------------------------------------------

            //-------------- For Multiple File Upload  ----------
            $all_extensions = [];
            $all_size = [];
            $all_file_names = [];

            $error_cnt = 0;
            $img_path='';

            if(isset($_FILES['img_path']['name']) && $_FILES['img_path']['name'][0] != NULL){
                $location='uploads/rfp/';
                foreach($_FILES['img_path']['name'] as $key=>$data){
                    if($data){
                        $res=$this->filestorage->FileArrayUpload($location,'img_path',$key);

                        $size = $_FILES['img_path']['size'][$key];
                        $ext = pathinfo($data, PATHINFO_EXTENSION);

                        array_push($all_extensions, $ext);
                        array_push($all_size, $size);
                        array_push($all_file_names, $res);

                        if($res != ''){
                            if($img_path == ''){
                                $img_path=$res;
                            }else{
                                $img_path=$img_path."|".$res;
                            }
                        }
                    }
                } // END of foreach Loop

                $total_size = byteFormat(array_sum($all_size),'MB');

                // v! Check if size is larger than 10 MB
                if($total_size > 10){
                    foreach($all_file_names as $fname){
                        $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/rfp/'.$fname;
                        if(file_exists($path)){
                            unlink($path);
                        }
                    }
                    $error_cnt++;
                } // END of If condition

                // v! check if file extension is correct
                $allowed_ext = ['jpg','jpeg','png','pdf'];
                $all_extensions = array_unique($all_extensions);

                foreach($all_extensions as $ext){
                    $ext = strtolower($ext);
                    if(in_array($ext,$allowed_ext) == false){
                        foreach($all_file_names as $fname){
                            $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/rfp/'.$fname;
                            if(file_exists($path)){
                                unlink($path);
                            }
                        }
                        $error_cnt++;
                    }
                } // END of Foreach Loop

                if($error_cnt != 0){
                    $this->session->set_flashdata('error', 'Error in file uploads. Please check total file size or file extensions.');
                    redirect('dashboard/quick_rfp_form');
                }
            }
            

            $rfp_data = array(
                    'rfp_mail'              => $this->input->post('email'),
                    'rfp_type'              => 'quick',
                    'fname'                 => $this->input->post('fname'),
                    'lname'                 => $this->input->post('lname'),
                    'birth_date'            => $birth_date,
                    'zipcode'               => $this->input->post('zipcode'),
                    'longitude'             => $longitude,
                    'latitude'              => $latitude,
                    'title'                 => $this->input->post('title'),
                    'dentition_type'        => $this->input->post('dentition_type'),
                    'distance_travel'       => $this->input->post('distance_travel'),
                    'patient_id'            => NULL,
                    'other_description'     => $this->input->post('other_description'),
                    'treatment_plan_total'  => $this->input->post('treatment_plan_total'),
                    'insurance_provider'    => $this->input->post('insurance_provider'),
                    'message'               => $this->input->post('message'),
                    'img_path'              => $img_path,
                    'created_at'            => date("Y-m-d H:i:s a")
                );

            $q_email = $this->input->post('email');

            $this->session->set_userdata('rfp_data', ['email_id'=>$q_email,'rfp_id'=>$last_id]);
                        
            $res_d = $this->db->get_where('users',['email_id'=>$q_email])->row_array();
            $this->session->unset_userdata('quick_email'); // Unset Session value for the quick email so it can't conflict with existing record
            
            $this->db->insert('rfp',$rfp_data);
            $last_id = $this->db->insert_id();

            
            
            if(!empty($res_d)){                
                $this->session->set_flashdata('success', 'Just one more step. Login to verify your Request information and submit.');
                redirect('login');
            }else{
                $this->session->set_flashdata('success', 'Just one step further. Please create your account and verify it.');
                $this->session->set_flashdata('quick_rfp_email', $q_email);
                redirect('registration/user');
            }
        }
	}

    // v! Custom Form validation
    public function validate_birthdate($str){
        $field_value = $str; //this is redundant, but it's to show you how
        if($field_value != ''){
            $arr_date = explode('-',$field_value);
            if(count($arr_date) == 3 && is_numeric($arr_date[0]) && is_numeric($arr_date[1]) && is_numeric($arr_date[2]) && checkdate($arr_date[0], $arr_date[1], $arr_date[2])){                
                return TRUE;
            }else{
                return FALSE;
            }
        }        
    }

    public function validate_zipcode($zipcode,$data=''){
        if($zipcode != ''){
            $str = 'https://maps.googleapis.com/maps/api/geocode/json?key='.GOOGLE_MAP_API.'&components=postal_code:'.$zipcode.'&sensor=false';
            $res = $this->unirest->get($str);
            $res_arr = json_decode($res->raw_body,true);

            // If $data is not null means return a longitude and latitude array ohter wise only status True/False
            if($data){
                return $res_arr;
            } else {
                if($res_arr['status'] != 'OK' && !empty($zipcode)){
                    return FALSE;
                }else if($res_arr['status'] == 'OK' && !empty($zipcode)) {
                    return TRUE;
                }
            }
        }
    } // End of function     

    public function validate_patientemail($email_str){
        $field_value = $email_str; //this is redundant, but it's to show you how
        if($field_value != ''){

            $res_d = $this->db->get_where('users',['email_id'=>$field_value])->row_array();

            if(empty($res_d)){
                return TRUE;
            }else{
                // If email exist and if it not belong to patient then it should return false
                if($res_d['role_id'] == '5'){
                    return true;
                }else{                    
                    return false;
                }
            }
        }
    }

}

/* End of file Quick_rfp.php */
/* Location: ./application/controllers/Quick_rfp.php */