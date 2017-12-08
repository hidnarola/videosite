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
        $data['sub_categories'] = $this->Post_model->get_sub_cat();
        $data['most_likes'] = $this->Post_model->get_most_liked_post(10,0);
        $data['most_views'] = $this->Post_model->get_most_viewed_post(10,0);
        $data['most_popular'] = $this->Post_model->get_most_popular_post(10,0);
        $data['most_recent_video'] = $this->Post_model->get_recently_posted_videos(2,0);
        $data['most_recent_blog'] = $this->Post_model->get_recently_posted_blogs(1,0);
        $data['most_recent_gallery'] = $this->Post_model->get_recently_posted_gallery(1,0);
        $data['subview'] = "front/home";
        $this->load->view('front/layouts/layout_main', $data);
    }

    public function post_detail($post_slug)
    {

        $sess_data = $this->session->userdata('client');
        $post_type = $this->uri->segment(1);
        $data['posts'] = $this->Post_model->get_all_posts_by_slug($post_slug);        
        $data['liked'] = $this->db->get_where('user_likes', ['post_id' => $data['posts']['id']])->num_rows();
        $res_post_data = $this->db->get_where('user_post', ['slug' => $post_slug, 'post_type' => $post_type])->row_array();
        $data['comments'] = $this->Post_model->get_comments_by_post($res_post_data['id'],5,0);
        $data['total_comments'] = $this->Post_model->get_comments_by_post_count($res_post_data['id']);
        $data['related_posts'] = $this->Post_model->get_related_posts_category_id($res_post_data['category_id'],$res_post_data['id'],4);
        $data['user_loggedin'] = false;
        $data['is_user_like'] = false;
        $data['is_user_bookmark'] = false;
        $data['new_var'] = 'Video';
        
        if($res_post_data['post_type'] == 'blog' || $res_post_data['post_type'] == 'gallery'){
            $this->db->order_by('order_no');
            if ($res_post_data['post_type'] == 'gallery')
            {
                $data['new_var'] = 'Gallerie';
                $data['gallery'] = $this->db->get_where('gallery', ['post_id' => $res_post_data['id']])->result_array();
                $data['count_gallery'] = count($data['gallery']);
            }

            if ($res_post_data['post_type'] == 'blog')
            {
                $data['new_var'] = 'Blog';
                $data['blog'] = $this->db->get_where('blog', ['post_id' => $res_post_data['id']])->result_array();
                $data['count_blog'] = count($data['blog']);
            }
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
            if ($res_post_data['post_type'] == 'video')
            {
                redirect('video/' . $res_post_data['slug']);
            }
            elseif ($res_post_data['post_type'] == 'blog')
            {
                redirect('blog/' . $res_post_data['slug']);
            }
            elseif ($res_post_data['post_type'] == 'gallery')
            {
                redirect('gallery/' . $res_post_data['slug']);
            }
        }

        // $this->load->view();
        // ------------------------------------------------------------------------
        // Increase the count of user post
        // ------------------------------------------------------------------------
        $this->increase_post_views($res_post_data['id']);

        $this->history_add($res_post_data);
    }
    
    public function ajax_load_comments($post_id)
    {

        $offset_comment = $this->input->post('offset_comment');        
        $total_comment_count = $this->db->get_where('comments',['post_id'=>$post_id])->num_rows();
        $data['comments'] = $this->Post_model->get_comments_by_post($post_id,5,$offset_comment);        

        if ($data['comments']) {
            $resp['all_html'] = $this->load->view('front/posts/ajax_commment_page',$data,true);
            $resp['offset_comment'] = $offset_comment + 5;
            $resp['status'] = 1;
        } else {
            $resp['all_html'] = '';
            $resp['status'] = 0;
        }
        echo json_encode($resp);
    
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

        if(empty($sess_data)){
            $ins_data = [
                'user_id' => 0,
                'ip_address' => $this->input->server('REMOTE_ADDR'),
                'post_id' => $post_id,
                'server_meta' => $server_json,
                'created_at' => date('Y-m-d')
            ];
        }
        else
        {
            $ins_data = [
                'user_id' => $sess_data['id'],
                'ip_address' => $this->input->server('REMOTE_ADDR'),
                'post_id' => $post_id,
                'server_meta' => $server_json,
                'created_at' => date('Y-m-d')
            ];
        }
        $total_per_day_cnt = $this->db->get_where('user_post_counts', ['ip_address' => $cur_ip, 'post_id' => $post_id, 'created_at' => date('Y-m-d')])
                ->num_rows();

        if ($total_per_day_cnt < 10)
        {
            $this->db->insert('user_post_counts', $ins_data);
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
                redirect('gallery/' . $post_data['slug']);
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
            redirect('gallery/' . $post_data['slug']);
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

    public function category_detail_page($cat_id,$sub_id = null) {

        $data['cat_id'] = $cat_id;
        $data['sub_id'] = $sub_id;

        $data['categories_name'] = $this->db->get_where('categories', ['id' => $cat_id,'is_deleted' =>'0', 'is_blocked' =>'0'])->row_array();
        $data['sub_categories_name'] = $this->db->get_where('sub_categories', ['id' => $sub_id,'is_deleted' =>'0', 'is_blocked' =>'0'])->row_array();
        
        if(is_null($sub_id)) {
            $data['posts'] = $this->Post_model->get_posts_from_category($cat_id,null,12);   
            $data['total_count_listing'] = $this->Post_model->get_posts_from_category_count($cat_id,null);
        } else {
            $data['posts'] = $this->Post_model->get_posts_from_category($cat_id,$sub_id,12);    
            $data['total_count_listing'] = $this->Post_model->get_posts_from_category_count($cat_id,$sub_id);
        }

        $data['subview'] = 'front/categories/index';
        $this->load->view('front/layouts/layout_main', $data);
    }

    public function ajax_category_listing_fetch(){
        $offset_listing = $this->input->post('offset_listing');
        $cat_id = $this->input->post('cat_id');
        $sub_id = $this->input->post('sub_id');
        
        if($sub_id == '') {        
            $data['posts'] = $this->Post_model->get_posts_from_category($cat_id,null,12,$offset_listing);
        }else{
            $data['posts'] = $this->Post_model->get_posts_from_category($cat_id,$sub_id,12,$offset_listing);
        }
        
        $res['html_str'] = $this->load->view('front/categories/ajax_listing',$data,true);
        $res['offset_listing'] = $offset_listing + 12;
        $res['success'] = true;
        echo json_encode($res);
    }

    public function new_test(){
        $this->load->view('front\dashboard\email_test');
    }
    
    
    public function display_cms($slug = null)
    {
        $data['slug'] = $this->Post_model->get_slug($slug);
        $data['html'] = $this->Post_model->get_content_by_slug($slug);
        $data['subview'] = "front/cms_pages";
        $this->load->view('front/layouts/layout_main', $data);
    }

    /* =====  End of Section For increase total count for user post block  ====== */
}
