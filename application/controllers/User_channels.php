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
											[
												'check_maximum_channel'=>'Can not add more than 3 Channels.',
												'check_unique_channel'=>'Channel name must be unique.'
											]);

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

	public function edit($channel_id){

		$this->form_validation->set_rules('channel_name', 'Channel Name', 'required|callback_check_unique_channel_edit['.$channel_id.']',
										 ['check_unique_channel_edit'=>'Channel name must be unique.']);

		$data['channel_data'] = $this->Cms_model->get_result('user_channels',['id'=>$channel_id],true);

        if($this->form_validation->run() == FALSE){
    		$data['subview']='front/channels/edit_channel';
        	$this->load->view('front/layouts/layout_main',$data);
		} else {
			
			$channel_name = $this->input->post('channel_name');
        	$channel_slug = slugify($channel_name);

        	$sess_data = $this->session->userdata('client');

        	$upd_arr = [
                            'channel_name'=>$channel_name,
                            'channel_slug'=>$channel_slug
                        ];
            $this->Cms_model->update_record('user_channels',['id'=>$channel_id],$upd_arr);
           	$this->session->set_flashdata('success','Channel successfully updated.');
           	redirect('user_channels');
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

	// ------------------------------------------------------------------------

	public function channel_detail($channel_name){
		
		$data['res_channel'] = $this->db->get_where('user_channels',['channel_slug'=>$channel_name])->row_array();
		if(empty($data['res_channel'])){ show_404(); }

		$sess_data = $this->session->userdata('client');
		$data['user_loggedin'] = false;
		$data['is_user_subscribe'] = false;
		$data['is_this_users_channel'] = false;
		$data['total_subscriber'] = $this->db->get_where('user_subscribers',['channel_id'=>$data['res_channel']['id']])->num_rows();

		// pr($data['total_subscriber'],1);

		if(!empty($sess_data)){
			
			$data['user_loggedin'] = true;
			
			$all_userchannel = $this->db->select('id')->get_where('user_channels',
															['user_id'=>$sess_data['id'],'is_deleted'=>'0','is_blocked'=>'0'])
												  ->result_array();

			// put validation check - if logged in user try to subscribe own channel 
			if(!empty($all_userchannel)){
				$all_ids = array_column($all_userchannel,'id');
				if(in_array($data['res_channel']['id'],$all_ids)){
					$data['is_this_users_channel'] = true;
				}
			}

			$user_subscribe_data =  $this->db->get_where('user_subscribers',['user_id'=>$sess_data['id'],'channel_id'=>$data['res_channel']['id']])
											 ->row_array();
			
			if(!empty($user_subscribe_data)){
				$data['is_user_subscribe'] = true;
			}
		}

		// pr($data['is_user_subscribe'],1);
		// pr($data['is_this_users_channel'],1);

		$this->load->view('front/channels/channel_details',$data);
	}

	public function subscribe_channel($channel_id){
		
		$sess_u_data = $this->session->userdata('client');
		// fetch channel data
		$channel_data = $this->db->get_where('user_channels',['id'=>$channel_id,'is_deleted'=>'0','is_blocked'=>'0'])->row_array();
		
		if(empty($channel_data)){ show_404(); }

		// fetch all channel of loggedin user
		$all_userchannel = $this->db->select('id')->get_where('user_channels',
															['user_id'=>$sess_u_data['id'],'is_deleted'=>'0','is_blocked'=>'0'])
												  ->result_array();

		// put validation check - if logged in user try to subscribe own channel 
		if(!empty($all_userchannel)){
			$all_ids = array_column($all_userchannel,'id');
			if(in_array($channel_id,$all_ids)){
				echo 'Can not subscribe'; 
				redirect('channel/'.$channel_data['channel_slug']);
			}
		}

		$total_subscribers = $this->db->get_where('user_subscribers',['user_id'=>$sess_u_data['id'],'channel_id'=>$channel_id])
									  ->num_rows();

		if($total_subscribers == 0){
			$ins_data = [
							'user_id'=>$sess_u_data['id'],
							'channel_id'=>$channel_id
						];
			$this->db->insert('user_subscribers',$ins_data);
			$this->session->set_flashdata('success','You have subscribed this user successfully.');
			redirect('channel/'.$channel_data['channel_slug']);
		}
	}

	public function unsubscribe_channel($channel_id){
		$channel_data = $this->db->get_where('user_channels',['id'=>$channel_id,'is_deleted'=>'0','is_blocked'=>'0'])->row_array();
		$sess_u_data = $this->session->userdata('client');
		$this->db->delete('user_subscribers',['user_id'=>$sess_u_data['id'],'channel_id'=>$channel_id]);
		// $this->session->set_flashdata('error','');
		// redirect('dashboard');
		redirect('channel/'.$channel_data['channel_slug']);
	}

	// ------------------------------------------------------------------------



	/*=================================================================
	=            Form custom validation by call back block            =
	=================================================================*/
	
	public function check_maximum_channel($channel_name){
		$sess_data = $this->session->userdata('client');
		$res = $this->Cms_model->get_result('user_channels',['user_id'=>$sess_data['id'],'is_deleted'=>'0','is_blocked'=>'0']);
		if(count($res) == 3){
			return false;
		}else{
			return true;
		}
	}

	public function check_unique_channel($channel_name){

		$channel_slug = slugify($channel_name);
		$res = $this->Cms_model->get_result('user_channels',['channel_slug'=>$channel_slug,'is_deleted'=>'0','is_blocked'=>'0']);
		if(!empty($res)){
			return false;
		} else {
			return true;
		}
	}
	
	public function check_unique_channel_edit($channel_name,$channel_id){
		$channel_data = $this->Cms_model->get_result('user_channels',['id'=>$channel_id],true);
		
		if($channel_data['channel_name'] != $channel_name){
			$channel_slug = slugify($channel_name);
			$res = $this->Cms_model->get_result('user_channels',['channel_slug'=>$channel_slug,'is_deleted'=>'0','is_blocked'=>'0']);
			if(!empty($res)){
				return false;
			} else {
				return true;
			}	
		}else{
			return true;
		}
	}

	/*=====  End of Form custom validation by call back block  ======*/

}

/* End of file User_channels.php */
/* Location: ./application/controllers/User_channels.php */