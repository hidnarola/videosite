<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Without_login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Users_model', 'Post_model','Other_model']);
	}

	public function search(){
		
		$search_q = $this->input->get('q');
		$data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();

		$data['posts'] = $this->Other_model->search_query_count($search_q);

		// ------------------------------------------------------------------------
		$config['base_url'] = base_url().'search?q='.$search_q;
        $config['total_rows'] = $this->Other_model->search_query_count($search_q);
        $config['per_page'] = 30;
        $offset = $this->input->get('per_page');
        $config = array_merge($config,pagination_front_config());
        
        $this->pagination->initialize($config);
		// ------------------------------------------------------------------------

        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );

		$data['posts'] = $this->Other_model->search_query($search_q,$config['per_page'],$offset);
		
        $data['subview'] = 'front/without_login/search';
        $this->load->view('front/layouts/layout_main', $data);
	}

}

/* End of file Without_login.php */
/* Location: ./application/controllers/Without_login.php */