<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_post extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model(['Post_model']);
    }    

    public function add_video_post(){
        
        $sess_data = $this->session->userdata('client');

        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
        $data['all_channels'] = $this->Post_model->get_result('user_channels', ['user_id' => $sess_data['id'], 'is_deleted' => '0', 'is_blocked' => '0']);
        
        $data['all_category'] = [];
        $data['all_sub_cat'] = [];
        $video_path = $this->input->post('video_path');

        if($_POST){
            $post_cat_id = $this->input->post('category');
            $data['all_category'] = $this->Post_model->get_result('categories', ['is_deleted' => '0', 'is_blocked' => '0']);
            $data['all_sub_cat'] = $this->Post_model->get_result('sub_categories', ['main_cat_id'=>$post_cat_id,'is_deleted' => '0', 'is_blocked' => '0']);
        }else{
            $data['all_category'] = $this->Post_model->get_result('categories', ['is_deleted' => '0', 'is_blocked' => '0']);            
        }

        $this->form_validation->set_rules('video_title', 'Video Title', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');        

        if ($this->form_validation->run() == FALSE){
            $data['subview'] = 'front/posts/video_add_post';
            $this->load->view('front/layouts/layout_main', $data);
        } else {

            // ------------------------------------------------------------------------
            $config['upload_path'] = './uploads/videos/';
            $config['allowed_types'] = '*';
            $config['max_size']  = '10000000000';       
            $config['encrypt_name'] = true;

            $this->load->library('upload', $config);
            
            if ( ! $this->upload->do_upload('vid_path')){
                
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('user_post/add_video_post');
            } else {
                $data = array('upload_data' => $this->upload->data());            

                $video_path = 'uploads/videos/'.$data['upload_data']['file_name'];

                $file_ext = $data['upload_data']['file_ext'];
                $random_name = random_string('alnum', 16);

                $file_name = $random_name.$file_ext;
                $img_file_name = $random_name.'.jpg';            

                exec(FFMPEG_PATH . ' -i ' . $data['upload_data']['full_path']. ' -vcodec libx264 -crf 20 '.$data['upload_data']['file_path'].$file_name);
                exec(FFMPEG_PATH . ' -i ' . $data['upload_data']['full_path'] . ' -ss 00:00:01.000 -vframes 1 ' . $data['upload_data']['file_path'].$img_file_name);

                unlink($data['upload_data']['full_path']);
            }
            // ------------------------------------------------------------------------

            $ins_data = [
                            'channel_id'=>$this->input->post('channel'),
                            'category_id'=>$this->input->post('category'),
                            'sub_category_id'=>$this->input->post('sub_category'),
                            'post_title'=>$this->input->post('video_title'),
                            'main_image'=>'uploads/videos/'.$img_file_name,
                            'slug'=>slugify($this->input->post('video_title')),
                            'created_at'=>date('Y-m-d H:i:s')
                        ];
            $last_id = $this->Post_model->insert_record('user_post',$ins_data);

            $video_data = [
                            'post_id'=>$last_id,
                            'title'=>$this->input->post('video_title'),
                            'description'=>$this->input->post('video_desc'),
                            'upload_path'=>'uploads/videos/'.$file_name,
                            'created_at'=>date('Y-m-d H:i:s')
                        ];
            $this->Post_model->insert_record('video',$video_data);
            $this->session->set_flashdata('success','Video has been uploaded successfully.');
            redirect('user_post/add_video_post');
        }
    }

    public function edit_video_post($post_id){
        
        $data['post_data'] = $this->db->get_where('user_post',['id'=>$post_id])->row_array();
        if(empty($data['post_data'])){ show_404(); }

        $data['post_data']['video'] = $this->db->get_where('video',['post_id'=>$post_id])->row_array();
        
        $sess_data = $this->session->userdata('client');

        // ------------------------------------------------------------------------
        $all_ids_arr = $this->db->select('id')->get_where('user_channels',['user_id'=>$sess_data['id']])->result_array();
        $all_channel_ids = array_column($all_ids_arr,'id');
        if(in_array($data['post_data']['channel_id'],$all_channel_ids) == false){ show_404(); }
        // ------------------------------------------------------------------------

        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
        $data['all_channels'] = $this->Post_model->get_result('user_channels', ['user_id' => $sess_data['id'], 'is_deleted' => '0', 'is_blocked' => '0']);
        
        $data['all_category'] = [];
        $data['all_sub_cat'] = [];
        $video_path = $this->input->post('video_path');

        if($_POST){
            $post_cat_id = $this->input->post('category');
            $data['all_category'] = $this->Post_model->get_result('categories', ['is_deleted' => '0', 'is_blocked' => '0']);
            $data['all_sub_cat'] = $this->Post_model->get_result('sub_categories', ['main_cat_id'=>$post_cat_id,'is_deleted' => '0', 'is_blocked' => '0']);
        }else{
            $data['all_category'] = $this->Post_model->get_result('categories', ['is_deleted' => '0', 'is_blocked' => '0']);
        }

        $this->form_validation->set_rules('video_title', 'Video Title', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');        

        if ($this->form_validation->run() == FALSE){
            $data['subview'] = 'front/posts/video_edit_post';
            $this->load->view('front/layouts/layout_main', $data);
        } else {

        }
    }

    // ------------------------------------------------------------------------

    public function add_post($post_type="blog"){
        
        if(empty($post_type)){ show_404(); }
        $sess_data = $this->session->userdata('client');

        if(in_array($post_type,['blog','gallery']) == false){ show_404(); }

        $data['post_type'] = $post_type;
        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
        $data['all_channels'] = $this->Post_model->get_result('user_channels', ['user_id' => $sess_data['id'], 'is_deleted' => '0', 'is_blocked' => '0']);
        
        $data['all_category'] = [];
        $data['all_sub_cat'] = [];

        if($_POST){
            $post_cat_id = $this->input->post('category');
            $data['all_category'] = $this->Post_model->get_result('categories', ['is_deleted' => '0', 'is_blocked' => '0']);
            $data['all_sub_cat'] = $this->Post_model->get_result('sub_categories', ['main_cat_id'=>$post_cat_id,'is_deleted' => '0', 'is_blocked' => '0']);
        }else{
            $data['all_category'] = $this->Post_model->get_result('categories', ['is_deleted' => '0', 'is_blocked' => '0']);            
        }

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data['subview'] = 'front/posts/add_post';
            $this->load->view('front/layouts/layout_main', $data);
        } else {

            // ------------------------------------------------------------------------
            
            if($post_type == 'blog'){ $folder_name = 'blogs'; }else { $folder_name = 'gallery'; }
            
            $config['upload_path'] = './uploads/'.$folder_name.'/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']  = '100000000';
            $config['encrypt_name'] = true;

            $this->load->library('upload', $config);
            
            if ( ! $this->upload->do_upload('img_path')){
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('user_post/add_post');
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_path = 'uploads/'.$folder_name.'/'.$data['upload_data']['file_name'];                
            }

            // ------------------------------------------------------------------------

            $ins_data = [
                            'channel_id'=>$this->input->post('channel'),
                            'category_id'=>$this->input->post('category'),
                            'sub_category_id'=>$this->input->post('sub_category'),
                            'post_title'=>$this->input->post('title'),
                            'main_image'=>$file_path,
                            'slug'=>slugify($this->input->post('title')),
                            'created_at'=>date('Y-m-d H:i:s')
                        ];
            $last_id = $this->Post_model->insert_record('user_post',$ins_data);
            $this->session->set_flashdata('success','User Post has been uploaded successfully.');
            redirect('user_post/add_post_slide/'.$last_id);
        }
    }

    public function view_all_slides($post_id){
        
        $sess_data = $this->session->userdata('client');
        $all_channels = $this->Post_model->get_result('user_channels', ['user_id' => $sess_data['id'], 'is_deleted' => '0', 'is_blocked' => '0']);
        $all_channel_id = array_column($all_channels,'id');

        $post_data = $this->db->get_where('user_post',['id'=>$post_id])->row_array();
        $data['post_type'] = $post_data['post_type'];
        // if(in_array($post_data['channel_id'],$all_channel_id) == false){
        //     die('Do not have access');
        // }

        if($post_data['post_type'] == 'blog'){
            $data['all_slides'] = $this->db->get_where('blog',['post_id'=>$post_id])->result_array();
        }else{
            $data['all_slides'] = $this->db->get_where('gallery',['post_id'=>$post_id])->result_array();
        }

        // pr($post_data);
        // pr($data['all_slides'],1);

        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
        $this->form_validation->set_rules('blog_title', 'Blog Title', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['subview'] = 'front/posts/view_all_slides';
            $this->load->view('front/layouts/layout_main', $data);
        }else{

        }
    }

    public function add_post_slide($post_id){

        $sess_data = $this->session->userdata('client');
        $all_channels = $this->Post_model->get_result('user_channels', ['user_id' => $sess_data['id'], 'is_deleted' => '0', 'is_blocked' => '0']);
        $all_channel_id = array_column($all_channels,'id');

        $post_data = $this->db->get_where('user_post',['id'=>$post_id])->row_array();

        if(in_array($post_data['channel_id'],$all_channel_id) == false){
            die('Do not have access');
        }

        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();        

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            
            $data['subview'] = 'front/posts/add_slide';
            $this->load->view('front/layouts/layout_main', $data);

        }else{

            // ------------------------------------------------------------------------
            
            if($post_data['post_type'] == 'blog'){ $folder_name = 'blogs'; }else { $folder_name = 'gallery'; }

            $config['upload_path'] = './uploads/'.$folder_name.'/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']  = '10000000';
            $config['encrypt_name'] = true;
            
            $this->load->library('upload', $config);
            
            if ( ! $this->upload->do_upload('img_path')){
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('user_post/add_post');
            }
            else{
                $data = array('upload_data' => $this->upload->data());
                $file_path = 'uploads/'.$folder_name.'/'.$data['upload_data']['file_name'];
            }
            
            // ------------------------------------------------------------------------

            if($post_data['post_type'] == 'blog'){
                
                $insert_array = [
                    'post_id' => $post_id,
                    'blog_title' => $blog_title,
                    'blog_description' => htmlspecialchars($this->input->post('description')),
                    'img_path' => $file_path,
                    'created_at' => date("Y-m-d H:i:s"),
                ];

                $this->Post_model->insert_record('blog',$insert_array);

            } else {
                $insert_array = [
                    'post_id' => $post_id,
                    'blog_title' => $blog_title,
                    'blog_description' => htmlspecialchars($this->input->post('description')),
                    'img_path' => $file_path,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                $this->Post_model->insert_record('gallery',$insert_array);
            }

        }
    }

    // ------------------------------------------------------------------------ 

    public function delete_user_post($post_id){
        $sess_data = $this->session->userdata('client');
        $all_ids_arr = $this->db->select('id')->get_where('user_channels',['user_id'=>$sess_data['id']])->result_array();
        $all_channel_ids = array_column($all_ids_arr,'id');

        $post_data = $this->db->get_where('user_post',['id'=>$post_id])->row_array();
        if(in_array($post_data['channel_id'],$all_channel_ids) == false){ show_404(); }

        $this->db->update('user_post',['is_deleted'=>'1'],['id'=>$post_id]);
        $this->session->set_flashdata('success','Post has been deleted successfully.');
        redirect('dashboard/view_my_posts');
    }

    // ------------------------------------------------------------------------

    public function ajax_call() {

        $category = $this->input->post('category');
        $all_sub = $this->db->get_where('sub_categories',['main_cat_id'=>$category])->result_array();                
        $new_str = '<option value="">Select Sub Category</option> ';

        if(!empty($all_sub)){
            $ret['success'] =true;
            foreach ($all_sub as $sub) {                
                $new_str .= '<option value="'.$sub['id'].'">';
                $new_str .= $sub['category_name'];
                $new_str .= '</option>';                
            }
        }
        $ret['all_sub_str'] = $new_str;

        echo json_encode($ret);
    }  

}

/* End of file User_post.php */
/* Location: ./application/controllers/User_post.php */