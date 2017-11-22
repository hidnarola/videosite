<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserPost extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Post_model']);
        check_admin_login();
    }

    /**
     * Function load view of users list.(HPA)
     */
    public function index($id = null)
    {
        $data['id'] = $id;
//        $post_id = decode($id);
        $post_id = $id;
        $data['all_posts'] = $this->Post_model->get_all_posts_by_post_id($post_id);
        qry();
        pr($data['all_posts'], 1);
        $data['subview'] = 'admin/userposts/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    public function view_post($id = null)
    {
        $data['id'] = $id;
        $user_id = decode($id);
        $data['post'] = $this->Admin_users_model->get_user_by_id($user_id);
        $data['subview'] = 'admin/user/post_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    public function view_blog($id = null)
    {
        $data['id'] = decode($id);
        $data['subview'] = 'admin/users/blog_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in blog list page
     */
    public function list_blog($id = null)
    {
        $final['recordsTotal'] = $this->Admin_users_model->get_blogs_by_user_count($id);
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Admin_users_model->get_all_blogs_by_user($id);
        echo json_encode($final);
    }

    public function view_video($id = null)
    {
        $data['id'] = decode($id);
        $data['subview'] = 'admin/users/video_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in blog list page
     */
    public function list_video($id = null)
    {
        $final['recordsTotal'] = $this->Admin_video_model->get_video_by_user_count($id);
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Admin_video_model->get_all_video_by_user($id);
        echo json_encode($final);
    }

    public function view_gallery($id = null)
    {
        $data['id'] = decode($id);
        $data['subview'] = 'admin/users/gallery_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in blog list page
     */
    public function list_gallery($id = null)
    {
        $final['recordsTotal'] = $this->Admin_gallery_model->get_gallery_by_user_count($id);
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Admin_gallery_model->get_all_gallery_by_user($id);
        echo json_encode($final);
    }

}
