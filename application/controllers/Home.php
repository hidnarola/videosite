<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Users_model', 'Post_model']);
        $this->load->helper('paypal_helper');
    }

    public function index()
    {
        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
        $data['subview'] = "front/home";
        $this->load->view('front/layouts/layout_main', $data);
    }

    public function post_detail($post_slug)
    {

        $sess_data = $this->session->userdata('client');
        $post_type = $this->uri->segment(1);
        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
        $data['posts'] = $this->Post_model->get_all_posts_by_slug($post_slug);
        $res_post_data = $this->db->get_where('user_post', ['slug' => $post_slug, 'post_type' => $post_type])->row_array();
        $data['user_loggedin'] = false;
        $data['is_user_like'] = false;
        $data['is_user_bookmark'] = false;

        if ($res_post_data['post_type'] == 'gallery')
        {
            $data['gallery'] = $this->db->get_where('gallery', ['post_id' => $res_post_data['id']])->result_array();
        }

        if ($res_post_data['post_type'] == 'blog')
        {
            $data['blog'] = $this->db->get_where('blog', ['post_id' => $res_post_data['id']])->result_array();
            // pr($data['blog'],1);
        }
                

        if (!empty($sess_data))
        {

            $data['user_loggedin'] = true;

            $user_like_data = $this->db->get_where('user_likes', ['user_id' => $sess_data['id'], 'post_id' => $data['posts']['id']])
                    ->row_array();
            if (!empty($user_like_data))
            {
                $data['is_user_like'] = true;
            }
            $user_bookmark_data = $this->db->get_where('user_bookmarks', ['user_id' => $sess_data['id'], 'post_id' => $data['posts']['id']])
                    ->row_array();
            if (!empty($user_bookmark_data))
            {
                $data['is_user_bookmark'] = true;
            }
        }

        if (empty($res_post_data))
        {
            show_404();
        }

        $this->form_validation->set_rules('comments', 'Comment', 'required');

        if ($this->form_validation->run() == false)
        {
            $data['subview'] = 'front/posts/view_blog';
            $this->load->view('front/layouts/layout_main', $data);
        }
        else
        {
            $comment = $this->input->post('comments');
            $ins_comment = [
                'message' => $comment,
                'post_id' => $res_post_data['id'],
                'user_id' => $sess_data['id'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            $result = $this->Post_model->insert_record('comments', $ins_comment);
            if ($result)
            {
                $this->session->set_flashdata('message', ['message' => 'Comment successfully Inserted!', 'class' => 'success']);
            }
            else
            {
                $this->session->set_flashdata('message', ['message' => 'Error Into Insert Comment!', 'class' => 'danger']);
            }
        }

        // $this->load->view();
        // ------------------------------------------------------------------------
        // Increase the count of user post
        // ------------------------------------------------------------------------
        $this->increase_post_views($res_post_data['id']);

        $this->history_add($res_post_data);
    }

    /* ============================================================================
      =            Section For increase total count for user post block            =
      ============================================================================ */

    public function increase_post_views($post_id)
    {

        $server_json = json_encode($this->input->server(array('SERVER_PROTOCOL', 'REQUEST_URI',
                    'HTTP_USER_AGENT', 'HTTP_HOST',
                    'REMOTE_PORT', 'SERVER_PROTOCOL')));
        $cur_ip = $this->input->server('REMOTE_ADDR');
        $sess_data = $this->session->userdata('client');

        if (!empty($sess_data))
        {

            $ins_data = [
                'user_id' => $sess_data['id'],
                'ip_address' => $this->input->server('REMOTE_ADDR'),
                'post_id' => $post_id,
                'server_meta' => $server_json,
                'created_at' => date('Y-m-d')
            ];

            $total_per_day_cnt = $this->db->get_where('user_post_counts', ['ip_address' => $cur_ip, 'post_id' => $post_id, 'created_at' => date('Y-m-d')])
                    ->num_rows();

            if ($total_per_day_cnt < 10)
            {
                $this->db->insert('user_post_counts', $ins_data);
            }
        }
    }

    public function like_post($post_id)
    {

        $sess_data = $this->session->userdata('client');
        $post_data = $this->db->get_where('user_post', ['id' => $post_id, 'is_deleted' => '0', 'is_blocked' => '0'])->row_array();
        if (empty($post_data))
        {
            show_404();
        }

        $is_post_liked = $this->db->get_where('user_likes', ['user_id' => $sess_data['id'], 'post_id' => $post_id])->num_rows();

        if ($is_post_liked == 0)
        {

            $ins_data = [
                'user_id' => $sess_data['id'],
                'post_id' => $post_id
            ];
            $this->db->insert('user_likes', $ins_data);
            $this->session->set_flashdata('success', 'You have liked this post successfully.');
            if ($post_data['post_type'] == 'video')
            {
                redirect('video/' . $post_data['slug']);
            }
            elseif ($post_data['post_type'] == 'blog')
            {
                redirect('blog/' . $post_data['slug']);
            }
            elseif ($post_data['post_type'] == 'gallery')
            {
                redirect('gallery/' . $post_data['slug']);
            }
        }
    }

    public function unlike_post($post_id)
    {
        $post_data = $this->db->get_where('user_post', ['id' => $post_id, 'is_deleted' => '0', 'is_blocked' => '0'])->row_array();
        $sess_data = $this->session->userdata('client');
        $this->db->delete('user_likes', ['user_id' => $sess_data['id'], 'post_id' => $post_id]);
        if ($post_data['post_type'] == 'video')
        {
            redirect('video/' . $post_data['slug']);
        }
        elseif ($post_data['post_type'] == 'blog')
        {
            redirect('blog/' . $post_data['slug']);
        }
        elseif ($post_data['post_type'] == 'gallery')
        {
            redirect('gallery/' . $post_data['slug']);
        }
    }

    public function bookmark_post($post_id)
    {

        $sess_data = $this->session->userdata('client');
        $post_data = $this->db->get_where('user_post', ['id' => $post_id, 'is_deleted' => '0', 'is_blocked' => '0'])->row_array();
        if (empty($post_data))
        {
            show_404();
        }

        $is_post_bookmarked = $this->db->get_where('user_bookmarks', ['user_id' => $sess_data['id'], 'post_id' => $post_id])->num_rows();

        if ($is_post_bookmarked == 0)
        {

            $ins_data = [
                'user_id' => $sess_data['id'],
                'post_id' => $post_id
            ];
            $this->db->insert('user_bookmarks', $ins_data);
            $this->session->set_flashdata('success', 'You have Bookmarked this post successfully.');
            if ($post_data['post_type'] == 'video')
            {
                redirect('video/' . $post_data['slug']);
            }
            elseif ($post_data['post_type'] == 'blog')
            {
                redirect('blog/' . $post_data['slug']);
            }
            elseif ($post_data['post_type'] == 'gallery')
            {
                redirect('blog/' . $post_data['slug']);
            }
        }
    }

    public function unbookmark_post($post_id)
    {
        $post_data = $this->db->get_where('user_post', ['id' => $post_id, 'is_deleted' => '0', 'is_blocked' => '0'])->row_array();
        $sess_data = $this->session->userdata('client');
        $this->db->delete('user_bookmarks', ['user_id' => $sess_data['id'], 'post_id' => $post_id]);
        if ($post_data['post_type'] == 'video')
        {
            redirect('video/' . $post_data['slug']);
        }
        elseif ($post_data['post_type'] == 'blog')
        {
            redirect('blog/' . $post_data['slug']);
        }
        elseif ($post_data['post_type'] == 'gallery')
        {
            redirect('blog/' . $post_data['slug']);
        }
    }

    // ------------------------------------------------------------------------
    public function history_add($post_data)
    {

        $sess_data = $this->session->userdata('client');
        if (!empty($sess_data))
        {

            $post_data_arr = $this->db->get_where('user_history', ['user_id' => $sess_data['id'], 'post_id' => $post_data['id'], 'created_at' => date('Y-m-d')])
                    ->row_array();

            if (!empty($post_data_arr))
            {
                $this->db->delete('user_history', ['id' => $post_data_arr['id']]);
            }

            $ins_history = [
                'user_id' => $sess_data['id'],
                'post_id' => $post_data['id'],
                'created_at' => date('Y-m-d')
            ];
            $this->db->insert('user_history', $ins_history);
        }
    }

    public function category_detail_page($id)
    {
        // die('fghjk');
        $data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
//        $data['gallery'] = $this->db->get_where('gallery', ['post_id' => $res_post_data['id']])->result_array();
//        $data['blog'] = $this->db->get_where('blog', ['post_id' => $res_post_data['id']])->result_array();
        $data['posts'] = $this->Post_model->get_posts_category_id($id);
        $data['subview'] = 'front/categories/index';
        $this->load->view('front/layouts/layout_main', $data);
    }

    /* =====  End of Section For increase total count for user post block  ====== */
}
