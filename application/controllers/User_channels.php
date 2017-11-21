<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_channels extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
	}

	public function index() {
		$sess_data = $this->session->userdata('client');
		$data['all_channels'] = $this->Cms_model->get_result('user_channels',['user_id'=>$sess_data['id'],'is_deleted'=>'0','is_blocked'=>'0']);
		$data['subview']='front/channels/index';
    	$this->load->view('front/layouts/layout_main',$data);
	}

	public function add(){
		
		$this->form_validation->set_rules('channel_name', 'Channel Name', 'required|callback_check_maximum_channel|callback_check_unique_channel',
											['check_maximum_channel'=>'Can not add more than 3 Channels.']);

        if($this->form_validation->run() == FALSE){
        	$data['subview']='front/channels/add_channel';
        	$this->load->view('front/layouts/layout_main',$data);
        }else{
        	$channel_name = $this->input->post('channel_name');
        	$channel_slug = slugify($channel_name);

        	$sess_data = $this->session->userdata('client');

        	$ins_channel = [
                                'user_id'=>$sess_data['id'],
                                'channel_name'=>$channel_name,
                                'channel_slug'=>$channel_slug,
                                'created_at'=>date('Y-m-d H:i:s')
                           ];
            $this->Cms_model->insert_record('user_channels',$ins_channel);
           	$this->session->set_flashdata('success','Channel successfully added.');
           	redirect('user_channels');
        }
	}

	public function edit($id){

		$this->form_validation->set_rules('channel_name', 'Channel Name', 'required|callback_check_maximum_channel',
											['check_maximum_channel'=>'Can not add more than 3 Channels.']);

        if($this->form_validation->run() == FALSE){
        	$data['subview']='front/channels/add_channel';
        	$this->load->view('front/layouts/layout_main',$data);
        }else{

        }
	}

	public function delete($id){
		$sess_data = $this->session->userdata('client');
		$res = $this->Cms_model->get_result('user_channels',['user_id'=>$sess_data['id'],'id'=>$id]);
		
		if(!empty($res)){
			$this->Cms_model->update_record('user_channels',['id'=>$id],['is_deleted'=>'1']);
			$this->session->set_flashdata('success','Channel successfully deleted.');
			redirect('user_channels');	
		}else{
			$this->session->set_flashdata('error','Not allowed to delete this channel.');
			redirect('user_channels');	
		}
	}


	/*=================================================================
	=            Form custom validation by call back block            =
	=================================================================*/
	
	public function check_maximum_channel($channel_name){
		$sess_data = $this->session->userdata('client');
		$res = $this->Cms_model->get_result('user_channels',['user_id'=>$sess_data['id'],'is_deleted'=>'0','is_blocked'=>'0']);		
		if(count($res) >= 1){
			return false;
		}else{
			return true;
		}
	}

	public function check_unique_channel($channel_name){
		$channel_slug = slugify($channel_name);
	}
	
	
	/*=====  End of Form custom validation by call back block  ======*/
	

}

/* End of file User_channels.php */
/* Location: ./application/controllers/User_channels.php */