<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_post extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Post_model']);
        
    }

    public function index()
    {
        $sess_data = $this->session->userdata('client');
        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
        $data['all_posts'] = $this->Post_model->get_all_posts_by_user_id($sess_data['id']);
        $data['subview'] = 'front/posts/index';
        $this->load->view('front/layouts/layout_main', $data);
    }

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
//                'img_path' => $this->saveuploadedfile(),
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

    public function add_gallery()
    {
        $sess_data = $this->session->userdata('client');
        $data['all_channels'] = $this->Post_model->get_result('user_channels', ['user_id' => $sess_data['id'], 'is_deleted' => '0', 'is_blocked' => '0']);
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $data['subview'] = 'front/posts/add_gallery';
            $this->load->view('front/layouts/layout_main', $data);
        }
        else
        {
            $title = $this->input->post('title');
            $post_slug = slugify($title);
            $ins_post = [
                'channel_id' => $this->input->post('channel'),
                'post_type' => 'gallery',
                'slug' => $post_slug,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $last_post_id = $this->Post_model->insert_record('user_post', $ins_post);

            $insert_array = [
                'post_id' => $last_post_id,
                'title' => $title,
                'description' => htmlspecialchars($this->input->post('description')),
//                'img_path' => $img_path,
                'created_at' => date("Y-m-d H:i:s a"),
            ];

            $result = $this->Post_model->insert_record('gallery', $insert_array);
            if ($result)
            {
                $msg = "<br>" . $success . " File Uploaded Successfully <br>" . $unsuccess . " File Not Upload";
                $this->session->set_flashdata('message', ['message' => 'Gallery successfully Inserted!' . $msg, 'class' => 'success']);
            }
            else
            {
                $this->session->set_flashdata('message', ['message' => 'Error Into Insert Gallery!', 'class' => 'danger']);
            }

            redirect('user_post');
        }
    }

    public function edit_gallery($gallery_id)
    {

        $sess_data = $this->session->userdata('client');
        $data['all_channels'] = $this->Post_model->get_result('user_channels', ['user_id' => $sess_data['id'], 'is_deleted' => '0', 'is_blocked' => '0']);

        $where = 'id = ' . $this->db->escape($blog_id);
        $data['record'] = $this->Post_model->get_result('gallery', $where, true);
        $this->form_validation->set_rules('title', ' Title', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $data['subview'] = 'front/posts/edit_gallery';
            $this->load->view('front/layouts/layout_main', $data);
        }
        else
        {

            $update_array = [
                'title' => $this->input->post('title'),
                'description' => htmlspecialchars($this->input->post('description')),
                    // 'img_path' => $img_path,
            ];

            $result = $this->Post_model->update_record('gallery', $where, $update_array);

            if ($result)
            {
                $this->session->set_flashdata('message', ['message' => 'Gallery successfully updated!' . $msg, 'class' => 'success']);
            }
            else
            {

                $this->session->set_flashdata('message', ['message' => 'Error Into Update Gallery!', 'class' => 'danger']);
            }
            redirect('user_post');
        }
    }

    public function add_video()
    {
        $sess_data = $this->session->userdata('client');
        $data['all_channels'] = $this->Post_model->get_result('user_channels', ['user_id' => $sess_data['id'], 'is_deleted' => '0', 'is_blocked' => '0']);
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $data['subview'] = 'front/posts/add_video';
            $this->load->view('front/layouts/layout_main', $data);
        }
        else
        {
            $video_title = $this->input->post('title');
            $post_slug = slugify($video_title);
            $ins_post = [
                'channel_id' => $this->input->post('channel'),
                'post_type' => 'blog',
                'slug' => $post_slug,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $last_post_id = $this->Post_model->insert_record('user_post', $ins_post);

            $insert_array = [
                'post_id' => $last_post_id,
                'title' => $video_title,
                'description' => htmlspecialchars($this->input->post('description')),
//                'img_path' => $img_path,
                'created_at' => date("Y-m-d H:i:s a"),
            ];

            $result = $this->Post_model->insert_record('video', $insert_array);
            if ($result)
            {
                $msg = "<br>" . $success . " File Uploaded Successfully <br>" . $unsuccess . " File Not Upload";
                $this->session->set_flashdata('message', ['message' => 'Video successfully Inserted!' . $msg, 'class' => 'success']);
            }
            else
            {
                $this->session->set_flashdata('message', ['message' => 'Error Into Insert Video!', 'class' => 'danger']);
            }

            redirect('user_post');
        }
    }

    public function edit_video($video_id)
    {

        $sess_data = $this->session->userdata('client');
        $data['all_channels'] = $this->Post_model->get_result('user_channels', ['user_id' => $sess_data['id'], 'is_deleted' => '0', 'is_blocked' => '0']);

        $where = 'id = ' . $this->db->escape($blog_id);
        $data['record'] = $this->Post_model->get_result('video', $where, true);


        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $data['subview'] = 'front/posts/edit_video';
            $this->load->view('front/layouts/layout_main', $data);
        }
        else
        {

            $update_array = [
                'title' => $this->input->post('title'),
                'description' => htmlspecialchars($this->input->post('description')),
                    // 'img_path' => $img_path,
            ];

            $result = $this->Post_model->update_record('video', $where, $update_array);

            if ($result)
            {
                $this->session->set_flashdata('message', ['message' => 'Video successfully updated!' . $msg, 'class' => 'success']);
            }
            else
            {

                $this->session->set_flashdata('message', ['message' => 'Error Into Update Video!', 'class' => 'danger']);
            }
            redirect('user_post');
        }
    }

   function ajax_call()
    {

        if (isset($_POST) && isset($_POST['category']))
        {
            $category = $_POST['category'];
            $arrSub = $this->Post_model->loadsubcategorycategories($category);
            $array_sub = [];
            foreach ($arrSub as $sub)
            {

                $array_sub[$sub->category_name] = $sub->category_name;
            }

            print form_dropdown('sub_category', $array_sub);
        }
        else
        {
            redirect('user_post/add_blog');
        }
    }

}

/* End of file User_post.php */
/* Location: ./application/controllers/User_post.php */