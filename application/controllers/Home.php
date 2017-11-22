<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['Users_model']);
		$this->load->helper('paypal_helper');
	}

	public function index(){
		$data['subview']="front/home";
		$this->load->view('front/layouts/layout_main',$data);
	}
 	
 	public function post_detail(){
 		
 	}
 	
}
