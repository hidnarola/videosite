<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_post extends CI_Controller
{

    public function __construct()
    {
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

    public function add_post(){
        
        $sess_data = $this->session->userdata('client');

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

        $this->form_validation->set_rules('blog_title', 'Blog Title', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data['subview'] = 'front/posts/video_add_post';
            $this->load->view('front/layouts/layout_main', $data);
        } else {

        }
    }

    public function add_post_slide(){

    }

    // ------------------------------------------------------------------------ 

    public function add_blog()
    {
        $sess_data = $this->session->userdata('client');
        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
        $data['all_channels'] = $this->Post_model->get_result('user_channels', ['user_id' => $sess_data['id'], 'is_deleted' => '0', 'is_blocked' => '0']);
        $data['all_category'] = $this->Post_model->get_result('categories', ['is_deleted' => '0', 'is_blocked' => '0']);
        $data['all_sub_cat'] = $this->Post_model->get_result('sub_categories', ['is_deleted' => '0', 'is_blocked' => '0']);
        
        $this->form_validation->set_rules('blog_title', 'Blog Title', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $data['subview'] = 'front/posts/add_blog';
            $this->load->view('front/layouts/layout_main', $data);
        }
        else
        {
            $blog_title = $this->input->post('blog_title');
            $post_slug = slugify($blog_title);
            $ins_post = [
                'channel_id' => $this->input->post('channel'),
                'post_type' => 'blog',
                'slug' => $post_slug,
                'category_id' => $this->input->post('category'),
                'sub_category_id' => $this->input->post('sub_category'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $last_post_id = $this->Post_model->insert_record('user_post', $ins_post);

            $insert_array = [
                'post_id' => $last_post_id,
                'blog_title' => $blog_title,
                'blog_description' => htmlspecialchars($this->input->post('blog_description')),
                // img_path' => $this->saveuploadedfile(),
                'created_at' => date("Y-m-d H:i:s a"),
            ];
            $result = $this->Post_model->insert_record('blog', $insert_array);
            if ($result)
            {
                $msg = "<br>" . $success . " File Uploaded Successfully <br>" . $unsuccess . " File Not Upload";
                $this->session->set_flashdata('message', ['message' => 'Blog successfully Inserted!' . $msg, 'class' => 'success']);
            }
            else
            {
                $this->session->set_flashdata('message', ['message' => 'Error Into Insert Blog!', 'class' => 'danger']);
            }

            redirect('user_post');
        }
    }

    public function edit_blog($blog_id)
    {

        $sess_data = $this->session->userdata('client');
        $data['all_channels'] = $this->Post_model->get_result('user_channels', ['user_id' => $sess_data['id'], 'is_deleted' => '0', 'is_blocked' => '0']);

        $where = 'id = ' . $this->db->escape($blog_id);
        $data['record'] = $this->Post_model->get_result('blog', $where, true);
        $this->form_validation->set_rules('blog_title', 'Blog Title', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $data['subview'] = 'front/posts/edit_blog';
            $this->load->view('front/layouts/layout_main', $data);
        }
        else
        {
            $update_array = [
                'blog_title' => $this->input->post('blog_title'),
                'blog_description' => htmlspecialchars($this->input->post('blog_description')),
                    // 'img_path' => $img_path,
            ];

            $result = $this->Post_model->update_record('blog', $where, $update_array);

            if ($result)
            {
                $this->session->set_flashdata('message', ['message' => 'Blog successfully updated!' . $msg, 'class' => 'success']);
            }
            else
            {

                $this->session->set_flashdata('message', ['message' => 'Error Into Update Blog!', 'class' => 'danger']);
            }
            redirect('user_post');
        }
    }    

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