<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserPost extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Post_model', 'Blogs_model', 'admin/Admin_video_model', 'admin/Admin_gallery_model']);
        check_admin_login();
    }

    /**
     * Function load view of users list.(HPA)
     */
    public function index()
    {
        // $data['all_posts'] = $this->Post_model->get_all_posts($id);
        $data['res_gallery'] = $this->db->get_where('user_post',['post_type'=>'gallery','is_deleted'=>'0'])->num_rows();
        $data['res_video'] = $this->db->get_where('user_post',['post_type'=>'video','is_deleted'=>'0'])->num_rows();
        $data['res_blog'] = $this->db->get_where('user_post',['post_type'=>'blog','is_deleted'=>'0'])->num_rows();
        $data['subview'] = 'admin/userposts/index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    public function view_blog($blog_post_id = null)
    {
        $data['id'] = decode($blog_post_id);
        $data['subview'] = 'admin/userposts/blog_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in blog list page
     */
    public function list_blog($blog_post_id)
    {
        $final['recordsTotal'] = $this->Blogs_model->get_blogs_count($blog_post_id);
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Blogs_model->get_all_blogs($blog_post_id);
        echo json_encode($final);
    }

    public function view_video($video_post_id)
    {
        $data['id'] = decode($video_post_id);
        $data['subview'] = 'admin/userposts/video_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in blog list page
     */
    public function list_video($video_post_id)
    {
        $final['recordsTotal'] = $this->Admin_video_model->get_videos_count($video_post_id);
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Admin_video_model->get_all_videos($video_post_id);
        echo json_encode($final);
    }

    public function view_gallery($gallery_post_id)
    {
        $data['id'] = decode($gallery_post_id);
        $data['subview'] = 'admin/userposts/gallery_index';
        $this->load->view('admin/layouts/layout_main', $data);
    }

    /**
     * Function is used to get result based on datatable in blog list page
     */
    public function list_gallery($gallery_post_id)
    {
        $final['recordsTotal'] = $this->Admin_gallery_model->get_gallery_count($gallery_post_id);
        $final['redraw'] = 1;
        $final['recordsFiltered'] = $final['recordsTotal'];
        $final['data'] = $this->Admin_gallery_model->get_all_gallery($gallery_post_id);
        echo json_encode($final);
    }

}
