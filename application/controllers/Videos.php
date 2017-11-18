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
			$config['encrypt_name'] = true;

			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('media_file')){
				$error = array('error' => $this->upload->display_errors());
				pr($error);
			} else {
				$data = array('upload_data' => $this->upload->data());
				
				// libx264 -crf 20

				exec(FFMPEG_PATH . ' -i ' . $data['upload_data']['full_path']. ' -vcodec libx264 -crf 20 '.$data['upload_data']['file_path'].'vdfgdsdfds.avi');
				exec(FFMPEG_PATH . ' -i ' . $data['upload_data']['full_path'] . ' -ss 00:00:01.000 -vframes 1 ' . $data['upload_data']['file_path'].'newimg.jpg');
				
				// ffmpeg -i input.mp4 -vcodec libx264 -crf 20 output.mp4
				// ffmpeg -i input.mp4 -vcodec h264 -acodec mp2 output.mp4
				// exex(FFMPEG_PATH.' -i input.mp4 output.avi');
				// ffmpeg -i input.avi -b:v 64k -bufsize 64k output.avi
				pr($data);
				echo "success";
			}
		}
	}

}

/* End of file Videos.php */
/* Location: ./application/controllers/Videos.php */