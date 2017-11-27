<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Without_login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Users_model', 'Post_model']);
	}

	public function search(){
		echo $search_q = $this->input->get('q');
		$data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
		$data['posts'] = $this->Post_model->get_posts_category_id($id);
        $data['subview'] = 'front/without_login/search';
        $this->load->view('front/layouts/layout_main', $data);
	}

}

/* End of file Without_login.php */
/* Location: ./application/controllers/Without_login.php */