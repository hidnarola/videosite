<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
	}

	public function index() {
		
	}

	public function upload_video(){

		$path = $_SERVER['DOCUMENT_ROOT'].'/s3bucket/';
		
		$this->load->view('front/videos/upload_video');
		
		if($_POST){


			$config['upload_path'] = $path;
			$config['allowed_types'] = '*';
			$config['max_size']  = '100000000';			
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('media_file')){
				$error = array('error' => $this->upload->display_errors());
				pr($error);
			}
			else{
				$data = array('upload_data' => $this->upload->data());
				pr($data);
				echo "success";
			}
		}
	}

}

/* End of file Videos.php */
/* Location: ./application/controllers/Videos.php */