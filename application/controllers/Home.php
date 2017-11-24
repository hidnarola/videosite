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
        // $data['subview']="front/home";
        // $this->load->view('front/layouts/layout_main',$data);
        echo "Video site";
    }

    public function post_detail($post_slug)
    {

        $sess_data = $this->session->userdata('client');
        $post_type = $this->uri->segment(1);
        $data['posts'] = $this->Post_model->get_all_posts_by_slug($post_slug);
        $res_post_data = $this->db->get_where('user_post', ['slug' => $post_slug, 'post_type' => $post_type])->row_array();
        $data['user_loggedin'] = false;
        $data['is_user_like'] = false;

        pr($res_post_data);
        if (!empty($sess_data))
        {

            $data['user_loggedin'] = true;

            $user_post_data = $this->db->get_where('user_post', ['id' => $data['posts']['id'], 'is_deleted' => '0', 'is_blocked' => '0'])->row_array();

            $user_like_data = $this->db->get_where('user_likes', ['user_id' => $sess_data['id'], 'post_id' => $data['posts']['id']])
                    ->row_array();

            if (!empty($user_like_data))
            {
                $data['is_user_like'] = true;
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

    /* =====  End of Section For increase total count for user post block  ====== */
}
